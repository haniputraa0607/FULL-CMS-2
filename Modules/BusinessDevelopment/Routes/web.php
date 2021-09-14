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
        Route::get('detail/{user_id}', ['middleware' => 'feature_control:339', 'uses' => 'PartnersController@detail']);
        Route::post('update/{user_id}', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@update']);
        Route::post('delete/{user_id}', ['middleware' => 'feature_control:341', 'uses' => 'PartnersController@destroy']);
        Route::post('update-bank/{id_bank_account}', ['middleware' => 'feature_control:352', 'uses' => 'PartnersController@updateBankAccount']);
        Route::post('reset-pin/{id_partner}', ['middleware' => 'feature_control:352', 'uses' => 'PartnersController@resetPin']);
        Route::post('create-bank', ['middleware' => 'feature_control:352', 'uses' => 'PartnersController@createBankAccount']);
        Route::any('/{type?}', ['middleware' => 'feature_control:338', 'uses' => 'PartnersController@index']);
    });
    
    //locations
    Route::group(['prefix' => 'locations'], function()
    {
        Route::get('detail/{user_id}', ['middleware' => 'feature_control:343', 'uses' => 'LocationsController@detail']);
        Route::post('update/{user_id}', ['middleware' => 'feature_control:344', 'uses' => 'LocationsController@update']);
        Route::post('delete/{user_id}', ['middleware' => 'feature_control:345', 'uses' => 'LocationsController@destroy']);  
        Route::any('/{type?}', ['middleware' => 'feature_control:342', 'uses' => 'LocationsController@index']);
    });
    
});
