<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer        $id
 * @property integer        $campaign_id
 * @property integer        $file_id
 * @property integer        $sort
 * @property string         $type
 * @property-read Campaign  $campaign
 * @property-read File      $file
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string         $deleted_at
 * @mixin \Eloquent
 */
class CampaignFile extends Model
{
    use SoftDeletes;

    protected $table = 'campaign_files';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['campaign', 'file'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public static function boot()
    {
        parent::boot();

        CampaignFile::created(function (CampaignFile $campaignFile) {
            if (! static::areEventsEnabled()) {
                return;
            }
            CampaignFile::checkCampaignFile($campaignFile);
        });

        CampaignFile::updated(function (CampaignFile $campaignFile) {
            if (! static::areEventsEnabled()) {
                return;
            }
            CampaignFile::checkCampaignFile($campaignFile);
        });
    }

    public static function checkCampaignFile(CampaignFile $campaignFile)
    {
        $campaignFile->load('campaign.user');
        if ($campaignFile->type == 'proof' && $campaignFile->campaign->state == 'awaiting_design' || $campaignFile->campaign->state == 'revision_requested') {
            // update state
            $campaignFile->campaign->state = 'awaiting_approval';
            $campaignFile->campaign->save();
            $campaignFile->campaign->notificationProofUploaded();
            success('Campaign state changed to: Awaiting Approval');
        }
    }
}
