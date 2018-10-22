<?php

namespace App\Http\Controllers;

abstract class AdminBaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('user_type:can_access_admin');
    }
}
