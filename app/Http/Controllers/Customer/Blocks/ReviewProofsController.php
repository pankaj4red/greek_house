<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Events\Campaign\DeliverEarlier;
use App\Events\Campaign\DeliveryDateHelp;
use App\Events\Campaign\DesignApproved;
use App\Events\Campaign\RevisionRequested;
use App\Http\Controllers\BlockController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReviewProofsController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.review_proofs');
    }

    public function postApproveMessage($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');
        $form = form($request)->withRules([
            'payment_type'    => 'required|in:Group,Check,Individual',
            'collection_date' => 'required|date',
        ]);
        $form->validate();
        $collectionDate = $request->input('collection_date');

        if ($this->getCampaign()->getCurrentArtwork()->design_type == 'screen') {
            $deliveryDate = add_business_days_to_date($collectionDate, 10);
        } else {
            $deliveryDate = add_business_days_to_date($collectionDate, 12);
        }
        $this->getCampaign()->update([
            'state'                => 'awaiting_quote',
            'payment_type'         => $request->input('payment_type'),
            'date'                 => Carbon::parse($deliveryDate)->format('Y-m-d'),
            'sizes_collected_date' => Carbon::parse($request->input('collection_date'))->format('Y-m-d'),
        ]);

        $message1 = "Thanks for approving the design. As we mentioned, if you get us the sizes by ".$request->input('collection_date').", you can expect the order to be delivered by ".$deliveryDate.".";
        $message1 .= " If you need your order sooner, let us know and we’ll make sure to help accommodate!";

        return json_encode([
            'success'  => true,
            'message1' => $message1,
        ]);
    }

    public function getApproveDesign($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.review_proofs___approve_design');
    }

    public function postApproveDesign($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');
        event(new DesignApproved($this->getCampaign()->id));
        if ($request->input('delivery_type') == 'normal') {

            $form = form($request)->withRules([
                'payment_type'    => 'required|in:Group,Check,Individual',
                'collection_date' => 'required|date',
            ]);
            $form->validate();

            $collectionDate = $request->input('collection_date');

            if ($this->getCampaign()->getCurrentArtwork()->design_type == 'screen') {
                $deliveryDate = add_business_days_to_date($collectionDate, 10);
            } else {
                $deliveryDate = add_business_days_to_date($collectionDate, 12);
            }
            $message = "Hey ".$this->getCampaign()->user->getFullName()."!\n";
            $message .= "Thanks for approving the design. As we mentioned, if you get us the sizes by ".$request->input('collection_date').", you can expect the order to be delivered by ".$deliveryDate.".";
            $message .= " If you need it sooner, let us know if you have any questions or concerns!\n\nThanks, \nGreek House";
            $messageForPopup = "Thanks for letting us know when you’ll have sizes collected by. We’ll let you know as soon as Greek Licensing approves the design. Typically this takes 24-48 hours. ";
            add_comment($id, $message, null);
        } else {
            $form = form($request)->withRules([
                'payment_type'    => 'required|in:Group,Check,Individual',
                'collection_date' => 'required|date',
                'scheduled_date'  => 'required|date',
            ]);
            $form->validate();
            $deliveryDate = $request->get('scheduled_date');
            $today = new \DateTime();
            $collectionDate = $today->format('Y-m-d');
            if ($request->input('email_type') == 'help') {
                $collectionDate = subtract_business_days_from_date($deliveryDate, 10);
            }
            $this->getCampaign()->update([
                'state'                => 'awaiting_quote',
                'date'                 => Carbon::parse($deliveryDate)->format('Y-m-d'),
                'sizes_collected_date' => Carbon::parse($collectionDate)->format('Y-m-d'),
                'payment_date_type'    => $request->get('delivery_type'),

            ]);
            if ($request->input('email_type') == 'urgent') {
                event(new DeliverEarlier($this->getCampaign()->id));
                $collectionDate = 'TODAY';
            } else {
                event(new DeliveryDateHelp($this->getCampaign()->id));
            }
            $message = "Hey Greek House!\n\n I need my order by ".$deliveryDate.", and I could get the sizes to you by ".$collectionDate." . Can you help? \n";
            $message .= " \nThanks, \n".\Auth::user()->getFullName();
            $messageForPopup = "Thanks for letting us know when you need your order by. We’ll reach out to make sure you get your order in on time!
If you need it even sooner, please email us at support@greekhouse.org with subject line: URGENT DELIVERY
 ";
            add_comment($id, $message, \Auth::user()->id);
        }
        $htmlMessage = '<div class="row"> <div class="col-md-12"><p class="text-center">';
        $htmlMessage .= $messageForPopup;
        $htmlMessage .= '</p></div></div>';
        $htmlMessage .= '<div class="action-row text-center">
                <button type="button" name="save"  class="btn btn-primary" id="ok_payment"> OK</button></div>';

        return json_encode([
            'success' => true,
            'message' => $htmlMessage,
        ]);
    }

    public function getRequestRevision($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.review_proofs___request_revision');
    }

    public function postRequestRevision($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        if (! in_array($this->getCampaign()->state, ['awaiting_approval'])) {
            return form()->error('Campaign not awaiting for approval.')->back();
        }

        form($request)->validate([
            'revision_text' => 'required',
        ]);

        $this->getCampaign()->artwork_request->update([
            'revision_text'  => $request->get('revision_text'),
            'revision_count' => $this->getCampaign()->artwork_request->revision_count + 1,
        ]);
        $this->getCampaign()->update([
            'state' => 'revision_requested',
        ]);
        event(new RevisionRequested($this->getCampaign()->id));
        add_comment($id, \Auth::user()->getFullName().' has requested a revision for '.$this->getCampaign()->name."\r\n".$request->get('revision_text'));

        return form()->success('A revision has been requested')->back();
    }
}
