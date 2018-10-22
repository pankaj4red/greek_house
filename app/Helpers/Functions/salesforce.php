<?php

function store_wizard_start_url(\Illuminate\Http\Request $request)
{
    Session::put('wizard_start_url', $request->fullUrl());
}

function get_wizard_start_url()
{
    return Session::get('wizard_start_url') ?? route('wizard::start');
}
