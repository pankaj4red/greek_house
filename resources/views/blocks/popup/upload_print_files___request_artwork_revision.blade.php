@extends ('customer')

@section ('title', 'Request Revision')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">REQUEST ARTWORK REVISION</div>
        <div class="popup-body">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="revision_text">Your Message</label>
                        {{ Form::textarea('fulfillment_invalid_text', $campaign->fulfillment_invalid_text, ['class' => 'form-control', 'placeholder' => '1. Please add notes/changes need in a numbered list.
2. Please try to keep your notes concise.
3. Please refrain from adding unnecessary information.', 'id' => 'validation_artwork_message']) }}
                    </div>
                </div>
            </div>
            <div class="action-row">
                <a href="{{ $back }}" class="button-back btn btn-default back-btn">Cancel</a>
                <button type="submit" name="save" value="save" class="btn btn-primary" id="popup-ajax-button">Request
                    Artwork Revision
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    @if (!Request::ajax())
        {!! '</div>' !!}
    @endif
@endsection
