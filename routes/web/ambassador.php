<?php

Route::get('/ambassador', 'Home\\AmbassadorController@getIndex')->name('ambassador::index');
Route::post('/ambassador', 'Home\\AmbassadorController@postIndex');
Route::get('/ambassador/schedule', 'Home\\AmbassadorController@getSchedule')->name('ambassador::schedule');
Route::get('/ambassador/thank-you', 'Home\\AmbassadorController@getThankYou')->name('ambassador::thank_you');
