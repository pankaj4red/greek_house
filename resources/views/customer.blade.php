@if (!Request::ajax())
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Greek House: Custom Apparel For Sororities & Fraternities</title>
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Greek House specializes in Sorority & Fraternity apparel. Free design, Free shipping, Free bag ’n tag. Work 1-on-1 with a designer today!">
    @if (App::environment() != 'production')
        <meta name="robots" content="noindex"/>
    @endif
    @yield('metadata')
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') . '?v=' . config('greekhouse.css_version') }}" rel="stylesheet">
    <link href="{{ asset('css/styleupgrade.css') . '?v=' . config('greekhouse.css_version') }}" rel="stylesheet">
    <link href="{{ asset('css/tooltipster.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">

    @if (!isset($print) || $print == false)
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('fancybox/jquery.fancybox.css') . '?v=2.1.5' }}" type="text/css"/>
    @endif
    @yield('stylesheet')
    @include ('v2.partials.plugins.pixel')
    @include ('v2.partials.plugins.drift')
    @include ('v2.partials.plugins.google_tag_head')
	
	<!-- Facebook Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window,document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	 fbq('init', '920718884678644'); 
	fbq('track', 'PageView');
	</script>
	<noscript>
	 <img height="1" width="1" 
	src="https://www.facebook.com/tr?id=920718884678644&ev=PageView
	&noscript=1"/>
	</noscript>
	<!-- End Facebook Pixel Code -->
	
</head>
<body class="{!! (isset($print) && $print) ? 'print' : '' !!} {{ Request::is('/') ? 'homepage' : '' }}">
    @include ('v2.partials.plugins.google_analytics')
    @include ('partials.header')
    <?php echo $__env->yieldContent('messages') ? $__env->yieldContent('messages') : messages(); ?>
    @yield ('content')
    <footer class="footer container-fluid">
        <div class="container">
            <div class="col-sm-12 col-md-4 col-lg-4 text-left">
                <p>CopyRight @ 2015-2016 | All Rights Reserved.</p>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-8">
                <ul>
                    <li><a href="mailto:support@greekhouse.org">Contact us</a></li>
                    <li><a href="{{ route('home::privacy') }}">Privacy &amp; Policy</a></li>
                    <li><a href="{{ route('home::tos') }}">Terms &amp; Conditions</a></li>
                    @if (!isset($print) || $print == false)
                        <li><a href="https://greekhouse.zendesk.com/" target="_blank">Help</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
    <script>
        window.onerror = function (errorMsg, file, lineNo, colNo, errStack) {
            if (errorMsg === 'Script error.') return false;
            if (errorMsg === 'Script error') return false;

            var msg = errorMsg ? errorMsg : "null";
            var stack = errStack ? errStack : "N/A";
            var errFile = file ? file : "null";
            var errLineNo = lineNo ? lineNo : "null";

            try {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('system::error') }}',
                    data: 'error=' + encodeURIComponent(msg)
                    + '&url=' + window.location
                    + '&stack=' + encodeURIComponent(stack)
                    + '&file=' + encodeURIComponent(errFile)
                    + '&line=' + encodeURIComponent(errLineNo),
                    cache: false
                });
            } catch (err) {
            }
            return false;
        };
    </script>
    <script src="{{ asset('js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    @if ((!isset($print) || $print == false) && config('services.freshmarketer.enabled'))
        <script src='//cdn.freshmarketer.com/105349/174851.js'></script>
    @endif
    <script src="{{ asset('js/tether.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.tooltipster.min.js') }}"></script>

    @if (!isset($print) || $print == false)
        <script src="//gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    @endif

    @if (!isset($print) || $print == false)
        <script type="text/javascript" src="{{ asset('fancybox/jquery.fancybox.pack.js') . '?v=2.1.5' }}"></script>
    @endif
    @if (Auth::user() && Auth::user()->type->seesSupportQuickQuote() && mb_strpos(Request::url(), '/store/') === false)
        @include ('partials.quick_quote_manager')
    @elseif ((Auth::user() && Auth::user()->type->seesCustomerQuickQuote()) && mb_strpos(Request::url(), '/store/') === false)
        @include ('partials.quick_quote_customer')
    @endif
    @yield ('include')
    {!! output_css() !!}
    {!! output_js() !!}
    @yield ('javascript')
    @if (!isset($print) || $print == false)
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css" media="screen"/>
    @endif
    @include ('v2.partials.plugins.hubspot')
    @include ('v2.partials.plugins.google_tag_body')
    @include ('v2.partials.plugins.adworks')
    @include ('v2.partials.plugins.freshmarketer')
    @include ('v2.partials.plugins.optin_monster')
    @include ('v2.partials.plugins.gatsby')
    @if (App::environment() == 'local' && config('greekhouse.branch'))
        <div style="position: fixed; top: 0; right: 0; z-index: 100; border-bottom: 1px solid black; border-left: 1px solid black; padding: 5px; border-bottom-left-radius: 5px">
            Branch: {{ config('greekhouse.branch') }}
            @if (config('greekhouse.developer'))
                <br/>Dev: {{ config('greekhouse.developer') }}
            @endif
        </div>
    @endif
</body>
</html>
@else
    @yield ('content')
    @yield ('include')
    {!! output_css() !!}
    {!! output_js() !!}
    @yield ('javascript')
    @if (Request::ajax())
        @include ('partials.ajax')
        @yield ('ajax')
    @endif
@endif