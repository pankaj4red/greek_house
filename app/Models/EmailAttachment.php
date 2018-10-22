<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $email_id
 * @property string  $name
 * @property mixed   $content
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 * @mixin \Eloquent
 */
class EmailAttachment extends Model
{
    use SoftDeletes;

    protected $connection = 'logs';

    protected $table = 'email_attachments';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [];
}
