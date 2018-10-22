<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer          $id
 * @property integer          $order_id
 * @property integer          $garment_size_id
 * @property integer          $product_color_id
 * @property integer          $quantity
 * @property float            $price
 * @property float            $subtotal
 * @property string           $sf_id
 * @property Carbon           $created_at
 * @property Carbon           $updated_at
 * @property Carbon           $deleted_at
 * @property-read GarmentSize $size
 * @property-read Order       $order
 * @mixin \Eloquent
 */
class OrderEntry extends Model
{
    use SoftDeletes;

    protected $table = 'order_entries';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['size', 'order', 'product_color'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product_color()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(ProductColor::class, 'product_color_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function size()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(GarmentSize::class, 'garment_size_id')->withTrashed();
    }
}
