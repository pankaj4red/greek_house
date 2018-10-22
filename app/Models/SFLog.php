<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer $id
 * @property string  $sf_id
 * @property string  $message
 * @property string  $before
 * @property string  $after
 * @property string  $change
 * @property string  $context
 * @property string  $execution
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @mixin \Eloquent
 */
class SFLog extends Model
{
    protected $table = 'sf_logs';

    protected $guarded = [];

    protected $dates = [];

    protected $hidden = [];
}
