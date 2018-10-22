<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Logging\Logger;
use Illuminate\Http\Request;

class SystemStealthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getError(Request $request)
    {
        Logger::logNotice('Javascript: ['.$request->get('url').'] '.$request->get('error'), ['stack' => $request->get('stack'), 'file' => $request->get('file'), 'line' => $request->get('line')]);
    }

    public function getLogicError(Request $request)
    {
        Logger::logLogicError([$request->get('url').': '.$request->get('error')]);
    }
}
