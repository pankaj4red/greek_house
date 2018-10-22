@extends ('admin.layouts.admin')

@section ('content')
    {{ Form::open() }}
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Campaign Products
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Product / Color</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="product-list">
                            @foreach ($campaign->product_colors as $productColor)
                                <tr class="product-color-entry">
                                    <td>
                                        {{ Form::select('product_id[]', product_options(), $productColor->product_id, ['class' => 'form-control product-id']) }}<br/>
                                        {{ Form::select('color_id[]', product_color_options($productColor->product_id), $productColor->id, ['class' => 'form-control product-color-id']) }}
                                    </td>
                                    <td>
                                        <p class="form-control-static"><img class="color-image product-color-image" src="{{ route('system::image', $productColor->image_id) }}" style="width: 100px;"/>
                                        </p>
                                    </td>
                                    <td style="vertical-align: middle;"><a href="javascript: void(0);" class="btn btn-danger product-remove">Remove</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right mb-3">
                        <button type="button" class="btn btn-info add-more">Add More</button>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('admin::campaign::read', [$campaign->id]) }}" class="btn btn-default btn-back">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section ('javascript')
    <script>
        $('body').on('click', '.product-remove', function (event) {
            let entry = $(this).closest('.product-color-entry');
            entry.html('<td colspan="3" style="text-align: center;">Removed</td>');
            event.preventDefault();

            return false;
        });
        <?php $productColor = product_color_repository()->getByProductId(array_keys(product_options())[0])->first(); ?>
        $('body').on('click', '.add-more', function (event) {
            $('.product-list').append($("<tr class=\"product-color-entry\">\n" +
                "<td>\n" +
                "    {!! addslashes(Form::select('product_id[]', product_options(), null, ['class' => 'form-control product-id'])) !!}<br/>\n" +
                "    {!! addslashes(Form::select('color_id[]', product_color_options($productColor->product_id), null, ['class' => 'form-control product-color-id'])) !!}\n" +
                "</td>\n" +
                "<td>\n" +
                "    <p class=\"form-control-static\"><img class=\"color-image product-color-image\" src=\"{{ route('system::image', $productColor->image_id) }}\" style=\"width: 100px;\"/>\n" +
                "    </p>\n" +
                "</td>\n" +
                "<td style=\"vertical-align: middle;\"><a href=\"javascript: void(0);\" class=\"btn btn-danger product-remove\">Remove</a></td>\n" +
                "</tr>"));
            event.preventDefault();

            return false;
        });
        $('body').on('change', '.product-id', function () {
            let productColorSelect = $(this).closest('.product-color-entry').find('.product-color-id');
            let productColorImage = $(this).closest('.product-color-entry').find('.product-color-image');
            productColorSelect.html('<option>Loading...</option>');

            $.ajax({
                url: '{{ route('system::product_colors', ['']) }}/' + $(this).val(),
                type: 'GET',
                success: function (data) {
                    if (data.success) {
                        $('.ajax-messages').empty();
                        productColorSelect.empty();
                        for (let i = 0; i < data.colors.length; i++) {
                            productColorSelect.append($('<option value="' + data.colors[i].id + '">' + data.colors[i].name + '</option>'))
                        }
                        productColorImage.attr('src', '{{ route('system::image', ['ID']) }}'.replace('ID', data.colors[0].image_id));
                    } else {
                        $('.ajax-messages').empty();
                        let errorText = $('<ul></ul>');
                        for (let j = 0; j < data.errors.length; j++) {
                            errorText.append($('<li>' + data.errors[j] + '</li>'));
                        }
                        let alert = $('<div class="alert alert-danger" role="alert"></div>');
                        alert.append(errorText);
                        $('.ajax-messages').append(alert);
                    }
                },
                error: function (data) {
                    $('.ajax-messages').empty();
                    $('.ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                }
            });
        });
        $('body').on('change', '.product-color-id', function () {
            let productSelect = $(this).closest('.product-color-entry').find('.product-id');
            let productColorSelect = $(this);
            let productColorImage = $(this).closest('.product-color-entry').find('.product-color-image');

            $.ajax({
                url: '{{ route('system::product_colors', ['']) }}/' + productSelect.val(),
                type: 'GET',
                success: function (data) {
                    if (data.success) {
                        $('.ajax-messages').empty();
                        for (let i = 0; i < data.colors.length; i++) {
                            if (data.colors[i].id == productColorSelect.val()) {
                                productColorImage.attr('src', '{{ route('system::image', ['ID']) }}'.replace('ID', data.colors[i].image_id));
                                return;
                            }
                        }
                    } else {
                        $('.ajax-messages').empty();
                        let errorText = $('<ul></ul>');
                        for (let j = 0; j < data.errors.length; j++) {
                            errorText.append($('<li>' + data.errors[j] + '</li>'));
                        }
                        let alert = $('<div class="alert alert-danger" role="alert"></div>');
                        alert.append(errorText);
                        $('.ajax-messages').append(alert);
                    }
                },
                error: function (data) {
                    $('.ajax-messages').empty();
                    $('.ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                }
            });
        });
    </script>
@append
