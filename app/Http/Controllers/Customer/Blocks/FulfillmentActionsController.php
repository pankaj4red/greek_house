<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Events\Campaign\FulfillmentIssueReported;
use App\Events\Campaign\FulfillmentIssueSolved;
use App\Events\Campaign\PrintingDateUpdated;
use App\Http\Controllers\BlockController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FulfillmentActionsController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.fulfillment_actions');
    }

    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.fulfillment_actions__report_issue');
    }

    public function postPopup($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        form($request)->validate([
            'reason'      => 'required|in:Artwork,Garment,Other',
            'description' => 'required',
        ]);

        $this->getCampaign()->update([
            'fulfillment_valid'          => false,
            'fulfillment_invalid_reason' => $request->get('reason'),
            'fulfillment_invalid_text'   => $request->get('description'),
        ]);

        add_comment_fulfillment($id, 'Issue Reported: '.$request->get('reason')."\r\n".$request->get('description'), \Auth::user()->id);
        event(new FulfillmentIssueReported($this->getCampaign()->id, $request->get('reason')));

        return form()->success('Issue Reported')->back();
    }

    public function getIssueSolved($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.fulfillment_actions__issue_solved');
    }

    public function postIssueSolved($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $this->getCampaign()->update([
            'fulfillment_valid'          => true,
            'fulfillment_invalid_reason' => null,
            'fulfillment_invalid_text'   => null,
        ]);

        add_comment_fulfillment($id, 'Issue Reported as Solved'."\r\n"."Please update the print date if it has changed", \Auth::user()->id);
        event(new FulfillmentIssueSolved($this->getCampaign()->id));

        return form()->success('Issue Reported as Solved')->back();
    }

    public function postFulfillmentState($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        if (! in_array($this->getCampaign()->state, ['fulfillment_validation', 'printing', 'shipped'])) {
            return form()->error('Campaign not in correct state')->back();
        }

        form($request)->validate([
            'fulfillment_state' => 'required|in:printing,shipped,delivered',
        ]);

        switch ($request->get('fulfillment_state')) {
            case 'printing':
                $this->getCampaign()->update([
                    'state' => 'printing',
                ]);
                break;
            case 'shipped':
                $this->getCampaign()->update([
                    'state' => 'shipped',
                ]);
                break;
            case 'delivered':
                $this->getCampaign()->update([
                    'state' => 'delivered',
                ]);
                break;
            default:
                return form()->success('Invalid State')->back();
        }

        add_comment_fulfillment($id, 'Fulfillment state: '.$request->get('fulfillment_state'), \Auth::user()->id);

        return form()->success('Fulfillment state set')->back();
    }

    public function getMarkShipped($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.fulfillment_actions__mark_shipped');
    }

    public function postMarkShipped($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $form = form($request)->withRules([
            'tracking_code'  => 'max:255',
            'scheduled_date' => 'date|date_year|nullable',
            'invoice_total'  => 'nullable|regex:/[\d]+[\.]*[\d]{0,2}/',
        ]);
        $form->validate();

        $invoiceTotal = 0;
        if ($request->get('invoice_total')) {
            $invoiceTotal = mb_str_replace('$', '', $request->get('invoice_total'));
            if (! $invoiceTotal) {
                $invoiceTotal = 0;
            }
        }

        $this->getCampaign()->update([
            'tracking_code'  => $request->get('tracking_code'),
            'scheduled_date' => $request->get('scheduled_date') ? date('Y-m-d', strtotime($request->get('scheduled_date'))) : null,
            'invoice_total'  => $invoiceTotal,
        ]);

        if ($this->getCampaign()->state == 'printing') {
            $this->getCampaign()->setShipped();
            if ($this->getCampaign()->tracking_code) {
                $this->getCampaign()->setOrdersTrackingCode();
                $this->getCampaign()->notificationTrackingCode();
            }
            if ($this->getCampaign()->scheduled_date) {
                $this->getCampaign()->notificationScheduledDate();
            }

            add_comment_fulfillment($id, 'Marked as Shipped', \Auth::user()->id);
        }

        return $form->success('Shipping Details Saved')->back();
    }

    public function postFulfillmentPrintingDate($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        form($request)->validate([
            'printing_date' => 'required|date',
        ]);

        $triggerEvent = false;
        if ($this->getCampaign()->state == 'fulfillment_validation' && $this->getCampaign()->fulfillment_valid) {
            $this->getCampaign()->update([
                'state' => 'printing',
            ]);
            $triggerEvent = true;
        }
        $oldPrintingDate = $this->getCampaign()->printing_date;
        $this->getCampaign()->update([
            'printing_date' => date('Y-m-d', strtotime($request->get('printing_date'))),
        ]);

        if ($oldPrintingDate != $this->getCampaign()->fresh()->printing_date) {
            $triggerEvent = true;
        }

        if ($triggerEvent) {
            add_comment_fulfillment($id, 'Printing date: '.Carbon::parse($request->get('printing_date'))->format('m/d/Y'), \Auth::user()->id);
            event(new PrintingDateUpdated($this->getCampaign()->id, Carbon::parse($request->get('printing_date'))->format('Y-m-d'), $oldPrintingDate));
        }

        return form()->success('Printing date set')->back();
    }
}
