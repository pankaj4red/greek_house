<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;

class SourceDesignController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.source_design');
    }
}
