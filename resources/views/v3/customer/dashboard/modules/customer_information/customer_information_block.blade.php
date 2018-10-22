<div class="card mb-3">
    <div class="card-header">
        Customer
        @if ($edit)
            <a href="{{ route('customer_module_popup', ['customer_information', $campaign->id]) }}" data-toggle="modal" data-target="#gh-modal" data-modal-width="800px">
                <i class="fa fa-edit color-slate pull-right text-lg"></i>
            </a>
        @endif
    </div>
    <div class="card-body">
        <div class="customer-information">
            @if ($showInformationPopup)
                <div>
                    <a href="{{ route('customer_block_popup', ['customer_details', $campaign->user_id]) }}" class="class="text-lg color-blue"">{{ $campaign->getContactFullName() }}</a>
                </div>
            @else
                <div class="text-lg color-blue">{{ $campaign->getContactFullName() }}</div>
            @endif
            <div class="font-italic font-weight-semi-bold">{{ $campaign->contact_chapter }}</div>
            <div class="text-sm">
                <img src="{{ static_asset('images/icon-mail-2.png') }}"/>
                {{ $campaign->contact_email }}
            </div>
            <div class="text-sm">
                <img src="{{ static_asset('images/icon-phone.png') }}"/>
                {{ $campaign->contact_phone }}
            </div>
        </div>
    </div>
</div>
