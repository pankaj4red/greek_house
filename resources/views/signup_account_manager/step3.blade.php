@extends ('customer')

@section ('title', 'Campus Manager Sign Up')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('hide_top_bar')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="container more-margin-bottom">
        @include ('partials.progress')
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default panel-box">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon icon-user"></i><span class="icon-text">Greek House Explainer Video</span>
                        </h3>
                    </div>
                    <div class="panel-body text-center">
                        <iframe width="100%" height="620" id="youtube_iframe"
                                src="https://www.youtube.com/embed/n_o4KrjMO_U?autoplay=1" frameborder="0"
                                allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="action-row">
            <a href="{{ route('signup_account_manager::step4') }}" class="btn btn-primary">Next</a>
        </div>
    </div>
@endsection

@section ('javascript')
    <script>
        $('#youtube_iframe').css('height', ($('#youtube_iframe').width() / 1.7777) + 'px');
    </script>
@append