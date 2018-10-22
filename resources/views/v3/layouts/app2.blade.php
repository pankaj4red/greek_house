<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Greek House: Custom Apparel For Sororities & Fraternities</title>
    <link href="{{ config('app.static_domain_full') }}{{ mix('css/app-v3.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
<div id="app">
    @yield('content')
</div>
<script src="{{ config('app.static_domain_full') }}{{ mix('js/app-v3.js') }}"></script>
@yield('javascript')
</body>
</html>


