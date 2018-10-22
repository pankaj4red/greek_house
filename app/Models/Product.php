<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer                        $id
 * @property string                         $sku
 * @property string                         $name
 * @property integer                        $garment_category_id
 * @property integer                        $garment_gender_id
 * @property integer                        $garment_brand_id
 * @property string                         $description
 * @property string                         $sizes_text
 * @property string                         $style_number
 * @property string                         $features
 * @property float                          $price
 * @property integer                        $image_id
 * @property boolean                        $active
 * @property Carbon                         $created_at
 * @property Carbon                         $updated_at
 * @property Carbon                         $deleted_at
 * @property string                         $designer_instructions
 * @property string                         $fulfillment_instructions
 * @property string                         $suggested_supplier
 * @property-read Collection|ProductColor[] $colors
 * @property-read Collection|ProductColor[] $active_colors
 * @property-read Collection|ProductSize[]  $sizes
 * @property-read GarmentGender             $gender
 * @property-read GarmentBrand              $brand
 * @property-read GarmentCategory           $category
 * @property-read File                      $image
 * @mixin \Eloquent
 */
class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['colors', 'active_colors', 'sizes', 'gender', 'brand', 'category', 'image'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function colors()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->hasMany(ProductColor::class, 'product_id')->orderBy('name', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function active_colors()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->hasMany(ProductColor::class, 'product_id')->where('active', true)->orderBy('name', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sizes()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->hasMany(ProductSize::class, 'product_id')->orderBy('garment_size_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gender()
    {
        return $this->belongsTo(GarmentGender::class, 'garment_gender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(GarmentBrand::class, 'garment_brand_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(GarmentCategory::class, 'garment_category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
