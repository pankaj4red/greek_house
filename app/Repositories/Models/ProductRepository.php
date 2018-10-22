<?php

namespace App\Repositories\Models;

use App\Models\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * @method Product make()
 * @method Collection|Product[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Product|null find($id)
 * @method Product create(array $parameters = [])
 */
class ProductRepository extends ModelRepository
{
    protected $modelClassName = Product::class;

    protected $rules = [
        'name'                => 'required|max:255',
        'style_number'        => 'required|max:255',
        'garment_brand_id'    => 'required|integer',
        'garment_category_id' => 'required|integer',
        'garment_gender_id'   => 'required|integer',
        'price'               => 'required|numeric',
        'description'         => 'required|max:1024',
        'sizes_text'          => 'required|max:255',
        'features'            => 'required|max:255',
        'active'              => 'required|in:yes,no',
    ];

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Collection|Product[]
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->model->newQuery()->with('category', 'gender', 'brand');
        if (isset($filters['filter_product_id']) && $filters['filter_product_id']) {
            $query = $query->where('id', $filters['filter_product_id']);
        }
        if (isset($filters['filter_product_name']) && $filters['filter_product_name']) {
            $query = $query->where('name', 'like', '%'.$filters['filter_product_name'].'%');
        }
        if (isset($filters['filter_product_sku']) && $filters['filter_product_sku']) {
            $query = $query->where('style_number', $filters['filter_product_sku']);
        }
        if (isset($filters['filter_product_brand']) && $filters['filter_product_brand']) {
            $query = $query->where('garment_brand_id', $filters['filter_product_brand']);
        }
        if (isset($filters['filter_product_category']) && $filters['filter_product_category']) {
            $query = $query->where('garment_category_id', $filters['filter_product_category']);
        }
        if (isset($filters['filter_product_gender']) && $filters['filter_product_gender']) {
            $query = $query->where('garment_gender_id', $filters['filter_product_gender']);
        }
        if (isset($filters['filter_product_active']) && $filters['filter_product_active']) {
            $query = $query->where('active', $filters['filter_product_active'] == 'on' ? true : false);
        }
        $this->queryOrderBy($query, $orderBy);

        return $this->queryPaginate($query, $page, $pageSize);
    }

    /**
     * @param $genderId
     * @param $categoryId
     * @return Collection|Product[]
     */
    public function getByGenderIdAndCategoryId($genderId, $categoryId)
    {
        $query = $this->model->newQuery();

        if ($genderId) {
            $query->whereRaw('(garment_gender_id = ? or garment_gender_id = 1)', [$genderId]);
        }
        if ($categoryId) {
            $query->where('garment_category_id', $categoryId);
        }

        return $query->whereExists(function (Builder $query) {
            $query->select(\DB::raw(1))->from('product_colors')->whereRaw('products.id = product_colors.product_id')->where('product_colors.active', '=', true);
        })->where('active', 1)->orderBy('products.name', 'asc')->get();
    }

    public function getByGenderIdAndCategoryIdAndAll($genderId, $categoryId)
    {
        $query = $this->model->newQuery();

        if ($genderId) {
            $query->whereRaw('(garment_gender_id = ? or garment_gender_id = 1)', [$genderId]);
        }
        $generalResults = $query->whereExists(function (Builder $query) {
            $query->select(\DB::raw(1))->from('product_colors')->whereRaw('products.id = product_colors.product_id')->where('product_colors.active', '=', true);
        })->where('active', 1)->orderBy('products.name', 'asc')->get();
        if ($categoryId) {
            $query->where('garment_category_id', $categoryId);
        }

        $resultsByCategory = $query->whereExists(function (Builder $query) {
            $query->select(\DB::raw(1))->from('product_colors')->whereRaw('products.id = product_colors.product_id')->where('product_colors.active', '=', true);
        })->where('active', 1)->orderBy('products.name', 'asc')->get();

        return $resultsByCategory->merge($generalResults);
    }

    /**
     * @param $genderCode
     * @param $categoryId
     * @return Collection|Product[]
     */
    public function getByGenderCodeAndCategoryId($genderCode = 'unisex', $categoryId)
    {
        $query = $this->model->newQuery();
        if ($genderCode) {
            $query->whereHas('gender', function ($query2) use ($genderCode) {
                /** @var Builder $query2 */
                $query2->where('code = ?)', [$genderCode]);
            });
        }
        if ($categoryId) {
            $query->where('garment_category_id', $categoryId)->where('active', 1);
        }

        return $query->whereExists(function (Builder $query) {
            $query->select(\DB::raw(1))->from('product_colors')->whereRaw('products.id = product_colors.product_id')->where('product_colors.active', '=', true);
        })->orderBy('products.name', 'asc')->get();
    }

    public function getActive()
    {
        return $this->model->newQuery()->where('active', true)->get();
    }

    public function getEligibleForFreeProduct()
    {
        return $this->model->newQuery()->where('price', '<', config('greekhouse.product.price_limit'))->get();
    }

    public function getInexpensive()
    {
        return $this->model->newQuery()->where('price', '<', config('greekhouse.product.expensive_threshold'))->get();
    }

    public function getExpensive()
    {
        return $this->model->newQuery()->where('price', '>', config('greekhouse.product.expensive_threshold'))->get();
    }

    public function findByStyleNumber($styleNumber)
    {
        return $this->model->newQuery()->where('style_number', $styleNumber)->first();
    }

    public function options($nullOption = [], $category = null)
    {
        $options = $nullOption;
        $query = $this->model->newQuery()->orderBy('name', 'asc');
        if ($category) {
            $query->where('garment_category_id', $category);
        }

        $entries = $query->get();
        foreach ($entries as $entry) {
            $options[$entry->id] = $entry->name;
        }

        return $options;
    }

    public function getTopProductsByCategory($category, $limit)
    {
        $query = $this->model->newQuery();
        $topProducts = $query->select([
            'product_id',
            \DB::raw('count(product_id) as product_count'),
        ])->from('campaign_product_colors')->leftJoin('product_colors', 'campaign_product_colors.product_color_id', '=', 'product_colors.id')->leftJoin('products', 'product_colors.product_id', '=', 'products.id')->where('products.active', 1)->whereRaw('products.garment_category_id = '.$category)->groupBy('product_colors.product_id')->orderBy('product_count', 'desc')->orderBy('products.name', 'asc')->limit($limit)->get();

        return $topProducts;
    }
}
