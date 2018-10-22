@extends ('admin_old.admin')

@section ('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Stores</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Stores
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="admin-filter">
                    {!! Form::open(['method' => 'get', 'class' => 'form-inline margin-bottom ']) !!}
                    Filter by:
                    {!! Form::text('filter_id', Request::has('filter_id')?Request::get('filter_id'):'', ['placeholder' => 'Store Id', 'class' => 'form-control']) !!}
                    {!! Form::text('filter_name', Request::has('filter_name')?Request::get('filter_name'):'', ['placeholder' => 'Store Name', 'class' => 'form-control']) !!}
                    {!! Form::text('filter_link', Request::has('filter_link')?Request::get('filter_link'):'', ['placeholder' => 'Store Link', 'class' => 'form-control']) !!}
                     {!! Form::text('filter_updated_from', Request::has('filter_updated_from')?Request::get('filter_updated_from'):'', ['placeholder' => 'Updated From', 'class' => 'form-control datepicker']) !!}
                        {!! Form::text('filter_updated_to', Request::has('filter_updated_to')?Request::get('filter_updated_to'):'', ['placeholder' => 'Updated To', 'class' => 'form-control datepicker']) !!}
                    
                    <button type="submit" name="filter" value="filter" class="btn btn-info">Apply</button>
                    {!! Form::close() !!}
                </div>
                <div class="table-responsive table-bordered">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Store Name</th>
                                <th>Store Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($list) { ?>
                                @foreach ($list as $entry)
                                <tr>
                                    <td><a href="{{ route('admin::store::read', [$entry->id]) }}">{{ $entry->id }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin::store::read', [$entry->id]) }}">{{ $entry->name }}</a>
                                    </td>
                                    <td><a href="{{ route('admin::store::read', [$entry->id]) }}">{{ $entry->link }}</a>
                                    </td>
                                   
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
                 <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class=" action-area pull-right">
            <a href="{{ route('admin::store::create') }}" class="btn btn-success">Create</a>
        </div>
    </div>
</div>
@endsection