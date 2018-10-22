@extends ('customer')

@section ('title', 'Member Sign Up')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('hide_top_bar')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="container">
        @include ('partials.progress')
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        {!! Form::open(['id' => 'form']) !!}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default panel-box">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon icon-user"></i><span class="icon-text">Personal Information</span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name<i class="required">*</i></label>
                                    {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name<i class="required">*</i></label>
                                    {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email<i class="required">*</i></label>
                                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone<i class="required">*</i></label>
                                    {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="school">College/University<i class="required">*</i></label>
                                    {!! Form::text('school', null, ['class' => 'form-control school', 'placeholder' => 'College/University']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chapter">Chapter<i class="required">*</i></label>
                                    {!! Form::text('chapter', null, ['class' => 'form-control chapter', 'placeholder' => 'Chapter']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password<i class="required">*</i></label>
                                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password ']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password<i class="required">*</i></label>
                                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="avatar">Profile Picture</label>
                                    <div class="file-list">
                                        <div class="file-wrapper">
                                            @if (isset($avatar))
                                                <div class="file-entry">
                                                    <div class="file-entry-image size-auto">
                                                        <img src="{{ $avatar['url'] }}"/>
                                                        <span>{{ $avatar['filename'] }}</span>
                                                    </div>
                                                    <input type="hidden" value="{{ $avatar['url'] }}"
                                                           name="avatar_url"/>
                                                    <input type="hidden" value="{{ $avatar['filename'] }}"
                                                           name="avatar_filename"/>
                                                    <input type="hidden" value="{{ $avatar['id'] }}" name="avatar_id"/>
                                                    <input type="hidden" value="existing" name="avatar_action"/>
                                                    <a href="#" class="btn btn-danger file-remove" data-target="avatar">Remove</a>
                                                </div>
                                            @endif
                                            <div class="filepicker-file">
                                                <a href="#" class="filepicker" id="avatar">Browse</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default panel-box">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="icon icon-info"></i><span
                                    class="icon-text">Terms & Conditions</span></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group-checkbox">
                                    <label>
                                        {!! Form::checkbox('agree', 'yes', null) !!} I have read and agree to
                                        the <a href="{{ route('signup_sales_rep::tos') }}" class="ajax-popup">Terms &
                                            Conditions.</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="action-row">
            <a href="{{ route('home::index') }}" class="btn btn-default">Cancel</a>
            <button type="submit" name="next" value="next" class="btn btn-primary">Next</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section ('include')
    @include ('partials.enable_school_chapter')
    @include ('partials.enable_filepicker')
@append

@section ('javascript')
    <script>
        schoolAndChapter('.school', '.chapter');
    </script>
    <script type="text/javascript">
        $(".ajax-popup").click(function (event) {
            event.preventDefault();
            $.fancybox({
                padding: 20,
                margin: 0,
                width: $(this).attr('data-width') ? $(this).attr('data-width') : '900px',
                height: 'auto',
                autoSize: false,
                href: $(this).attr('href'),
                type: 'ajax',
                scrolling: 'auto'
            });
            return false;
        });
    </script>
@append