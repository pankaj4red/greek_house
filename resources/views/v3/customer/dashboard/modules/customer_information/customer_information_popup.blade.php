@extends('v3.layouts.campaign')

@section('title', 'Customer Information')

@section('content_campaign')
    {{ Form::open() }}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group required">
                <label>First Name</label>
                {{ Form::text('contact_first_name', $campaign->contact_first_name, ['class' => 'form-control', 'placeholder' => 'First Name', 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group required">
                <label>Last Name</label>
                {{ Form::text('contact_last_name', $campaign->contact_last_name, ['class' => 'form-control', 'placeholder' => 'Last Name', 'required']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group required">
                <label>School</label>
                {{ Form::text('contact_school', $campaign->contact_school, ['class' => 'form-control contact_school school', 'placeholder' => 'School', 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group required">
                <label>Chapter</label>
                {{ Form::text('contact_chapter', $campaign->contact_chapter, ['class' => 'form-control contact_chapter chapter', 'placeholder' => 'Chapter', 'required']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group required">
                <label>Phone</label>
                {{ Form::text('contact_phone', $campaign->contact_phone, ['class' => 'form-control', 'placeholder' => 'Phone', 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group required">
                <label>Email</label>
                {{ Form::text('contact_email', $campaign->contact_email, ['class' => 'form-control', 'placeholder' => 'Email', 'required']) }}
            </div>
        </div>
    </div>
    <div class="text-right">
        <a href="{{ $back }}" class="btn btn-default btn-back">Back</a>
        <button type="submit" class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Submit</button>
    </div>
    {{ Form::close() }}
@endsection
