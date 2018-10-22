<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;
use Illuminate\Http\Request;

class NotesController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.notes.notes_block');
    }

    /**
     * @param int     $id
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse|string
     */
    public function postBlock($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $this->force(['admin', 'support', 'designer', 'junior_designer', 'art_director']);

        $this->getCampaign()->update([
            'notes' => $request->get('notes'),
        ]);

        return form()->success('Campaign Notes Changed')->back();
    }
}
