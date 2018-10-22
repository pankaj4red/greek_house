<div class="card mb-3">
    <div class="card-header">
        Important Dates
        @if ($edit)
            <a href="{{ route('customer_module_popup', ['important_dates', $campaign->id]) }}" data-toggle="modal" data-target="#gh-modal">
                <i class="fa fa-edit color-slate pull-right text-lg"></i>
            </a>
        @endif
    </div>
    <ul class="list-group list-group-flush text-sm text-uppercase color-slate">
        <li class="list-group-item">
            <div class="text-spacing-1">Rush Delivery</div>
            <div>{{ $campaign->rush ? 'YES': 'NO' }}</div>
        </li>
        <li class="list-group-item bg-gray">
            <div class="text-spacing-1">Delivery Due Date</div>
            <div>{{ $campaign->date ? $campaign->date->format('m/d/Y') : 'N/A' }}</div>
        </li>
        <li class="list-group-item">
            <div class="text-spacing-1">Finalize design by</div>
            <div>N/A</div>
        </li>
    </ul>
</div>
