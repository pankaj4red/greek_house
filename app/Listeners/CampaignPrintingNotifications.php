<?php

namespace App\Listeners;

use App\Events\Campaign\Printing;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignPrintingNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  Printing $event
     * @return void
     */
    public function handle(Printing $event)
    {
        //
    }
}
