<div class="card mb-3">
    @include('v3.partials.progress')
    @if ($campaign->tracking_code)
        <div class="card-body border-top">
            <div class="text-reg text-uppercase color-blue font-weight-semi-bold">Tracking Code</div>
            <div class="text-sm color-slate">{{ $campaign->tracking_code }}</div>
        </div>
    @endif
</div>
