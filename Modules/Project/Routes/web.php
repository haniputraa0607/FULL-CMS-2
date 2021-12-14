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
    Route::any('{type?}', ['middleware' => 'feature_control:402', 'uses' => 'ProjectController@index']);
    Route::any('create/new', ['middleware' => 'feature_control:403', 'uses' => 'ProjectController@create']);
    Route::get('select-list/lokasi/{id}', ['middleware' => 'feature_control:402', 'uses' => 'ProjectController@lokasi']);
    Route::get('detail/{id}', ['middleware' => 'feature_control:404', 'uses' => 'ProjectController@detail']);
    Route::post('update/detail', ['middleware' => 'feature_control:405', 'uses' => 'ProjectController@update']);
    Route::post('reject/data', ['middleware' => 'feature_control:405', 'uses' => 'ProjectController@reject']);
    Route::get('excel/{id}', ['middleware' => 'feature_control:402', 'uses' => 'ProjectController@excel']);
    //survey
    Route::post('create/survey_location', ['middleware' => 'feature_control:403', 'uses' => 'ProjectSurveyController@create']);
    Route::post('next/survey_location', ['middleware' => 'feature_control:405', 'uses' => 'ProjectSurveyController@next']);
    Route::post('delete/survey_location', ['middleware' => 'feature_control:406', 'uses' => 'ProjectSurveyController@delete']);
    //desain
    Route::post('create/desain', ['middleware' => 'feature_control:403', 'uses' => 'ProjectDesainController@create']);
    Route::post('next/desain', ['middleware' => 'feature_control:405', 'uses' => 'ProjectDesainController@next']);
    Route::post('delete/desain', ['middleware' => 'feature_control:406', 'uses' => 'ProjectDesainController@delete']);
    //contract
    Route::post('create/contract', ['middleware' => 'feature_control:403', 'uses' => 'ProjectContractController@create']);
    Route::post('next/contract', ['middleware' => 'feature_control:405', 'uses' => 'ProjectContractController@next']);
    Route::post('delete/contract', ['middleware' => 'feature_control:406', 'uses' => 'ProjectContractController@delete']);
    
    //fitout
    Route::post('create/fitout', ['middleware' => 'feature_control:403', 'uses' => 'ProjectFitOutController@create']);
    Route::post('next/fitout', ['middleware' => 'feature_control:405', 'uses' => 'ProjectFitOutController@next']);
    Route::post('delete/fitout', ['middleware' => 'feature_control:406', 'uses' => 'ProjectFitOutController@delete']);
   //handover
    Route::post('create/handover', ['middleware' => 'feature_control:403', 'uses' => 'ProjectHandoverController@create']);
    Route::post('next/handover', ['middleware' => 'feature_control:405', 'uses' => 'ProjectHandoverController@next']);
   Route::post('delete/handover', ['middleware' => 'feature_control:406', 'uses' => 'ProjectHandoverController@delete']);
});
