@extends ('customer')

@section ('title', 'Profile - Add Address')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="page-header cancel-header-margin">
        <div class="container">
            <span class="pull-left page-title">Profile</span>
            <div class="pull-right new-order">
                <a role="button" href="{{ route('profile::add_address') }}" class="btn btn-default add-new-btn"
                   id="add-order">
                    <span>New Address</span>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="form-header">
            <h1><i class="icon icon-info"></i><span class="icon-text">New Address</span></h1>
            <hr/>
        </div>
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        {!! Form::open(['id' => 'form']) !!}
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default panel-box">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name this address</label>
                                    {!! Form::text('name', null, ['class' => 'form-control address-field', 'placeholder' => 'Address Name', 'data-address' => 'name', 'id' => 'name']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="line1">Address Line 1</label>
                                    {!! Form::text('line1', old('line1'), ['class' => 'form-control address-field', 'placeholder' => 'Line 1', 'data-address' => 'line1', 'id' => 'line1']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="line2">Address Line 2</label>
                                    {!! Form::text('line2', old('line2'), ['class' => 'form-control address-field', 'placeholder' => 'Line 2', 'data-address' => 'line2', 'id' => 'line2']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    {!! Form::text('city', null, ['class' => 'form-control address-field', 'placeholder' => 'City', 'data-address' => 'city', 'id' => 'city']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="state">State</label>
                                    {!! Form::text('state', null, ['class' => 'form-control address-field', 'placeholder' => 'State', 'data-address' => 'state', 'id' => 'state']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="zip_code">Zip Code</label>
                                    {!! Form::text('zip_code', null, ['class' => 'form-control address-field', 'placeholder' => 'Zip Code', 'data-address' => 'zip_code', 'id' => 'zip_code']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    {!! Form::select('country', country_options(), null, ['class' => 'form-control address-field', 'data-address' => 'country', 'id' => 'country']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="action-row">
            <a href="{{ route('profile::index') }}" class="button-back btn btn-default back-btn">Cancel</a>
            <button type="submit" name="save" value="save" class="btn btn-primary">Save</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection