<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;
use Illuminate\Http\Request;

class NotesController extends BlockController
{
    public function block()
    {
        $this->force(['admin', 'support', 'designer', 'junior_designer', 'art_director']);

        return $this->view('blocks.block.notes');
    }

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
