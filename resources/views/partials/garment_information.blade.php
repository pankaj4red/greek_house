<div class="ajax-messages"></div>
<div class="garment-information-steps">
    <div class="step-gender">
        {{ Form::open(['id' => 'ajax-form-gender']) }}
        {{ csrf_field() }}
        <div class="row text-center margin-bottom">
            <?php $i = 0; ?>
            @foreach(garment_gender_list() as $gender)
                @if ($i % 4 == 0 && $i != 0)
        </div>
        <div class="row text-center margin-bottom">
            @endif
            <div class="col-md-4 category-option no-float">
                <div class="category-option-container">
                    <a href="#" class="link-submit-step1" data-id="{{ $gender->id }}">
                        <img src="{{ route('system::image', [$gender->image_id]) }}"/>
                    </a><br/>
                    <h2><span>{{ $gender->name }}</span></h2>
                </div>
            </div>
            <?php $i++; ?>
            @endforeach
        </div>
        <div class="action-row">
            <a href="{{ URL::previous() }}" class="button-back btn btn-default back-btn">Back</a>
        </div>
        {{ Form::close() }}
    </div>
    <div class="step-category hidden-override">
        {{ Form::open(['id' => 'ajax-form-category']) }}
        {{ csrf_field() }}
        <div class="row text-center margin-bottom step2-content">

        </div>
        <div class="action-row">
            <a href="#" class="button-back btn btn-default back-btn back-step2">Back</a>
        </div>
        {{ Form::close() }}
    </div>
    <div class="step-product hidden-override">
        {{ Form::open(['id' => 'ajax-form-product']) }}
        {{ csrf_field() }}
        <div class="row text-center margin-bottom step3-content">

        </div>
        <div class="action-row">
            <a href="#" class="button-back btn btn-default back-btn back-step3">Back</a>
        </div>
        {{ Form::close() }}
    </div>
    <div class="step-color hidden-override">
        {{ Form::open(['id' => 'ajax-form-color']) }}
        {{ csrf_field() }}
        <div class="row">
            <div class="color-list">

            </div>
        </div>
        <div class="row">
            <img src="data:image/png;base64,null" id="product-image" class="width-70"/>
        </div>
        <div class="action-row">
            <input type="hidden" value="0" name="product-id" id="product-id2"/>
            <input type="hidden" value="0" name="color-id" id="color-id"/>
            <a href="{{ URL::current() }}" class="button-back btn btn-default back-btn back-step4">Back</a>
            <button type="submit" name="save" value="save" class="btn btn-primary" id="ajax-button">Save</button>
        </div>
        {{ Form::close() }}
    </div>
</div>

@section ('include')
    <?php register_css(static_asset('css/atooltip.css')) ?>
    <?php register_js(static_asset('js/jquery.atooltip.min.js')) ?>
@append

@section ('javascript')
    <script>
        $('body').on('click', '.link-submit-step1', function (event) {
            event.preventDefault();
            $(this).closest('form').find('#gender-id').remove();
            $(this).closest('form').append($('<input type="hidden" id="gender-id" name="gender-id" value="' + $(this).attr('data-id') + '"/>'));
            var formData = $("#ajax-form-gender").serialize();
            var that = this;
            $.ajax({
                url: '{{ route('customer_block_popup', ['garment_information', $campaign->id, 'step1']) }}',
                type: 'POST',
                data: formData,
                success: function (data) {
                    if (data.success) {
                        $('.ajax-messages').empty();
                        $('.step-gender').addClass('hidden-override');
                        $('.step-category').removeClass('hidden-override');
                        var row = null;
                        $('.step2-content').empty();
                        for (var i = 0; i < data.categories.length; i++) {
                            if (i % 3 === 0) {
                                row = $('<div class="row text-center margin-bottom"></div>')
                            }
                            row.append($('<div class="col-md-4 category-option no-float"><div class="category-option-container"><a href="#" class="link-submit-step2" data-id="' + data.categories[i].id + '">' +
                                    '<img src="{{ route('system::image', ['ID']) }}'.replace('ID', data.categories[i].image_id) + '"/></a><br/><h2><span>' + data.categories[i].name + '</span></h2></div></div>'));
                            if (i % 3 === 2) {
                                $('.step2-content').append(row);
                                row = null;
                            }
                        }
                        if (row !== null) {
                            $('.step2-content').append(row);
                        }
                    } else {
                        $('.ajax-messages').empty();
                        var errorText = $('<ul></ul>');
                        for (var j = 0; j < data.errors.length; j++) {
                            errorText.append($('<li>' + data.errors[j] + '</li>'));
                        }
                        var alert = $('<div class="alert alert-danger" role="alert"></div>');
                        alert.append(errorText);
                        $('.ajax-messages').append(alert);
                    }
                },
                error: function (data) {
                    $('.ajax-messages').empty();
                    $('.ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                },
                complete: function () {
                    $(that).find('.ajax-progress').remove();
                    $(that).prop('disabled', false);
                }
            });
            return false;
        });
    </script>
    <script>
        $('body').on('click', '.link-submit-step2', function (event) {
            event.preventDefault();
            $(this).closest('form').find('#gender-id2').remove();
            $(this).closest('form').append($('<input type="hidden" id="gender-id2" name="gender-id" value="' + $('#gender-id').val() + '"/>'));
            $(this).closest('form').append($('<input type="hidden" id="category-id" name="category-id" value="' + $(this).attr('data-id') + '"/>'));
            var formData = $("#ajax-form-category").serialize();
            var that = this;
            $.ajax({
                url: '{{ route('customer_block_popup', ['garment_information', $campaign->id, 'step2']) }}',
                type: 'POST',
                data: formData,
                success: function (data) {
                    if (data.success) {
                        $('.ajax-messages').empty();
                        $('.step-category').addClass('hidden-override');
                        $('.step-product').removeClass('hidden-override');
                        var row = null;
                        $('.step3-content').empty();
                        for (var i = 0; i < data.products.length; i++) {
                            if (i % 3 === 0) {
                                row = $('<div class="row text-center margin-bottom"></div>')
                            }
                            row.append($('<div class="col-md-4 category-option no-float"><div class="category-option-container"><a href="#" class="link-submit-step3" data-id="' + data.products[i].id + '">' +
                                    '<img src="{{ route('system::image', ['ID']) }}'.replace('ID',data.products[i].image_id) + '"/></a><br/><h2><span>' + data.products[i].name + '</span></h2></div></div>'));
                            if (i % 3 === 2) {
                                $('.step3-content').append(row);
                                row = null;
                            }
                        }
                        if (row !== null) {
                            $('.step3-content').append(row);
                        }
                    } else {
                        $('.ajax-messages').empty();
                        var errorText = $('<ul></ul>');
                        for (var j = 0; j < data.errors.length; j++) {
                            errorText.append($('<li>' + data.errors[j] + '</li>'));
                        }
                        var alert = $('<div class="alert alert-danger" role="alert"></div>');
                        alert.append(errorText);
                        $('.ajax-messages').append(alert);
                    }
                },
                error: function (data) {
                    $('.ajax-messages').empty();
                    $('.ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                },
                complete: function () {
                    $(that).find('.ajax-progress').remove();
                    $(that).prop('disabled', false);
                }
            });
            return false;
        });
    </script>
    <script>
        $('body').on('click', '.link-submit-step3', function (event) {
            event.preventDefault();
            $(this).closest('form').find('#product-id').remove();
            $('#product-id2').val($(this).attr('data-id'));
            $(this).closest('form').append($('<input type="hidden" id="product-id" name="product-id" value="' + $(this).attr('data-id') + '"/>'));
            var formData = $("#ajax-form-product").serialize();
            var that = this;
            $.ajax({
                url: '{{ route('customer_block_popup', ['garment_information', $campaign->id, 'step3']) }}',
                type: 'POST',
                data: formData,
                success: function (data) {
                    if (data.success) {
                        $('.ajax-messages').empty();
                        $('.step-product').addClass('hidden-override');
                        $('.step-color').removeClass('hidden-override');
                        var row = null;
                        $('.color-list').empty();
                        for (var i = 0; i < data.colors.length; i++) {
                            $('.color-list').append('<a href="#" class="color-selection" data-id="' + data.colors[i].id + '"><img src="{{ route('system::image', ['ID']) }}'.replace('ID', data.colors[i].thumbnail_id) + '" title="' + data.colors[i].name + '"/></a>');
                        }
                        $('#product-image').attr('src', '{{ route('system::image', ['ID']) }}'.replace('ID', data.colors[0].image_id));
                        $('#color-id').val(data.colors[0].id);
                        $('.color-selection img').aToolTip();
                    } else {
                        $('.ajax-messages').empty();
                        var errorText = $('<ul></ul>');
                        for (var j = 0; j < data.errors.length; j++) {
                            errorText.append($('<li>' + data.errors[j] + '</li>'));
                        }
                        var alert = $('<div class="alert alert-danger" role="alert"></div>');
                        alert.append(errorText);
                        $('.ajax-messages').append(alert);
                    }
                },
                error: function (data) {
                    $('.ajax-messages').empty();
                    $('.ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                },
                complete: function () {
                    $(that).find('.ajax-progress').remove();
                    $(that).prop('disabled', false);
                }
            });
            return false;
        });
    </script>
    <script>
        $('.back-step2').click(function (event) {
            event.preventDefault();
            $('.ajax-messages').empty();
            $('.step-category').addClass('hidden-override');
            $('.step-gender').removeClass('hidden-override');
            return false;
        });
        $('.back-step3').click(function (event) {
            event.preventDefault();
            $('.ajax-messages').empty();
            $('.step-product').addClass('hidden-override');
            $('.step-category').removeClass('hidden-override');
            return false;
        });
        $('.back-step4').click(function (event) {
            event.preventDefault();
            $('.ajax-messages').empty();
            $('.step-color').addClass('hidden-override');
            $('.step-product').removeClass('hidden-override');
            return false;
        });
    </script>
    <script>
        $('#ajax-button').click(function (event) {
            event.preventDefault();
            var formData = $("#ajax-form-color").serialize();
            $(this).prop('disabled', true);
            $(this).append('<div class="ajax-progress ajax-progress-throbber"><i class="glyphicon glyphicon-refresh glyphicon-spin"></i></div>');
            var that = this;
            $.ajax({
                url: '{{ Request::getRequestUri() }}',
                type: 'POST',
                data: formData,
                success: function (data) {
                    if (data.success) {
                        $('.ajax-messages').empty();
                        $('.ajax-messages').append($('<div class="alert alert-success" role="alert">Submit Successful. Redirecting...</div>'));
                        window.location = data.intended;
                    } else {
                        $('.ajax-messages').empty();
                        var errorText = $('<ul></ul>');
                        for (var i = 0; i < data.errors.length; i++) {
                            errorText.append($('<li>' + data.errors[i] + '</li>'));
                        }
                        var alert = $('<div class="alert alert-danger" role="alert"></div>');
                        alert.append(errorText);
                        $('.ajax-messages').append(alert);
                    }
                },
                error: function (data) {
                    $('.ajax-messages').empty();
                    $('.ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                },
                complete: function () {
                    $(that).find('.ajax-progress').remove();
                    $(that).prop('disabled', false);
                }
            });
            return false;
        });
    </script>
    <!--suppress JSCheckFunctionSignatures -->
    <script>
        $('body').on('click', '.color-selection', function (event) {
            event.preventDefault();
            $.ajax('{{ route('campaign::ajax_image', ['']) }}/' + $(this).attr('data-id')).done(function (data) {
                $('#product-image').attr('src', '//{{ config('app.domain.content') }}/image/' + data.image + '.png');
                $('#color-id').val(data.id);
            });
            return false;
        });
    </script>
@append

