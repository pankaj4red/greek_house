<?php

namespace App\Providers;

use App\Events\Campaign\ArtworkFixed;
use App\Events\Campaign\AwaitingDesign;
use App\Events\Campaign\CampusApprovalRequired;
use App\Events\Campaign\Cancelled;
use App\Events\Campaign\Created as CampaignCreated;
use App\Events\Campaign\DecoratorAssigned;
use App\Events\Campaign\DeliverEarlier;
use App\Events\Campaign\Delivered;
use App\Events\Campaign\DeliveryDateHelp;
use App\Events\Campaign\DesignApproved;
use App\Events\Campaign\DesignerAssigned;
use App\Events\Campaign\FulfillmentIssueReported;
use App\Events\Campaign\FulfillmentIssueSolved;
use App\Events\Campaign\FulfillmentReady;
use App\Events\Campaign\FullyCreated as CampaignFullyCreated;
use App\Events\Campaign\MessageCreated;
use App\Events\Campaign\OnHold;
use App\Events\Campaign\PaymentCancelled;
use App\Events\Campaign\PaymentClosed;
use App\Events\Campaign\PaymentExtended;
use App\Events\Campaign\PaymentProcessed;
use App\Events\Campaign\PaymentRetrying;
use App\Events\Campaign\PrintFilesProvided;
use App\Events\Campaign\Printing;
use App\Events\Campaign\PrintingDateUpdated;
use App\Events\Campaign\ProofsProvided;
use App\Events\Campaign\QuoteProvided;
use App\Events\Campaign\RevisionRequested;
use App\Events\Campaign\Shipped as CampaignShipped;
use App\Events\Campaign\StateManuallyChanged;
use App\Events\Campaign\SuppliesFixed;
use App\Events\Misc\CampusManagerRequest;
use App\Events\Model\ModelCreated;
use App\Events\Model\ModelUpdated;
use App\Events\Order\Authorized;
use App\Events\Order\Charged;
use App\Events\Order\ChargedManual;
use App\Events\Order\FailedToAuthorize;
use App\Events\Order\FailedToCharge;
use App\Events\Order\Refunded;
use App\Events\Order\Shipped as OrderShipped;
use App\Events\User\Registered;
use App\Events\User\UserCreated as UserCreated;
use App\Exceptions\RedirectException;
use App\Listeners\CampaignArtworkFixedNotifications;
use App\Listeners\CampaignArtworkFixedTracking;
use App\Listeners\CampaignAwaitingDesignNotifications;
use App\Listeners\CampaignAwaitingDesignTracking;
use App\Listeners\CampaignCampusApprovalRequiredNotifications;
use App\Listeners\CampaignCampusApprovalRequiredTracking;
use App\Listeners\CampaignCancelledNotifications;
use App\Listeners\CampaignCancelledTracking;
use App\Listeners\CampaignCreatedNotifications;
use App\Listeners\CampaignCreatedTracking;
use App\Listeners\CampaignDecoratorAssignedNotifications;
use App\Listeners\CampaignDecoratorAssignedTracking;
use App\Listeners\CampaignDeliverEarlierNotifications;
use App\Listeners\CampaignDeliveredNotifications;
use App\Listeners\CampaignDeliveredTracking;
use App\Listeners\CampaignDeliveryDateHelpNotification;
use App\Listeners\CampaignDesignApprovedNotifications;
use App\Listeners\CampaignDesignApprovedSalesforce;
use App\Listeners\CampaignDesignApprovedTracking;
use App\Listeners\CampaignDesignerAssignedNotifications;
use App\Listeners\CampaignDesignerAssignedTracking;
use App\Listeners\CampaignFulfillmentIssueReportedNotifications;
use App\Listeners\CampaignFulfillmentIssueReportedTracking;
use App\Listeners\CampaignFulfillmentIssueSolvedNotifications;
use App\Listeners\CampaignFulfillmentIssueSolvedTracking;
use App\Listeners\CampaignFulfillmentReadySalesforce;
use App\Listeners\CampaignFulfillmentReadyTracking;
use App\Listeners\CampaignMessageCreatedNotifications;
use App\Listeners\CampaignMessageCreatedTracking;
use App\Listeners\CampaignOnHoldInternalNote;
use App\Listeners\CampaignOnHoldNotifications;
use App\Listeners\CampaignOnHoldTracking;
use App\Listeners\CampaignPaymentCancelledNotifications;
use App\Listeners\CampaignPaymentCancelledTracking;
use App\Listeners\CampaignPaymentClosedNotifications;
use App\Listeners\CampaignPaymentClosedTracking;
use App\Listeners\CampaignPaymentExtendedNotifications;
use App\Listeners\CampaignPaymentExtendedTracking;
use App\Listeners\CampaignPaymentProcessedNotifications;
use App\Listeners\CampaignPaymentProcessedTracking;
use App\Listeners\CampaignPaymentRetryingNotifications;
use App\Listeners\CampaignPaymentRetryingTracking;
use App\Listeners\CampaignPrintFilesProvidedNotifications;
use App\Listeners\CampaignPrintFilesProvidedTracking;
use App\Listeners\CampaignPrintingDateUpdatedNotifications;
use App\Listeners\CampaignPrintingDateUpdatedTracking;
use App\Listeners\CampaignPrintingNotifications;
use App\Listeners\CampaignPrintingTracking;
use App\Listeners\CampaignProofsProvidedNotifications;
use App\Listeners\CampaignProofsProvidedTracking;
use App\Listeners\CampaignQuoteProvidedNotifications;
use App\Listeners\CampaignQuoteProvidedTracking;
use App\Listeners\CampaignRevisionRequestedNotifications;
use App\Listeners\CampaignRevisionRequestedTracking;
use App\Listeners\CampaignShippedNotifications;
use App\Listeners\CampaignShippedTracking;
use App\Listeners\CampaignStateManuallyChangedTracking;
use App\Listeners\CampaignSuppliesFixedNotifications;
use App\Listeners\CampaignSuppliesFixedTracking;
use App\Listeners\CampusManagerRequestNotifications;
use App\Listeners\ModelCreatedLogging;
use App\Listeners\ModelUpdatedLogging;
use App\Listeners\OrderAuthorizedLogging;
use App\Listeners\OrderAuthorizedNotifications;
use App\Listeners\OrderChargedLogging;
use App\Listeners\OrderChargedManualLogging;
use App\Listeners\OrderChargedManualNotifications;
use App\Listeners\OrderChargedNotifications;
use App\Listeners\OrderFailedToAuthorizeLogging;
use App\Listeners\OrderFailedToChargeLogging;
use App\Listeners\OrderRefundedLogging;
use App\Listeners\OrderShippedLogging;
use App\Listeners\OrderShippedNotifications;
use App\Listeners\Salesforce\CreateSFContactOnUserCreated;
use App\Listeners\Salesforce\CreateSFOpportunityOnCampaignCreated;
use App\Listeners\UserCreatedNotifications;
use App\Listeners\UserRegisteredNotifications;
use App\Logging\Logger;
use App\Models\User;
use Auth;
use Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Session;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        StateManuallyChanged::class     => [
            CampaignStateManuallyChangedTracking::class,
        ],
        AwaitingDesign::class           => [
            CampaignAwaitingDesignNotifications::class,
            CampaignAwaitingDesignTracking::class,
        ],
        DesignApproved::class           => [
            CampaignDesignApprovedNotifications::class,
            CampaignDesignApprovedTracking::class,
            CampaignDesignApprovedSalesforce::class,
        ],
        DeliverEarlier::class           => [
            CampaignDeliverEarlierNotifications::class,
        ],
        DeliveryDateHelp::class         => [
            CampaignDeliveryDateHelpNotification::class,
        ],
        SuppliesFixed::class            => [
            CampaignSuppliesFixedNotifications::class,
            CampaignSuppliesFixedTracking::class,
        ],
        ArtworkFixed::class             => [
            CampaignArtworkFixedNotifications::class,
            CampaignArtworkFixedTracking::class,
        ],
        CampusApprovalRequired::class   => [
            CampaignCampusApprovalRequiredNotifications::class,
            CampaignCampusApprovalRequiredTracking::class,
        ],
        Cancelled::class                => [
            CampaignCancelledNotifications::class,
            CampaignCancelledTracking::class,
        ],
        MessageCreated::class           => [
            CampaignMessageCreatedNotifications::class,
            CampaignMessageCreatedTracking::class,
        ],
        CampaignCreated::class          => [
            CampaignCreatedTracking::class,
        ],
        CampaignFullyCreated::class     => [
            CreateSFOpportunityOnCampaignCreated::class,
            CampaignCreatedNotifications::class,
        ],
        DecoratorAssigned::class        => [
            CampaignDecoratorAssignedNotifications::class,
            CampaignDecoratorAssignedTracking::class,
        ],
        Delivered::class                => [
            CampaignDeliveredNotifications::class,
            CampaignDeliveredTracking::class,
        ],
        DesignerAssigned::class         => [
            CampaignDesignerAssignedNotifications::class,
            CampaignDesignerAssignedTracking::class,
        ],
        OnHold::class                   => [
            CampaignOnHoldNotifications::class,
            CampaignOnHoldTracking::class,
            CampaignOnHoldInternalNote::class,
        ],
        PaymentCancelled::class         => [
            CampaignPaymentCancelledNotifications::class,
            CampaignPaymentCancelledTracking::class,
        ],
        PaymentClosed::class            => [
            CampaignPaymentClosedNotifications::class,
            CampaignPaymentClosedTracking::class,
        ],
        PaymentRetrying::class          => [
            CampaignPaymentRetryingNotifications::class,
            CampaignPaymentRetryingTracking::class,
        ],
        PaymentExtended::class          => [
            CampaignPaymentExtendedNotifications::class,
            CampaignPaymentExtendedTracking::class,
        ],
        PaymentProcessed::class         => [
            CampaignPaymentProcessedNotifications::class,
            CampaignPaymentProcessedTracking::class,
        ],
        PrintFilesProvided::class       => [
            CampaignPrintFilesProvidedNotifications::class,
            CampaignPrintFilesProvidedTracking::class,
        ],
        Printing::class                 => [
            CampaignPrintingNotifications::class,
            CampaignPrintingTracking::class,
        ],
        ProofsProvided::class           => [
            CampaignProofsProvidedNotifications::class,
            CampaignProofsProvidedTracking::class,
        ],
        QuoteProvided::class            => [
            CampaignQuoteProvidedNotifications::class,
            CampaignQuoteProvidedTracking::class,
        ],
        RevisionRequested::class        => [
            CampaignRevisionRequestedNotifications::class,
            CampaignRevisionRequestedTracking::class,
        ],
        FulfillmentReady::class         => [
            CampaignFulfillmentReadySalesforce::class,
            CampaignFulfillmentReadyTracking::class,
        ],
        FulfillmentIssueReported::class => [
            CampaignFulfillmentIssueReportedNotifications::class,
            CampaignFulfillmentIssueReportedTracking::class,
        ],
        FulfillmentIssueSolved::class   => [
            CampaignFulfillmentIssueSolvedNotifications::class,
            CampaignFulfillmentIssueSolvedTracking::class,
        ],
        PrintingDateUpdated::class      => [
            CampaignPrintingDateUpdatedNotifications::class,
            CampaignPrintingDateUpdatedTracking::class,
        ],
        CampaignShipped::class          => [
            CampaignShippedNotifications::class,
            CampaignShippedTracking::class,
        ],
        ModelCreated::class             => [
            ModelCreatedLogging::class,
        ],
        ModelUpdated::class             => [
            ModelUpdatedLogging::class,
        ],
        Authorized::class               => [
            OrderAuthorizedNotifications::class,
            OrderAuthorizedLogging::class,
        ],
        Charged::class                  => [
            OrderChargedNotifications::class,
            OrderChargedLogging::class,
        ],
        ChargedManual::class            => [
            OrderChargedManualNotifications::class,
            OrderChargedManualLogging::class,
        ],
        FailedToAuthorize::class        => [
            OrderFailedToAuthorizeLogging::class,
        ],
        FailedToCharge::class           => [
            OrderFailedToChargeLogging::class,
        ],
        Refunded::class                 => [
            OrderRefundedLogging::class,
        ],
        OrderShipped::class             => [
            OrderShippedNotifications::class,
            OrderShippedLogging::class,
        ],
        CampusManagerRequest::class     => [
            CampusManagerRequestNotifications::class,
        ],
        UserCreated::class              => [
            UserCreatedNotifications::class,
            CreateSFContactOnUserCreated::class,
        ],
        Registered::class               => [
            UserRegisteredNotifications::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Logger::listenToEmail();

        Event::listen('auth.login', function (User $user) {
            $user->last_login_at = date('Y-m-d H:i:s', time());
            $user->save();
        });

        Event::listen('auth.logout', function ($user) {
            if ($user instanceof User && Session::has('artlo')) {
                $artDirector = user_repository()->find(Session::get('artlo'));
                if ($artDirector != null && $artDirector->isType('art_director')) {
                    Session::forget('artlo');
                    /** @noinspection PhpParamsInspection */
                    Auth::login($artDirector);
                    throw new RedirectException(route('art_director::designer', [$user->id]));
                }
            } elseif ($user instanceof User && Session::has('adlo')) {
                $admin = user_repository()->find(Session::get('adlo'));
                if ($admin != null && $admin->isType('admin')) {
                    Session::forget('adlo');
                    /** @noinspection PhpParamsInspection */
                    Auth::login($admin);
                    throw new RedirectException(route('admin::user::read', [$user->id]));
                }
            }
        });
    }
}
