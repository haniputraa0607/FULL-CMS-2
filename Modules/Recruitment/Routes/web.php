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


Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'recruitment/hair-stylist'], function()
{
    Route::any('candidate', ['middleware' => 'feature_control:347,348,349,350', 'uses' => 'HairStylistController@candidatelist']);
    Route::get('candidate/detail/{id}', ['middleware' => 'feature_control:348', 'uses' => 'HairStylistController@candidateDetail']);
    Route::post('candidate/update/{id}', ['middleware' => 'feature_control:349', 'uses' => 'HairStylistController@candidateUpdate']);
    Route::post('candidate/status/{id}', ['middleware' => 'feature_control:349', 'uses' => 'HairStylistController@candidateUpdateStatus']);
    Route::post('candidate/delete/{id}', ['middleware' => 'feature_control:350', 'uses' => 'HairStylistController@candidateDelete']);
    Route::get('detail/download-file/{id}', ['middleware' => 'feature_control:348', 'uses' => 'HairStylistController@hsDownloadFile']);

    Route::any('/', ['middleware' => 'feature_control:347,348,349,350', 'uses' => 'HairStylistController@hslist']);
    Route::get('detail/{id}', ['middleware' => 'feature_control:348', 'uses' => 'HairStylistController@hsDetail']);
    Route::post('update/{id}', ['middleware' => 'feature_control:349', 'uses' => 'HairStylistController@hsUpdate']);
    Route::post('update-status', ['middleware' => 'feature_control:349', 'uses' => 'HairStylistController@updateStatus']);

	Route::group(['prefix' => 'schedule'], function()
	{
	    Route::any('/', ['middleware' => 'feature_control:353,354,355', 'uses' => 'HairStylistScheduleController@list']);
	    Route::get('detail/{id}', ['middleware' => 'feature_control:354', 'uses' => 'HairStylistScheduleController@detail']);
	    Route::post('update/{id}', ['middleware' => 'feature_control:355', 'uses' => 'HairStylistScheduleController@update']);
	});
});