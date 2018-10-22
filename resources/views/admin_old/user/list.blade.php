@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Users</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Users
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="admin-filter">
                        {!! Form::open(['method' => 'get', 'class' => 'form-inline margin-bottom ']) !!}
                        Filter by:
                        {!! Form::text('filter_id', Request::has('filter_id')?Request::get('filter_id'):'', ['placeholder' => 'Id', 'class' => 'form-control']) !!}
                        {!! Form::text('filter_name', Request::has('filter_name')?Request::get('filter_name'):'', ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                        {!! Form::text('filter_email', Request::has('filter_email')?Request::get('filter_email'):'', ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                        {!! Form::text('filter_phone', Request::has('filter_phone')?Request::get('filter_phone'):'', ['placeholder' => 'Phone Number', 'class' => 'form-control']) !!}
                        {!! Form::select('filter_type', user_type_options(['all' => 'Filter by Type']), Request::has('filter_type')?Request::get('filter_type'):'', ['class' => 'form-control']) !!}
                        <button type="submit" name="filter" value="filter" class="btn btn-info">Apply</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="table-responsive table-bordered">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Type</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($list as $entry)
                                <tr>
                                    <td><a href="{{ route('admin::user::read', [$entry->id]) }}">{{ $entry->id }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin::user::read', [$entry->id]) }}">{{ $entry->getFullName() }}</a>
                                    </td>
                                    <td><a href="{{ route('admin::user::read', [$entry->id]) }}">{{ $entry->email }}</a>
                                    </td>
                                    <td>{{ $entry->phone }}</td>
                                    <td>{{ $entry->type->caption }}</td>
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
    <div class="row">
        <div class="col-sm-12">
            <div class=" action-area pull-right">
                <a href="{{ route('admin::user::create') }}" class="btn btn-success">Create</a>
            </div>
        </div>
    </div>
@endsection