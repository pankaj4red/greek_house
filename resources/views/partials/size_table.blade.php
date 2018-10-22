<?php $randomId = rand(0, 100); ?>
<div class="table-responsive" id="st_{{ $randomId }}">
    <table class="table table-bordered table-sizes">
        <thead>
        <tr>
            @if ($declareInvalid)
                <th class="col-select"></th>
            @endif
            <th class="col-style">STYLE</th>
            <th class="col-color">COLOR</th>
            @foreach ($sizeTable->sizes as $short => $quantity)
                <th class="col-{{ $short }}">{{ $short }}</th>
            @endforeach
            <th class="col-quantity">TOTAL</th>
            @if ($showCost)
                <th class="col-total">COST</th>
            @endif
            <th class="col-supplier">SUPPLIER</th>
            <th class="col-ship-form">SHIP FROM</th>
            <th class="col-eta">ETA</th>
            @if ($edit)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody class="line-list">
        <tr class="line-current">
            @if ($declareInvalid)
                <td class="col-select grey"></td>
            @endif
            <td class="grey text-left col-title" colspan="2">CURRENT</td>
            @foreach ($sizeTable->sizes as $short => $quantity)
                <td class="grey current-value col-{{ $short }}">/</td>
            @endforeach
            <td class="grey current-value col-quantity">{{ $sizeTable->quantity }}</td>
            @if ($showCost)
                <td class="grey current-value col-total">/</td>
            @endif
            <td class="grey" colspan="3"></td>
            @if ($edit)
                <td>
                    <a href="#" class="input-add">+</a>
                </td>
            @endif
        </tr>
        <tr class="line-total grey">
            @if ($declareInvalid)
                <td class="col-select grey"></td>
            @endif
            <td class="grey text-left original-value col-title" colspan="2">ORDER TOTAL</td>
            @foreach ($sizeTable->sizes as $short => $quantity)
                <td class="grey original-value col-{{ $short }}">{{ $quantity }}</td>
            @endforeach
            <td class="grey original-value col-quantity">{{ $sizeTable->quantity }}</td>
            @if ($showCost)
                <td class="grey original-value col-total">{{ money($sizeTable->total) }}</td>
            @endif
            <td class="grey" colspan="{{ 3+($edit?1:0) }}"></td>
        </tr>
        </tbody>
    </table>
</div>

@section ('javascript')
    <script>
        var st{{ $randomId }}_information = JSON.parse("{!! slashes(json_encode($sizeTable)) !!}");

        //todo: refactor
        function st{{ $randomId }}_updateActions() {
            if ($('#st_{{ $randomId }} .input-remove').length > 1) {
                $('#st_{{ $randomId }} .input-remove').show();
            } else {
                $('#st_{{ $randomId }} .input-remove').hide();
            }
        }

        //todo: refactor
        function st{{ $randomId }}_updateCurrent() {
            var lines = [];
            var currentSizes = [];
            var totalSizes = [];
            var quantity = 0;
            var total = 0;
            $('#st_{{ $randomId }} tr.line').each(function () {
                var line = {'id': 0, 'sizes': {}, 'supplier': 0, 'eta': '', 'ship_from': '', 'quantity': 0, 'total': 0};
                var lineQuantity = 0;
                for (var size in st{{ $randomId }}_information['sizes']) {
                    currentSizes[size] = parseInt($(this).find('.input-' + size).val());
                    if (typeof totalSizes[size] === 'undefined') {
                        totalSizes[size] = 0;
                    }
                    totalSizes[size] += parseInt($(this).find('.input-' + size).val());
                    lineQuantity += parseInt($(this).find('.input-' + size).val());
                    line.sizes[size] = parseInt($(this).find('.input-' + size).val());
                }
                line.id = $(this).find('.input-id').val();
                line.product = $(this).find('.input-product').val();
                line.color = $(this).find('.input-color').val();
                line.ship_from = $(this).find('.input-ship-form').val();
                line.eta = $(this).find('.input-eta').val();
                line.supplier = $(this).find('.input-supplier').val();
                if ($(this).find('.input-total').length > 0) {
                    line.total = $(this).find('.input-total').val().replace('$', '');
                }
                line.quantity = lineQuantity;
                total += parseFloat(line.total);
                quantity += lineQuantity;
                $(this).find('.col-quantity').text(lineQuantity);
                lines.push(line);
            });
            $('#st_{{ $randomId }} tr.line-current').find('.col-quantity').text(quantity);
            $('#st_{{ $randomId }} tr.line-current').find('.col-total').text('$' + total.toFixed(2));
            for (var size in totalSizes) {
                $('#st_{{ $randomId }} tr.line-current').find('.col-' + size).text(totalSizes[size]);
            }
            $('#sizes').val(JSON.stringify(lines));
        }

        function st{{ $randomId }}_addLine(line) {
            var elementText = '<tr class="line">';
            @if ($declareInvalid)
                elementText += '<td class="line col-select"><input type="checkbox" name="supplies[]" value="0" class="input-select"/></td>';
                    @endif
            var styleNumberSelect = '<select class="input-product">';
            var colorNameSelect = '<select class="input-color">';
            var index = 0;
            for (var productKey in st{{ $randomId }}_information.products) {
                if (line == null && index == 0 || line != null && line.product == st{{ $randomId }}_information.products[productKey].id) {
                    for (var colorKey in st{{ $randomId }}_information.products[productKey].colors) {
                        var selectedColor = line != null && line.product_color == st{{ $randomId }}_information.products[productKey].colors[colorKey].id ? 'selected' : '';
                        colorNameSelect += '<option ' + selectedColor + ' value="' + st{{ $randomId }}_information.products[productKey].colors[colorKey].id + '">' + st{{ $randomId }}_information.products[productKey].colors[colorKey].name + '</option>';
                    }
                }
                var styleNumberSelected = line != null && line.product == st{{ $randomId }}_information.products[productKey].id ? 'selected' : '';
                styleNumberSelect += '<option ' + styleNumberSelected + ' value="' + st{{ $randomId }}_information.products[productKey].id + '">' + st{{ $randomId }}_information.products[productKey].name + '</option>';

                index++;
            }
            styleNumberSelect += '</select>';
            colorNameSelect += '</select>';
            elementText += '<td class="grey line col-style"><input type="hidden" class="input-id" value="0"/>' + styleNumberSelect + '</td><td class="grey line col-color">' + colorNameSelect + '</td>';
            for (var size in st{{ $randomId }}_information['sizes']) {
                elementText += '<td class="line col-' + size + ' {{ (!$edit)?'grey':'' }}"><input type="text" class="form-control input-' + size + '" value="0" {{ (!$edit)?' readonly':'' }}/></td>';
            }

            var supplyText = '';
            for (var supplyIndex in st{{ $randomId }}_information['suppliers']) {
                supplyText += '<option value="' + st{{ $randomId }}_information['suppliers'][supplyIndex]['id'] + '">' + st{{ $randomId }}_information['suppliers'][supplyIndex]['name'] + '</option>';
            }
            elementText += '<td class="grey line col-quantity"><input type="text" class="form-control input-quantity" value="0" {!! (!$edit)?' readonly':'' !!}/></td>';
            @if ($showCost)
                elementText += '<td class="{{ (!$edit)?'grey':'' }} line col-total"><input type="text" class="form-control input-total" value="0" {{ (!$edit)?' readonly':'' }}/></td>';
            @endif
                elementText += '<td class="col-supplier {{ (!$edit)?'grey':'' }}">';
            @if (!isset($print) || $print == false)
                elementText += '<select class="input-supplier" {{ (!$edit)?'disabled':'' }}>' + supplyText + '</select>';
            @endif
                    elementText += '</td><td class="{{ (!$edit)?'grey':'' }}"><input type="text" class="form-control input-ship-form" value="" size="60" {{ (!$edit)?'readonly':'' }}/></td>';
            elementText += '<td class="{{ (!$edit)?'grey':'' }}"><input type="text" class="form-control input-eta" value="" size="60" {{ (!$edit)?'readonly':'' }}/></td>';
            @if ($edit)
                    elementText += '<td><a href="#" class="input-remove">X</a></td>';
            @endif
                    elementText += '</tr>';
            var element = $(elementText);
            $('#st_{{ $randomId }} .line-list .line-current').before(element);
            element.find('.input-supplier').val(element.find('.input-supplier option:first-child').attr('value'));
            if (line) {
                if (line.id) {
                    //element.find('.input-supplier').prop('disabled', true);
                }
                for (size in line['sizes']) {
                    element.find('.input-' + size).val(line['sizes'][size]);
                }
                if (line['supplier']) {
                    @if (!isset($print) || $print == false)
                    element.find('.input-supplier').val(line['supplier']);
                    @else
                        for (supplyIndex in st{{ $randomId }}_information['suppliers']) {
                        if (st{{ $randomId }}_information['suppliers'][supplyIndex]['id'] === line['supplier']) {
                            @if ($edit)
                            element.find('.input-supplier').val(st{{ $randomId }}_information['suppliers'][supplyIndex]['id']);
                            @else
                            element.find('.col-supplier').text(st{{ $randomId }}_information['suppliers'][supplyIndex]['name']);
                            @endif
                        }
                    }
                    @endif
                }
                element.find('.col-quantity').text(line['quantity']);
                element.find('.input-id').val(line['id']);
                element.find('.input-select').val(line['id']);
                element.find('.input-total').val({!! (!$edit)?'"$" + ':'' !!}line['total']);
                element.find('.input-eta').val(line['eta']);
                element.find('.input-ship-form').val(line['ship_from']);
                if (line['state'] === 'nok') {
                    element.find('input').prop('disabled', true);
                    element.find('select').prop('disabled', true);
                    element.addClass('red');
                    if (line['error']) {
                        var lineError = $('<span class="line-error"></span>');
                        lineError.text(line['error']);
                        element.find('td:first-child').append(lineError);
                    }
                }
            }
            st{{ $randomId }}_updateCurrent();
            @if ($edit)
            element.find(".input-eta").datepicker({
                inline: false,
                dateFormat: "mm/dd"
            });
            @endif
        }

        function st{{ $randomId }}_productUpdate(row) {
            var colors = st{{ $randomId }}_information.products[row.find('.input-product').val()].colors;
            row.find('.input-color').empty();
            for (var colorKey in colors) {
                row.find('.input-color').append('<option value="' + colors[colorKey].id + '">' + colors[colorKey].name + '</option>');
            }
        }

        st{{ $randomId }}_updateActions();
        $('#st_{{ $randomId }} .input-add').click(function (event) {
            event.preventDefault();
            st{{ $randomId }}_addLine(null);
            return false;
        });
        for (var lineIndex in st{{ $randomId }}_information['lines']) {
            st{{ $randomId }}_addLine(st{{ $randomId }}_information['lines'][lineIndex]);
        }
        @if ($edit)
        $('body').on('click', '#st_{{ $randomId }} .input-remove', function (event) {
            event.preventDefault();
            $(this).closest('tr').remove();
            st{{ $randomId }}_updateCurrent();
            return false;
        });
        $('body').on('keyup', '#st_{{ $randomId }} .line input', function (event) {
            event.preventDefault();
            st{{ $randomId }}_updateCurrent();
            return false;
        });
        $('body').on('click', '#st_{{ $randomId }} .line input', function (event) {
            event.preventDefault();
            st{{ $randomId }}_updateCurrent();
            return false;
        });
        $('body').on('change', '#st_{{ $randomId }} .input-supplier', function (event) {
            event.preventDefault();
            st{{ $randomId }}_updateCurrent();
            return false;
        });
        $('body').on('change', '#st_{{ $randomId }} .input-eta', function (event) {
            event.preventDefault();
            st{{ $randomId }}_updateCurrent();
            return false;
        });
        $('body').on('change', '#st_{{ $randomId }} .input-ship-from', function (event) {
            event.preventDefault();
            st{{ $randomId }}_updateCurrent();
            return false;
        });
        $('body').on('change', '#st_{{ $randomId }} .input-product', function (event) {
            event.preventDefault();
            st{{ $randomId }}_productUpdate($(this).closest('tr.line'));
            st{{ $randomId }}_updateCurrent();
            return false;
        });
        $('body').on('change', '#st_{{ $randomId }} .input-color', function (event) {
            event.preventDefault();
            st{{ $randomId }}_updateCurrent();
            return false;
        });
        @endif

        $("#sizeTable .line .input-eta").datepicker({
            inline: false,
            dateFormat: "mm/dd"
        });
    </script>
@append