<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Events\Campaign\StateManuallyChanged;
use App\Http\Controllers\BlockController;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class ChangeStateController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.change_state');
    }

    public function postBlock($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        /** @var Validator $validator */
        $validator = campaign_repository()->validate($request, ['state']);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $stateText = campaign_state_caption($request->get('state'));
        if ($stateText == null) {
            return form()->error('Unknown State')->back();
        }

        $this->getCampaign()->update([
            'state'                      => $request->get('state'),
            'fulfillment_valid'          => true,
            'fulfillment_invalid_reason' => null,
            'fulfillment_invalid_text'   => null,
        ]);

        event(new StateManuallyChanged($this->getCampaign()->id, $request->get('state')));

        if ($request->has('save')) {
            return form()->success('Campaign State Changed')->back();
        } else {
            return form()->success('Campaign State Changed')->route('dashboard::index');
        }
    }
}
