<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Greek House: Custom Apparel For Sororities & Fraternities</title>
    @include('v3.partials.metadata')
    <link href="{{ config('app.static_domain_full') }}{{ mix('css/app-v3.css') }}" rel="stylesheet">
    @yield('style')
    @include('v3.partials.plugins.pixel')
    @include('v3.partials.plugins.drift')
    @include('v3.partials.plugins.google_tag_head')
</head>
<body>
@include ('v3.partials.plugins.google_analytics')
<div id="app">
    @include('v3.partials.navigation')
    @if (Session::get('successes') || $errors->getMessages())
        <div class="container mt-4">
            @include('v3.partials.messages.all')
        </div>
    @endif
    @yield('content')
    @include('v3.partials.footer')
</div>
@include('v3.partials.modal')
@include('v3.partials.prompt')
@include('v3.partials.quick_quote')
<script src="{{ config('app.static_domain_full') }}{{ mix('js/app-v3.js') }}"></script>
@include('v3.partials.initialize_plugins')
@yield('javascript')
@include('v3.partials.plugins.hubspot')
@include('v3.partials.plugins.google_tag_body')
@include('v3.partials.plugins.adworks')
@include('v3.partials.plugins.freshmarketer')
@include('v3.partials.plugins.gatsby')
@if (App::environment() == 'local' && config('greekhouse.branch'))
    <div style="position: fixed; top: 0; right: 0; z-index: 100; border-bottom: 1px solid black; border-left: 1px solid black; padding: 5px; border-bottom-left-radius: 5px; font-weight: 500; font-size: 0.8rem">
        Branch: {{ config('greekhouse.branch') }}
        @if (config('greekhouse.developer'))
            <br/>Dev: {{ config('greekhouse.developer') }}
        @endif
    </div>
@endif
</body>
</html>


