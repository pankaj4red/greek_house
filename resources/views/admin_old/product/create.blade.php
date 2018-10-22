@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create Product</h1>
        </div>
    </div>
    {!! Form::model($model) !!}
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
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Style Number (SKU)</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('style_number', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Brand</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::select('garment_brand_id', garment_brand_options(['' => 'Select Brand']), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Category</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::select('garment_category_id', garment_category_options(['' => 'Select Category']), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Gender</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::select('garment_gender_id', garment_gender_options(['' => 'Select Gender']), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Price</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('price', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Sizes (Selected)</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">
                                    @foreach (garment_size_list() as $size)
                                        {!! Form::checkbox('size_' . $size->short, 'yes', old('size_' . $size->short)=='yes') !!} {{ $size->short }}
                                        <br/>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Sizes (Text)</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::textarea('sizes_text', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Features</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::textarea('features', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Active</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {!! Form::radio('active', 'yes', null) !!}Yes
                                </label>
                                <label class="radio-inline">
                                    {!! Form::radio('active', 'no', null) !!}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label" for="avatar">Image</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="file-list">
                                        @include ('partials.image_picker', [
                                            'fieldName' => 'image',
                                            'fieldType' => 'image',
                                            'fieldData' => isset($image) ? $image : null
                                        ])
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Suggested Supplier</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('suggested_supplier', null,['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Designe Instructions</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::textarea('designer_instructions', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Fulfillment Instructions</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::textarea('fulfillment_instructions', null, ['class' => 'form-control']) !!}
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
                <a href="{{ route('admin::product::list') }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section ('include')
    @if (!Request::ajax())
        @include ('partials.enable_filepicker')
    @endif
@append
