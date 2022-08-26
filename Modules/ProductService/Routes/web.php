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

Route::prefix('product-service')->group(function() {
    Route::group(['middleware' => 'validate_session'], function(){
        Route::get('/', ['middleware' => 'feature_control:362,363', 'uses' => 'ProductServiceController@index']);
        Route::any('detail/{code}', ['middleware' => 'feature_control:363,365', 'uses' => 'ProductServiceController@detail']);
        Route::any('detail/{code}/delete-commission/{id_commission}', ['middleware' => 'feature_control:363,365', 'uses' => 'ProductServiceController@deleteCommission']);
        Route::post('product-use/update', ['middleware' => 'feature_control:365', 'uses' => 'ProductServiceController@productUseUpdate']);
        Route::post('submitCommission', ['middleware' => 'feature_control:365', 'uses' => 'ProductServiceController@submitCommission']);
        Route::get('position/assign', ['middleware' => ['feature_control:365'], 'uses' => 'ProductServiceController@positionAssign']);
        Route::post('position/assign', ['middleware' => ['feature_control:365'], 'uses' => 'ProductServiceController@positionAssignUpdate']);
        Route::any('visible/{key?}', ['middleware' => 'feature_control:365', 'uses' => 'ProductServiceController@visibility']);
        Route::any('hidden/{key?}', ['middleware' => 'feature_control:365', 'uses' => 'ProductServiceController@visibility']);
    });
});
