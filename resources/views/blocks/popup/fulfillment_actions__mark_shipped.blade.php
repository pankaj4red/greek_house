@extends ('customer')

@section ('title', 'Shipping Details')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">SHIPPING DETAILS</div>
        <div class="popup-body">
            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tracking_code">Tracking Code</label>
                        {{ Form::text('tracking_code', $campaign->tracking_code, ['class' => 'form-control', 'placeholder' => 'Tracking Code', 'id' => 'tracking_code']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="scheduled_date">Estimated Delivery Date</label>
                        {{ Form::text('scheduled_date', $campaign->scheduled_date ? $campaign->scheduled_date->format('m/d/Y') : '', ['class' => 'form-control', 'placeholder' => 'Scheduled Date', 'id' => 'date']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="invoice_total">Invoice Total</label>
                        {{ Form::text('invoice_total', $campaign->invoice_total, ['class' => 'form-control', 'placeholder' => 'Invoice Total', 'id' => 'invoice_total']) }}
                    </div>
                </div>
            </div>
            <div class="action-row">
                <a href="{{ $back }}" class="button-back btn btn-default back-btn">Cancel</a>
                <button type="submit" name="save" value="save" class="btn btn-primary"
                        id="popup-ajax-button">Save
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    @if (!Request::ajax())
        {!! '</div>' !!}
    @endif
@endsection

@section ('javascript')
    <script>
        $("#date").datepicker({
            inline: false
        });
    </script>
@append


