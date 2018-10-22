@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Products</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Products
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="admin-filter">
                        {!! Form::open(['method' => 'get', 'class' => 'form-inline margin-bottom ']) !!}
                        Filter by:
                        {!! Form::text('filter_product_id', Request::has('filter_product_id')?Request::get('filter_product_id'):'', ['placeholder' => 'Product Id', 'class' => 'form-control']) !!}
                        {!! Form::text('filter_product_name', Request::has('filter_product_name')?Request::get('filter_product_name'):'', ['placeholder' => 'Product Name', 'class' => 'form-control']) !!}
                        {!! Form::text('filter_product_sku', Request::has('filter_product_sku')?Request::get('filter_product_sku'):'', ['placeholder' => 'Product Sku', 'class' => 'form-control']) !!}
                        {!! Form::select('filter_product_brand', garment_brand_options(['' => 'Filter by Brand']), Request::has('filter_product_brand')?Request::get('filter_product_brand'):'', ['class' => 'form-control']) !!}
                        {!! Form::select('filter_product_category', garment_category_options(['' => 'Filter by Category']), Request::has('filter_product_category')?Request::get('filter_product_category'):'', ['class' => 'form-control']) !!}
                        {!! Form::select('filter_product_gender', garment_gender_options(['' => 'Filter by Gender']), Request::has('filter_product_gender')?Request::get('filter_product_gender'):'', ['class' => 'form-control']) !!}
                        {!! Form::select('filter_product_active', active_options([ '' => 'Filter By Active']), Request::has('filter_product_active')?Request::get('filter_product_active'):'', ['class' => 'form-control']) !!}
                        <button type="submit" name="filter" value="filter" class="btn btn-info">Apply</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="table-responsive table-bordered">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Gender</th>
                                <th>Active</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($list as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>
                                        <a href="{{ route('admin::product::read', [$entry->id]) }}">{{ $entry->name }}</a>
                                    </td>
                                    <td>{{ ($entry->brand) ? $entry->brand->name : '' }}</td>
                                    <td>{{ $entry->category->name }}</td>
                                    <td>{{ $entry->gender->name }}</td>
                                    <td>{{ $entry->active?'Active':'Inactive' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-left">
                        <div class="table-entries">
                            Showing {{ ($list->currentPage()-1) * $list->perPage() + 1 }}
                            to {{ (($list->currentPage()-1) * $list->perPage()) + $list->count() }}
                            of {{ $list->total() }} entries
                        </div>
                    </div>
                    <div class="pull-right">
                        {!! $list->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->isType(['admin', 'product_manager', 'support']))
        <div class="row">
            <div class="col-sm-12">
                <div class=" action-area pull-right">
                    <a href="{{ route('admin::product::create') }}" class="btn btn-success">Create</a>
                </div>
            </div>
        </div>
    @endif
@endsection