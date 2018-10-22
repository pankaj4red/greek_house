<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\GarmentBrand
 *
 * @property integer $id
 * @property string  $name
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 * @mixin \Eloquent
 */
class GarmentBrand extends Model
{
    use SoftDeletes;

    protected $table = 'garment_brands';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [];
}
