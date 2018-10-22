<?php

namespace App\CampaignViews;

use App\Contracts\CampaignViews\CampaignView;
use App\Http\Controllers\Customer\Blocks\CampaignInformationController;
use App\Http\Controllers\Customer\Blocks\CustomerInformationController;
use App\Http\Controllers\Customer\Blocks\GarmentInformationController;
use App\Http\Controllers\Customer\Blocks\MessagesController;
use App\Http\Controllers\Customer\Blocks\PaymentDetailsController;
use App\Http\Controllers\Customer\Blocks\ReviewProofsController;
use App\Http\Controllers\Customer\Blocks\ShippingInformationController;
use App\Http\Controllers\Customer\Blocks\ShippingTypesController;
use App\Models\Campaign;

class PublicCampaignView extends CampaignView
{
    /**
     * PublicCampaignView constructor.
     *
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->setCampaign($campaign);
        $this->force('public');
        clear_access_tokens();

        $this->addLeft(\App::make(GarmentInformationController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,

        ]));

        $this->addLeft(\App::make(CustomerInformationController::class)->configure($campaign->id, [
            'view'                 => true,
            'edit'                 => false,
            'showInformationPopup' => false,
        ], ['show_information' => false]));

        $this->addLeft(\App::make(ShippingInformationController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addLeft(\App::make(ShippingTypesController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
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
            'edit'                => false,
            'payment'             => in_array($campaign->state, ['collecting_payment']),
            'date'                => false,
            'cancel'              => false,
            'seePaymentTableView' => false,
        ], ['cancel' => false]));

        $this->addRight(\App::make(ReviewProofsController::class)->configure($campaign->id, [
            'view' => count($campaign->getCurrentArtwork()->proofs) > 0 || $campaign->artwork_request->design_minutes != 0,
            'edit' => false,
        ]));

        $this->addRight(\App::make(CampaignInformationController::class)->configure($campaign->id, [
            'view'                    => true,
            'edit'                    => false,
            'designInstructions'      => false,
            'fulfillmentInstructions' => false,
            'supplier'                => false,
        ], [
            'showPaymentType' => false,
            'editCloseDate'   => false,
        ]));

        $this->addRight(\App::make(MessagesController::class)->configure($campaign->id, [
            'view'    => true,
            'edit'    => false,
            'channel' => 'customer',
        ]));
    }
}
