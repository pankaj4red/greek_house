<?php
/**
 * Created by PhpStorm.
 * User: Asma Shaheen
 * Date: 6/4/2018
 * Time: 11:43 AM
 */

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;
use Illuminate\Http\Request;

class FulfillmentNotesController extends BlockController
{
    public function block()
    {
        $this->force(['admin', 'support', 'designer', 'decorator', 'art_director']);

        return $this->view('blocks.block.fulfillment_notes');
    }

    public function postBlock($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $this->force(['admin', 'support', 'designer', 'decorator']);

        $this->getCampaign()->update([
            'fulfillment_notes' => $request->get('fulfillment_notes'),
        ]);

        return form()->success('Campaign Fulfillment Notes Changed')->back();
    }
}
