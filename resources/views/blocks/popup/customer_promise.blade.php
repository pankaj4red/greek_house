@extends ('customer')

@section ('title', 'Customer Promise')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">CUSTOMER PROMISE</div>
        <div class="popup-body">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="rush">Rush<i class="required">*</i></label><br/>
                        {{ Form::radio('rush', 'no', ! $campaign->rush, ['class' => '']) }} <label
                                for="rush">No</label><br/>
                        {{ Form::radio('rush', 'yes', $campaign->rush, ['class' => '']) }} <label
                                for="rush">Yes</label><br/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="date">Delivery Due Date</label>
                        {{ Form::text('date', $campaign->date ? $campaign->date->format('m/d/Y') : '', ['class' => 'form-control', 'placeholder' => 'Date', 'id' => 'date_promise']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="flexible">Flexibility<i class="required">*</i></label><br/>
                        {{ Form::radio('flexible', 'no', $campaign->flexible == 'no', ['class' => '']) }} <label
                                for="flexible">I must have delivered by this date</label><br/>
                        {{ Form::radio('flexible', 'yes', $campaign->flexible == 'yes', ['class' => '']) }} <label
                                for="flexible">Ship date is flexible within timeframe</label><br/>
                    </div>
                </div>
            </div>
            <div class="action-row">
                <a href="{{ $back }}" class="button-back btn btn-default back-btn">Cancel</a>
                <button type="submit" name="save" value="save" class="btn btn-primary" id="popup-ajax-button">
                    Save
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
        $("#date_promise").datepicker({
            inline: false
        });
    </script>
@append
