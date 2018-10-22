@extends ('customer')

@section ('title', $campaign->name . ' Checkout')

@section ('metadata')
    <meta property="og:url"
          value="{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) }}"/>
    <meta property="og:type" value="website"/>
    <meta property="og:title" value="{{ $campaign->name }} | Greek House"/>
    <meta property="og:site_name" value="Greek House"/>
    <meta property="og:description" value="Don't miss out on this shirt!"/>
    @if ($campaign->getFirstProofId())
        <meta property="og:image" value="{{ route('system::image', [$campaign->getFirstProofId()]) }}"/>
    @endif
    <meta name="p:domain_verify" content="205e0c139cd6a5d2093567a56916f331"/>
@append

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="container">
        {{-- Fill all items in colors/quantities --}}
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        <div class="row">
            <div class="col-md-8">
                <div class="proofs">
                    <h1 class="no-margin text-center">{{ $campaign->name }}</h1>
                    <?php $images = []; ?>
                    @for($i = 1; $i <= 10; $i++)
                        @if ($campaign->getProofEntry($i - 1))
                            <?php
                            $images[] = $campaign->getProofEntry($i - 1)->file;
                            ?>
                        @endif
                    @endfor
                    @include ('partials.slider2', ['images' => $images, 'actionArea' => ''])
                </div>
            </div>
            <div class="col-md-4">
                <div class="campaign-checkout">
                    {!! Form::open() !!}
                    <div class="campaign-tags">
                        {{-- Append all campaign product style numbers --}}
                        <span>Product Code: #{{ $campaign->products->first()->style_number }}</span>
                    </div>
                    {{-- Quote no longer applies ? --}}
                    <span class="checkout-price">{{ quote_range($campaign->quote_low * 1.07, $campaign->quote_high * 1.07, $campaign->quote_final * 1.07, false) }}</span>
                    <div class="progress-section">
                        <div class="progress-wrapper">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                     aria-valuenow="{{ $campaign->getAuthorizedQuantity() + $campaign->getSuccessQuantity() }}"
                                     aria-valuemin="0"
                                     aria-valuemax="{{ estimated_quantity_by_code($campaign->getCurrentArtwork()->design_type, $campaign->estimated_quantity)->from }}"
                                     style="width: {{ $campaign->hasMetEstimatedQuantity() ? 100 : round(($campaign->getAuthorizedQuantity() + $campaign->getSuccessQuantity()) * 100 / $campaign->getMinimumQuantity(), 2) }}%;">
                                    <span class="sr-only">{{ $campaign->getAuthorizedQuantity() + $campaign->getSuccessQuantity() }}</span>
                                </div>
                            </div>
                            <div class="progress-bar-tooltip" role="tooltip"
                                 style="left: {{ $campaign->hasMetEstimatedQuantity() ? 100 : round(($campaign->getAuthorizedQuantity() + $campaign->getSuccessQuantity()) * 100 / $campaign->getMinimumQuantity(), 2) }}%">
                                <div class="progress-bar-tooltip-arrow"></div>
                                <div class="progress-bar-tooltip-inner">{{ $campaign->getAuthorizedQuantity() + $campaign->getSuccessQuantity() }}</div>
                            </div>
                        </div>
                        <div class="progress-state">
                            <span class="progress-time-left"><span class="progress-time-left-value"
                                                                   data-days="{{ $days }}" data-hours="{{ $hours }}"
                                                                   data-minutes="{{ $minutes }}"
                                                                   data-seconds="{{ $seconds }}">{{ $days ? $days . 'd ' : '' }}{{ str_pad($hours, 2, '0', STR_PAD_LEFT) }}
                                    :{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}</span>
                                Left to Buy</span>
                            <span class="progress-target">Goal: {{ $campaign->getMinimumQuantity() }}</span>
                        </div>
                    </div>

                    <table class="product-cart">
                        <thead>
                        <tr>
                            <th>Quantity</th>
                            <th>Size</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- For each array, check specific order / campaign --}}
                        @if (is_array($sizeList) && count($sizeList) > 0)
                            @for ($i = 0; $i < count($sizeList); $i++)
                                <tr>
                                    <td class="product-cart-quantity">
                                        <input type="text" placeholder="0" name="quantity[]"
                                               value="{{ $quantityList[$i] }}" class="product-quantity"/>
                                    </td>
                                    <td class="product-cart-size">
                                        <div class="product-cart-dropdown">
                                            <label for="input-size" class="sr-only">Product Sizes</label>
                                            <select name="size[]" class="dropdown-select product-size" id="input-size">
                                                @foreach (product_size_options($campaign->products->first()->id) as $sizeKey => $sizeValue)
                                                    <option value="{{ $sizeKey }}" {{ $sizeList[$i] == $sizeKey ? 'selected' : '' }}>{{ $sizeValue }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        @else
                            <tr>
                                <td class="product-cart-quantity">
                                    <input type="text" placeholder="0" name="quantity[]" value=""
                                           class="product-quantity"/>
                                </td>
                                <td class="product-cart-size">
                                    <div class="product-cart-dropdown">
                                        <label for="input-size2" class="sr-only">Product Sizes</label>
                                        <select name="size[]" class="dropdown-select product-size" id="input-size2">
                                            @foreach (product_size_options($campaign->products->first()->id) as $sizeKey => $sizeValue)
                                                <option value="{{ $sizeKey }}">{{ $sizeValue }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="add-another">
                        <a href="#" id="add-another-size">+ ADD ANOTHER SIZE</a>
                    </div>
                    <button type="submit" class="buy-now">Buy Now</button>
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
                        <span class="share-feed-span">share this</span>
                        <a href="javascript:void(0)" class="addthis_button_facebook at300b facebook-image"
                           title="Facebook"><img class="fb-share" src="{{ static_asset('images/fbshare.jpg') }}"/></a>
                        <a href="javascript:void(0)" class="social-thumb addthis_button_link at300b"
                           title="{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) }}"><span
                                    class="v-align-wrapper"><span class="v-align"><img
                                            src="{{ static_asset('images/link.png') }}"
                                            alt="icon-social"></span></span></a>
                    </div>
                    <?php register_js('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5416f2ad4d856633') ?>
                    {!! Form::close() !!}
                </div>
                <p class="checkout-comment">Final item prices are based on sign-up quantity.
                    (So, if your friend group is big, your savings will be too.)
                    We will authorize a payment for the max amount, but will be lowered as more of your friends buy.
                </p>
            </div>
        </div>

    </div>
@endsection

@section ('javascript')
    <script>
        $('#add-another-size').click(function (event) {
            $('.product-cart tbody').append($('<tr><td class="product-cart-quantity">' +
                '<input type="text" placeholder="0" name="quantity[]" value="" class="product-quantity"/></td>' +
                '<td class="product-cart-size"><div class="product-cart-dropdown">' +
                '<select name="size[]" class="dropdown-select product-size">' +
                    @foreach (product_size_options($campaign->products->first()->id) as $sizeKey => $sizeValue)
                        '<option value="{{ $sizeKey }}">{{ $sizeValue }}</option>' +
                    @endforeach
                        '</select>' +
                '</div></td></tr>'));
            event.preventDefault();
            return false;
        });

        function pad(value) {
            var pad = "00";
            return pad.substring(0, pad.length - ('' + value).length) + value
        }
        var countdown = setInterval(function () {
            var $progressTimeLeft = $('.progress-time-left-value');
            var days = parseInt($progressTimeLeft.attr('data-days'));
            var hours = parseInt($progressTimeLeft.attr('data-hours'));
            var minutes = parseInt($progressTimeLeft.attr('data-minutes'));
            var seconds = parseInt($progressTimeLeft.attr('data-seconds'));
            seconds--;
            if (seconds < 0) {
                seconds = 59;
                minutes--;
                if (minutes < 0) {
                    minutes = 59;
                    hours--;
                    if (hours < 0) {
                        hours = 23;
                        days--;
                        if (days < 0) {
                            days = 0;
                            hours = 0;
                            minutes = 0;
                            seconds = 0;
                            clearInterval(countdown);
                        }
                        $progressTimeLeft.attr('data-days', days);
                    }
                    $progressTimeLeft.attr('data-hours', hours);
                }
                $progressTimeLeft.attr('data-minutes', minutes);
            }
            $progressTimeLeft.attr('data-seconds', seconds);

            $progressTimeLeft.text((days > 0 ? days + 'd ' : '') + (hours > 0 ? pad(hours) + ':' : '') + pad(minutes) + ':' + pad(seconds));
        }, 1000);
    </script>
@append
