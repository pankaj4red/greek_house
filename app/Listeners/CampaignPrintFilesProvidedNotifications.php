<?php

namespace App\Listeners;

use App\Events\Campaign\PrintFilesProvided;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignPrintFilesProvidedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  PrintFilesProvided $event
     * @return void
     */
    public function handle(PrintFilesProvided $event)
    {
        //
    }
}
