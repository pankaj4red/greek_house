@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Product Details
                <a href="{{ route('admin::product::update', [$model->id]) }}" class="btn btn-default">Edit</a>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Product Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">#</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->id }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Style Number (SKU)</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->style_number }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Brand</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ ($model->brand) ? $model->brand->name : '' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Category</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->category->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Gender</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->gender->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Price</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">${{ number_format($model->price, 2) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Sizes (Selected)</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">
                                    @foreach ($model->sizes as $size)
                                        {{ $size->size->name }}<br/>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->description }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Sizes (Text)</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->sizes_text }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Features</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->features }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Active</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->active?'Active':'Inactive' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Image</label>
                            </div>
                            <div class="col-sm-9">
                                @if ($model->image)
                                    <img src="{{ route('system::image', [$model->image->id]) }}"/>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Suggested Supplier</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{!!  bbcode($model->suggested_supplier) !!}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Designer Instructions</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{!!  bbcode($model->designer_instructions)  !!}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Fulfillment Instructions</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{!!  bbcode($model->fulfillment_instructions)  !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Colors
                    <a href="{{ route('admin::product_color::create', [$model->id]) }}"
                       class="btn btn-default">Create</a>
                </div>
                <div class="panel-body">
                    @if ($model->colors)
                        @foreach ($model->colors as $color)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    {{ $color->name }}
                                    <a href="{{ route('admin::product_color::update', [$color->id]) }}"
                                       class="btn btn-default">Edit</a>
                                    <a href="{{ route('admin::product_color::delete', [$color->id]) }}"
                                       class="btn btn-danger">Delete</a>
                                </div>
                                <div class="panel-body">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label class="control-label">Name</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $color->name }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label class="control-label">Thumbnail</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="form-control-static"><img class="image-thumbnail"
                                                                                    src="{{ route('system::image', [$color->thumbnail_id]) }}"/>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label class="control-label">Image</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="form-control-static"><img class="image-thumbnail"
                                                                                    src="{{ route('system::image', [$color->image_id]) }}"/>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label class="control-label">Active</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $color->active?'Active':'Inactive' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        No colors
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class=" action-area pull-right">
                <a href="{{ route('admin::product::list') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
@endsection