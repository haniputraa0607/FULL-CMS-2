<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'hair-stylist'], function()
{
    Route::get('commision/filter', ['uses' => 'HairStylistController@exportCommision']);
    Route::post('commision/export', ['uses' => 'HairStylistController@exportCommision']);
    Route::get('payroll/filter', ['uses' => 'HairStylistController@exportPayroll']);
    Route::post('payroll/export', ['uses' => 'HairStylistController@exportPayroll']);

    Route::group(['prefix' => 'category'], function(){
        Route::get('create', ['uses' => 'HairStylistController@categoryCreate']);
        Route::post('create', ['uses' => 'HairStylistController@categoryCreate']);
        Route::get('/', 'HairStylistController@categoryList');
        Route::get('detail/{id}', 'HairStylistController@categoryDetail');
        Route::post('update/{id}', 'HairStylistController@categoryDetail');
        Route::post('delete/{id}', 'HairStylistController@categoryDelete');
    });
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'recruitment/hair-stylist'], function()
{
    Route::get('candidate/setting-requirements', ['uses' => 'HairStylistController@candidateSettingRequirements']);
    Route::post('candidate/setting-requirements', ['uses' => 'HairStylistController@candidateSettingRequirements']);
    Route::any('candidate', ['middleware' => 'feature_control:347,348,349,350', 'uses' => 'HairStylistController@candidatelist']);
    Route::get('candidate/detail/{id}', ['middleware' => 'feature_control:348', 'uses' => 'HairStylistController@candidateDetail']);
    Route::post('candidate/update/{id}', ['middleware' => 'feature_control:349', 'uses' => 'HairStylistController@candidateUpdate']);
    Route::post('candidate/status/{id}', ['middleware' => 'feature_control:349', 'uses' => 'HairStylistController@candidateUpdateStatus']);
    Route::post('candidate/delete/{id}', ['middleware' => 'feature_control:350', 'uses' => 'HairStylistController@candidateDelete']);
    Route::get('detail/download-file/{id}', ['middleware' => 'feature_control:348', 'uses' => 'HairStylistController@hsDownloadFile']);
    Route::get('detail/download-file-contract/{id}', ['middleware' => 'feature_control:348', 'uses' => 'HairStylistController@hsDownloadFileContract']);

    Route::any('/', ['middleware' => 'feature_control:347,348,349,350', 'uses' => 'HairStylistController@hslist']);
    Route::get('detail/{id}', ['middleware' => 'feature_control:348', 'uses' => 'HairStylistController@hsDetail']);
    Route::post('update/{id}', ['middleware' => 'feature_control:349', 'uses' => 'HairStylistController@hsUpdate']);
    Route::post('update-box/{id}', ['middleware' => 'feature_control:349', 'uses' => 'HairStylistController@hsUpdateBox']);
    Route::post('update-status', ['middleware' => 'feature_control:349', 'uses' => 'HairStylistController@updateStatus']);
    Route::post('move-outlet/{id}', ['middleware' => 'feature_control:349', 'uses' => 'HairStylistController@moveOutlet']);

	Route::group(['prefix' => 'request'], function()
	{
	    Route::any('/', ['middleware' => 'feature_control:379', 'uses' => 'RequestHairStylistController@index']);
	    Route::any('/new', ['middleware' => 'feature_control:441', 'uses' => 'RequestHairStylistController@create']);
	    Route::any('/detail/{id}', ['middleware' => 'feature_control:380', 'uses' => 'RequestHairStylistController@show']);
	    Route::post('/store', ['middleware' => 'feature_control:378', 'uses' => 'RequestHairStylistController@store']);
	    Route::post('/delete/{id}', ['middleware' => 'feature_control:379', 'uses' => 'RequestHairStylistController@destroy']);
	    Route::post('/reject/{id}', ['middleware' => 'feature_control:379', 'uses' => 'RequestHairStylistController@reject']);
	    Route::post('/update/{id}', ['middleware' => 'feature_control:379', 'uses' => 'RequestHairStylistController@update']);
	});


	Route::group(['prefix' => 'schedule'], function()
	{
	    Route::any('/', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairStylistScheduleController@list']);
	    Route::any('create', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairStylistScheduleController@create']);
	    Route::get('detail/{id}', ['middleware' => 'feature_control:354', 'uses' => 'HairStylistScheduleController@detail']);
	    Route::post('update/{id}', ['middleware' => 'feature_control:355', 'uses' => 'HairStylistScheduleController@update']);
	    Route::post('/check', ['middleware' => 'feature_control:441', 'uses' => 'HairStylistScheduleController@check']);
	});

	Route::group(['prefix' => 'timeoff'], function()
	{
	    Route::any('/', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairStylistTimeOffOvertimeController@listTimeOff']);
	    Route::any('create', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairStylistTimeOffOvertimeController@createTimeOff']);
	    Route::post('list-hs', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairStylistTimeOffOvertimeController@listHS']);
	    Route::post('list-date', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairStylistTimeOffOvertimeController@listDate']);
	    Route::post('delete/{id}', ['middleware' => 'feature_control:354', 'uses' => 'HairStylistTimeOffOvertimeController@deleteTimeOff']);
	    Route::get('detail/{id}', ['middleware' => 'feature_control:354', 'uses' => 'HairStylistTimeOffOvertimeController@detailTimeOff']);
	    Route::post('update/{id}', ['middleware' => 'feature_control:355', 'uses' => 'HairStylistTimeOffOvertimeController@updateTimeOff']);
	});

	Route::group(['prefix' => 'overtime'], function()
	{
	    Route::any('/', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairStylistTimeOffOvertimeController@listOvertime']);
	    Route::any('create', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairStylistTimeOffOvertimeController@createOvertime']);
	    Route::post('delete/{id}', ['middleware' => 'feature_control:354', 'uses' => 'HairStylistTimeOffOvertimeController@deleteOvertime']);
	    Route::get('detail/{id}', ['middleware' => 'feature_control:354', 'uses' => 'HairStylistTimeOffOvertimeController@detailOvertime']);
	    Route::post('update/{id}', ['middleware' => 'feature_control:355', 'uses' => 'HairStylistTimeOffOvertimeController@updateOvertime']);
	});

    Route::any('attendance-setting', ['uses' => 'HairstylistAttendanceController@setting']);
	Route::group(['prefix' => 'attendance'], function()
	{
	    Route::get('/', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairstylistAttendanceController@index']);
	    Route::post('/', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairstylistAttendanceController@filter']);
	    Route::get('detail/{id}', ['middleware' => 'feature_control:354', 'uses' => 'HairstylistAttendanceController@detail']);
	    Route::post('detail/{id}', ['middleware' => 'feature_control:354', 'uses' => 'HairstylistAttendanceController@filter']);
	    Route::post('delete/{id}', ['middleware' => 'feature_control:525', 'uses' => 'HairstylistAttendanceController@deleteAttendance']);
	});

	Route::group(['prefix' => 'attendance-pending'], function()
	{
	    Route::get('/', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairstylistAttendanceController@listPending']);
	    Route::post('/', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairstylistAttendanceController@filterPending']);
	    Route::get('detail/{id}', ['middleware' => 'feature_control:354', 'uses' => 'HairstylistAttendanceController@detailPending']);
	    Route::post('detail/{id}', ['middleware' => 'feature_control:354', 'uses' => 'HairstylistAttendanceController@filterPending']);
	    Route::post('detail/{id}/update', ['middleware' => 'feature_control:355', 'uses' => 'HairstylistAttendanceController@updatePending']);
	});

	Route::group(['prefix' => 'attendance-request'], function()
	{
	    Route::get('/', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairstylistAttendanceController@listRequest']);
	    Route::post('/', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairstylistAttendanceController@filterRequest']);
	    Route::get('detail/{id}', ['middleware' => 'feature_control:354', 'uses' => 'HairstylistAttendanceController@detailRequest']);
	    Route::post('detail/{id}', ['middleware' => 'feature_control:354', 'uses' => 'HairstylistAttendanceController@filterRequest']);
	    Route::post('detail/{id}/update', ['middleware' => 'feature_control:355', 'uses' => 'HairstylistAttendanceController@updateRequest']);
	});

	Route::group(['prefix' => 'announcement'], function()
	{
	    Route::any('/', ['middleware' => 'feature_control:368,369,371,372', 'uses' => 'AnnouncementController@list']);
	    Route::any('create', ['middleware' => 'feature_control:370', 'uses' => 'AnnouncementController@create']);
	    Route::any('edit/{id}', ['middleware' => 'feature_control:369,371', 'uses' => 'AnnouncementController@edit']);
		Route::any('delete/{id}', ['middleware' => 'feature_control:372', 'uses' => 'AnnouncementController@delete']);
	});

	Route::group(['prefix' => 'update-data'], function()
	{
	    Route::any('/', ['middleware' => 'feature_control:428,429,430', 'uses' => 'HairStylistUpdateDataController@list']);
	    Route::get('detail/{id}', ['middleware' => 'feature_control:429', 'uses' => 'HairStylistUpdateDataController@detail']);
	    Route::post('update/{id}', ['middleware' => 'feature_control:430', 'uses' => 'HairStylistUpdateDataController@update']);
	});

	Route::group(['prefix' => 'group'], function()
	{
	    Route::any('create', ['middleware' => 'feature_control:394', 'uses' => 'HairStylistGroupController@create']);	    
	    Route::any('detail/{id}', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@detail']);	    
	    Route::post('update', ['middleware' => 'feature_control:395', 'uses' => 'HairStylistGroupController@update']);	    
	    Route::any('/', ['middleware' => 'feature_control:393', 'uses' => 'HairStylistGroupController@index']);	    
	    Route::post('commission/create', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@create_commission']);	    
	    Route::post('commission/update', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@update_commission']);	    

            Route::post('insentif/create', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@create_insentif']);	    
	    Route::post('insentif/update', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@update_insentif']);	    
	    Route::get('insentif/detail/{id}', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@detail_insentif']);	    
	    Route::any('insentif/delete/{id}', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@delete_insentif']);	    
            Route::post('insentif/create-rumus-insentif', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@create_rumus_insentif']);
            Route::any('insentif/delete-rumus-insentif/{id}', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@delete_rumus_insentif']);
	    Route::post('overtime/create', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@create_overtime']);	    
            Route::post('potongan/create', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@create_potongan']);	    
	    Route::post('potongan/update', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@update_potongan']);	    
	    Route::get('potongan/detail/{id}', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@detail_potongan']);	    
	    Route::any('potongan/delete/{id}', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@delete_potongan']);	    
	    Route::post('potongan/create-rumus-potongan', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@create_rumus_potongan']);
            Route::any('potongan/delete-rumus-potongan/{id}', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@delete_rumus_potongan']);
	    Route::post('invite_hs', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@invite_hs']);	    
	    Route::any('commission/detail/{id}', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@detail_commission']);	 	    
	    Route::any('commission/filter_commission', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@filter_commission']);	 	    
	    Route::any('commission/filter_hs', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@filter_hs']);	 	    
	    Route::any('commission/filter_insentif', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@filter_insentif']);	 	    
	    Route::any('commission/filter_potongan', ['middleware' => 'feature_control:396', 'uses' => 'HairStylistGroupController@filter_potongan']);	 	    
	});
	Route::group(['prefix' => 'default'], function()
	{
	    Route::post('insentif/create', ['middleware' => 'feature_control:425', 'uses' => 'HairStylistGroupController@default_create_insentif']);	    
	    Route::post('insentif/update', ['middleware' => 'feature_control:425', 'uses' => 'HairStylistGroupController@default_update_insentif']);	    
	    Route::get('insentif/detail/{id}', ['middleware' => 'feature_control:425', 'uses' => 'HairStylistGroupController@default_detail_insentif']);	    
	    Route::any('insentif/delete/{id}', ['middleware' => 'feature_control:425', 'uses' => 'HairStylistGroupController@default_delete_insentif']);	    
	    Route::any('insentif', ['middleware' => 'feature_control:425', 'uses' => 'HairStylistGroupController@default_index_insentif']);	    
	    Route::post('potongan/create', ['middleware' => 'feature_control:426', 'uses' => 'HairStylistGroupController@default_create_potongan']);	    
	    Route::post('potongan/update', ['middleware' => 'feature_control:426', 'uses' => 'HairStylistGroupController@default_update_potongan']);	    
	    Route::get('potongan/detail/{id}', ['middleware' => 'feature_control:426', 'uses' => 'HairStylistGroupController@default_detail_potongan']);	    
	    Route::any('potongan/delete/{id}', ['middleware' => 'feature_control:426', 'uses' => 'HairStylistGroupController@default_delete_potongan']);	    
	    Route::any('potongan', ['middleware' => 'feature_control:426', 'uses' => 'HairStylistGroupController@default_index_potongan']);	    
            Route::group(['prefix' => 'overtime'], function()
            {
                Route::post('create', ['middleware' => 'feature_control:426', 'uses' => 'HairStylistGroupController@default_create_overtime']);	    
                Route::post('update', ['middleware' => 'feature_control:426', 'uses' => 'HairStylistGroupController@default_update_overtime']);	    
                Route::get('detail/{id}', ['middleware' => 'feature_control:426', 'uses' => 'HairStylistGroupController@default_detail_overtime']);	    
                Route::any('delete/{id}', ['middleware' => 'feature_control:426', 'uses' => 'HairStylistGroupController@default_delete_overtime']);	    
                Route::any('/', ['middleware' => 'feature_control:426', 'uses' => 'HairStylistGroupController@default_index_overtime']);	    
            });
        });
});