<?php

Route::group(['domain' => config('app.domain.content')], function () {
    Route::get('/image/.png', 'System\SystemController@getImage');
    Route::get('/image/{id}.png', ['as' => 'system::image', 'uses' => 'System\SystemController@getImage', 'before' => 'cache']);
    Route::get('/image-download/{id}.png', ['as' => 'system::image_download', 'uses' => 'System\SystemController@getImageDownload', 'before' => 'cache']);
    Route::get('/file/{id}', ['as' => 'system::file', 'uses' => 'System\SystemController@getFile']);
    Route::get('/product-colors/{id}', ['as' => 'system::product_colors', 'uses' => 'System\SystemController@getProductColors']);
    Route::get('/download/order{id}.pdf', ['as' => 'customer_block::order_form', 'uses' => 'Customer\Blocks\SendPrinterController@getDownload']);
    Route::get('/ajax/design-gallery/recent', ['as' => 'system::design_gallery_recent', 'uses' => 'System\SystemController@getDesignGalleryRecent']);
    Route::get('/ajax/design-gallery/{id}/related', ['as' => 'system::design_gallery_related', 'uses' => 'System\SystemController@getDesignGalleryRelated']);
    Route::get('/ajax/design-gallery/trending', ['as' => 'system::design_gallery_trending', 'uses' => 'System\SystemController@getDesignGalleryTrending']);
    Route::get('/ajax/design-gallery/tag/search', ['as' => 'system::design_gallery_tag_search', 'uses' => 'System\SystemController@getDesignGalleryTagSearch']);

    // Report Downloads
    Route::get('/report/campaign_sales/{id}', ['as' => 'report::campaign_sales', 'uses' => 'Report\ReportController@getCampaignSales']);
    Route::get('/report/campaign_fulfillment/{id}', ['as' => 'report::campaign_fulfillment', 'uses' => 'Report\ReportController@getCampaignFulfillment']);

    Route::get('/order/ajax/image/{id}', ['as' => 'campaign::ajax_image', 'uses' => 'Home\CampaignController@getAjaxColorImage']);
});
