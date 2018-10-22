<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;
use Illuminate\Http\Request;

class ShippingTypesController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.shipping_types');
    }

    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.shipping_types');
    }

    public function postPopup($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        if (! $request->get('shipping_group') && ! $request->get('shipping_individual')) {
            form()->error('At least one shipping method is needed.')->back();
        }

        $this->getCampaign()->update([
            'shipping_group'      => $request->get('shipping_group') ? true : false,
            'shipping_individual' => $request->get('shipping_individual') ? true : false,
        ]);

        return form()->success('Shipping Type Information Saved')->back();
    }
}
