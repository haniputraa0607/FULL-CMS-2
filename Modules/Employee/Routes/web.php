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

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'employee'], function()
{
    Route::group(['prefix' => 'office-hours'], function(){
        Route::get('/', ['middleware' => 'feature_control:444', 'uses' => 'EmployeeController@officeHoursList']);
        Route::get('create', ['middleware' => 'feature_control:444', 'uses' => 'EmployeeController@officeHoursCreate']);
        Route::post('create', ['middleware' => 'feature_control:444', 'uses' => 'EmployeeController@officeHoursCreate']);
        Route::get('detail/{id}', ['middleware' => 'feature_control:443,445', 'uses' => 'EmployeeController@officeHoursDetail']);
        Route::post('update/{id}', ['middleware' => 'feature_control:445', 'uses' => 'EmployeeController@officeHoursDetail']);
        Route::post('delete', ['middleware' => 'feature_control:446', 'uses' => 'EmployeeController@officeHoursDelete']);
        Route::any('assign', ['uses' => 'EmployeeController@assign']);
    });

    Route::group(['prefix' => 'announcement'], function(){
        Route::any('/', ['middleware' => 'feature_control:464,465,467,468', 'uses' => 'EmployeeAnnouncementController@list']);
        Route::any('create', ['middleware' => 'feature_control:466', 'uses' => 'EmployeeAnnouncementController@create']);
        Route::any('edit/{id}', ['middleware' => 'feature_control:465,467', 'uses' => 'EmployeeAnnouncementController@edit']);
		Route::any('delete/{id}', ['middleware' => 'feature_control:468', 'uses' => 'EmployeeAnnouncementController@delete']);
    });

    Route::group(['prefix' => 'schedule'], function(){
        Route::any('/', ['middleware' => 'feature_control:472,473,474', 'uses' => 'EmployeeScheduleController@list']);
	    Route::any('create', ['middleware' => 'feature_control:475', 'uses' => 'EmployeeScheduleController@create']);
	    Route::get('detail/{shift}/{id}', ['middleware' => 'feature_control:473', 'uses' => 'EmployeeScheduleController@detail']);
	    Route::post('update/{id}', ['middleware' => 'feature_control:474', 'uses' => 'EmployeeScheduleController@update']);
	    Route::post('/check', ['middleware' => 'feature_control:475', 'uses' => 'EmployeeScheduleController@check']);
    });
     Route::group(['prefix' => 'recruitment'], function(){
        Route::any('', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@index']);
        Route::any('detail/{id}', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@detail']);
        Route::any('candidate', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@candidate']);
        Route::any('candidate/detail/{id}', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@detailcandidate']);
        Route::any('candidate/update/{id}', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@candidateUpdate']);
//        Route::any('create', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@create']);
    });

    Route::group(['prefix' => 'attendance'], function(){
        Route::get('/', ['uses' => 'EmployeeAttendanceController@list']);
        Route::post('/', ['uses' => 'EmployeeAttendanceController@filter']);
        Route::get('detail/{id}', ['uses' => 'EmployeeAttendanceController@detail']);
        Route::post('detail/{id}', ['uses' => 'EmployeeAttendanceController@filter']);
        Route::any('setting', ['uses' => 'EmployeeAttendanceController@setting']);
        Route::get('pending', ['uses' => 'EmployeeAttendanceController@listPending']);
        Route::post('pending', ['uses' => 'EmployeeAttendanceController@filterPending']);
        Route::get('pending/detail/{id}', ['uses' => 'EmployeeAttendanceController@detailPending']);
        Route::post('pending/detail/{id}', ['uses' => 'EmployeeAttendanceController@filterPending']);
        Route::post('pending/detail/{id}/update', ['uses' => 'EmployeeAttendanceController@updatePending']);
    });

});
