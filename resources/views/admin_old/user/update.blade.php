@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update User</h1>
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
                                <label class="control-label">Username</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('username', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
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
                                <label class="control-label">Type</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::select('type_code', user_type_options(['' => 'Select Type']), null, ['class' => 'form-control']) !!}
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
                                <label class="control-label">Activation Code</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('activation_code', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Active</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {!! Form::radio('active', true, $model['active']) !!}Yes
                                </label>
                                <label class="radio-inline">
                                    {!! Form::radio('active', false, ! $model['active']) !!}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Account Manager</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::select('account_manager', account_manager_options(['' => '']), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Decorator Status</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::select('decorator_status', ['ON' => 'ON', 'OFF' => 'OFF'], null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Decorator Screenprint Enabled</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {!! Form::radio('decorator_screenprint_enabled', true, $model['decorator_screenprint_enabled']) !!}Yes
                                </label>
                                <label class="radio-inline">
                                    {!! Form::radio('decorator_screenprint_enabled', false, $model['decorator_screenprint_enabled']) !!}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Decorator Embroidery Enabled</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {!! Form::radio('decorator_embroidery_enabled', true, $model['decorator_embroidery_enabled']) !!}Yes
                                </label>
                                <label class="radio-inline">
                                    {!! Form::radio('decorator_embroidery_enabled', false, $model['decorator_embroidery_enabled']) !!}No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">On Hold State Protection</label>
                            </div>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    {!! Form::radio('on_hold_state', 'enabled', $model['on_hold_state']) !!}enabled
                                </label>
                                <label class="radio-inline">
                                    {!! Form::radio('on_hold_state', 'disabled', $model['on_hold_state']) !!}disabled
                                </label>
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
                <a href="{{ route('admin::user::read', [$model['id']]) }}" class="btn btn-default">Back</a>
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