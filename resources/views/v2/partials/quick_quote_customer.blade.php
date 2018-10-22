<div class="quick-quote-popup">
    <div class="quick-quote">
        <a role="button" class="btn quick-quote-button toggle-quick-quote" href="javascript:void(0)"><img
                    src="{{ static_asset('images/icon-fixed-pop.png') }}" alt="pop-up"/></a>
        <h1>Quick Quote</h1>
        <div class="form-row">
            <span class="male-select">
                <label class="radio-label" for="male">
                    <input class="radio-btn iradio-radio" id="gender_male" type="radio" name="gender" value="2" checked>
                    Male
                </label>
            </span>
            <span class="female-select">
                 <label class="radio-label" for="female">
                     <input class="radio-btn iradio-radio" id="gender_female" type="radio" value="3" name="gender">
                    Female
                 </label>
            </span>
        </div>
        <div class="form-row">
            <label for="garment_category" class="sr-only">Garment Type</label>
            <select class="select-picker form-control" id="garment_category">
                <option value="" disabled selected>Choose Garment Type</option>
            </select>
        </div>
        <div class="form-row">
            <label for="garment_product" class="sr-only">Garment Product</label>
            <select class="select-picker form-control" id="garment_product">
                <option value="" disabled selected>Choose Product</option>
            </select>
        </div>
        <div class="form-row">
            <div class="pull-left half-select">
                <label for="colors_front" class="sr-only">Colors Front</label>
                <select class="select-picker form-control" id="colors_front">
                    <option value="" disabled selected>F. Colors</option>
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                </select>
            </div>
            <div class="pull-right half-select">
                <label for="colors_back" class="sr-only">Colors Back</label>
                <select class="select-picker form-control" id="colors_back">
                    <option value="" disabled selected>B. Colors</option>
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <input type="number" class="form-control" id="estimated_quantity" placeholder="Estimated Quantity (min: 24)"
                   min="24"/>
        </div>
        <div class="form-row btnbar"><a href="javascript:void(0)" class="btn btn-green pull-left"
                                        id="quick-quote-submit">SUBMIT</a> <a href="javascript:void(0)"
                                                                              class="btn btn-white-black toggle-quick-quote">Cancel</a>
        </div>
        <div class="form-row cost-detail">
            <ul>
                <li><span class="pull-left">Total Cost</span><span class="pull-right green-text text-left"
                                                                   id="total-cost"></span></li>
                <li>
                    <span class="pull-left">Cost/Shirt</span><span class="pull-right green-text text-left"
                                                                   id="shirt-cost"></span>
                </li>
            </ul>
        </div>
    </div>
</div>

@section ('javascript')
    <script>
        $('.iradio-radio').iCheck({
            checkboxClass: 'icheckbox',
            radioClass: 'iradio',
            increaseArea: '20%'
        });
    </script>
    <script>
        var quoteFirst = true;
        $('body').on('click', '.toggle-quick-quote', function (event) {
            event.preventDefault();
            $('.quick-quote-popup').toggleClass('show');
            if ($('.quick-quote-popup').hasClass('show') && quoteFirst === true) {
                quoteFirst = false;
                clearQuote();
                getCategories();

            }
            return false;
        });
    </script>
    <script>
        function getCategories() {
            var gender = 1;
            $('.iradio-radio:checked').each(function () {
                gender = parseInt($(this).val());
            });
            if (gender === 1) return;
            $('#garment_category').prop('disabled', true);
            $('#garment_product').prop('disabled', true);
            $.ajax({
                url: '{{ route('system::categories', ['']) }}' + '/' + gender,
                type: 'GET',
                success: function (data) {
                    $('#garment_category').empty();
                    $('#garment_product').empty();
                    if (data.success) {
                        $('#garment_category').append($('<option value="" disabled selected>Choose Garment Type</option>'));
                        $('#garment_product').append($('<option value="" disabled selected>Choose Product</option>'));
                        for (var i = 0; i < data.categories.length; i++) {
                            $('#garment_category').append($('<option value="' + data.categories[i].id + '">' + data.categories[i].name + '</option>'));
                        }
                        $('#garment_category').prop('disabled', false);
                        $('#garment_product').prop('disabled', false);
                    }
                },
                error: function (data) {
                    $('#garment_category').empty();
                },
                complete: function () {
                }
            });
        }

        function getProducts() {
            var gender = 1;
            $('.iradio-radio:checked').each(function () {
                gender = $(this).val();
            });
            if (gender === 1) return;
            var category = $('#garment_category').val();
            $('#garment_product').prop('disabled', true);
            $.ajax({
                url: '/garment-brand/' + gender + '/' + category,
                type: 'GET',
                success: function (data) {
                    $('#garment_product').empty();
                    if (data.success) {
                        $('#garment_product').append($('<option value="" disabled selected>Choose Product</option>'));
                        for (var i = 0; i < data.products.length; i++) {
                            $('#garment_product').append($('<option value="' + data.products[i].id + '">' + data.products[i].name + '</option>'));
                        }
                    }
                    $('#garment_product').prop('disabled', false);
                },
                error: function (data) {
                    $('#garment_product').empty();
                },
                complete: function () {
                }
            });
        }

        $('.quick-quote-popup').on('ifChecked', '.iradio-radio', getCategories);
        $('.quick-quote-popup').on('change', '#garment_category', getProducts);
        $('#quick-quote-submit').click(function (event) {
            event.preventDefault();
            var product = $('#garment_product').val();
            if (!product) return;
            if (!$('#estimated_quantity').val()) return;
            if ($('#estimated_quantity').val() < 24) {
                $('#estimated_quantity').val(24);
            }
            var estimatedQuantityFrom = $('#estimated_quantity').val();
            var estimatedQuantityTo = $('#estimated_quantity').val();
            var frontColors = $('#colors_front').val();
            if (!frontColors) return;
            var backColors = $('#colors_back').val();
            if (!backColors) return;
            $.ajax({
                url: '{{ route('system::quick_quote', ['screen']) }}' + '?pid=' + product + '&cf=' + frontColors + '&cb=' + backColors + '&eqf=' + estimatedQuantityFrom + '&eqt=' + estimatedQuantityTo,
                type: 'GET',
                success: function (data) {
                    if (data.success) {
                        if (data.quote.price_unit[0].toFixed(2) !== data.quote.price_unit[1].toFixed(2)) {
                            $('#shirt-cost').text('$' + number_format(data.quote.price_unit[0], 2, '.', ','));
                            $('#total-cost').text('$' + number_format(data.quote.price_total[0], 2, '.', ','));
                        } else {
                            $('#shirt-cost').text('$' + number_format(data.quote.price_unit[0], 2, '.', ','));
                            $('#total-cost').text('$' + number_format(data.quote.price_total[0], 2, '.', ','));
                        }
                        $('#shirt-postfix').removeClass('hidden-override');
                    }
                },
                error: function (data) {
                    $('#garment_product').empty();
                },
                complete: function () {
                }
            });
            return false;
        });

        function clearQuote() {
            $('#shirt-cost').text('');
            $('#total-cost').text('');
            $('#shirt-postfix').addClass('hidden-override');
        }

        $('.quick-quote-popup').on('change', 'input', clearQuote);
        $('.quick-quote-popup').on('change', 'select', clearQuote);
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
    <script src="{{ static_asset('js/icheck.js') }}" type="text/javascript"></script>
@append

