<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;

class UnclaimedCampaignController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.unclaimed_campaign.unclaimed_campaign_block');
    }
}
