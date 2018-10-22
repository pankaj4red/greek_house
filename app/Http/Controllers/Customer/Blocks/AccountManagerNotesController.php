<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;
use Illuminate\Http\Request;

class AccountManagerNotesController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.account_manager_notes');
    }

    public function postBlock($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $this->getCampaign()->update([
            'account_manager_notes' => $request->get('account_manager_notes'),
        ]);

        return form()->success('Campaign Account Manager Notes Changed')->back();
    }
}
