@extends('v2.layouts.campaign')

@section('title', 'Important Dates')

@section('content_campaign')
    <link
            href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css"
            rel="stylesheet" type='text/css'>
    {{ Form::open() }}

    <div class="row">
        <div class="form-group col-12">
            <label class="gh-label">Rush</label>
            {{ Form::select('rush', yes_no_options(), $campaign->rush ? 'yes' : 'no', ['class' => 'gh-control']) }}
        </div>
    </div>

    <div class="form-group buttons">
        <a href="{{ $back }}" class="gh-btn grey-transparent btn-close">Back</a>
        <button type="submit" class="gh-btn blue"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Submit</button>
    </div>
    {{ Form::close() }}
@endsection
