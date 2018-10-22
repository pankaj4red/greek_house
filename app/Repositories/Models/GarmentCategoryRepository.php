<?php

namespace App\Repositories\Models;

use App\Models\GarmentCategory;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;

/**
 * @method GarmentCategory make()
 * @method Collection|GarmentCategory[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method GarmentCategory|null find($id)
 */
class GarmentCategoryRepository extends ModelRepository
{
    protected $modelClassName = GarmentCategory::class;

    protected $rules = [
        'name'   => 'required|max:255',
        'active' => 'boolean',
        'sort'   => 'integer',
        'wizard' => 'required|in:show,default,hide',
    ];

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Collection|GarmentCategory[]
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->model->newQuery()->with('image');
        if ($orderBy) {
            $this->queryOrderBy($query, $orderBy);
        } else {
            $query->orderBy('sort', 'asc')->orderBy('updated_at', 'desc');
        }

        return $this->queryPaginate($query, $page, $pageSize);
    }

    /**
     * @param integer $genderId
     * @return Collection|GarmentCategory[]
     */
    public function getByGenderId($genderId)
    {
        return $this->model->whereExists(function (Builder $query) use ($genderId) {
            $query->select(\DB::raw(1))->from('products')->join('garment_genders', function (JoinClause $join) use ($genderId) {
                $join->on('products.garment_gender_id', '=', 'garment_genders.id');
                $join->whereIn('garment_genders.id', [\DB::raw(1), $genderId]);
            })->join('product_colors', function (JoinClause $join) use ($genderId) {
                $join->on('products.id', '=', 'product_colors.product_id');
                $join->where('product_colors.active', '=', true);
            })->whereRaw('products.garment_category_id = garment_categories.id')->where('garment_categories.id', '<>', 10000)->where('products.active', 1);
        })->where('garment_categories.active', true)->orderBy('garment_categories.sort', 'asc')->get();
    }

    public function options($nullOption = [])
    {
        $options = $nullOption;
        $entries = $this->model->newQuery()->orderBy('name', 'asc')->get();
        foreach ($entries as $entry) {
            $options[$entry->id] = $entry->name;
        }

        return $options;
    }

    public function additionalOptions($nullOption = [])
    {
        $options = $nullOption;
        $entries = $this->model->newQuery()->where('allow_additional', true)->orderBy('name', 'asc')->get();
        foreach ($entries as $entry) {
            $options[$entry->id] = $entry->name;
        }

        return $options;
    }

    public function allActive()
    {
        return $this->model->newQuery()->whereNotNull('image_id')->orderBy('sort', 'asc')->orderBy('name', 'asc')->where('wizard', '<>', 'hide')->get();
    }

    public function firstActive()
    {
        return $this->model->newQuery()->whereNotNull('image_id')->orderBy('sort', 'asc')->orderBy('name', 'asc')->first();
    }

    public function firstWizardDefault()
    {
        return $this->model->newQuery()->whereNotNull('image_id')->where('wizard', 'default')->where('name', '<>', 'No Category')->orderBy('sort', 'asc')->orderBy('name', 'asc')->first();
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes = [])
    {
        $first = $this->model->newQuery()->orderBy('sort', 'desc')->first();
        if ($first) {
            $attributes['sort'] = $first->sort + 1;
        }
        $instance = $this->model->newInstance($attributes);
        $instance->save();

        return $instance;
    }
}
