<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property int    $id
 * @property string $key
 * @property string value
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @mixin \Eloquent
 */
class Variable extends Model
{
    protected $table = 'variables';

    protected $guarded = [];

    protected $dates = [];

    protected $hidden = [];
}
