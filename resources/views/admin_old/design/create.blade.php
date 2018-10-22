@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create Design</h1>
        </div>
    </div>
    {!! Form::model($model) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Design Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label" for="avatar">Image</label>
                            </div>
                            <div class="col-sm-9">
                                @if (isset($image))
                                    <div class="file-entry">
                                        <div class="file-entry-image size-auto">
                                            <img src="{{ $image['url'] }}"/>
                                            <span>{{ $image['filename'] }}</span>
                                        </div>
                                        <input type="hidden" value="{{ $image['url'] }}" name="image_url"/>
                                        <input type="hidden" value="{{ $image['filename'] }}" name="image_filename"/>
                                        <input type="hidden" value="{{ $image['id'] }}" name="image_id"/>
                                        <input type="hidden" value="existing" name="image_action"/>
                                        <a href="#" class="btn btn-danger file-remove" data-target="image">Remove</a>
                                    </div>
                                @endif
                                <div class="filepicker-file">
                                    <a href="#" class="filepicker" id="image">Browse</a>
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
                <a href="{{ route('admin::design::list') }}" class="btn btn-default">Back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section ('javascript')
    @include ('partials.enable_filepicker')
@append
