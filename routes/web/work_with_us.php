<?php

Route::get('/go', ['as' => 'work_with_us::go', 'uses' => 'Home\WorkWithUsController@getIndex']);
Route::get('/membership/{mode?}/{id?}', ['as' => 'work_with_us::membership', 'uses' => 'Home\WorkWithUsController@getIndex']);
Route::post('/work-with-us/save-work-with-us-lead', ['as' => 'check-work-withus-fields', 'uses' => 'Home\WorkWithUsController@saveWorkWithUsLead']);

Route::get('/work-with-us/{mode?}/thank-you-ready/{id?}', ['as' => 'work_with_us::thank_you_ready', 'uses' => 'Home\WorkWithUsController@getThankYouReady']);
Route::get('/work-with-us/{mode?}/thank-you-not-ready/{id?}', ['as' => 'work_with_us::thank_you_not_ready', 'uses' => 'Home\WorkWithUsController@getThankYouNotReady']);
Route::post('/work-with-us/{mode?}/thank-you-not-ready/{id?}', ['as' => 'work_with_us::thank_you_not_ready', 'uses' => 'Home\WorkWithUsController@postThankYouNotReady']);

Route::get('/work-with-us/{mode?}/thank-you/{id?}', ['as' => 'work_with_us::thank_you', 'uses' => 'Home\WorkWithUsController@getThankYou']);
Route::get('/work-with-us/{mode?}/schedule/{id?}', ['as' => 'work_with_us::schedule', 'uses' => 'Home\WorkWithUsController@getSchedule']);

Route::get('/work-with-us/{mode?}/{id?}', ['as' => 'work_with_us::index', 'uses' => 'Home\WorkWithUsController@getIndex']);
Route::post('/work-with-us/{mode?}/{id?}', 'Home\WorkWithUsController@postIndex');
Route::post('/register/check-set-password-fields', ['as' => 'check-set-password-fields', 'uses' => 'Auth\RegisterController@checkSetPasswordInputs']);
