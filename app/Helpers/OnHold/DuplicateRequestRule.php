<?php

namespace App\Helpers\OnHold;

use App\Models\Campaign;
use App\Models\User;
use App\Notifications\CampaignOnHold\OnHoldDuplicateNotification;

class DuplicateRequestRule extends OnHoldRule
{
    protected $name = 'duplicate';

    protected $category = 'duplicate';

    protected $notification = OnHoldDuplicateNotification::class;

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
        /** @var User $user */
        $user = $user->fresh('campaigns');
        foreach ($user->campaigns as $userCampaign) {
            if ($campaign->id == $userCampaign->id) {
                continue;
            }
            if ($campaign->name == $userCampaign->name) {
                return $this->returnResult($campaign, true);
            }
        }

        return $this->returnResult($campaign, false);
    }
}