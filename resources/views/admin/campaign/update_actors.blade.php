@extends ('admin.layouts.admin')

@section ('content')
    {{ Form::open() }}
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Campaign Actors
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Customer</label>
                        <div class="col-12 col-sm-9">{{ Form::select('user_id', user_options(), $campaign->user_id, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Designer</label>
                        <div class="col-12 col-sm-9">{{ Form::select('designer_id', designer_options(['' => 'N/A']), $campaign->artwork_request->designer_id, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Decorator</label>
                        <div class="col-12 col-sm-9">{{ Form::select('decorator_id', decorator_options(null, ['' => 'N/A']), $campaign->decorator_id, ['class' => 'form-control']) }}</div>
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

