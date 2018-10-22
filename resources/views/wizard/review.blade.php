@extends ('customer')

@section ('title', 'Wizard - Review')

@section ('content')
    <link href="{{ static_asset('css/wizard.css') . '?v=' . config('greekhouse.css_version') }}" rel="stylesheet">
    <!-- the 4 steps section -->
    @include ('partials.wizard_progress')

    <!-- end of the 4 steps section -->
    <div class="tab-content">
        <div class="tab-pane fade in show active" id="tabFive" role="tabpanel">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="product-name-big">{{ $campaignLead->name }}</h2>
                    </div>
                </div>
                <!-- end or product-name h2 ROW -->
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="apparel-options-container">
                            <p class="apparel-options-p">Selected Products</p>
                            <hr class="apparel-options-hr">
                        </div>
                    </div>
                    <div id="review_product_list" class="col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                        @foreach(campaign_lead_product_tree($campaignLead->product_colors) as $product)
                            <div class="cart_product" id="product-one-fifth-step">
                                <div class="row row-position">
                                    <div class="col-md-3 col-sm-3">
                                        @if ($product->colors->count() > 0)
                                            <img class="img img-responsive img-thumbnail" src="{{ route('system::image', [$product->colors[0]->image_id]) }}"
                                                 alt="{{ $product->name }}">
                                        @else
                                            <img class="img img-responsive img-thumbnail" src="{{ route('system::image', [$product->image_id]) }}" alt="...">
                                        @endif
                                    </div>
                                    <div class="col-md-7 col-sm-7">
                                        <h4 class="media-heading step3_product_title">{{ $product->name }}</h4>
                                    </div>
                                    <div class="col-md-2 col-sm-2 edit_options">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="colorboxes">
                                            @foreach($product->colors as $index => $color)
                                                <span id="c{{ $index }}-{{ $loop->index }}" data-slot="{{ $loop->index + 1 }}"
                                                      class="color_slot color_slot_{{ $loop->index + 1 }} color_box btn-baseColor"
                                                      style="background-image: url({{ route('system::image', [$color->thumbnail_id]) }})"
                                                      title="{{ $color->name }}">&nbsp;</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div> <!-- end of col -->
                </div> <!-- end of shirt avatar and product description ROW -->
                <div class="row">
                    <div class="container demo">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                                            <img class="double-down" src="{{ static_asset('images/wizard/double-down-arrow.png') }}">Design Description
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <div class="col-sm-12 col-md-12 col-lg-12 print-locations-accordion">
                                            <h4 class="locations-description-head-accordion general-head-style">
                                                Print Locations:
                                            </h4>
                                            <p id="review_print_locations" class="locations-description-p-accordion general-p-style">-</p>
                                        </div>
                                        @if ($campaignLead->print_front)
                                            <div id="review_print_front">
                                                <div class="col-sm-12 col-md-12 col-lg-12 description-text-accordion">
                                                    <h4 class="description-text-head-accordion general-head-style">
                                                        Front Description:
                                                    </h4>
                                                    <p class="description-text-p-accordion general-p-style">
                                                        {!! bbcode($campaignLead->print_front_description) !!}
                                                    </p>
                                                    <h4 class="number-of-colors-head-accordion general-head-style general-h4-text-centered">
                                                        Number Of Colors:
                                                    </h4>
                                                    <p id="review_print_front_nr_colors" class="number-of-colors-p-accordion general-p-style general-p-text-centered">
                                                        {{ $campaignLead->print_front_colors }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($campaignLead->print_pocket)
                                            <div id="review_print_pocket">
                                                <div class="col-sm-12 col-md-12 col-lg-12 description-text-accordion">
                                                    <h4 class="description-text-head-accordion general-head-style">
                                                        Pocket Description:
                                                    </h4>
                                                    <p class="description-text-p-accordion general-p-style">
                                                        {!! bbcode($campaignLead->print_pocket_description) !!}
                                                    </p>
                                                    <h4 class="number-of-colors-head-accordion general-head-style general-h4-text-centered">
                                                        Number Of Colors:
                                                    </h4>
                                                    <p id="review_print_pocket_nr_colors" class="number-of-colors-p-accordion general-p-style general-p-text-centered">
                                                        {{ $campaignLead->print_pocket_colors }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($campaignLead->print_back)
                                            <div id="review_print_back">
                                                <div class="col-sm-12 col-md-12 col-lg-12 description-text-accordion">
                                                    <h4 class="description-text-head-accordion general-head-style">
                                                        Back Description:
                                                    </h4>
                                                    <p class="description-text-p-accordion general-p-style">
                                                        {!! bbcode($campaignLead->print_back_description) !!}
                                                    </p>
                                                    <h4 class="number-of-colors-head-accordion general-head-style general-h4-text-centered">
                                                        Number Of Colors:
                                                    </h4>
                                                    <p id="review_print_back_nr_colors" class="number-of-colors-p-accordion general-p-style general-p-text-centered">
                                                        {{ $campaignLead->print_back_colors }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($campaignLead->print_sleeve)
                                            <div id="review_print_sleeve">
                                                <div class="col-sm-12 col-md-12 col-lg-12 description-text-accordion">
                                                    <h4 class="description-text-head-accordion general-head-style">
                                                        Sleeve Description:
                                                    </h4>
                                                    <p class="description-text-p-accordion general-p-style">
                                                        {!! bbcode($campaignLead->print_sleeve_description) !!}
                                                    </p>
                                                    <h4 class="number-of-colors-head-accordion general-head-style general-h4-text-centered">
                                                        Number Of Colors:
                                                    </h4>
                                                    <p id="review_print_sleeve_nr_colors" class="number-of-colors-p-accordion general-p-style general-p-text-centered">
                                                        {{ $campaignLead->print_sleeve_colors }}
                                                    </p>
                                                    <h4 class="number-of-colors-head-accordion general-head-style general-h4-text-centered">
                                                        Preferred Sleeve:
                                                    </h4>
                                                    <p id="review_print_sleeve_nr_colors" class="number-of-colors-p-accordion general-p-style general-p-text-centered">
                                                        {{ ucfirst($campaignLead->print_sleeve_preferred) }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-sm-12 col-md-6 col-lg-6 number-of-colors-accordion">
                                            <h4 class="number-of-colors-head-accordion general-head-style general-h4-text-centered">
                                                Total Estimated Quantity:
                                            </h4>
                                            <p id="review_total_est_qty" class="number-of-colors-p-accordion general-p-style general-p-text-centered">
                                                {{ $campaignLead->estimated_quantity }}
                                            </p>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 number-of-colors-accordion">
                                            <h4 class="number-of-colors-head-accordion general-head-style general-h4-text-centered">
                                                Print Type:
                                            </h4>
                                            <p id="review_print_type" class="number-of-colors-p-accordion general-p-style general-p-text-centered">
                                                {{ $campaignLead->design_type == 'screen' ? 'Screenprint' : 'Embroidery' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <img class="double-down" src="{{ static_asset('images/wizard/double-down-arrow.png') }}">Shipping info
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body pen-for-changes">
                                        <div class="row" id="step-five-container" style="">
                                            <div class="col-md-8 col-md-offset-2 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="First Name" readonly="readonly" name="review_first_name"
                                                                   value="{{ $campaignLead->contact_first_name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Last Name" readonly="readonly" name="review_last_name"
                                                                   value="{{ $campaignLead->contact_last_name }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Addres Line 1" readonly="readonly" name="review_address_line1"
                                                                   value="{{ $campaignLead->address_line1 }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Addres Line 2" readonly="readonly" name="review_address_line2"
                                                                   value="{{ $campaignLead->address_line2 }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="State" readonly="readonly" name="review_state"
                                                                   value="{{ $campaignLead->address_state }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="City" readonly="readonly" name="review_city" value="{{ $campaignLead->address_city }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="1611" readonly="readonly" name="review_zip" value="{{ $campaignLead->address_zip_code }}">
                                                </div>
                                            </div>
                                        </div> <!-- end of step-five-container -->
                                    </div>
                                </div>
                            </div>
                        </div><!-- panel-group -->
                        <div class="col-sm-12 col-md-12 col-lg-6 col-lg-offset-3">
                            {{ Form::open(['url' => route('wizard::review'), 'id' => 'review-form']) }}
                            {{ Form::hidden('campaign_lead_id', $campaignLead->id) }}
                            <div class="form-group col-lg-10 col-lg-offset-1">
                                {{ Form::text('promo_code', Request::has('code') ? Request::get('code') : $campaignLead->promo_code, ['placeholder' => 'Promo Code', 'autocomplete' => 'off', 'class' => 'form-control', 'id' => 'promo_code']) }}
                            </div>
                            @if (Auth::user())
                                <button type="submit" class="btn btn-success" id="step-five-btn-submit">Submit Design Request</button>
                            @else
                                <button type="button" class="btn btn-success" id="step-five-btn-submit" data-toggle="modal" data-target="#modalLogin">Submit Design Request</button>
                            @endif
                            {{ Form::close() }}
                            <p class="disclaimer-p">By clicking the button you accept the <a href="{{ route('home::tos') }}" class="terms-conditions" target="_blank">Terms &amp; Conditions</a>.</p>
                        </div>
                        <!-- Large Login modal -->
                        <div class="modal fade modal-login" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLargeTitle" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                   <!-- <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                    </div>-->
                                    <div class="modal-body">
                                        <form id="login-popup-form" method="POST" action="{{ route('login') }}">
                                            @if (messages_exist())
                                                {!! messages_output() !!}
                                            @endif
                                            <div class="login-messages"></div>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-7 col-lg-7 text-center border-right-gray">
                                                        <h5 class="modal-login-heading" id="modal-login-head">LOGIN</h5>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="login-email" name="username" placeholder="Username or Email">
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="password" class="form-control" id="login-password" name="password" placeholder="Password">
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                            <button type="submit" class="btn btn-success" id="login-popup-button">Sign In</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-5 col-lg-5 text-center">
                                                        <h3 class="modal-login-accordion-head">No Account?</h3>
                                                        <div class="signup-info">It's free and only takes a minute!</div>
                                                        <div class="col-sm-12 col-md-12 col-lg-12">

                                                            <button type="button" class="btn btn-primary btn-blue-greek-house signup-popup-button" id="modal-login-btn-next" data-toggle="modal"
                                                                    data-target="#modalSignup">Sign up
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div> <!-- row end -->
                                            </div> <!-- container fluid end -->
                                        </form>
                                    </div> <!-- end of modal-body -->
                                </div> <!-- end of Modal Content -->
                            </div> <!-- modal dialog modal mg -->
                        </div> <!-- end of ALL LARGE MODAL -->
                        <!-- Large Sign Up modal -->
                        <div class="modal fade model-signup" id="modalSignup" tabindex="-1" role="dialog" aria-labelledby="modalLargeTitle" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                  <!--  <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h5 class="modal-login-heading" id="modal-login-head">Create Your Free Account</h5>
                                        <div class="signup-info text-center">You're one step away from getting the best designs on campus!</div>
                                    </div> -->
                                    <div class="modal-body">
                                        <h5 class="modal-login-heading" id="modal-login-head">Create Your Free Account</h5>
                                        <div class="signup-info text-center">You're one step away from getting the best designs on campus!</div>

                                        <form id="register-popup-form" method="POST" action="{{ route('register') }}">
                                            @if (messages_exist())
                                                {!! messages_output() !!}
                                            @endif
                                            <div class="register-messages"></div>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <input type="name" class="form-control" name="first_name" id="first_name" placeholder="First Name">
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="name" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                                                        </div>
                                                        <div class="form-group">
                                                            {!! Form::select('graduation_year', graduation_year_options('Your graduation year'), null, ['class' => 'form-control select-placeholder']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <form class="input-accordion-login">
                                                            <div class="form-group">
                                                                <input type="phone" class="form-control" name="phone" id="phone" placeholder="Phone">
                                                            </div>

                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="school" id="school" placeholder="University/College">
                                                            </div>

                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="chapter" id="chapter" placeholder="Chapter">
                                                            </div>
                                                            <div class="form-group">
                                                                {{ Form::select('position', chapter_position_options(['' => 'Your position in your chapter']), null, ['class' => 'form-control select-placeholder']) }}
                                                            </div>
                                                            <div class="form-group">
                                                                {{ Form::select('members', chapter_member_count_options(['' => '# of members in your organization']), null, ['class' => 'form-control select-placeholder']) }}
                                                            </div>

                                                        </form>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <div class="btn-holder">
                                                            <button type="button" class="btn btn-default" id="modal-login-btn-back" data-dismiss="modal">Go Back</button>
                                                            <button type="button" class="btn btn-blue-greek-house" id="register-popup-button">Submit</button>
                                                        </div>
                                                    </div>
                                                </div> <!-- row end -->
                                            </div> <!-- container fluid end -->
                                        </form>
                                    </div> <!-- end of modal-body -->
                                </div> <!-- end of Modal Content -->
                            </div> <!-- modal dialog modal mg -->
                        </div> <!-- end of ALL SIGN UP MODAL -->
                    </div><!-- container -->
                </div> <!-- row -->
            </div> <!-- end of container -->
        </div>    <!-- end of whole tab FIVE -->
    </div><!-- end of DIV TAB PANE GENERAL CONTENT -->
@endsection

@section ('stylesheet')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"/>
@append

@section ('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{{ static_asset('js/wizard.js') . '?v=' . config('greekhouse.css_version') }}"></script>
    <script>
        $.ajaxSetup({ headers: { 'X-CSRF-Token' : $('input[name=_token]').val() } });
        $('#login-popup-button').click(function (event) {
            event.preventDefault();
            var formData = $("#login-popup-form").serialize();
            $(this).prop('disabled', true);
            $(this).append('<div class="ajax-progress ajax-progress-throbber"><i class="glyphicon glyphicon-refresh glyphicon-spin"></i></div>');
            var that = this;
            $.ajax({
                url: '{{ route('login') }}',
                type: 'POST',
                data: formData,
                success: function (data) {
                    if (data.auth) {
                        $('.login-messages').append($('<div class="alert alert-success" role="alert">Login Successful</div>'));
                        window.location.href = window.location + ($('input[name=promo_code]').val() ? ('?code=' + $('input[name=promo_code]').val()) : '');
                    } else {
                        $('.login-messages').empty();
                        $('.login-messages').append($('<div class="alert alert-danger" role="alert">Sorry, unrecognized username or password.</div>'));
                    }
                },
                error: function (data) {
                    $('.login-messages').empty();
                    $('.login-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                },
                complete: function () {
                    $(that).find('.ajax-progress').remove();
                    $(that).prop('disabled', false);
                }
            });
            return false;
        });
    </script>
    <script>
        $('#register-popup-button').click(function (event) {
            event.preventDefault();
            var formData = $("#register-popup-form").serialize();
            $(this).prop('disabled', true);
            $(this).append('<div class="ajax-progress ajax-progress-throbber"><i class="glyphicon glyphicon-refresh glyphicon-spin"></i></div>');
            var that = this;
            $.ajax({
                url: '{{ route('register') }}',
                type: 'POST',
                data: formData,
                success: function (data) {
                    if (data.auth) {
                        $('.register-messages').empty();
                        $('.register-messages').append($('<div class="alert alert-success" role="alert">Registration Successful. Redirecting...</div>'));
                        window.location.href = window.location + ($('input[name=promo_code]').val() ? ('?code=' + $('input[name=promo_code]').val()) : '');
                    } else {
                        $('.register-messages').empty();
                        $('.register-messages').append($('<div class="alert alert-danger" role="alert">' + data.error + '</div>'));
                    }
                },
                error: function (data) {
                    $('.register-messages').empty();
                    $('.register-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                },
                complete: function () {
                    $(that).find('.ajax-progress').remove();
                    $(that).prop('disabled', false);
                }
            });
            return false;
        });
    </script>
    <script>
        $('.forgot-link').click(function (event) {
            event.preventDefault();
            $('#login-form').hide();
            $('#forgot-form').show();
            return false;
        });
    </script>
@append