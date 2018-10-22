@if (Auth::user() && Auth::user()->type->seesSupportQuickQuote() && mb_strpos(Request::url(), '/store/') === false)
    @include ('v2.partials.quick_quote_manager')
@elseif ((Auth::user() && Auth::user()->type->seesCustomerQuickQuote()) && mb_strpos(Request::url(), '/store/') === false)
    @include ('v2.partials.quick_quote_customer')
@endif
