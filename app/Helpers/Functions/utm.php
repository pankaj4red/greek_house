<?php

function store_utm(\Illuminate\Http\Request $request)
{
    $source = null;
    $medium = null;
    $campaign = null;
    $term = null;
    $content = null;
    $raw = null;
    $query = null;

    if ($request->get('utm_source')) {
        $source = $request->get('utm_source');
        $medium = $request->get('utm_medium');
        $campaign = $request->get('utm_campaign');
        $term = $request->get('utm_term');
        $content = $request->get('utm_content');
        $raw = $request->getQueryString();
        $query = $request->getQueryString();
    }

    if ($request->headers->get('referer') && ! Session::get('utm_source') && ! starts_with($request->headers->get('referer'), config('app.url'))) {
        $source = 'Referer';
        $raw = $request->headers->get('referer');
        $query = $request->getQueryString();
    }

    if ($source) {
        Session::put('utm_source', $source);
        Session::put('utm_medium', $medium);
        Session::put('utm_campaign', $campaign);
        Session::put('utm_term', $term);
        Session::put('utm_content', $content);
        Session::put('utm_raw', $raw);
        Session::put('utm_query', $query);
    }
}

function get_utm_source()
{
    return Session::get('utm_source') ?? 'Direct';
}

function get_utm_medium()
{
    return Session::get('utm_medium');
}

function get_utm_campaign()
{
    return Session::get('utm_campaign');
}

function get_utm_term()
{
    return Session::get('utm_term');
}

function get_utm_content()
{
    return Session::get('utm_content');
}

function get_utm_raw()
{
    return Session::get('utm_raw');
}

function get_utm_query()
{
    return Session::get('utm_query');
}

