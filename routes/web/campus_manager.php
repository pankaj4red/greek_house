<?php

Route::get('/cm', 'Home\\CampusManagerController@getIndex')->name('campus_manager::index');
Route::post('/cm', 'Home\\CampusManagerController@postIndex');
Route::get('/cm/application', 'Home\\CampusManagerController@getApplication')->name('campus_manager::application');
Route::post('/cm/application', 'Home\\CampusManagerController@postApplication');
Route::get('/cm/schedule', 'Home\\CampusManagerController@getSchedule')->name('campus_manager::schedule');
