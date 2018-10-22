@extends ('customer')

@section ('title', 'Reset Password')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="container">
        <div class="form-header">
            <h1><i class="icon icon-squares"></i><span class="icon-text">Reset Password</span></h1>
            <hr/>
        </div>
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        <div class="row">
            <div class="col-md-offset-3 col-md-6 text-center">
                {!! Form::open(['url' => route('password.reset', [''])]) !!}
                {!! Form::hidden('token', $token) !!}
                <div class="login-register-content">
                    <div class="form-group">
                        <label for="email">Email</label>
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Password Confirmation']) !!}
                    </div>
                    <button type="submit" class="btn btn-default">Reset Password</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

