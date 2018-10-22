<?php

namespace App\Repositories\Models;

use App\Models\ArtworkRequest;
use Illuminate\Support\Collection;

/**
 * @method ArtworkRequest make()
 * @method Collection|ArtworkRequest[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method ArtworkRequest|null find($id)
 * @method ArtworkRequest create(array $parameters = [])
 */
class ArtworkRequestRepository extends ModelRepository
{
    protected $modelClassName = ArtworkRequest::class;

    protected $rules = [];
}
