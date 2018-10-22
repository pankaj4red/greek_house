<div class="panel panel-default panel-minimalistic">
    <div class="panel-heading">
        @if ($date && in_array($campaign->state, [
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered']))
            <h3 class="panel-title"><i class="icon icon-price"></i><span class="icon-text">Garment Info</span></h3>
        @else
            <h3 class="panel-title"><i class="icon icon-price"></i><span class="icon-text">Payment Details</span></h3>
            <h3 class="panel-price text-right"><span class="icon-text">{{ quote_range($campaign->quote_low * 1.07, $campaign->quote_high * 1.07, $campaign->quote_final * 1.07) }}</span></h3>
        @endif
    </div>
    <div class="panel-body">
        <div class="payment-details">
            @if ($payment)
                <div class="row payment-actions">
                    <?php $count = 0; ?>
                    <?php /* if ($show_all_payment_methods || $campaign->payment_credit_card) */ ?>
                    <?php $count++; ?>
                    <div class="col-md-8">
                        <a class="btn btn-success btn-sm"
                           href="{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) }}">Buy
                            Now</a>
                    </div>
                    <?php /* @endif */ ?>
                    <?php /* @for (; $count < 2; $count++) */ ?>
                    <?php /*     <div class="col-md-4"> */ ?>
                    <?php /*     </div> */ ?>
                    <?php /* @endfor */ ?>
                    <div class="col-md-4">
                        <i class="payment-calendar"></i>
                        <span class="payment-date text-right">{{ $campaign->close_date?date('m/d/Y', strtotime($campaign->close_date)):'N/A' }}</span>
                        <span class="payment-text text-right">Campaign Close Date</span>
                    </div>
                </div>
            @endif
            @if ($date)
                <div class="row payment-actions">
                    <div class="col-md-12">
                        <i class="payment-calendar"></i>
                        <span class="payment-date text-right">{{ $campaign->garment_arrival_date?date('m/d/Y', strtotime($campaign->garment_arrival_date)):'N/A' }}</span>
                        <span class="payment-text text-right">Expected Arrival Date</span>
                    </div>
                </div>
            @endif
            @if ($payment)
                <div class="row background-grey margin-top-reversed share-campaign">
                    <div class="col-md-4">
                        <span class="text-right social-icons-label">Share this Campaign:</span>
                    </div>
                    <div class="col-md-8">
                        <script type="text/javascript">
                            var addthis_config =
                                {
                                    services_expanded: 'facebook,email,link',
                                    data_track_clickback: false
                                }
                        </script>
                        <div class="social-icons addthis_toolbox"
                             addthis:url="{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) }}"
                             addthis:description="Don't miss out on this shirt!"
                             addthis:title="{{ $campaign->name }} | Greek House">
                            <a href="javascript:void(0)" class="social-thumb addthis_button_facebook at300b"
                               title="Facebook"><span class="v-align-wrapper"><span class="v-align"><img
                                                src="{{ static_asset('images/icon-social-1.png') }}" alt="icon-social"></span></span></a>
                            <a href="javascript:void(0)" class="social-thumb addthis_button_link at300b"
                               title="{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) }}"><span
                                        class="v-align-wrapper"><span class="v-align"><img
                                                src="{{ static_asset('images/link.png') }}"
                                                alt="icon-social"></span></span></a>
                            <div class="atclear"></div>
                        </div>
                    </div>
                    <?php register_js('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5416f2ad4d856633') ?>
                </div>
            @endif
            <table class="table">
                <tr>
                    @foreach ($sizes['sizes'] as $size)
                        <td>
                            <span class="payment-quantity">{{ $size['quantity'] }}</span>
                            <span class="payment-text">{{ $size['short'] }}</span>
                        </td>
                    @endforeach
                    <td>
                        <span class="payment-main">{{ $sizes['total'] }}</span>
                        <span class="payment-text">Total</span>
                    </td>
                    @if ($seePaymentTableView)
                        <td>
                            <a href="{{ route('customer_block_popup', ['payment_details', $campaign->id, 'sales']) }}"
                               class="payment-link ajax-popup order-detail-page" data-width="80%">View</a>
                        </td>
                    @endif
                </tr>
            </table>
            @if ($edit)
                <div class="order-close-date-details">
                    {{ Form::model($paymentCloseDate, ['route' => ['customer_block_popup', 'payment_details', $campaign->id, 'close_date']]) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-inline">
                                <div>
                                    @if ($cancel)
                                        <label class="radio-inline">
                                            {{ Form::radio('action', 'cancel', (null?null:$paymentCloseDate['action'])=='cancel', ['class' => 'order_action']) }}
                                            Cancel Order
                                        </label>
                                    @endif
                                    <label class="radio-inline">
                                        {{ Form::radio('action', 'close', (null?null:$paymentCloseDate['action'])=='close', ['class' => 'order_action']) }}
                                        Close Order
                                    </label>
                                    <label class="radio-inline">
                                        {{ Form::radio('action', 'extend', (null?null:$paymentCloseDate['action'])=='extend', ['class' => 'order_action']) }}
                                        Extend Order
                                    </label>
                                </div>
                            </div>
                            <div class="select-date order-date"
                                 style="{{ (null?null:$paymentCloseDate['action'])=='close'?'display: none':'' }}">
                                <div class="date input-group" data-date-format="dd/MM/yyyy" data-toggle="modal"
                                     data-target="#myModal">
                                    <input class="form-control" size="16" type="text" name="close_date"
                                           placeholder="Enter Closing Date" id="close-date" readonly=""/>
                                    <span class="input-group-addon"><span class="glyphicon cal-icon"></span></span>
                                </div>
                            </div>
                            <button type="submit" name="payment_actions" value="save"
                                    class="btn btn-primary btn-sm btn-inline pull-right" id="ajax-button">Update Order Close Date
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            @endif
        </div>
    </div>
</div>

@section ('javascript')
    <script>
        $('.order_action').change(function (event) {
            if ($(this).val() === 'extend') {
                $('.order-date').show();
            } else {
                $('.order-date').hide();
            }
        });
    </script>
    <script>
        $("#close-date").datepicker({
            inline: false
        });
    </script>
@append