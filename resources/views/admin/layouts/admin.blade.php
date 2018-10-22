<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Area</title>
    <link href="{{ config('app.static_domain_full') }}{{ mix('css/app-admin.css') }}" rel="stylesheet">
</head>
<body id="page-top">
@include('admin.partials.navigation_top')
<div id="wrapper">
    @include('admin.partials.navigation_left')
    <div id="content-wrapper">
        <div class="container-fluid">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            @yield('content')
        </div>
    </div>
</div>

<script src="{{ config('app.static_domain_full') }}{{ mix('js/app-admin.js') }}"></script>
@include('admin.partials.initialize_plugins')
@yield('javascript')
</body>
</html>
