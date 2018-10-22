@extends('v2.layouts.campaign')

@section('title', 'Payment details')

@section('content_campaign')
    <div class="view-orders">
        {!! $report->html() !!}
    </div>
    <div class="form-group buttons">
        <a href="{{ $back }}" class="gh-btn grey-transparent btn-close">Back</a>
        <a href="{{ route('report::campaign_sales', [$campaign->id]) }}" class="gh-btn blue">Download Order List</a>
    </div>
@endsection
