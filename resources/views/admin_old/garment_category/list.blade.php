@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Garment Categories</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Garment Categories
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Sort</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($list as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>
                                        <a href="{{ route('admin::garment_category::read', [$entry->id]) }}">{{ $entry->name }}</a>
                                        @if ($entry->wizard == 'default')
                                            (default)
                                        @endif
                                    </td>
                                    <td>{{ $entry->sort }}</td>
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
    @if (Auth::user()->isType(['admin', 'product_manager']))
        <div class="row">
            <div class="col-sm-12">
                <div class=" action-area pull-right">
                    <a href="{{ route('admin::garment_category::create') }}" class="btn btn-success">Create</a>
                </div>
            </div>
        </div>
    @endif
@endsection