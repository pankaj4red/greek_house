@extends ('customer')

@section ('title', 'Shipping Information')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">SHIPPING INFORMATION</div>
        <div class="popup-body">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="address_line1">Line 1<i class="required">*</i></label>
                        {{ Form::text('address_line1', $campaign->address_line1, ['class' => 'form-control', 'placeholder' => 'Line 1', 'id' => 'address_line1']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="address_line2">Line 2</label>
                        {{ Form::text('address_line2', $campaign->address_line2, ['class' => 'form-control', 'placeholder' => 'Line 2', 'id' => 'address_line2']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address_city">City<i class="required">*</i></label>
                        {{ Form::text('address_city', $campaign->address_city, ['class' => 'form-control', 'placeholder' => 'City', 'id' => 'address_city']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address_state">State<i class="required">*</i></label>
                        {{ Form::text('address_state', $campaign->address_state, ['class' => 'form-control', 'placeholder' => 'State', 'id' => 'address_state']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address_zip_code">Zip Code<i class="required">*</i></label>
                        {{ Form::text('address_zip_code', $campaign->address_zip_code, ['class' => 'form-control', 'placeholder' => 'Zip Code', 'id' => 'address_zip_code']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address_zip_code">Country<i class="required">*</i></label>
                        {{ Form::select('address_country', country_options(), $campaign->address_country, ['class' => 'form-control', 'id' => 'address_country']) }}
                    </div>
                </div>
            </div>
            <div class="action-row">
                <a href="{{ $back }}" class="button-back btn btn-default back-btn">Cancel</a>
                <button type="submit" name="save" value="save" class="btn btn-primary" id="popup-ajax-button">Save
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    @if (!Request::ajax())
        {!! '</div>' !!}
    @endif
@endsection
