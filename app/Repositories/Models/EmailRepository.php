<?php

namespace App\Repositories\Models;

use App\Models\Email;
use Illuminate\Support\Collection;

/**
 * @method Email make()
 * @method Collection|Email[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Email|null find($id)
 * @method Email create(array $parameters = [])
 */
class EmailRepository extends ModelRepository
{
    protected $modelClassName = Email::class;
}
