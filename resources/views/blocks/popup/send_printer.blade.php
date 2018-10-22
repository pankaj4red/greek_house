@extends ('customer')

@section ('title', 'Send to Printer')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="new_modal">
        <div class="popup">
            @if(!$print)
                <a class="scroll-arrow" id="scroll_down" href="#section_1" class="scroll-down" address="true">
                    <img src="{{static_asset('images/wizard/panel-arrow-down.png')}}" id="scroll_arrow">
                </a>
            @endif
            <div class="popup-title scroll_point" id="section_0">ORDER FORM</div>
            <div class="popup-body">
                <div class="campaign-header">
                    <div class="campaign-header-left">
                        <div class="campaign-header-name">{{ $campaign->name }}</div>
                        <div class="campaign-header-client">
                            Client:
                            <span class="campaign-header-client-name">
                            {{ $campaign->getContactFullName() }}
                                @if ($campaign->contact_chapter)
                                    - {{ $campaign->contact_chapter }}
                                @endif
                        </span>
                        </div>
                    </div>
                    <div class="campaign-header-right">
                    <span class="campaign-header-id">CAMPAIGN #: <span
                                class="state_{{ $campaign->state }}">{{ $campaign->id }}</span></span>
                    </div>
                </div>
                {{ Form::open(['id' => 'ajax-form']) }}
                <div class="ajax-messages"></div>
                @if (messages_exist())
                    {!! messages_output() !!}
                @endif
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="garment_arrival_date">Garment Arrival Date<i class="required">*</i></label>
                            @if ($edit)
                                {{ Form::text('garment_arrival_date', $campaign->garment_arrival_date ? $campaign->garment_arrival_date->format('m/d/Y') : '', ['class' => 'form-control date', 'id' => 'garment_arrival_date', 'placeholder' => 'MM/DD/YYYY']) }}
                            @else
                                {{ Form::text('garment_arrival_date', $campaign->garment_arrival_date ? $campaign->garment_arrival_date->format('m/d/Y') : '', ['class' => 'form-control date', 'id' => 'garment_arrival_date', 'placeholder' => 'MM/DD/YYYY', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Flexible</label><br/>
                            @if ($edit)
                                {{ Form::select('flexible', yes_no_options(),  old('flexible', $campaign->flexible), ['class' => 'form-control pull-left']) }}
                                <br/>
                            @elseif ($print)
                                {{ old('flexible', $campaign->flexible)=='no'?'No':'Yes' }}
                            @else
                                {{ Form::text('flexible', $campaign->flexible, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Due Date</label>
                            @if ($edit)
                                {{ Form::text('date', $campaign->date ? $campaign->date->format('m/d/Y') : ($defaultDueDate ?? ''), ['class' => 'form-control', 'placeholder' => 'MM/DD/YYYY', 'id' => 'due_at']) }}
                            @else
                                {{ Form::text('date', $campaign->date ? $campaign->date->format('m/d/Y') : ($defaultDueDate ?? ''), ['class' => 'form-control', 'placeholder' => 'MM/DD/YYYY', 'id' => 'due_at', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Order Printing Date<i class="required">*</i></label>
                            @if ($edit)
                                {{ Form::text('printing_date', $campaign->printing_date ? $campaign->printing_date->format('m/d/Y') : '', ['class' => 'form-control', 'placeholder' => 'MM/DD/YYYY', 'id' => 'printing_date']) }}
                            @else
                                {{ Form::text('printing_date', $campaign->printing_date ? $campaign->printing_date->format('m/d/Y') : '', ['class' => 'form-control', 'placeholder' => 'MM/DD/YYYY', 'id' => 'printing_date', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Days in Transit</label>
                            @if ($edit)
                                {{ Form::text('days_in_transit', $campaign->days_in_transit, ['class' => 'form-control', 'placeholder' => 'Days in Transit (UPS Ground)', 'id' => 'days_in_transit']) }}
                            @else
                                {{ Form::text('days_in_transit', $campaign->days_in_transit, ['class' => 'form-control', 'placeholder' => 'Days in Transit (UPS Ground)', 'id' => 'days_in_transit', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Pockets</label>
                            @if ($edit)
                                {{ Form::select('decorator_pocket', yes_no_options(), $campaign->decorator_pocket, ['class' => 'form-control pull-left']) }}
                            @else
                                {{ Form::text('decorator_pocket', $campaign->decorator_pocket, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Shipping Option</label>
                            @if ($edit)
                                {{ Form::select('shipping_option', shipping_options(), shipping_option_caption($campaign->shipping_option) , ['class' => 'form-control pull-left']) }}
                            @else
                                {{ Form::text('shipping_option', shipping_option_caption($campaign->shipping_option), ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="speciality_inks">Speciality Inks<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::select('speciality_inks', yes_no_options(), $campaign->speciality_inks , ['class' => 'form-control pull-left']) }}
                            @elseif ($print)
                                {{ $campaign->speciality_inks == 'no' ? 'No' : 'Yes' }}
                            @else
                                {{ Form::text('speciality_inks', $campaign->speciality_inks, ['class' => 'form-control', 'disabled' => 'disabled']) }}

                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="embellishment_names">Embellishment Names<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::select('embellishment_names', yes_no_options(), old('embellishment_names', $campaign->embellishment_names), ['class' => 'form-control']) }}
                            @elseif ($print)
                                {{ $campaign->embellishment_names == 'no' ? 'No' : 'Yes' }}
                            @else
                                {{ Form::text('embellishment_names',  $campaign->embellishment_names, ['class' => 'form-control', 'disabled' => 'disabled']) }}

                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="embellishment_numbers">Embellishment Numbers<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::select('embellishment_numbers', yes_no_options(), old('embellishment_numbers', $campaign->embellishment_names), ['class' => 'form-control']) }}
                            @elseif ($print)
                                {{ $campaign->embellishment_numbers == 'no' ? 'No' : 'Yes' }}
                            @else
                                {{ Form::text('embellishment_numbers',  $campaign->embellishment_numbers, ['class' => 'form-control', 'disabled' => 'disabled']) }}

                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="polybag_and_label">Polybag & Label<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::select('polybag_and_label', yes_no_options(), old('polybag_and_label', $campaign->embellishment_names), ['class' => 'form-control']) }}
                            @elseif ($print)
                                {{ $campaign->polybag_and_label == 'no' ? 'No' : 'Yes' }}
                            @else
                                {{ Form::text('polybag_and_label',  $campaign->polybag_and_label, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="design_type">Print Type<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::select('design_type', design_type_options(), old('design_type', $campaign->design_type), ['class' => 'form-control']) }}

                            @elseif ($print)
                                {{ $campaign->artwork_request->design_type == 'screen' ? 'Screenprint' : 'Embroidery' }}
                            @else
                                {{ Form::text('design_type',  $campaign->design_type, ['class' => 'form-control', 'disabled' => 'disabled']) }}

                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="design_type">Rush<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::select('rush', yes_no_options(), old('rush', $campaign->rush), ['class' => 'form-control']) }}
                                <br/>
                            @elseif ($print)
                                {{ $campaign->rush ? 'Yes' : 'No' }}
                            @else
                                {{ Form::text('rush',  $campaign->rush, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                </div>
                @if (!$print)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="design_type">Fulfillment Notes</label><br/>
                                @if ($edit)
                                    {{ Form::textarea('fulfillment_notes', $campaign->fulfillment_notes, ['class' => 'form-control']) }}
                                @else
                                    {{ Form::textarea('fulfillment_notes', $campaign->fulfillment_notes, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                                @endif

                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php $images = []; ?>
                            @if ($campaign->artwork_request->proofs->count() > 0)

                                @foreach ($campaign->artwork_request->proofs as $proofEntry)
                                    <?php /** @var \App\Models\ArtworkRequestFile $proofEntry */  $images[] = $proofEntry->file; ?>
                                @endforeach
                                @include('partials.slider_inline', [
                                    'watermark' => false,
                                    'images' => $images
                                ])
                            @else
                                <div class="no-content">
                                    No Proofs were uploaded.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row scroll_point" id="section_1">
                    <div class="col-md-12">
                        <div class="form-group">
                            @foreach (['front', 'back', 'sleeve_left', 'sleeve_right'] as $area)
                                @if ($campaign->artwork_request->{'designer_colors_' . $area . '_list'})
                                    <label for="design_type">{{ ucwords(str_replace('_', ' ', $area)) }} Colors: </label>
                                    @foreach (explode(',', $campaign->artwork_request->{'designer_colors_' . $area . '_list'}) as $color)
                                        <span class="mb-1 mr-3 text-nowrap color-square-entry">
                                        <span class="color-square" style="background-color: {{ $color }}"></span>
                                        <span class="text-sm">{{ pms_color_repository()->caption($color) }}</span>
                                     </span>
                                    @endforeach
                                    <br/>
                                @endif

                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">
                            <h4>Shipping Info</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fulfillment_shipping_name">Name<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::text('fulfillment_shipping_name', $campaign->fulfillment_shipping_name ?? $campaign->contact_first_name . ' ' . $campaign->contact_last_name, ['class' => 'form-control']) }}
                            @else
                                {{ Form::text('fulfillment_shipping_name', $campaign->fulfillment_shipping_name ?? $campaign->contact_first_name . ' ' . $campaign->contact_last_name, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fulfillment_shipping_phone">Phone<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::text('fulfillment_shipping_phone', $campaign->fulfillment_shipping_phone ?? $campaign->contact_phone, ['class' => 'form-control']) }}
                            @else
                                {{ Form::text('fulfillment_shipping_phone', $campaign->fulfillment_shipping_phone ?? $campaign->contact_phone, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fulfillment_shipping_line1">Line 1<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::text('fulfillment_shipping_line1', $campaign->fulfillment_shipping_line1 ?? $campaign->address_line1, ['class' => 'form-control']) }}
                            @else
                                {{ Form::text('fulfillment_shipping_line1', $campaign->fulfillment_shipping_line1 ?? $campaign->address_line1, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fulfillment_shipping_line2">Line 2<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::text('fulfillment_shipping_line2', $campaign->fulfillment_shipping_line2 ?? $campaign->address_line2, ['class' => 'form-control']) }}
                            @else
                                {{ Form::text('fulfillment_shipping_line2', $campaign->fulfillment_shipping_line2 ?? $campaign->address_line2, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fulfillment_shipping_city">City<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::text('fulfillment_shipping_city', $campaign->fulfillment_shipping_city ?? $campaign->address_city, ['class' => 'form-control']) }}
                            @else
                                {{ Form::text('fulfillment_shipping_city', $campaign->fulfillment_shipping_city ?? $campaign->address_city, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fulfillment_shipping_state">State<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::text('fulfillment_shipping_state', $campaign->fulfillment_shipping_state ?? $campaign->address_state, ['class' => 'form-control']) }}
                            @else
                                {{ Form::text('fulfillment_shipping_state', $campaign->fulfillment_shipping_state ?? $campaign->address_state, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fulfillment_shipping_zip_code">Zip Code<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::text('fulfillment_shipping_zip_code', $campaign->fulfillment_shipping_zip_code ?? $campaign->address_zip_code, ['class' => 'form-control']) }}
                            @else
                                {{ Form::text('fulfillment_shipping_zip_code', $campaign->fulfillment_shipping_zip_code ?? $campaign->address_zip_code, ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fulfillment_shipping_zip_code">Country<i class="required">*</i></label><br/>
                            @if ($edit)
                                {{ Form::select('fulfillment_shipping_country', country_options(), $campaign->fulfillment_shipping_country, ['class' => 'form-control']) }}
                            @else
                                {{ Form::text('fulfillment_shipping_country', country_name($campaign->fulfillment_shipping_country), ['class' => 'form-control', 'disabled' => 'disabled']) }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">
                            <h4>Sizes</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        @include ('partials.size_table', ['sizeTable' => $sizeTable, 'declareInvalid' => false, 'campaign' => $campaign, 'edit' => $edit, 'print' => $print])
                    </div>
                </div>
                <input type="hidden" name="sizes" id="sizes" value="{}"/>

                @if (!$print)
                    <div class="row action-row">
                        <div class="col-md-12">

                            @if ($edit)
                                {{ Form::select('decorator', decorator_options($campaign->artwork_request->design_type), $campaign->decorator_id, ['class' => 'form-control size-300 pull-left']) }}
                            @else
                                <label for="decorator" class="sr-only">Decorator</label>
                                <select class="form-control size-300 pull-left" name="decorator" id="decorator">
                                    <option>{{ $campaign->decorator ? $campaign->decorator->getFullName() : '' }}</option>
                                </select>
                            @endif
                            @if ($edit)
                                @if ($campaign->state == 'fulfillment_ready')
                                    <button type="submit" name="save" value="save" class="btn btn-primary pull-right btn-success"
                                            id="popup-ajax-button">Assign to Decorator
                                    </button>
                                @else
                                    <button type="submit" name="save" value="save" class="btn btn-primary pull-right"
                                            id="popup-ajax-button">Update Order Form
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('customer_block_popup', ['send_printer', $campaign->id, 'download']) }}"
                                   class="button-back btn btn-success back-btn pull-right">Download Order Form</a>
                            @endif
                            <a href="{{ $back }}" class="button-back btn btn-default back-btn pull-right">Cancel</a>

                        </div>
                    </div>
                @endif

                {{ Form::close() }}
            </div>
        </div>
    </div>
    @if (!Request::ajax())
        {!! '</div>' !!}
    @endif
@endsection

@section ('javascript')
    <script>
        $("#garment_arrival_date").datepicker({
            inline: false
        });
        $("#printing_date").datepicker({
            inline: false
        });
        $("#due_at").datepicker({
            inline: false
        });

        $(".fancybox-inner").on('click', "#scroll_down", function (event) {
            event.preventDefault();
            location.hash = '';
            var section_name = $(this).attr('href');
            var hash = section_name;

            var section_name_arr = section_name.split('_');
            var new_section_name = '#section_' + parseInt(parseInt(section_name_arr[1]) + 1);
            if ($(new_section_name).length > 0) {
                $(this).attr('href', new_section_name);
                $("#scroll_arrow").attr('src', "{{static_asset('images/wizard/panel-arrow-down.png')}}");
            }
            else {
                $(this).attr('href', "#section_0");
                $("#scroll_arrow").attr('src', "{{static_asset('images/wizard/panel-arrow-up.png')}}");
            }
            window.location.hash = hash;


        });
        $(function () {
            var nextHash = 0;
            $(".fancybox-inner").scroll(function () {
                $('.scroll_point').each(function () {
                    var top = $("#scroll_down").offset().top;//window.scrollY;

                    var distance = top - $(this).offset().top;
                    var hash = parseInt($(this).attr('id').slice(8));
                    if (distance < 40 && distance > -40 /*&& nextHash != hash*/) {
                        nextHash = hash + 1;

                        if ($("#section_" + nextHash).length > 0) {
                            $("#scroll_down").attr('href', "#section_" + nextHash);
                            $("#scroll_arrow").attr('src', "{{static_asset('images/wizard/panel-arrow-down.png')}}");
                        }
                        else {
                            $("#scroll_down").attr('href', "#section_0");
                            $("#scroll_arrow").attr('src', "{{static_asset('images/wizard/panel-arrow-up.png')}}");
                        }
                    }
                });
            });
        });
    </script>
@append

@if($print)
@section ('javascript')
    <script>
        var rowCount = $('.table-sizes tr').length;
        console.log(rowCount);
        if (rowCount <= 6) {
            $(".popup-title").css('font-size', '40px');
            $(".title h4").css('font-size', '30px');
            $(".title h4").css('margin-top', '20px');

            $(".campaign-header-name").css('font-size', '30px');
            $(".campaign-header-name").css('min-width', '500px');
            $(".campaign-header-client").css('min-width', '500px');
            $(".campaign-header-client").css('font-size', '25px');
            $(".campaign-header-client").css('margin-top', '15px');
            $(".campaign-header-id").css('font-size', '25px');
            $(".form-control").css('font-size', '25px');
            $(".form-group").css('font-size', '25px');
            $(".form-control").css('height', '75px');
            $("label").css('font-size', '25px');
            $("label").css('width', '100%');
            $(".table-sizes > tbody > tr >td").css('height', '75px');
            $(".table-sizes > thead > tr >th").css('height', '75px');
            $(".table-sizes > tbody > tr >td").css('font-size', '25px');
            $(".table-sizes > thead > tr >th").css('font-size', '25px');

        }

        else if (rowCount <= 10) {
            $(".popup-title").css('font-size', '35px');
            $(".title h4").css('font-size', '26px');
            $(".title h4").css('margin-top', '10px');

            $(".campaign-header-name").css('font-size', '26px');
            $(".campaign-header-name").css('min-width', '500px');
            $(".campaign-header-client").css('min-width', '500px');

            $(".campaign-header-client").css('font-size', '22px');
            $(".campaign-header-client").css('margin-top', '10px');
            $(".campaign-header-id").css('font-size', '22px');
            $(".form-control").css('font-size', '22px');
            $(".form-group").css('font-size', '22px');
            $(".form-control").css('height', '65px');
            $("label").css('font-size', '22px');
            $("label").css('width', '100%');
            $(".table-sizes > tbody > tr >td").css('height', '65px');
            $(".table-sizes > thead > tr >th").css('height', '65px');
            $(".table-sizes > tbody > tr >td").css('font-size', '22px');
            $(".table-sizes > thead > tr >th").css('font-size', '22px');

        }
    </script>
@append
@endif
