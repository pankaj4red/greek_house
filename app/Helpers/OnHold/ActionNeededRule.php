<?php

namespace App\Helpers\OnHold;

use App\Models\Campaign;
use App\Models\User;

class ActionNeededRule extends OnHoldRule
{
    protected $name = 'action_needed';

    protected $category = 'action_needed';

    protected $notification = null;

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
        $actionNeeded = 0;
        $user = $user->fresh('campaigns');
        foreach ($user->campaigns as $campaign) {
            if (in_array($campaign->state, [
                'awaiting_approval',
                'revision_requested',
            ])) {
                $actionNeeded++;
            }
            if ($campaign->state == 'collecting_payment') {
                $actionNeeded++;
            }
        }

        return $this->returnResult($campaign, $actionNeeded > 2);
    }
}