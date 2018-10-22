@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Campaign Actors</h1>
        </div>
    </div>
    {{ Form::model($campaign) }}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Actors
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">User</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('user_id', user_options(), $campaign->user_id, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Designer</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('designer_id', designer_options(['' => 'N/A']), $campaign->artwork_request->designer_id, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Decorator</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('decorator_id', decorator_options(null, ['' => 'N/A']), $campaign->decorator_id, ['class' => 'form-control']) }}
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
                <a href="{{ route('admin::campaign::read', [$campaign->id]) }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
