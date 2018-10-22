<?php

namespace App\Repositories\Models;

use App\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * @method Supplier make()
 * @method Collection|Supplier[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Supplier|null find($id)
 * @method Supplier create(array $parameters = [])
 */
class SupplierRepository extends ModelRepository
{
    protected $modelClassName = Supplier::class;

    protected $rules = [
        'name' => 'required|max:255',
    ];

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Supplier[]|LengthAwarePaginator
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->model->newQuery();
        $this->queryOrderBy($query, $orderBy);

        return $this->queryPaginate($query, $page, $pageSize);
    }

    public function findByName($name)
    {
        return $this->model->newQuery()->where('name', $name)->first();
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
