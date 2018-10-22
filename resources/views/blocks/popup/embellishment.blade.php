@extends ('customer')

@section ('title', 'Embellishment')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">EMBELLISHMENT</div>
        <div class="popup-body">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="design_type">Print Type<i class="required">*</i></label><br/>
                        {{ Form::radio('design_type', 'screen', $campaign->artwork_request->design_type == 'screen', ['class' => '']) }}
                        <label for="rush">Screenprint</label><br/>
                        {{ Form::radio('design_type', 'embroidery', $campaign->artwork_request->design_type == 'embroidery', ['class' => '']) }}
                        <label for="rush">Embroidery</label><br/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="polybag_and_label">Polybag & Label<i class="required">*</i></label><br/>
                        {{ Form::radio('polybag_and_label', 'no', ! $campaign->polybag_and_label, ['class' => '']) }}
                        <label for="polybag_and_label">No</label><br/>
                        {{ Form::radio('polybag_and_label', 'yes', $campaign->polybag_and_label, ['class' => '']) }}
                        <label for="polybag_and_label">Yes</label><br/>
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
        $("#date").datepicker({
            inline: false
        });
    </script>
@append

@section ('ajax')
    <script>
        attachAjax('#popup-ajax-button');
    </script>
@append
