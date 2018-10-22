<?php

namespace App\CampaignViews;

use App;
use App\Contracts\CampaignViews\CampaignView;
use App\Http\Controllers\Customer\Modules\CampaignDetailsController;
use App\Http\Controllers\Customer\Modules\CampaignStatusController;
use App\Http\Controllers\Customer\Modules\CustomerInformationController;
use App\Http\Controllers\Customer\Modules\DesignerCountdownController;
use App\Http\Controllers\Customer\Modules\DesignInformationController;
use App\Http\Controllers\Customer\Modules\EmbellishmentController;
use App\Http\Controllers\Customer\Modules\FulfillmentNotesController;
use App\Http\Controllers\Customer\Modules\ImportantDatesController;
use App\Http\Controllers\Customer\Modules\MessagesController;
use App\Http\Controllers\Customer\Modules\NotesController;
use App\Http\Controllers\Customer\Modules\PaymentDetailsController;
use App\Http\Controllers\Customer\Modules\ProductsController;
use App\Http\Controllers\Customer\Modules\ShippingInformationController;
use App\Http\Controllers\Customer\Modules\ShippingTypesController;
use App\Http\Controllers\Customer\Modules\SourceDesignController;
use App\Http\Controllers\Customer\Modules\UnclaimedCampaignController;
use App\Http\Controllers\Customer\Modules\UploadPrintFilesController;
use App\Models\Campaign;

class DesignerCampaignView extends CampaignView
{
    protected $v2 = true;

    /**
     * DesignerCampaignView constructor.
     *
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->setCampaign($campaign);
        $this->force('designer');
        clear_access_tokens();

        $this->addLeft(App::make(ImportantDatesController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addLeft(App::make(EmbellishmentController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => true,
        ]));

        $this->addLeft(App::make(CustomerInformationController::class)->configure($campaign->id, [
            'view'                 => true,
            'edit'                 => false,
            'showInformationPopup' => false,
        ], ['show_information' => false]));

        $this->addLeft(App::make(ShippingInformationController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addLeft(App::make(ShippingTypesController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addRight(App::make(CampaignStatusController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addRight(App::make(SourceDesignController::class)->configure($campaign->id, [
            'view' => $campaign->source_design_id != null,
            'edit' => false,
        ]));

        $this->addRight(App::make(DesignerCountdownController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => false,
        ]));

        $this->addRight(App::make(UnclaimedCampaignController::class)->configure($campaign->id, [
            'view' => ! $campaign->artwork_request->designer_id && in_array($campaign->state, ['awaiting_design', 'awaiting_approval', 'revision_requested']),
            'edit' => true,
        ]));

        $this->addRight(App::make(UploadPrintFilesController::class)->configure($campaign->id, [
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

        $this->addRight(App::make(PaymentDetailsController::class)->configure($campaign->id, [
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
            'goals'               => false,
        ], ['cancel' => false]));

        $this->addRight(App::make(DesignInformationController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => ! in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ]),
        ], [
            'approval' => false,
        ]));

        $this->addRight(App::make(NotesController::class)->configure($campaign->id, [
            'view'     => true,
            'edit'     => true,
            'collapse' => true,
        ]));

        $this->addRight(App::make(FulfillmentNotesController::class)->configure($campaign->id, [
            'view'     => true,
            'edit'     => true,
            'collapse' => true,
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
