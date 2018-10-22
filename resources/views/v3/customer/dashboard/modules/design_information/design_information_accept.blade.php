@extends('v3.layouts.campaign')

@section('title', 'Approve Design')

@section('content_campaign')
    {{ Form::open(['id' => 'approve-design-form']) }}
    <input type="hidden" name="message_type" id="message-type" value="close_date"/>

    <div id="accept-design-step-1">
        @component('v3.partials.slider.proof_slider', ['campaign' => $campaign])
        @endcomponent

        <div class="card mb-3">
            <div class="card-header">
                Design Details
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        @foreach (['front', 'back', 'sleeve_left', 'sleeve_right'] as $position)
                            @if ($campaign->artwork_request->{'designer_colors_' . $position . '_list'})
                                <tr>
                                    <th class="text-nowrap color-slate text-uppercase font-weight-normal text-reg">{{ ucwords(str_replace('_', ' ', $position)) }} Colors</th>
                                    <td>
                                        @foreach (explode(',', $campaign->artwork_request->{'designer_colors_' . $position . '_list'}) as $color)
                                            <span class="mb-3 mr-3">
                                                <span class="color-square" style="background: {{ trim($color) }};"></span>
                                                <span>{{ pms_color_repository()->caption(trim($color)) }}</span>
                                            </span>
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        @if ($campaign->artwork_request->{'designer_dimensions_front'} || $campaign->artwork_request->{'designer_dimensions_back'} || $campaign->artwork_request->{'designer_dimensions_sleeve_left'} || $campaign->artwork_request->{'designer_dimensions_sleeve_right'})
                            <tr>
                                <th class="text-nowrap color-slate text-uppercase font-weight-normal text-reg">Dimensions</th>
                                <td>
                                    @foreach (['front', 'back', 'sleeve_left', 'sleeve_right'] as $position)
                                        @if ($campaign->artwork_request->{'designer_dimensions_' . $position})
                                            <span class="mr-3 text-nowrap mb-3">{{ ucwords(str_replace('_', ' ', $position)) }}
                                                : {{ $campaign->artwork_request->{'designer_dimensions_' . $position} }}</span>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="text-right">
                    <a href="{{ $back }}" class="btn btn-default btn-back">Back</a>
                    <button type="button" class="btn btn-info btn-next"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Next</button>
                </div>
            </div>
        </div>
    </div>

    <div id="accept-design-step-2" style="display: none">
        <div class="card mb-3">
            <div class="card-header">
                Payment Details
            </div>
            <div class="card-body">
                <div class="ajax-messages"></div>
                <div class="form-group">
                    <label>How do you want to collect sizes and payment?</label>
                    <div class="custom-control custom-radio">
                        {{ Form::radio('payment_type', 'Check', $campaign->payment_type == 'Check', ['class' => 'custom-control-input', 'id' => 'payment-type-check']) }}
                        <label class="custom-control-label" for="payment-type-check"><strong>Pay with Check</strong> - Submit Sizes on Message Board</label>
                    </div>
                    <div class="custom-control custom-radio">
                        {{ Form::radio('payment_type', 'Individual', $campaign->payment_type == 'Individual', ['class' => 'custom-control-input', 'id' => 'payment-type-individual']) }}
                        <label class="custom-control-label" for="payment-type-individual"><strong>Share Payment Link</strong> - Everyone Submits Sizes and Pays on Their Own</label>
                    </div>
                    <div class="custom-control custom-radio">
                        {{ Form::radio('payment_type', 'Group', $campaign->payment_type == 'Group' || ! $campaign->payment_type, ['class' => 'custom-control-input', 'id' => 'payment-type-group']) }}
                        <label class="custom-control-label" for="payment-type-group"><strong>Chapter Credit Card</strong> - Submit Sizes on Message Board or Through Payment Link</label>
                    </div>
                </div>
                <div class="form-group required" id="close-date-div" style="position: relative">
                    <label>When do you think you’ll have the sizes collected?</label>
                    {{ Form::text('collection_date', null, ['class' => 'form-control datepicker-custom', 'id' => 'close-date', 'placeholder' => 'Date']) }}
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-default btn-previous">Back</button>
                    <button type="button" class="btn btn-info btn-next"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Next</button>
                </div>
            </div>
        </div>
    </div>

    <div id="accept-design-step-3" style="display: none">
        <div class="card mb-3">
            <div class="card-header">
                Delivery Details
            </div>
            <div class="card-body">
                <p class="text-center approve-message"></p>
                <div class="text-center">
                    <button type="button" class="btn btn-info btn-next">I Need My Order Sooner</button>
                    <button type="submit" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div id="accept-design-step-4" style="display: none">
        <div class="card mb-3">
            <div class="card-header">
                Payment Details
            </div>
            <div class="card-body">
                <div class="ajax-messages"></div>
                <div class="form-group required" id="delivery-date-div" style="position: relative">
                    <label>When do you need these delivered by?</label>
                    {{ Form::text('delivery_date', null, ['class' => 'form-control datepicker-custom', 'id' => 'delivery-date', 'placeholder' => 'Date']) }}
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-info btn-next"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Next</button>
                </div>
            </div>
        </div>
    </div>

    <div id="accept-design-step-5" style="display: none">
        <div class="card mb-3">
            <div class="card-header">
                Delivery Details
            </div>
            <div class="card-body">
                <p class="text-center approve-message"></p>
                <div class="text-center">
                    <button type="button" class="btn btn-info btn-previous">No, I need to pick a new Delivery Date</button>
                    <button type="button" class="btn btn-primary btn-next">Yes!</button>
                </div>
            </div>
        </div>
    </div>

    <div id="accept-design-step-6" style="display: none">
        <div class="card mb-3">
            <div class="card-header">
                Delivery Details
            </div>
            <div class="card-body">
                <p class="text-center">Thanks for letting us know when you need your order by. We’ll reach out to make sure you get your order in on time! If you need it even sooner, please
                    email us at support@greekhouse.org with subject line: URGENT DELIVERY</p>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Ok</button>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section('javascript')
    <script>
        GreekHouseDatepicker.init();

        function getMessage(event, callback) {
            event.preventDefault();
            var form = $('#approve-design-form');
            var formData = form.serialize();
            form.find('.ajax-messages').each(function () {
                $(this).empty();
            });
            $.ajax({
                url: '{{ route('customer_module_popup', ['design_information', $campaign->id, 'delivery_message']) }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        $('.approve-message').each(function () {
                            $(this).text(data.message);
                        });
                        callback();
                    } else {
                        var alert = $('<div class="alert alert-danger" role="alert"></div>');
                        alert.text(data.message);
                        form.find('.ajax-messages').each(function () {
                            $(this).append(alert);
                        });
                    }
                },
                error: function (data) {
                    form.find('.ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                }
            });
            return false;
        }

        $('#accept-design-step-1 .btn-next').click(function (event) {
            event.preventDefault();
            $('#accept-design-step-1').slideUp();
            $('#accept-design-step-2').slideDown();

            return false;
        });

        $('#accept-design-step-2 .btn-next').click(function (event) {
            event.preventDefault();
            getMessage(event, function () {
                $('#accept-design-step-3').slideDown();
                $('#accept-design-step-2').slideUp();
            });
        });

        $('#accept-design-step-2 .btn-previous').click(function (event) {
            event.preventDefault();
            $('#accept-design-step-1').slideDown();
            $('#accept-design-step-2').slideUp();

            return false;
        });

        $('#accept-design-step-3 .btn-next').click(function (event) {
            event.preventDefault();
            $('#message-type').val('delivery_date');
            $('#accept-design-step-4').slideDown();
            $('#accept-design-step-3').slideUp();

            return false;
        });

        $('#accept-design-step-4 .btn-next').click(function (event) {
            event.preventDefault();
            getMessage(event, function () {
                $('#accept-design-step-5').slideDown();
                $('#accept-design-step-4').slideUp();
            });

            return false;
        });

        $('#accept-design-step-5 .btn-previous').click(function (event) {
            event.preventDefault();
            $('#accept-design-step-4').slideDown();
            $('#accept-design-step-5').slideUp();

            return false;
        });

        $('#accept-design-step-5 .btn-next').click(function (event) {
            event.preventDefault();
            $('#accept-design-step-6').slideDown();
            $('#accept-design-step-5').slideUp();

            return false;
        });

        $("#close-date").datepicker({
            inline: false,
            minDate: new Date(),
        });

        $("#delivery-date").datepicker({
            inline: false,
            minDate: window.addWorkDays(new Date(), 7),
            beforeShowDay: $.datepicker.noWeekends
        });
    </script>
@append
