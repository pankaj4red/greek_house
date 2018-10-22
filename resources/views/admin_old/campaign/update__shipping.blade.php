@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Campaign Shipping</h1>
        </div>
    </div>
    {{ Form::open() }}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Shipping Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('address_name', $campaign->address_name, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Line 1</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('address_line1', $campaign->address_line1, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Line 2</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('address_line2', $campaign->address_line2, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">City</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('address_city', $campaign->address_city, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">State</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('address_state', $campaign->address_state, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Zip Code</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('address_zip_code', $campaign->address_zip_code, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Country</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::select('address_country', country_options(), $campaign->address_country, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Shipping Types
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Group</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {{ Form::radio('shipping_group', 'yes', $campaign->shipping_group) }}Yes
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('shipping_group', 'no', ! $campaign->shipping_group) }}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Individual</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {{ Form::radio('shipping_individual', 'yes', $campaign->shipping_individual) }}Yes
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('shipping_individual', 'no', ! $campaign->shipping_individual) }}No
                                </label>
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
