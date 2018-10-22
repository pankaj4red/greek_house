<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string  $name
 * @property string  $short
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 * @mixin \Eloquent
 */
class GarmentSize extends Model
{
    use SoftDeletes;

    protected $table = 'garment_sizes';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [];
}
