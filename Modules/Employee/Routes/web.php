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
    });

    Route::group(['prefix' => 'assign-office-hours'], function(){
        Route::get('/', ['middleware' => 'feature_control:444', 'uses' => 'EmployeeController@assignOfficeHoursList']);
        Route::get('create', ['middleware' => 'feature_control:444', 'uses' => 'EmployeeController@assignOfficeHoursCreate']);
        Route::post('create', ['middleware' => 'feature_control:444', 'uses' => 'EmployeeController@assignOfficeHoursCreate']);
        Route::get('detail/{id}', ['middleware' => 'feature_control:443,445', 'uses' => 'EmployeeController@assignOfficeHoursDetail']);
        Route::post('update/{id}', ['middleware' => 'feature_control:445', 'uses' => 'EmployeeController@assignOfficeHoursDetail']);
        Route::post('delete', ['middleware' => 'feature_control:446', 'uses' => 'EmployeeController@assignOfficeHoursDelete']);
    });
});
