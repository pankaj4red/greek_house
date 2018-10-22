@extends ('customer')

@section ('title', 'Report Issue')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">ISSUE SOLVED</div>
        <div class="popup-body">
            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center">Are you sure you want to mark current issues as solved?</p>
                </div>
            </div>
            <div class="action-row text-center">
                <a href="{{ $back }}" class="button-back btn btn-default back-btn">No</a>
                <button type="submit" name="save" value="save" class="btn btn-primary" id="popup-ajax-button">
                    Yes
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    @if (!Request::ajax())
        {!! '</div>' !!}
    @endif
@endsection

