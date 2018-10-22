<?php

namespace App\Helpers\OnHold;

use App\Models\Campaign;
use App\Models\User;
use App\Notifications\CampaignOnHold\OnHoldHighRiskNotification;

class OnlyCancelledCampaignsRule extends OnHoldRule
{
    protected $name = 'only_cancelled';

    protected $category = 'high_risk';

    protected $notification = OnHoldHighRiskNotification::class;

    /**
     * @param Campaign $campaign
     * @param User     $user
     * @return bool
     */
    public function match(Campaign $campaign, User $user)
    {
        if ($user->type->isStaff()) {
            return $this->returnResult($campaign, false);
        }
        $user = $user->fresh('campaigns');
        if ($user->campaigns->count() <= 1) {
            return $this->returnResult($campaign, false);
        }
        foreach ($user->campaigns as $userCampaign) {
            if ($campaign->id == $userCampaign->id) {
                continue;
            }
            if ($userCampaign->state != 'cancelled') {
                return $this->returnResult($campaign, false);
            }
        }

        return $this->returnResult($campaign, true);
    }
}