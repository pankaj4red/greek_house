<?php

namespace App\Listeners;

use App\Events\Campaign\ArtworkFixed;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignArtworkFixedNotifications
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
        $this->dispatch(new SendEmailJob('newArtworkUpdate', [$event->campaignId]));
    }
}
