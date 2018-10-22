<?php

namespace App\Repositories\Models;

use App\Models\SupplierEmbellishment;
use Illuminate\Support\Collection;

/**
 * @method SupplierEmbellishment make()
 * @method Collection|SupplierEmbellishment[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method SupplierEmbellishment|null find($id)
 * @method SupplierEmbellishment create(array $parameters = [])
 */
class SupplierEmbellishmentRepository extends ModelRepository
{
    protected $modelClassName = SupplierEmbellishment::class;
}
