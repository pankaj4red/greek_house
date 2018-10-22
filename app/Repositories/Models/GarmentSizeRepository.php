<?php

namespace App\Repositories\Models;

use App\Models\GarmentSize;
use Illuminate\Support\Collection;

/**
 * @method GarmentSize make()
 * @method Collection|GarmentSize[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method GarmentSize|null find($id)
 * @method GarmentSize create(array $parameters = [])
 */
class GarmentSizeRepository extends ModelRepository
{
    protected $modelClassName = GarmentSize::class;

    /**
     * @param string $short
     * @return GarmentSize|null
     */
    public function findByShort($short)
    {
        return $this->model->where('short', $short)->first();
    }

    public function options($productId = null, $nullOption = [])
    {
        //TODO
        if ($productId === null) {
            $products = product_options();
            $productId = collect($products)->keys()->first();
        }
        $sizes = product_size_repository()->getByProductId($productId);
        $sizeOptions = $nullOption;
        foreach ($sizes as $size) {
            $sizeOptions[$size->size->id] = $size->size->name;
        }

        return $sizeOptions;
    }
}
