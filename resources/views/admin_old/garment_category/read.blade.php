@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Garment Category Details
                <a href="{{ route('admin::garment_category::update', [$garmentCategory->id]) }}" class="btn btn-default">Edit</a>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Garment Category Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $garmentCategory->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Image</label>
                            </div>
                            <div class="col-sm-9">
                                @if ($garmentCategory->image)
                                    <img src="{{ route('system::image', [$garmentCategory->image->id]) }}"/>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Active</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $garmentCategory->active?'Active':'Inactive' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Wizard</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $garmentCategory->wizard }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Shows in Additional Products</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $garmentCategory->allow_additional ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Sort</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $garmentCategory->sort }}</p>
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
                <a href="{{ route('admin::garment_category::list') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
@endsection