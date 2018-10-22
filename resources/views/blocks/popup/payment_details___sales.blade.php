@extends ('customer')

@section ('title', 'Payment Details')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">PAYMENT DETAILS</div>
        <div class="popup-body">
            <div class="row">
                <div class="col-md-12">
                    {!! $report->html() !!}
                </div>
            </div>
            <div class="action-row">
                <a class="btn btn-success submit-btn"
                   href="{{ route('report::campaign_sales', [$campaign->id]) }}">Download Order List</a>
            </div>
        </div>
    </div>
    @if (!Request::ajax())
        {!! '</div>' !!}
    @endif
@endsection
