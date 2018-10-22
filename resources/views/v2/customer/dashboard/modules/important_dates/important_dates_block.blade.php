<div class="block-info-rounded">
    <div class="block-info__title">
        Important Dates
        <a href="{{ route('customer_module_popup', ['important_dates', $campaign->id]) }}" class="module-link title__button"><i class="fa fa-edit"></i></a>
    </div>
    <div class="block-info__body">
        <div class="body__item">
            <div class="item__title">Rush Delivery</div>
            <div class="item__value">{{ $campaign->rush ? 'YES': 'NO' }}</div>
        </div>
        <div class="body__item grey">
            <div class="item__title">Delivery Due Date</div>
            <div class="item__value">{{ $campaign->date ? $campaign->date->format('m/d/Y') : 'N/A' }}</div>
        </div>
        <div class="body__item">
            <div class="item__title">Finalize design by</div>
            <div class="item__value">N/A</div>
        </div>
    </div>
</div>