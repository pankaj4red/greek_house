@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create Product Color</h1>
        </div>
    </div>
    {!! Form::model($model) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Product Color Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Product</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $product->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label" for="avatar">Image</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="file-list"  id="color_image_div">
                                    @include ('partials.image_picker', [
                                        'fieldName' => 'image',
                                        'fieldType' => 'image',
                                        'fieldData' => isset($image) ? $image : null
                                    ])
                                </div>
                                {{Form::hidden('create_thumbnail_url', url('/admin/product_color/create_thumbnail/'), ['id' => 'create_thumbnail_url'])}}
                                {{Form::hidden('prefix','product_color.create' , ['id' => 'prefix'])}}

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label" for="avatar">Thumbnail</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="file-list"  id="color_thumbnail_div">
                                    @include ('partials.image_picker', [
                                        'fieldName' => 'thumbnail',
                                        'fieldType' => 'image',
                                        'fieldData' => isset($thumbnail) ? $thumnail : null
                                    ])
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class=" action-area pull-right">
                <a href="{{ route('admin::product::read', [$product->id]) }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section ('javascript')
    @include ('partials.enable_filepicker')
@append
@section ('javascript')
    <script>
        window.filepicker_callback = function (target, action, data) {
            if(action == 'add') {
                if (target !== 'image') {
                    return;
                }
                $.ajax({
                    url: $("#create_thumbnail_url").val(),
                    type: 'GET',
                    dataType: 'json',
                    data: {'filename': data.filename, 'file_url': data.url, 'prefix': $("#prefix").val()},
                    beforeSend:function(){
                        $(":submit").prop('disabled', true);
                        var loading_img = '<div class="ajax-progress ajax-progress-throbber"><i class="glyphicon glyphicon-refresh glyphicon-spin"></i></div>';
                        $("#color_thumbnail_div").find('.file-entry .file-entry-image').html(loading_img);
                    },
                    success: function (result) {
                        //populate thumbnail info
                        console.log(result);
                        $("#color_thumbnail_div").find('.file-entry').remove();
                        $("#color_thumbnail_div .file-wrapper").find(".filepicker-file").before($('<div class="file-entry"><div class="file-entry-image"><img src="' + result.url + '"/><span>' + result.filename + '</span></div>' +
                            '<input type="hidden" value="' + result.url + '" name="thumbnail_url"/>' +
                            '<input type="hidden" value="' + result.filename + '" name="thumbnail_filename"/>' +
                            '<input type="hidden" value="0" name="thumbnail_id"/>' +
                            '<input type="hidden" value="existing" name="thumbnail_action"/>' +
                            '<a href="#" class="btn btn-danger file-remove" data-target="thumbnail">Remove</a>' +
                            '</div>'));
                    },
                    complete: function () {
                        $(":submit").prop('disabled', false);
                    }


                });
            }
        };
    </script>
@append
