@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create User</h1>
        </div>
    </div>
    {!! Form::model($model) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Contact Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">First Name</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Last Name</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Email</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('email', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Phone</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">School</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('school', null, ['class' => 'form-control school']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Chapter</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('chapter', null, ['class' => 'form-control chapter']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Graduation Year</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::select('graduation_year', graduation_year_options(), null, ['class' => 'form-control order-field select-placeholder']) !!}

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Password</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Repeat Password</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Type</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::select('user_type', user_type_options(), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">School Year<br/>(Campus Ambassador)</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::select('school_year', school_year_options(), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Venmo Username<br/>(Campus Ambassador)</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('venmo_username', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label" for="avatar">Avatar</label>
                            </div>
                            <div class="col-sm-9">
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
    <div class="row">
        <div class="col-sm-12">
            <div class=" action-area pull-right">
                <a href="{{ route('admin::user::list') }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section ('javascript')
    @include ('partials.enable_school_chapter')
    <script>
        schoolAndChapter('.school', '.chapter');
    </script>
    @include ('partials.enable_filepicker')
@append
