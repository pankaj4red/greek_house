<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer     $id
 * @property string      $type
 * @property integer     $design_id
 * @property integer     $file_id
 * @property boolean     $enabled
 * @property integer     $sort
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 * @property Carbon      $deleted_at
 * @property-read File   $file
 * @property-read Design $design
 * @mixin \Eloquent
 */
class DesignFile extends Model
{
    use SoftDeletes;

    protected $table = 'design_files';

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
