<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer   $id
 * @property string    $name
 * @property integer   $image_id
 * @property boolean   $active
 * @property integer   $sort
 * @property integer   $wizard
 * @property boolean   $allow_additional
 * @property Carbon    $created_at
 * @property Carbon    $updated_at
 * @property Carbon    $deleted_at
 * @property-read File $image
 * @mixin \Eloquent
 */
class GarmentCategory extends Model
{
    use SoftDeletes;

    protected $table = 'garment_categories';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['image'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
