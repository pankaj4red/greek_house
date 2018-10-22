@extends('v3.layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <div class="container mt-5">
        <h1 class="h3 title-blue text-center mb-5">Shopping Cart</h1>

        {{ Form::open() }}
        <input type="hidden" value="{{ $cart->id }}" class="cart-id"/>
        <div class="cart mb-5">
            <div class="cart-body">
                @foreach($cart->orders as $order)
                    @foreach ($order->entries as $entry)
                        <div class="cart-entry">
                            <input type="hidden" value="{{ $entry->id }}" name="entry[]" class="cart-entry-id"/>
                            <input type="hidden" value="{{ $entry->price }}" class="cart-entry-price"/>
                            <div class="cart-entry-image">
                                <a href="{{ route('custom_store::details', [product_to_description($order->campaign_id, $order->campaign->name)]) }}" target="_blank">
                                    <div class="cart-entry-image-container"
                                         style="background-image: url('{{ route('system::image', [$order->campaign->getProductColorProofs($entry->product_color_id)->first()->file_id]) }}')"></div>
                                </a>
                            </div>
                            <div class="cart-entry-description">
                                <a href="{{ route('custom_store::details', [product_to_description($order->campaign_id, $order->campaign->name)]) }}" target="_blank">{{ $order->campaign->name }}</a>
                                <div class="cart-entry-description-details">{{ $entry->product_color->product->name }} {{ $entry->product_color->name }} ({{ $entry->size->short }})</div>
                            </div>
                            <div class="cart-entry-quantity">
                                <div class="quantity-counter">
                                    <div class="quantity-counter-minus">-</div>
                                    <input type="text" class="quantity-counter-quantity" value="{{ $entry->quantity }}" name="quantity[]" title="quantity"/>
                                    <div class="quantity-counter-plus">+</div>
                                </div>
                            </div>
                            <div class="cart-entry-pricing">
                                <div class="cart-entry-pricing-subtotal">{{ money($entry->subtotal) }}</div>
                                <div class="cart-entry-pricing-details">{{ $entry->quantity }}x {{ money($entry->price) }}</div>
                            </div>
                            <div class="cart-entry-actions">
                                <a href="javascript: void(0)" class="cart-entry-remove"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
            <div class="cart-footer">
                @if ($cart->getSubtotal() != $cart->getTotal())
                    <div class="cart-footer-entry">
                        <div class="cart-footer-label">Subtotal:</div>
                        <div class="cart-footer-value cart-subtotal">{{ money($cart->getSubtotal()) }}</div>
                    </div>
                @endif
                @if ($cart->getShipping())
                    <div class="cart-footer-entry">
                        <div class="cart-footer-label">Shipping Charge:</div>
                        <div class="cart-footer-value cart-shipping">{{ money($cart->getShipping()) }}</div>
                        <input type="hidden" value="{{ $cart->getShipping() }}" class="cart-shipping"/>
                    </div>
                @endif
                <div class="cart-footer-entry">
                    <div class="cart-footer-label">Cart Total:</div>
                    <div class="cart-footer-value large cart-total">{{ money($cart->getTotal()) }}</div>
                </div>
            </div>
        </div>
        <div class="text-center">
            @if ($cart->orders->count() > 0)
                @if ($cart->orders->first()->campaign->user->campaigns->count() > 1)
                    <a class="btn btn-default text-uppercase mb-3" href="{{ route('custom_store::campaigns', [$cart->orders->first()->campaign->user_id]) }}">Continue Shopping</a>
                @endif
                <button class="btn btn-info text-uppercase mb-3" type="submit">Proceed to Checkout</button>
            @endif
        </div>
        {{ Form::close() }}
    </div>
@append