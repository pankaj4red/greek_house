@extends ('customer')

@section ('title', 'Additional Information')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">ADDITIONAL INFORMATION</div>
        <div class="popup-body">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="date">Shipping Cost</label>
                        {{ Form::text('shipping_cost', $campaign->shipping_cost, ['class' => 'form-control', 'placeholder' => 'Shipping Cost', 'id' => 'shipping_cost']) }}
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
