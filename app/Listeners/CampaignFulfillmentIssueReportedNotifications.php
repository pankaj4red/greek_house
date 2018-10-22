<?php

namespace App\Listeners;

use App\Events\Campaign\FulfillmentIssueReported;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignFulfillmentIssueReportedNotifications
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
        $this->dispatch(new SendEmailJob('fulfillmentIssueReported', [$event->campaignId]));
    }
}
