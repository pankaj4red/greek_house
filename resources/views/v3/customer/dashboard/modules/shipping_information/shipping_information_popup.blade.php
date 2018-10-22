@extends('v3.layouts.campaign')

@section('title', 'Shipping Information')

@section('content_campaign')
    {{ Form::open() }}
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group required">
                <label>First Name</label>
                {{ Form::text('contact_first_name', $campaign->contact_first_name, ['class' => 'form-control', 'required']) }}
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group required">
                <label>Last Name</label>
                {{ Form::text('contact_last_name', $campaign->contact_last_name, ['class' => 'form-control', 'required']) }}
            </div>
        </div>
    </div>
    <div class="form-group required">
        <label>Line 1</label>
        {{ Form::text('address_line1', $campaign->address_line1, ['class' => 'form-control', 'required']) }}
    </div>
    <div class="form-group">
        <label>Line 2</label>
        {{ Form::text('address_line2', $campaign->address_line2, ['class' => 'form-control', 'required']) }}
    </div>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group required">
                <label>City</label>
                {{ Form::text('address_city', $campaign->address_city, ['class' => 'form-control', 'required']) }}
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group required">
                <label>State</label>
                {{ Form::text('address_state', $campaign->address_state, ['class' => 'form-control', 'required']) }}
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group required">
                <label>Zip Code</label>
                {{ Form::text('address_zip_code', $campaign->address_zip_code, ['class' => 'form-control', 'required']) }}
            </div>
        </div>
    </div>
    <div class="text-right">
        <a href="{{ $back }}" class="btn btn-default btn-back">Back</a>
        <button type="submit" class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Submit</button>
    </div>
    {{ Form::close() }}
@endsection
