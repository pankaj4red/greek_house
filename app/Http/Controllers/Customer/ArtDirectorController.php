<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Traits\ChecksCampaignPermission;
use App\Traits\ChecksUserActivation;
use Illuminate\Http\Request;

class ArtDirectorController extends Controller
{
    use ChecksCampaignPermission, ChecksUserActivation;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('user_type:is_director');
    }

    public function getIndex(Request $request)
    {
        return view('art_director.index', [
            'unclaimed'   => campaign_repository()->getUnclaimed(),
            'designer'    => campaign_repository()->getAwaitingForDesigner(),
            'customer'    => campaign_repository()->getAwaitingForCustomer(),
            'done'        => campaign_repository()->getDesignCompleted(),
            'uploadFiles' => campaign_repository()->getNeedingUploadFiles($request->get('embellishment')),
        ]);
    }

    public function getAwaitingForCustomer(Request $request)
    {
        return view('art_director.awaiting_for_customer', [
            'customer' => campaign_repository()->getAwaitingForCustomer($request->get('embellishment')),
        ]);
    }

    public function getAwaitingForDesigner()
    {
        return view('art_director.awaiting_for_designer', [
            'designer' => campaign_repository()->getAwaitingForDesigner(),
        ]);
    }

    public function getDone(Request $request)
    {
        return view('art_director.done', [
            'done' => campaign_repository()->getDesignCompleted($request->get('embellishment')),
        ]);
    }

    public function getUnclaimed()
    {
        return view('art_director.unclaimed', [
            'unclaimed' => campaign_repository()->getUnclaimed(\Request::get('embellishment')),
        ]);
    }

    public function getUploadFiles()
    {
        return view('art_director.upload_files', [
            'uploadFiles' => campaign_repository()->getNeedingUploadFiles(\Request::get('embellishment')),
        ]);
    }

    public function getDesigner($id = null)
    {
        $designers = user_repository()->getDesigners();

        $designer = null;
        $designerCampaigns = [];
        if ($id != null) {
            $designer = user_repository()->find($id);
            if ($designer == null || ! $designer->type->isDesigner()) {
                return form()->route('art_director::designer')->withErrors('Unknown Designer');
            }

            $designerCampaigns = campaign_repository()->getAssignedToDesigner($id);
        }

        return view('art_director.designer', [
            'designers'         => $designers,
            'designer'          => $designer,
            'designerCampaigns' => $designerCampaigns,
        ]);
    }

    public function getLogInAs($id)
    {
        $designer = user_repository()->find($id);
        if ($designer == null || ! $designer->type->isDesigner()) {
            return form()->route('art_director::designer')->withErrors('Unknown Designer');
        }

        \Session::put('artlo', \Auth::user()->id);
        \Auth::login($designer);

        return form()->success('Logged in as designer')->route('dashboard::index');
    }
}
