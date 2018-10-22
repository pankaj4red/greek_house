<div class="row" id="quote-tab-content-{{ $product->id }}">
    {{ Form::hidden('product_id[]', $product->id) }}
    <div class="col-md-12">
        <table class="table table-condensed quote-table">
            <thead>
            <tr>
                <th colspan="3">Product Information</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="key">Product Name</td>
                <td class="value" colspan="2">{{ $product->name }}</td>
            </tr>
            <tr>
                <td class="key">Garment Style</td>
                <td class="value" colspan="2">{{ $product->style_number }}</td>
            </tr>
            <tr>
                <td class="key">Product Unit Cost</td>
                <td class="value" colspan="2">{{ number_format($product->price, 2) }}</td>
            </tr>
            </tbody>
        </table>
        <table class="table table-condensed quote-table quote-table-ajax">
            <thead>
            <tr>
                <th>Quote</th>
                <th>Per Unit</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
            <tr>
                <td class="separator" colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td class="key">Cost per Unit</td>
                <td class="value bold unit-cost" colspan="2">-</td>
            </tr>
            <tr>
                <td class="key">Price per Shirt</td>
                <td class="value"
                    colspan="2">{{ Form::text('unit_price_low[]', null, ['class' => 'unit-price-low', 'placeholder' => '-']) }}{{ Form::text('unit_price_high[]', null, ['class' => 'unit-price-high', 'placeholder' => '-']) }}</td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

@section ('javascript')
    <script>
        var frontColors = parseInt("{{ $campaign->artwork_request->designer_colors_front?$campaign->artwork_request->designer_colors_front:0 }}");
        var backColors = parseInt("{{ $campaign->artwork_request->designer_colors_back?$campaign->artwork_request->designer_colors_back:0 }}");
        var leftColors = parseInt("{{ $campaign->artwork_request->designer_colors_sleeve_left?$campaign->artwork_request->designer_colors_sleeve_left:0 }}");
        var rightColors = parseInt("{{ $campaign->artwork_request->designer_colors_sleeve_right?$campaign->artwork_request->designer_colors_sleeve_right:0 }}");
        var blackShirt = '{{ $campaign->artwork_request->designer_black_shirt?'yes':'no' }}';
        var productCount = parseInt("{{ product_color_products($campaign->product_colors)->count() }}");
        var product = parseInt("{{ $product->id }}");

        function quote{{ $product->id }}() {
            var designHours = $('#design-hours').val();
            var estimatedQuantityFrom = $('#estimated_quantity option:selected').attr('data-from');
            var estimatedQuantityTo = $('#estimated_quantity option:selected').attr('data-to');
            var markup = $('#markup').val();
            $.ajax({
                url: '{{ route('system::quick_manager_quote', ['screen']) }}' + '?pid=' + product + '&cf=' + frontColors + '&cb=' + backColors + '&cl=' + leftColors + '&cr=' + rightColors + '&bs=' + blackShirt + '&eqf=' + estimatedQuantityFrom + '&eqt=' + estimatedQuantityTo + '&dh=' + designHours + '&mu=' + markup + '&pc=' + productCount,
                type: 'GET',
                success: function (data) {
                    $('#quote-tab-content-{{ $product->id }} .quote-table.quote-table-ajax tbody').html('');
                    $('#quote-tab-content-{{ $product->id }} .unit-price').val('');
                    $('#quote-tab-content-{{ $product->id }} .unit-total').val('');
                    if (data.success) {
                        for (var i = 0; i < data.quote.groups.length; i++) {
                            $('#quote-tab-content-{{ $product->id }} .quote-table.quote-table-ajax tbody').append($('<tr><td class="title" colspan="3">' + data.quote.groups[i].title + '</td></tr>'));
                            for (var j = 0; j < data.quote.groups[i].lines.length; j++) {
                                var unitText = '';
                                var totalText = '';
                                var unit = data.quote.groups[i].lines[j].unit;
                                var total = data.quote.groups[i].lines[j].total;
                                if (unit[0] === null) {
                                    if (unit[1] !== null) {
                                        unitText = '$' + number_format(unit[1], 2, '.', ',');
                                    }
                                } else if (unit[0] === unit[1]) {
                                    unitText = '$' + number_format(unit[0], 2, '.', ',');
                                } else {
                                    unitText = '$' + number_format(unit[0], 2, '.', ',') + ' - ' + '$' + number_format(unit[1], 2, '.', ',');
                                }
                                if (total[0] === null) {
                                    if (total[1] !== null) {
                                        totalText = '$' + number_format(total[1], 2, '.', ',');
                                    }
                                    totalText = '$' + number_format(total[1], 2, '.', ',');
                                } else if (total[0] === total[1]) {
                                    totalText = '$' + number_format(total[0], 2, '.', ',');
                                } else {
                                    totalText = '$' + number_format(total[0]) + ' - ' + '$' + number_format(total[1], 2, '.', ',');
                                }
                                $('#quote-tab-content-{{ $product->id }} .quote-table.quote-table-ajax tbody').append($('<tr><td class="key">&nbsp;&nbsp;' + data.quote.groups[i].lines[j].title + '</td><td class="value">' + unitText + '</td><td class="value">' + totalText + '</td></tr>'));
                            }
                            var groupTotalText = '';
                            var groupTotal = data.quote.groups[i].total;
                            if (groupTotal[0] === null) {
                                if (groupTotal[1] !== null) {
                                    groupTotalText = '$' + number_format(groupTotal[1], 2, '.', ',');
                                }
                                groupTotalText = '$' + number_format(groupTotal[1], 2, '.', ',');
                            } else if (groupTotal[0] === groupTotal[1]) {
                                groupTotalText = '$' + number_format(groupTotal[0], 2, '.', ',');
                            } else {
                                groupTotalText = '$' + number_format(groupTotal[0], 2, '.', ',') + ' - ' + '$' + number_format(groupTotal[1], 2, '.', ',');
                            }
                            $('#quote-tab-content-{{ $product->id }} .quote-table.quote-table-ajax tbody').append($('<tr><td class="key" colspan="2">&nbsp;</td><td class="value border-top bold">' + groupTotalText + '</td></tr>'));
                        }
                        var pricePerShirt = data.quote.price_unit;
                        $('#quote-tab-content-{{ $product->id }} .unit-price-low').val('$' + number_format(pricePerShirt[1], 2, '.', ','));
                        $('#quote-tab-content-{{ $product->id }} .unit-price-high').val('$' + number_format(pricePerShirt[0], 2, '.', ','));
                        var costUnit = data.quote.cost_unit;
                        if (costUnit[0] !== costUnit[1]) {
                            $('#quote-tab-content-{{ $product->id }} .unit-cost').text('$' + number_format(costUnit[0], 2, '.', ',') + ' - $' + number_format(costUnit[1], 2, '.', ','));
                        } else {
                            $('#quote-tab-content-{{ $product->id }} .unit-cost').text('$' + number_format(costUnit[0], 2, '.', ','));
                        }
                        updateQuoteOnTabs();
                    }
                },
                error: function (data) {
                    $('#quote-tab-content-{{ $product->id }} .quote-table.quote-table-ajax tbody').html('');
                    $('#quote-tab-content-{{ $product->id }} .unit-price').val('');
                    $('#quote-tab-content-{{ $product->id }} .unit-total').val('');
                    updateQuoteOnTabs();
                },
                complete: function () {
                }
            });
            return false;
        }

        $('#quote-tab-content-{{ $product->id }} .quote-table.quote-table-ajax .quote-trigger').change(quote{{ $product->id }});
        $('#quote-tab-content-{{ $product->id }} .quote-table.quote-table-ajax .quote-trigger').keyup(quote{{ $product->id }});
        quote{{ $product->id }}();
    </script>
@append
