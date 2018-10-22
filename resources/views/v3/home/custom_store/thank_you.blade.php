@extends('v3.layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <div class="image-background image-background-drawn-world text-center pt-120px pb-120px">
        <div class="container">
            <h1 class="h2 color-blue text-uppercase mb-5">Hello, your order is confirmed!</h1>
            <a class="btn btn-default text-uppercase btn-hard-border" href="{{ route('custom_store::campaigns', [$cart->orders->first()->campaign->user_id]) }}">Continue Shopping</a>
        </div>
    </div>

    <div class="container">
        <div class="mt-5">
            <h2 class="h3 color-blue text-uppercase text-center mb-5">Here's what you ordered:</h2>
            <div class="text-lg color-slate">
                Order #:
                @foreach($cart->orders as $order)
                    {{ $order->id . ($loop->last ? '' : ',' ) }}
                @endforeach
            </div>
            <div class="text-lg color-slate">
                Order Date #:
                @foreach($cart->orders as $order)
                    {{ $order->campaign->date ? $order->campaign->date->format('m/d/Y') : '10-14 business days after the campaign ends.'}}
                @endforeach
            </div>
            <div class="cart mt-3">
                <div class="cart-body">
                    @foreach ($cart->orders as $order)
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
                                    <a href="{{ route('custom_store::details', [product_to_description($order->campaign_id, $order->campaign->name)]) }}"
                                       target="_blank">{{ $order->campaign->name }}</a>
                                    <div class="cart-entry-description-details">{{ $entry->product_color->name }} ({{ $entry->size->short }})</div>
                                </div>
                                <div class="cart-entry-pricing">
                                    <div class="cart-entry-pricing-subtotal">{{ money($entry->subtotal) }}</div>
                                    <div class="cart-entry-pricing-details">{{ $entry->quantity }}x {{ money($entry->price) }}</div>
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
            @foreach ($cart->orders as $order)
                @if ($order->shipping_type == 'group')
                    <div class="font-weight-semi-bold color-slate">{{ $order->campaign->name }} - Group Shipping</div>
                    <div class="ml-3 color-slate text-sm">{{ $order->campaign->getContactFullName() }}</div>
                    <div class="ml-3 color-slate text-sm"><a href="mailto: {{ $order->campaign->contact_email }}">{{ $order->campaign->contact_email }}</a></div>
                    <div class="ml-3 color-slate text-sm mb-3">{{ $order->campaign->contact_school }}</div>
                @endif
                @if ($order->shipping_type == 'individual')
                    <div class="font-weight-semi-bold color-slate">{{ $order->campaign->name }} - Individual Shipping</div>
                    <div class="ml-3 color-slate text-sm">{{ $order->getContactFullName() }}</div>
                    <div class="ml-3 color-slate text-sm"><a href="mailto: {{ $order->contact_email }}">{{ $order->contact_email }}</a></div>
                    <div class="ml-3 color-slate text-sm mb-3">{{ $order->contact_school }}</div>
                @endif
            @endforeach
        </div>
        <div class="mt-5">
            <h2 class="h3 color-blue text-uppercase text-center mb-5">Get Involved</h2>
            <div class="row">
                <div class="col-12 col-md-4 text-center">
                    <a href="{{ route('home::index') }}">
                        <div class="image-background image-hover-effect w-100 h-260px" style="background-image: url(/images/store/landing/merch_team.jpg)"></div>
                        <div class="text-xl color-black text-uppercase font-weight-semi-bold mt-3 mb-3 rockwell">Join our merch team</div>
                        <p class="color-slate">Submit ideas for products and designs</p>
                    </a>
                </div>
                <div class="col-12 col-md-4 text-center">
                    <a href="{{ route('home::index') }}">
                        <div class="image-background image-hover-effect w-100 h-260px" style="background-image: url(/images/store/landing/influencer.png)"></div>
                        <div class="text-xl color-black text-uppercase font-weight-semi-bold mt-3 mb-3 rockwell">Become an Influencer</div>
                        <p class="color-slate">Set early access to products to post on social Media</p>
                    </a>
                </div>
                <div class="col-12 col-md-4 text-center">
                    <a href="{{ route('ambassador::index') }}">
                        <div class="image-background image-hover-effect w-100 h-260px" style="background-image: url(/images/store/landing/ambassador.png)"></div>
                        <div class="text-xl color-black text-uppercase font-weight-semi-bold mt-3 mb-3 rockwell">Become an Ambassador</div>
                        <p class="color-slate">Manage your chapter's store & Live Sales campaigns</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @include('v3.partials.expanded_footer')
@append

@section ('javascript')
    @if ($cart->orders->first()->user && $cart->orders->first()->user->orders->count() == $cart->orders->count())
        <script>
            fbq('track', 'New Customer - Purchase');
        </script>
    @endif

    @if ($cart->orders->first()->user && $cart->orders->first()->user->orders->count() > $cart->orders->count())
        <script>
            fbq('track', 'Existing Customer - Purchase');
        </script>
    @endif
@append

@section ('include')
    <?php register_js('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5416f2ad4d856633') ?>
@append
