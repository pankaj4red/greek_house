@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Design Details
                <a href="{{ route('admin::design::delete', [$model->id]) }}" class="btn btn-danger">Delete</a>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Design Information
                    <a href="{{ route('admin::design::update_general', [$model->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Code</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->code }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Campaign</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">
                                    @if ($model->campaign)
                                        <a href="{{ route('admin::campaign::read', [$model->campaign_id]) }}">{{ $model->campaign->name }}</a>
                                    @else
                                        N/A
                                    @endif

                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Status</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ ucfirst($model->status) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Trending</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $model->trending ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Thumbnail</label>
                            </div>
                            <div class="col-sm-9">
                                @if ($model->thumbnail_id)
                                    <img class="image-thumbnail" src="{{ route('system::image', [$model->thumbnail_id]) }}"/>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Tags
                    <a href="{{ route('admin::design::update_tags', [$model->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        @foreach (design_tag_group_repository()->all() as $group)
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">{{ $group->caption }}</label>
                                </div>
                                <div class="col-sm-9">
                                    <p class="form-control-static">
                                        @foreach ($model->getTags($group->code) as $tag)
                                            <span class="label label-info">{{ $tag->name }}</span>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Images
                    <a href="{{ route('admin::design::update_images', [$model->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-12">
                                @foreach ($model->files as $file)
                                    @if ($file->type == 'image')
                                        <img src="{{ route('system::image', [$file->file_id]) }}"
                                             class="image-thumbnail"/>
                                    @endif
                                @endforeach
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
            </div>
        </div>
    </div>
@endsection