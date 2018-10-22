@extends('v2.layouts.app')

@section ('title', 'Store Checkout')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
<div class="page checkout">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="gh-title text-uppercase text-center blue">Checkout</h3>
                <?php
                    //Todo: Select first order and fill data, else leave empty?
                    //dd($cart->orders);
                    $order = $cart->orders[0]; //TODO Find first filled order in array?
                    $campaign = $order->campaign;
                ?>
                <div class="checkout__shipping">
                    <h5>Group Shipping</h5>
                    <div>{{ $campaign->getContactFullName() }}</div>
                    <div><a href="mailto:{{ $campaign->contact_email }}" t target="_blank">{{ $campaign->contact_email }}</a></div>
                    <div>{{ $campaign->contact_school }}</div>
                </div>

                <!--<form name="shopping-cart-form" id="shopping-cart-form">-->
                {!! Form::open(['url' => Request::fullUrl(), 'id' => 'shopping-cart-form merchant-form']) !!}

                    <section class="checkout__section">
                        <h5 class="gh-subtitle text-uppercase text-center blue">Contact Information</h5>
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
                            <div class="form-group col-lg-6">
                                @if ($order->state == 'new')
                                    {!! Form::text('contact_email', old('contact_email', $order->contact_email), ['class' => 'gh-control', 'placeholder' => 'Email Address']) !!}
                                @else
                                    {{ $order->contact_email ?? 'N/A' }}
                                @endif
                            </div>
                            <div class="form-group col-lg-6">
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
                    </section>

                    <section class="checkout__section">
                        <h5 class="gh-subtitle text-uppercase text-center blue">Billing Information</h5>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                @if ($order->state == 'new')
                                    {!! Form::text('billing_line1', old('billing_line1', $order->billing_line1), ['class' => 'gh-control', 'placeholder' => 'Billing Address line 1']) !!}
                                @else
                                    {{ $order->billing_line1 }}
                                @endif
                            </div>
                            <div class="form-group col-lg-6">
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
                            <div class="form-group col-lg-6">
                                 @if ($order->state == 'new')
                                    {!! Form::text('billing_zip_code', old('billing_zip_code', $order->billing_zip_code), ['class' => 'gh-control', 'placeholder' => 'Billing Zip Code']) !!}
                                @else
                                    {{ $order->billing_zip_code }}
                                @endif
                            </div>
                        </div>
                    </section>

                    <section class="checkout__section checkout__payment">
                        <h5 class="gh-subtitle text-uppercase text-center blue">Payment Information</h5>
                        <input type="hidden" id="vault_nonce" name="vault_nonce" >
                        <input type="hidden" id="device_data" name="device_data" >
                        <div class="row">
                             <div class="col-lg-12 text-center">
                                <div id="paypal-container" class=""></div>
                            </div>

                            <!--
                            <div class="col-lg-8 payment__left">
                                <div class="payment__type">
                                    <div>
                                         @if ($order->state == 'new')
                                            {!! Form::radio('payment_method', 'card', ! in_array(old('payment_method', $order->payment_method), ['manual', 'test']), ['id' => 'payByCard','class' => 'green-radio blue hidden-override']) !!}
                                        @endif
                                        <input class="colored-radio blue" type="radio" name="payment-type" id="payByCard" checked>
                                        <label class="" for="payByCard">Payment&nbsp;by&nbsp;Card</label>
                                    </div>
                                    <div>
                                        <div class="type__icon discover"><img src="/images/test/payment-icons/discover.svg"></div>
                                        <div class="type__icon"><img src="/images/test/payment-icons/american_express.svg"></div>
                                        <div class="type__icon"><img src="/images/test/payment-icons/visa.svg"></div>
                                        <div class="type__icon"><img src="/images/test/payment-icons/mastercard.svg"></div>
                                    </div>
                                </div>
                                <div class="row payment__card-number">
                                    <div class="form-group col-12">
                                        <input type="text" class="gh-control" placeholder="Card Number">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <input type="text" class="gh-control" placeholder="Name on Card">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 align-self-end payment__right">
                                <div class="row payment__expiration">
                                    <div class="form-group col-6">
                                        <label class="gh-label">Expiration&nbsp;Date</label>
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
                                    <div class="form-group col-6 align-self-end">
                                        <select class="gh-control">
                                            <option>2018</option>
                                            <option>2019</option>
                                            <option>2020</option>
                                            <option>2021</option>
                                            <option>2022</option>
                                            <option>2023</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label class="gh-label">
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
                            -->
                        </div>
                        <div class="row payment__shipping">
                            <div class="col-lg-3 col-md-6 text-md-left text-center">
                                <h6 class="gh-subtitle">Shipping and Handling:</h6>
                            </div>
                            <div class="col-lg-9 col-md-6 text-md-left text-center">
                                <div class="shipping__option">
                                    <input class="colored-radio blue" type="radio" name="shipping" id="shipping1"  value="10.00" checked>
                                    <label class="" for="shipping1">Flat Rate: $10.00</label>
                                </div>
                                <div class="shipping__option">
                                    <input class="colored-radio blue" type="radio" name="shipping" id="shipping2" value="60.00">
                                    <label class="" for="shipping2">International: $60.00</label>
                                </div>
                                <div class="shipping__option">
                                    <input class="colored-radio blue" type="radio" name="shipping" id="shipping3" value="5.00">
                                    <label class="" for="shipping3">Local Delivery: $5.00</label>
                                </div>
                                <div class="shipping__option">
                                    <input class="colored-radio blue" type="radio" name="shipping" id="shipping4" value="0">
                                    <label class="" for="shipping4">Local Pickup (Free)</label>
                                </div>
                            </div>

                        </div>
                    </section>

                    <div class="shopping-cart__products">
                         @foreach($cart->orders as $order)
                            @include('v2.home.custom_store.partials.cart_product', ["product" => $order])
                        @endforeach

                        <div class="cart__product subtotal">
                            <div class="subtotal__coupon">
                                <input type="text" class="gh-control" placeholder="Enter coupon code">
                                <input type="button" class="gh-btn blue-transparent" value="Apply">
                            </div>

                            <div class="subtotal__prices">
                                <div class="subtotal__price order-shipping">
                                    <div class="price__label">Shipping Cost:</div>
                                    <div class="price__value" id="cart-shipping">${{ $order->shipping }}</div>
                                </div>
                                <div class="subtotal__price order-subtotal">
                                    <div class="price__label">Cart Subtotal:</div>
                                    <div class="price__value" id="cart-subtotal">{{ money($order->total - $order->shipping) }}</div>
                                </div>
                                <div class="subtotal__price total-price order-total">
                                    <div class="price__label">Order Total:</div>
                                    <div class="price__value" id="cart-total">${{ $order->total }}</div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="checkout__submit">
                        <input class="gh-btn blue big text-uppercase" type="submit" value="Place your order" />
                    </div>
                    <div class="checkout__terms">
                        By clicking ‘Place Your Order’ you agree to our <a href="#">privacy policy</a> and <a href="#">terms of service</a>.
                        <div class="terms__checkbox">
                            <input class="greekhouse-checkbox" type="checkbox" id="newsAgree" checked>
                            <label class="" for="newsAgree">
                                I would like to receive emails about new products directly from these sellers or any licensed partners.
                            </label>
                        </div>
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection


@section ('javascript')
    <script src="https://js.braintreegateway.com/js/braintree-2.32.1.min.js"></script>
    <script type="text/javascript">
        //braintree test token:
        //var clientToken = "eyJ2ZXJzaW9uIjoyLCJhdXRob3JpemF0aW9uRmluZ2VycHJpbnQiOiI4MjEyZWZiNTM5OTI1MThlYjhhYzRjMzMyOGIwNGY4YTRjNjY0MDEwOTZhMWU3ODcxOTBkNmE5OGNhZmZkMTQyfGNyZWF0ZWRfYXQ9MjAxOC0wNy0xNlQxMToyMjoxNS43MjkwMjUyNDgrMDAwMFx1MDAyNm1lcmNoYW50X2lkPTM0OHBrOWNnZjNiZ3l3MmJcdTAwMjZwdWJsaWNfa2V5PTJuMjQ3ZHY4OWJxOXZtcHIiLCJjb25maWdVcmwiOiJodHRwczovL2FwaS5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tOjQ0My9tZXJjaGFudHMvMzQ4cGs5Y2dmM2JneXcyYi9jbGllbnRfYXBpL3YxL2NvbmZpZ3VyYXRpb24iLCJjaGFsbGVuZ2VzIjpbXSwiZW52aXJvbm1lbnQiOiJzYW5kYm94IiwiY2xpZW50QXBpVXJsIjoiaHR0cHM6Ly9hcGkuc2FuZGJveC5icmFpbnRyZWVnYXRld2F5LmNvbTo0NDMvbWVyY2hhbnRzLzM0OHBrOWNnZjNiZ3l3MmIvY2xpZW50X2FwaSIsImFzc2V0c1VybCI6Imh0dHBzOi8vYXNzZXRzLmJyYWludHJlZWdhdGV3YXkuY29tIiwiYXV0aFVybCI6Imh0dHBzOi8vYXV0aC52ZW5tby5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tIiwiYW5hbHl0aWNzIjp7InVybCI6Imh0dHBzOi8vb3JpZ2luLWFuYWx5dGljcy1zYW5kLnNhbmRib3guYnJhaW50cmVlLWFwaS5jb20vMzQ4cGs5Y2dmM2JneXcyYiJ9LCJ0aHJlZURTZWN1cmVFbmFibGVkIjp0cnVlLCJwYXlwYWxFbmFibGVkIjp0cnVlLCJwYXlwYWwiOnsiZGlzcGxheU5hbWUiOiJBY21lIFdpZGdldHMsIEx0ZC4gKFNhbmRib3gpIiwiY2xpZW50SWQiOm51bGwsInByaXZhY3lVcmwiOiJodHRwOi8vZXhhbXBsZS5jb20vcHAiLCJ1c2VyQWdyZWVtZW50VXJsIjoiaHR0cDovL2V4YW1wbGUuY29tL3RvcyIsImJhc2VVcmwiOiJodHRwczovL2Fzc2V0cy5icmFpbnRyZWVnYXRld2F5LmNvbSIsImFzc2V0c1VybCI6Imh0dHBzOi8vY2hlY2tvdXQucGF5cGFsLmNvbSIsImRpcmVjdEJhc2VVcmwiOm51bGwsImFsbG93SHR0cCI6dHJ1ZSwiZW52aXJvbm1lbnROb05ldHdvcmsiOnRydWUsImVudmlyb25tZW50Ijoib2ZmbGluZSIsInVudmV0dGVkTWVyY2hhbnQiOmZhbHNlLCJicmFpbnRyZWVDbGllbnRJZCI6Im1hc3RlcmNsaWVudDMiLCJiaWxsaW5nQWdyZWVtZW50c0VuYWJsZWQiOnRydWUsIm1lcmNoYW50QWNjb3VudElkIjoiYWNtZXdpZGdldHNsdGRzYW5kYm94IiwiY3VycmVuY3lJc29Db2RlIjoiVVNEIn0sIm1lcmNoYW50SWQiOiIzNDhwazljZ2YzYmd5dzJiIiwidmVubW8iOiJvZmYifQ==";
        var clientToken = "{{ $clientToken }}";

        braintree.setup(clientToken, "custom", {
            paypal: {
                container: "paypal-container",
                singleUse: false,
                billingAgreementDescription: '',
                locale: 'en_US',
                enableShippingAddress: true,
                shippingAddressOverride: {
                    recipientName: $('input[name=contact_first_name]').val() + ' ' + $('input[name=contact_last_name]').val(),
                    /*
                    streetAddress: '1234 Main St.',
                    extendedAddress: 'Unit 1',
                    locality: 'Chicago',
                    countryCodeAlpha2: 'US',
                    postalCode: '60652',
                    region: 'IL',
                    phone: '123.456.7890',
                    editable: false
                    */
                }
            },
            dataCollector: {
                paypal: true
            },
            onPaymentMethodReceived: function (obj) {
                //doSomethingWithTheNonce(obj.nonce);
                $('#vault_nonce').val(obj.nonce);
                console.log(obj);
            },
            onReady: function (braintreeInstance) {
                $('#device_data').val(braintreeInstance.deviceData);
            }
        });
        /*
        braintree.setup(clientToken, "dropin", {
            container: "paypal-container"
        });
        */
    </script>
    {{-- old stuff --}}
    @if ($order->state == 'new')
        <script>
            $('#shipping-options .panel-heading a').on('click', function (e) {
                if ($(this).parents('.panel').children('.panel-collapse').hasClass('in')) {
                    e.stopPropagation();
                }
                e.preventDefault();
            });

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
                    transactionForm.action = "{{ route('checkout::checkout_authorize', ['', null]) }}";
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