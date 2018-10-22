@extends('v2.layouts.app')

@section('title', 'Work With Us')

@section('content')
    <div class="block-container" id="work-with-us-form">
        <div class="container">
            <h1>Join our House. Get Rewards.</h1>
            <p>Greek House is a custom apparel platform that is built by Greeks, for Greeks.</p>
            {{ Form::open(['method' => 'POST', 'id' => 'work-with-us-form-element', 'url' => route('work_with_us::index', [$mode, $id])]) }}
            {{ Form::hidden('minimum_guarantee', old('minimum_guarantee', 'no'), ['id' => 'work-with-us-minimum-guarantee']) }}
            @include ('v2.partials.messages.all', ['except' => ['name', 'email', 'phone', 'school', 'chapter', 'position', 'members']])
            <div class="row justify-content-md-center">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::text('name', null, ['class' => 'form-control ' . ($errors->get('name') ?  'is-invalid' : ''), 'placeholder' => 'Your name', 'id' => 'form-full-name']) }}
                        @if ($errors->get('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::text('email', null, ['id' => 'work_with_us_email', 'class' => 'form-control ' . ($errors->get('email') ?  'is-invalid' : ''), 'placeholder' => 'Your email address']) }}
                        @if ($errors->get('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::text('phone', null, ['class' => 'form-control ' . ($errors->get('phone') ?  'is-invalid' : ''), 'placeholder' => 'Your phone number']) }}
                        @if ($errors->get('phone'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::text('school', null, ['class' => 'form-control ' . ($errors->get('school') ?  'is-invalid' : ''), 'placeholder' => 'Name of your University/College']) }}
                        @if ($errors->get('school'))
                            <div class="invalid-feedback">
                                {{ $errors->first('school') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::text('chapter', null, ['class' => 'form-control ' . ($errors->get('chapter') ?  'is-invalid' : ''), 'placeholder' => 'Name of your Fraternity or Sorority']) }}
                        @if ($errors->get('chapter'))
                            <div class="invalid-feedback">
                                {{ $errors->first('chapter') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::select('position', chapter_position_options(['' => 'Your position in your chapter']), null, ['class' => 'form-control select-placeholder ' . ($errors->get('position') ?  'is-invalid' : ''), 'data-placeholder' => '400', 'data-selected' => '500']) }}
                        @if ($errors->get('position'))
                            <div class="invalid-feedback">
                                {{ $errors->first('position') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::select('members', chapter_member_count_options(['' => '# of members in your organization']), null, ['class' => 'form-control select-placeholder ' . ($errors->get('members') ?  'is-invalid' : ''), 'data-placeholder' => '400', 'data-selected' => '500', 'id' => 'work-with-us-members']) }}
                        @if ($errors->get('members'))
                            <div class="invalid-feedback">
                                {{ $errors->first('members') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::select('are_you_ready', ['' => 'Are you ready to submit a design request?', 'no' => 'Not yet!', 'yes' => 'Yes, I’m ready for my free design.'], null, ['class' => 'form-control select-placeholder ' . ($errors->get('are_you_ready') ?  'is-invalid' : ''), 'data-placeholder' => '400', 'data-selected' => '500']) }}
                        @if ($errors->get('are_you_ready'))
                            <div class="invalid-feedback">
                                {{ $errors->first('are_you_ready') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <button type="button" class="btn btn-blue" id="submit_work_with_us">Sign Up</button>
                        {{Form::hidden('username', '', ['id' => 'username'])}}
                        {{Form::hidden('password', '', ['id' => 'password'])}}
                        {{Form::hidden('submit_form', '', ['id' => 'submit_form'])}}

                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="block-container" id="work-with-us-benefits">
        <div class="container">
            <div class="work-with-us-benefits-section">
                <h2>The Benefits</h2>
                <hr/>
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/work-with-us/same_day_design.gif') }}"/>
                        <h3>Same Day Design</h3>
                        <p>Work 1-on-1 with a professional artist. Get your free design back within 24 hours.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/work-with-us/intelligent_pricing.gif') }}"/>
                        <h3>Intelligent Pricing</h3>
                        <p>Don't know how many shirts will get ordered? No problem. Price is automatically lowered with each additional piece purchased. So, the more you buy the less you pay.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/work-with-us/free_bag_n_tag.gif') }}"/>
                        <h3>Free Bag-n-Tag</h3>
                        <p>All shirts are individually wrapped and labeled to make distribution a breeze.</p>
                    </div>
                </div>
            </div>
            <div class="work-with-us-benefits-section">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/work-with-us/philanthropy_donations.gif') }}"/>
                        <h3>Philanthropy Donations</h3>
                        <p>Greek House donates back on all philanthropy orders to help your chapter reach its fundraising goals.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/work-with-us/membership_assistant.gif') }}"/>
                        <h3>Membership Assistant</h3>
                        <p>We assign each member an assistant who can call or text anytime and receive an instant response.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/work-with-us/design_gallery.gif') }}"/>
                        <h3>Design Gallery</h3>
                        <p>Save time and headaches by choosing one of our 5,000 designs from our gallery. All are completely customizable.</p>
                    </div>
                </div>
            </div>
            <div class="work-with-us-benefits-section">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/work-with-us/easy_payment_collection.gif') }}"/>
                        <h3>Easy Payment Collection</h3>
                        <p>Use our payment collection tool to seamlessly collect sizes and payment
                            with a single link. You can also pay with chapter check, credit card or
                            a combination of all three.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/work-with-us/fast_response_time.gif') }}"/>
                        <h3>Fast Response Time</h3>
                        <p>Whether you have a question about your design, order, or shipping updates, we'll answer within a couple hours but usually within minutes.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ static_asset('images/work-with-us/flexible_shipping_options.gif') }}"/>
                        <h3>Flexible Shipping Options</h3>
                        <p>We provide free shipping, allow for both group and individual, and offer rush for those orders that just need to get there ASAP.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="work-with-us-platform">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>The Platform</h2>
                    <hr/>
                    <p>Easily control the entire order process from start to finish in one place. Get exactly what your chapter wants in less time.</p>
                    <ul>
                        <li>Live chat</li>
                        <li>Instant quotes</li>
                        <li>Real time order updates</li>
                        <li>Collaborate directly with designers</li>
                        <li>5000+ Designs that can be customized</li>
                        <li>Text updates</li>
                    </ul>
                </div>
                <div class="offset-md-1 col-md-4">
                    <img src="{{ static_asset('images/ambassador/platform-mobile.png') }}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="work-with-us-community">
        <div class="container">
            <h2>The Community</h2>
            <p class="mb-5">See what members are saying about Greek House</p>

            <div class="row">
                <div class="col-lg-4">
                    <img src="{{ static_asset('images/work-with-us/kiera.jpg') }}"/>
                    <h3>Nina Romans</h3>
                    <p>“I love that the shirts are bagged and tagged, it's always super easy to hand out. The customer service always responds super fast, and overall it's a really easy and fast
                        process.”</p>
                    <div class="work-with-us-community">
                        <p class="smaller">Delta Gamma - UF</p>
                        <small>Ambassador Since ‘14</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="{{ static_asset('images/work-with-us/shyan.jpg') }}"/>
                    <h3>Pedro Escobar</h3>
                    <p>“This is the best t-shirt company we've ever worked with, period.”</p>
                    <div class="work-with-us-community">
                        <p class="smaller">Alpha Tau Omega - UF</p>
                        <small>Ambassador Since ‘13</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="{{ static_asset('images/work-with-us/sarah.jpg') }}"/>
                    <h3>Quinn Heinrich</h3>
                    <p>“Ya'll have made it so easy for me to communicate to designers and share proofs. It has taken so much stress off of my job!”</p>
                    <div class="work-with-us-community">
                        <p class="smaller">Kappa Kappa Gamma - UT</p>
                        <small>Ambassador Since ‘15</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container" id="work-with-us-faq">
        <div class="container">
            <h2>Frequently Asked Questions</h2>
            <hr/>
            <div class="work-with-us-faq-section">
                <h3>Q: Is membership free? Yes.</h3>
                <p>Membership is and always will be free.</p>
            </div>
            <div class="work-with-us-faq-section">
                <h3>Q: What's the next step?</h3>
                <p>Click the “Become a Member” button below and join Greek House! You can schedule a short welcome
                    call where we explain membership benefits and answer all of your questions or you can place a design request if you're ready to get started.</p>
            </div>
            <a href="{{ route('work_with_us::index') }}#work-with-us-form" class="btn btn-blue slide-scroll" data-slide-scroll="#work-with-us-form" data-slide-focus="#form-full-name">Become a
                member</a>
        </div>
    </div>
    <div class="modal fade" id="modal_set_password" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalLargeTitle" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        <div class="set-password-title">
                            @include ('v2.partials.logo')
                        </div>
                        <h1> Welcome to Greek House</h1>
                        {{ Form::open(['method' => 'POST', 'id' => 'set-password-form-element', 'url' => route('check-set-password-fields')]) }}

                        <div class="signup-info">Enter a password to create your free account </div>
                        <div class="ajax-messages"></div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="login-email" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="login-password" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                            <button type="submit" class="btn btn-success" id="account_password_button">Create Account</button>
                        </div>
                        <div class="signup-info small-info">See how it works on the next page</div>

                    {{Form::close()}}
                    </div>
                </div>
               </div><!-- end of Modal Content -->
        </div>
    </div><!-- end of MODAL -->
            @endsection

@section ('javascript')
    <script>
        var bypassPrompt = false;
        $('#work-with-us-form-element').submit(function (event) {
               if (!bypassPrompt && $('#work-with-us-members').val() == 24 && $("#username").val() == '') {
                    if (event) event.preventDefault();

                    GreekHousePrompt.options({
                        title: 'ORDER MINIMUM',
                        text: 'Greek House has a 24 piece minimum on all campaigns.<br/>Can you guarantee a minimum of 24 pieces ordered on your first campaign?',
                        buttons: [
                            {
                                text: 'NO', 'class': 'btn-blue-transparent', callback: function (event) {
                                    GreekHousePrompt.close();
                                    bypassPrompt = true;
                                    $('#work-with-us-minimum-guarantee').val('no');
                                    $('#work-with-us-form-element button').click();
                                }
                            },
                            {
                                text: 'YES', 'class': 'btn-green', callback: function (event) {
                                    GreekHousePrompt.close();
                                    bypassPrompt = true;
                                    $('#work-with-us-minimum-guarantee').val('yes');
                                    //$('#work-with-us-form-element button').click();
                                    //show set password form here
                                    $("#modal_set_password").modal('show');
                                    $("#login-email").val($("#work_with_us_email").val());
                                }
                            },
                        ]
                    }).show();
                }
                else if (!bypassPrompt && $('#work-with-us-members').val() > 24 && $("#username").val() == '') {
                    //show set password popup
                    if (event) event.preventDefault();
                    $("#modal_set_password").modal('show');
                   $("#login-email").val($("#work_with_us_email").val());
                }

        });
        $("#modal_set_password").on("click", "#account_password_button", function(event){
            event.preventDefault();
            $(this).prop('disabled', true);
            $(this).append('<div class="ajax-progress ajax-progress-throbber"><i class="glyphicon glyphicon-refresh glyphicon-spin"></i></div>');
            $("#modal_set_password").find('.ajax-messages').empty();
            var url = $(this).closest('form').attr('action');
            var formData = $(this).closest('form').serialize();
            var that = this;
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    if(data.success === false){
                        var errorText = data.message;
                        var alert = $('<div class="alert alert-danger" role="alert"></div>');
                        alert.append(errorText);
                        $("#modal_set_password").find('.ajax-messages').append(alert);

                    }
                    else{
                        $("#username").val($("#login-email").val());
                        $("#password").val($("#login-password").val());
                         $("#modal_set_password").modal('hide');
                        bypassPrompt = true;
                        $("#work-with-us-form-element").submit();

                    }
                },
                 complete: function () {
                    $(that).find('.ajax-progress').remove();
                    $(that).prop('disabled', false);
                }
            });

            return false;
        });
        $("#work-with-us-form-element").on('click', '#submit_work_with_us', function(){
            validate_form();
        });
function validate_form(){
    var url = "{{route('check-work-withus-fields')}}";
    var formData = $("#work-with-us-form-element").serialize();
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        async: true,
        success: function (data) {

            if(data.success === false){
                var errorText = '';
                $(".invalid-feedback").remove();
                $('input').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
                $.each(data.errors, function(key, value){
                    $('input[name='+key+']').addClass('is-invalid');
                    $('input[name='+key+']').after('<div class="invalid-feedback">'+value+'</div>');

                    $('select[name='+key+']').addClass('is-invalid');
                    $('select[name='+key+']').after('<div class="invalid-feedback">'+value+'</div>');

                });
                var alert = $('<div class="alert alert-danger" role="alert"></div>');
                alert.append(errorText);
                $("#work-with-us-form-element").find('.ajax-messages').append(alert);
                return false;

            }
            else{
                $(".invalid-feedback").remove();
                $('input').removeClass('is-invalid');
                $('select').removeClass('is-invalid');

                $("#work-with-us-form-element").submit();

            }
        },

    });
}
    </script>
@append