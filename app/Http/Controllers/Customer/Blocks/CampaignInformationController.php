<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CampaignInformationController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.campaign_information');
    }

    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.campaign_information');
    }

    public function postPopup($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $form = form($request)->withRules([
            'estimated_quantity' => 'required',
            'design_type'        => 'required|in:screen,embroidery',
            'promo_code'         => 'max:255',
            'budget'             => 'required|in:yes,no',
            'budget_range'       => '',
            'date'               => $request->get('flexible') == 'yes' ? 'nullable|date' : 'required|date',
            'flexible'           => 'required',
        ]);

        if (! \Auth::user()->isType(['admin', 'support']) && $request->get('flexible') == 'no') {
            if (Carbon::parse($request->get('date')) < Carbon::parse('+11 days')) {
                $form->error('Selected date must be at least 11 days from now.');
            }
        }
        if (\Auth::user()->isType(['admin', 'support'])) {
            $form->withRules([
                'design_style_preference' => 'required',
            ]);

            if ($request->has('designer_id') && $request->get('designer_id') > 0) {
                $form->withRules([
                    'designer_id' => 'required|integer',
                ]);
            }
            if ($request->has('print_front')) {
                $form->withRules([
                    'print_front_colors'      => 'required',
                    'print_front_description' => 'required',
                ]);
            }
            if ($request->has('print_back')) {
                $form->withRules([
                    'print_back_colors'      => 'required',
                    'print_back_description' => 'required',
                ]);
            }
            if ($request->has('print_pocket')) {
                $form->withRules([
                    'print_pocket_colors'      => 'required',
                    'print_pocket_description' => 'required',
                ]);
            }
            if ($request->has('print_sleeve')) {
                $form->withRules([
                    'print_sleeve_colors'      => 'required',
                    'print_sleeve_description' => 'required',
                    'print_sleeve_preferred'   => 'required',
                ]);
            }
            if (! $request->has('print_front') && ! $request->has('print_pocket') && ! $request->has('print_back') && ! $request->has('print_sleeve')) {
                $form->error('At least one print location is needed');
            }
        }

        if ($request->get('budget') == 'yes') {
            $form->withRules([
                'budget_range' => 'required',
            ]);
        }

        $requestedDate = Carbon::parse($request->get('date'));
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

        $form->validate();

        $campaign = $this->getCampaign();
        $campaign->date = $request->get('date') ? Carbon::parse($request->get('date')) : null;

        $artworkRequest = $campaign->artwork_request;
        if (\Auth::user()->isType(['admin', 'support'])) {
            $artworkRequest->print_front = $request->has('print_front') ? true : false;
            $artworkRequest->print_pocket = $request->has('print_pocket') ? true : false;
            $artworkRequest->print_back = $request->has('print_back') ? true : false;
            $artworkRequest->print_sleeve = $request->has('print_sleeve') ? true : false;
            $artworkRequest->print_front_description = $request->get('print_front_description');
            $artworkRequest->print_pocket_description = $request->get('print_pocket_description');
            $artworkRequest->print_back_description = $request->get('print_back_description');
            $artworkRequest->print_sleeve_description = $request->get('print_sleeve_description');
            $artworkRequest->print_sleeve_preferred = $request->get('print_sleeve_preferred');
            $artworkRequest->print_front_colors = $request->get('print_front_colors');
            $artworkRequest->print_pocket_colors = $request->get('print_pocket_colors');
            $artworkRequest->print_back_colors = $request->get('print_back_colors');
            $artworkRequest->print_sleeve_colors = $request->get('print_sleeve_colors');
            $artworkRequest->designer_id = $request->get('designer_id') ? $request->get('designer_id') : null;
            $artworkRequest->design_style_preference = $request->get('design_style_preference');
        }
        $artworkRequest->design_type = $request->get('design_type');
        $artworkRequest->save();

        if ($campaign->artwork) {
            $artwork = $campaign->artwork;
            $artwork->design_type = $request->get('design_type');
            $artwork->save();
        }

        $campaign->budget = $request->get('budget');
        $campaign->budget_range = $request->get('budget_range');
        $campaign->flexible = $request->get('flexible');
        $campaign->estimated_quantity = estimated_quantity_by_code($request->get('design_type'), $request->get('estimated_quantity'))->code;
        $campaign->promo_code = $request->get('promo_code');
        if ($request->has('close_date')) {
            $campaign->close_date = \Carbon\Carbon::parse($request->get('close_date'))->format('Y-m-d');
        }
        $campaign->save();

        return $form->success('Campaign Information Saved')->back();
    }
}
