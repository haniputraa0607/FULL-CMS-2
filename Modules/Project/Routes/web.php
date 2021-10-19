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

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'project'], function()
{
    Route::any('{type?}', ['middleware' => 'feature_control:338', 'uses' => 'ProjectController@index']);
    Route::any('create/new', ['middleware' => 'feature_control:4', 'uses' => 'ProjectController@create']);
    Route::post('select-list/lokasi', ['middleware' => 'feature_control:4', 'uses' => 'ProjectController@lokasi']);
    Route::get('detail/{id}', ['middleware' => 'feature_control:339', 'uses' => 'ProjectController@detail']);
    
    //survey
    Route::post('create/survey_location', ['middleware' => 'feature_control:340', 'uses' => 'ProjectSurveyController@create']);
    Route::post('next/survey_location', ['middleware' => 'feature_control:340', 'uses' => 'ProjectSurveyController@next']);
    //desain
    Route::post('create/desain', ['middleware' => 'feature_control:340', 'uses' => 'ProjectDesainController@create']);
    Route::post('next/desain', ['middleware' => 'feature_control:340', 'uses' => 'ProjectDesainController@next']);
    Route::post('delete/desain', ['middleware' => 'feature_control:340', 'uses' => 'ProjectDesainController@delete']);
    //contract
    Route::post('create/contract', ['middleware' => 'feature_control:340', 'uses' => 'ProjectContractController@create']);
    Route::post('next/contract', ['middleware' => 'feature_control:340', 'uses' => 'ProjectContractController@next']);
    //fitout
    Route::post('create/fitout', ['middleware' => 'feature_control:340', 'uses' => 'ProjectFitOutController@create']);
    Route::post('next/fitout', ['middleware' => 'feature_control:340', 'uses' => 'ProjectFitOutController@next']);
    Route::post('delete/fitout', ['middleware' => 'feature_control:340', 'uses' => 'ProjectFitOutController@delete']);
   
});
