@extends ('admin.layouts.admin')

@section ('content')
    {{ Form::open() }}
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Campaign Shipping Types
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Group</label>
                        <div class="col-12 col-sm-9">{{ Form::select('shipping_group', enabled_disabled_repository()->options(), $campaign->shipping_group ? 'enabled' : 'disabled', ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Individual</label>
                        <div class="col-12 col-sm-9">{{ Form::select('shipping_individual', enabled_disabled_repository()->options(), $campaign->shipping_individual ? 'enabled' : 'disabled', ['class' => 'form-control']) }}</div>
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

