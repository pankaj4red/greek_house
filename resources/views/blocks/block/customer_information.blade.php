<div class="panel panel-default panel-minimalistic">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-user"></i><span class="icon-text">Customer Info</span></h3>
        @if ($edit)
            <a href="{{ $popupUrl }}" class="profile-edit ajax-popup order-detail-page">EDIT</a>
        @endif
    </div>
    <div class="panel-body">
        <div class="customer-information">
            @if ($showInformationPopup)
                <div class="customer-name"><a class="userfancybox"
                                              href="{{ route('customer_block_popup', ['customer_details', $campaign->user_id]) }}">{{ $campaign->getContactFullName() }}</a>
                </div>
            @else
                <div class="customer-name">{{ $campaign->getContactFullName() }}</div>
            @endif
            <div class="customer-chapter">{{ $campaign->contact_chapter }}</div>
            <div class="customer-email">
                <img src="{{ static_asset('images/icon-mail-2.png') }}"/>
                {{ $campaign->contact_email }}
            </div>
            <div class="customer-phone">
                <img src="{{ static_asset('images/icon-phone.png') }}"/>
                {{ $campaign->contact_phone }}
            </div>
        </div>
    </div>
</div>