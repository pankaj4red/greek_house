@extends('v2.layouts.app')

@section('title', 'Purchase')

@section('content')
    @include('v2.partials.messages.all')
    <div class="page page__campaign">
        <div class="container">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            <div id="error-area"></div>
            <div id="checkout-area" class="row flex-lg-row flex-column-reverse">
                <div class="col-lg-6">
                    {!! Form::hidden('shipping_type', $order->shipping_type, ['class' => 'order-field', 'id' => 'shipping_type']) !!}
                    @if (($order->state == 'new' && $campaign->shipping_group) || ($order->state != 'new' && $order->shipping_type == 'group'))
                        <div class="block-info-rounded block-checkout" id="shipping-options">
                            <div class="block-info__title">
                                Shipping Information
                            </div>
                            <div class="block-info__body checkout__shipping">
                                <h5>Group Shipping</h5>
                                <div>{{ $campaign->getContactFullName() }}</div>
                                <div><a href="mailto:{{ $campaign->contact_email }}" target="_blank">{{ $campaign->contact_email }}</a></div>
                                <div>{{ $campaign->contact_school }}</div>
                            </div>
                        </div>
                    @endif
                    @if (($order->state == 'new' && $campaign->shipping_individual) || ($order->state != 'new' && $order->shipping_type == 'individual'))
                        <div class="block-info-rounded block-checkout" id="shipping-options">
                            <div class="block-info__title">
                                Shipping Information
                            </div>
                            <div class="block-info__body checkout__shipping">
                                <h5>Individual Shipping (${{ 7 + (2 * ($order->quantity - 1)) }} extra charge)</h5>
                                <div>{{ $campaign->getContactFullName() }}</div>
                                <div><a href="mailto:{{ $campaign->contact_email }}" target="_blank">{{ $campaign->contact_email }}</a></div>
                                <div>{{ $campaign->contact_school }}</div>
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
                    <div class="block-info-rounded block-checkout" id="contact-information">
                        <div class="block-info__title">
                            Contact Information
                        </div>
                        <div class="block-info__body">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    @if ($order->state == 'new')
                                        {!! Form::text('contact_first_name', old('contact_first_name', $order->contact_first_name), ['class' => 'gh-control', 'placeholder' => 'First Name']) !!}
                                    @else
                                        {{ $order->contact_first_name ?? 'N/A' }}
                                    @endif
                                </div>
                                <div class="form-group col-lg-6">
                                    @if ($order->state == 'new')
                                        {!! Form::text('contact_last_name', old('contact_last_name', $order->contact_last_name), ['class' => 'gh-control', 'placeholder' => 'Last Name']) !!}
                                    @else
                                        {{ $order->contact_last_name ?? 'N/A' }}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    @if ($order->state == 'new')
                                        {!! Form::text('contact_email', old('contact_email', $order->contact_email), ['class' => 'gh-control', 'placeholder' => 'Email Address']) !!}
                                    @else
                                        {{ $order->contact_email ?? 'N/A' }}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    @if ($order->state == 'new')
                                        {!! Form::text('contact_phone', old('contact_phone', $order->contact_phone), ['class' => 'gh-control', 'placeholder' => 'Phone Number']) !!}
                                    @else
                                        {{ $order->contact_phone ?? 'N/A' }}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    @if ($order->state == 'new')
                                        {!! Form::text('contact_school', old('contact_school', $order->contact_school), ['class' => 'gh-control', 'placeholder' => 'College']) !!}
                                    @else
                                        {{ $order->contact_school ?? $campaign->contact_school ?? 'N/A' }}
                                    @endif
                                </div>
                                <div class="form-group col-lg-6">
                                    @if ($order->state == 'new')
                                        {!! Form::text('contact_chapter', old('contact_chapter', $order->contact_chapter), ['class' => 'gh-control', 'placeholder' => 'Chapter']) !!}
                                    @else
                                        {{ $order->contact_chapter ?? $campaign->contact_chapter ?? 'N/A' }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-info-rounded block-checkout" id="billing-information">
                        <div class="block-info__title">
                            Billing Information
                            @if ($order->state == 'new')
                                <div class="checkbox billing-same-as-shipping">
                                    <label data-toggle="collapse" data-target="#collapseBilling">
                                        <input type="checkbox" class="order-field" name="billing_same_as_shipping"/> Same as
                                        Shipping
                                    </label>
                                </div>
                            @endif
                        </div>
                        <div class="block-info__body" id="collapseBilling">
                            <div class="row">
                                <div class="form-group col-12">
                                    @if ($order->state == 'new')
                                        {!! Form::text('billing_line1', old('billing_line1', $order->billing_line1), ['class' => 'gh-control', 'placeholder' => 'Billing Address line 1']) !!}
                                    @else
                                        {{ $order->billing_line1 }}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    @if ($order->state == 'new')
                                        {!! Form::text('billing_line2', old('billing_line2', $order->billing_line2), ['class' => 'gh-control', 'placeholder' => 'Billing Address line 2']) !!}
                                    @else
                                        {{ $order->billing_line2 }}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    @if ($order->state == 'new')
                                        {!! Form::text('billing_city', old('billing_city', $order->billing_city), ['class' => 'gh-control', 'placeholder' => 'Billing City']) !!}
                                    @else
                                        {{ $order->billing_city }}
                                    @endif
                                </div>
                                <div class="form-group col-lg-6">
                                    @if ($order->state == 'new')
                                        {!! Form::text('billing_state', old('billing_state', $order->billing_state), ['class' => 'gh-control', 'placeholder' => 'Billing State']) !!}
                                    @else
                                        {{ $order->billing_state }}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    @if ($order->state == 'new')
                                        {!! Form::text('billing_zip_code', old('billing_zip_code', $order->billing_zip_code), ['class' => 'gh-control', 'placeholder' => 'Billing Zip Code']) !!}
                                    @else
                                        {{ $order->billing_zip_code }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-info-rounded block-checkout payment" id="payment-information">
                        <div class="block-info__title">
                            Payment Information
                        </div>
                        <div class="block-info__body">
                            <div class="checkout_payment-type">
                                <div>
                                @if ($order->state == 'new')
                                    {!! Form::radio('payment_method', 'card', ! in_array(old('payment_method', $order->payment_method), ['manual', 'test']), ['class' => 'green-radio ' . ((!$checkoutManual && !$checkoutTest) ? 'hidden-override': '')]) !!}
                                @endif
                                <!--<input class="green-radio" type="radio" name="payment-type" id="payByCard" checked>-->
                                    <label class="" for="payByCard">
                                        Payment&nbsp;by&nbsp;Card</label>
                                </div>
                                <div>
                                    <div class="payment-type__icon discover"><img src="/images/test/payment-icons/discover.svg"></div>
                                    <div class="payment-type__icon"><img src="/images/test/payment-icons/american_express.svg"></div>
                                    <div class="payment-type__icon"><img src="/images/test/payment-icons/visa.svg"></div>
                                    <div class="payment-type__icon"><img src="/images/test/payment-icons/mastercard.svg"></div>
                                <!--<span class="card-amex pull-right"><img src="{{ static_asset('images/card-amex.jpg') }}"
                                                                            alt="card"/></span>-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <input type="text" class="gh-control" placeholder="Card Number" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <input type="text" class="gh-control" placeholder="Name on Card" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3 col-6 ">
                                    <label>Expiration&nbsp;Date</label>
                                    <select class="gh-control">
                                        <option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3 col-6 align-self-end">
                                    <select class="gh-control">
                                        <option>2018</option>
                                        <option>2019</option>
                                        <option>2020</option>
                                        <option>2021</option>
                                        <option>2022</option>
                                        <option>2023</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 col-12">
                                    <label>
                                        CVV Code
                                        <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip"
                                           data-placement="right"
                                           title="Turn your card over and look at the signature box.
                                           You should see either the entire 16-digit credit card number or just the last four
                                           digits followed by a special 3-digit code. This 3-digit code is your CVV number / Card Security Code.">
                                        </i>
                                    </label>
                                    <input type="text" class="gh-control">
                                </div>
                            </div>
                        </div>
                    @if ($order->state == 'new' || $order->billing_provider == 'authorized')
                        <!--
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
                            -->
                        @endif
                        @if (($order->state == 'new' && $checkoutManual) || ($order->state != 'new' && $order->billing_provider == 'manual'))
                            <div class="block-info-rounded block-checkout payment">
                                <div class="block-info__body payment__manual">
                                    <div class="checkout_payment-type">
                                        <div>
                                            <!--<input class="green-radio" type="radio" name="payment-type" id="payManual">-->
                                            @if ($order->state == 'new')
                                                {!! Form::radio('payment_method', 'manual', old('payment_method', $order->payment_method) == 'manual', ['class' => 'green-radio']) !!}
                                            @endif
                                            <label class="" for="payManual">Manual Payment</label>
                                        </div>
                                    </div>

                                    <div class="payment__statistics">
                                        @if ($order->state == 'new')
                                            <div class="stat__item">
                                                <div class="stat__title">Authorized</div>
                                                <div class="stat__number">{{ $campaign->getAuthorizedQuantity() }}</div>
                                            </div>
                                            <div class="stat__item">
                                                <div class="stat__title">Charged</div>
                                                <div class="stat__number">{{ $campaign->getSuccessQuantity() }}</div>
                                            </div>
                                            <div class="stat__item">
                                                <div class="stat__title">Final Qty</div>
                                                <div class="stat__number">{{ $campaign->getAuthorizedQuantity() + $campaign->getSuccessQuantity() + $order->quantity }}</div>
                                            </div>
                                            <div class="stat__item">
                                                <div class="stat__title">Price Per</div>
                                                <div class="stat__price">{!! Form::text('manual_payment_price', $campaign->quote_high, ['class' => 'form-control order-field']) !!}</div>
                                            </div>
                                        @else
                                            <div class="form-group">
                                                Paid ${{ $order->total }}
                                            </div>
                                        @endif
                                    </div>
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
                    @if ($order->state == 'new')
                        <div class="checkout__btn">
                            <button id="place-order" class="gh-btn green">
                                Place your order <!--<i class='fa fa-spinner'></i>-->
                            </button>
                        </div>
                        <div class="checkout__terms">
                            By clicking ‘Place Your Order’ you agree to our <a href="{{ route('home::privacy') }}" target="_blank">privacy policy</a> and <a href="{{ route('home::tos') }}"
                                                                                                                                                             target="_blank">terms of service</a>.
                            <div class="terms__checkbox">
                                <input class="greekhouse-checkbox" type="checkbox" id="newsAgree" name="receive_emails" checked>
                                <label class="" for="newsAgree">
                                    I would like to receive emails about new products directly from these sellers or any licensed partners.
                                </label>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    @if (in_array($order->state, ['authorized', 'authorized_failed']))
                        <div class="alert alert-success text-center">Order Authorized</div>
                    @endif
                    @if (in_array($order->state, ['success']))
                        <div class="alert alert-success text-center">Order Paid</div>
                    @endif
                    @if (!in_array($order->state, ['new', 'authorized', 'authorized_failed', 'success']))
                        <div class="alert alert-warning text-center">Order {{ ucfirst($order->state) }}</div>
                    @endif
                    <div class="block-info-rounded block-checkout">
                        <div class="block-info__title">
                            Order summary
                            @if ($order->state == 'new')
                                <a href="{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) }}?copy={{ $order->id }}">
                                    <i class="pull-right fa fa-edit edit-icon"></i>
                                </a>
                            @endif
                        </div>
                        <div class="block-info__body checkout__summary">
                            @foreach ($order->entries as $orderEntry)
                                <div class="summary__product">
                                    <div class="product__image" style="background-image: url({{ route('system::image', [$campaign->product_colors->first()->product->image_id]) }})"></div>
                                    <div class="product__name">
                                        <div class="">{{ $campaign->name }}</div>
                                        <div class="product__color">{{ $campaign->product_colors->first()->name }} ({{ $orderEntry->size->short }})</div>
                                    </div>
                                    <div class="product__price">{{ $orderEntry->quantity }} x ${{ $orderEntry->price }}</div>
                                </div>
                            @endforeach
                            <div class="summary__info">
                                <div>Subtotal</div>
                                <div>${{ $order->subtotal }}</div>
                            </div>
                            <div class="summary__info">
                                <div>Tax</div>
                                <div>${{ $order->tax }}</div>
                            </div>
                            <div class="summary__info">
                                <div>Shipping</div>
                                <div>${{ $order->shipping }}</div>
                            </div>
                            <div class="summary__info">
                                <div>Total</div>
                                <div class="total">${{ $order->total }}</div>
                            </div>
                        </div>
                        <div class="summary__note">
                            <h5>How long will it take to get my shirt?</h5>
                            <div>
                                Your order will arrive 7-10 business days after the end
                                of the campaign!
                            </div>
                        </div>
                    </div>
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
                        subtotal: parseFloat("{{ $order->subtotal }}"),
                        tax: parseFloat("{{ $order->tax }}"),
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
                        GreekHouse.checkout.payment.total = GreekHouse.checkout.payment.subtotal + GreekHouse.checkout.payment.shipping + GreekHouse.checkout.payment.tax;
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
@endsection
