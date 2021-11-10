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

Route::prefix('BusinessDevelopment')->group(function() {
    Route::get('/', 'BusinessDevelopmentController@index');
});
Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'businessdev'], function()
{
    //partners
    Route::group(['prefix' => 'partners'], function()
    {
        Route::group(['prefix' => 'request-update'], function()
        {
            Route::any('/', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@listRequestUpdate']);
            Route::post('delete/{id}', ['middleware' => 'feature_control:341', 'uses' => 'PartnersController@destroyRequestUpdate']);
            Route::get('detail/{id}', ['middleware' => 'feature_control:339', 'uses' => 'PartnersController@detailRequestUpdate']);
            Route::post('update/{id}', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@updateRequestUpdate']);
        });
        Route::get('detail/{user_id}', ['middleware' => 'feature_control:339', 'uses' => 'PartnersController@detail']);
        Route::post('update/{user_id}', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@update']);
        Route::post('delete/{user_id}', ['middleware' => 'feature_control:341', 'uses' => 'PartnersController@destroy']);
        Route::post('reject/{user_id}', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@rejectCandidate']);
        Route::post('update-bank/{id_bank_account}', ['middleware' => 'feature_control:352', 'uses' => 'PartnersController@updateBankAccount']);
        Route::post('reset-pin/{id_partner}', ['middleware' => 'feature_control:352', 'uses' => 'PartnersController@resetPin']);
        Route::post('create-bank', ['middleware' => 'feature_control:352', 'uses' => 'PartnersController@createBankAccount']);
        Route::post('create-follow-up', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@followUp']);
        Route::get('pdf', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@pdf']);
        Route::any('/{type?}', ['middleware' => 'feature_control:338', 'uses' => 'PartnersController@index']);
        //partner close temporary
        Route::group(['prefix' => 'close-temporary'], function()
        {
            Route::get('/{id}', ['middleware' => 'feature_control:343', 'uses' => 'PartnersCloseTemporaryController@index']);
            Route::get('/detail/{id}', ['middleware' => 'feature_control:343', 'uses' => 'PartnersCloseTemporaryController@detail']);
            Route::post('/update', ['middleware' => 'feature_control:343', 'uses' => 'PartnersCloseTemporaryController@update']);
            Route::post('/updateActive', ['middleware' => 'feature_control:343', 'uses' => 'PartnersCloseTemporaryController@updateActive']);
            Route::post('/reject', ['middleware' => 'feature_control:343', 'uses' => 'PartnersCloseTemporaryController@reject']);
            Route::post('/success', ['middleware' => 'feature_control:343', 'uses' => 'PartnersCloseTemporaryController@success']);
            Route::post('/create', ['middleware' => 'feature_control:343', 'uses' => 'PartnersCloseTemporaryController@create']);
            Route::post('/createActive', ['middleware' => 'feature_control:343', 'uses' => 'PartnersCloseTemporaryController@createActive']);
            Route::post('/lampiran/delete', ['middleware' => 'feature_control:343', 'uses' => 'PartnersCloseTemporaryController@lampiranDelete']);
            Route::post('/lampiran/create', ['middleware' => 'feature_control:343', 'uses' => 'PartnersCloseTemporaryController@lampiranCreate']);
        });
        Route::group(['prefix' => 'close-permanent'], function()
        {
            Route::get('/{id}', ['middleware' => 'feature_control:343', 'uses' => 'PartnersClosePermanentController@index']);
            Route::post('/create', ['middleware' => 'feature_control:343', 'uses' => 'PartnersClosePermanentController@create']);
            Route::post('/createActive', ['middleware' => 'feature_control:343', 'uses' => 'PartnersClosePermanentController@createActive']);
            Route::post('/reject', ['middleware' => 'feature_control:343', 'uses' => 'PartnersClosePermanentController@reject']);
            Route::get('/detail/{id}', ['middleware' => 'feature_control:343', 'uses' => 'PartnersClosePermanentController@detail']);
            Route::post('/update', ['middleware' => 'feature_control:343', 'uses' => 'PartnersClosePermanentController@update']);
            Route::post('/updateActive', ['middleware' => 'feature_control:343', 'uses' => 'PartnersClosePermanentController@updateActive']);
            Route::post('/lampiran/delete', ['middleware' => 'feature_control:343', 'uses' => 'PartnersClosePermanentController@lampiranDelete']);
            Route::post('/lampiran/create', ['middleware' => 'feature_control:343', 'uses' => 'PartnersClosePermanentController@lampiranCreate']);
            Route::post('/success', ['middleware' => 'feature_control:343', 'uses' => 'PartnersClosePermanentController@success']);
        });
        Route::group(['prefix' => 'outlet'], function()
        {
            Route::get('/{id}', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@index']);
            Route::group(['prefix' => 'cutoff'], function()
            {
              Route::post('/create', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@createCutoff']);  
              Route::get('/detail/{id}', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@detailCutoff']);  
              Route::post('/update', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@updateCutoff']);
              Route::post('/reject', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@rejectCutoff']);
              Route::post('/success', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@successCutoff']);
              Route::post('/lampiran/delete', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@lampiranDeleteCutoff']);
              Route::post('/lampiran/create', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@lampiranCreateCutoff']);
            });
            Route::group(['prefix' => 'change'], function()
            {
              Route::post('/create', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@createChange']);  
              Route::get('/detail/{id}', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@detailChange']);  
              Route::post('/update', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@updateChange']);
              Route::post('/reject', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@rejectChange']);
              Route::post('/success', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@successChange']);
              Route::post('/lampiran/delete', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@lampiranDeleteChange']);
              Route::post('/lampiran/create', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@lampiranCreateChange']);
            });
        });
    });
    
    //locations
    Route::group(['prefix' => 'locations'], function()
    {
        Route::get('detail/{user_id}', ['middleware' => 'feature_control:343', 'uses' => 'LocationsController@detail']);
        Route::post('update/{user_id}', ['middleware' => 'feature_control:344', 'uses' => 'LocationsController@update']);
        Route::post('delete/{user_id}', ['middleware' => 'feature_control:345', 'uses' => 'LocationsController@destroy']);  
        Route::any('/{type?}', ['middleware' => 'feature_control:342', 'uses' => 'LocationsController@index']);
    });
    
    Route::group(['prefix' => 'form-survey'], function()
    {
        Route::get('new', ['middleware' => 'feature_control:343', 'uses' => 'FormSurveyController@new']);
        Route::get('detail/{id}', ['middleware' => 'feature_control:343', 'uses' => 'FormSurveyController@edit']);
        Route::post('create/{type?}', ['middleware' => 'feature_control:344', 'uses' => 'FormSurveyController@store']);
        Route::post('update', ['middleware' => 'feature_control:344', 'uses' => 'FormSurveyController@update']);
        Route::post('delete/{user_id}', ['middleware' => 'feature_control:345', 'uses' => 'FormSurveyController@destroy']);  
        Route::any('/', ['middleware' => 'feature_control:339', 'uses' => 'FormSurveyController@index']);
    });
    
});
