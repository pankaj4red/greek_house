<?php

Route::get('/oauth/hubspot', 'System\\OAuthController@getHubSpot')->name('oauth::hubspot');
Route::post('/oauth/hubspot', 'System\\OAuthController@postHubSpot');

