@extends ('admin.layouts.admin')

@section ('content')
    {{ Form::open() }}
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Campaign Information
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Id</label>
                        <div class="col-12 col-sm-9">{{ $campaign->id }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Name</label>
                        <div class="col-12 col-sm-9">{{ Form::text('name', $campaign->name, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">State</label>
                        <div class="col-12 col-sm-9">{{ Form::select('state', campaign_state_options(), $campaign->state, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Requested Date</label>
                        <div class="col-12 col-sm-9">{{ Form::text('date', $campaign->date ? $campaign->date->format('m/d/Y') : null, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Close Date</label>
                        <div class="col-12 col-sm-9">{{ Form::text('close_date', $campaign->close_date ? $campaign->close_date->format('m/d/Y') : null, ['class' => 'form-control datepicker']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Flexible</label>
                        <div class="col-12 col-sm-9">{{ Form::select('flexible', flexible_options(), $campaign->flexible, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Scheduled Date</label>
                        <div class="col-12 col-sm-9">{{ Form::text('scheduled_date', $campaign->scheduled_date ? $campaign->scheduled_date->format('m/d/Y') : null, ['class' => 'form-control datepicker']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Promo Code</label>
                        <div class="col-12 col-sm-9">{{ Form::text('promo_code', $campaign->promo_code, ['class' => 'form-control', 'placeholder' => 'Promo Code']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Estimated Quantity</label>
                        <div class="col-12 col-sm-9">{{ Form::select('estimated_quantity', estimated_quantity_options($campaign->artwork_request->design_type), $campaign->estimated_quantity, ['class' => 'form-control', 'id' => 'estimated_quantity']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Budget</label>
                        <div class="col-12 col-sm-9">{{ Form::select('budget', yes_no_options(), $campaign->budget, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Budget Range</label>
                        <div class="col-12 col-sm-9">{{ Form::select('budget_range', budget_options(), $campaign->budget_range, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Reminders</label>
                        <div class="col-12 col-sm-9">{{ Form::select('reminders', on_off_repository()->options(), $campaign->reminders, ['class' => 'form-control']) }}</div>
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
