<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;
use Illuminate\Http\Request;

class ShippingTypesController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.shipping_types.shipping_types_block');
    }

    /**
     * @param int $id
     * @return string
     * @throws \Throwable
     */
    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('v3.customer.dashboard.modules.shipping_types.shipping_types_popup');
    }

    /**
     * @param int     $id
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postPopup($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        if (! $request->get('shipping_group') && ! $request->get('shipping_individual')) {
            return form()->error('At least one shipping method is needed.')->back();
        }

        $this->getCampaign()->update([
            'shipping_group'      => $request->get('shipping_group') ? true : false,
            'shipping_individual' => $request->get('shipping_individual') ? true : false,
        ]);

        return form()->success('Shipping Type Information Saved')->back();
    }
}
