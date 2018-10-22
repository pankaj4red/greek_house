<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;

class CampaignDetailsController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.campaign_details.campaign_details_block');
    }
}
