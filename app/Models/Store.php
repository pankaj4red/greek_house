<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string  $name
 * @property string  $email
 * @property string  $phone
 * @property string  $school
 * @property string  $chapter
 * @property integer $school_id
 * @property integer $chapter_id
 * @property string  $position
 * @property integer $size
 * @property string  $instagram
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 * @mixin \Eloquent
 */
class Store extends Model
{
    use SoftDeletes;

    protected $table = 'stores';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [];
}
