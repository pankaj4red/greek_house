<div class="card mb-3">
    <div class="card-header">
        Shipping Address
        @if ($edit)
            <a href="{{ route('customer_module_popup', ['shipping_information', $campaign->id]) }}" data-toggle="modal" data-target="#gh-modal" data-modal-width="800px">
                <i class="fa fa-edit color-slate pull-right text-lg"></i>
            </a>
        @endif
    </div>
    <ul class="list-group list-group-flush text-sm color-slate">
        <li class="list-group-item">
            <div class="text-spacing-1 text-uppercase">Name</div>
            <div>{{ $campaign->getContactFullName() }}</div>
        </li>
        <li class="list-group-item">
            <div class="text-spacing-1 text-uppercase">Address</div>
            <div>
                {{ $campaign->address_line1 }}
                @if ($campaign->address_line2)
                    <br>{{ $campaign->address_line2 }}
                @endif
            </div>
        </li>
        <li class="list-group-item">
            <div class="text-spacing-1 text-uppercase">City</div>
            <div>{{ $campaign->address_city }}</div>
        </li>
        <li class="list-group-item">
            <div class="text-spacing-1 text-uppercase">State</div>
            <div>{{ $campaign->address_state }}</div>
        </li>
        <li class="list-group-item">
            <div class="text-spacing-1 text-uppercase">Zip code</div>
            <div>{{ $campaign->address_zip_code }}</div>
        </li>
    </ul>
</div>
