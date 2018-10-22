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
        <div class="popup-title">REPORT ISSUE</div>
        <div class="popup-body">
            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="free_tshirt_size">What is the issue?<i class="required">*</i></label>
                        {{ Form::select('reason', fulfillment_issue_reason_options(['' => 'Please select the Issue Category']), $campaign->fulfillment_invalid_reason, ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Description<i class="required">*</i></label>
                    </div>
                    {{ Form::textarea('description', $campaign->fulfillment_invalid_text, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="action-row pull-right">
                <a href="{{ $back }}" class="button-back btn btn-default back-btn">Cancel</a>
                <button type="submit" name="save" value="save" class="btn btn-primary" id="popup-ajax-button">
                    Submit Issue
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    @if (!Request::ajax())
        {!! '</div>' !!}
    @endif
@endsection

