<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;
use Illuminate\Http\Request;

class CustomerInformationController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.customer_information.customer_information_block');
    }

    /**
     * @param int $id
     * @return string
     * @throws \Throwable
     */
    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('v3.customer.dashboard.modules.customer_information.customer_information_popup');
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

        $form = form($request)->withRules([
            'contact_first_name' => 'required',
            'contact_last_name'  => 'required',
            'contact_email'      => 'required|email',
            'contact_phone'      => 'required',
            'contact_school'     => 'required',
            'contact_chapter'    => 'required',
        ]);
        $phone = get_phone($request->get('contact_phone'));
        if ($phone == false) {
            $form->error('Contact Phone needs 10 digits');
        }
        $form->validate();

        $this->getCampaign()->update([
            'contact_first_name' => $request->get('contact_first_name'),
            'contact_last_name'  => $request->get('contact_last_name'),
            'contact_email'      => $request->get('contact_email'),
            'contact_phone'      => $phone,
            'contact_school'     => $request->get('contact_school'),
            'contact_chapter'    => $request->get('contact_chapter'),
        ]);

        return $form->success('Customer Information Saved')->back();
    }
}
