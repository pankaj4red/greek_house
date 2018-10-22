<?php

Route::group(['domain' => config('app.domain.main')], function () {
    Auth::routes();

    include 'web/campus_manager.php';
    include 'web/ambassador.php';
    include 'web/work_with_us.php';
    include 'web/home.php';
    include 'web/admin.php';
    include 'web/custom_store.php';

    include 'web/oauth.php';

    Route::get('/health-check', function () {
        user_repository()->first();

        return response('It is up', 200);
    });

    Route::get('/send-activation/{id}', ['as' => 'send_activation', 'uses' => 'Auth\AuthController@getSendActivation']);
    Route::get('/activate-account/{email}/{code}', ['as' => 'activate_account', 'uses' => 'Auth\AuthController@getActivateAccount']);

    // Customer Area
    Route::get('/signup/customer/information/{campus?}', ['as' => 'signup_customer::step1', 'uses' => 'Home\SignupCustomerController@getStep1']);
    Route::post('/signup/customer/information/{campus?}', 'Home\SignupCustomerController@postStep1');
    Route::get('/signup/customer/video', ['as' => 'signup_customer::step2', 'uses' => 'Home\SignupCustomerController@getStep2']);
    Route::get('/signup/customer/success', ['as' => 'signup_customer::step3', 'uses' => 'Home\SignupCustomerController@getStep3']);
    Route::get('/signup/customer/tos', ['as' => 'signup_customer::tos', 'uses' => 'Home\SignupCustomerController@getTos']);

    // Campus Ambassador Area
    Route::get('/sales/{campus?}', function ($campus = null) {
        return Redirect::to('/signup/membership/information'.($campus ? '/'.$campus : ''), 301);
    });
    Route::get('/signup/sales/information/{campus?}', function ($campus = null) {
        return Redirect::to('/signup/membership/information'.($campus ? '/'.$campus : ''), 301);
    });
    Route::get('/signup/sales/video', function () {
        return Redirect::to('/signup/membership/video', 301);
    });
    Route::get('/signup/sales/success', function () {
        return Redirect::to('/signup/membership/success', 301);
    });
    Route::get('/signup/sales/tos', function () {
        return Redirect::to('/signup/membership/tos', 301);
    });
    Route::post('/signup/sales/information/{campus?}', 'Home\SignupSalesRepController@postStep1');

    Route::get('/signup/membership/information/{campus?}', ['as' => 'signup_sales_rep::step1', 'uses' => 'Home\SignupSalesRepController@getStep1']);
    Route::post('/signup/membership/information/{campus?}', 'Home\SignupSalesRepController@postStep1');
    Route::get('/signup/membership/video', ['as' => 'signup_sales_rep::step2', 'uses' => 'Home\SignupSalesRepController@getStep2']);
    Route::get('/signup/membership/success', ['as' => 'signup_sales_rep::step3', 'uses' => 'Home\SignupSalesRepController@getStep3']);
    Route::get('/signup/membership/tos', ['as' => 'signup_sales_rep::tos', 'uses' => 'Home\SignupSalesRepController@getTos']);

    // Campus Manager Area
    Route::get('/campus', function () {
        return Redirect::to('/signup/campus', 301);
    });
    Route::get('/signup/campus', ['as' => 'signup_account_manager::step1', 'uses' => 'Home\SignupAccountManagerController@getStep1']);
    Route::post('/signup/campus', 'Home\SignupAccountManagerController@postStep1');
    Route::get('/signup/campus/contract', ['as' => 'signup_account_manager::step2', 'uses' => 'Home\SignupAccountManagerController@getStep2']);
    Route::get('/signup/campus/video', ['as' => 'signup_account_manager::step3', 'uses' => 'Home\SignupAccountManagerController@getStep3']);
    Route::get('/signup/campus/success', ['as' => 'signup_account_manager::step4', 'uses' => 'Home\SignupAccountManagerController@getStep4']);
    Route::get('/signup/campus/tos', ['as' => 'signup_account_manager::tos', 'uses' => 'Home\SignupAccountManagerController@getTos']);

    // Order Area
    Route::get('/start-here/{id?}', function ($id = null) {
        return Redirect::to('/wizard', 301);
    });
    Route::get('/start-here-1', function () {
        return Redirect::to('/wizard', 301);
    });
    Route::get('/start-here-2/{genderId}', function ($genderId) {
        return Redirect::to('/wizard', 301);
    });
    Route::get('/start-here-3/{genderId}/{categoryId}', function ($genderId, $categoryId) {
        return Redirect::to('/wizard', 301);
    });
    Route::get('/start-here-4/{id}', function ($id) {
        return Redirect::to('/wizard/product/'.$id, 301);
    });
    Route::get('/start-here-5', function () {
        return Redirect::to('/wizard', 301);
    });
    Route::get('/start-here-6', function () {
        return Redirect::to('/wizard', 301);
    });
    Route::get('/start-here-7', function () {
        return Redirect::to('/wizard', 301);
    });
    Route::get('/start-here-8', function () {
        return Redirect::to('/wizard', 301);
    });
    Route::get('/start-here-review', function () {
        return Redirect::to('/wizard', 301);
    });
    Route::get('/start-here-success', function () {
        return Redirect::to('/wizard', 301);
    });

    Route::get('/wizard/product/category/{id?}', [
        'as' => 'wizard::product_category',
        function ($id, \Illuminate\Http\Request $request) {
            $controller = App::make('App\Http\Controllers\Home\WizardController');

            return $controller->getProduct($request, $id, 'category');
        },
    ]);

    // Wizard
    Route::post('/wizard/product/category/{id?}', ['uses' => 'Home\WizardController@postProduct']);
    Route::get('/wizard/product/{id?}', [
        'as' => 'wizard::product',
        function (\Illuminate\Http\Request $request, $id = null) {
            $controller = App::make('App\Http\Controllers\Home\WizardController');

            if ($id) {
                return $controller->getProduct($request, $id, 'product');
            } else {
                return $controller->getProduct($request, $id, 'category');
            }
        },
    ]);
    Route::post('/wizard/product/{id?}', ['uses' => 'Home\WizardController@postProduct']);
    Route::get('/wizard/design', ['as' => 'wizard::design', 'uses' => 'Home\WizardController@getDesign']);
    Route::post('/wizard/design', ['uses' => 'Home\WizardController@postDesign']);
    Route::get('/wizard/order', ['as' => 'wizard::order', 'uses' => 'Home\WizardController@getOrder']);
    Route::post('/wizard/order', ['uses' => 'Home\WizardController@postOrder']);
    Route::get('/wizard/delivery', ['as' => 'wizard::delivery', 'uses' => 'Home\WizardController@getDelivery']);
    Route::post('/wizard/delivery', ['uses' => 'Home\WizardController@postDelivery']);
    Route::get('/wizard/review', ['as' => 'wizard::review', 'uses' => 'Home\WizardController@getReview']);
    Route::post('/wizard/review', ['uses' => 'Home\WizardController@postReview']);
    Route::get('/wizard/success/{userCount?}/{id?}', ['as' => 'wizard::success', 'uses' => 'Home\WizardController@getSuccess']);
    Route::get('/wizard/{designId?}', ['as' => 'wizard::start', 'uses' => 'Home\WizardController@getStart']);
    Route::get('/wizard/ajax/products', ['as' => 'wizard::ajax::product', 'uses' => 'Home\WizardController@getAjaxProducts']);
    Route::get('/wizard/ajax/product-detail/{id}', ['as' => 'wizard::ajax::product_detail', 'uses' => 'Home\WizardController@getAjaxProductDetail']);
    Route::get('/ajax/wizard-products/{categoryId}', ['as' => 'wizard::ajax:category', 'uses' => 'Home\WizardController@getAjaxCategory']);
    Route::get('/ajax/wizard-products-search/', ['as' => 'wizard::ajax:search', 'uses' => 'Home\WizardController@getAjaxSearch']);

    Route::get('/garment-category/{genderId}', ['as' => 'system::categories', 'uses' => 'System\SystemController@getGarmentCategory']);
    Route::get('/garment-brand/{genderId}/{categoryId}', ['as' => 'system::brands', 'uses' => 'System\SystemController@getGarmentBrand']);
    Route::get('/quick-quote/{type}', ['as' => 'system::quick_quote', 'uses' => 'System\SystemController@getQuickQuote']);
    Route::get('/quick-quote-manager/{type}', ['as' => 'system::quick_manager_quote', 'uses' => 'System\SystemController@getManagerQuickQuote']);
    Route::get('/autocomplete/school', ['as' => 'system::autocomplete_school', 'uses' => 'System\SystemController@getAutocompleteSchool']);
    Route::get('/autocomplete/chapter/{school?}', ['as' => 'system::autocomplete_chapter', 'uses' => 'System\SystemController@getAutocompleteChapter']);
    Route::get('/autocomplete/user', ['as' => 'system::autocomplete_user', 'uses' => 'System\SystemController@getAutocompleteUser']);
    Route::get('/salesforce-oauth', ['as' => 'system::salesforce_oauth', 'uses' => 'System\SystemController@getSalesforceOauth']);
    Route::get('/hash/{id}', ['as' => 'system::hash', 'uses' => 'System\SystemController@getHash']);
    Route::get('/system/error', ['as' => 'system::error', 'uses' => 'System\SystemStealthController@getError']);
    Route::get('/system/logic-error', ['as' => 'system::logic_error', 'uses' => 'System\SystemStealthController@getLogicError']);
    Route::get('/estimated-quantities/{type}', ['uses' => 'System\SystemController@getEstimatedQuantities', 'as' => 'system::estimated_quantities']);

    // Profile Area
    Route::get('/profile', ['as' => 'profile::index', 'uses' => 'Customer\ProfileController@getIndex']);
    Route::get('/profile/edit-information', ['as' => 'profile::edit_information', 'uses' => 'Customer\ProfileController@getEditInformation']);
    Route::post('/profile/edit-information', 'Customer\ProfileController@postEditInformation');
    Route::get('/profile/add-address', ['as' => 'profile::add_address', 'uses' => 'Customer\ProfileController@getAddAddress']);
    Route::post('/profile/add-address', 'Customer\ProfileController@postAddAddress');
    Route::get('/profile/edit-address/{id}', ['as' => 'profile::edit_address', 'uses' => 'Customer\ProfileController@getEditAddress']);
    Route::post('/profile/edit-address/{id}', 'Customer\ProfileController@postEditAddress');
    Route::get('/profile/add-address', ['as' => 'profile::add_address', 'uses' => 'Customer\ProfileController@getAddAddress']);
    Route::post('/profile/add-address', 'Customer\ProfileController@postAddAddress');
    Route::post('/profile/toggle', ['as' => 'profile::toggle_decorator_status', 'uses' => 'Customer\ProfileController@postToggleDecoratorStatus']);

    // Referrals
    Route::get('/referrals', ['as' => 'referral::index', 'uses' => 'Customer\ReferralController@getIndex']);

    // Dashboard Area
    Route::get('/dashboard/{option?}', ['as' => 'dashboard::index', 'uses' => 'Customer\DashboardController@getIndex']);
    Route::get('/campaign/{id}/{view?}', ['as' => 'dashboard::details', 'uses' => 'Customer\DashboardController@getDetails']);
    Route::get('/grab-campaign/{id}', ['as' => 'dashboard::grab', 'uses' => 'Customer\DashboardController@getGrab']);
    Route::post('/reject-campaign/{id}', ['as' => 'dashboard::reject', 'uses' => 'Customer\DashboardController@postReject']);
    Route::post('/dashboard/message/{id}', ['as' => 'dashboard::customer_message', 'uses' => 'Customer\DashboardController@postCustomerMessage']);
    Route::post('/dashboard/close_date/{id}', ['as' => 'dashboard::close_date', 'uses' => 'Customer\DashboardController@postCloseDate']);
    Route::post('/dashboard/change_state/{id}', ['as' => 'dashboard::change_state', 'uses' => 'Customer\DashboardController@postChangeState']);
    Route::post('/dashboard/notes/{id}', ['as' => 'dashboard::notes', 'uses' => 'Customer\DashboardController@postNotes']);
    Route::post('/dashboard/print_file_delete/{campaignId}/{fileId}', ['as' => 'dashboard::print_file_delete', 'uses' => 'Customer\DashboardController@postPrintFileDelete']);
    Route::post('/dashboard/print_file_upload/{campaignId}', ['as' => 'dashboard::print_file_upload', 'uses' => 'Customer\DashboardController@postPrintFileUpload']);

    Route::get('/report/campaign_shipping_file/{id}', ['as' => 'report::campaign_shipping_file', 'uses' => 'Report\ReportController@getShippingFile']);
    Route::get('/report/campaign_shipping_pdf/{id}', ['as' => 'report::campaign_shipping_pdf', 'uses' => 'Report\ReportController@getShippingPdf']);

    // Art Director
    Route::get('/art-director', ['as' => 'art_director::index', 'uses' => 'Customer\ArtDirectorController@getIndex']);
    Route::get('/art-director/unclaimed', ['as' => 'art_director::unclaimed', 'uses' => 'Customer\ArtDirectorController@getUnclaimed']);
    Route::get('/art-director/awaiting_for_designer', [
        'as' => 'art_director::awaiting_for_designer',
        'uses' => 'Customer\ArtDirectorController@getAwaitingForDesigner',
    ]);
    Route::get('/art-director/customer', [
        'as' => 'art_director::awaiting_for_customer',
        'uses' => 'Customer\ArtDirectorController@getAwaitingForCustomer',
    ]);
    Route::get('/art-director/files', ['as' => 'art_director::upload_files', 'uses' => 'Customer\ArtDirectorController@getUploadFiles']);
    Route::get('/art-director/done', ['as' => 'art_director::done', 'uses' => 'Customer\ArtDirectorController@getDone']);
    Route::get('/art-director/designer/{id?}', ['as' => 'art_director::designer', 'uses' => 'Customer\ArtDirectorController@getDesigner']);
    Route::get('/art-director/designer/log-in-as/{id}', ['as' => 'art_director::log_in_as', 'uses' => 'Customer\ArtDirectorController@getLogInAs']);

    // Account Manager
    Route::get('/account-manager/accounts', ['as' => 'account_manager::accounts', 'uses' => 'Customer\AccountManagerController@getAccounts']);
    Route::get('/account-manager/account/{id}', ['as' => 'account_manager::account', 'uses' => 'Customer\AccountManagerController@getAccount']);
    Route::get('/account-manager/share', ['as' => 'account_manager::share', 'uses' => 'Customer\AccountManagerController@getShare']);

    Route::post('/dashboard/cblock/{block}/{id}', [
        'as' => 'customer_block',
        function ($block, $id, \Illuminate\Http\Request $request) {
            $controller = App::make('App\Http\Controllers\Customer\Blocks\\'.to_camel($block).'Controller');

            return $controller->handlePostBlock($id, $request);
        },
    ]);

    Route::post('/dashboard/module/{block}/{id}', [
        'as' => 'customer_module',
        function ($block, $id, \Illuminate\Http\Request $request) {
            $controller = App::make('App\Http\Controllers\Customer\Modules\\'.to_camel($block).'Controller');

            return $controller->handlePostBlock($id, $request);
        },
    ]);

    Route::get('/dashboard/pblock/{block}/{id}/{method?}', [
        'as' => 'customer_block_popup',
        function ($block, $id, $method = null, \Illuminate\Http\Request $request) {
            $controller = App::make('App\Http\Controllers\Customer\Blocks\\'.to_camel($block).'Controller');
            if ($method == null) {
                return $controller->handlePopup($id);
            } else {
                if (! method_exists($controller, 'get'.ucfirst(camel_case($method)))) {
                    abort(404);
                }

                return $controller->handleGetMethod(ucfirst(camel_case($method)), $id, $request);
            }
        },
    ]);
    Route::post('/dashboard/pblock/{block}/{id}/{method?}', [
        'as' => 'customer_block_popup',
        function ($block, $id, $method = null, \Illuminate\Http\Request $request) {
            $controller = App::make('App\Http\Controllers\Customer\Blocks\\'.to_camel($block).'Controller');
            if ($method == null) {
                return $controller->handlePostPopup($id, $request);
            } else {
                if (! method_exists($controller, 'post'.ucfirst(camel_case($method)))) {
                    abort(404);
                }

                return $controller->handlePostMethod(ucfirst(camel_case($method)), $id, $request);
            }
        },
    ]);

    Route::get('/dashboard/module-popup/{block}/{id}/{method?}', [
        'as' => 'customer_module_popup',
        function ($block, $id, $method = null, \Illuminate\Http\Request $request) {
            $controller = App::make('App\Http\Controllers\Customer\Modules\\'.to_camel($block).'Controller');
            if ($method == null) {
                return $controller->handlePopup($id);
            } else {
                if (! method_exists($controller, 'get'.ucfirst(camel_case($method)))) {
                    abort(404);
                }

                return $controller->handleGetMethod(ucfirst(camel_case($method)), $id, $request);
            }
        },
    ]);
    Route::post('/dashboard/module-popup/{block}/{id}/{method?}', [
        'as' => 'customer_module_popup',
        function ($block, $id, $method = null, \Illuminate\Http\Request $request) {
            $controller = App::make('App\Http\Controllers\Customer\Modules\\'.to_camel($block).'Controller');
            if ($method == null) {
                return $controller->handlePostPopup($id, $request);
            } else {
                if (! method_exists($controller, 'post'.ucfirst(camel_case($method)))) {
                    abort(404);
                }

                return $controller->handlePostMethod(ucfirst(camel_case($method)), $id, $request);
            }
        },
    ]);

    Route::get('/dashboard/cblock/garment_information/{id}', [
        'as' => 'customer_block::garment_information',
        'uses' => 'Customer\CustomerBlockController@getGarmentInformation',
    ]);
    Route::post('/dashboard/cblock/garment_information/{id}', 'Customer\CustomerBlockController@postGarmentInformation');
    Route::get('/dashboard/cblock/customer_information/{id}', [
        'as' => 'customer_block::customer_information',
        'uses' => 'Customer\CustomerBlockController@getCustomerInformation',
    ]);
    Route::post('/dashboard/cblock/customer_information/{id}', 'Customer\CustomerBlockController@postCustomerInformation');
    Route::get('/dashboard/cblock/shipping_information/{id}', [
        'as' => 'customer_block::shipping_information',
        'uses' => 'Customer\CustomerBlockController@getShippingInformation',
    ]);
    Route::post('/dashboard/cblock/shipping_information/{id}', 'Customer\CustomerBlockController@postShippingInformation');
    Route::get('/dashboard/cblock/shipping_types/{id}', ['as' => 'customer_block::shipping_types', 'uses' => 'Customer\CustomerBlockController@getShippingTypes']);
    Route::post('/dashboard/cblock/shipping_types/{id}', 'Customer\CustomerBlockController@postShippingTypes');
    Route::get('/dashboard/cblock/campaign_information/{id}', [
        'as' => 'customer_block::campaign_information',
        'uses' => 'Customer\CustomerBlockController@getCampaignInformation',
    ]);
    Route::post('/dashboard/cblock/campaign_information/{id}', 'Customer\CustomerBlockController@postCampaignInformation');
    Route::get('/dashboard/cblock/upload_proofs/{id}', ['as' => 'customer_block::upload_proofs', 'uses' => 'Customer\CustomerBlockController@getUploadProofs']);
    Route::post('/dashboard/cblock/upload_proofs/{id}', 'Customer\CustomerBlockController@postUploadProofs');
    Route::get('/dashboard/cblock/upload_prints/{id}', ['as' => 'customer_block::upload_prints', 'uses' => 'Customer\CustomerBlockController@getUploadPrints']);
    Route::post('/dashboard/cblock/upload_prints/{id}', 'Customer\CustomerBlockController@postUploadPrints');
    Route::get('/dashboard/cblock/request_revision/{id}', ['as' => 'customer_block::request_revision', 'uses' => 'Customer\CustomerBlockController@getRequestRevision']);
    Route::post('/dashboard/cblock/request_revision/{id}', 'Customer\CustomerBlockController@postRequestRevision');
    Route::get('/dashboard/cblock/approve_design/{id}', ['as' => 'customer_block::approve_design', 'uses' => 'Customer\CustomerBlockController@getApproveDesign']);
    Route::post('/dashboard/cblock/approve_design/{id}', 'Customer\CustomerBlockController@postApproveDesign');
    Route::post('/dashboard/cblock/garment-information-step1/{id}', [
        'as' => 'customer_block::garment_information_step1',
        'uses' => 'Customer\CustomerBlockController@postGarmentInformationStep1',
    ]);
    Route::post('/dashboard/cblock/garment-information-step2/{id}', [
        'as' => 'customer_block::garment_information_step2',
        'uses' => 'Customer\CustomerBlockController@postGarmentInformationStep2',
    ]);
    Route::post('/dashboard/cblock/garment-information-step3/{id}', [
        'as' => 'customer_block::garment_information_step3',
        'uses' => 'Customer\CustomerBlockController@postGarmentInformationStep3',
    ]);
    Route::get('/dashboard/cblock/provide_quote/{id}', ['as' => 'customer_block::provide_quote', 'uses' => 'Customer\CustomerBlockController@getProvideQuote']);
    Route::post('/dashboard/cblock/provide_quote/{id}', 'Customer\CustomerBlockController@postProvideQuote');
    Route::get('/dashboard/cblock/sales/{id}', ['as' => 'customer_block::sales', 'uses' => 'Customer\CustomerBlockController@getSales']);
    Route::get('/dashboard/cblock/download-sales/{id}', ['as' => 'customer_block::download_sales', 'uses' => 'Customer\CustomerBlockController@getDownloadSales']);
    Route::get('/dashboard/cblock/embellishment/{id}', ['as' => 'customer_block::embellishment', 'uses' => 'Customer\CustomerBlockController@getEmbellishment']);
    Route::post('/dashboard/cblock/embellishment/{id}', 'Customer\CustomerBlockController@postEmbellishment');
    Route::get('/dashboard/cblock/send_printer/{id}', ['as' => 'customer_block::send_printer', 'uses' => 'Customer\CustomerBlockController@getSendPrinter']);
    Route::post('/dashboard/cblock/send_printer/{id}', 'Customer\CustomerBlockController@postSendPrinter');
    Route::get('/dashboard/cblock/review_send_printer/{id}', [
        'as' => 'customer_block::review_send_printer',
        'uses' => 'Customer\CustomerBlockController@getReviewSendPrinter',
    ]);
    Route::post('/dashboard/cblock/evaluate_proofs/{id}', ['as' => 'customer_block::evaluate_proofs', 'uses' => 'Customer\CustomerBlockController@postEvaluateProofs']);
    Route::get('/dashboard/cblock/approve_garment/{id}', ['as' => 'customer_block::approve_garment', 'uses' => 'Customer\CustomerBlockController@getApproveGarment']);
    Route::post('/dashboard/cblock/approve_garment/{id}', 'Customer\CustomerBlockController@postApproveGarment');
    Route::get('/dashboard/cblock/request_garment_revision/{id}', [
        'as' => 'customer_block::request_garment_revision',
        'uses' => 'Customer\CustomerBlockController@getRequestGarmentRevision',
    ]);
    Route::post('/dashboard/cblock/request_garment_revision/{id}', 'Customer\CustomerBlockController@postRequestGarmentRevision');
    Route::get('/dashboard/cblock/request_artwork_revision/{id}', [
        'as' => 'customer_block::request_artwork_revision',
        'uses' => 'Customer\CustomerBlockController@getRequestArtworkRevision',
    ]);
    Route::post('/dashboard/cblock/request_artwork_revision/{id}', 'Customer\CustomerBlockController@postRequestArtworkRevision');
    Route::get('/dashboard/cblock/approve_artwork/{id}', ['as' => 'customer_block::approve_artwork', 'uses' => 'Customer\CustomerBlockController@getApproveArtwork']);
    Route::post('/dashboard/cblock/approve_artwork/{id}', 'Customer\CustomerBlockController@postApproveArtwork');
    Route::get('/dashboard/cblock/customer_promise/{id}', ['as' => 'customer_block::customer_promise', 'uses' => 'Customer\CustomerBlockController@getCustomerPromise']);
    Route::post('/dashboard/cblock/customer_promise/{id}', 'Customer\CustomerBlockController@postCustomerPromise');
    Route::get('/dashboard/cblock/change_garment_information/{id}', [
        'as' => 'customer_block::change_garment_information',
        'uses' => 'Customer\CustomerBlockController@getChangeGarmentInformation',
    ]);
    Route::post('/dashboard/cblock/change_garment_information/{id}', 'Customer\CustomerBlockController@postChangeGarmentInformation');
    Route::get('/dashboard/cblock/change_garment/{id}', ['as' => 'customer_block::change_garment', 'uses' => 'Customer\CustomerBlockController@getChangeGarment']);
    Route::post('/dashboard/cblock/change_garment/{id}', 'Customer\CustomerBlockController@postChangeGarment');
    Route::get('/dashboard/cblock/reset_print_date/{id}', ['as' => 'customer_block::reset_print_date', 'uses' => 'Customer\CustomerBlockController@getResetPrintDate']);
    Route::post('/dashboard/cblock/reset_print_date/{id}', 'Customer\CustomerBlockController@postResetPrintDate');
    Route::get('/dashboard/cblock/mark_delivered/{id}', ['as' => 'customer_block::mark_delivered', 'uses' => 'Customer\CustomerBlockController@getMarkDelivered']);
    Route::post('/dashboard/cblock/mark_delivered/{id}', 'Customer\CustomerBlockController@postMarkDelivered');

    // Old Checkout Redirects
    Route::get('/checkout-individual/{id}', function ($id) {
        return Redirect::to('/store/'.product_to_description($id), 301);
    });
    Route::get('/checkout/start/{id}/{paymentType}', function ($id, $paymentType) {
        return Redirect::to('/store/'.product_to_description($id).($paymentType == 'group' ? '?group' : ''), 301);
    });
    Route::get('/checkout/step1/{id}/{paymentType}', function ($id, $paymentType) {
        return Redirect::to('/store/'.product_to_description($id).($paymentType == 'group' ? '?group' : ''), 301);
    });
    Route::get('/checkout/step2/{id}/{paymentType}', function ($id, $paymentType) {
        return Redirect::to('/store/'.product_to_description($id).($paymentType == 'group' ? '?group' : ''), 301);
    });
    Route::get('/checkout/step3/{id}/{paymentType}', function ($id, $paymentType) {
        return Redirect::to('/store/'.product_to_description($id).($paymentType == 'group' ? '?group' : ''), 301);
    });
    Route::get('/checkout/step4/{id}', function ($id) {
        $order = order_repository()->find($id);
        if ($order == null) {
            abort(404);
        }

        return Redirect::to('/store/'.product_to_description($order->campaign_id).'/'.$order->id, 301);
    });

    Route::get('/test', ['as' => 'test:test', 'uses' => 'Test\TestController@getTest']);
    Route::post('/test', ['uses' => 'Test\TestController@postTest']);
    Route::get('/dividebyzero', ['as' => 'test:error', 'uses' => 'Test\TestController@error']);
    Route::get('/test-block/{id}/{block}', ['as' => 'test:block', 'uses' => 'Test\TestController@block']);
    Route::get('/sendemail/{ruleName}/{campaignId}', ['as' => 'test:send_email', 'uses' => 'Test\TestController@sendEmail']);
    Route::get('/dividebyzero/{id?}', ['as' => 'test:error', 'uses' => 'Test\TestController@error']);
    Route::get('/errors/403', function () {
        return view('errors.403');
    });
    Route::get('/errors/404', function () {
        return view('errors.404');
    });
    Route::get('/errors/500', function () {
        return view('errors.500');
    });
    Route::get('/errors/503', function () {
        return view('errors.503');
    });

    // Old routes that still work
    Route::get('/workorder/accept/{id}/ind/process', function ($id) {
        return Redirect::to('/checkout-individual/'.$id, 301);
    });
    Route::get('/jobs', function () {
        return Redirect::to('/work-with-us', 301);
    });
    Route::get('/designs-gallery', function () {
        return Redirect::to('/design-gallery', 301);
    });

    // Old routes that no longer work
    Route::get('/orderform', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/orderform/{any}', function () {
        abort(404, 'Resource no longer exists');
    })->where('any', '.*');
    Route::get('/product/node/nojs/complete/{id}', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/manage/dashboard', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/node/{id}', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/node', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/sites/{any}', function () {
        abort(404, 'Resource no longer exists');
    })->where('any', '.*');
    Route::get('/user/{any}', function () {
        abort(404, 'Resource no longer exists');
    })->where('any', '.*');
    Route::get('/misc/{any}', function () {
        abort(404, 'Resource no longer exists');
    })->where('any', '.*');
    Route::get('/category/{any}', function () {
        abort(404, 'Resource no longer exists');
    })->where('any', '.*');
    Route::get('/taxonomy/{any}', function () {
        abort(404, 'Resource no longer exists');
    })->where('any', '.*');
    Route::get('/cart', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/greek-house-privacy-policy', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/greek-house-shipping-returns', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/greek-house-refunds-returns', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/greek-house-terms-of-service', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/greek-house-terms-of-service{any}', function () {
        abort(404, 'Resource no longer exists');
    })->where('any', '.*');
    Route::get('/%E2%80%A6/American-Apparel-Tank-Delta-Gam', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/th1s_1s_a_4o4.html', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/wp-{any}', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/LiveSearchSiteAuth.xml', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/bingsiteauth.xml', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/BingSiteAuth.xml', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/user', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/modules/{any}', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/the-benefits-of-our-free-artwork-system', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/pma{any}', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/feed', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/CFIDE/administrator', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/xmlrpc.php', function () {
        abort(404, 'Resource no longer exists');
    });
    Route::get('/feed', function () {
        abort(404, 'Resource no longer exists');
    });

    Route::get('/helpers/column', ['as' => 'helpers::column', 'uses' => 'Helpers\HelperController@getColumn']);
    Route::POST('/helpers/column', ['as' => 'helpers::column', 'uses' => 'Helpers\HelperController@postColumn']);
});

Route::group(['domain' => config('app.domain.content')], function () {
    Route::get('/image/.png', 'System\SystemController@getImage');
    Route::get('/image/{id}.png', ['as' => 'system::image', 'uses' => 'System\SystemController@getImage', 'before' => 'cache']);
    Route::get('/image-download/{id}.png', ['as' => 'system::image_download', 'uses' => 'System\SystemController@getImageDownload', 'before' => 'cache']);
    Route::get('/file/{id}', ['as' => 'system::file', 'uses' => 'System\SystemController@getFile']);
    Route::get('/product-colors/{id}', ['as' => 'system::product_colors', 'uses' => 'System\SystemController@getProductColors']);
    Route::get('/download/order{id}.pdf', ['as' => 'customer_block::order_form', 'uses' => 'Customer\Blocks\SendPrinterController@getDownload']);
    Route::get('/ajax/design-gallery/recent', ['as' => 'system::design_gallery_recent', 'uses' => 'System\SystemController@getDesignGalleryRecent']);
    Route::get('/ajax/design-gallery/trending', ['as' => 'system::design_gallery_trending', 'uses' => 'System\SystemController@getDesignGalleryTrending']);
    Route::get('/ajax/design-gallery/tag/search', ['as' => 'system::design_gallery_tag_search', 'uses' => 'System\SystemController@getDesignGalleryTagSearch']);

    // Report Downloads
    Route::get('/report/campaign_sales/{id}', ['as' => 'report::campaign_sales', 'uses' => 'Report\ReportController@getCampaignSales']);
    Route::get('/report/campaign_fulfillment/{id}', ['as' => 'report::campaign_fulfillment', 'uses' => 'Report\ReportController@getCampaignFulfillment']);

    Route::get('/order/ajax/image/{id}', ['as' => 'campaign::ajax_image', 'uses' => 'Home\CampaignController@getAjaxColorImage']);
});


//// Global Functionality
///** @noinspection PhpDeprecationInspection */
//Route::filter('cache', function () {
//    if (Request::header('If-Modified-Since')) {
//        return response('', 304)->setCache([
//            'max_age' => 259200,
//            'public' => true,
//            'last_modified' => new DateTime('2016-01-01')
//        ]);
//    }
//    return null;
//});
