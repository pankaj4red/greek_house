<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer      $id
 * @property integer      $product_id
 * @property string       $name
 * @property integer      $thumbnail_id
 * @property integer      $image_id
 * @property boolean      $active
 * @property Carbon       $created_at
 * @property Carbon       $updated_at
 * @property Carbon       $deleted_at
 * @property-read Product $product
 * @property-read File    $image
 * @property-read File    $thumbnail
 * @mixin \Eloquent
 */
class ProductColor extends Model
{
    use SoftDeletes;

    protected $table = 'product_colors';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['product', 'image', 'thumbnail'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thumbnail()
    {
        return $this->belongsTo(File::class, 'thumbnail_id');
    }
}
