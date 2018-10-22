@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="page-header">Logs</h1>
        </div>
    </div>
    @include ('partials.log_header', ['variables' => log_variables()])
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Log List
                </div>
                <div class="panel-body">
                    <div class="table-responsive table-bordered margin-bottom">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Level</th>
                                <th>Message</th>
                                <th>User</th>
                                <th>IP</th>
                                <th>Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($list as $log)
                                <tr>
                                    <td><a href="{{ route('admin::log::read', [$log->id]) }}">{{ $log->id }}</a></td>
                                    <td><a href="{{ route('admin::log::list') . '?' . log_parameters(['channel' => $log->channel]) }}">{{ $log->channel }}</a></td>
                                    <td><a href="{{ route('admin::log::list') . '?' . log_parameters(['level' => $log->level]) }}">{{ $log->level }}</a></td>
                                    <td><a href="{{ route('admin::log::list') . '?' . log_parameters(['message' => $log->message]) }}">{{ $log->message }}</a></td>
                                    <td><a href="{{ route('admin::log::list') . '?' . log_parameters(['user_id' => $log->user_id]) }}">{{ $log->user_id ? user_repository()->find($log->user_id)->getFullName() : 'N/A' }}</a></td>
                                    <td><a href="{{ route('admin::log::list') . '?' . log_parameters(['ip' => $log->ip]) }}">{{ $log->ip }}</a></td>
                                    <td><a href="{{ route('admin::log::list') . '?' . log_parameters(['time_from' => $log->created_at, 'time_to' => $log->created_at]) }}">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $list->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection