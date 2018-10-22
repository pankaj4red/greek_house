<?php

namespace App\Repositories\Models;

use App\Models\OrderEntry;
use Illuminate\Support\Collection;

/**
 * @method OrderEntry make()
 * @method Collection|OrderEntry[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method OrderEntry|null find($id)
 * @method OrderEntry create(array $parameters = [])
 */
class OrderEntryRepository extends ModelRepository
{
    protected $modelClassName = OrderEntry::class;
}
