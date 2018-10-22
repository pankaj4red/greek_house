@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Campaign Information</h1>
        </div>
    </div>
    {{ Form::open() }}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    General Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">#</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->id }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('name', $campaign->name, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">State</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('state', campaign_state_options(), $campaign->state, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Requested Date</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('date', $campaign->date ? $campaign->date->format('m/d/Y') : null, ['class' => 'form-control datepicker']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Close Date</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('close_date', $campaign->close_date ? $campaign->close_date->format('m/d/Y') : null, ['class' => 'form-control datepicker']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Flexible Date</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {{ Form::radio('flexible', 'yes', $campaign->flexible == 'yes') }}Yes
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('flexible', 'no', $campaign->flexible == 'no') }}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Scheduled Date</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('scheduled_date', $campaign->scheduled_date ? $campaign->scheduled_date->format('m/d/Y') : null, ['class' => 'form-control datepicker']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Promo Code</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('promo_code', $campaign->promo_code, ['class' => 'form-control', 'placeholder' => 'Promo Code']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Estimated Quantity</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('estimated_quantity', estimated_quantity_options($campaign->artwork_request->design_type), $campaign->estimated_quantity, ['class' => 'form-control', 'id' => 'estimated_quantity']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Budget</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('budget', yes_no_options(), $campaign->budget, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Budget Range</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('budget_range', budget_options(), $campaign->budget_range, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Reminders</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('reminders', ['on' => 'on', 'off' => 'off'], $campaign->reminders, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Fulfillment Notes</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::textarea('fulfillment_notes', $campaign->fulfillment_notes, ['class' => 'form-control']) }}

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

@section ('javascript')
    <link href="{{ static_asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <script src="{{ static_asset('js/jquery-ui.min.js') }}"></script>
    <script>
        $(".datepicker").datepicker({
            inline: false
        });
    </script>
@append
