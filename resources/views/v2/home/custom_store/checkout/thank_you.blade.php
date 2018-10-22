@extends('v2.layouts.app')

@section('title', 'Store Confirmation')

@section ('messages')
    <div class="nope"></div>
@endsection
<?php
$campaign = $cart->orders[0]->campaign;
?>
@section('content')
    @include('v2.partials.messages.all')
    <div class="store confirmation">

    <section class="intro">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="gh-title blue text-uppercase">Hello, your order is confirmed!</h1>
                    <a class="gh-btn grey-transparent text-uppercase" href="{{ route('home::index') }}">Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>


    <div class="container">
        <div class="row">
            <div class="col-12 shopping-cart">
                <h3 class="gh-title text-uppercase text-center blue">Here’s what you ordered:</h3>

                <div class="confirmation__order">
                    <div>Order #: <?php foreach ($cart->orders as $order) {
                            echo $order->id . ', ';
                        }  ?></div>
                    <div>Order Date: {{ date("m/d/Y", strtotime($campaign->date)) }}</div>
                </div>

                <div class="shopping-cart__products">
                    @foreach($cart->orders as $order)
                        @include('v2.home.custom_store.partials.cart_product', ["product" => $order, "control" => false])
                    @endforeach

                    <div class="cart__product subtotal">

                        <div class="checkout__shipping">
                            <h5>Group Shipping</h5>
                            <div>{{ $campaign->getContactFullName() }}</div>
                            <div><a href="mailto:{{ $campaign->contact_email }}" t
                                    target="_blank">{{ $campaign->contact_email }}</a></div>
                            <div>{{ $campaign->contact_school }}</div>
                        </div>
                        <div class="subtotal__prices">
                            <div class="subtotal__price total-price">
                                <div class="price__label">Order Total:</div>
                                <div class="price__value" id="cart-subtotal">$43.98</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('v2.home.custom_store.partials.get_involved')

</div>
@endsection

@section ('include')
    <?php register_js('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5416f2ad4d856633') ?>
@append