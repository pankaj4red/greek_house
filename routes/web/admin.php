<?php

// Admin Area
Route::get('/admin/dashboard', ['as' => 'admin::index', 'uses' => 'Admin\DashboardController@getIndex']);
Route::get('/admin/design/list', ['as' => 'admin::design::list', 'uses' => 'Admin\DesignController@getList']);
Route::get('/admin/design/trending', ['as' => 'admin::design::trending', 'uses' => 'Admin\DesignController@getTrending']);
Route::post('/admin/design/trending', 'Admin\DesignController@postTrending');
Route::get('/admin/design/create', ['as' => 'admin::design::create', 'uses' => 'Admin\DesignController@getCreate']);
Route::post('/admin/design/create', 'Admin\DesignController@postCreate');
Route::get('/admin/design/read/{id}', ['as' => 'admin::design::read', 'uses' => 'Admin\DesignController@getRead']);
Route::get('/admin/design/update-general/{id}', ['as' => 'admin::design::update_general', 'uses' => 'Admin\DesignController@getUpdateGeneral']);
Route::post('/admin/design/update-general/{id}', 'Admin\DesignController@postUpdateGeneral');
Route::get('/admin/design/update-tags/{id}', ['as' => 'admin::design::update_tags', 'uses' => 'Admin\DesignController@getUpdateTags']);
Route::post('/admin/design/update-tags/{id}', 'Admin\DesignController@postUpdateTags');
Route::get('/admin/design/update-images/{id}', ['as' => 'admin::design::update_images', 'uses' => 'Admin\DesignController@getUpdateImages']);
Route::post('/admin/design/update-images/{id}', 'Admin\DesignController@postUpdateImages');
Route::get('/admin/design/delete/{id}', ['as' => 'admin::design::delete', 'uses' => 'Admin\DesignController@getDelete']);
Route::post('/admin/design/delete/{id}', 'Admin\DesignController@postDelete');

Route::get('/admin/supplier/list', ['as' => 'admin::supplier::list', 'uses' => 'Admin\SupplierController@getList']);
Route::get('/admin/supplier/create', ['as' => 'admin::supplier::create', 'uses' => 'Admin\SupplierController@getCreate']);
Route::post('/admin/supplier/create', 'Admin\SupplierController@postCreate');
Route::get('/admin/supplier/read/{id}', ['as' => 'admin::supplier::read', 'uses' => 'Admin\SupplierController@getRead']);
Route::get('/admin/supplier/update/{id}', ['as' => 'admin::supplier::update', 'uses' => 'Admin\SupplierController@getUpdate']);
Route::post('/admin/supplier/update/{id}', 'Admin\SupplierController@postUpdate');
Route::get('/admin/supplier/delete/{id}', ['as' => 'admin::supplier::delete', 'uses' => 'Admin\SupplierController@getDelete']);
Route::post('/admin/supplier/delete/{id}', 'Admin\SupplierController@postDelete');

Route::get('/admin/garment_brand/list', ['as' => 'admin::garment_brand::list', 'uses' => 'Admin\GarmentBrandController@getList']);
Route::get('/admin/garment_brand/create', ['as' => 'admin::garment_brand::create', 'uses' => 'Admin\GarmentBrandController@getCreate']);
Route::post('/admin/garment_brand/create', 'Admin\GarmentBrandController@postCreate');
Route::get('/admin/garment_brand/read/{id}', ['as' => 'admin::garment_brand::read', 'uses' => 'Admin\GarmentBrandController@getRead']);
Route::get('/admin/garment_brand/update/{id}', ['as' => 'admin::garment_brand::update', 'uses' => 'Admin\GarmentBrandController@getUpdate']);
Route::post('/admin/garment_brand/update/{id}', 'Admin\GarmentBrandController@postUpdate');
Route::get('/admin/garment_brand/delete/{id}', ['as' => 'admin::garment_brand::delete', 'uses' => 'Admin\GarmentBrandController@getDelete']);
Route::post('/admin/garment_brand/delete/{id}', 'Admin\GarmentBrandController@postDelete');

Route::get('/admin/garment_category/list', ['as' => 'admin::garment_category::list', 'uses' => 'Admin\GarmentCategoryController@getList']);
Route::get('/admin/garment_category/create', ['as' => 'admin::garment_category::create', 'uses' => 'Admin\GarmentCategoryController@getCreate']);
Route::post('/admin/garment_category/create', 'Admin\GarmentCategoryController@postCreate');
Route::get('/admin/garment_category/read/{id}', ['as' => 'admin::garment_category::read', 'uses' => 'Admin\GarmentCategoryController@getRead']);
Route::get('/admin/garment_category/update/{id}', ['as' => 'admin::garment_category::update', 'uses' => 'Admin\GarmentCategoryController@getUpdate']);
Route::post('/admin/garment_category/update/{id}', 'Admin\GarmentCategoryController@postUpdate');
Route::get('/admin/garment_category/delete/{id}', ['as' => 'admin::garment_category::delete', 'uses' => 'Admin\GarmentCategoryController@getDelete']);
Route::post('/admin/garment_category/delete/{id}', 'Admin\GarmentCategoryController@postDelete');

Route::get('/admin/garment_color/list', ['as' => 'admin::garment_color::list', 'uses' => 'Admin\GarmentColorController@getList']);
Route::get('/admin/garment_color/create', ['as' => 'admin::garment_color::create', 'uses' => 'Admin\GarmentColorController@getCreate']);
Route::post('/admin/garment_color/create', 'Admin\GarmentColorController@postCreate');
Route::get('/admin/garment_color/read/{id}', ['as' => 'admin::garment_color::read', 'uses' => 'Admin\GarmentColorController@getRead']);
Route::get('/admin/garment_color/update/{id}', ['as' => 'admin::garment_color::update', 'uses' => 'Admin\GarmentColorController@getUpdate']);
Route::post('/admin/garment_color/update/{id}', 'Admin\GarmentColorController@postUpdate');
Route::get('/admin/garment_color/delete/{id}', ['as' => 'admin::garment_color::delete', 'uses' => 'Admin\GarmentColorController@getDelete']);
Route::post('/admin/garment_color/delete/{id}', 'Admin\GarmentColorController@postDelete');

Route::get('/admin/campaign/list', ['as' => 'admin::campaign::list', 'uses' => 'Admin\CampaignController@getList']);
Route::get('/admin/campaign/create', ['as' => 'admin::campaign::create', 'uses' => 'Admin\CampaignController@getCreate']);
Route::post('/admin/campaign/create', 'Admin\CampaignController@postCreate');
Route::get('/admin/campaign/read/{campaign}', ['as' => 'admin::campaign::read', 'uses' => 'Admin\CampaignController@getRead']);

Route::get('/admin/campaign/update-general/{campaign}', ['as' => 'admin::campaign::update_general', 'uses' => 'Admin\CampaignController@getUpdateGeneral']);
Route::post('/admin/campaign/update-general/{campaign}', 'Admin\CampaignController@postUpdateGeneral');
Route::get('/admin/campaign/update-contact/{campaign}', ['as' => 'admin::campaign::update_contact', 'uses' => 'Admin\CampaignController@getUpdateContact']);
Route::post('/admin/campaign/update-contact/{campaign}', 'Admin\CampaignController@postUpdateContact');
Route::get('/admin/campaign/update-shipping/{campaign}', ['as' => 'admin::campaign::update_shipping', 'uses' => 'Admin\CampaignController@getUpdateShipping']);
Route::post('/admin/campaign/update-shipping/{campaign}', 'Admin\CampaignController@postUpdateShipping');
Route::get('/admin/campaign/update-shipping-types/{campaign}', ['as' => 'admin::campaign::update_shipping_types', 'uses' => 'Admin\CampaignController@getUpdateShippingTypes']);
Route::post('/admin/campaign/update-shipping-types/{campaign}', 'Admin\CampaignController@postUpdateShippingTypes');
Route::get('/admin/campaign/update-quote/{campaign}', ['as' => 'admin::campaign::update_quote', 'uses' => 'Admin\CampaignController@getUpdateQuote']);
Route::post('/admin/campaign/update-quote/{campaign}', 'Admin\CampaignController@postUpdateQuote');
Route::get('/admin/campaign/update-actors/{campaign}', ['as' => 'admin::campaign::update_actors', 'uses' => 'Admin\CampaignController@getUpdateActors']);
Route::post('/admin/campaign/update-actors/{campaign}', 'Admin\CampaignController@postUpdateActors');
Route::get('/admin/campaign/update-artwork-request/{campaign}', ['as' => 'admin::campaign::update_artwork_request', 'uses' => 'Admin\CampaignController@getUpdateArtworkRequest']);
Route::post('/admin/campaign/update-artwork-request/{campaign}', 'Admin\CampaignController@postUpdateArtworkRequest');
Route::get('/admin/campaign/update-proofs/{campaign}', ['as' => 'admin::campaign::update_proofs', 'uses' => 'Admin\CampaignController@getProofs']);
Route::post('/admin/campaign/update-proofs/{campaign}', 'Admin\CampaignController@postProofs');
Route::get('/admin/campaign/update-products/{campaign}', ['as' => 'admin::campaign::update_products', 'uses' => 'Admin\CampaignController@getUpdateProducts']);
Route::post('/admin/campaign/update-products/{campaign}', 'Admin\CampaignController@postUpdateProducts');

Route::get('/admin/campaign/update/{id}', ['as' => 'admin::campaign::update', 'uses' => 'Admin\CampaignController@getUpdate']);
Route::post('/admin/campaign/update/{id}', 'Admin\CampaignController@postUpdate');
Route::get('/admin/campaign/delete/{id}', ['as' => 'admin::campaign::delete', 'uses' => 'Admin\CampaignController@getDelete']);
Route::post('/admin/campaign/delete/{id}', 'Admin\CampaignController@postDelete');

Route::get('/admin/product/list', ['as' => 'admin::product::list', 'uses' => 'Admin\ProductController@getList']);
Route::get('/admin/product/create', ['as' => 'admin::product::create', 'uses' => 'Admin\ProductController@getCreate']);
Route::post('/admin/product/create', 'Admin\ProductController@postCreate');
Route::get('/admin/product/read/{id}', ['as' => 'admin::product::read', 'uses' => 'Admin\ProductController@getRead']);
Route::get('/admin/product/update/{id}', ['as' => 'admin::product::update', 'uses' => 'Admin\ProductController@getUpdate']);
Route::post('/admin/product/update/{id}', 'Admin\ProductController@postUpdate');
Route::get('/admin/product/delete/{id}', ['as' => 'admin::product::delete', 'uses' => 'Admin\ProductController@getDelete']);
Route::post('/admin/product/delete/{id}', 'Admin\ProductController@postDelete');

Route::get('/admin/user/list', ['as' => 'admin::user::list', 'uses' => 'Admin\UserController@getList']);
Route::get('/admin/store/list', ['as' => 'admin::store::list', 'uses' => 'Admin\UserController@getStores']);
Route::get('/admin/user/create', ['as' => 'admin::user::create', 'uses' => 'Admin\UserController@getCreate']);
Route::any('/admin/store/create', ['as' => 'admin::store::create', 'uses' => 'Admin\UserController@CreateStore']);
Route::post('/admin/user/create', 'Admin\UserController@postCreate');
Route::get('/admin/user/read/{id}', ['as' => 'admin::user::read', 'uses' => 'Admin\UserController@getRead']);
Route::get('/admin/store/read/{id}', ['as' => 'admin::store::read', 'uses' => 'Admin\UserController@getStoreRead']);
Route::get('/admin/user/update/{id}', ['as' => 'admin::user::update', 'uses' => 'Admin\UserController@getUpdate']);
Route::any('/admin/store/update/{id}', ['as' => 'admin::store::update', 'uses' => 'Admin\UserController@getStoreUpdate']);
Route::post('/admin/user/update/{id}', 'Admin\UserController@postUpdate');
Route::get('/admin/user/delete/{id}', ['as' => 'admin::user::delete', 'uses' => 'Admin\UserController@getDelete']);
Route::get('/admin/store/delete/{id}', ['as' => 'admin::store::delete', 'uses' => 'Admin\UserController@getStoreDelete']);
Route::post('/admin/user/delete/{id}', 'Admin\UserController@postDelete');
Route::post('/admin/user/loginas/{id}', ['as' => 'admin::user::loginas', 'uses' => 'Admin\UserController@postLoginAs']);

Route::get('/admin/address/create/{userId}', ['as' => 'admin::address::create', 'uses' => 'Admin\AddressController@getCreate']);
Route::post('/admin/address/create/{userId}', 'Admin\AddressController@postCreate');
Route::get('/admin/address/update/{id}', ['as' => 'admin::address::update', 'uses' => 'Admin\AddressController@getUpdate']);
Route::post('/admin/address/update/{id}', 'Admin\AddressController@postUpdate');
Route::get('/admin/address/delete/{id}', ['as' => 'admin::address::delete', 'uses' => 'Admin\AddressController@getDelete']);
Route::post('/admin/address/delete/{id}', 'Admin\AddressController@postDelete');
Route::get('/admin/address/shipping/{id}', ['as' => 'admin::address::make_shipping', 'uses' => 'Admin\AddressController@getMakeShipping']);

Route::get('/admin/product_color/create/{productId}', ['as' => 'admin::product_color::create', 'uses' => 'Admin\ProductColorController@getCreate']);
Route::post('/admin/product_color/create/{productId}', 'Admin\ProductColorController@postCreate');
Route::get('/admin/product_color/update/{id}', ['as' => 'admin::product_color::update', 'uses' => 'Admin\ProductColorController@getUpdate']);
Route::post('/admin/product_color/update/{id}', 'Admin\ProductColorController@postUpdate');
Route::get('/admin/product_color/delete/{id}', ['as' => 'admin::product_color::delete', 'uses' => 'Admin\ProductColorController@getDelete']);
Route::post('/admin/product_color/delete/{id}', 'Admin\ProductColorController@postDelete');
Route::get('/admin/product_color/create_thumbnail/', 'Admin\ProductColorController@createThumbnail');

Route::get('/admin/order/list', ['as' => 'admin::order::list', 'uses' => 'Admin\OrderController@getList']);
Route::get('/admin/order/read/{order}', ['as' => 'admin::order::read', 'uses' => 'Admin\OrderController@getRead']);
Route::get('/admin/order/update/{order}', ['as' => 'admin::order::update', 'uses' => 'Admin\OrderController@getUpdate']);
Route::post('/admin/order/update/{order}', ['as' => 'admin::order::update', 'uses' => 'Admin\OrderController@postUpdate']);
Route::post('/admin/order/cancel/{order}', ['as' => 'admin::order::cancel', 'uses' => 'Admin\OrderController@postCancel']);
Route::post('/admin/order/refund/{order}', ['as' => 'admin::order::refund', 'uses' => 'Admin\OrderController@postRefund']);
Route::post('/admin/order/void/{order}', ['as' => 'admin::order::void', 'uses' => 'Admin\OrderController@postVoid']);

Route::get('/admin/slider/list', ['as' => 'admin::slider::list', 'uses' => 'Admin\SliderImageController@getList']);
Route::get('/admin/slider/create', ['as' => 'admin::slider::create', 'uses' => 'Admin\SliderImageController@getCreate']);
Route::post('/admin/slider/create', ['as' => 'admin::slider::create', 'uses' => 'Admin\SliderImageController@postCreate']);
Route::get('/admin/slider/update/{image}', ['as' => 'admin::slider::update', 'uses' => 'Admin\SliderImageController@getUpdate']);
Route::post('/admin/slider/update/{image}', ['as' => 'admin::slider::update', 'uses' => 'Admin\SliderImageController@postUpdate']);
Route::get('/admin/slider/delete/{image}', ['as' => 'admin::slider::delete', 'uses' => 'Admin\SliderImageController@getDelete']);
Route::post('/admin/slider/delete/{image}', ['as' => 'admin::slider::delete', 'uses' => 'Admin\SliderImageController@postDelete']);

Route::get('/admin/revision/read/{id}', ['as' => 'admin::revision::read', 'uses' => 'Admin\RevisionController@getRead']);

Route::get('/admin/log/list', ['as' => 'admin::log::list', 'uses' => 'Admin\LogController@getList']);
Route::get('/admin/log/read/{id}', ['as' => 'admin::log::read', 'uses' => 'Admin\LogController@getRead']);

Route::get('/admin/transaction/list', ['as' => 'admin::transaction::list', 'uses' => 'Admin\TransactionController@getList']);
Route::get('/admin/transaction/read/{transaction}', ['as' => 'admin::transaction::read', 'uses' => 'Admin\TransactionController@getRead']);

Route::get('/admin/style', ['as' => 'admin::style::read', 'uses' => 'Admin\StyleController@getRead']);
