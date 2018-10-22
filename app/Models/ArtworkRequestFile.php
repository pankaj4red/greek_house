<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer             $id
 * @property integer             $artwork_request_id
 * @property integer             $file_id
 * @property integer             $product_color_id
 * @property integer             $sort
 * @property string              $type
 * @property \Carbon\Carbon      $created_at
 * @property \Carbon\Carbon      $updated_at
 * @property \Carbon\Carbon      $deleted_at
 * @property-read ArtworkRequest $artwork_request
 * @property-read File           $file
 * @mixin \Eloquent
 */
class ArtworkRequestFile extends Model
{
    use SoftDeletes;

    protected $table = 'artwork_request_files';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['artwork_request', 'file'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function artwork_request()
    {
        return $this->belongsTo(ArtworkRequest::class, 'artwork_request_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product_color()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    public static function boot()
    {
        parent::boot();

        ArtworkRequestFile::created(function (ArtworkRequestFile $artworkRequestFile) {
            if (! static::areEventsEnabled()) {
                return;
            }
            ArtworkRequestFile::checkFile($artworkRequestFile);
        });

        ArtworkRequestFile::updated(function (ArtworkRequestFile $artworkRequestFile) {
            if (! static::areEventsEnabled()) {
                return;
            }
            ArtworkRequestFile::checkFile($artworkRequestFile);
        });
    }

    public static function checkFile(ArtworkRequestFile $artworkRequestFile)
    {
        $artworkRequestFile->load('artwork_request.campaign.user');
        if (in_array($artworkRequestFile->type, [
                'proof_generic',
                'proof_front',
                'proof_back',
                'proof_close_up',
                'proof_other',
            ]) && $artworkRequestFile->artwork_request->campaign->state == 'awaiting_design' || $artworkRequestFile->artwork_request->campaign->state == 'revision_requested') {
            $artworkRequestFile->artwork_request->campaign->state = 'awaiting_approval';
            $artworkRequestFile->artwork_request->campaign->save();
            $artworkRequestFile->artwork_request->campaign->notificationProofUploaded();
            success('Campaign state changed to: Awaiting Approval');
        }
    }
}
