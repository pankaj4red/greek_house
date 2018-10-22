@extends ('customer')

@section ('title', 'Provide Quote')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    {{ Form::open() }}
    <div class="popup" id="provide-quote">
        <div class="popup-title">PROVIDE QUOTE</div>
        <div class="popup-body">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            <div class="row">
                <div class="col-md-3">
                    <ul class="nav nav-pills nav-stacked" id="quote-tab-link-tabs">
                        @foreach (product_color_products($campaign->product_colors) as $product)
                            <li role="presentation" class="{{ $loop->index == 0 ? 'active' : '' }}">
                                <a href="#quote-tab-{{ $product->id }}" aria-controls="quote-tab-{{ $product->id }}" role="tab" data-toggle="tab" id="quote-tab-link-{{ $product->id }}">
                                    {{ $product->name }}
                                    <div class="quote-tab-link-range">
                                        @if ($campaign->quotes->where('product_id', $product->id)->count() > 0)
                                            {{ quote_range($campaign->quotes->where('product_id', $product->id)->first()->quote_low * 1.07, $campaign->quotes->where('product_id', $product->id)->first()->quote_high * 1.07) }}
                                        @endif
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed quote-table">
                                <thead>
                                <tr>
                                    <th colspan="3">Campaign Information</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="key">Estimated Quantity</td>
                                    <td class="value" colspan="2">
                                        <label for="estimated_quantity" class="sr-only">Estimated Quantity</label>
                                        <select class="quote-global-trigger" id="estimated_quantity" name="estimated_quantity">
                                            @foreach (estimated_quantity_options('screen') as $key => $caption)
                                                <option value="{{ $key }}" data-from="{{ estimated_quantity_by_code('screen', $key)->from }}"
                                                        data-to="{{ estimated_quantity_by_code('screen', $key)->to }}"
                                                        data-markup="{{ estimated_quantity_by_code('screen', $key)->markup }}" {{ $campaign->estimated_quantity == $key ? 'selected' : '' }}>{{ $caption }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">Design Hours</td>
                                    <td class="value"
                                        colspan="2">{{ Form::text('design_hours', to_hours($campaign->artwork_request->design_minutes), ['id' => 'design-hours', 'class' => 'quote-global-trigger']) }}</td>
                                </tr>
                                <tr>
                                    <td class="key">Markup %</td>
                                    <td class="value" colspan="2">{{ Form::text('markup', $defaultMarkup, ['id' => 'markup', 'class' => 'quote-global-trigger']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="tab-content">
                                @foreach (product_color_products($campaign->product_colors) as $product)
                                    <div role="tabpanel" class="tab-pane fade {{ $loop->index == 0 ? 'in active' : '' }}" id="quote-tab-{{ $product->id }}">
                                        @if ($campaign->artwork_request->design_type == 'screen')
                                            @include ('blocks.popup.provide_quote___screen_printer', ['product' => $product])
                                        @elseif ($campaign->artwork_request->design_type == 'embroidery')
                                            @include ('blocks.popup.provide_quote___embroidery', ['product' => $product])
                                        @else
                                            Quoting Type Not Implemented
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 action-row">
                <a href="{{ $back }}" class="button-back btn btn-default back-btn">Cancel</a>
                <button class="btn btn-info" type="button" id="quote-next-btn" style="display: {{ product_color_products($campaign->product_colors)->count() > 1 ? 'inline' : 'none' }}">
                    Next
                </button>
                <button class="btn btn-primary" type="submit" id="quote-save-btn" style="display: {{ product_color_products($campaign->product_colors)->count() < 2 ? 'inline' : 'none' }}">
                    Save
                </button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
    @if (!Request::ajax())
        {!! '</div>' !!}
    @endif
@endsection

@section ('javascript')
    <script>
        function quote() {
            @foreach (product_color_products($campaign->product_colors) as $product)
            quote{{ $product->id }}();
            @endforeach
        }

        $('#estimated_quantity').change(function () {
            $('#markup').val($('#estimated_quantity option:selected').attr('data-markup'));
        });
        $('.quote-global-trigger').change(quote);
        $('.quote-global-trigger').keyup(quote);
        $('.unit-price-low').change(updateQuoteOnTabs);
        $('.unit-price-low').keyup(updateQuoteOnTabs);
        $('.unit-price-high').change(updateQuoteOnTabs);
        $('.unit-price-high').keyup(updateQuoteOnTabs);

        function updateQuoteOnTabs() {
            @foreach (product_color_products($campaign->product_colors) as $product)
            if ($('#quote-tab-content-{{ $product->id }} .unit-price-low').val() && $('#quote-tab-content-{{ $product->id }} .unit-price-high').val()) {
                if ($('#quote-tab-content-{{ $product->id }} .unit-price-low').val() == $('#quote-tab-content-{{ $product->id }} .unit-price-high').val()) {
                    $('#quote-tab-link-{{ $product->id }} .quote-tab-link-range').text(number_format($('#quote-tab-content-{{ $product->id }} .unit-price-low').val()));
                } else {
                    $('#quote-tab-link-{{ $product->id }} .quote-tab-link-range').text(number_format($('#quote-tab-content-{{ $product->id }} .unit-price-low').val()) + ' - ' + number_format($('#quote-tab-content-{{ $product->id }} .unit-price-high').val()));
                }
            } else {
                $('#quote-tab-link-{{ $product->id }} .quote-tab-link-range').text('');
            }
            @endforeach
        }

        function quoteNext() {
            $('#quote-tab-link-tabs > .active').next('li').find('a').trigger('click');
            updateQuoteNext();
        }

        function updateQuoteNext() {
            $(".fancybox-inner").animate({ scrollTop: 0 }, "slow");
            $('#quote-tab-link-tabs > li').each(function () {
                if ($(this).hasClass('active')) {
                    if ($(this).index() == $('#quote-tab-link-tabs > li').length - 1) {
                        $('#quote-next-btn').hide();
                        $('#quote-save-btn').show();
                    } else {
                        $('#quote-next-btn').show();
                        $('#quote-save-btn').hide();
                    }
                }
            });
        }

        $('#quote-next-btn').click(quoteNext);

        function number_format(number, decimals, dec_point, thousands_sep) {
            var units = number.toString().split(".");
            var decimal = '00';
            if (units.length > 1) {
                decimal = units[1];
                units = units[0];
            } else {
                decimal = '00';
                units = units[0];
            }

            if (decimal.length < 1) {
                decimal = decimal + '0';
            }
            if (decimal.length < 2) {
                decimal = decimal + '0';
            }

            var unitsParts = units.split(/(?=(?:...)*$)/);
            var final = '';
            for (var i = 0; i < unitsParts.length; i++) {
                if (i > 0) final += ',';
                final += unitsParts[i];
            }
            final = final + '.' + decimal;
            return final;
        }
    </script>
@append
