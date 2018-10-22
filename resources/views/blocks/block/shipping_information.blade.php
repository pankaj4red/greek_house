<div class="panel panel-default panel-minimalistic">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-van"></i><span class="icon-text">Shipping Info</span></h3>
        @if ($edit)
            <a href="{{ $popupUrl }}" class="profile-edit ajax-popup order-detail-page">EDIT</a>
        @endif
    </div>
    <div class="panel-body">
        <div class="shipping-information">
            <div class="shipping-information-title">Address</div>
            <div class="shipping-information-text">
                {{ $campaign->address_line1 }}
                @if (isset($campaign->address_line2))
                    <br/>
                    {{ $campaign->address_line2 }}
                @endif
            </div>
            <div class="shipping-information-title">City</div>
            <div class="shipping-information-text">{{ $campaign->address_city }}</div>
            <div class="shipping-information-title">State</div>
            <div class="shipping-information-text">{{ $campaign->address_state }}</div>
            <div class="shipping-information-title">Zip Code</div>
            <div class="shipping-information-text">{{ $campaign->address_zip_code }}</div>
            <div class="shipping-information-title">Country</div>
            <div class="shipping-information-text">{{ country_name($campaign->address_country) }}</div>
        </div>
    </div>
</div>