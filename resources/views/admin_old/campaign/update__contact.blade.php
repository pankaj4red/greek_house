@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Campaign Contacts</h1>
        </div>
    </div>
    {{ Form::model($campaign) }}
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
                                {{ Form::text('contact_first_name', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Last Name</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('contact_last_name', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Email</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('contact_email', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Phone</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('contact_phone', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">School</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('contact_school', null, ['class' => 'form-control contact_school']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Chapter</label>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('contact_chapter', null, ['class' => 'form-control contact_chapter']) }}
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
                <a href="{{ route('admin::campaign::read', [$campaign->id]) }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section ('javascript')
    @include ('partials.enable_school_chapter')
    <script>
        schoolAndChapter('.contact_school', '.contact_chapter');
    </script>
@append
