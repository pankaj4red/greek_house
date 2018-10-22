<?php

namespace App\Helpers\OnHold;

use App\Models\Campaign;
use App\Models\User;
use App\Notifications\CampaignOnHold\OnHoldHighRiskNotification;

class LowSuccessRateRule extends OnHoldRule
{
    protected $name = 'high_risk';

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
        $success = 0;
        $fail = 0;
        $user = $user->fresh('campaigns');
        foreach ($user->campaigns as $campaign) {
            if (in_array($campaign->state, [
                'processing_payment',
                'fulfillment_ready',
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
            ])) {
                $success++;
            }
            if ($campaign->state == 'cancelled') {
                $fail++;
            }
        }
        if ($fail == 0 && $success == 0) {
            return $this->returnResult($campaign, false);
        }

        return $this->returnResult($campaign, $success / ($success + $fail) < 0.5);
    }
}