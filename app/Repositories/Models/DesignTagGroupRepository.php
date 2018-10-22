<?php

namespace App\Repositories\Models;

use App\Models\DesignTagGroup;
use Illuminate\Support\Collection;

/**
 * @method DesignTagGroup make()
 * @method Collection|DesignTagGroup[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method DesignTagGroup|null find($id)
 * @method DesignTagGroup create(array $parameters = [])
 */
class DesignTagGroupRepository extends ModelRepository
{
    protected $modelClassName = DesignTagGroup::class;

    protected $rules = [];

    public function findByCode($code)
    {
        return $this->model->newQuery()->where('code', $code)->first();
    }
}
