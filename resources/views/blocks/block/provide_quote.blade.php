<div class="panel panel-default panel-minimalistic">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-info"></i><span class="icon-text">Provide Quote</span></h3>
        @if ($edit)
            <a href="{{ $popupUrl }}" class="profile-edit ajax-popup order-detail-page" data-width="900px">EDIT</a>
        @endif
    </div>
    <div class="panel-body">
        <div class="shipping-information">
            <div class="shipping-information-title">Price per Shirt</div>
            <div class="shipping-information-text">
                @forelse($campaign->quotes as $quote)
                    {{ $quote->product->name }}: {{ quote_range($quote->quote_low * 1.07, $quote->quote_high * 1.07, $quote->quote_final * 1.07) }}<br/>
                @empty
                    {{ quote_range($campaign->quote_low * 1.07, $campaign->quote_high * 1.07, $campaign->quote_final * 1.07) }}
                @endforelse
            </div>
        </div>
    </div>
</div>
