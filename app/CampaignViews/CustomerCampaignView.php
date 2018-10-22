<?php

namespace App\CampaignViews;

use App;
use App\Contracts\CampaignViews\CampaignView;
use App\Http\Controllers\Customer\Modules\CampaignDetailsController;
use App\Http\Controllers\Customer\Modules\CampaignStatusController;
use App\Http\Controllers\Customer\Modules\DeliveryInformationController;
use App\Http\Controllers\Customer\Modules\DesignInformationController;
use App\Http\Controllers\Customer\Modules\ImportantDatesController;
use App\Http\Controllers\Customer\Modules\MessagesController;
use App\Http\Controllers\Customer\Modules\PaymentDetailsController;
use App\Http\Controllers\Customer\Modules\ProductsController;
use App\Http\Controllers\Customer\Modules\ShippingInformationController;
use App\Models\Campaign;

class CustomerCampaignView extends CampaignView
{
    protected $v2 = true;

    /**
     * CustomerCampaignView constructor.
     *
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->setCampaign($campaign);
        $this->force('customer');
        clear_access_tokens();

        $this->addLeft(App::make(ImportantDatesController::class)->configure($campaign->id, [
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

        $this->addLeft(App::make(ShippingInformationController::class)->configure($campaign->id, [
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

        $this->addRight(App::make(CampaignStatusController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addRight(App::make(DeliveryInformationController::class)->configure($campaign->id, [
            'view' => in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
            ]),
            'edit' => false,
        ]));

        $this->addRight(App::make(PaymentDetailsController::class)->configure($campaign->id, [
            'view'                => in_array($campaign->state, [
                'collecting_payment',
                'processing_payment',
                'fulfillment_ready',
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
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
            'goals'               => in_array($campaign->state, [
                'collecting_payment',
                'processing_payment',
                'fulfillment_ready',
            ]),
        ], ['cancel' => true]));

        $this->addRight(App::make(DesignInformationController::class)->configure($campaign->id, [
            'view' => $campaign->getCurrentArtwork()->proofs->count() > 0 || $campaign->artwork_request->design_minutes != 0,
            'edit' => false,
        ], [
            'approval' => in_array($campaign->state, ['awaiting_approval', 'campus_approval']),
        ]));

        $this->addRightTab('messages', 'Messages', App::make(MessagesController::class)->configure($campaign->id, [
            'view'    => true,
            'edit'    => true,
            'channel' => 'customer',

        ]));

        $this->addRightTab('products', 'Products', App::make(ProductsController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addRightTab('description', 'Description', App::make(CampaignDetailsController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));
    }
}
