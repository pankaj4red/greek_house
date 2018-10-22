<?php

namespace App\Repositories\Models;

use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Validator;

/**
 * @method Store make()
 * @method Collection|Store[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Store|null find($id)
 * @method Store create(array $parameters = [])
 */
class StoreRepository extends ModelRepository {
    protected $modelClassName = Store::class;

    protected $rules = [
        'name' => 'required|max:255',
        'link' => 'required|max:255',
    ];
    protected $extraRules = [];

    /**
     * @param mixed      $data
     * @param array|null $rules
     * @param int|null   $id
     * @return Validator
     */
    public function validate($data, $rules = null, $id = null) {
        $messages = [];
        $data = $data instanceof Request ? $data->all() : $data;
        $this->extraRules = [];
        $result = parent::validate($data, $rules, $messages);

        return $result;
    }

    /**
     * @param array|null $filter
     * @return array
     */
    public function getRules($filter = null) {
        return $this->extraRules + parent::getRules($filter);
    }

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Collection|Store[]
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null) {
        $query = $this->model->newQuery();

        if (isset($filters['filter_id']) && $filters['filter_id']) {
            $query = $query->where('id', $filters['filter_id']);
        }
        if (isset($filters['filter_name']) && $filters['filter_name']) {
            $query = $query->where('name', 'like', '%' . $filters['filter_name'] . '%');
        }
        if (isset($filters['filter_link']) && $filters['filter_link']) {
            $query = $query->where('link', 'like', '%' . $filters['filter_link'] . '%');
        }
        if (isset($filters['filter_updated_from']) && $filters['filter_updated_from']) {
            $query = $query->where('stores.updated_at', '>=', date('Y-m-d', strtotime($filters['filter_updated_from'])));
        }
        if (isset($filters['filter_updated_to']) && $filters['filter_updated_to']) {
            $query = $query->where('stores.updated_at', '<=', date('Y-m-d', strtotime($filters['filter_updated_to'])));
        }
        $this->queryOrderBy($query, $orderBy);

        return $this->queryPaginate($query, $page, $pageSize);
    }

}
