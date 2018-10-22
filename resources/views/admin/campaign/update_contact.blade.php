@extends ('admin.layouts.admin')

@section ('content')
    {{ Form::model($campaign) }}
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Campaign Contacts
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">First Name</label>
                        <div class="col-12 col-sm-9">{{ Form::text('contact_first_name', null, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Last Name</label>
                        <div class="col-12 col-sm-9">{{ Form::text('contact_last_name', null, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Email</label>
                        <div class="col-12 col-sm-9">{{ Form::text('contact_email', null, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Phone</label>
                        <div class="col-12 col-sm-9">{{ Form::text('contact_phone', null, ['class' => 'form-control']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">School</label>
                        <div class="col-12 col-sm-9">{{ Form::text('contact_school', null, ['class' => 'form-control contact-school']) }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-right">Chapter</label>
                        <div class="col-12 col-sm-9">{{ Form::text('contact_chapter', null, ['class' => 'form-control contact-chapter']) }}</div>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('admin::campaign::read', [$campaign->id]) }}" class="btn btn-default btn-back">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section ('javascript')
    @include ('admin.partials.enable_school_chapter')
    <script>
        schoolAndChapter('.contact-school', '.contact-chapter');
    </script>
@append
