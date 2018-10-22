<div class="panel panel-default panel-box">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-tshirt"></i><span class="icon-text">Order Form</span></h3>
    </div>
    <div class="panel-body">
        @if ($edit)
            <a href="{{ $popupUrl }}" class="btn btn-success ajax-popup order-detail-page" data-width="1200px">
                @if ($campaign->state == 'fulfillment_ready')
                    SEND TO DECORATOR
                @else
                    UPDATE ORDER FORM
                @endif
            </a>
        @endif
        @if ($review)
            <a href="{{ route('customer_block_popup', ['send_printer', $campaign->id, 'review']) }}"
               class="btn btn-info ajax-popup order-detail-page" data-width="1200px">VIEW ORDER FORM</a>
            <a href="{{ route('customer_block_popup', ['send_printer', $campaign->id, 'download']) }}"
               class="button-back btn btn-success back-btn">DOWNLOAD ORDER FORM</a>
        @endif
    </div>
</div>
