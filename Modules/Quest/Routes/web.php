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

Route::prefix('quest')->group(function () {
    Route::get('/', 'QuestController@index');
    Route::any('create', 'QuestController@create');
    Route::any('detail/{slug}', 'QuestController@show');
    Route::any('update/detail', 'QuestController@update');
});
