<div class="panel panel-default panel-minimalistic">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-price"></i><span class="icon-text">Customer Promise</span></h3>
        @if ($edit)
            <a href="{{ $popupUrl }}" class="profile-edit ajax-popup order-detail-page">EDIT</a>
        @endif
    </div>
    <div class="panel-body">
        <div class="colored-list">
            <div class="colored-item blue">
                <div class="colored-item-information">
                    <p class="colored-item-text">Assigned On</p>
                    <h5 class="colored-item-title">
                    <span class="bold-black-text">
                        @if ($campaign->assigned_decorator_date)
                            {{ date('m/d/Y', strtotime($campaign->assigned_decorator_date)) }}
                        @else
                            N/A
                        @endif
                    </span>
                    </h5>
                </div>
            </div>
            <div class="colored-item orange">
                <div class="colored-item-information">
                    <p class="colored-item-text">Rush Order</p>
                    <h5 class="colored-item-title">
                        @if ($campaign->rush)
                            <span class="bold-red-text">Yes</span>
                        @else
                            <span class="bold-black-text">No</span>
                        @endif
                    </h5>
                </div>
            </div>
            <div class="colored-item red">
                <div class="colored-item-information">
                    <p class="colored-item-text">Printing Date</p>
                    <h5 class="colored-item-title">
                    <span class="bold-black-text">
                        @if ($campaign->printing_date)
                            {{ date('m/d/Y', strtotime($campaign->printing_date)) }}
                        @else
                            N/A
                        @endif
                    </span>
                    </h5>
                </div>
            </div>
            @if ($showDaysInTransit)
                <div class="colored-item red">
                    <div class="colored-item-information">
                        <p class="colored-item-text">Days in Transit</p>
                        <h5 class="colored-item-title">
                    <span class="bold-black-text">
                        {{ $campaign->days_in_transit ? $campaign->days_in_transit : 0 }}
                    </span>
                        </h5>
                    </div>
                </div>
            @endif
            @if ($showRequestedDeliveryDate)
                <div class="colored-item green">
                    <div class="colored-item-information">
                        <p class="colored-item-text">Due Date</p>
                        <h5 class="colored-item-title">
                        <span class="bold-black-text">
                            {{ $campaign->date ? date('m/d/Y', strtotime($campaign->date)) : 'N/A' }}
                        </span>
                        </h5>
                    </div>
                </div>
            @endif
            @if ($showRequestedDeliveryDate)
                <div class="colored-item green">
                    <div class="colored-item-information">
                        <p class="colored-item-text">Flexible</p>
                        <h5 class="colored-item-title">
                            @if ($campaign->flexible == 'yes')
                                <span class="bold-red-text">Yes</span>
                            @else
                                <span class="bold-black-text">No</span>
                            @endif
                        </h5>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
