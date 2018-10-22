@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Garment Category</h1>
        </div>
    </div>
    {{ Form::model($garmentCategory) }}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Garment Category Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('name', null, ['class' => 'form-control']) }}
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
                                <label class="control-label">Active</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {{ Form::radio('active', true, null) }}Yes
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('active', false, null) }}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label" for="avatar">Wizard</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('wizard', wizard_options(), null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Shows in Additional Products</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {{ Form::radio('allow_additional', true, null) }}Yes
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('allow_additional', false, null) }}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Sort</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('sort', null, ['class' => 'form-control']) }}
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
                <a href="{{ route('admin::garment_category::read', [$garmentCategory->id]) }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section ('javascript')
    @include ('partials.enable_filepicker')
@append