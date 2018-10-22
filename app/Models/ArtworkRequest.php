<?php

namespace App\Models;

use App\Events\Campaign\DesignerAssigned;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer                                      $id
 * @property integer                                      $designer_id
 * @property string                                       $state
 * @property integer                                      $revision_count
 * @property string                                       $revision_text
 * @property boolean                                      $print_front
 * @property string                                       $print_front_colors
 * @property string                                       $print_front_description
 * @property string                                       $print_front_dimensions
 * @property boolean                                      $print_pocket
 * @property string                                       $print_pocket_colors
 * @property string                                       $print_pocket_description
 * @property string                                       $print_pocket_dimensions
 * @property boolean                                      $print_back
 * @property string                                       $print_back_colors
 * @property string                                       $print_back_description
 * @property string                                       $print_back_dimensions
 * @property boolean                                      $print_sleeve
 * @property string                                       $print_sleeve_colors
 * @property string                                       $print_sleeve_description
 * @property string                                       $print_sleeve_preferred
 * @property string                                       $print_sleeve_dimensions
 * @property string                                       $design_style_preference
 * @property string                                       $design_type
 * @property integer                                      $design_minutes
 * @property float                                        $hourly_rate
 * @property string                                       $designer_action_required_at
 * @property string                                       $designer_assigned_at
 * @property string                                       $speciality_inks
 * @property string                                       $embellishment_names
 * @property string                                       $embellishment_numbers
 * @property boolean                                      $designer_black_shirt
 * @property integer                                      $designer_colors_front
 * @property integer                                      $designer_dimensions_front
 * @property integer                                      $designer_colors_front_list
 * @property integer                                      $designer_colors_back
 * @property integer                                      $designer_dimensions_back
 * @property integer                                      $designer_colors_back_list
 * @property integer                                      $designer_colors_sleeve_left
 * @property integer                                      $designer_dimensions_sleeve_left
 * @property integer                                      $designer_colors_sleeve_left_list
 * @property integer                                      $designer_colors_sleeve_right
 * @property integer                                      $designer_dimensions_sleeve_right
 * @property integer                                      $designer_colors_sleeve_right_list
 * @property Carbon                                       $created_at
 * @property Carbon                                       $updated_at
 * @property Carbon                                       $deleted_at
 * @property-read User                                    $designer
 * @property-read Campaign                                $campaign
 * @property-read ArtworkRequestFile[]|Collection|HasMany $images
 * @property-read ArtworkRequestFile[]|Collection|HasMany $proofs
 * @property-read ArtworkRequestFile[]|Collection|HasMany $proofs_front
 * @property-read ArtworkRequestFile[]|Collection|HasMany $proofs_back
 * @property-read ArtworkRequestFile[]|Collection|HasMany $proofs_close_up
 * @property-read ArtworkRequestFile[]|Collection|HasMany $proofs_other
 * @property-read ArtworkRequestFile[]|Collection|HasMany $proofs_generic
 * @property-read ArtworkRequestFile[]|Collection|HasMany $print_files
 * @mixin \Eloquent
 */
class ArtworkRequest extends Model
{
    use SoftDeletes;

    protected $table = 'artwork_requests';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['designer', 'images', 'proofs', 'print_files'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function campaign()
    {
        return $this->hasOne(Campaign::class, 'artwork_request_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->hasMany(ArtworkRequestFile::class, 'artwork_request_id')->where('type', 'image')->orderBy('sort', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proofs()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->hasMany(ArtworkRequestFile::class, 'artwork_request_id')->where('type', 'like', 'proof%')->orderBy('type')->orderBy('sort', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proofs_front()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->hasMany(ArtworkRequestFile::class, 'artwork_request_id')->where('type', 'proof_front')->orderBy('sort', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proofs_back()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->hasMany(ArtworkRequestFile::class, 'artwork_request_id')->where('type', 'proof_back')->orderBy('sort', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proofs_close_up()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->hasMany(ArtworkRequestFile::class, 'artwork_request_id')->where('type', 'proof_close_up')->orderBy('sort', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proofs_other()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->hasMany(ArtworkRequestFile::class, 'artwork_request_id')->where('type', 'proof_other')->orderBy('sort', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proofs_generic()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->hasMany(ArtworkRequestFile::class, 'artwork_request_id')->whereIn('type', ['proof_generic', 'proof'])->orderBy('sort', 'asc');
    }

    public function getProofsFromType($type, $productColorId = null)
    {
        $source = $this->proofs;
        switch ($type) {
            case 'front':
                $source = $this->proofs_front;
                break;
            case 'back':
                $source = $this->proofs_back;
                break;
            case 'close_up':
                $source = $this->proofs_close_up;
                break;
            case 'other':
                $source = $this->proofs_other;
                break;
            case 'generic':
                // Generics are not associated with products
                return $this->proofs_generic;
        }

        if ($productColorId) {
            return $source->where('product_color_id', $productColorId);
        }

        return $source;
    }

    public function getProofsFromProductColor($productColorId)
    {
        $collection = $this->proofs->where('product_color_id', $productColorId);
        if ($this->campaign->product_colors->first()->id == $productColorId) {
            $collection = $collection->merge($this->proofs->where('product_color_id', null));
        }

        return $collection->sort(function ($a, $b) {
            $aIndex = array_search($a->type, ['proof_front', 'proof_back', 'proof_close_up', 'proof_other', 'proof_generic']);
            $bIndex = array_search($b->type, ['proof_front', 'proof_back', 'proof_close_up', 'proof_other', 'proof_generic']);

            return $aIndex - $bIndex;
        });
    }

    public function getProofsFromProduct($productId)
    {
        return $this->proofs->filter(function ($value, $key) use ($productId) {
            if ($value->product_color && $value->product_color->product_id == $productId) {
                return true;
            }

            return false;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function print_files()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->hasMany(ArtworkRequestFile::class, 'artwork_request_id')->where('type', 'print_file')->orderBy('sort', 'asc');
    }

    protected static $runningEvent = false;

    public static function boot()
    {
        parent::boot();
        ArtworkRequest::updated(function (ArtworkRequest $artworkRequest) {
            if (! static::areEventsEnabled()) {
                return;
            }
            if (static::$runningEvent) {
                return;
            }
            static::$runningEvent = true;

            $original = (object) $artworkRequest->getOriginal();
            if ($original->designer_id == null && $artworkRequest->designer_id != null) {
                $artworkRequest->campaign->notificationDesignerAssigned();
            }

            if ($original->designer_id != $artworkRequest->designer_id) {
                $artworkRequest->designer_assigned_at = date('Y-m-d H:i:s');
                $artworkRequest->save();
                event(new DesignerAssigned($artworkRequest->campaign->id, $artworkRequest->designer_id));
            }
            static::$runningEvent = false;
        });
    }

    public function toContext()
    {
        return [
            'id'          => $this->id,
            'designer_id' => $this->designer_id,
        ];
    }
}
