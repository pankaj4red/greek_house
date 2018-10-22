@extends ('customer')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="login-register-content">
       <!-- <div class="login-register-title">
            <i class="fa fa-university fa-4x"></i>
        </div>-->
        <form id="login-form" method="POST" action="{{ route('login') }}">
            <h1>LOGIN</h1>
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            {!! csrf_field() !!}
            <div class="login-messages"></div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Username or Email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>
            <button id="login-button" type="submit" class="btn btn-blue-greek-house">Sign In</button>
            <a href="javascript:void(0)" class="forgot-link">Forgot Password?</a>
        </form>
        <form id="forgot-form" method="POST" action="{{ route('password.email') }}" style="display: none">
            <h1>FORGOT YOUR PASSWORD?</h1>
            {!! csrf_field() !!}
            <div class="forgot-messages"></div>
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" name="email" class="form-control" id="forgot-username" placeholder="Email">
            </div>
            <button id="forgot-button" type="submit" class="btn btn-blue-greek-house">Submit</button>
        </form>
    </div>
@endsection

@section ('javascript')
    @if (Request::ajax())
        <script>
            $('#login-button').click(function (event) {
                event.preventDefault();
                var formData = $("#login-form").serialize();
                $(this).prop('disabled', true);
                $(this).append('<div class="ajax-progress ajax-progress-throbber"><i class="glyphicon glyphicon-refresh glyphicon-spin"></i></div>');
                var that = this;
                $.ajax({
                    url: '{{ route('login') }}',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        if (data.auth) {
                            $('.login-messages').empty();
                            $('.login-messages').append($('<div class="alert alert-success" role="alert">Login Successful. Redirecting...</div>'));
                            window.location = data.intended;
                        } else {
                            $('.login-messages').empty();
                            $('.login-messages').append($('<div class="alert alert-danger" role="alert">' + data.message + '</div>'));
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
            $('#forgot-button').click(function (event) {
                event.preventDefault();
                var formData = $("#forgot-form").serialize();
                $(this).prop('disabled', true);
                $(this).append('<div class="ajax-progress ajax-progress-throbber"><i class="glyphicon glyphicon-refresh glyphicon-spin"></i></div>');
                var that = this;
                $.ajax({
                    url: '{{ route('password.email') }}',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        if (data.success) {
                            $('.forgot-messages').empty();
                            $('.forgot-messages').append($('<div class="alert alert-success" role="alert">Forgot Password Request Successful. Redirecting...</div>'));
                            window.location = data.intended;
                        } else {
                            $('.forgot-messages').empty();
                            $('.forgot-messages').append($('<div class="alert alert-danger" role="alert">Sorry, unrecognized email or username.</div>'));
                        }
                    },
                    error: function (data) {
                        $('.forgot-messages').empty();
                        $('.forgot-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
                    },
                    complete: function () {
                        $(that).find('.ajax-progress').remove();
                        $(that).prop('disabled', false);
                    }
                });
                return false;
            });
        </script>
    @endif
    <script>
        $('.forgot-link').click(function (event) {
            event.preventDefault();
            $('#login-form').hide();
            $('#forgot-form').show();
            return false;
        });
    </script>
@append