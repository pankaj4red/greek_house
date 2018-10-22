<?php

namespace App\Listeners;

use App\Events\Campaign\FulfillmentIssueReported;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignFulfillmentIssueReportedTracking
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  FulfillmentIssueReported $event
     * @return void
     */
    public function handle(FulfillmentIssueReported $event)
    {
        campaign_repository()->find($event->campaignId)->track('fulfillment_issue: '.$event->reason, ['reason' => $event->reason]);
    }
}
