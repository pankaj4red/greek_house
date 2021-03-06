@extends ('admin_old.admin')

@section ('content')
    <div class="ajax-messages"></div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Delete Product Color</h1>
        </div>
    </div>
    {!! Form::open() !!}
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Delete Product Color
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <p>Are you sure you want to delete the product color {{ $productColor->name }}?</p>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class=" action-area pull-right">
                                <a href="{{ route('admin::product::read', [$productColor->product_id]) }}"
                                   class="btn btn-default">Back</a>
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
