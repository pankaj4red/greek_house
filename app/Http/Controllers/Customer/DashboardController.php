<?php

namespace App\Http\Controllers\Customer;

use App\Dashboards\AccountManagerDashboard;
use App\Dashboards\AdminDashboard;
use App\Dashboards\ArtDirectorDashboard;
use App\Dashboards\CustomerClosedDashboard;
use App\Dashboards\CustomerOpenDashboard;
use App\Dashboards\DecoratorAwaitingGarmentsDashboard;
use App\Dashboards\DecoratorDashboard;
use App\Dashboards\DecoratorPrintingDashboard;
use App\Dashboards\DesignerDashboard;
use App\Dashboards\JuniorDesignerDashboard;
use App\Dashboards\SupportDashboard;
use App\Helpers\OnHold\RejectedByDesignerGenericRule;
use App\Helpers\OnHold\RejectedByDesignerSpecificRule;
use App\Http\Controllers\Controller;
use App\Logging\Logger;
use App\Traits\ChecksCampaignPermission;
use App\Traits\ChecksUserActivation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ChecksCampaignPermission, ChecksUserActivation;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function getIndex(Request $request, $option = null)
    {
        dashboard_change();

        $dashboardNavigation = false;
        $tables = [];
        if (\Auth::user()->isType('admin')) {
            $dashboard = \App::make(AdminDashboard::class);
            if ($option === null) {
                $option = $dashboard->getDefault();
            }
            $tables[] = [
                'name'         => 'default-table',
                'active'       => $option,
                'activeOption' => $dashboard->getActiveOption($option),
                'options'      => $dashboard->getOptions(),
                'results'      => $dashboard->getResults($option, $request->has('page') ? $request->get('page') : 1, $request->url(), $request->query()),
                'header'       => $dashboard->getHeader($option),
                'fluid'        => $dashboard->getFluid(),
            ];
            $dashboardNavigation = $dashboard->showsNavigation();
        } elseif (\Auth::user()->isType('support')) {
            $dashboard = \App::make(SupportDashboard::class);
            if ($option === null) {
                $option = $dashboard->getDefault();
            }
            $tables[] = [
                'name'         => 'default-table',
                'active'       => $option,
                'activeOption' => $dashboard->getActiveOption($option),
                'options'      => $dashboard->getOptions(),
                'results'      => $dashboard->getResults($option, $request->has('page') ? $request->get('page') : 1, $request->url(), $request->query()),
                'header'       => $dashboard->getHeader($option),
                'fluid'        => $dashboard->getFluid(),
            ];
            $dashboardNavigation = $dashboard->showsNavigation();
        } elseif (\Auth::user()->isType('art_director')) {
            $dashboard = \App::make(ArtDirectorDashboard::class);
            if ($option === null) {
                $option = $dashboard->getDefault();
            }
            $tables[] = [
                'name'         => 'default-table',
                'active'       => $option,
                'activeOption' => $dashboard->getActiveOption($option),
                'options'      => $dashboard->getOptions(),
                'results'      => $dashboard->getResults($option, $request->has('page') ? $request->get('page') : 1, $request->url(), $request->query()),
                'header'       => $dashboard->getHeader($option),
                'fluid'        => $dashboard->getFluid(),
            ];
            $dashboardNavigation = $dashboard->showsNavigation();
        } elseif (\Auth::user()->isType('designer')) {
            $dashboard = \App::make(DesignerDashboard::class);
            if ($option === null) {
                $option = $dashboard->getDefault();
            }
            $tables[] = [
                'name'         => 'default-table',
                'active'       => $option,
                'activeOption' => $dashboard->getActiveOption($option),
                'options'      => $dashboard->getOptions(),
                'results'      => $dashboard->getResults($option, $request->has('page') ? $request->get('page') : 1, $request->url(), $request->query()),
                'header'       => $dashboard->getHeader($option),
                'fluid'        => $dashboard->getFluid(),
            ];
            $dashboardNavigation = $dashboard->showsNavigation();
        } elseif (\Auth::user()->isType('junior_designer')) {
            $dashboard = \App::make(JuniorDesignerDashboard::class);
            if ($option === null) {
                $option = $dashboard->getDefault();
            }
            $tables[] = [
                'name'         => 'default-table',
                'active'       => $option,
                'activeOption' => $dashboard->getActiveOption($option),
                'options'      => $dashboard->getOptions(),
                'results'      => $dashboard->getResults($option, $request->has('page') ? $request->get('page') : 1, $request->url(), $request->query()),
                'header'       => $dashboard->getHeader($option),
                'fluid'        => $dashboard->getFluid(),
            ];
            $dashboardNavigation = $dashboard->showsNavigation();
        } elseif (\Auth::user()->isType('decorator')) {
            $dashboard = \App::make(DecoratorDashboard::class);
            if ($option === null) {
                $option = $dashboard->getDefault();
            }
            $tables[] = [
                'name'         => 'default-table',
                'active'       => $option,
                'activeOption' => $dashboard->getActiveOption($option),
                'options'      => $dashboard->getOptions(),
                'results'      => $dashboard->getResults($option, $request->has('page') ? $request->get('page') : 1, $request->url(), $request->query()),
                'header'       => $dashboard->getHeader($option),
                'fluid'        => $dashboard->getFluid(),
            ];
            $dashboardNavigation = $dashboard->showsNavigation();
            if ($option == 'today') {
                $dashboard = \App::make(DecoratorAwaitingGarmentsDashboard::class);
                $tables[] = [
                    'name'         => 'decorator-awaiting-garments',
                    'active'       => null,
                    'activeOption' => $dashboard->getActiveOption($option),
                    'options'      => $dashboard->getOptions(),
                    'results'      => $dashboard->getResults($option, $request->has('page2') ? $request->get('page2') : 1, $request->url(), $request->query()),
                    'header'       => $dashboard->getHeader($option),
                    'fluid'        => $dashboard->getFluid(),
                ];
                $dashboard = \App::make(DecoratorPrintingDashboard::class);
                $tables[] = [
                    'name'         => 'decorator-printing',
                    'active'       => null,
                    'activeOption' => $dashboard->getActiveOption($option),
                    'options'      => $dashboard->getOptions(),
                    'results'      => $dashboard->getResults($option, $request->has('page3') ? $request->get('page3') : 1, $request->url(), $request->query()),
                    'header'       => $dashboard->getHeader($option),
                    'fluid'        => $dashboard->getFluid(),
                ];
                $dashboardNavigation = $dashboard->showsNavigation();
            }
        } elseif (\Auth::user()->isType('account_manager')) {
            $dashboard = \App::make(AccountManagerDashboard::class);
            if ($option === null) {
                $option = $dashboard->getDefault();
            }
            $tables[] = [
                'name'         => 'default-table',
                'active'       => $option,
                'activeOption' => $dashboard->getActiveOption($option),
                'options'      => $dashboard->getOptions(),
                'results'      => $dashboard->getResults($option, $request->has('page') ? $request->get('page') : 1, $request->url(), $request->query()),
                'header'       => $dashboard->getHeader($option),
                'fluid'        => $dashboard->getFluid(),
            ];
            $dashboardNavigation = $dashboard->showsNavigation();
        } else {
            $dashboard = \App::make(CustomerOpenDashboard::class);
            $tables[] = [
                'name'         => 'open_table',
                'active'       => $option,
                'activeOption' => $dashboard->getActiveOption($option),
                'options'      => $dashboard->getOptions(),
                'results'      => $dashboard->getResults($option, $request->has('page') ? $request->get('page') : 1, $request->url(), $request->query()),
                'header'       => $dashboard->getHeader($option),
                'fluid'        => $dashboard->getFluid(),
            ];
            $dashboard = \App::make(CustomerClosedDashboard::class);
            $tables[] = [
                'name'         => 'closed_table',
                'active'       => $option,
                'activeOption' => $dashboard->getActiveOption($option),
                'options'      => $dashboard->getOptions(),
                'results'      => $dashboard->getResults($option, $request->has('page2') ? $request->get('page2') : 1, $request->url(), $request->query()),
                'header'       => $dashboard->getHeader($option),
                'fluid'        => $dashboard->getFluid(),
            ];
            $dashboardNavigation = $dashboard->showsNavigation();
        }

        return view('v3.customer.dashboard.dashboard', [
            'tables'              => $tables,
            'dashboardNavigation' => $dashboardNavigation,
        ]);
    }

    public function getDetails($id, Request $request, $view = null)
    {
        $campaign = campaign_repository()->find($id);
        if ($campaign == null) {
            Logger::logWarning('Unknown Campaign #Dashboard');

            return form()->error('Unknown Campaign')->route('dashboard::index');
        }
        if (! in_array($view, [
            null,
            'Customer',
            'Support',
            'Director',
            'Designer',
            'JuniorDesigner',
            'Fulfillment',
            'Decorator',
            'Public',
            'AccountManager',
            'DesignGallery',
        ])) {
            return form()->error('Unknown View')->route('dashboard::index');
        }
        if ($view == null) {
            if (\Auth::user()->id == $campaign->user_id) {
                $view = 'Customer';
            } elseif (\Auth::user()->isType(['admin', 'support'])) {
                $view = 'Support';
            } elseif (\Auth::user()->isType('art_director')) {
                $view = 'Director';
            } elseif (\Auth::user()->isType('designer')) {
                $view = 'Designer';
            } elseif (\Auth::user()->isType('junior_designer')) {
                $view = 'JuniorDesigner';
            } elseif (\Auth::user()->isType('decorator')) {
                $view = 'Decorator';
            } elseif (\Auth::user()->isType('account_manager')) {
                $view = 'AccountManager';
            } else {
                $view = 'Public';
            }

            return form()->route('dashboard::details', [$campaign->id, $view]);
        }

        if ($view != 'Public') {
            $result = $this->checkCampaignPermissions($campaign);
            if ($result != null) {
                return $result;
            }
        }

        $className = 'App\\CampaignViews\\'.$view.'CampaignView';
        $campaignView = new $className($campaign);

        return view($campaignView->isV2() ? 'v3.customer.dashboard.campaign' : 'dashboard.details', [
            'campaign'     => $campaign,
            'campaignView' => $campaignView,
            'popup'        => $request->has('popup') ? $request->get('popup') : false,
        ]);
    }

    public function getGrab($id)
    {
        $campaign = campaign_repository()->find($id);
        if ($campaign == null) {
            return form()->error('Unknown Campaign')->back();
        }
        if (\Auth::user()->isType(['designer', 'art_director'])) {
            if ($campaign->artwork_request->designer_id == null) {
                $campaign->artwork_request->designer_id = \Auth::user()->id;
                $campaign->artwork_request->save();

                return form()->success('This campaign is now assigned to you')->back();
            } else {
                return form()->error('Campaign already assigned')->back();
            }
        } else {
            return form()->error('You cannot grab campaigns')->back();
        }
    }

    public function postReject($id, Request $request)
    {
        $campaign = campaign_repository()->find($id);
        if ($campaign == null) {
            return form()->error('Unknown Campaign')->back();
        }

        form($request)->validate([
            'reason' => 'required',
        ]);

        if (\Auth::user()->isType(['designer', 'art_director'])) {
            if ($campaign->artwork_request->designer_id == null) {
                if ($request->get('reason') == 'generic') {
                    (new RejectedByDesignerGenericRule())->process($campaign, $campaign->user);
                } else {
                    (new RejectedByDesignerSpecificRule())->process($campaign, $campaign->user, $request->get('reason'));
                }

                return form()->success('This campaign is now marked as rejected by you')->back();
            } else {
                return form()->error('Campaign already assigned')->back();
            }
        } else {
            return form()->error('You cannot grab campaigns')->back();
        }
    }
}
