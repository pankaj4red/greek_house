@extends ('customer')

@section ('title', 'Customer Information')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">CUSTOMER INFORMATION</div>
        <div class="popup-body">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contact_first_name">First Name<i class="required">*</i></label>
                        {{ Form::text('contact_first_name', $campaign->contact_first_name, ['class' => 'form-control', 'placeholder' => 'First Name', 'id' => 'contact_first_name']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contact_last_name">Last Name<i class="required">*</i></label>
                        {{ Form::text('contact_last_name', $campaign->contact_last_name, ['class' => 'form-control', 'placeholder' => 'Last Name', 'id' => 'contact_last_name']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contact_school">School<i class="required">*</i></label>
                        {{ Form::text('contact_school', $campaign->contact_school, ['class' => 'form-control contact_school school', 'placeholder' => 'School', 'id' => 'contact_school']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contact_chapter">Chapter<i class="required">*</i></label>
                        {{ Form::text('contact_chapter', $campaign->contact_chapter, ['class' => 'form-control contact_chapter chapter', 'placeholder' => 'Chapter', 'id' => 'contact_chapter']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contact_phone">Phone<i class="required">*</i></label>
                        {{ Form::text('contact_phone', $campaign->contact_phone, ['class' => 'form-control', 'placeholder' => 'Phone', 'id' => 'contact_phone']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contact_email">Email<i class="required">*</i></label>
                        {{ Form::text('contact_email', $campaign->contact_email, ['class' => 'form-control', 'placeholder' => 'Email', 'id' => 'contact_email']) }}
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

@section ('include')
    @include ('partials.enable_school_chapter')
@append

@section ('ajax')
    <script>
        schoolAndChapter('.school', '.chapter');
    </script>
@append
