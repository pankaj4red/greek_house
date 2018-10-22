<?php

namespace App\Listeners;

use App\Events\Campaign\StateManuallyChanged;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignStateManuallyChangedTracking
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param StateManuallyChanged $event
     * @return void
     */
    public function handle(StateManuallyChanged $event)
    {
        campaign_repository()->find($event->campaignId)->track('state_changed', ['state' => $event->state]);
    }
}
