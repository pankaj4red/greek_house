<?php

namespace App\Listeners;

use App\Events\Campaign\Delivered;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignDeliveredNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  Delivered $event
     * @return void
     */
    public function handle(Delivered $event)
    {
        //
    }
}
