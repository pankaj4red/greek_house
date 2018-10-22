<?php

namespace App\Listeners;

use App\Events\Campaign\FulfillmentIssueSolved;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignFulfillmentIssueSolvedTracking
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  FulfillmentIssueSolved $event
     * @return void
     */
    public function handle(FulfillmentIssueSolved $event)
    {
        campaign_repository()->find($event->campaignId)->track('issue_solved');
    }
}
