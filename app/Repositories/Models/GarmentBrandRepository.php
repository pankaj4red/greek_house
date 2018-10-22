<?php

namespace App\Repositories\Models;

use App\Models\GarmentBrand;
use Illuminate\Support\Collection;

/**
 * @method GarmentBrand make()
 * @method Collection|GarmentBrand[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method GarmentBrand|null find($id)
 * @method GarmentBrand create(array $parameters = [])
 */
class GarmentBrandRepository extends ModelRepository
{
    protected $modelClassName = GarmentBrand::class;

    protected $rules = [
        'name' => 'required|max:255',
    ];

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Collection|GarmentBrand[]
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->model->newQuery();
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
}
