<?php

namespace App\CampaignViews;

use App\Contracts\CampaignViews\CampaignView;
use App\Http\Controllers\Customer\Blocks\CampaignInformationController;
use App\Http\Controllers\Customer\Blocks\CustomerInformationController;
use App\Http\Controllers\Customer\Blocks\DesignerCountdownController;
use App\Http\Controllers\Customer\Blocks\FulfillmentNotesController;
use App\Http\Controllers\Customer\Blocks\GarmentInformationController;
use App\Http\Controllers\Customer\Blocks\MessagesController;
use App\Http\Controllers\Customer\Blocks\NotesController;
use App\Http\Controllers\Customer\Blocks\PaymentDetailsController;
use App\Http\Controllers\Customer\Blocks\ShippingInformationController;
use App\Http\Controllers\Customer\Blocks\ShippingTypesController;
use App\Http\Controllers\Customer\Blocks\SourceDesignController;
use App\Http\Controllers\Customer\Blocks\UnclaimedCampaignController;
use App\Http\Controllers\Customer\Blocks\UploadPrintFilesController;
use App\Http\Controllers\Customer\Blocks\UploadProofsController;
use App\Models\Campaign;

class DirectorCampaignView extends CampaignView
{
    /**
     * DirectorCampaignView constructor.
     *
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->setCampaign($campaign);
        $this->force('director');
        clear_access_tokens();

        $this->addLeft(\App::make(GarmentInformationController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => true,

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

        $this->addRight(\App::make(SourceDesignController::class)->configure($campaign->id, [
            'view' => $campaign->source_design_id != null,
            'edit' => false,
        ]));

        $this->addRight(\App::make(DesignerCountdownController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addRight(\App::make(UnclaimedCampaignController::class)->configure($campaign->id, [
            'view' => ! $campaign->artwork_request->designer_id && in_array($campaign->state, ['awaiting_design', 'awaiting_approval', 'revision_requested']),
            'edit' => true,
        ]));

        $this->addRight(\App::make(UploadPrintFilesController::class)->configure($campaign->id, [
            'view'     => in_array($campaign->state, [
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
            'edit'     => in_array($campaign->state, [
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
            'evaluate' => false,
            'date'     => false,
            'shipping' => false,
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
            'seePaymentTableView' => true,
        ], ['cancel' => false]));

        $this->addRight(\App::make(UploadProofsController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => ! in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
        ]));

        $this->addRight(\App::make(CampaignInformationController::class)->configure($campaign->id, [
            'view'                    => true,
            'edit'                    => false,
            'designInstructions'      => true,
            'fulfillmentInstructions' => false,
            'supplier'                => false,
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

        $this->addRight(\App::make(NotesController::class)->configure($campaign->id, [
            'view'     => true,
            'edit'     => true,
            'collapse' => true,
        ]));

        $this->addRight(\App::make(FulfillmentNotesController::class)->configure($campaign->id, [
            'view'     => true,
            'edit'     => true,
            'collapse' => true,
        ]));

        $this->addRight(\App::make(MessagesController::class)->configure($campaign->id, [
            'view'    => true,
            'edit'    => true,
            'channel' => 'customer',
        ]));
    }
}
