<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer     $id
 * @property string      $design_id
 * @property string      $group
 * @property string      $name
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 * @property Carbon      $deleted_at
 * @property-read File   $file
 * @property-read Design $design
 * @mixin \Eloquent
 */
class DesignTag extends Model
{
    use SoftDeletes;

    protected $table = 'design_tags';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['file', 'design'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function design()
    {
        return $this->belongsTo(Design::class, 'design_id');
    }
}
