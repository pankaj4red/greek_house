<div class="block-info-rounded">
    <div class="block-info__title">
        Shipping Info
        <a href="{{ route('customer_module_popup', ['shipping_information', $campaign->id]) }}" class="module-link title__button"><i class="fa fa-edit"></i></a>
    </div>
    <div class="block-info__body">
        <div class="body__item">
            <div class="item__title">Name</div>
            <div class="item__value">{{ $campaign->getContactFullName() }}</div>
        </div>
        <div class="body__item">
            <div class="item__title">Address</div>
            <div class="item__value">
                {{ $campaign->address_line1 }}
                @if ($campaign->address_line2)
                    <br>{{ $campaign->address_line2 }}
                @endif
            </div>
        </div>
        <div class="body__item">
            <div class="item__title">City</div>
            <div class="item__value">{{ $campaign->address_city }}</div>
        </div>
        <div class="body__item">
            <div class="item__title">State</div>
            <div class="item__value">{{ $campaign->address_state }}</div>
        </div>
        <div class="body__item">
            <div class="item__title">Zip code</div>
            <div class="item__value">{{ $campaign->address_zip_code }}</div>
        </div>
    </div>
</div>
