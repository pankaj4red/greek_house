@extends ('customer')

@section ('title', 'Profile - Edit Information')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="page-header cancel-header-margin">
        <div class="container">
            <span class="pull-left page-title">Profile</span>
            <div class="pull-right new-order">
                <a role="button" href="{{ route('profile::add_address') }}" class="btn btn-default add-new-btn"
                   id="add-order">
                    <span>New Address</span>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="form-header">
            <h1><i class="icon icon-info"></i><span class="icon-text">Edit Profile Information</span></h1>
            <hr/>
        </div>
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        {!! Form::model($model, ['id' => 'form']) !!}
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default panel-box">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone (Format: (555) 555-5555)</label>
                                    {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="school">School</label>
                                    {!! Form::text('school', null, ['class' => 'form-control school', 'placeholder' => 'School']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="chapter">Chapter or Organization Name</label>
                                    {!! Form::text('chapter', null, ['class' => 'form-control chapter', 'placeholder' => 'Chapter']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="chapter">Graduation Year</label>
                                    {!! Form::select('graduation_year', graduation_year_options(), null, ['class' => 'form-control order-field select-placeholder']) !!}
                                </div>
                                @if ($model->isType(['sales_rep', 'account_manager']))
                                    <div class="form-group">
                                        <label for="school">School Year</label>
                                        {!! Form::select('school_year', $schoolYearOptions, null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="chapter">Venmo Username</label>
                                        {!! Form::text('venmo_username', null, ['class' => 'form-control', 'placeholder' => 'Venmo Username']) !!}
                                    </div>
                                @endif
                                @if ($model->isType(['junior_designer', 'designer', 'art_director']))
                                    <div class="form-group">
                                        <label for="hourly_rate">Hourly Rate</label>
                                        {!! Form::text('hourly_rate', null, ['placeholder' => 'Hourly Rate', 'class' => 'form-control']) !!}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="avatar">Avatar</label>
                                    <div class="file-list">
                                        @include ('partials.image_picker', [
                                            'fieldName' => 'avatar',
                                            'fieldType' => 'image',
                                            'fieldData' => isset($avatar) ? $avatar : null
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="action-row">
            <a href="{{ route('profile::index') }}" class="button-back btn btn-default back-btn">Cancel</a>
            <button type="submit" name="save" value="save" class="btn btn-primary">Save</button>
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
    <script>
        function refreshGroupAreas() {
            $('.group-area').hide();
            $('.print-button').each(function () {
                if ($(this).prop('checked')) {
                    $('#' + $(this).attr('data-area')).show();
                }
            });
        }
        $('#theme').change(function () {
            if ($(this).val() === 'other') {
                $('#other_theme').show();
            } else {
                $('#other_theme').hide();
            }
        });
        $('.print-button').change(function () {
            var that = this;
            $('.print-button').each(function () {
                if (that !== this && $(that).attr('data-group') === $(this).attr('data-group')) {
                    $(this).prop('checked', false);
                }
            });
            refreshGroupAreas();
        });
    </script>
@append