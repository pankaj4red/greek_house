<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerPromiseController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.customer_promise');
    }

    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.customer_promise');
    }

    public function postPopup($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $form = form($request)->withRules([
            'rush'     => 'required',
            'date'     => $request->get('flexible') == 'yes' ? 'date|nullable' : 'required|date',
            'flexible' => 'required',
        ]);
        $requestedDate = Carbon::parse($request->get('date'));
        if (! \Auth::user()->isType(['admin', 'support'])) {
            if ($requestedDate != $this->getCampaign()->date && $this->getCampaign()->date != null && $request->get('flexible') == 'no') {
                if (! in_array($this->getCampaign()->state, [
                    'on_hold',
                    'campus_approval',
                    'awaiting_design',
                    'awaiting_approval',
                    'revision_requested',
                    'awaiting_quote',
                    'collecting_payment',
                ])) {
                    $form->error('Campaign due date cannot be changed after payment has started');
                } elseif ($requestedDate < $this->getCampaign()->date) {
                    $form->error('New due date cannot be set to earlier than the current due date');
                }
            }
        }

        $form->validate();

        $this->getCampaign()->update([
            'flexible' => $request->get('flexible'),
            'rush'     => $request->get('rush') == 'yes' ? true : false,
            'date'     => $request->get('date') ? Carbon::parse($request->get('date')) : null,
        ]);

        return $form->success('Customer Promise Updated')->back();
    }
}
