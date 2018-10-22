@extends('v2.layouts.app')

@section('content')
    @if (Request::ajax())
        <div class="ajax-messages"></div>
        @yield('content_campaign')
    @else
        <div class="container">
            @include('v2.partials.messages.all')
            @yield('content_campaign')
        </div>
    @endif
@append

