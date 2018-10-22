<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer        $id
 * @property integer        $artwork_id
 * @property integer        $file_id
 * @property integer        $sort
 * @property string         $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read Artwork   $artwork
 * @property-read File      $file
 * @mixin \Eloquent
 */
class ArtworkFile extends Model
{
    use SoftDeletes;

    protected $table = 'artwork_files';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['artwork', 'file'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function artwork()
    {
        return $this->belongsTo(Artwork::class, 'artwork_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
