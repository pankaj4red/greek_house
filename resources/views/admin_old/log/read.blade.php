@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Log Details</h1>
        </div>
    </div>
    @include ('partials.log_header', ['variables' => log_variables_from_model($log)])
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Log Information
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
                            <tr>
                                <td><a href="{{ route('admin::log::read', [$log->id]) }}">{{ $log->id }}</a></td>
                                <td><a href="{{ route('admin::log::list') . '?' . log_parameters(['channel' => $log->channel]) }}">{{ $log->channel }}</a></td>
                                <td><a href="{{ route('admin::log::list') . '?' . log_parameters(['level' => $log->level]) }}">{{ $log->level }}</a></td>
                                <td><a href="{{ route('admin::log::list') . '?' . log_parameters(['message' => $log->message]) }}">{{ $log->message }}</a></td>
                                <td>
                                    <a href="{{ route('admin::log::list') . '?' . log_parameters(['user_id' => $log->user_id ?? 'null']) }}">{{ $log->user_id ? user_repository()->find($log->user_id)->getFullName() : 'N/A' }}</a>
                                </td>
                                <td><a href="{{ route('admin::log::list') . '?' . log_parameters(['ip' => $log->ip]) }}">{{ $log->ip }}</a></td>
                                <td>
                                    <a href="{{ route('admin::log::list') . '?' . log_parameters(['time' => $log->created_at]) }}">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Log Details
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                    <div class="row">
                        @foreach ($log->details->chunk($log->details->count() / 2) as $chunk)
                            <div class="col-md-6">
                                @foreach ($chunk as $detail)
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <label class="control-label">{{ $detail->key }}</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="form-control-static">{{ $detail->value }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
@endsection