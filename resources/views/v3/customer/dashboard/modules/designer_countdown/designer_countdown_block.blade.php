<div class="card mb-3">
    <div class="card-header border-bottom-0">
        Designer Countdown
    </div>
    <div class="card-group">
        <div class="card border-bottom-0 border-left-0">
            <div class="card-body">
                <div class="font-italic font-weight-semi-bold">Created</div>
                {{ $campaign->created_at->format('m/d/Y H:i:s') }}
            </div>
        </div>
        <div class="card border-bottom-0 border-left-0">
            <div class="card-body">
                <div class="font-italic font-weight-semi-bold">Customer Wait</div>
                {{ time_count($campaign->getCustomerWaitingTime()) }}
            </div>
        </div>
        <div class="card border-bottom-0 border-left-0">
            <div class="card-body">
                <div class="font-italic font-weight-semi-bold">Designer Wait</div>
                {{ time_count($campaign->getDesignerWaitingTime()) }}
            </div>
        </div>
        <div class="card border-bottom-0 border-left-0 border-right-0">
            <div class="card-body">
                <div class="font-italic font-weight-semi-bold">Reply Countdown</div>
                <div class="{{ countdown_class($campaign->getCountdownTime()) }}">{{ time_count($campaign->getCountdownTime()) }}</div>
            </div>
        </div>
    </div>
</div>