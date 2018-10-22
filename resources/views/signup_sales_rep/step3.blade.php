@extends ('customer')

@section ('title', 'Member Sign Up')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('hide_top_bar')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (config('services.facebook_pixel.enabled'))
        <script>
            fbq('track', 'CompleteRegistration');
        </script>
    @endif
    <div class="page-header cancel-header-margin">
        <div class="container">
            <span class="pull-left page-title">Member Sign Up - Success!</span>
        </div>
    </div>
    <div class="container more-margin-bottom">
        @include ('partials.progress')
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        <div class="row">
            <div class="confirmation-box">
                <img src="{{ static_asset('images/thumbs-up-icon.png') }}" alt="image">
                <h1><span>Congrats</span> You Did it!</h1>
                <p>You are now a Greek House Member.</p>
                <div class="row margin-bottom">
                    <div class="col-xs-12 text-center">
                        <a href="{{ route('wizard::start') }}" class="btn btn-lg btn-success">Start a Design Request</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
