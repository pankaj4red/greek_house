<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer        $id
 * @property string         $sf_id
 * @property string         $name
 * @property Carbon         $created_at
 * @property Carbon         $updated_at
 * @property Carbon         $deleted_at
 * @property-read Chapter[] $chapters
 * @mixin \Eloquent
 */
class School extends Model
{
    use SoftDeletes;

    protected $table = 'schools';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['chapters'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'school_id');
    }
}
