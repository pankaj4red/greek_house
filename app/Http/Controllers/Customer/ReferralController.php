<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class ReferralController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function getIndex()
    {
        return view('referral.index');
    }
}
