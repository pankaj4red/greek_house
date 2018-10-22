<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Greek House: Custom Apparel For Sororities & Fraternities</title>
    @include('v2.partials.metadata')
    <link href="{{ config('app.static_domain_full') }}{{ mix('css/all_vendor.css') }}" rel="stylesheet">
    <link href="{{ config('app.static_domain_full') }}{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('style')
    @include('v2.partials.plugins.pixel')
    @include('v2.partials.plugins.drift')
    @include('v2.partials.plugins.google_tag_head')
</head>
<body>
    @include ('v2.partials.plugins.google_analytics')
    <div id="app">
        @include('v2.partials.navigation')
        @yield('content')
        @include('v2.partials.footer')
    </div>
    @include('v2.partials.modal')
    @include('v2.partials.prompt')
    @include('v2.partials.quick_quote')
    <script src="{{ config('app.static_domain_full') }}{{ mix('js/app.js') }}"></script>
    @yield('javascript')
    @include('v2.partials.plugins.hubspot')
    @include('v2.partials.plugins.google_tag_body')
    @include('v2.partials.plugins.adworks')
    @include('v2.partials.plugins.freshmarketer')
    @include('v2.partials.plugins.optin_monster')
    @include('v2.partials.plugins.gatsby')
    @if (App::environment() == 'local' && config('greekhouse.branch'))
        <div style="position: fixed; top: 0; right: 0; z-index: 100; border-bottom: 1px solid black; border-left: 1px solid black; padding: 5px; border-bottom-left-radius: 5px; font-weight: 500;">
            Branch: {{ config('greekhouse.branch') }}
            @if (config('greekhouse.developer'))
                <br/>Dev: {{ config('greekhouse.developer') }}
            @endif
        </div>
    @endif
</body>
</html>


