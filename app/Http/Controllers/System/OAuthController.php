<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Services\HubSpot;
use Illuminate\Http\Request;

class OAuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('user_type:can_access_admin');
    }

    public function getHubSpot(Request $request)
    {
        if (! $request->get('code')) {
            return view('v2.system.oauth.hubspot', [
                'error' => $request->get('error') ? ($request->get('error').': '.$request->get('error_description')) : null,
            ]);
        }

        $refreshToken = (new HubSpot())->getRefreshToken($request->get('code'));

        return view('v2.system.oauth.hubspot_result', ['refreshToken' => $refreshToken]);
    }
}