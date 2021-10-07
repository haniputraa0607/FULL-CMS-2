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

Route::prefix('user-rating')->middleware(['web', 'validate_session'])->group(function() {
	Route::post('option','RatingOptionController@store');
    Route::get('/detail/{id}', 'UserRatingController@show');
    Route::get('/', 'UserRatingController@index');
    Route::post('/', 'UserRatingController@setFilter');
    Route::get('setting', 'UserRatingController@setting');
    Route::post('setting', 'UserRatingController@settingUpdate');
    Route::get('setting', 'UserRatingController@setting');
    Route::post('setting', 'UserRatingController@settingUpdate');
    Route::any('autoresponse/{target}', 'UserRatingController@autoresponse');
    Route::any('autoresponse', 'UserRatingController@autoresponse');
    Route::group(['prefix'=>'report'],function(){
		Route::group(['prefix'=>'hairstylist'],function(){
		    Route::get('/', 'UserRatingController@reportHairstylist');
		    Route::post('/', 'UserRatingController@setReportFilterHairstylist');
		    Route::get('detail', 'UserRatingController@reportListHairstylist');
		    Route::get('detail/{id_hairstylist}', 'UserRatingController@reportDetailHairstylist');
		});

		Route::group(['prefix'=>'outlet'],function(){
		    Route::get('/', 'UserRatingController@report');
		    Route::post('/', 'UserRatingController@setReportFilter');
		    Route::get('detail', 'UserRatingController@reportOutlet');
		    Route::get('detail/{outlet_code}', 'UserRatingController@reportOutletDetail');
		});
	});

});
