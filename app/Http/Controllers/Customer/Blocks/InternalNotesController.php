<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;

class InternalNotesController extends BlockController
{
    public function block()
    {
        $this->force(['admin', 'support', 'designer', 'junior_designer', 'art_director']);

        return $this->view('blocks.block.internal_notes');
    }
}
