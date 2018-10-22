<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string  $name
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 * @mixin \Eloquent
 */
class Supplier extends Model
{
    use SoftDeletes;

    protected $table = 'suppliers';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [];
}
