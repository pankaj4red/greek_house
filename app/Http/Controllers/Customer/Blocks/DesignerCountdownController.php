<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;

class DesignerCountdownController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.designer_countdown');
    }
}
