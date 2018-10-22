<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;
use Illuminate\Http\Request;

class ImportantDatesController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.important_dates.important_dates_block');
    }

    /**
     * @param int $id
     * @return string
     * @throws \Throwable
     */
    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('v3.customer.dashboard.modules.important_dates.important_dates_popup');
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
            'rush' => 'in:yes,no',
        ]);

        $this->getCampaign()->update([
            'rush' => $request->get('rush') == 'yes',
        ]);

        form()->success('Successfully submitted');

        return form()->back();
    }
}
