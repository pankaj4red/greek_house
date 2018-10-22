<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class StyleController extends Controller
{
    public function getRead()
    {
        return view('admin_old.style.read');
    }
}