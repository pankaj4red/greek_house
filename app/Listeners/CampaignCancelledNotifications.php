<?php

namespace App\Listeners;

use App\Events\Campaign\Cancelled;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignCancelledNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  Cancelled $event
     * @return void
     */
    public function handle(Cancelled $event)
    {
        //
    }
}
