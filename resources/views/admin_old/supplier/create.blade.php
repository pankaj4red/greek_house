@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create Supplier</h1>
        </div>
    </div>
    {!! Form::model($model) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Supplier Information
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class=" action-area pull-right">
                <a href="{{ route('admin::supplier::list') }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
