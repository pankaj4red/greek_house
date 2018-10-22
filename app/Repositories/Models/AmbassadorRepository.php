<?php

namespace App\Repositories\Models;

use App\Models\Ambassador;
use Illuminate\Support\Collection;

/**
 * @method Ambassador make()
 * @method Collection|Ambassador[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Ambassador|null find($id)
 * @method Ambassador create(array $parameters = [])
 */
class AmbassadorRepository extends ModelRepository
{
    protected $modelClassName = Ambassador::class;

    protected $rules = [];
}
