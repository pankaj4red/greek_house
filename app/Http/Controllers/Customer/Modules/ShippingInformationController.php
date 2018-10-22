<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;
use Illuminate\Http\Request;

class ShippingInformationController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.shipping_information.shipping_information_block');
    }

    /**
     * @param int $id
     * @return string
     * @throws \Throwable
     */
    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('v3.customer.dashboard.modules.shipping_information.shipping_information_popup');
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

        form($request)->validate([
            'contact_first_name' => 'required|max:255',
            'contact_last_name'  => 'required|max:255',
            'address_line1'      => 'required|max:255',
            'address_line2'      => 'max:255',
            'address_city'       => 'required|max:255',
            'address_state'      => 'required|max:255',
            'address_zip_code'   => 'required|digits:5',
        ]);

        $this->getCampaign()->update([
            'contact_first_name' => $request->get('contact_first_name'),
            'contact_last_name'  => $request->get('contact_last_name'),
            'address_line1'      => $request->get('address_line1'),
            'address_line2'      => $request->get('address_line2'),
            'address_city'       => $request->get('address_city'),
            'address_state'      => $request->get('address_state'),
            'address_zip_code'   => $request->get('address_zip_code'),
        ]);

        return form($request)->success('Shipping Information Saved')->back();
    }
}
