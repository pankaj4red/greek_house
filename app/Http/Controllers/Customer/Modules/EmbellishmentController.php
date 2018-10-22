<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;
use Illuminate\Http\Request;

class EmbellishmentController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.embellishment.embellishment_block');
    }

    /**
     * @param int $id
     * @return string
     * @throws \Throwable
     */
    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('v3.customer.dashboard.modules.embellishment.embellishment_popup');
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
            'design_type'       => 'required|in:screen,embroidery',
            'polybag_and_label' => 'required|in:yes,no',
        ]);

        $this->getCampaign()->update([
            'polybag_and_label' => $request->get('polybag_and_label') == 'yes' ? true : false,
        ]);

        $this->getCampaign()->artwork_request->update([
            'design_type' => $request->get('design_type'),
        ]);

        if ($this->getCampaign()->artwork) {
            $this->getCampaign()->artwork->update([
                'design_type' => $request->get('design_type'),
            ]);
        }

        return form()->success('Campaign Embellishment Updated')->back();
    }
}
