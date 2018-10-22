<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;
use Illuminate\Http\Request;

class FulfillmentNotesController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.fulfillment_notes.fulfillment_notes_block');
    }

    /**
     * @param int     $id
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse|string
     */
    public function postBlock($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $this->force(['admin', 'designer', 'decorator']);

        $this->getCampaign()->update([
            'fulfillment_notes' => $request->get('fulfillment_notes'),
        ]);

        return form()->success('Campaign Fulfillment Notes Changed')->back();
    }
}
