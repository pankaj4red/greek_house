<?php

namespace App\Listeners;

use App\Events\Campaign\CampusApprovalRequired;
use App\Jobs\SendEmailJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignCampusApprovalRequiredNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  CampusApprovalRequired $event
     * @return void
     */
    public function handle(CampusApprovalRequired $event)
    {
        $this->dispatch(new SendEmailJob('campusManagerApproveRequired', [$event->campaignId]));
    }
}
