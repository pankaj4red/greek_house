@extends(Request::ajax() ? 'v3.layouts.ajax' : 'v3.layouts.app')

@section('content')
    @if (Request::ajax())
        <div class="ajax-messages"></div>
        @yield('content_campaign')
    @else
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    @yield('title')
                </div>
                <div class="card-body">
                    @include('v3.partials.messages.all')
                    @yield('content_campaign')
                </div>
            </div>
        </div>
    @endif
@append

