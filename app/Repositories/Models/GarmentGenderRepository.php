<?php

namespace App\Repositories\Models;

use App\Models\GarmentGender;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method GarmentGender make()
 * @method Collection|GarmentGender[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method GarmentGender|null find($id)
 * @method GarmentGender create(array $parameters = [])
 */
class GarmentGenderRepository extends ModelRepository
{
    protected $modelClassName = GarmentGender::class;

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Collection|GarmentGender[]
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->model->newQuery();
        /** @var Builder $query */
        if (isset($filters['not_unisex']) && $filters['not_unisex']) {
            $query = $query->where('name', '<>', 'unisex');
        }
        $this->queryOrderBy($query, $orderBy);

        return $this->queryPaginate($query, $page, $pageSize);
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

    public function findByCode($code)
    {
        return $this->model->newQuery()->where('code', $code)->first();
    }
}
