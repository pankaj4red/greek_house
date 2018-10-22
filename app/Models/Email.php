<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string  $from
 * @property string  $to
 * @property string  $cc
 * @property string  $subject
 * @property string  $body
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 * @mixin \Eloquent
 */
class Email extends Model
{
    use SoftDeletes;

    protected $connection = 'logs';

    protected $table = 'emails';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [];
}
