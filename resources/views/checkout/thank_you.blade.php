@extends ('customer')

@section ('title', $typeCaption . ' Checkout')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="page-header cancel-header-margin">
        <div class="container">
            <span class="pull-left page-title">{{ $typeCaption }} Checkout</span>
            <div class="pull-right page-info">
                <span class="page-info-text-big">{{ $order->campaign->name }}</span>
                CAMPAIGN# <span class="field-nid state_{{ $order->campaign->state }}"><a href="{{ route('custom_store::details', [product_to_description($order->campaign->id, $order->campaign->name)]) }}">{{ $order->campaign->id }}</a></span>
            </div>
        </div>
    </div>
	 
    <div class="container more-margin-bottom">
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        <div class="row">
            <div class="confirmation-box">
                <img src="{{ static_asset('images/thumbs-up-icon.png') }}" alt="image">
                <h1><span>Congrats</span> You Did it!</h1>
                <p>Now let your friends know how they can look as good as you.</p>
                <script type="text/javascript">
                    var addthis_config =
                    {
                        services_expanded: 'facebook,email,link',
                        data_track_clickback: false
                    }
                </script>
                <div class="social-icons addthis_toolbox"
                     addthis:url="{{ route('custom_store::details', [product_to_description($order->campaign->id, $order->campaign->name)]) }}"
                     addthis:description="Don't miss out on this shirt!"
                     addthis:title="{{ $order->campaign->name }} | Greek House">
                    <a href="javascript:void(0)" class="social-thumb addthis_button_facebook at300b"
                       title="Facebook"><span class="v-align-wrapper"><span class="v-align"><img
                                        src="{{ static_asset('images/icon-social-1.png') }}"
                                        alt="icon-social"></span></span></a>
                    <a href="javascript:void(0)" class="social-thumb addthis_button_twitter at300b" title="Tweet"><span
                                class="v-align-wrapper"><span class="v-align"><img
                                        src="{{ static_asset('images/icon-social-2.png') }}"
                                        alt="icon-social"></span></span></a>
                    <a href="http://instagram.com/MyGreekHouse"
                       class="social-thumb addthis_button_instagram_follow at300b" addthis:userid="MyGreekHouse"
                       target="_blank" title="Follow on Instagram"><span class="v-align-wrapper"><span
                                    class="v-align"><img src="{{ static_asset('images/icon-social-3.png') }}"
                                                         alt="icon-social"></span></span><span
                                class="addthis_follow_label">Instagram</span></a>
                    <a href="javascript:void(0)" class="social-thumb addthis_button_pinterest_share at300b"
                       target="_blank" title="{{ $order->campaign->name }}"
                       pi:pinit:description="Don't miss out on this shirt! - {{ $order->campaign->name }} {{ route('custom_store::details', [product_to_description($order->campaign->id, $order->campaign->name)]) }}"
                       pi:pinit:layout="horizontal"
                       pi:pinit:url="{{ route('custom_store::details', [product_to_description($order->campaign->id, $order->campaign->name)]) }}"><span
                                class="v-align-wrapper"><span class="v-align"><img
                                        src="{{ static_asset('images/icon-social-4.png') }}"
                                        alt="icon-social"></span></span></a>
                    <div class="atclear"></div>
                </div>
            </div>
            <div class="confirmation-details-box">
                <div class="row">
                    <div class="col-md-6 confirmation-details-left">
                        <p>Your Order #</p>
                        <span class="badge"><a href="{{ route('checkout::checkout', [product_to_description($order->campaign->id, $order->campaign->name), $order->id]) }}">{{ $order->id }}</a></span>
                    </div>
                    <div class="col-md-6 confirmation-details-right">
                        <p class="confirmation-details-address-title">Shipping to</p>
                        <span class="confirmation-details-address">
                            @if ($order->payment_type == 'individual' && $order->shipping_type == 'individual')
                                {{ $order->shipping_line1 }}<br/>
                                @if ($order->shipping_line2)
                                    {{ $order->shipping_line2 }}<br/>
                                @endif
                                {{ $order->shipping_city }}
                                , {{ $order->shipping_zip_code }} {{ $order->shipping_state }}
                            @else
                                {{ $order->campaign->address_line1 }}<br/>
                                @if ($order->campaign->address_line2)
                                    {{ $order->campaign->address_line2 }}<br/>
                                @endif
                                {{ $order->campaign->address_city }}
                                , {{ $order->campaign->address_zip_code }} {{ $order->campaign->address_state }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <h4 class="confirmation-note">Don't forget to look out for an email with all the nitty gritty regarding this
                order!</h4>
        </div>
    </div>
@endsection

@section ('javascript')
	@if ($order->user && $order->user->orders->count() == 1)
		<script>
		  fbq('track', 'New Customer - Purchase');
		</script>
	@endif

    @if ($order->user && $order->user->orders->count() > 1)
		<script>
		  fbq('track', 'Existing Customer - Purchase');
		</script>
	@endif
@append

@section ('include')
    <?php register_js('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5416f2ad4d856633') ?>
@append