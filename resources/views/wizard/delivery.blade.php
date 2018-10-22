@extends ('customer')

@section ('title', 'Wizard - Delivery')

@section ('content')
    <link href="{{ static_asset('css/wizard.css') . '?v=' . config('greekhouse.css_version') }}" rel="stylesheet">
    <!-- the 4 steps section -->
    @include ('partials.wizard_progress')

    <!-- end of the 4 steps section -->
    {{ Form::open(['url' => route('wizard::delivery')]) }}
    <div class="tab-content">
        <div class="tab-pane in show active" id="tabFour" role="tabpanel">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 tab-four-b">
                        <div class="row" id="" style="">
                            <div class="col-md-8 col-md-offset-2 col-sm- ">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Address1">Address Options</label>
                                            {{ Form::select('address_option', address_options(Auth::user() ? Auth::user()->addresses : [], ['save' => 'New Address (Save)', 'dontsave' => 'New Address (Don\'t Save)']), $campaignLead->address_option, ['autocomplete' => 'off', 'class' => 'form-control', 'id' => 'address']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Address2">Address Name</label>
                                            {{ Form::text('address_name', $campaignLead->address_name, ['placeholder' => 'Address name', 'autocomplete' => 'off', 'class' => 'form-control  address-field', 'id' => 'address_name']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Address1">First Name</label>
                                            {{ Form::text('address_first_name', $campaignLead->contact_first_name, ['placeholder' => 'First name', 'autocomplete' => 'off', 'class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Address2">Last Name</label>
                                            {{ Form::text('address_last_name', $campaignLead->contact_last_name, ['placeholder' => 'Last name', 'autocomplete' => 'off', 'class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Address1">Address line 1</label>
                                            {{ Form::text('address_line1', $campaignLead->address_line1, ['placeholder' => 'Address', 'autocomplete' => 'off', 'class' => 'form-control  address-field', 'id' => 'route']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Address2">Address line 2</label>
                                            {{ Form::text('address_line2', $campaignLead->address_line2, ['placeholder' => 'Address', 'autocomplete' => 'off', 'class' => 'form-control  address-field', 'id' => 'street_number']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="City">City</label>
                                            {{ Form::text('address_city', $campaignLead->address_city, ['placeholder' => 'City', 'autocomplete' => 'off', 'class' => 'form-control  address-field', 'id' => 'locality']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="State">State</label>
                                            {{ Form::text('address_state', $campaignLead->address_state, ['placeholder' => 'State', 'autocomplete' => 'off', 'class' => 'form-control  address-field', 'id' => 'administrative_area_level_1']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Zip">Zip Code</label>
                                            {{ Form::text('address_zip_code', $campaignLead->address_zip_code, ['placeholder' => 'Zip Code', 'autocomplete' => 'off', 'class' => 'form-control  address-field', 'id' => 'postal_code']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- colsm12 md12 lg12 step four b -->
                    <div class="col-sm-12 col-md-12 col-lg-12 tab-four-a">
                        <div class="row" id="step4a_container">
                            <div class="col-md-6 col-md-offset-3 col-sm-12">
                                <div class="form-group">
                                    <label>Tell us when you need your order</label>
                                    {{ Form::select('flexible', flexible_options(), $campaignLead->flexible, ['class' => 'form-control', 'id' => 'order-delivery']) }}
                                </div>
                                <p class="subtext_small">Greek House delivers your order within 10 business days after sizes and payment have been submitted. Need your order rushed <span
                                            class="round_tooltip glyphicon glyphicon-question-sign" data-toggle="popover" data-trigger="click"
                                            data-content="Rush Orders are available as soon as 6 Business Days after sizes and payment have been collected. Rush Shipping fees will apply."></span></p>
                                <div id="needed_date" style="{{ old('flexible', $campaignLead->flexible) == 'no' ? '' : 'display: none;' }}">
                                    <br>
                                    <label for="">When would you ideally need this order delivered? (*)
                                        <small></small>
                                    </label>
                                    {{ Form::text('date', $campaignLead->date ? \Carbon\Carbon::parse($campaignLead->date)->format('m/d/Y') : null, ['class' => 'datepicker-here form-control', 'placeholder' => 'Select date', 'autocomplete' => 'off', 'id' => 'delivery-date']) }}
                                </div>

                                <div id="weekday_required" style="display: none">
                                    <div class="form-group">
                                        <label class="normal_font_weight"></label>
                                        <br>
                                        <p class=" font14 mb10 text-danger">Deliveries should be on weekdays</p>
                                    </div>
                                </div>
                                <div id="minimum_time" style="{{ old('flexible', $campaignLead->flexible) == 'no' && \Carbon\Carbon::parse(old('date', $campaignLead->date) ?? 'today')->format('Y-m-d') < \Carbon\Carbon::parse('+12 weekdays')->format('Y-m-d') ? '' : 'display: none' }}">
                                    <div class="form-group">
                                        <label class="normal_font_weight"></label>
                                        <br>
                                        <p class=" font14 mb10 text-danger">Oh no :(, we don’t think it’s feasible to get a design back to you and have it be turned around and meet the Rush Shipping deadline. Choose up more than 12 business days ahead of today’s date.</p>
                                    </div>
                                </div>
                                <div id="extra_fee" style="{{ old('flexible', $campaignLead->flexible) == 'no' && (
                                \Carbon\Carbon::parse(old('date', $campaignLead->date) ?? 'today')->format('Y-m-d') >= \Carbon\Carbon::parse('+12 weekdays')->format('Y-m-d') &&
                                \Carbon\Carbon::parse(old('date', $campaignLead->date) ?? 'today')->format('Y-m-d') < \Carbon\Carbon::parse('+15 weekdays')->format('Y-m-d'))
                                 ? '' : 'display: none' }}">
                                    <div class="form-group">
                                        <label class="normal_font_weight"></label>
                                        <br>
                                        <p class="subtext font14 mb10">It takes some time to finalize the design, collect the sizes and payment which could cause the Order to be Rushed. Do you accept
                                            Rush Shipping fees if they apply?</p>
                                        {!! Form::select('rush', rush_options(), $campaignLead->rush ? 'yes' : 'no', ['class' => 'form-control', 'id' => 'rush']) !!}
                                    </div>
                                </div>
                                <br>
                                <div id="toStep5container" class="text-center">
                                    <button type="submit" id="toStep5" class="btn text-center btn-primary btn-blue-greek-house">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- row end -->
            </div>    <!-- container end -->
        </div> <!-- id tab four -->
    </div><!-- end of DIV TAB PANE GENERAL CONTENT -->
    {{ Form::close() }}
@endsection

@section ('stylesheet')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"/>
@append

@section ('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{{ static_asset('js/wizard.js') . '?v=' . config('greekhouse.css_version') }}"></script>
    <script>
        var addressList = JSON.parse("{!! slashes(json_encode(Auth::user() ? Auth::user()->addresses : [])) !!}");
        $('#address').change(function () {
            refreshAddresses(true)
        });
        refreshAddresses(false);
        function refreshAddresses(empty) {
            if ($('#address').val() != 'save' && $('#address').val() != 'dontsave') {
                $('.address-field').each(function () {
                    $(this).prop('readonly', true);
                    var address = {};
                    for (var i = 0; i < addressList.length; i++) {
                        if (addressList[i].id === parseInt($('#address').val())) {
                            $('#address_name').val(addressList[i].name);
                            $('#route').val(addressList[i].line1);
                            $('#street_number').val(addressList[i].line2);
                            $('#locality').val(addressList[i].city);
                            $('#administrative_area_level_1').val(addressList[i].state);
                            $('#postal_code').val(addressList[i].zip_code);
                        }
                    }
                    $('#save-address').hide();
                });
            } else {
                $('.address-field').each(function () {
                    $(this).prop('readonly', false);
                });
                if (empty) {
                    $('#address_name').val('');
                    $('#street_number').val('');
                    $('#route').val('');
                    $('#locality').val('');
                    $('#administrative_area_level_1').val('');
                    $('#postal_code').val('');
                }
                $('#save-address').show();
            }
        }
    </script>

@append