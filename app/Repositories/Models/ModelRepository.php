<?php

namespace App\Repositories\Models;

use App\Models\Model;
use Illuminate\Container\Container;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Validator;

abstract class ModelRepository
{
    /** @var string|null $modelClassName */
    protected $modelClassName = null;

    /** @var Model $model */
    protected $model;

    protected $rules = [];

    public function __construct(Container $app)
    {
        $this->model = $app->make($this->getModelClassName());
    }

    /**
     * @return string
     */
    public function getModelClassName()
    {
        return $this->modelClassName;
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes = [])
    {
        $instance = $this->model->newInstance($attributes);
        $instance->save();

        return $instance;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function make()
    {
        return $this->model->newInstance();
    }

    /**
     * @param array      $columns
     * @param array|null $with
     * @param array|null $orderBy
     * @return Model[]
     */
    public function all($columns = ['*'], $with = null, $orderBy = null)
    {
        $query = $this->model->newQuery();
        if ($with) {
            if (is_array($with)) {
                foreach ($with as $withEntry) {
                    $query->with($withEntry);
                }
            } else {
                $query->with($with);
            }
        }
        $this->queryOrderBy($query, $orderBy);

        return $query->get($columns);
    }

    /**
     * @param            $id
     * @return Model|null
     */
    public function find($id)
    {
        $query = $this->model->newQuery();

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $query->find($id);
    }

    /**
     * @param            $id
     * @return Model|null
     */
    public function findWithTrashed($id)
    {
        $query = $this->model->newQuery();

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        /** @noinspection PhpUndefinedMethodInspection */
        return $query->withTrashed()->find($id);
    }

    /**
     * @param array|int $ids
     * @return void
     */
    public function delete($ids)
    {
        if (is_numeric($ids)) {
            $ids = [$ids];
        }
        foreach ($ids as $id) {
            $instance = $this->find($id);
            if ($instance) {
                $instance->delete();
            }
        }
    }

    /**
     * @param mixed      $data
     * @param array|null $rules
     * @param array      $messages
     * @return Validator
     */
    public function validate($data, $rules = null, $messages = [])
    {
        if ($rules == null) {
            $rules = $this->getRules();
        } else {
            $rules = $this->getRules($rules);
        }

        return \Validator::make($data instanceof Request ? $data->all() : $data, $rules, $messages);
    }

    /**
     * @param array|null $filter
     * @return array
     */
    public function getRules($filter = null)
    {
        /** @noinspection PhpUndefinedFieldInspection */
        $rules = $this->rules;
        if ($filter != null) {
            $rules = array_intersect_key($rules, array_flip($filter));
        }

        return $rules;
    }

    /**
     * @param Builder $query
     * @param         $orderBy
     * @return Builder
     */
    protected function queryOrderBy($query, $orderBy)
    {
        if ($orderBy) {
            if (is_array($orderBy)) {
                if (is_array($orderBy[0])) {
                    $query->orderBy($orderBy[0][0], $orderBy[0][1]);
                }
                if (is_array($orderBy[1])) {
                    $query->orderBy($orderBy[1][0], $orderBy[1][1]);
                }
                if (! is_array($orderBy[0]) && ! is_array($orderBy[1])) {
                    $query->orderBy($orderBy[0], $orderBy[1]);
                }
            } else {
                $query->orderBy($orderBy, 'desc');
            }
        } else {
            $query->orderBy('updated_at', 'desc');
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param         $page
     * @param         $pageSize
     * @return Collection|LengthAwarePaginator
     */
    protected function queryPaginate($query, $page, $pageSize)
    {
        if ($page !== null && $pageSize !== null) {
            $results = $query->skip($page * $pageSize)->take($pageSize)->get();
        } else {
            $results = $query->paginate($pageSize === null ? 20 : $pageSize);
        }

        return $results;
    }

    /**
     * @return Builder
     */
    public function newQuery()
    {
        return $this->model->newQuery();
    }

    public function first()
    {
        return $this->model->newQuery()->first();
    }

    /**
     * @return Builder
     */
    public function count()
    {
        return $this->model->newQuery()->count();
    }

    public function findInPosition($position)
    {
        return $this->model->newQuery()->skip($position)->first();
    }
}
