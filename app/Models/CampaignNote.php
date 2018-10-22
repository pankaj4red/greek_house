<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer       $id
 * @property integer       $campaign_id
 * @property string        $type
 * @property string        $content
 * @property Carbon        $created_at
 * @property Carbon        $updated_at
 * @property-read Campaign $campaign
 * @mixin \Eloquent
 */
class CampaignNote extends Model
{
    protected $table = 'campaign_notes';

    protected $guarded = [];

    protected $dates = [];

    protected $hidden = ['campaign'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
