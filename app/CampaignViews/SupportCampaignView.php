<?php

namespace App\CampaignViews;

use App\Contracts\CampaignViews\CampaignView;
use App\Http\Controllers\Customer\Blocks\AccountManagerNotesController;
use App\Http\Controllers\Customer\Blocks\AdditionalInformationController;
use App\Http\Controllers\Customer\Blocks\CampaignInformationController;
use App\Http\Controllers\Customer\Blocks\ChangeStateController;
use App\Http\Controllers\Customer\Blocks\CustomerInformationController;
use App\Http\Controllers\Customer\Blocks\CustomerPromiseController;
use App\Http\Controllers\Customer\Blocks\DesignerCountdownController;
use App\Http\Controllers\Customer\Blocks\EmbellishmentController;
use App\Http\Controllers\Customer\Blocks\FulfillmentActionsController;
use App\Http\Controllers\Customer\Blocks\FulfillmentNotesController;
use App\Http\Controllers\Customer\Blocks\GarmentInformationController;
use App\Http\Controllers\Customer\Blocks\InternalNotesController;
use App\Http\Controllers\Customer\Blocks\MessagesController;
use App\Http\Controllers\Customer\Blocks\NotesController;
use App\Http\Controllers\Customer\Blocks\PaymentDetailsController;
use App\Http\Controllers\Customer\Blocks\ProvideQuoteController;
use App\Http\Controllers\Customer\Blocks\SendPrinterController;
use App\Http\Controllers\Customer\Blocks\ShippingInformationController;
use App\Http\Controllers\Customer\Blocks\ShippingTypesController;
use App\Http\Controllers\Customer\Blocks\SourceDesignController;
use App\Http\Controllers\Customer\Blocks\UploadPrintFilesController;
use App\Http\Controllers\Customer\Blocks\UploadProofsController;
use App\Models\Campaign;

class SupportCampaignView extends CampaignView
{
    /**
     * SupportCampaignView constructor.
     *
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->setCampaign($campaign);
        $this->force('support');
        clear_access_tokens();

        $this->addLeft(\App::make(ChangeStateController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => true,
        ]));

        $this->addLeft(\App::make(CustomerPromiseController::class)->configure($campaign->id, [
            'view'                      => true,
            'edit'                      => true,
            'showRequestedDeliveryDate' => true,
            'showDaysInTransit'         => false,
        ]));

        $this->addLeft(\App::make(GarmentInformationController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => true,
        ]));

        $this->addLeft(\App::make(EmbellishmentController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => true,
        ]));

        $this->addLeft(\App::make(CustomerInformationController::class)->configure($campaign->id, [
            'view'                 => true,
            'edit'                 => true,
            'showInformationPopup' => true,
        ], ['show_information' => true]));

        $this->addLeft(\App::make(ShippingInformationController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => true,
        ]));

        $this->addLeft(\App::make(ShippingTypesController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => true,
        ]));

        $this->addLeft(\App::make(AdditionalInformationController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => true,
        ]));

        $this->addRight(\App::make(SourceDesignController::class)->configure($campaign->id, [
            'view' => $campaign->source_design_id != null,
            'edit' => false,
        ]));

        $this->addRight(\App::make(DesignerCountdownController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addRight(\App::make(FulfillmentActionsController::class)->configure($campaign->id, [
            'view' => in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
            'edit' => in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
            ]),
        ]));

        $this->addRight(\App::make(SendPrinterController::class)->configure($campaign->id, [
            'view'   => in_array($campaign->state, [
                'fulfillment_ready',
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
            'edit'   => in_array($campaign->state, [
                'fulfillment_ready',
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
            'review' => in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
        ], [
            'show_cost' => true,
            'review'    => in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
            'download'  => in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
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
            'date'     => in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
            ]),
            'shipping' => in_array($campaign->state, [
                'fulfillment_ready',
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
            ]),
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
            'date'                => in_array($campaign->state, [
                    'fulfillment_validation',
                    'printing',
                    'shipped',
                    'delivered',
                    'cancelled',
                ]) && $campaign->garment_arrival_date,
            'cancel'              => true,
            'seePaymentTableView' => true,
        ], ['cancel' => true]));

        $this->addRight(\App::make(ProvideQuoteController::class)->configure($campaign->id, [
            'view' => in_array($campaign->state, ['awaiting_quote', 'collecting_payment', 'processing_payment']),
            'edit' => in_array($campaign->state, ['awaiting_quote', 'collecting_payment', 'processing_payment']),
        ]));

        $this->addRight(\App::make(UploadProofsController::class)->configure($campaign->id, [
            'view' => ! in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
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
            'edit'                    => true,
            'designInstructions'      => false,
            'fulfillmentInstructions' => true,
            'supplier'                => true,
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
            'editCloseDate'   => true,
        ]));

        $this->addRight(\App::make(InternalNotesController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => true,
        ]));

        $this->addRight(\App::make(NotesController::class)->configure($campaign->id, [
            'view'     => true,
            'edit'     => true,
            'collapse' => false,
        ]));
        $this->addRight(\App::make(FulfillmentNotesController::class)->configure($campaign->id, [
            'view'     => true,
            'edit'     => true,
            'collapse' => false,
        ]));

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
