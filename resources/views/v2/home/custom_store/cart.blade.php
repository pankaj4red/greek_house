@extends('v2.layouts.app')

@section('title', 'My Store Cart')

@section('content')
    <div class="page shopping-cart">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="gh-title text-uppercase text-center blue">Shopping cart</h3>
                    {!! Form::open(['url' => Request::fullUrl(), 'id' => 'shopping-cart-form']) !!}
                    @if (messages_exist())
                        {!! messages_output() !!}
                    @endif
                    {!! csrf_field() !!}
                    <div class="shopping-cart__products">
                        @foreach($orders as $order)
                            @include('v2.home.custom_store.partials.cart_product', ["product" => $order])
                        @endforeach

                        <div class="cart__product subtotal">
                            <div class="subtotal__prices">
                                <div class="subtotal__price total-price">
                                    <div class="price__label">Cart Subtotal:</div>
                                    <div class="price__value" id="cart-subtotal">$0.00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="checkout__submit">
                        <input class="gh-btn blue big text-uppercase" type="submit" value="Proceed to checkout" />
                        <a class="gh-btn blue big text-uppercase" href="{{ route('home::index')  }}" >CONTINUE SHOPPING</a>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection