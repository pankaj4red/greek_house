<div class="card mb-3">
    <div class="card-header">
        Shipping Types
        @if ($edit)
            <a href="{{ route('customer_module_popup', ['shipping_types', $campaign->id]) }}" data-toggle="modal" data-target="#gh-modal">
                <i class="fa fa-edit color-slate pull-right text-lg"></i>
            </a>
        @endif
    </div>
    <ul class="list-group list-group-flush text-sm text-uppercase color-slate">
        <li class="list-group-item">
            <div class="text-spacing-1">Group Shipping</div>
            <div>{{ $campaign->shipping_group ? 'YES' : 'NO' }}</div>
        </li>
        <li class="list-group-item bg-gray">
            <div class="text-spacing-1">Individual Shipping</div>
            <div>{{ $campaign->shipping_individual ? 'YES' : 'NO' }}</div>
        </li>
    </ul>
</div>
