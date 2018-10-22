<?php

namespace App\Repositories\Models;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method Chapter make()
 * @method Collection|Chapter[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Chapter|null find($id)
 * @method Chapter create(array $parameters = [])
 */
class ChapterRepository extends ModelRepository
{
    protected $modelClassName = Chapter::class;

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Collection|Chapter[]
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->model->newQuery()->with('school');
        /** @var Builder $query */
        if (isset($filters['filter_school']) && $filters['filter_school']) {
            $query = $query->whereHas('school', function ($query) use ($filters) {
                /** @var Builder $query */
                $query->where('name', 'like', '%'.$filters['filter_school'].'%');
            });
        }
        if (isset($filters['filter_chapter']) && $filters['filter_chapter']) {
            $query = $query->where('name', 'like', '%'.$filters['filter_chapter'].'%');
        }
        $this->queryOrderBy($query, $orderBy);

        return $this->queryPaginate($query, $page, $pageSize);
    }

    /**
     * @param string $school
     * @param string $chapter
     * @return Chapter|null
     */
    public function findBySchoolAndChapter($school, $chapter)
    {
        $schools = school_repository()->autoComplete($school);
        if (! (count($schools) > 0 && $schools[0]->score == $schools[0]->words)) {
            return null;
        }
        $chapterObject = $this->model->newQuery()->where('school_id', $schools[0]->id)->where('name', $chapter)->first();
        /** @var Chapter $chapterObject */
        if (! $chapterObject) {
            return null;
        }

        return $chapterObject;
    }

    public function findBySfId($sfId)
    {
        return $this->model->newQuery()->where('sf_id', $sfId)->first();
    }
}
