@extends('v3.layouts.campaign')

@section('title', 'Payment details')

@section('content_campaign')
    <div class="view-orders">
        {!! $report->html() !!}
    </div>
    <div class="text-right">
        <a href="{{ $back }}" class="btn btn-default btn-back">Back</a>
        <a href="{{ route('report::campaign_sales', [$campaign->id]) }}" class="btn btn-info">Download Order List</a>
    </div>
@endsection
