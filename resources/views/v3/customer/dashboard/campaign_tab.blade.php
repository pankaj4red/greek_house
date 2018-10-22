<div class="container mt-5">
    @if (Auth::user() && count(Auth::user()->getViews($campaign->id)) > 1)
        <ul class="nav nav-tabs nav-lg" role="tablist">
            @foreach (Auth::user()->getViews($campaign->id) as $view)
                <li class="nav-item mr-4">
                    <a class="nav-link {{ Request::is('campaign/*/' . ucfirst(camel_case($view)))?'active':'' }} pt-2 pb-2 p-1 text-xs"
                       href="{{ route('dashboard::details', [$campaign->id, ucfirst(camel_case($view))]) }}" title="{{ ucfirst(spaced_camel_case($view)) }}" role="tab" aria-selected="true">
                        {{ ucfirst(spaced_camel_case($view)) }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
