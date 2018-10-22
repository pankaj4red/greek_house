@extends ('customer')

@section ('title', $campaign->name . ' Checkout')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="container">
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        <div id="error-area"></div>
        <div id="checkout-area" class="row">
            <div class="col-md-5 col-md-offset-1 pull-right">
                @if (in_array($order->state, ['authorized', 'authorized_failed']))
                    <div class="alert alert-success text-center">Order Authorized</div>
                @endif
                @if (in_array($order->state, ['success']))
                    <div class="alert alert-success text-center">Order Paid</div>
                @endif
                @if (!in_array($order->state, ['new', 'authorized', 'authorized_failed', 'success']))
                    <div class="alert alert-warning text-center">Order {{ ucfirst($order->state) }}</div>
                @endif
                <div class="order-summary">
                    <h2>Order Summary
                        @if ($order->state == 'new')
                            <a href="{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) }}?copy={{ $order->id }}">
                                <i class="pull-right fa fa-edit edit-icon"></i>
                            </a>
                        @endif
                    </h2>
                    <div class="order-entries">
                        <table class="order-entry">
                            <tbody>
                            @foreach ($order->entries as $orderEntry)
                                <tr>
                                    <td class="order-entry-product">
                                        <img src="{{ route('system::image', [$productColorImage->id]) }}" alt=""/>
                                    </td>
                                    <td class="order-entry-title">
                                        <h3>{{ $campaign->name }}</h3>
                                        <ul class="order-entry-details">
                                            <li><span class="color_label">{{ product_color($campaign->products->first()->pivot->color_id)->name }}</span>
                                                ({{ $orderEntry->size->short }})
                                            </li>
                                        </ul>
                                    </td>
                                    <td class="order-entry-total">
                                        {{ $orderEntry->quantity }} x {{ money($orderEntry->price * 1.07) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="order-subtotal">
                        <span>Subtotal</span>
                        <span class="pull-right">{{ money($order->total - $order->shipping) }}</span>
                    </div>
                    <div class="order-shipping">
                        <span>Shipping</span>
                        <span class="pull-right">${{ $order->shipping }}</span>
                    </div>
                    <div class="order-total">
                        <span>Total</span>
                        <span class="pull-right price-total order-total-value">${{ $order->total }} </span>
                    </div>
                </div>
                <div class="order-help">
                    <p><strong>How long will it take to get my shirt? </strong><br/>
                        Your order will arrive 7-10 business days after the end of the campaign! </p>
                </div>
            </div>
            <div class="col-md-6 pull-left">
                {!! Form::hidden('shipping_type', $order->shipping_type, ['class' => 'order-field', 'id' => 'shipping_type']) !!}
                <div class="panel-group" id="shipping-options" role="tablist" aria-multiselectable="false">
                    <h2><i class="fa fa-truck" aria-hidden="true"></i> Shipping Information</h2>
                    @if (($order->state == 'new' && $campaign->shipping_group) || ($order->state != 'new' && $order->shipping_type == 'group'))
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingGroup">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#shipping-options"
                                       href="#collapseGroup"
                                       aria-expanded="{{ $order->shipping_type == 'group' ? 'true' : 'false' }}"
                                       aria-controls="collapseGroup">
                                        Group Shipping<span class="glyphicon glyphicon-ok-circle active-shipping"
                                                            aria-hidden="true"></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseGroup"
                                 class="panel-collapse collapse {{ $order->shipping_type == 'group' ? 'in' : '' }}"
                                 role="tabpanel"
                                 aria-labelledby="headingGroup">
                                <div class="panel-body">
                                    {{ $campaign->getContactFullName() }} <br/>
                                    <a href="mailto:{{ $campaign->contact_email }}"
                                       target="_blank">{{ $campaign->contact_email }}</a><br/>
                                    {{ $campaign->contact_school }}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (($order->state == 'new' && $campaign->shipping_individual) || ($order->state != 'new' && $order->shipping_type == 'individual'))
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingIndividual">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse"
                                       data-parent="#shipping-options"
                                       href="#collapseIndividual"
                                       aria-expanded="{{ $order->shipping_type != 'group' ? 'true' : 'false' }}"
                                       aria-controls="collapseIndividual">
                                        Individual Shipping (${{ 7 + (2 * ($order->quantity - 1)) }} extra charge) <span
                                                class="glyphicon glyphicon-ok-circle active-shipping"
                                                aria-hidden="true"></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseIndividual"
                                 class="panel-collapse collapse {{ $order->shipping_type != 'group' ? 'in' : '' }}"
                                 role="tabpanel"
                                 aria-labelledby="headingIndividual">
                                <div class="panel-body">
                                    <div class="form-group">
                                        @if ($order->state == 'new')
                                            {!! Form::text('shipping_line1', old('shipping_line1', $order->shipping_line1), ['class' => 'form-control order-field', 'placeholder' => 'Shipping Address line 1']) !!}
                                        @else
                                            {{ $order->shipping_line1 }}
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        @if ($order->state == 'new')
                                            {!! Form::text('shipping_line2', old('shipping_line2', $order->shipping_line2), ['class' => 'form-control order-field', 'placeholder' => 'Shipping Address line 2']) !!}
                                        @else
                                            {{ $order->shipping_line2 }}
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                @if ($order->state == 'new')
                                                    {!! Form::text('shipping_city', old('shipping_city', $order->shipping_city), ['class' => 'form-control order-field', 'placeholder' => 'Shipping City']) !!}
                                                @else
                                                    {{ $order->shipping_city }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                @if ($order->state == 'new')
                                                    {!! Form::text('shipping_state', old('shipping_state', $order->shipping_state), ['class' => 'form-control order-field', 'placeholder' => 'Shipping State']) !!}
                                                @else
                                                    {{ $order->shipping_state }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        @if ($order->state == 'new')
                                            {!! Form::text('shipping_zip_code', old('shipping_zip_code', $order->shipping_zip_code), ['class' => 'form-control order-field', 'placeholder' => 'Shipping Zip Code']) !!}
                                        @else
                                            {{ $order->shipping_zip_code }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div id="contact-information">
                    <h2><i class="fa fa-user" aria-hidden="true"></i> Contact Information</h2>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                @if ($order->state == 'new')
                                    {!! Form::text('contact_first_name', old('contact_first_name', $order->contact_first_name), ['class' => 'form-control  order-field', 'placeholder' => 'First Name']) !!}
                                @else
                                    {{ $order->contact_first_name ?? 'N/A' }}
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                @if ($order->state == 'new')
                                    {!! Form::text('contact_last_name', old('contact_last_name', $order->contact_last_name), ['class' => 'form-control  order-field', 'placeholder' => 'Last Name']) !!}
                                @else
                                    {{ $order->contact_last_name ?? 'N/A' }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        @if ($order->state == 'new')
                            {!! Form::text('contact_email', old('contact_email', $order->contact_email), ['class' => 'form-control  order-field', 'placeholder' => 'Email Address']) !!}
                        @else
                            {{ $order->contact_email ?? 'N/A' }}
                        @endif
                    </div>
                    <div class="form-group">
                        @if ($order->state == 'new')
                            {!! Form::text('contact_phone', old('contact_phone', $order->contact_phone), ['class' => 'form-control  order-field', 'placeholder' => 'Phone Number']) !!}
                        @else
                            {{ $order->contact_phone ?? 'N/A' }}
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                @if ($order->state == 'new')
                                    {!! Form::text('contact_school', old('contact_school', $order->contact_school), ['class' => 'form-control  order-field', 'placeholder' => 'College']) !!}
                                @else
                                    {{ $order->contact_school ?? $campaign->contact_school ?? 'N/A' }}
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                @if ($order->state == 'new')
                                    {!! Form::text('contact_chapter', old('contact_chapter', $order->contact_chapter), ['class' => 'form-control  order-field', 'placeholder' => 'Chapter']) !!}
                                @else
                                    {{ $order->contact_chapter ?? $campaign->contact_chapter ?? 'N/A' }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                @if ($order->state == 'new')
                                    {!! Form::select('contact_graduation_year', graduation_year_options('Select Your Graduation Year'), old('contact_graduation_year', $order->contact_graduation_year), ['class' => 'form-control order-field select-placeholder']) !!}

                                @else
                                    {{ $order->contact_graduation_year ?? $campaign->contact_graduation_year ?? 'N/A' }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div id="billing-information">
                    <h2><i class="fa fa-list-alt" aria-hidden="true"></i> Billing Information
                        @if ($order->state == 'new')
                            <div class="checkbox billing-same-as-shipping">
                                <label data-toggle="collapse" data-target="#collapseBilling">
                                    <input type="checkbox" class="order-field" name="billing_same_as_shipping"/> Same as
                                    Shipping
                                </label>
                            </div>
                        @endif
                    </h2>
                    <div class="panel-collapse collapse in" id="collapseBilling">
                        <div class="form-group">
                            @if ($order->state == 'new')
                                {!! Form::text('billing_line1', old('billing_line1', $order->billing_line1), ['class' => 'form-control order-field', 'placeholder' => 'Billing Address line 1']) !!}
                            @else
                                {{ $order->billing_line1 }}
                            @endif
                        </div>
                        <div class="form-group">
                            @if ($order->state == 'new')
                                {!! Form::text('billing_line2', old('billing_line2', $order->billing_line2), ['class' => 'form-control order-field', 'placeholder' => 'Billing Address line 2']) !!}
                            @else
                                {{ $order->billing_line2 }}
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    @if ($order->state == 'new')
                                        {!! Form::text('billing_city', old('billing_city', $order->billing_city), ['class' => 'form-control order-field', 'placeholder' => 'Billing City']) !!}
                                    @else
                                        {{ $order->billing_city }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    @if ($order->state == 'new')
                                        {!! Form::text('billing_state', old('billing_state', $order->billing_state), ['class' => 'form-control order-field', 'placeholder' => 'Billing State']) !!}
                                    @else
                                        {{ $order->billing_state }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @if ($order->state == 'new')
                                {!! Form::text('billing_zip_code', old('billing_zip_code', $order->billing_zip_code), ['class' => 'form-control order-field', 'placeholder' => 'Billing Zip Code']) !!}
                            @else
                                {{ $order->billing_zip_code }}
                            @endif
                        </div>
                    </div>
                </div>
                <div id="payment-information">
                    <h2><i class="fa fa-lock"></i> Payment Information</h2>
                    @if ($order->state == 'new' || $order->billing_provider == 'authorized')
                        <div id="payment-card">
                            <div class="pay-title">
                                <label>
                                    @if ($order->state == 'new')
                                        {!! Form::radio('payment_method', 'card', ! in_array(old('payment_method', $order->payment_method), ['manual', 'test']), ['class' => 'order-field ' . ((!$checkoutManual && !$checkoutTest) ? 'hidden-override': '')]) !!}
                                    @endif
                                    Payment By Card</label>
                                <span class="card-amex pull-right"><img src="{{ static_asset('images/card-amex.jpg') }}"
                                                                        alt="card"/></span>
                            </div>
                            <div class="accordion_content">
                                @if ($order->state == 'new')
                                    <form method="post" id="authorize-acceptjs">
                                        <div class="form-group">
                                            <input type="tel" class='form-control' value="" id="cardNumberID" placeholder="Card Number" autocomplete="off"/>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class='form-control' value="" id="cardName" placeholder="Card Name" autocomplete="off"/>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <div class="form-group form-group-pair">
                                                    <input type="text" class='form-control' id="monthID" placeholder="MM" value=""/>
                                                    <input type="text" class='form-control' id="yearID" placeholder="YYYY" value=""/>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <input type="text" class='form-control' id="cardCodeID" placeholder="CVC"/>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="form-group">
                                        Paid ${{ $order->total }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if (($order->state == 'new' && $checkoutManual) || ($order->state != 'new' && $order->billing_provider == 'manual'))
                        <div id="payment-manual">
                            <div class="pay-title">
                                <label>
                                    @if ($order->state == 'new')
                                        {!! Form::radio('payment_method', 'manual', old('payment_method', $order->payment_method) == 'manual', ['class' => 'order-field']) !!}
                                    @endif
                                    Manual
                                    Payment</label>
                            </div>
                            <div class="accordion_content">
                                @if ($order->state == 'new')
                                    <div class="cart-footer">
                                        <div class="cart-footer-subtotal quantity-field">
                                            <div class="total-title total-title-short">Authorized Qty</div>
                                            <div class="total-value">{{ $campaign->getAuthorizedQuantity() }}</div>
                                        </div>
                                        <div class="cart-footer-tax quantity-field">
                                            <div class="total-title total-title-short">Charged Qty</div>
                                            <div class="total-value">{{ $campaign->getSuccessQuantity() }}</div>
                                        </div>
                                        <div class="cart-footer-shipping quantity-field">
                                            <div class="total-title total-title-short">Final Qty</div>
                                            <div class="total-value">{{ $campaign->getAuthorizedQuantity() + $campaign->getSuccessQuantity() + $order->quantity }}</div>
                                        </div>
                                        <div class="cart-footer-total quantity-field">
                                            <div class="total-title total-title-short">Price Per Item</div>
                                            <div class="total-value">{!! Form::text('manual_payment_price', round($campaign->quote_high * 1.07, 2), ['class' => 'form-control order-field']) !!}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group">
                                        Paid ${{ $order->total }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if (($order->state == 'new' && $checkoutTest) || ($order->state != 'new' && $order->billing_provider == 'test'))
                        <div id="payment-test">
                            <div class="pay-title">
                                <label>
                                    @if ($order->state == 'new')
                                        {!! Form::radio('payment_method', 'test', old('payment_method', $order->payment_method) == 'test', ['class' => 'order-field']) !!}
                                    @endif
                                    Test Payment</label>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="checkout-footer">
                    @if ($order->state == 'new')
                        <button id="place-order">Place Your Order
                            <i class='fa fa-spinner'></i>
                        </button>
                        <p>By clicking 'Place Your Order' you agree to our <a href="#">privacy policy</a> and <a
                                    href="#">terms of service</a>.</p>
                        <p><label><input type="checkbox" value="1" checked="checked" name="receive_emails" class="order-field"/> I would
                                like to receive emails about new products directly from these sellers or any
                                licensed partners</label></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @if ($checkoutManual)
        {!! Form::open(['id' => 'checkout-manual', 'route' => ['checkout::checkout_manual', product_to_description($campaign->id, $campaign->name), $order->id]]) !!}
        <input type="hidden" id="manual-price" name="manual_payment_price"/>
        <button type="submit" class="hidden">Submit Manual</button>
        {!! Form::close() !!}
    @endif
    @if ($checkoutManual)
        {!! Form::open(['id' => 'checkout-test', 'route' => ['checkout::checkout_test', product_to_description($campaign->id, $campaign->name), $order->id]]) !!}
        <button type="submit" class="hidden">Submit Test</button>
        {!! Form::close() !!}
    @endif
@endsection


@section ('javascript')
    @if ($order->state == 'new')
        <script>
            $('#shipping-options .panel-heading a').on('click', function (e) {
                if ($(this).parents('.panel').children('.panel-collapse').hasClass('in')) {
                    e.stopPropagation();
                }
                e.preventDefault();
            });
        </script>

        <script>
            let GreekHouse = {
                checkout: {
                    payment: {
                        shippingCost: parseFloat("{{ 7 + (2 * ($order->quantity - 1)) }}"),
                        shipping: parseFloat("{{ $order->shipping }}"),
                        subtotal: parseFloat("{{ $order->subtotal * 1.07 }}"),
                        total: parseFloat("{{ $order->total }}"),
                    },
                    init: function () {
                        // Automatically save information
                        $('.order-field').change(GreekHouse.checkout.saveInformation);
                        GreekHouse.checkout.saveInformation();

                        // Submit
                        $('#place-order').click(GreekHouse.checkout.submit);

                        //
                        $('#shipping-options .panel-collapse').on('shown.bs.collapse', function () {
                            GreekHouse.checkout.updateSameAsShipping();
                            GreekHouse.checkout.saveInformation();
                        });
                    },
                    onError: function (e) {
                        try {
                            $('#payment-form').submit();
                        } catch (e) {
                        }
                    },
                    saveInformation: function (event, callback) {
                        let data = {};
                        $('.order-field').each(function () {
                            if (($(this).attr('type') !== 'radio' && $(this).attr('type') !== 'checkbox') || $(this).prop('checked')) {
                                data[$(this).attr('name')] = $(this).val();
                            }
                        });
                        $.ajax({
                            method: 'POST',
                            url: '{{ route('checkout::ajax_save_information', [$order->id]) }}',
                            data: data,
                            success: function (data) {
                                if (typeof callback !== 'undefined') {
                                    callback();
                                }
                            },
                            error: function (data) {
                                GreekHouse.checkout.addError('Error while saving information');
                            }
                        });
                    },
                    submit: function (event) {
                        try {
                            $('#error-area').html('');
                            $('#place-order').prop('disabled', true);
                            GreekHouse.checkout.saveInformation(event, function (event) {
                                try {
                                    $('#error-area').html('');
                                    $('#place-order').prop('disabled', true);
                                    if (event) {
                                        event.preventDefault();
                                    }
                                    var data = {
                                        manual_payment_price: $('input[name=manual_payment_price]').val()
                                    };
                                    $.ajax({
                                        method: 'POST',
                                        url: '{{ route('checkout::ajax_validate_information', [$order->id]) }}',
                                        data: data,
                                        dataType: 'json',
                                        success: function (data) {
                                            try {
                                                $('#place-order').prop('disabled', false);
                                                if (data.success) {
                                                    if ($('input[name=payment_method]:checked').val() === 'manual') {
                                                        $('#manual-price').val($('input[name=manual_payment_price]').val());
                                                        $('#checkout-manual').submit();
                                                        return;
                                                    }
                                                    else if ($('input[name=payment_method]:checked').val() === 'test') {
                                                        $('#checkout-test').submit();
                                                        return;
                                                    }
                                                    else {
                                                        AcceptJS.sendPaymentDataToAnet();
                                                        //AcceptJS.processTransaction({dataDescriptor: 'description!', dataValue: 'code!'});
                                                        return false;
                                                    }
                                                } else {
                                                    $.each(data.errors, function (index, value) {
                                                        GreekHouse.checkout.addError(value);
                                                    });
                                                    $('html, body').animate({
                                                        scrollTop: $("#error-area").offset().top
                                                    }, 500);
                                                }
                                            } catch (error) {
                                                GreekHouse.checkout.submitFallback();
                                                throw error;
                                            }
                                        },
                                        error: function (data) {
                                            try {
                                                $('#place-order').prop('disabled', false);
                                                GreekHouse.checkout.addError('Error while validating information');
                                                $('html, body').animate({
                                                    scrollTop: $("#error-area").offset().top
                                                }, 500);
                                            } catch (error) {
                                                GreekHouse.checkout.submitFallback();
                                                throw error;
                                            }
                                        }
                                    });
                                    return false;
                                } catch (error) {
                                    GreekHouse.checkout.submitFallback();
                                    throw error;
                                }
                            });
                            event.preventDefault();
                            return false;
                        } catch (error) {
                            GreekHouse.checkout.submitFallback();
                            throw error;
                        }
                    },
                    submitFallback: function (error) {
                        $('#error-area').html('');
                        $('#place-order').prop('disabled', false);
                        if ($.isArray(error)) {
                            error.forEach(function (value) {
                                GreekHouse.checkout.addError(value);
                            });
                        } else {
                            GreekHouse.checkout.addError(error ? error : 'Server Internal Error');
                        }
                        $('html, body').animate({
                            scrollTop: $("#error-area").offset().top
                        }, 500);
                    },
                    updateSameAsShipping: function () {
                        if ($('#collapseGroup').hasClass('in')) {
                            $('#shipping_type').val('group');
                            GreekHouse.checkout.updateShippingCost();
                            if ($('.billing-same-as-shipping input').prop('checked')) {
                                $('.billing-same-as-shipping input').prop('checked', false);
                                $('#collapseBilling').collapse('show');
                            }
                            $('.billing-same-as-shipping').hide();
                        } else {
                            $('#shipping_type').val('individual');
                            GreekHouse.checkout.updateShippingCost();
                            $('.billing-same-as-shipping').show();
                        }
                    },
                    updateShippingCost: function () {
                        if ($('#shipping_type').val() !== 'group') {
                            GreekHouse.checkout.payment.shipping = GreekHouse.checkout.payment.shippingCost;
                            $('.order-shipping .pull-right').text('$' + GreekHouse.checkout.payment.shipping.toFixed(2));
                            $('.order-shipping').show();
                        } else {
                            GreekHouse.checkout.payment.shipping = 0;
                            $('.order-shipping').hide();
                        }
                        $('#shipping-input').val(GreekHouse.checkout.payment.shipping);
                        GreekHouse.checkout.payment.total = GreekHouse.checkout.payment.subtotal + GreekHouse.checkout.payment.shipping;
                        $('.order-total-value').text('$' + GreekHouse.checkout.payment.total.toFixed(2));
                    },
                    addError: function (error) {
                        $('#error-area').append($('<div class="alert alert-danger" role="alert"></div>').text(error));
                        try {
                            $.ajax({
                                type: 'GET',
                                url: '{{ route('system::logic_error') }}',
                                data: 'error=' + encodeURIComponent(error) + '&url=' + window.location,
                                cache: false
                            });
                        } catch (err) {
                        }
                    }
                }
            };

            GreekHouse.checkout.init();
        </script>

        @if (App::environment() == 'production')
            <script>
                $.ajaxSetup({
                    cache: true
                });

                function loadScript(script) {
                    jQuery.ajax({
                        async: false,
                        type: 'GET',
                        url: script,
                        data: null,
                        success: function () {
                            console.log(script + ' force loaded');
                        },
                        dataType: 'script',
                        error: function (xhr, textStatus, errorThrown) {
                            console.log(script + ' ' + textStatus);
                        }
                    });
                }

                loadScript('https://js.authorize.net/v1/AcceptCore.js');
                loadScript('https://js.authorize.net/v1/Accept.js');
            </script>
            <script type="text/javascript" src="https://js.authorize.net/v1/Accept.js" charset="utf-8"></script>
        @else
            <script type="text/javascript" src="https://jstest.authorize.net/v1/Accept.js" charset="utf-8"></script>
        @endif

        <script>
            let AcceptJS = {
                sendPaymentDataToAnet: function () {
                    let secureData = {};
                    let authData = {};
                    let cardData = {};

                    // Extract the card number, expiration date, and card code.
                    cardData.fullName = $('#cardName').val();
                    cardData.cardNumber = $('#cardNumberID').val();
                    cardData.month = $('#monthID').val();
                    cardData.year = $('#yearID').val();
                    cardData.cardCode = $('#cardCodeID').val();
                    secureData.cardData = cardData;

                    // The Authorize.Net Client Key is used in place of the traditional Transaction Key. The Transaction Key
                    // is a shared secret and must never be exposed. The Client Key is a public key suitable for use where
                    // someone outside the merchant might see it.
                    authData.clientKey = "{{ config('greekhouse.billing.providers.authorize.public_key') }}";
                    authData.apiLoginID = "{{ config('greekhouse.billing.providers.authorize.login') }}";
                    secureData.authData = authData;

                    // Pass the card number and expiration date to Accept.js for submission to Authorize.Net.
                    Accept.dispatchData(secureData, responseHandler);

                    // Process the response from Authorize.Net to retrieve the two elements of the payment nonce.
                    // If the data looks correct, record the OpaqueData to the console and call the transaction processing function.
                    function responseHandler(response) {
                        if (response.messages.resultCode === "Error") {
                            let errors = [];
                            for (let i = 0; i < response.messages.message.length; i++) {
                                errors.push(response.messages.message[i].text);
                            }
                            GreekHouse.checkout.submitFallback(errors);
                        } else {
                            AcceptJS.processTransaction(response.opaqueData);
                        }
                    }
                },
                processTransaction: function (responseData) {
                    //create the form and attach to the document
                    let transactionForm = document.createElement("form");
                    transactionForm.Id = "transactionForm";
                    transactionForm.action = "{{ route('checkout::checkout_authorize', [product_to_description($campaign->id, $campaign->name), $order->id]) }}";
                    transactionForm.method = "POST";
                    document.body.appendChild(transactionForm);

                    //create form "input" elements corresponding to each parameter
                    let csrf = document.createElement("input");
                    csrf.hidden = true;
                    csrf.value = "{{ csrf_token() }}";
                    csrf.name = "_token";
                    transactionForm.appendChild(csrf);

                    //create form "input" elements corresponding to each parameter
                    let description = document.createElement("input");
                    description.hidden = true;
                    description.value = responseData.dataDescriptor;
                    description.name = "description";
                    transactionForm.appendChild(description);

                    let code = document.createElement("input");
                    code.hidden = true;
                    code.value = responseData.dataValue;
                    code.name = "code";
                    transactionForm.appendChild(code);

                    //submit the new form
                    transactionForm.submit();
                }
            };
        </script>
    @endif
@append