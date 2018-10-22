<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

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
class Chapter extends Model
{
    use SoftDeletes;

    protected $table = 'chapters';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['school'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
