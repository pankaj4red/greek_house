@extends ('customer')

@section ('content')
    <div class="login-register-content">
        <div class="login-register-title">
            <i class="fa fa-university fa-4x"></i>
            <h1>REGISTER HERE !</h1>
            <form id="register-form" method="POST" action="{{ route('register') }}">
                {!! csrf_field() !!}
                <div class="register-messages"></div>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                           placeholder="Confirm Password">
                </div>
                <button id="register-button" type="submit" class="btn btn-default">Register</button>
            </form>
        </div>
    </div>
@endsection

@section ('javascript')
    @if (Request::ajax())
        <script>
            $('#register-button').click(function (event) {
                event.preventDefault();
                var formData = $("#register-form").serialize();
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
                            window.location = data.intended;
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
    @endif
@append
