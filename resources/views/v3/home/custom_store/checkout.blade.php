@extends('v3.layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <div class="container mt-5">
        <h1 class="h3 title-blue text-center mb-5">Checkout</h1>
        {{ Form::open(['id' => 'checkout-form']) }}
        <div class="row">
            <div class="col-12 col-md-6">
                @foreach ($cart->orders as $order)
                    <div class="card mb-3">
                        <div class="card-header">
                            {{ $order->campaign->name }} - Shipping Information
                        </div>
                        <div class="card-body">
                            @if ($order->campaign->shipping_group)
                                @if ($order->campaign->shipping_group && $order->campaign->shipping_individual)
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" class="custom-control-input shipping-type-radio" id="shipping-type-{{ $order->id }}-group" name="shipping_type_{{ $order->id }}"
                                               value="group" {{ $order->shipping_type != 'individual' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="shipping-type-{{ $order->id }}-group">Group Shipping</label>
                                    </div>
                                @else
                                    <div class="font-weight-semi-bold color-slate">Group Shipping</div>
                                @endif
                                <div class="ml-3 color-slate text-sm">{{ $order->campaign->getContactFullName() }}</div>
                                <div class="ml-3 color-slate text-sm"><a href="mailto: {{ $order->campaign->contact_email }}">{{ $order->campaign->contact_email }}</a></div>
                                <div class="ml-3 color-slate text-sm">{{ $order->campaign->contact_school }}</div>
                                @if ($order->campaign->shipping_group && $order->campaign->shipping_individual)
                                    <br/>
                                @endif
                            @endif
                            @if ($order->campaign->shipping_individual)
                                @if ($order->campaign->shipping_group && $order->campaign->shipping_individual)
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input shipping-type-radio shipping-type-individual" data-quantity="{{ $order->quantity }}"
                                               id="shipping-type-{{ $order->id }}-individual"
                                               name="shipping_type_{{ $order->id }}"
                                               value="individual" {{ $order->shipping_type == 'individual' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="shipping-type-{{ $order->id }}-individual">Individual Shipping</label>
                                        <div class="mt-3 color-slate text-sm">$7 Extra For 1st Item; $2 for each additional item</div>
                                    </div>
                                @else
                                    <div class="font-weight-semi-bold color-slate">Individual Shipping</div>
                                    <div class="mt-3 color-slate text-sm">$7 Extra For 1st Item; $2 for each additional item</div>
                                    <input type="hidden" class="shipping-type-individual-quantity" value="{{ $order->quantity }}"/>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
                @foreach ($cart->orders as $order)
                    @if ($order->campaign->shipping_individual)
                        <div class="card mb-3" id="shipping-information-individual">
                            <div class="card-header">
                                Individual Shipping Information
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    {{ Form::text('shipping_line1', $cart->shipping_line1, ['class' => 'form-control', 'placeholder' => 'Line 1']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::text('shipping_line2', $cart->shipping_line2, ['class' => 'form-control', 'placeholder' => 'Line 2']) }}
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            {{ Form::text('shipping_city', $cart->shipping_city, ['class' => 'form-control', 'placeholder' => 'City']) }}
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            {{ Form::text('shipping_state', $cart->shipping_state, ['class' => 'form-control', 'placeholder' => 'State']) }}
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            {{ Form::text('shipping_zip_code', $cart->shipping_zip_code, ['class' => 'form-control', 'placeholder' => 'Zip Code']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @break
                    @endif
                @endforeach
                <div class="card mb-3">
                    <div class="card-header">
                        Contact Information
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ Form::text('contact_first_name', $cart->contact_first_name, ['class' => 'form-control', 'placeholder' => 'First Name']) }}
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ Form::text('contact_last_name', $cart->contact_last_name, ['class' => 'form-control', 'placeholder' => 'Last Name']) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::text('contact_email', $cart->contact_email, ['class' => 'form-control', 'placeholder' => 'Email Address']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::text('contact_phone', $cart->contact_phone, ['class' => 'form-control', 'placeholder' => 'Phone Number']) }}
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ Form::text('contact_school', $cart->contact_school, ['class' => 'form-control', 'placeholder' => 'College']) }}
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ Form::text('contact_chapter', $cart->contact_chapter, ['class' => 'form-control', 'placeholder' => 'Chapter']) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::select('contact_graduation_year', graduation_year_options('Select Your Graduation Year'), old('contact_graduation_year', $order->contact_graduation_year), ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        Payment Information
                    </div>
                    <div class="card-body">
                        @if ($checkoutManual && $cart->orders->count() == 1)
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="payment-type-card" name="payment_method" value="card" checked>
                                <label class="custom-control-label" for="payment-type-card">Payment by Card</label>
                            </div>
                        @else
                            <input type="hidden" name="payment_method" value="card"/>
                        @endif
                        <input type="hidden" id="payment-nonce" name="payment_nonce" value=""/>
                        <div id="dropin-container"></div>
                        @if ($checkoutManual && $cart->orders->count() == 1)
                            <div class="card-body border-top">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="payment-type-manual" name="payment_method" value="manual">
                                    <label class="custom-control-label" for="payment-type-manual">Payment Manual</label>
                                </div>
                            </div>
                            <table class="w-100 border-top border-bottom table-fixed">
                                <tr>
                                    <td class="p-2 border border-bottom-blue">
                                        <div class="text-left font-weight-semi-bold">Authorized Qty</div>
                                        <div class="text-right color-blue font-weight-bold text-lg">{{ $cart->orders->first()->campaign->getAuthorizedQuantity() }}</div>
                                    </td>
                                    <td class="p-2 border border-bottom-orange">
                                        <div class="text-left font-weight-semi-bold">Charged Qty</div>
                                        <div class="text-right color-blue font-weight-bold text-lg">{{ $cart->orders->first()->campaign->getSuccessQuantity() }}</div>
                                    </td>
                                    <td class="p-2 border border-bottom-green">
                                        <div class="text-left font-weight-semi-bold">Final Qty</div>
                                        <div class="text-right color-blue font-weight-bold text-lg">{{ $cart->orders->first()->campaign->getAuthorizedQuantity() + $cart->orders->first()->campaign->getSuccessQuantity() + $cart->orders->first()->quantity }}</div>
                                    </td>
                                </tr>
                            </table>
                            <div class="col col-md-12">
                                @foreach ($cart->orders->first()->entries as $entry)
                                    <div class="mt-3">
                                        <label>Price Per Item ({{ $cart->orders->first()->campaign->name }} - {{ $entry->product_color->name }}
                                            - {{ $entry->size->short }})
                                        </label>
                                        <div>{{ Form::text('manual_payment_price_' . $entry->id, round($cart->orders->first()->campaign->getQuoteHigh($entry->product_color->product_id) * 1.07, 2), ['class' => 'form-control']) }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <button class="btn btn-success text-uppercase w-100" type="submit" id="submit-button">Place Your Order</button>
                <div class="mt-3 text-center">
                    By clicking 'Place Your Order' you agree to our <a href="{{ route('home::privacy') }}" target="_blank">Privacy policy</a> and <a href="{{ route('home::tos') }}" target="_blank">terms
                        of service</a>.
                </div>
                <div class="mt-1 text-left">
                    <label class="form-checkbox mr-3 font-weight-normal color-black">
                        I would like to receive emails about new products directly from these sellers or any licensed partners.
                        {{ Form::checkbox('allow_marketing', 1, true, ['class' => '']) }}
                        <span></span>
                    </label>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        Order Summary
                    </div>
                    <div class="card-body">
                        @foreach ($cart->orders as $order)
                            @foreach ($order->entries as $entry)
                                <div class="cart-entry cart-entry-sm">
                                    <input type="hidden" value="{{ $entry->id }}" name="entry[]" class="cart-entry-id"/>
                                    <input type="hidden" value="{{ $entry->price }}" class="cart-entry-price"/>
                                    <div class="cart-entry-image">
                                        <a href="{{ route('custom_store::details', [product_to_description($order->campaign_id, $order->campaign->name)]) }}" target="_blank">
                                            <div class="cart-entry-image-container"
                                                 style="background-image: url('{{ route('system::image', [$order->campaign->getProductColorProofs($entry->product_color_id)->first()->file_id]) }}')"></div>
                                        </a>
                                    </div>
                                    <div class="cart-entry-description">
                                        <a href="{{ route('custom_store::details', [product_to_description($order->campaign_id, $order->campaign->name)]) }}"
                                           target="_blank">{{ $order->campaign->name }}</a>
                                        <div class="cart-entry-description-details">{{ $entry->product_color->name }} ({{ $entry->size->short }})</div>
                                    </div>
                                    <div class="cart-entry-pricing">
                                        <div class="cart-entry-pricing-details">{{ $entry->quantity }}x {{ money($entry->price) }}</div>
                                        <div class="cart-entry-pricing-subtotal">{{ money($entry->subtotal) }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                        <div class="row font-weight-semi-bold mb-4">
                            <div class="col-6 text-left">
                                Subtotal
                            </div>
                            <div class="col-6 text-right">
                                {{ money($cart->getSubtotal()) }}
                            </div>
                        </div>
                        <div class="row font-weight-semi-bold mb-4" id="shipping-line" {!! ! $cart->getShipping() ? 'style="display: none"' : '' !!}>
                            <div class="col-6 text-left">
                                Shipping Charge
                            </div>
                            <div class="col-6 text-right" id="shipping-line-value">
                                {{ money($cart->getShipping()) }}
                            </div>
                        </div>
                        <div class="row font-weight-semi-bold" id="total-line" data-total="{{ $cart->getTotalWithoutShipping() }}">
                            <div class="col-6 text-left">
                                Total
                            </div>
                            <div class="col-6 text-right color-green" id="total-line-value">
                                {{ money($cart->getTotal()) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 font-weight-semi-bold">How long will it take to get my shirt?</div>
                <div class="color-slate">Your order will arrive 7-10 business days after the end of the campaign!</div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
    @include('v3.partials.expanded_footer')
@append

@section('javascript')
    <script src="https://js.braintreegateway.com/web/dropin/1.11.0/js/dropin.min.js"></script>
    <script>
        var form = document.querySelector('#checkout-form');
        var button = document.querySelector('#submit-button');
        var hiddenNonceInput = document.querySelector('#payment-nonce');

        var dropinInstance = braintree.dropin.create({
            authorization: '{{ $clientToken }}',
            container: '#dropin-container',
            venmo: {
                allowNewBrowserTab: false
            }
        }, function (createErr, instance) {
            if (createErr) {
                console.error(createErr);
                return;
            }

            button.addEventListener('click', function (event) {
                if ($('#payment-type-card').length == 1 && $('#payment-type-card').prop('checked') == false) {
                    return;
                }

                event.preventDefault();
                if ($('#payment-type-card').length > 0 && !$('#payment-type-card').prop('checked')) {
                    return;
                }
                instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
                    if (requestPaymentMethodErr) {
                        console.error(requestPaymentMethodErr);
                        button.removeAttribute('disabled');
                        return;
                    }
                    hiddenNonceInput.value = payload.nonce;
                    form.submit();
                });
                return false;
            });

            if (instance.isPaymentMethodRequestable()) {
                button.removeAttribute('disabled');
            }

            instance.on('paymentMethodRequestable', function (event) {
                console.log(event.type);
                console.log(event.paymentMethodIsSelected);

                button.removeAttribute('disabled');
            });

            instance.on('noPaymentMethodRequestable', function () {
                button.setAttribute('disabled', true);
            });
        });

        if ($('.shipping-type-individual').length || $('.shipping-type-individual-quantity').length) {
            $('.shipping-type-radio').change(updateIndividualShippingInformation);
            updateIndividualShippingInformation();
        }

        function updateIndividualShippingInformation() {
            var visible = false;
            var shipping = 0;
            $('.shipping-type-individual').each(function () {
                if ($(this).is(':checked')) {
                    visible = true;
                    shipping += 7 + (parseInt($(this).attr('data-quantity')) - 1) * 2;
                }
            });

            $('.shipping-type-individual-quantity').each(function () {
                visible = true;
                shipping += 7 + (parseInt($(this).val()) - 1) * 2;
            });

            if (visible) {
                $('#shipping-information-individual').show();
            } else {
                $('#shipping-information-individual').hide();
            }

            var total = $('#total-line').attr('data-total');

            if (shipping > 0) {
                $('#shipping-line').show();
                $('#shipping-line-value').text('$' + number_format(shipping));
                $('#total-line-value').text('$' + number_format(Math.round((parseFloat(total) + shipping) * 100) / 100));
            } else {
                $('#shipping-line').hide();
                $('#total-line-value').text('$' + number_format(total));
            }
        }
    </script>
@append