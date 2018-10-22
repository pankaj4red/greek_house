<?php

function dashboard_mode($default)
{
    if (session()->has('dashboard_mode')) {
        return session()->get('dashboard_mode');
    }

    return $default;
}

function dashboard_change_query($default, $include = [])
{
    $data = [];
    if (dashboard_mode($default) == 'expanded') {
        $data['container'] = true;
    } else {
        $data['expanded'] = true;
    }

    foreach ($include as $key) {
        $data[$key] = Request::get($key);
    }

    return query_build($data);
}

function dashboard_change()
{
    if (Request::has('expanded')) {
        session()->put('dashboard_mode', 'expanded');
    }
    if (Request::has('container')) {
        session()->put('dashboard_mode', 'container');
    }
}
