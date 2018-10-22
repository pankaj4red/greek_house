<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;
use Illuminate\Http\Request;

class AdditionalInformationController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.additional_information');
    }

    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.additional_information');
    }

    public function postPopup($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        form($request)->validate([
            'shipping_cost' => 'numeric',
        ]);

        $this->getCampaign()->update([
            'shipping_cost' => $request->get('shipping_cost') ? $request->get('shipping_cost') : null,
        ]);

        return form()->success('Campaign Additional Information Updated')->back();
    }
}
