<?php

namespace App\Http\Controllers\Customer;

use App\Dashboards\AccountManagerMembersDashboard;
use App\Http\Controllers\Controller;
use App\Traits\ChecksCampaignPermission;
use App\Traits\ChecksUserActivation;
use Illuminate\Http\Request;

class AccountManagerController extends Controller
{
    use ChecksCampaignPermission, ChecksUserActivation;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('user_type:account_manager');
    }

    public function getAccounts(Request $request)
    {
        $dashboard = \App::make(AccountManagerMembersDashboard::class);
        $option = $dashboard->getDefault();
        $tables[] = [
            'name'         => 'default-table',
            'active'       => $option,
            'activeOption' => $dashboard->getActiveOption($option),
            'options'      => $dashboard->getOptions(),
            'results'      => $dashboard->getResults($option, $request->has('page') ? $request->get('page') : 1, $request->url(), $request->query()),
            'header'       => $dashboard->getHeader($option),
        ];

        return view('account_manager.accounts', [
            'tables' => $tables,
        ]);
    }

    public function getAccount($id)
    {
        $user = user_repository()->find($id);
        if (\Auth::user()->id != $id) {
            $valid = false;
            if (\Auth::user()->id == $user->account_manager_id) {
                $valid = true;
            }
            if ($valid == false) {
                if (\Auth::user()->type->isSupport()) {
                    $valid = true;
                }
            }
            if ($valid == false) {
                return form()->error('Access Denied')->route('account_manager::accounts');
            }
        }

        return view('account_manager.account', [
            'user' => $user,
        ]);
    }

    public function getShare()
    {
        return view('account_manager.share');
    }
}
