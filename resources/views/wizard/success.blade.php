@extends ('customer')

@section ('title', 'Order - Success')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="container text-center success-page-feedback">
        @if (messages_exist())
            {!! messages_output() !!}
        @endif

        <div class="like-img-wrap">
            <img class="img-responsive text-img" src="{{ static_asset('images/like-icon.png') }}" alt="like-icon"/>
        </div>

        <div class="content-bottom mb-5 border">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2>Congrats You did it!</h2>
                    <h5>Your Design Has Been Submitted</h5>
                    <a href="{{ route('dashboard::index') }}" class="btn btn-lg">
                        <button type="button" name="dashboard" class="btn btn-dashboard"> Go To My Dashboard</button>
                    </a>
                    <a href="{{route('dashboard::details', [$campaign->id, 'Customer'])}}">
                        <button type="button" name="dashboard" class="btn btn-dashboard active"> Go To My Design</button>
                    </a>
                </div>
            </div>
            <div class="row col-lg-6 col-md-8 m-auto">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="col-box">
                        <a href="{{url('/').'/cm'}}">
                            <img class="img-responsve" src="{{ static_asset('images/geticon.png') }}" alt=""/>
                            <h4>Get Involved</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="col-box">
                        <a href="https://www.instagram.com/mygreekhouse/" target="_blank">
                            <img class="img-responsve" src="{{ static_asset('images/follow-icon.png') }}" alt=""/>
                            <h4>Follow Us On Instagram</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="col-box">
                        <a href="{{ route('wizard::start') }}">
                            <img class="img-responsve" src="{{ static_asset('images/place-icon.png') }}" alt=""/>
                            <h4>Place Another Design</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section ('javascript')
    @if (config('services.facebook_pixel.enabled'))
        @if (isset($userCount) && $userCount == 1)
            <script>
                fbq('track', 'New Customer - 1st Design Request Placed');
            </script>

        @endif
        @if (isset($userCount) && $userCount > 1)
            <script>
                fbq('track', 'Existing Customer - Design Request');
            </script>
        @endif

        <script> fbq('track', "Design Request Placed"); </script>
    @endif

    @if (App::environment() == 'production')
        <!-- Google Code for Successful Order Conversion Page -->
        <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 965450773;
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "ffffff";
            var google_conversion_label = "8QJCCJzIwnUQlbiuzAM";
            var google_remarketing_only = false;
            /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
            <div style="display:inline;">
                <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/965450773/?label=8QJCCJzIwnUQlbiuzAM&amp;guid=ON&amp;script=0"/>
            </div>
        </noscript>
    @endif

@append
