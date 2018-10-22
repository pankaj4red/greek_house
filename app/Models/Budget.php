<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer $id
 * @property string  $code
 * @property string  $caption
 * @property double  $from
 * @property double  $to
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @mixin \Eloquent
 */
class Budget extends Model
{
    protected $table = 'budgets';

    protected $guarded = [];

    protected $dates = [];

    protected $hidden = [];
}
