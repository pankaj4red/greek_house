<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer                                      $id
 * @property string                                       $design_type
 * @property string                                       $speciality_inks
 * @property string                                       $embellishment_names
 * @property string                                       $embellishment_numbers
 * @property boolean                                      $designer_black_shirt
 * @property integer                                      $designer_colors_front
 * @property integer                                      $designer_colors_back
 * @property integer                                      $designer_colors_sleeve_left
 * @property integer                                      $designer_colors_sleeve_right
 * @property Carbon                                       $created_at
 * @property Carbon                                       $updated_at
 * @property Carbon                                       $deleted_at
 * @property-read ArtworkRequestFile[]|Collection|HasMany $proofs
 * @property-read ArtworkRequestFile[]|Collection|HasMany $print_files
 * @mixin \Eloquent
 */
class Artwork extends Model
{
    use SoftDeletes;

    protected $table = 'artwork_requests';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['designer'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proofs()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->hasMany(ArtworkFile::class, 'artwork_id')->where('type', 'proof')->orderBy('sort', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function print_files()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->hasMany(ArtworkFile::class, 'artwork_id')->where('type', 'print_file')->orderBy('sort', 'asc');
    }
}
