<?php

namespace App\Listeners;

use App\Events\Campaign\PrintingDateUpdated;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignPrintingDateUpdatedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  PrintingDateUpdated $event
     * @return void
     */
    public function handle(PrintingDateUpdated $event)
    {
        $this->dispatch(new SendEmailJob('fulfillmentPrintingDateUpdated', [$event->campaignId, $event->oldPrintingDate]));
    }
}
