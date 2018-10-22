<?php

namespace App\CampaignViews;

use App\Contracts\CampaignViews\CampaignView;
use App\Http\Controllers\Customer\Blocks\CustomerPromiseController;
use App\Http\Controllers\Customer\Blocks\EmbellishmentController;
use App\Http\Controllers\Customer\Blocks\FulfillmentActionsController;
use App\Http\Controllers\Customer\Blocks\FulfillmentNotesController;
use App\Http\Controllers\Customer\Blocks\GarmentInformationController;
use App\Http\Controllers\Customer\Blocks\MessagesController;
use App\Http\Controllers\Customer\Blocks\PaymentDetailsController;
use App\Http\Controllers\Customer\Blocks\ReviewProofsController;
use App\Http\Controllers\Customer\Blocks\SendPrinterController;
use App\Http\Controllers\Customer\Blocks\ShippingInformationController;
use App\Http\Controllers\Customer\Blocks\ShippingTypesController;
use App\Http\Controllers\Customer\Blocks\UploadPrintFilesController;
use App\Models\Campaign;

class DecoratorCampaignView extends CampaignView
{
    /**
     * DecoratorCampaignView constructor.
     *
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->setCampaign($campaign);
        $this->force('decorator');
        clear_access_tokens();

        $this->addLeft(\App::make(CustomerPromiseController::class)->configure($campaign->id, [
            'view'                      => true,
            'edit'                      => false,
            'showRequestedDeliveryDate' => true,
            'showDaysInTransit'         => true,
        ]));

        $this->addLeft(\App::make(GarmentInformationController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,

        ]));

        $this->addLeft(\App::make(EmbellishmentController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addLeft(\App::make(ShippingInformationController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addLeft(\App::make(ShippingTypesController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addRight(\App::make(FulfillmentActionsController::class)->configure($campaign->id, [
            'view'   => in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
            'edit'   => in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
            ]),
            'issues' => in_array($campaign->state, [
                'fulfillment_validation',
            ]),
        ]));

        $this->addRight(\App::make(SendPrinterController::class)->configure($campaign->id, [
            'view'   => in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
            'edit'   => false,
            'review' => in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
        ], [
            'review'   => in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
            'download' => in_array($campaign->state, [
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
            'edit'     => false,
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
        ], [
            'evaluate' => in_array($campaign->state, ['fulfillment_validation']) && ! $campaign->fulfillment_valid && $campaign->fulfillment_invalid_reason == 'Artwork',
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
            'date'                => in_array($campaign->state, [
                    'fulfillment_validation',
                    'printing',
                    'shipped',
                    'delivered',
                    'cancelled',
                ]) && $campaign->garment_arrival_date,
            'seePaymentTableView' => false,
        ], ['cancel' => false]));

        $this->addRight(\App::make(ReviewProofsController::class)->configure($campaign->id, [
            'view'  => count($campaign->getCurrentArtwork()->proofs) > 0 || $campaign->artwork_request->design_minutes != 0,
            'edit'  => false,
            'slide' => false,
        ]));

        $this->addRight(\App::make(FulfillmentNotesController::class)->configure($campaign->id, [
            'view'     => true,
            'edit'     => true,
            'collapse' => true,
        ]));

        $this->addRight(\App::make(MessagesController::class)->configure($campaign->id, [
            'view'    => true,
            'edit'    => true,
            'channel' => 'fulfillment',
        ]));
    }
}
