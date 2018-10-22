@section ('javascript')
    <script>
        function printType(printTypeSelector, estimatedQuantitySelector) {
            $(printTypeSelector).change(function() {
                $.ajax({
                    url: '{{ route('system::estimated_quantities', '') }}' + '/' + $(printTypeSelector).val(),
                    success: function (data) {
                        $(estimatedQuantitySelector + ' option[value!=""]').each(function(index, option) {
                            option.remove();
                        });
                        for (var code in data.estimated_quantity_options) {
                            $(estimatedQuantitySelector).append($('<option value="' + code + '">' + data.estimated_quantity_options[code] + '</option>'));
                        }
                    },
                    error: function (data) {
                        $('.ajax-messages').empty();
                        $('.ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                    }
                });
            });
        }
    </script>
@append
