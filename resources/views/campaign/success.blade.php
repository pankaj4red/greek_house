@extends ('customer')

@section ('title', 'Order - Success')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (config('services.crazy_egg.enabled'))
        <script type="text/javascript">
            setTimeout(function(){var a=document.createElement("script");
                var b=document.getElementsByTagName("script")[0];
                a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0050/4238.js?"+Math.floor(new Date().getTime()/3600000);
                a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
        </script>
    @endif
    <div class="container">
        @include ('partials.progress')
        <div class="alert alert-success">Your order has been submitted!</div>
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        <div class="row">
            <div class="confirmation-box">
                <img src="{{ static_asset('images/thumbs-up-icon.png') }}" alt="image">
                <h1><span>Congrats</span> You Did it!</h1>
                <p>Your order has been submitted!</p>
                <div class="row margin-bottom">
                    <div class="col-xs-12 text-center">
                        <a href="{{ route('wizard::start') }}" class="btn btn-lg btn-success">Place Another Campaign</a>
                        <a href="{{ route('dashboard::index') }}" class="btn btn-lg btn-info">Go To Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
        @if ($newAccount)
            {!! Form::model($model) !!}
            {!! csrf_field() !!}
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default panel-box">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon icon-user"></i><span class="icon-text">Do you wish to make an account?</span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                           placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                           id="password_confirmation" placeholder="Confirm Password">
                                </div>
                                <button type="submit" name="save" value="save" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        @endif
    </div>
@endsection