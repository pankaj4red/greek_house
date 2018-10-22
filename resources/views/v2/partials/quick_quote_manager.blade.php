<?php
$products = product_repository()->getActive();
$garmentTypes = [];
foreach ($products as $product) {
    $garmentTypes[] = (object)['id' => $product->id, 'name' => $product->name, 'price' => $product->price,
                               'style_number' => $product->style_number];
}
?>
<a role="button" class="btn quick-quote-button toggle-quick-quote static-right" href="javascript:void(0)"><img
            src="{{ static_asset('images/icon-fixed-pop.png') }}" alt="pop-up"/></a>
<div class="modal hidden-override" id="quote-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog Quotes-info_mdl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"><img src="{{ static_asset('images/Cross-Icon-White.png') }}"
                                                    alt=""/></span></button>
                <h4 class="modal-title" id="myModalLabel">Finalize quote</h4>
            </div>
            <div class="modal-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tp-inpt-flds">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 tp-inpt">
                        <label>Update Design Hours (H)</label>
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input id="quick-design-hours" type="text" class="form-control input-small" placeholder=""
                                   value="3">
                            <span class="input-group-addon"><img src="{{ static_asset('images/icon-watch-small.png') }}"
                                                                 alt="Watch"/></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 tp-inpt">

                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 tp-inpt">
                        <label>Estimated Quantity</label>
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input type="number" class="form-control input-small" id="quick-estimated-quantity"
                                   placeholder="Estimated Quantity (min: 24)" min="24"/>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tp-inpt-flds">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 tp-inpt">
                        <label>Style Number (SKU)</label>
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input id="quick-garment-style-number" type="text" class="form-control input-small"
                                   placeholder="">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 tp-inpt">
                        <label for="quick-garment-type">Garment Type</label>
                        <div class="input-group bootstrap-timepicker timepicker">
                            <select id="quick-garment-type" class="form-control input-small">
                                <option value="">Choose a Garment Type</option>
                                @foreach ($garmentTypes as $garmentType)
                                    <option value="{{ $garmentType->id }}">{{ $garmentType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 tp-inpt">
                        <label> Update Product Price (Units)</label>
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input id="quick-product-price" type="text" class="form-control input-small" placeholder=""
                                   value="6">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tp-inpt-flds">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 tp-inpt">
                        <label for="quick-front-colors">Front Colors</label>
                        <select id="quick-front-colors" class="form-control input-small">
                            @for ($i = 0; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ $i==1?'selected':'' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 tp-inpt">
                        <label for="quick-back-colors">Back Colors</label>
                        <select id="quick-back-colors" class="form-control input-small">
                            @for ($i = 0; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ $i==1?'selected':'' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 tp-inpt">
                        <label for="quick-left-colors">Left Sleeve Colors</label>
                        <select id="quick-left-colors" class="form-control input-small">
                            @for ($i = 0; $i <= 8; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 tp-inpt">
                        <label for="quick-right-colors">Right Sleeve Colors</label>
                        <select id="quick-right-colors" class="form-control input-small">
                            @for ($i = 0; $i <= 8; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tp-inpt-flds">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 tp-inpt">
                        <label for="quick-black-shirt">Black Shirt</label>
                        <select id="quick-black-shirt" class="form-control input-small">
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 Q-type">
                    <ul class="select-order">
                        <li> Quote Type Options/Design Hours :</li>
                        <li>
                            <input class="radio-btn" id="quick-option01" type="radio" name="iCheck" checked>
                            <label class="radio-label" for="quick-option01">Top Tier Graphics</label>
                        </li>
                        <li>
                            <input class="radio-btn" id="quick-option02" type="radio" name="iCheck" checked>
                            <label class="radio-label" for="quick-option02">Shirts.io</label>
                        </li>
                    </ul>
                </div>
                <div class="popup-content">
                    <div class="col-sm-12 col-md-12 col-lg-12 noPadd order-detail-table Payment-detail-table table-responsive">
                        <div class="data-details gray-bg upload-proofs-sec">
                            <ul>
                                <li><span class="pull-left">Garment Name</span> <strong class="pull-right">-</strong>
                                </li>
                                <li><span class="pull-left">Garment Style</span> <strong class="pull-right">-</strong>
                                </li>
                                <li><span class="pull-left">Style Number</span> <strong class="pull-right">-</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="popup-content margin-top">
                    <div class="col-sm-12 col-md-12 col-lg-12 noPadd order-detail-table Payment-detail-table table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <th></th>
                                    <th>Per Unit</th>
                                    <th>Total</th>
                                </tr>
                            </table>
                        </div>
                        <div id="table-content">

                        </div>
                    </div>
                </div>
                <div class="popup-content row margin-top">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tp-inpt">
                        <label>Price Per Shirt</label>
                        <div class="input-group">
                            <input type="text" class="form-control input-small" placeholder=""
                                   id="quick-price-per-shirt"/>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tp-inpt">
                        <label>Price Total</label>
                        <div class="input-group">
                            <input type="text" class="form-control input-small" placeholder="" id="quick-price-total"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 update-total-btn">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">CANCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section ('javascript')
    <script>
        var garmentTypes = JSON.parse("{!! slashes(json_encode($garmentTypes)) !!}");
        $('#quote-modal .btn-default').click(function () {
            $('#quote-modal').hide();
            $('#quote-modal').addClass('hidden-override');
        });
        $('#quote-modal .close').click(function () {
            $('#quote-modal').hide();
            $('#quote-modal').addClass('hidden-override');
        });
        function updateQuote() {
            var frontColors = parseInt($('#quick-front-colors').val());
            var backColors = parseInt($('#quick-back-colors').val());
            var leftColors = parseInt($('#quick-left-colors').val());
            var rightColors = parseInt($('#quick-right-colors').val());
            var blackShirt = 'no';
            if (frontColors > 8) {
                frontColors = 8;
            }
            if (backColors > 8) {
                backColors = 8;
            }
            if (leftColors > 8) {
                leftColors = 8;
            }
            if (rightColors > 8) {
                rightColors = 8;
            }
            if ($('#quick-black-shirt').val() === 'yes') {
                blackShirt = 'yes';
            }
            if (!$('#quick-estimated-quantity').val()) return;
            if ($('#quick-estimated-quantity').val() < 24) {
                return;
            }
            var estimatedQuantityFrom = $('#quick-estimated-quantity').val();
            var estimatedQuantityTo = $('#quick-estimated-quantity').val();
            var productName = $('#quick-garment-type option:selected').text();
            var productPrice = $('#quick-product-price').val();
            $.ajax({
                url: '{{ route('system::quick_manager_quote', ['screen']) }}' + '?pn=' + encodeURIComponent(productName) + '&pp=' + productPrice + '&cf=' + frontColors + '&cb=' + backColors + '&cl=' + leftColors + '&cr=' + rightColors + '&bs=' + blackShirt + '&eqf=' + estimatedQuantityFrom + '&eqt=' + estimatedQuantityTo + '&dh=' + $('#quick-design-hours').val(),
                type: 'GET',
                success: function (data) {
                    $('#table-content').html('');
                    $('#quick-price-per-shirt').val('');
                    $('#quick-price-total').val('');
                    if (data.success) {
                        for (var i = 0; i < data.quote.groups.length; i++) {
                            $('#table-content').append($('<div class="panel-heading title"><h4>' + data.quote.groups[i].title + '</h4></div>'));
                            var group = $('<table class="table-responsive"></table>');
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
                                    unitText = '$' + number_format(unit[0], 2, '.', ',');
                                }
                                if (total[0] === null) {
                                    if (total[1] !== null) {
                                        totalText = '$' + number_format(total[1], 2, '.', ',');
                                    }
                                    totalText = '$' + number_format(total[1], 2, '.', ',');
                                } else if (total[0] === total[1]) {
                                    totalText = '$' + number_format(total[0], 2, '.', ',');
                                } else {
                                    totalText = '$' + number_format(total[0]);
                                }
                                group.append($('<tr><td>' + data.quote.groups[i].lines[j].title + '</td><td class="gray-text" id="quick-product-unit">' + unitText + '</td><td class="blu-text" id="quick-product-total">' + totalText + '</td></tr>'));
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
                                groupTotalText = '$' + number_format(groupTotal[0], 2, '.', ',');
                            }
                            group.append($('<tr><td></td><td></td><td class="blu-text total-price">' + groupTotalText + '</td></tr>'));
                            $('#table-content').append(group);
                        }
                        var pricePerShirt = data.quote.price_unit;
                        if (pricePerShirt[0] !== pricePerShirt[1]) {
                            $('#quick-price-per-shirt').val('$' + number_format(pricePerShirt[0], 2, '.', ','));
                        } else {
                            $('#quick-price-per-shirt').val('$' + number_format(pricePerShirt[0], 2, '.', ','));
                        }
                        var priceTotal = data.quote.price_total;
                        if (priceTotal[0] !== priceTotal[1]) {
                            $('#quick-price-total').val('$' + number_format(priceTotal[0], 2, '.', ','));
                        } else {
                            $('#quick-price-total').val('$' + number_format(priceTotal[0], 2, '.', ','));
                        }
                    }
                },
                error: function (data) {

                },
                complete: function () {
                }
            });
        }
        $('#quick-design-hours').change(updateQuote);
        $('#quick-design-hours').keyup(updateQuote);
        $('#quick-design-hours').keydown(updateQuote);

        $('#quick-product-price').change(updateQuote);
        $('#quick-product-price').keyup(updateQuote);
        $('#quick-product-price').keydown(updateQuote);

        $('#quick-estimated-quantity').change(updateQuote);
        $('#quick-estimated-quantity').keyup(updateQuote);
        $('#quick-estimated-quantity').keydown(updateQuote);
        $('.toggle-quick-quote').click(function (event) {
            if ($('#quote-modal').hasClass('hidden-override')) {
                updateQuote();
                $('#quote-modal').removeClass('hidden-override');
                $('#quote-modal').show();
            } else {
                $('#quote-modal').addClass('hidden-override');
                $('#quote-modal').hide();
            }
        });
        function updateGarmentTypeNumber() {
            for (var i = 0; i < garmentTypes.length; i++) {
                if (garmentTypes[i].style_number === $('#quick-garment-style-number').val()) {
                    $('#quick-garment-type').val(garmentTypes[i].id);
                    updateGarmentTypeSelect();
                }
            }
        }
        function updateGarmentTypeSelect() {
            if ($('#quick-garment-type').val()) {
                for (var i = 0; i < garmentTypes.length; i++) {
                    if (garmentTypes[i].id === parseInt($('#quick-garment-type').val())) {
                        $('#quick-product-price').val(garmentTypes[i].price);
                        updateQuote();
                    }
                }
            }
        }
        $('#quick-garment-style-number').change(updateGarmentTypeNumber);
        $('#quick-garment-style-number').keyup(updateGarmentTypeNumber);
        $('#quick-garment-type').change(updateGarmentTypeSelect);
        $('#quick-garment-type').keyup(updateGarmentTypeSelect);


        $('#quick-front-colors').change(updateQuote);
        $('#quick-front-colors').keyup(updateQuote);
        $('#quick-sleeve-front-colors').change(updateQuote);
        $('#quick-sleeve-front-colors').keyup(updateQuote);
        $('#quick-back-colors').change(updateQuote);
        $('#quick-back-colors').keyup(updateQuote);
        $('#quick-left-colors').change(updateQuote);
        $('#quick-left-colors').keyup(updateQuote);
        $('#quick-right-colors').change(updateQuote);
        $('#quick-right-colors').keyup(updateQuote);
        $('#quick-black-shirt').change(updateQuote);
        $('#quick-black-shirt').keyup(updateQuote);

    </script>
    <script>
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