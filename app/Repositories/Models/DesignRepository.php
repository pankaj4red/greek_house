<?php

namespace App\Repositories\Models;

use App\Models\Campaign;
use App\Models\Design;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method Design make()
 * @method Collection|Design[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Design|null find($id)
 * @method Design create(array $parameters = [])
 */
class DesignRepository extends ModelRepository
{
    protected $modelClassName = Design::class;

    protected $rules = [
        'name' => 'required|max:255',
    ];

    private function getListingQuery($filters = null, $includeInEnabled = false)
    {
        $query = $this->model->newQuery()->with('files', 'thumbnail');
        if (! $includeInEnabled) {
            $query->whereHas('enabled_images');
        }
        if (isset($filters['name']) && $filters['name']) {
            $query = $query->where('designs.name', 'like', '%'.$filters['name'].'%');
        }
        if (isset($filters['trending']) && $filters['trending']) {
            $query = $query->where('designs.trending', $filters['trending']);
        }
        if (isset($filters['campaign_name']) && $filters['campaign_name']) {
            $query = $query->whereHas('campaign', function ($query2) use ($filters) {
                /** @var Builder $query2 */
                $query2->where('campaigns.name', 'like', '%'.$filters['campaign_name'].'%');
            });
        }

        return $query;
    }

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Paginator
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->getListingQuery($filters, false);
        $this->queryOrderBy($query, $orderBy);

        return $this->queryPaginate($query, $page, $pageSize);
    }

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Paginator
     */
    public function getListingAll($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->getListingQuery($filters, true);
        $this->queryOrderBy($query, $orderBy);

        return $this->queryPaginate($query, $page, $pageSize);
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @return \Illuminate\Database\Eloquent\Collection|Collection|static[]
     */
    public function getRecent($page, $pageSize)
    {
        return $this->model->newQuery()->whereHas('enabled_images')->where('status', 'enabled')->orderBy('id', 'desc')->skip($pageSize * $page)->take($pageSize)->get();
    }

    public function getRelatedDesignId($imageId)
    {
        return $this->model->newQuery()->with('files', 'thumbnail')->where('thumbnail_id', $imageId)->get();
    }

    /**
     * @param string[] $tags
     * @return \Illuminate\Database\Eloquent\Collection|Collection|static[]
     */
    public function getSearch(array $tags = [])
    {
        $tags = array_filter($tags);

        $designsQuery = $this->model->newQuery()->where(function ($query) {
            /** @var \Illuminate\Database\Query\Builder $query */
            $query->orWhere('status', 'enabled');
            $query->orWhere('status', 'search');
        })->orderBy('id', 'desc');

        //Check if search has just one number
        if (count($tags) == 1 && (string) (int) $tags[0] == $tags[0]) {
            $designsQuery->where(function ($query) use ($tags) {
                /** @var \Illuminate\Database\Query\Builder $query */
                $query->where('id', $tags[0])->orWhere('campaign_id', $tags[0]);
            });
        } else {
            $designsQuery->whereHas('tags', function ($query) use ($tags) {
                /** @var Builder $query */
                for ($i = 0; $i < count($tags); $i++) {
                    if ($i == 0) {
                        $query->where('name', 'like', '%'.$tags[$i].'%');
                    } else {
                        $query->orWhere('name', 'like', '%'.$tags[$i].'%');
                    }
                }
            });
        }
        $designsQuery->whereHas('enabled_images');
        $designsRaw = $designsQuery->get();

        $designMeta = [];
        foreach ($designsRaw as $designRaw) {
            $designMeta[] = (object) ['model' => $designRaw, 'score' => $designRaw->getTagScore($tags)];
        }

        $designs = collect($designMeta)->sort(function ($a, $b) {
            return $b->score - $a->score;
        });
        $designsFinal = [];
        foreach ($designs as $design) {
            $designsFinal[] = $design->model;
        }

        return collect($designsFinal);
    }

    public function getRelated(Design $design)
    {
        $usedIds = [$design->id];

        $themeEventTags = [];
        foreach ($design->getTags('themes') as $tag) {
            $themeEventTags[] = $tag->name;
        }
        foreach ($design->getTags('event') as $tag) {
            $themeEventTags[] = $tag->name;
        }

        /** @var Collection $trending */
        $trending = $this->getSubTrendingWithTags(Carbon::parse('2016-01-01'), $themeEventTags);
        foreach ($trending as $key => $trendingDesign) {
            if (in_array($trendingDesign->id, $usedIds)) {
                $trending->forget($key);
                break;
            }
        }

        if ($trending->count() < 8) {
            foreach ($trending as $trendingDesign) {
                $usedIds[] = $trendingDesign->id;
            }

            $remainingTags = [];
            foreach (design_tag_group_repository()->all() as $group) {
                if (! in_array($group->code, ['themes', 'event'])) {
                    foreach ($design->getTags($group->code) as $tag) {
                        $remainingTags[] = $tag->name;
                    }
                }
            }

            $trending2 = $this->getSubTrendingWithTags(Carbon::parse('2016-01-01'), $remainingTags);
            foreach ($trending2 as $key => $trendingDesign) {
                if (in_array($trendingDesign->id, $usedIds)) {
                    $trending2->forget($key);
                }
            }
            $trending = $trending->merge($trending2);
        }

        if ($trending->count() < 8) {
            foreach ($trending as $trendingDesign) {
                $usedIds[] = $trendingDesign->id;
            }

            $recent = $this->getRecent(0, 16);
            foreach ($recent as $key => $recentDesign) {
                if (in_array($recentDesign->id, $usedIds)) {
                    $recent->forget($key);
                }
            }
            $trending = $trending->merge($recent);
        }

        return collect($trending->chunk(8)->first());
    }

    /**
     * @param string $period
     * @return Collection|Design[]
     */
    public function getTrending($period = 'all')
    {
        $from = Carbon::create(2016, 1, 1);
        if (in_array($period, ['month', 'week'])) {
            $from = Carbon::parse('-1 '.$period);
        }

        $trending = $this->model->newQuery()->whereHas('enabled_images')->where('status', 'enabled')->orderBy('trending', 'desc')->orderBy('sort', 'asc')->orderBy('id', 'asc')->where('created_at', '>=', $from->format('Y-m-d'))->skip(0)->take(16)->get();
        if ($trending->count() < 16) {
            $ids = [];
            foreach ($trending as $design) {
                $ids[] = $design->id;
            }
            $extra = $this->model->newQuery()->with('tags', 'files')->whereHas('enabled_images')->whereNotIn('id', $ids)->orderBy('trending', 'desc')->orderBy('sort', 'asc')->where('status', 'enabled')->orderBy('id', 'desc')->take(16 - $trending->count())->get();
            $trending = $trending->merge($extra);
        }

        return $trending;
    }

    private function getSubTrendingWithTags(Carbon $from, array $tags)
    {
        $designsRaw = $this->model->newQuery()->whereHas('enabled_images')->where('status', 'enabled')->where('created_at', '>=', $from->format('Y-m-d'))->whereHas('tags', function ($query) use ($tags) {
            /** @var Builder $query */
            for ($i = 0; $i < count($tags); $i++) {
                if ($i == 0) {
                    $query->where('name', 'like', '%'.$tags[$i].'%');
                } else {
                    $query->orWhere('name', 'like', '%'.$tags[$i].'%');
                }
            }
        })->get();

        $designMeta = [];
        foreach ($designsRaw as $designRaw) {
            $designMeta[] = (object) ['model' => $designRaw, 'score' => $designRaw->getTagScore($tags)];
        }

        $designs = collect($designMeta)->sort(function ($a, $b) {
            return $b->score - $a->score;
        });
        $designsFinal = [];
        foreach ($designs as $design) {
            $designsFinal[] = $design->model;
        }

        return collect($designsFinal)->take(16);
    }

    public function paginate($pageSize)
    {
        return $this->model->paginate($pageSize);
    }

    /**
     * @param Campaign $campaign
     * @return Design
     */
    public function createFromCampaign($campaign)
    {
        $design = static::create([
            'campaign_id' => $campaign->id,
            'name'        => $campaign->name,
            'code'        => $campaign->id,
            'status'      => 'new',
        ]);

        if ($campaign->contact_school) {
            design_tag_repository()->createTagOnGroup($design->id, 'college', $campaign->contact_school);
        }
        if ($campaign->contact_chapter) {
            design_tag_repository()->createTagOnGroup($design->id, 'chapter', $campaign->contact_chapter);
        }
        if ($campaign->product_colors->first()) {
            design_tag_repository()->createTagOnGroup($design->id, 'product_type', $campaign->product_colors->first()->product->category->name);
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->model->find($design->id);
    }

    /**
     * @param integer $campaignId
     * @return Design|null
     */
    public function findByCampaignId($campaignId)
    {
        return $this->model->newQuery()->where('campaign_id', $campaignId)->first();
    }

    /**
     * @param int|null $exceptId
     * @return int
     */
    public function maxSort($exceptId = null)
    {
        /** @var Design $result */
        $result = $this->model->newQuery()->where('trending', true)->orderBy('sort', 'desc')->first();

        return $result ? $result->sort + 1 : 1;
    }
}
