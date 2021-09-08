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
    //candidate
    Route::any('candidatepartners', ['middleware' => 'feature_control:338', 'uses' => 'PartnersController@index']);
    //partners
    Route::group(['prefix' => 'partners'], function()
    {
        Route::any('/', ['middleware' => 'feature_control:338', 'uses' => 'PartnersController@index']);
        Route::get('detail/{user_id}', ['middleware' => 'feature_control:339', 'uses' => 'PartnersController@detail']);
        Route::post('update/{user_id}', ['middleware' => 'feature_control:340', 'uses' => 'PartnersController@update']);
        Route::post('delete/{user_id}', ['middleware' => 'feature_control:341', 'uses' => 'PartnersController@destroy']);
        
    });
    
});
