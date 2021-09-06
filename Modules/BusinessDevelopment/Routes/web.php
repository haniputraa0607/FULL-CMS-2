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
        Route::any('/', 'PartnersController@index');
        Route::get('detail/{user_id}', 'PartnersController@detail');
        Route::post('update/{user_id}', 'PartnersController@update');
        
    });
    
});
