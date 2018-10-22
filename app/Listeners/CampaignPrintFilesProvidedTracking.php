<?php

namespace App\Listeners;

use App\Events\Campaign\PrintFilesProvided;

class CampaignPrintFilesProvidedTracking
{
    /**
     * Handle the event.
     *
     * @param  PrintFilesProvided $event
     * @return void
     */
    public function handle(PrintFilesProvided $event)
    {
        campaign_repository()->find($event->campaignId)->track('print_files_provided');
    }
}
