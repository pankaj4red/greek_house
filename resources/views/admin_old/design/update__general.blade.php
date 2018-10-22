@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Design General</h1>
        </div>
    </div>
    {!! Form::open() !!}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Design Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('name', $design->name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Code</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('code', $design->code, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Campaign Id</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('campaign_id', $design->campaign_id, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Status</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::select('status', design_status_options(), $design->status, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Trending</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::select('trending', yes_no_options(), $design->trending ? 'yes' : 'no', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Thumbnail</label>
                            </div>
                            <div class="col-sm-9">
                                @include ('partials.image_picker', [
                                    'fieldName' => 'thumbnail',
                                    'fieldType' => 'image',
                                    'fieldData' => isset($thumbnail) ? $thumbnail : null
                                ])
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
                <a href="{{ route('admin::design::read', [$design->id]) }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section ('javascript')
    @include ('partials.enable_filepicker')
@append