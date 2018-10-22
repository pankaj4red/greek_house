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
 * @property string  $year
 * @property string  $description
 * @property string  $positions
 * @property string  $major
 * @property string  $sf_id
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 * @mixin \Eloquent
 */
class CampusManager extends Model
{
    use SoftDeletes;

    protected $table = 'campus_managers';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [];
}
