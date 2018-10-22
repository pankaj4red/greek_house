@extends('v2.layouts.campaign')

@section('title', 'Shipping Information')

@section('content_campaign')
    {{ Form::open() }}
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label class="gh-label">First Name</label>
                {{ Form::text('contact_first_name', $campaign->contact_first_name, ['class' => 'gh-control']) }}
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label class="gh-label">Last Name</label>
                {{ Form::text('contact_last_name', $campaign->contact_last_name, ['class' => 'gh-control']) }}
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="gh-label">Line 1</label>
        {{ Form::text('address_line1', $campaign->address_line1, ['class' => 'gh-control']) }}
    </div>
    <div class="form-group">
        <label class="gh-label">Line 2</label>
        {{ Form::text('address_line2', $campaign->address_line2, ['class' => 'gh-control']) }}
    </div>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group">
                <label class="gh-label">City</label>
                {{ Form::text('address_city', $campaign->address_city, ['class' => 'gh-control']) }}
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group">
                <label class="gh-label">State</label>
                {{ Form::text('address_state', $campaign->address_state, ['class' => 'gh-control']) }}
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group">
                <label class="gh-label">Zip Code</label>
                {{ Form::text('address_zip_code', $campaign->address_zip_code, ['class' => 'gh-control']) }}
            </div>
        </div>
    </div>
    <div class="form-group buttons">
        <a href="{{ $back }}" class="gh-btn grey-transparent btn-close">Back</a>
        <button type="submit" class="gh-btn blue"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Submit</button>
    </div>
    {{ Form::close() }}
@endsection
