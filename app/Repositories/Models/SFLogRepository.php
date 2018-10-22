<?php

namespace App\Repositories\Models;

use App\Models\SFLog;
use Illuminate\Support\Collection;

/**
 * @method SFLog make()
 * @method Collection|SFLog[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method SFLog|null find($id)
 * @method SFLog create(array $parameters = [])
 */
class SFLogRepository extends ModelRepository
{
    protected $modelClassName = SFLog::class;
}
