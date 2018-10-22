<?php

namespace App\Listeners;

use App\Events\Campaign\OnHold;
use App\Helpers\OnHold\OnHoldEngine;
use App\Logging\Logger;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignOnHoldNotifications
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  OnHold $event
     * @return void
     */
    public function handle(OnHold $event)
    {
        $rule = OnHoldEngine::getRule($event->ruleName);
        if (! $rule) {
            Logger::logAlert('Unknown on hold rule: '.$event->ruleName);
        }

        $campaign = campaign_repository()->find($event->campaignId);
        $notification = $rule->getNotification($campaign);

        if ($notification) {
            $campaign->user->notify($notification);
        }
    }
}
