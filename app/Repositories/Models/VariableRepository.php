<?php

namespace App\Repositories\Models;

use App\Models\Variable;
use Illuminate\Support\Collection;

/**
 * @method Variable make()
 * @method Collection|Variable[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Variable|null find($id)
 * @method Variable create(array $parameters = [])
 */
class VariableRepository extends ModelRepository
{
    protected $modelClassName = Variable::class;
}
