@extends ('admin.layouts.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Slide</h1>
        </div>
    </div>
    {!! Form::model($model) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Slide Information
                    <span class="right-align">
                    <a href="{{ route('admin::slider::delete', [$model->id]) }}"
                       class="btn btn-danger">Delete</a>
                    </span>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
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
                                <label class="control-label">URL</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('url', $model->url, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Priority</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('priority', $model->priority, ['class' => 'form-control']) !!}
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
                <a href="{{ route('admin::slider::list') }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section ('javascript')
    @include ('partials.enable_filepicker')
@append

