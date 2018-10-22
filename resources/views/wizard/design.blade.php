@extends ('customer')

@section ('title', 'Wizard - Describe your design')

@section ('content')
    <link href="{{ static_asset('css/wizard.css') . '?v=' . config('greekhouse.css_version') }}" rel="stylesheet">
    <!-- the 4 steps section -->
    @include ('partials.wizard_progress')

    <!-- end of the 4 steps section -->
    {{ Form::open(['url' => route('wizard::design')]) }}
    <div class="tab-content">
        <div class="tab-pane active" id="tabTwo" role="tabpanel">
            <div class="container tabTwo-custom-container">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-5">
                        <img class="tab2-img-display img-fluid img-responsive" src="{{ route('system::image', [$campaignLead->product_colors->first()->image_id]) }}">
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-7" id="campaign-section">
                        <div class="form-group">
                            <label class="campaign-name-txt" for="campaign-name">Name Your Campaign:</label>
                            {{ Form::text('name', $campaignLead->name, ['class' => 'form-control', 'id' => 'campaign-name', 'autocomplete' => 'off']) }}
                        </div>
                        <div class="print-locations">
                            <h4 class="print-location-head">Select Print Locations:</h4>
                            <div class="checkbox-container">
                                <div class="btn-group btn-group" data-toggle="buttons">
                                    <label class="btn {{ ((Session::has('_old_input') && old('print_front')) || (! Session::has('_old_input') && $campaignLead->print_front)) ? 'active' : '' }}">
                                        <input type="checkbox" class="print-location-checkbox" id="print_location_front" name='print_front'
                                               autocomplete="off" {{ ((Session::has('_old_input') && old('print_front')) || (! Session::has('_old_input') && $campaignLead->print_front)) ? 'checked' : '' }}><i
                                                class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> Front</span>
                                    </label>
                                    <label class="btn {{ ((Session::has('_old_input') && old('print_pocket')) || (! Session::has('_old_input') && $campaignLead->print_pocket)) ? 'active' : '' }}">
                                        <input type="checkbox" class="print-location-checkbox" id="print_location_pocket" name='print_pocket'
                                               autocomplete="off" {{ ((Session::has('_old_input') && old('print_pocket')) || (! Session::has('_old_input') && $campaignLead->print_pocket)) ? 'checked' : '' }}><i
                                                class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> Pocket</span>
                                    </label>
                                    <label class="btn {{ ((Session::has('_old_input') && old('print_back')) || (! Session::has('_old_input') && $campaignLead->print_back)) ? 'active' : '' }}">
                                        <input type="checkbox" class="print-location-checkbox" id="print_location_back" name='print_back'
                                               autocomplete="off" {{ ((Session::has('_old_input') && old('print_back')) || (! Session::has('_old_input') && $campaignLead->print_back)) ? 'checked' : '' }}><i
                                                class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> Back</span>
                                    </label>
                                    <label class="btn {{ ((Session::has('_old_input') && old('print_sleeve')) || (! Session::has('_old_input') && $campaignLead->print_sleeve)) ? 'active' : '' }}">
                                        <input type="checkbox" class="print-location-checkbox" id="print_location_sleeve" name='print_sleeve'
                                               autocomplete="off" {{ ((Session::has('_old_input') && old('print_sleeve')) || (! Session::has('_old_input') && $campaignLead->print_sleeve)) ? 'checked' : '' }}><i
                                                class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> Sleeve</span>
                                    </label>
                                </div>
                            </div> <!-- end of checkbox container -->
                            <p class="print-locations-description">Please include as much information as possible to help our designers get your design right the first time!</p>
                        </div> <!-- end print-locations -->
                        <div class="call-to-action-checkbox-click">
                            <div class="panel panel-default print_location_boxes" id="location_front"
                                 style="{{ ((Session::has('_old_input') && old('print_front')) || (! Session::has('_old_input') && $campaignLead->print_front)) ? '' : 'display: none;' }}">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <h4 class="panel-body-head">
                                                Describe what you would like designed on the front of the shirt.
                                            </h4>
                                            {{ Form::textarea('print_front_description', $campaignLead->print_front_description, ['class' => 'form-control form-text-tabtwo location-back-description', 'rows' => 5, 'cols' => 30, 'placeholder' => '1. Please add notes/changes you need in a numbered list.
2. Please try to keep your notes concise.
3. Please make sure to write the exact text you want on the shirt (event name, date, venue, letters, school, chapter, sponsors, etc...).', 'id' => 'print_front_desc', 'autocomplete' => 'off']) }}
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <p class="panel-body-description">No. of Colors</p>
                                            {{ Form::select('print_front_colors', color_options('front', [], false), $campaignLead->print_front_colors, ['class' => 'form-control form-number-counter', 'id' => 'print_front_nr_colors']) }}
                                        </div>
                                    </div>
                                </div> <!-- end of panel-body -->
                            </div> <!-- end of #LOCATION_FRONT -->
                        </div>
                        <div class="panel panel-default print_location_boxes" id="location_pocket"
                             style="{{ ((Session::has('_old_input') && old('print_pocket')) || (! Session::has('_old_input') && $campaignLead->print_pocket)) ? '' : 'display: none;' }}">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <h4 class="panel-body-head">
                                            Describe what you would like designed on the pocket of the shirt.
                                        </h4>
                                        {{ Form::textarea('print_pocket_description', $campaignLead->print_pocket_description, ['class' => 'form-control form-text-tabtwo location-back-description', 'rows' => 5, 'cols' => 30, 'placeholder' => '1. Please add notes/changes you need in a numbered list.
2. Please try to keep your notes concise.
3. Please make sure to write the exact text you want on the shirt (event name, date, venue, letters, school, chapter, sponsors, etc...).', 'id' => 'print_pocket_desc', 'autocomplete' => 'off']) }}
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <p class="panel-body-description">No. of Colors</p>
                                        {{ Form::select('print_pocket_colors', color_options('pocket', [], false), $campaignLead->print_pocket_colors, ['class' => 'form-control form-number-counter', 'id' => 'print_pocket_nr_colors']) }}
                                    </div>
                                </div> <!-- end of row -->
                            </div> <!-- end of panel-body -->
                        </div> <!-- end of #LOCATION_POCKET -->
                        <div class="panel panel-default print_location_boxes" id="location_back"
                             style="{{ ((Session::has('_old_input') && old('print_back')) || (! Session::has('_old_input') && $campaignLead->print_back)) ? '' : 'display: none;' }}">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <h4 class="panel-body-head">
                                            Describe what you would like designed on the back of the shirt.
                                        </h4>
                                        {{ Form::textarea('print_back_description', $campaignLead->print_back_description, ['class' => 'form-control form-text-tabtwo location-back-description', 'rows' => 5, 'cols' => 30, 'placeholder' => '1. Please add notes/changes you need in a numbered list.
2. Please try to keep your notes concise.
3. Please make sure to write the exact text you want on the shirt (event name, date, venue, letters, school, chapter, sponsors, etc...).', 'id' => 'print_back_desc', 'autocomplete' => 'off']) }}
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <p class="panel-body-description">No. of Colors</p>
                                        {{ Form::select('print_back_colors', color_options('back', [], false), $campaignLead->print_back_colors, ['class' => 'form-control form-number-counter', 'id' => 'print_back_nr_colors']) }}
                                    </div>


                                </div> <!-- end of row -->
                            </div> <!-- end of panel-body -->
                        </div> <!-- end of #LOCATION_BACK -->
                        <div class="panel panel-default print_location_boxes" id="location_sleeve"
                             style="{{ ((Session::has('_old_input') && old('print_sleeve')) || (! Session::has('_old_input') && $campaignLead->print_sleeve)) ? '' : 'display: none;' }}">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <h4 class="panel-body-head">
                                            Describe what you would like designed on the sleeve of the shirt.
                                        </h4>
                                        {{ Form::textarea('print_sleeve_description', $campaignLead->print_sleeve_description, ['class' => 'form-control form-text-tabtwo location-back-description', 'rows' => 5, 'cols' => 30, 'placeholder' => '1. Please add notes/changes you need in a numbered list.
2. Please try to keep your notes concise.
3. Please make sure to write the exact text you want on the shirt (event name, date, venue, letters, school, chapter, sponsors, etc...).', 'id' => 'print_sleeve_desc', 'autocomplete' => 'off']) }}
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <p class="panel-body-description">No. of Colors</p>
                                        {{ Form::select('print_sleeve_colors', color_options('sleeve', [], false), $campaignLead->print_sleeve_colors, ['class' => 'form-control form-number-counter', 'id' => 'print_sleeve_nr_colors']) }}
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <p class="panel-body-description">Preferred Sleeve</p>
                                        {{ Form::select('print_sleeve_preferred', sleeve_options(), $campaignLead->print_sleeve_preferred, ['class' => 'form-control form-number-counter', 'id' => 'print_sleeve_preferred']) }}
                                    </div>
                                </div> <!-- end of row -->
                            </div> <!-- end of panel-body -->
                        </div> <!-- end of #LOCATION_SLEEVE -->
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="file-list half-margin-top">
                                    @include ('partials.file_picker', [
                                        'fieldName' => 'design1',
                                        'fieldType' => 'image',
                                        'fieldData' => isset($designs[0]) ? $designs[0] : null
                                    ])
                                    @include ('partials.file_picker', [
                                        'fieldName' => 'design2',
                                        'fieldType' => 'image',
                                        'fieldData' => isset($designs[1]) ? $designs[1] : null
                                    ])
                                    @include ('partials.file_picker', [
                                        'fieldName' => 'design3',
                                        'fieldType' => 'image',
                                        'fieldData' => isset($designs[2]) ? $designs[2] : null
                                    ])
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary btn-blue-greek-house" id="toStep3" value="Next">
                        </div>
                    </div> <!-- end of call to action checkbox -->
                </div> <!-- end of col-sm-12 col-md-6 col-lg-7 -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of TAB TWO -->
    </div><!-- end of DIV TAB PANE GENERAL CONTENT -->
    {{ Form::close() }}
@endsection

@section ('stylesheet')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"/>
@append

@section ('include')
    @include ('partials.enable_filepicker')
@append

@section ('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{{ static_asset('js/wizard.js') . '?v=' . config('greekhouse.css_version') }}"></script>
@append