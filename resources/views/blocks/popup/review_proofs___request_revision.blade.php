@extends ('customer')

@section ('title', 'Make Changes')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">MAKE CHANGES</div>
        <div class="popup-body">
            {{ Form::open(['id' => 'ajax-form']) }}
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            <div class="ajax-messages"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="revision_text">Your Message</label>
                        {{ Form::textarea('revision_text', $campaign->artwork_request->revision_text, ['class' => 'form-control', 'placeholder' => '1. Please add notes/changes need in a numbered list.
2. Please try to keep your notes concise.
3. Please refrain from adding unnecessary information.', 'id' => 'revision_text']) }}
                    </div>
                </div>
            </div>
            <div class="action-row">
                <a href="{{ $back }}" class="button-back btn btn-default back-btn">Cancel</a>
                <button type="submit" name="save" value="save" class="btn btn-primary" id="popup-ajax-button">
                    Make Changes
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    @if (!Request::ajax())
        {!! '</div>' !!}
    @endif
@endsection
