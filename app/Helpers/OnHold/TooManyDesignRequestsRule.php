<?php

namespace App\Helpers\OnHold;

use App\Models\Campaign;
use App\Models\User;
use App\Notifications\CampaignOnHold\OnHoldHighRiskNotification;

class TooManyDesignRequestsRule extends OnHoldRule
{
    protected $name = 'too_many_design_requests';

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
        $openCount = 0;
        foreach ($user->campaigns as $campaign) {
            if (in_array($campaign->state, [
                'on_hold',
                'campus_approval',
                'awaiting_design',
                'awaiting_approval',
                'revision_requested',
                'awaiting_quote',
                'collecting_payment',
            ])) {
                $openCount++;
            }
        }

        return $this->returnResult($campaign, $openCount > 2);
    }
}