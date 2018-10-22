<?php

namespace App\CampaignViews;

use App\Contracts\CampaignViews\CampaignView;
use App\Http\Controllers\Customer\Blocks\AccountManagerNotesController;
use App\Http\Controllers\Customer\Blocks\ApproveCampaignController;
use App\Http\Controllers\Customer\Blocks\CampaignInformationController;
use App\Http\Controllers\Customer\Blocks\CustomerInformationController;
use App\Http\Controllers\Customer\Blocks\GarmentInformationController;
use App\Http\Controllers\Customer\Blocks\MessagesController;
use App\Http\Controllers\Customer\Blocks\PaymentDetailsController;
use App\Http\Controllers\Customer\Blocks\ReviewProofsController;
use App\Http\Controllers\Customer\Blocks\ShippingInformationController;
use App\Http\Controllers\Customer\Blocks\ShippingTypesController;
use App\Models\Campaign;

class AccountManagerCampaignView extends CampaignView
{
    /**
     * AccountManagerCampaignView constructor.
     *
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->setCampaign($campaign);
        $this->force('account_manager');
        clear_access_tokens();

        $this->addLeft(\App::make(GarmentInformationController::class)->configure($campaign->id, [
            'view'                    => true,
            'edit'                    => in_array($campaign->state, [
                'on_hold',
                'campus_approval',
                'awaiting_design',
                'awaiting_approval',
                'revision_requested',
                'awaiting_quote',
            ]),
            'designInstructions'      => false,
            'fulfillmentInstructions' => false,
            'supplier'                => false,
        ]));

        $this->addLeft(\App::make(CustomerInformationController::class)->configure($campaign->id, [
            'view'                 => true,
            'edit'                 => in_array($campaign->state, [
                'on_hold',
                'campus_approval',
                'awaiting_design',
                'awaiting_approval',
                'revision_requested',
                'awaiting_quote',
            ]),
            'showInformationPopup' => false,
        ], ['show_information' => false]));

        $this->addLeft(\App::make(ShippingInformationController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => in_array($campaign->state, [
                'on_hold',
                'campus_approval',
                'awaiting_design',
                'awaiting_approval',
                'revision_requested',
                'awaiting_quote',
            ]),
        ]));

        $this->addLeft(\App::make(ShippingTypesController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addRight(\App::make(ApproveCampaignController::class)->configure($campaign->id, [
            'view' => in_array($campaign->state, ['campus_approval']),
            'edit' => true,
        ]));

        $this->addRight(\App::make(PaymentDetailsController::class)->configure($campaign->id, [
            'view'                => in_array($campaign->state, [
                'collecting_payment',
                'processing_payment',
                'fulfillment_ready',
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
            'edit'                => in_array($campaign->state, ['collecting_payment']),
            'payment'             => in_array($campaign->state, ['collecting_payment']),
            'date'                => false,
            'cancel'              => false,
            'seePaymentTableView' => true,
        ], ['cancel' => false]));

        $this->addRight(\App::make(ReviewProofsController::class)->configure($campaign->id, [
            'view' => count($campaign->artwork_request->proofs) > 0 || $campaign->artwork_request->design_minutes != 0,
            'edit' => in_array($campaign->state, ['awaiting_approval', 'campus_approval']),
        ]));

        $this->addRight(\App::make(CampaignInformationController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => in_array($campaign->state, [
                'on_hold',
                'campus_approval',
                'awaiting_design',
                'awaiting_approval',
                'revision_requested',
                'awaiting_quote',
            ]),
        ], [
            'showPaymentType' => in_array($campaign->state, [
                'awaiting_quote',
                'collecting_payment',
                'processing_payment',
                'fulfillment_ready',
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
            'editCloseDate'   => false,
        ]));

        $campaign->load('user');
        $this->addRight(\App::make(AccountManagerNotesController::class)->configure($campaign->id, [
            'view' => $campaign->user->account_manager_id != null,
            'edit' => true,
        ]));

        $this->addRight(\App::make(MessagesController::class)->configure($campaign->id, [
            'view'    => true,
            'edit'    => true,
            'channel' => 'customer',
        ]));
    }
}
