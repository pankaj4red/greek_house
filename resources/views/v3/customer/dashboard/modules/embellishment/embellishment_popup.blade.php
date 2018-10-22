@extends('v3.layouts.campaign')

@section('title', 'Embellishment')

@section('content_campaign')
    {{ Form::open() }}
    <div class="form-group required">
        <label>Print Type</label>
        {{ Form::select('design_type', design_type_options(), $campaign->artwork_request->design_type, ['class' => 'form-control', 'required']) }}
    </div>
    <div class="form-group required">
        <label>Polybag & Label</label>
        {{ Form::select('polybag_and_label', yes_no_options(), $campaign->polybag_and_label ? 'yes' : 'no', ['class' => 'form-control', 'required']) }}
    </div>
    <div class="text-right">
        <a href="{{ $back }}" class="btn btn-default btn-back">Back</a>
        <button type="submit" class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Submit</button>
    </div>
    {{ Form::close() }}
@endsection
