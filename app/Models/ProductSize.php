<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer          $id
 * @property integer          $product_id
 * @property integer          $garment_size_id
 * @property Carbon           $created_at
 * @property Carbon           $updated_at
 * @property Carbon           $deleted_at
 * @property-read GarmentSize $size
 * @mixin \Eloquent
 */
class ProductSize extends Model
{
    use SoftDeletes;

    protected $table = 'product_sizes';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['size'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function size()
    {
        return $this->belongsTo(GarmentSize::class, 'garment_size_id');
    }
}
