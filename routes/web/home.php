<?php

Route::get('/', ['as' => 'home::index', 'uses' => 'Home\HomeController@getIndex']);
Route::get('/refunds', ['as' => 'home::refunds', 'uses' => 'Home\HomeController@getRefunds']);
Route::get('/design-gallery/{id?}', ['as' => 'home::design_gallery', 'uses' => 'Home\HomeController@getDesignGallery']);
Route::get('/design-gallery/related/{id?}', ['as' => 'home::ajax_design_gallery', 'uses' => 'Home\HomeController@getAjaxDesignRelated']);
Route::get('/tos', ['as' => 'home::tos', 'uses' => 'Home\HomeController@getTos']);
Route::get('/privacy', ['as' => 'home::privacy', 'uses' => 'Home\HomeController@getPrivacy']);

Route::get('/about-us', ['as' => 'home::about_us', 'uses' => 'Home\HomeController@getAboutUs']);
Route::get('/facebook-tracker', ['as' => 'home::facebook_tracker', 'uses' => 'Home\HomeController@facebookExistingUserTrack']);
