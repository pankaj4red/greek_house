<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer     $id
 * @property integer     $school_id
 * @property string      $sf_id
 * @property string      $name
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 * @property Carbon      $deleted_at
 * @property-read School $school
 * @mixin \Eloquent
 */
class ChapterOrganization extends Model
{
    protected $table = 'chapter_organizations';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [];
}
