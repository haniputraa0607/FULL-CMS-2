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

Route::prefix('chartofaccount')->group(function() {
    Route::get('/', ['middleware' => 'feature_control:400', 'uses' => 'ChartOfAccountController@index']);
    Route::any('/sync', ['middleware' => 'feature_control:401', 'uses' => 'ChartOfAccountController@sync']);
});
