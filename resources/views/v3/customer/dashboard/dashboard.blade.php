@extends('v3.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div id="dashboard">
        @if ($dashboardNavigation)
            <div class="container">
                <div class="row border border-grey mt-5">
                    <div class="col text-center p-4">
                        <a href="{{ route('wizard::start') }}" class="text-uppercase color-slate text-sm font-weight-semi-bold letter-space-1 text-nowrap text-no-underline">
                            <span class="svg-grey">
                                @include ('v3.partials.icons.tshirt')
                            </span>
                            <span class="ml-2">New campaign</span>
                        </a>
                    </div>
                    <div class="col text-center p-4">
                        <a href="{{ route('home::design_gallery') }}" class="text-uppercase color-slate text-sm font-weight-semi-bold letter-space-1 text-nowrap text-no-underline">
                            <span class="svg-grey">
                                @include ('v3.partials.icons.image')
                            </span>
                            <span class="ml-2">Visit Design Gallery</span>
                        </a>
                    </div>
                    <div class="col text-center p-4">
                        <a href="{{ route('referral::index') }}" class="text-uppercase color-slate text-sm font-weight-semi-bold letter-space-1 text-nowrap text-no-underline">
                            <span class="svg-grey">
                                @include ('v3.partials.icons.users')
                            </span>
                            <span class="ml-2">Refer A Friend</span>
                        </a>
                    </div>
                    <div class="col text-center p-4">
                        <a href="{{ route('custom_store::campaigns', [Auth::user()->id]) }}" class="text-uppercase color-slate text-sm font-weight-semi-bold letter-space-1 text-nowrap text-no-underline">
                            <span class="svg-grey">
                                @include ('v3.partials.icons.shopping_cart')
                            </span>
                            <span class="ml-2">Visit Store</span>
                        </a>
                    </div>
                    <div class="col text-center p-4">
                        <a href="https://greekhouse.zendesk.com/" target="_blank" class="text-uppercase color-slate text-sm font-weight-semi-bold letter-space-1 text-nowrap text-no-underline">
                            <span class="svg-grey">
                                @include ('v3.partials.icons.question_circle')
                            </span>
                            <span class="ml-2">Help</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @foreach ($tables as $table)
            @include ('v3.customer.dashboard.dashboard_table', $table)
        @endforeach
        @if (false && Auth::user() && Auth::user()->isType(['admin', 'support', 'art_director', 'decorator', 'designer', 'junior_designer']))
            <div class="expand-tables">
                <a href="{{ Request::url() }}?{{ dashboard_change_query($table['fluid'] ? 'expanded' : 'container', ['page']) }}">
                    <i class="fa fa-expand"></i>
                </a>
            </div>
        @endif
    </div>
@endsection
