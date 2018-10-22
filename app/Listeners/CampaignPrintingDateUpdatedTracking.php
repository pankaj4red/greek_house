<?php

namespace App\Listeners;

use App\Events\Campaign\PrintingDateUpdated;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignPrintingDateUpdatedTracking
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
        campaign_repository()->find($event->campaignId)->track('printing_date_updated', ['printing_date' => $event->printingDate]);
    }
}
