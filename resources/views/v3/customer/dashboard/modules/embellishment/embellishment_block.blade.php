<div class="card mb-3">
    <div class="card-header">
        Embellishment
        @if ($edit)
            <a href="{{ route('customer_module_popup', ['embellishment', $campaign->id]) }}" data-toggle="modal" data-target="#gh-modal">
                <i class="fa fa-edit color-slate pull-right text-lg"></i>
            </a>
        @endif
    </div>
    <ul class="list-group list-group-flush text-sm text-uppercase color-slate">
        <li class="list-group-item">
            <div class="text-spacing-1">Print Type</div>
            @if ($campaign->getCurrentArtwork()->design_type == 'screen')
                <div>Screenprint</div>
            @else
                <div>Embroidery</div>
            @endif
        </li>
        <li class="list-group-item bg-gray">
            <div class="text-spacing-1">Polybag & Label</div>
            @if ($campaign->polybag_and_label)
                <div>Yes</div>
            @else
                <div>No</div>
            @endif
        </li>
    </ul>
</div>
