<div class="row">
    <div class="col-md-12">
        <div class="admin-filter">
            {{ Form::open(['method' => 'GET', 'url' => route('admin::log::list'), 'class' => 'form-inline']) }}
            {{ Form::text('id', isset($variables['id']) ? $variables['id'] : null, ['placeholder' => 'id', 'class' => 'form-control']) }}
            {{ Form::text('channel', isset($variables['channel']) ? $variables['channel'] : null, ['placeholder' => 'channel', 'class' => 'form-control']) }}
            {{ Form::text('level', isset($variables['level']) ? $variables['level'] : null, ['placeholder' => 'level', 'class' => 'form-control']) }}
            {{ Form::text('message', isset($variables['message']) ? $variables['message'] : null, ['placeholder' => 'message', 'class' => 'form-control']) }}
            {{ Form::text('user_id', isset($variables['user_id']) ? $variables['user_id'] : null, ['placeholder' => 'user_id', 'class' => 'form-control']) }}
            {{ Form::text('ip', isset($variables['ip']) ? $variables['ip'] : null, ['placeholder' => 'ip', 'class' => 'form-control']) }}
            {{ Form::text('time_from', isset($variables['time_from']) ? $variables['time_from'] : null, ['placeholder' => 'time_from', 'class' => 'form-control']) }}
            {{ Form::text('time_to', isset($variables['time_to']) ? $variables['time_to'] : null, ['placeholder' => 'time_to', 'class' => 'form-control']) }}
            {{ Form::text('campaign', isset($variables['campaign']) ? $variables['campaign'] : null, ['placeholder' => 'campaign', 'class' => 'form-control']) }}
            {{ Form::text('order', isset($variables['order']) ? $variables['order'] : null, ['placeholder' => 'order', 'class' => 'form-control']) }}
            {{ Form::text('key', isset($variables['key']) ? $variables['key'] : null, ['placeholder' => 'key', 'class' => 'form-control']) }}
            {{ Form::text('value', isset($variables['value']) ? $variables['value'] : null, ['placeholder' => 'value', 'class' => 'form-control']) }}
            <button type="submit" name="filter" value="filter" class="btn btn-info">Apply</button>
            {{ Form::close() }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if (isset($variables['message']))
            <a href="{{ route('admin::log::list') . '?' . http_build_query(['message' => $variables['message']]) }}">Message</a>
        @endif
        @if (isset($variables['user_id']))
            <a href="{{ route('admin::log::list') . '?' . http_build_query(['user_id' => $variables['user_id']]) }}">User</a>
        @endif
        @if (isset($variables['ip']))
            <a href="{{ route('admin::log::list') . '?' . http_build_query(['ip' => $variables['ip']]) }}">IP</a>
        @endif
        @if (isset($variables['time_from']))
            <a href="{{ route('admin::log::list') . '?' . http_build_query(log_time($variables['time_from'], $variables['time_to'], 0)) }}">Time</a>
        @endif
        @if (isset($variables['time_from']))
            <a href="{{ route('admin::log::list') . '?' . http_build_query(log_time($variables['time_from'], $variables['time_to'], 2)) }}">2s</a>
        @endif
        @if (isset($variables['time_from']))
            <a href="{{ route('admin::log::list') . '?' . http_build_query(log_time($variables['time_from'], $variables['time_to'], 5)) }}">5s</a>
        @endif
        @if (isset($variables['time_from']))
            <a href="{{ route('admin::log::list') . '?' . http_build_query(log_time($variables['time_from'], $variables['time_to'], 60)) }}">60s</a>
        @endif
        @if (isset($variables['campaign']))
            <a href="{{ route('admin::log::list') . '?' . http_build_query(['campaign' => $variables['campaign']]) }}">Campaign</a>
        @endif
        @if (isset($variables['order']))
            <a href="{{ route('admin::log::list') . '?' . http_build_query(['order' => $variables['order']]) }}">Order</a>
        @endif
    </div>
</div>
