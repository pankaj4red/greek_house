<?php

namespace App\Repositories\Models;

use App\Models\ProductSize;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method ProductSize make()
 * @method Collection|ProductSize[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method ProductSize|null find($id)
 * @method ProductSize create(array $parameters = [])
 */
class ProductSizeRepository extends ModelRepository
{
    protected $modelClassName = ProductSize::class;

    /**
     * @param $productId
     * @return Collection|ProductSize[]
     */
    public function getByProductId($productId)
    {
        return $this->model->where('product_id', $productId)->with('size')->orderBy('garment_size_id')->get();
    }

    /**
     * @param integer $productId
     * @param string  $short
     * @return ProductSize|null
     */
    public function findByProductIdAndShort($productId, $short)
    {
        return $this->model->newQuery()->with('size')->whereHas('size', function ($query) use ($short) {
            /** @var Builder $query */
            $query->where('short', $short);
        })->where('product_id', $productId)->first();
    }

    /**
     * @param integer $productId
     * @param array   $nullOption
     * @return array
     */
    public function options($productId, $nullOption = [])
    {
        if ($productId === null) {
            $products = product_options();
            $productId = collect($products)->keys()->first();
        }
        $options = $nullOption;
        $entries = product_size_repository()->getByProductId($productId);
        foreach ($entries as $entry) {
            $options[$entry->id] = $entry->size->name;
        }

        return $options;
    }
}
