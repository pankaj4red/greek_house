<?php

namespace App\Listeners;

use App\Events\Campaign\DesignerAssigned;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignDesignerAssignedNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  DesignerAssigned $event
     * @return void
     */
    public function handle(DesignerAssigned $event)
    {
        //
    }
}
