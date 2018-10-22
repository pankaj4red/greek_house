<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Events\Campaign\DeliverEarlier;
use App\Events\Campaign\DeliveryDateHelp;
use App\Events\Campaign\DesignApproved;
use App\Events\Campaign\RevisionRequested;
use App\Forms\ImageUploadHandler;
use App\Http\Controllers\ModuleController;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DesignInformationController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('v3.customer.dashboard.modules.design_information.design_information_block');
    }

    /**
     * @param $id
     * @return string
     * @throws \Throwable
     */
    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        $proofsGeneric = [];
        for ($i = 0; $i < 10; $i++) {
            $proofsGeneric[$i] = new ImageUploadHandler('campaign.update-' . $id, 'proof' . $i);
            $proofsGeneric[$i]->setImageId($this->getCampaign()->getProof('generic', $i) ? $this->getCampaign()->getProof('generic', $i)->file_id : null);
        }
        $proofs['generic'] = [
            'proof0' => $proofsGeneric[0]->getImage(),
            'proof1' => $proofsGeneric[1]->getImage(),
            'proof2' => $proofsGeneric[2]->getImage(),
            'proof3' => $proofsGeneric[3]->getImage(),
            'proof4' => $proofsGeneric[4]->getImage(),
            'proof5' => $proofsGeneric[5]->getImage(),
            'proof6' => $proofsGeneric[6]->getImage(),
            'proof7' => $proofsGeneric[7]->getImage(),
            'proof8' => $proofsGeneric[8]->getImage(),
            'proof9' => $proofsGeneric[9]->getImage(),
        ];

        $proofsProduct = [];
        foreach ($this->getCampaign()->product_colors as $productColor) {
            $proofsProduct[$productColor->id] = (object) [
                'front'    => new ImageUploadHandler('campaign.update-' . $id, 'proof' . $productColor->id . '_front'),
                'back'     => new ImageUploadHandler('campaign.update-' . $id, 'proof' . $productColor->id . '_back'),
                'close_up' => new ImageUploadHandler('campaign.update-' . $id, 'proof' . $productColor->id . '_close_up'),
                'other'    => new ImageUploadHandler('campaign.update-' . $id, 'proof' . $productColor->id . '_other'),
            ];

            $proofsProduct[$productColor->id]->front->setImageId($this->getCampaign()->getProductColorProof($productColor->id, 'front') ? $this->getCampaign()->getProductColorProof($productColor->id, 'front')->file_id : null);
            $proofsProduct[$productColor->id]->front = $proofsProduct[$productColor->id]->front->getImage();

            $proofsProduct[$productColor->id]->back->setImageId($this->getCampaign()->getProductColorProof($productColor->id, 'back') ? $this->getCampaign()->getProductColorProof($productColor->id, 'back')->file_id : null);
            $proofsProduct[$productColor->id]->back = $proofsProduct[$productColor->id]->back->getImage();

            $proofsProduct[$productColor->id]->close_up->setImageId($this->getCampaign()->getProductColorProof($productColor->id, 'close_up') ? $this->getCampaign()->getProductColorProof($productColor->id, 'close_up')->file_id : null);
            $proofsProduct[$productColor->id]->close_up = $proofsProduct[$productColor->id]->close_up->getImage();

            $proofsProduct[$productColor->id]->other->setImageId($this->getCampaign()->getProductColorProof($productColor->id, 'other') ? $this->getCampaign()->getProductColorProof($productColor->id, 'other')->file_id : null);
            $proofsProduct[$productColor->id]->other = $proofsProduct[$productColor->id]->other->getImage();
        }

        $proofs['products'] = $proofsProduct;

        return $this->view('v3.customer.dashboard.modules.design_information.design_information_popup', [
            'proofs' => (object) $proofs,
        ]);
    }

    /**
     * @param int     $id
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse|string
     * @throws \Illuminate\Validation\ValidationException
     * @throws Exception
     */
    public function postPopup($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $proofs = [];
        for ($i = 0; $i < 10; $i++) {
            $imageHandler = new ImageUploadHandler('campaign.update-' . $id, 'proof' . $i, false, 600, 600);
            $result = $imageHandler->post();
            if ($result instanceof RedirectResponse) {
                return $result;
            }
            $proofs[] = (object) [
                'type'             => 'proof_generic',
                'file_id'          => $result['image'],
                'product_color_id' => null,
                'sort'             => $i,
            ];
        }

        foreach ($this->getCampaign()->product_colors as $productColor) {
            foreach (['front', 'back', 'close_up', 'other'] as $position) {
                $imageHandler = new ImageUploadHandler('campaign.update-' . $id, 'proof' . $productColor->id . '_' . $position, false, 600, 600);
                $result = $imageHandler->post();
                if ($result instanceof RedirectResponse) {
                    return $result;
                }
                $proofs[] = (object) [
                    'type'             => 'proof_' . $position,
                    'file_id'          => $result['image'],
                    'product_color_id' => $productColor->id,
                    'sort'             => 0,
                ];
            }
        }

        $form = form($request);
        $minutes = 0;
        if (is_numeric($request->get('design_hours'))) {
            $minutes = $request->get('design_hours') * 60;
        } elseif (preg_match('/^([0-9]+):([0-9]{1,2})$/', $request->get('design_hours'), $matches)) {
            $minutes = ($matches[1] * 60) + $matches[2];
        } else {
            $form->error('Invalid design hours format');
        }
        if ($request->get('design_type') == 'embroidery' && ($request->get('speciality_inks') == 'yes' || $request->get('embellishment_names') == 'yes' || $request->get('embellishment_numbers') == 'yes')) {
            $form->error('Campaigns with Speciality Inks or Embellishment Names/Numbers cannot have a print type of Embroidery');
        }

        $form->validate();

        $artworkRequest = $this->getCampaign()->artwork_request;
        $artworkRequest->update([
            'design_minutes'                    => $minutes,
            'designer_colors_front'             => $request->get('designer_colors_front_list') ? count(explode(',', $request->get('designer_colors_front_list'))) : 0,
            'designer_colors_back'              => $request->get('designer_colors_back_list') ? count(explode(',', $request->get('designer_colors_back_list'))) : 0,
            'designer_colors_sleeve_left'       => $request->get('designer_colors_sleeve_left_list') ? count(explode(',', $request->get('designer_colors_sleeve_left_list'))) : 0,
            'designer_colors_sleeve_right'      => $request->get('designer_colors_sleeve_right_list') ? count(explode(',', $request->get('designer_colors_sleeve_right_list'))) : 0,
            'designer_colors_front_list'        => $request->get('designer_colors_front_list'),
            'designer_colors_back_list'         => $request->get('designer_colors_back_list'),
            'designer_colors_sleeve_left_list'  => $request->get('designer_colors_sleeve_left_list'),
            'designer_colors_sleeve_right_list' => $request->get('designer_colors_sleeve_right_list'),
            'designer_dimensions_front'         => $request->get('designer_dimensions_front'),
            'designer_dimensions_back'          => $request->get('designer_dimensions_back'),
            'designer_dimensions_sleeve_left'   => $request->get('designer_dimensions_sleeve_left'),
            'designer_dimensions_sleeve_right'  => $request->get('designer_dimensions_sleeve_right'),
            'designer_black_shirt'              => $request->get('designer_black_shirt') == 'yes' ? 1 : 0,
            'design_type'                       => $request->get('design_type'),
            'speciality_inks'                   => $request->get('speciality_inks'),
            'embellishment_names'               => $request->get('embellishment_names'),
            'embellishment_numbers'             => $request->get('embellishment_numbers'),
        ]);

        if ($artworkRequest->design_type == 'screen' && $this->getCampaign()->estimated_quantity == '12-23') {
            $this->getCampaign()->update([
                'estimated_quantity' => '24-47',
            ]);
            comment_repository()->create([
                'channel'     => 'customer',
                'campaign_id' => $this->getCampaign()->id,
                'user_id'     => null,
                'body'        => 'Hey ' . $this->getCampaign()->user->first_name . "\n" . 'The minimum quantity of this order increased to 24 pieces because the embellishment changed ' . 'from embroidery to screenprint. Let us know if you have any questions!' . "\n" . '-Greek  House',
                'ip'          => \Request::ip(),
            ]);
        }

        $changed = false;
        foreach ($proofs as $proof) {
            $currentProof = artwork_request_file_repository()->findByArtworkRequestAndType($this->getCampaign()->artwork_request_id, $proof->type, $proof->product_color_id, $proof->sort);
            if ($currentProof && ! $proof->file_id) {
                $changed = true;
                $currentProof->delete();
                continue;
            }
            if ($currentProof && $proof->file_id && $currentProof->file_id != $proof->file_id) {
                $changed = true;
                $currentProof->update([
                    'file_id' => $proof->file_id,
                ]);
                continue;
            }
            if (! $currentProof && $proof->file_id) {
                $changed = true;
                artwork_request_file_repository()->create([
                    'artwork_request_id' => $this->getCampaign()->artwork_request_id,
                    'file_id'            => $proof->file_id,
                    'product_color_id'   => $proof->product_color_id,
                    'sort'               => $proof->sort,
                    'type'               => $proof->type,
                ]);
                continue;
            }
        }

        if ($changed) {
            comment_repository()->create([
                'channel'     => 'customer',
                'campaign_id' => $this->getCampaign()->id,
                'user_id'     => null,
                'body'        => ($artworkRequest->designer_id ? ('Designer ' . $artworkRequest->designer->first_name) : 'Greek House') . ' has uploaded a proof!',
                'ip'          => \Request::ip(),
            ]);
        }

        return form()->success('Proof Information Saved')->back();
    }

    /**
     * @param                          $id
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function getAutoComplete($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $results = pms_color_repository()->autocomplete($request->get('term'));
        $final = [];
        foreach ($results as $result) {
            $final[] = ['id' => $result->code, 'value' => $result->caption . ' (' . $result->code . ')'];
        }

        return json_encode($final);
    }

    /**
     * @param $id
     * @return string
     * @throws \Throwable
     */
    public function getRevision($id)
    {
        (new ImageUploadHandler('uploaded-proof', 'image'))->setImageId(null);
        (new ImageUploadHandler('uploaded-proof', 'image2'))->setImageId(null);
        (new ImageUploadHandler('uploaded-proof', 'image3'))->setImageId(null);

        return $this->view('v3.customer.dashboard.modules.design_information.design_information_revision');
    }

    /**
     * @param         $id
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postRevision($id, Request $request)
    {
        $this->forceCanBeAccessed('approval');

        if (! in_array($this->getCampaign()->state, ['awaiting_approval'])) {
            return form()->error('Campaign not awaiting for approval.')->back();
        }

        $imageHandler = new ImageUploadHandler('uploaded-proof', 'image');
        $result = $imageHandler->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }
        $imageHandler2 = new ImageUploadHandler('uploaded-proof', 'image2');
        $result2 = $imageHandler2->post();
        if ($result2 instanceof RedirectResponse) {
            return $result2;
        }
        $imageHandler3 = new ImageUploadHandler('uploaded-proof', 'image3');
        $result3 = $imageHandler3->post();
        if ($result3 instanceof RedirectResponse) {
            return $result3;
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
        add_comment($this->getCampaign()->id, \Auth::user()->getFullName() . ' has requested a revision for ' . $this->getCampaign()->name . "\r\n" . $request->get('revision_text'), \Auth::user()->id, $result['image']);
        if ($result2['image']) {
            add_comment($this->getCampaign()->id, '', \Auth::user()->id, $result2['image']);
        }
        if ($result3['image']) {
            add_comment($this->getCampaign()->id, '', \Auth::user()->id, $result3['image']);
        }
        $imageHandler->clear();

        return form()->success('A revision has been requested')->back();
    }

    /**
     * @param $id
     * @return string
     * @throws \Throwable
     */
    public function getAccept($id)
    {
        return $this->view('v3.customer.dashboard.modules.design_information.design_information_accept');
    }

    /**
     * @param         $id
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postAccept($id, Request $request)
    {
        $this->forceCanBeAccessed('approval');

        form($request)->validate([
            'collection_date' => 'required|date',
            'payment_type'    => 'required|in:Group,Check,Individual',
            'delivery_date'   => 'nullable|date',
            'message_type'    => 'required|in:close_date,delivery_date',
        ]);

        event(new DesignApproved($this->getCampaign()->id));

        if ($request->get('message_type') == 'close_date') {
            $collectionDate = Carbon::parse($request->get('collection_date'));
            if ($this->getCampaign()->getCurrentArtwork()->design_type == 'screen') {
                $deliveryDate = $collectionDate->copy()->addWeekdays(10);
            } else {
                $deliveryDate = $collectionDate->copy()->addWeekdays(12);
            }

            $this->getCampaign()->update([
                'date'                 => $deliveryDate,
                'sizes_collected_date' => $collectionDate,
                'payment_type'         => $request->get('payment_type'),
                'state'                => 'awaiting_quote',
            ]);

            $comment = "Hey " . $this->getCampaign()->user->getFullName() . "!\n";
            $comment .= "Thanks for approving the design. As we mentioned, if you get us the sizes by " . $collectionDate->format('F j, Y');
            $comment .= ", you can expect the order to be delivered by " . $deliveryDate->format('F j, Y') . ".";
            $comment .= " If you need it sooner, let us know if you have any questions or concerns!\n\nThanks, \nGreek House";
            add_comment($id, $comment, null);
        }

        if ($request->get('message_type') == 'delivery_date') {
            $deliveryDate = Carbon::parse($request->get('delivery_date'));
            if ($this->getCampaign()->getCurrentArtwork()->design_type == 'screen') {
                $collectionDate = $deliveryDate->copy()->subWeekdays(10);
            } else {
                $collectionDate = $deliveryDate->copy()->subWeekdays(12);
            }

            $collectionDateText = $collectionDate->format('F j, Y');
            if ($collectionDate <= Carbon::today()) {
                $collectionDateText = 'TODAY';
                $collectionDate = Carbon::today();
                event(new DeliverEarlier($this->getCampaign()->id));
            } else {
                event(new DeliveryDateHelp($this->getCampaign()->id));
            }

            $this->getCampaign()->update([
                'date'                 => $deliveryDate,
                'sizes_collected_date' => $collectionDate,
                'payment_type'         => $request->get('payment_type'),
                'state'                => 'awaiting_quote',
            ]);

            $comment = "Hey Greek House!\n\n I need my order by " . $deliveryDate->format('F j, Y') . ", and I could get the sizes to you by " . $collectionDateText . " . Can you help? \n";
            $comment .= " \nThanks, \n" . \Auth::user()->getFullName();
            add_comment($id, $comment, \Auth::user()->id);
        }

        return form()->success('Designs have been approved')->back();
    }

    /**
     * @param                          $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeliveryMessage($id, Request $request)
    {
        $this->forceCanBeAccessed('approval');

        if (! $request->get('collection_date')) {
            return response()->json([
                'success' => false,
                'message' => 'Collection Date is required',
            ]);
        }

        if (! $request->get('payment_type')) {
            return response()->json([
                'success' => false,
                'message' => 'Payment Type is required',
            ]);
        }

        $collectionDate = null;
        try {
            $collectionDate = Carbon::parse($request->get('collection_date'));;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Collection Date is invalid',
            ]);
        }

        if (! in_array($request->get('payment_type'), ['Group', 'Check', 'Individual'])) {
            return response()->json([
                'success' => false,
                'message' => 'Payment type is invalid',
            ]);
        }
        $paymentType = $request->get('payment_type');

        if ($request->get('message_type') == 'close_date') {
            // Customer just provided a sizes collected date

            if ($this->getCampaign()->getCurrentArtwork()->design_type == 'screen') {
                $deliveryDate = $collectionDate->copy()->addWeekdays(10);
            } else {
                $deliveryDate = $collectionDate->copy()->addWeekdays(12);
            }

            $message = "Thanks for approving the design. As we mentioned, if you get us the sizes by " . $collectionDate->format('F j, Y');
            $message .= ", you can expect the order to be delivered by " . $deliveryDate->format('F j, Y') . ".";
            $message .= " If you need your order sooner, let us know and we’ll make sure to help accommodate!";

            return json_encode([
                'success' => true,
                'message' => $message,
            ]);
        }

        if ($request->get('message_type') == 'delivery_date') {
            // Customer just provided a delivery date
            if (! $request->get('delivery_date')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Delivery Date is required',
                ]);
            }

            $deliveryDate = null;
            try {
                $deliveryDate = Carbon::parse($request->get('delivery_date'));;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Delivery Date is invalid',
                ]);
            }

            if ($this->getCampaign()->getCurrentArtwork()->design_type == 'screen') {
                $collectionDate = $deliveryDate->copy()->subWeekdays(10);
            } else {
                $collectionDate = $deliveryDate->copy()->subWeekdays(12);
            }

            $collectionDateText = $collectionDate->format('F j, Y');
            if ($collectionDate <= Carbon::today()) {
                $collectionDateText = 'TODAY';
                $collectionDate = Carbon::today();
            }

            $message = 'In order to get your order delivered to you by ' . $deliveryDate->format('F j, Y') . ', we need to get sizes by ' . $collectionDateText;
            $message .= '. Can you guarantee that sizes will be submitted by this date?';

            return json_encode([
                'success' => true,
                'message' => $message,
            ]);
        }

        return json_encode([
            'success' => false,
            'message' => 'Invalid message type',
        ]);
    }
}
