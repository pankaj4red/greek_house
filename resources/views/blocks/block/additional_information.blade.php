<div class="panel panel-default panel-minimalistic">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-price"></i><span class="icon-text">Additional Information</span></h3>
        @if ($edit)
            <a href="{{ $popupUrl }}" class="profile-edit ajax-popup order-detail-page">EDIT</a>
        @endif
    </div>
    <div class="panel-body">
        <div class="colored-list">
            <div class="colored-item blue">
                <div class="colored-item-information">
                    <p class="colored-item-text">Shipping Cost</p>
                    <h5 class="colored-item-title">
                        <span class="bold-black-text">
                            @if ($campaign->shipping_cost)
                                ${{ $campaign->shipping_cost }}
                            @else
                                N/A
                            @endif
                        </span>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
