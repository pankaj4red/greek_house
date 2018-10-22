<?php

namespace App\Helpers\OnHold;

use App\Models\Campaign;
use App\Models\User;
use App\Notifications\CampaignOnHold\OnHoldDesignSpecificNotification;

class RejectedByDesignerSpecificRule extends OnHoldRule
{
    protected $name = 'rejected_by_designer_specific';

    protected $category = 'design';

    protected $notification = OnHoldDesignSpecificNotification::class;

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

        return $this->returnResult($campaign, false);
    }
}