<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'setting', 'namespace' => 'Modules\Setting\Http\Controllers'], function()
{
    Route::group(['prefix' => 'employee'], function(){
        Route::get('faq', 'SettingEmployeeController@faqList');
        Route::get('faq/popular', 'SettingEmployeeController@faqListPopular');
        Route::get('faq/create', 'SettingEmployeeController@faqCreate');
        Route::post('faq/save', 'SettingEmployeeController@faqStore');
        Route::get('faq/edit/{slug}', 'SettingEmployeeController@faqEdit');
        Route::post('faq/update/{slug}', 'SettingEmployeeController@faqUpdate');
        Route::any('faq/delete/{slug}', 'SettingEmployeeController@faqDelete');
        Route::any('faq/popular/{slug}', 'SettingEmployeeController@faqPopularCreate');
        Route::any('faq/popular/delete/{slug}', 'SettingEmployeeController@faqPopularDelete');
        Route::get('faq/sort', 'SettingEmployeeController@faqSort');
        Route::post('faq/sort/update', 'SettingEmployeeController@faqSortUpdate');
        Route::post('update/{slug}', 'SettingEmployeeController@settingUpdate');
      });
	Route::post('app_logo', 'SettingController@appLogoSave');
    Route::post('app_sidebar', 'SettingController@appSidebarSave');
    Route::post('app_navbar', 'SettingController@appNavbarSave');
    Route::post('user_inbox', 'SettingController@userInboxSave');
    Route::get('faq', 'SettingController@faqList');
    Route::get('faq/create', 'SettingController@faqCreate');
    Route::post('faq/save', 'SettingController@faqStore');
    Route::get('faq/edit/{slug}', 'SettingController@faqEdit');
    Route::post('faq/update/{slug}', 'SettingController@faqUpdate');
    Route::any('faq/delete/{slug}', 'SettingController@faqDelete');
    Route::get('faq/sort', 'SettingController@faqSort');
    Route::post('faq/sort/update', 'SettingController@faqSortUpdate');
    Route::post('update/{slug}', 'SettingController@settingUpdate');

    Route::post('social_media', 'SettingController@socialMediaSave');
    
    Route::get('intro/{key}', 'TutorialController@introList');
    Route::post('intro/save', 'TutorialController@introStore');

    Route::any('whatsapp', ['middleware' => 'config_control:74,75', 'uses' => 'SettingController@whatsApp']);
	
    /* complete profile */
    Route::any('complete-profile', ['middleware' => 'feature_control:148', 'uses' => 'SettingController@completeProfile']);

    /* confirmation messages */
    Route::any('confirmation-messages','SettingController@confirmationMessages');

    /* confirmation messages */
    Route::any('otp-messages','SettingController@otpMessages');

    /*Text menu*/
    Route::any('text_menu', 'SettingController@textMenu');
    Route::post('text_menu/update/{category}', 'SettingController@updateTextMenu');

    /*Setting Phone*/
    Route::get('phone', 'SettingController@phoneNumberSetting');
    Route::post('phone/update', 'SettingController@updatePhoneNumberSetting');

    /*maintenance mode*/
    Route::any('maintenance-mode', 'SettingController@maintenanceMode');

    /*Setting Expired time OTP and Email*/
    Route::any('time-expired', 'SettingController@timeExpired');

    Route::any('outletapp', 'SettingController@outletAppSetting');
    Route::post('outletapp/splash-screen', 'SettingController@splashScreenOutletApps');

	Route::any('mitra-apps', 'SettingController@employeeAppsSetting');
    Route::post('mitra-apps/splash-screen', 'SettingController@splashScreenMitraApps');   

	Route::any('employee-apps', 'SettingController@mitraAppsSetting');
    Route::post('employee-apps/splash-screen', 'SettingController@splashScreenEmployeeApps');   
    
    //logo confirmation letter
    Route::any('/logo-confir', ['middleware' => 'feature_control:343', 'uses' => 'SettingController@confirmationLogoPDF']);

    //code icount
    Route::any('/setting-icount', ['middleware' => 'feature_control:392', 'uses' => 'SettingController@setting_icount']);
    
    //global commission
    Route::any('/setting-global-commission', ['middleware' => 'feature_control:423', 'uses' => 'SettingController@settingGlobalCommission']);
    Route::post('/setting-global-commission/refresh', ['middleware' => 'feature_control:423', 'uses' => 'SettingController@settingGlobalCommissionRefresh']);
    
    //salary formula
    Route::any('/setting-salary-formula', ['middleware' => 'feature_control:424', 'uses' => 'SettingController@salary_formula']);
    
    //attendances_date
    Route::any('/setting-attendances-date', ['middleware' => 'feature_control:427', 'uses' => 'SettingController@attendances_date']);
   
    Route::any('home', 'SettingController@homeSetting');
	Route::any('date', 'SettingController@dateSetting');
    Route::get('{key}', 'SettingController@settingList');
	
	Route::any('background/create', ['middleware' => 'config_control:30,32', 'uses' => 'SettingController@createBackground']);
    Route::any('background/delete', ['middleware' => 'config_control:30,32', 'uses' => 'SettingController@deleteBackground']);
    Route::any('greeting/create', ['middleware' => 'config_control:30,31', 'uses' => 'SettingController@createGreeting']);
    Route::any('greeting/update/{slug}', ['middleware' => 'config_control:30,31', 'uses' => 'SettingController@updateGreetings']);
    Route::post('greeting/delete', ['middleware' => 'config_control:30,31', 'uses' => 'SettingController@deleteGreetings']);

    Route::post('default_home', 'SettingController@defaultHomeSave');
    
    Route::any('home/user', 'SettingController@dashboardSetting');
    Route::post('dashboard/delete', 'SettingController@deleteDashboard');
    Route::post('dashboard/ajax', 'SettingController@updateDashboardAjax');
    Route::post('dashboard/default-date', 'SettingController@updateDateRange');
    Route::post('dashboard/visibility-section', 'SettingController@visibilityDashboardSection');
    Route::post('dashboard/order-section', 'SettingController@orderDashboardSection');
    Route::post('dashboard/order-card', 'SettingController@orderDashboardCard');

    /* banner */
    Route::post('banner/create', ['middleware' => 'feature_control:145', 'uses' => 'SettingController@createBanner']);
    Route::post('banner/update', ['middleware' => 'feature_control:146', 'uses' => 'SettingController@updateBanner']);
    Route::post('banner/reorder', ['middleware' => 'feature_control:146', 'uses' => 'SettingController@reorderBanner']);
    Route::get('banner/delete/{slug}', ['middleware' => 'feature_control:147', 'uses' => 'SettingController@deleteBanner']);

    /* featured_deal */
    Route::post('featured_deal/create', ['middleware' => 'feature_control:145', 'uses' => 'SettingController@createFeaturedDeal']);
    Route::post('featured_deal/update', ['middleware' => 'feature_control:146', 'uses' => 'SettingController@updateFeaturedDeal']);
    Route::post('featured_deal/reorder', ['middleware' => 'feature_control:146', 'uses' => 'SettingController@reorderFeaturedDeal']);
    Route::get('featured_deal/delete/{slug}', ['middleware' => 'feature_control:147', 'uses' => 'SettingController@deleteFeaturedDeal']);

    /* featured subscription */
    Route::post('featured_subscription/create', ['middleware' => 'feature_control:242', 'uses' => 'SettingController@createFeaturedSubscription']);
    Route::post('featured_subscription/update', ['middleware' => 'feature_control:243', 'uses' => 'SettingController@updateFeaturedSubscription']);
    Route::post('featured_subscription/reorder', ['middleware' => 'feature_control:243', 'uses' => 'SettingController@reorderFeaturedSubscription']);
    Route::get('featured_subscription/delete/{slug}', ['middleware' => 'feature_control:244', 'uses' => 'SettingController@deleteFeaturedSubscription']);

    /* featured promo campaign */
    Route::post('featured_promo_campaign/create', ['middleware' => 'feature_control:145', 'uses' => 'SettingController@createFeaturedPromoCampaign']);
    Route::post('featured_promo_campaign/update', ['middleware' => 'feature_control:146', 'uses' => 'SettingController@updateFeaturedPromoCampaign']);
    Route::post('featured_promo_campaign/reorder', ['middleware' => 'feature_control:146', 'uses' => 'SettingController@reorderFeaturedPromoCampaign']);
    Route::get('featured_promo_campaign/delete/{slug}', ['middleware' => 'feature_control:147', 'uses' => 'SettingController@deleteFeaturedPromoCampaign']);

    // point reset
    Route::post('reset/{type}/update', 'SettingController@updatePointReset');
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'crm', 'namespace' => 'Modules\Setting\Http\Controllers'], function()
{
    Route::any('setting_email', 'SettingController@settingEmail');
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'version', 'namespace' => 'Modules\Setting\Http\Controllers'], function()
{
    Route::any('/', 'VersionController@index');
});

Route::group(['prefix' => 'setting', 'namespace' => 'Modules\Setting\Http\Controllers'], function()
{
    Route::any('webview/{slug}', 'SettingController@aboutWebview');
    Route::any('faq/webview', 'SettingController@faqWebview');
});

/* Promo Setting */
Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'promo-setting', 'namespace' => 'Modules\Setting\Http\Controllers'], function () {
    Route::any('cashback', ['middleware' => 'feature_control:233', 'uses' => 'PromoSettingController@promoCashback']);
});