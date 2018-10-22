<?php

namespace App\Repositories\Models;

use App\Models\DesignFile;
use Illuminate\Support\Collection;

/**
 * @method DesignFile make()
 * @method Collection|DesignFile[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method DesignFile|null find($id)
 * @method DesignFile create(array $parameters = [])
 */
class DesignFileRepository extends ModelRepository
{
    protected $modelClassName = DesignFile::class;

    protected $rules = [];
}
