<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer $id
 * @property string  $code
 * @property string  $caption
 * @property string  $whitelist
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @mixin \Eloquent
 */
class DesignTagGroup extends Model
{
    protected $table = 'design_tag_groups';

    protected $guarded = [];

    protected $dates = [];

    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function design()
    {
        return $this->belongsTo(Design::class, 'design_id');
    }
}
