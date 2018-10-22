<?php

namespace App\Listeners;

use App\Events\Campaign\Shipped;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignShippedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  Shipped $event
     * @return void
     */
    public function handle(Shipped $event)
    {
        //
    }
}
