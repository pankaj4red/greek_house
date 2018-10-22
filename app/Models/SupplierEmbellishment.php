<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer                    $id
 * @property integer                    $supplier_id
 * @property string                     $embellishment
 * @property Carbon                     $created_at
 * @property Carbon                     $updated_at
 * @property Carbon                     $deleted_at
 * @property-read SupplierEmbellishment $supplier
 * @mixin \Eloquent
 */
class SupplierEmbellishment extends Model
{
    use SoftDeletes;

    protected $table = 'supplier_embellishments';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['supplier'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(SupplierEmbellishment::class, 'supplier_embellishment_id');
    }
}
