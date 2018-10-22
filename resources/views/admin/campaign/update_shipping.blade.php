@extends ('admin.layouts.admin')

@section ('content')
    {{ Form::model($campaign) }}
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Campaign Contacts
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Name</label>
                        <div class="col-12 col-sm-9">{{ Form::text('address_name', null, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Line 1</label>
                        <div class="col-12 col-sm-9">{{ Form::text('address_line1', null, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Line 2</label>
                        <div class="col-12 col-sm-9">{{ Form::text('address_line2', null, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">City</label>
                        <div class="col-12 col-sm-9">{{ Form::text('address_city', null, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">State</label>
                        <div class="col-12 col-sm-9">{{ Form::text('address_state', null, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Zip Code</label>
                        <div class="col-12 col-sm-9">{{ Form::text('address_zip_code', null, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Country</label>
                        <div class="col-12 col-sm-9">{{ Form::select('address_country', country_options(), null, ['class' => 'form-control']) }}</div>
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
