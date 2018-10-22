@if (Auth::user() && count(Auth::user()->getViews($campaign->id)) > 1)
    <div class="campaign-view-tab-list">
        @foreach (Auth::user()->getViews($campaign->id) as $view)
            <div class="campaign-view-tab {{ Request::is('campaign/*/' . ucfirst(camel_case($view)))?'active':'' }}">
                <a href="{{ route('dashboard::details', [$campaign->id, ucfirst(camel_case($view))]) }}" title="{{ ucfirst(spaced_camel_case($view)) }}">
                    {{ ucfirst(spaced_camel_case($view)) }}
                </a>
            </div>
        @endforeach
    </div>
@endif
