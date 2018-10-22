<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string  $channel
 * @property string  $level
 * @property string  $message
 * @property string  $method
 * @property string  $args
 * @property string  $context
 * @property string  $extra
 * @property string  $stack
 * @property integer $user_id
 * @property string  $username
 * @property string  $ip
 * @property string  $notification_status
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 * @mixin \Eloquent
 */
class Log extends Model
{
    use SoftDeletes;

    protected $table = 'logs';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [];
}
