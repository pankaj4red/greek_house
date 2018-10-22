<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;

class DeliveryInformationController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.delivery_information.delivery_information_block');
    }
}
