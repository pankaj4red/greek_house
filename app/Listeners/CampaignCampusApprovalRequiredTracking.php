<?php

namespace App\Listeners;

use App\Events\Campaign\CampusApprovalRequired;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignCampusApprovalRequiredTracking
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
        campaign_repository()->find($event->campaignId)->track('campus_approval_required');
    }
}
