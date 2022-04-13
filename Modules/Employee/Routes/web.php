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
        Route::any('/', ['middleware' => 'feature_control:448,449,451,452', 'uses' => 'EmployeeAnnouncementController@list']);
        Route::any('create', ['middleware' => 'feature_control:450', 'uses' => 'EmployeeAnnouncementController@create']);
        Route::any('edit/{id}', ['middleware' => 'feature_control:449,371', 'uses' => 'EmployeeAnnouncementController@edit']);
		Route::any('delete/{id}', ['middleware' => 'feature_control:452', 'uses' => 'EmployeeAnnouncementController@delete']);
    });
});
