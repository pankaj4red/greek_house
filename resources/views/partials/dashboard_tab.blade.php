<section class="second-nav">
    @if (Auth::user() && count(Auth::user()->getViews($campaign->id)) > 1)
        <div class="second-nav-inner">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <ul>
                            @foreach (Auth::user()->getViews($campaign->id) as $view)
                                <li class="{{ Request::is('campaign/*/' . ucfirst(camel_case($view)))?'active':'' }}"><a
                                            href="{{ route('dashboard::details', [$campaign->id, ucfirst(camel_case($view))]) }}">{{ ucfirst(spaced_camel_case($view)) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
