<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;
use Illuminate\Http\Request;

class EmbellishmentController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.embellishment');
    }

    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.embellishment');
    }

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
