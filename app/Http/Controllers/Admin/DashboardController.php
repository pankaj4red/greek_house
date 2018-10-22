<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;

class DashboardController extends AdminBaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        return view('admin.dashboard.dashboard');
    }
}
