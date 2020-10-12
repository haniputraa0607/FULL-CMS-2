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

Route::prefix('product-variant')->group(function() {
    Route::group(['middleware' => 'validate_session'], function(){
        Route::get('/', ['middleware' => 'feature_control:278', 'uses' => 'ProductVariantController@index']);
        Route::get('create', ['middleware' => 'feature_control:279', 'uses' => 'ProductVariantController@create']);
        Route::post('store', ['middleware' => 'feature_control:279', 'uses' => 'ProductVariantController@store']);
        Route::get('edit/{id}', ['middleware' => 'feature_control:281', 'uses' => 'ProductVariantController@edit']);
        Route::post('update/{id}', ['middleware' => 'feature_control:281', 'uses' => 'ProductVariantController@update']);
        Route::any('delete/{id}', ['middleware' => 'feature_control:282', 'uses' => 'ProductVariantController@destroy']);
    });
});

Route::prefix('product-variant-group')->group(function() {
    Route::group(['middleware' => 'validate_session'], function(){
        Route::get('price/{id_outlet?}', ['middleware' => 'feature_control:281', 'uses' => 'ProductVariantGroupController@listPrice']);
        Route::post('price/{id_outlet}', ['middleware' => 'feature_control:281', 'uses' => 'ProductVariantGroupController@updatePrice']);
    });
});