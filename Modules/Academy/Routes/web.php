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

Route::prefix('product-academy')->group(function() {
    Route::group(['middleware' => 'validate_session'], function(){
        Route::get('/', ['middleware' => 'feature_control:373,374', 'uses' => 'ProductAcademyController@index']);
        Route::any('detail/{code}', ['middleware' => 'feature_control:374,376', 'uses' => 'ProductAcademyController@detail']);
        Route::post('product-use/update', ['middleware' => 'feature_control:376', 'uses' => 'ProductAcademyController@productUseUpdate']);
        Route::get('position/assign', ['middleware' => ['feature_control:376'], 'uses' => 'ProductAcademyController@positionAssign']);
        Route::post('position/assign', ['middleware' => ['feature_control:376'], 'uses' => 'ProductAcademyController@positionAssignUpdate']);
        Route::any('visible/{key?}', ['middleware' => 'feature_control:376', 'uses' => 'ProductAcademyController@visibility']);
        Route::any('hidden/{key?}', ['middleware' => 'feature_control:376', 'uses' => 'ProductAcademyController@visibility']);

        //setting instalment
        Route::get('setting/instalment', ['middleware' => 'feature_control:376', 'uses' => 'ProductAcademyController@settingInstalment']);
        Route::post('setting/instalment', ['middleware' => 'feature_control:376', 'uses' => 'ProductAcademyController@settingInstalmentSave']);
    });
});

