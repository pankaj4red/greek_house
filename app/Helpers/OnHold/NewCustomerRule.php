<?php

namespace App\Helpers\OnHold;

use App\Models\Campaign;
use App\Models\User;
use App\Notifications\CampaignOnHold\OnHoldNewCustomerNotification;

class NewCustomerRule extends OnHoldRule
{
    protected $name = 'new_customer';

    protected $category = 'new_customer';

    protected $notification = OnHoldNewCustomerNotification::class;

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

        return $this->returnResult($campaign, $user->campaigns->count() == 1 && $user->campaigns->first()->id == $campaign->id);
    }
}