<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;

class DesignerCountdownController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.designer_countdown.designer_countdown_block');
    }
}
