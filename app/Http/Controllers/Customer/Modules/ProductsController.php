<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;

class ProductsController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.products.products_block');
    }
}
