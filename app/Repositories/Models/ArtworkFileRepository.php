<?php

namespace App\Repositories\Models;

use App\Models\ArtworkFile;
use Illuminate\Support\Collection;

/**
 * @method ArtworkFile make()
 * @method Collection|ArtworkFile[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method ArtworkFile|null find($id)
 * @method ArtworkFile create(array $parameters = [])
 */
class ArtworkFileRepository extends ModelRepository
{
    protected $modelClassName = ArtworkFile::class;

    protected $rules = [];
}
