@extends('v3.layouts.campaign')

@section('title', 'Important Dates')

@section('content_campaign')
    {{ Form::open() }}
    <div class="row">
        <div class="form-group col-12 required">
            <label>Rush</label>
            {{ Form::select('rush', yes_no_options(), $campaign->rush ? 'yes' : 'no', ['class' => 'form-control', 'required']) }}
        </div>
    </div>

    <div class="text-right">
        <a href="{{ $back }}" class="btn btn-default btn-back">Back</a>
        <button type="submit" class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Submit</button>
    </div>
    {{ Form::close() }}
@endsection
