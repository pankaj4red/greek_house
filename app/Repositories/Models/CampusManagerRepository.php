<?php

namespace App\Repositories\Models;

use App\Models\CampusManager;
use Illuminate\Support\Collection;

/**
 * @method CampusManager make()
 * @method Collection|CampusManager[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method CampusManager|null find($id)
 * @method CampusManager create(array $parameters = [])
 */
class CampusManagerRepository extends ModelRepository
{
    protected $modelClassName = CampusManager::class;

    protected $rules = [];
}
