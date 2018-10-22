<?php

namespace App\Listeners;

use App\Events\Campaign\ArtworkFixed;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignArtworkFixedTracking
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  ArtworkFixed $event
     * @return void
     */
    public function handle(ArtworkFixed $event)
    {
        campaign_repository()->find($event->campaignId)->track('artwork_fixed');
    }
}
