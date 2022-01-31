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

Route::group(['middleware' => ['web','validate_session'], 'prefix' => 'outlet-starter-bundling'], function() {
    Route::get('/', 'OutletStarterBundlingController@index');
    Route::get('/create', 'OutletStarterBundlingController@create');
    Route::post('/create', 'OutletStarterBundlingController@store');
    Route::get('/detail/{code}', 'OutletStarterBundlingController@show');
    Route::post('/update', 'OutletStarterBundlingController@update');
    Route::post('/delete', 'OutletStarterBundlingController@destroy');
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
        Route::post('approved-follow-up', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@approved']);
        Route::post('approved-survey-loc', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@approvedSurvey']);
        Route::post('new-follow-up', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@followUpNewLoc']);
        Route::get('pdf', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@pdf']);
        Route::get('generate-spk/{id_partner}/{id_location}', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@generateSPK']);
        
        Route::get('bundling/{id}', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@bundling']);
        Route::get('detail_location/{id}', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@detailForSelect']);
        
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
        Route::group(['prefix' => 'becomes-ixobox'], function()
        {
            Route::get('/{id}', ['middleware' => 'feature_control:343', 'uses' => 'PartnersBecomesIxoboxController@index']);
            Route::post('/create', ['middleware' => 'feature_control:343', 'uses' => 'PartnersBecomesIxoboxController@create']);
            Route::post('/createActive', ['middleware' => 'feature_control:343', 'uses' => 'PartnersBecomesIxoboxController@createActive']);
            Route::post('/reject', ['middleware' => 'feature_control:343', 'uses' => 'PartnersBecomesIxoboxController@reject']);
            Route::get('/detail/{id}', ['middleware' => 'feature_control:343', 'uses' => 'PartnersBecomesIxoboxController@detail']);
            Route::post('/update', ['middleware' => 'feature_control:343', 'uses' => 'PartnersBecomesIxoboxController@update']);
            Route::post('/updateActive', ['middleware' => 'feature_control:343', 'uses' => 'PartnersBecomesIxoboxController@updateActive']);
            Route::post('/lampiran/delete', ['middleware' => 'feature_control:343', 'uses' => 'PartnersBecomesIxoboxController@lampiranDelete']);
            Route::post('/lampiran/create', ['middleware' => 'feature_control:343', 'uses' => 'PartnersBecomesIxoboxController@lampiranCreate']);
            Route::post('/success', ['middleware' => 'feature_control:343', 'uses' => 'PartnersBecomesIxoboxController@success']);
        });
        Route::group(['prefix' => 'outlet'], function()
        {
            Route::get('/{id}', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@index']);
            Route::get('/detail/{id}', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@detail']);
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
              Route::group(['prefix' => 'change_location'], function()
            {
              Route::post('/create', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@createChangeLocation']);  
              Route::get('/detail/{id}', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@detailChangeLoation']); 
               Route::post('/create-follow-up', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@followUp']);
               Route::any('/reject/{id}', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@rejectChangeLocation']);
//              Route::post('/update', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@updateChange']);
//              Route::post('/reject', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@rejectChange']);
//              Route::post('/success', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@successChange']);
//              Route::post('/lampiran/delete', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@lampiranDeleteChange']);
//              Route::post('/lampiran/create', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@lampiranCreateChange']);
            });
            Route::group(['prefix' => 'close'], function()
            {
              Route::post('/create', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@createClose']);  
              Route::post('/createActive', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@createActive']);  
              Route::get('/list/{id}', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@listClose']);  
              Route::get('/detail/{id}', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@detailClose']);  
              Route::post('/update', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@updateClose']);
              Route::post('/updateActive', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@updateCloseActive']);
              Route::post('/reject', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@rejectClose']);
              Route::post('/success', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@successClose']);
//              Route::post('/create-follow-up', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@followUp']);
              Route::post('/followup/approved', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@approved']);  
              Route::post('/lampiran/delete', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@lampiranDeleteClose']);
              Route::post('/lampiran/create', ['middleware' => 'feature_control:343', 'uses' => 'OutletManageController@lampiranCreateClose']);
            });
        });
    });
    
    //locations
    Route::group(['prefix' => 'locations'], function()
    {
        Route::get('detail/{user_id}', ['middleware' => 'feature_control:343', 'uses' => 'LocationsController@detail']);
        Route::get('detail-status/{user_id}', ['middleware' => 'feature_control:343', 'uses' => 'LocationsController@detailStatus']);
        Route::post('update/{user_id}', ['middleware' => 'feature_control:344', 'uses' => 'LocationsController@update']);
        Route::post('delete/{user_id}', ['middleware' => 'feature_control:345', 'uses' => 'LocationsController@destroy']);  
        Route::post('create-follow-up', ['middleware' => 'feature_control:345', 'uses' => 'LocationsController@followUp']);  
        Route::post('approved-follow-up', ['middleware' => 'feature_control:345', 'uses' => 'LocationsController@approved']);  
        Route::get('detail_form_survey/{id}', ['middleware' => 'feature_control:340', 'uses' => 'LocationsController@detailFormSurvey']);
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
