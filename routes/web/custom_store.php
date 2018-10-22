<?php

// Custom Store
Route::get('/stores/{user}', ['as' => 'custom_store::campaigns', 'uses' => 'Home\CustomStoreController@getCampaigns']);

// Cart Page
Route::post('/store/cart/ajax/delete-item/{cart}', ['as' => 'custom_store::delete_item', 'uses' => 'Home\CustomStoreController@postAjaxDeleteItem']);
Route::get('/store/cart', ['as' => 'custom_store::cart', 'uses' => 'Home\CustomStoreController@getCart']);
Route::post('/store/cart', ['as' => 'custom_store::cart', 'uses' => 'Home\CustomStoreController@postCart']);

// Checkout
Route::get('/store/checkout/{cart}/thank-you', ['as' => 'custom_store::thank_you', 'uses' => 'Home\CustomStoreController@getThankYou']);
Route::get('/store/checkout/{cart?}', ['as' => 'custom_store::checkout', 'uses' => 'Home\CustomStoreController@getCheckout']);
Route::post('/store/checkout/{cart?}', ['as' => 'custom_store::checkout', 'uses' => 'Home\CustomStoreController@postCheckout']);

// Checkout of specific campaigns
Route::get('/store/{campaign_checkout}/{productColor?}', ['as' => 'custom_store::details', 'uses' => 'Home\CustomStoreController@getDetails']);
Route::post('/store/{campaign_checkout}/{productColor?}', ['as' => 'custom_store::details', 'uses' => 'Home\CustomStoreController@postDetails']);

// Checkout
Route::get('/store/{campaign_checkout}/{id}', ['as' => 'checkout::checkout', 'uses' => 'Home\CheckoutController@getCheckout']);
Route::post('/checkout/validate-authorize', ['as' => 'checkout::validate_authorize_post', 'uses' => 'Home\CheckoutController@postValidateAuthorizePost']);
Route::post('/checkout/ajax/save-information/{id}', ['as' => 'checkout::ajax_save_information', 'uses' => 'Home\CheckoutController@ajaxSaveInformation']);
Route::post('/checkout/ajax/validate-information/{id}', ['as' => 'checkout::ajax_validate_information', 'uses' => 'Home\CheckoutController@ajaxValidateInformation']);
Route::post('/store/{campaign_checkout}/{id}/manual', ['as' => 'checkout::checkout_manual', 'uses' => 'Home\CheckoutController@postCheckoutManual']);
Route::post('/store/{campaign_checkout}/{id}/test', ['as' => 'checkout::checkout_test', 'uses' => 'Home\CheckoutController@postCheckoutTest']);
Route::post('/store/{campaign_checkout}/{id}/authorize', ['as' => 'checkout::checkout_authorize', 'uses' => 'Home\CheckoutController@postCheckoutAuthorize']);
