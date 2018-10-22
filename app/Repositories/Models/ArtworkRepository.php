<?php

namespace App\Repositories\Models;

use App\Models\Artwork;
use Illuminate\Support\Collection;

/**
 * @method Artwork make()
 * @method Collection|Artwork[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Artwork|null find($id)
 * @method Artwork create(array $parameters = [])
 */
class ArtworkRepository extends ModelRepository
{
    protected $modelClassName = Artwork::class;

    protected $rules = [];
}
