<?php

namespace App\Repositories\Models;

use App\Models\ProductColor;
use Illuminate\Support\Collection;

/**
 * @method ProductColor make()
 * @method Collection|ProductColor[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method ProductColor|null find($id)
 * @method ProductColor create(array $parameters = [])
 */
class ProductColorRepository extends ModelRepository
{
    protected $modelClassName = ProductColor::class;

    protected $rules = [
        'name'   => 'required|max:255',
        'active' => 'required|in:yes,no',
    ];

    /**
     * @param integer      $productId
     * @param integer|null $excludeId
     * @return ProductColor[]|Collection
     */
    public function getByProductId($productId, $excludeId = null)
    {
        $query = $this->model->newQuery()->where('product_id', $productId);
        if ($excludeId) {
            $query->where('id', '<>', $excludeId);
        }

        return $query->get();
    }

    /**
     * @param integer $productId
     * @param string  $colorName
     * @return ProductColor
     */
    public function findByProductIdAndColorName($productId, $colorName)
    {
        return $this->model->newQuery()->where('product_id', $productId)->where('name', $colorName)->first();
    }

    /**
     * @param string $styleNumber
     * @param string $colorName
     * @return ProductColor
     */
    public function findByProductStyleNumberAndColorName($styleNumber, $colorName)
    {
        return $this->model->newQuery()->whereHas('product', function ($query) use ($styleNumber) {
            $query->where('style_number', $styleNumber);
        })->where('name', $colorName)->first();
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
        $entries = $this->getByProductId($productId);
        foreach ($entries as $entry) {
            $options[$entry->id] = $entry->name;
        }

        return $options;
    }

    public function getRandom()
    {
        $count = $this->count();

        return $this->model->newQuery()->take(1)->skip(rand(0, $count - 1))->first();
    }
}
