@extends ('admin_old.admin')

@section ('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Store Details
            <a href="{{ route('admin::store::update', [$user->id]) }}" class="btn btn-default">Edit</a>
            <a data-toggle="modal" data-target="#myModal" class="btn btn-default">Delete</a>
        </h1>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this store?</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin::store::delete', [$user->id]) }}" class="btn btn-default">Yes</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Store Information
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label class="control-label">Store Name</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label class="control-label">Store Link</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $user->link }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">

</div>
<div class="row">
    <div class="col-sm-12">
        <div class=" action-area pull-right">
            <a href="{{ route('admin::store::list') }}" class="btn btn-default">Back</a>
        </div>
    </div>
</div>
@endsection