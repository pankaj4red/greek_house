<?php

namespace App\Repositories\Models;

use App\Models\File;
use Illuminate\Support\Collection;

/**
 * @method File make()
 * @method Collection|File[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method File|null find($id)
 * @method File create(array $parameters = [])
 */
class FileRepository extends ModelRepository
{
    protected $modelClassName = File::class;
}
