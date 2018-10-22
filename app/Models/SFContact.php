<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer $id
 * @property string  $sf_id
 * @property string  $content
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @mixin \Eloquent
 */
class SFContact extends Model
{
    protected $table = 'sf_contacts';

    protected $guarded = [];

    protected $dates = [];

    protected $hidden = [];
}
