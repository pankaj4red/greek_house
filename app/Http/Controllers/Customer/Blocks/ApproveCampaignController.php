<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Events\Campaign\AwaitingDesign;
use App\Http\Controllers\BlockController;
use Illuminate\Http\Request;

class ApproveCampaignController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.approve_campaign');
    }

    public function postApprove($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        if ($this->getCampaign()->state != 'campus_approval') {
            return form()->error('Campaign is not awaiting approval.')->back();
        }

        $this->getCampaign()->update([
            'state' => 'awaiting_design',
        ]);;
        add_comment($this->getCampaign()->id, 'Campaign has been approved by the Campus Manager');
        event(new AwaitingDesign($this->getCampaign()->id));

        return form()->success('Campaign Approved')->back();
    }

    public function postCancel($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        if ($this->getCampaign()->state != 'campus_approval') {
            return form()->error('Campaign is not awaiting approval.')->back();
        }

        $this->getCampaign()->update([
            'state' => 'cancelled',
        ]);
        add_comment($this->getCampaign()->id, 'Campaign has been disapproved by the Campus Manager');

        return form()->success(success('Campaign Cancelled'))->back();
    }
}
