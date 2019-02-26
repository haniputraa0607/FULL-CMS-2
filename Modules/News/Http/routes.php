<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'news', 'namespace' => 'Modules\News\Http\Controllers'], function()
{
    Route::get('/', ['middleware' => 'feature_control:19', 'uses' => 'NewsController@index']);
    Route::get('ajax', ['middleware' => 'feature_control:19', 'uses' => 'NewsController@indexAjax']);
    Route::any('create', ['middleware' => 'feature_control:21', 'uses' => 'NewsController@create']);
    Route::post('delete', ['middleware' => 'feature_control:23', 'uses' => 'NewsController@delete']);
    Route::get('detail/{id}/{slug}', ['middleware' => 'feature_control:20', 'uses' => 'NewsController@detail']);
    Route::post('detail/{id}/{slug}', ['middleware' => 'feature_control:22', 'uses' => 'NewsController@detail']);

    // results of news custom form
    Route::get('form-data/{id}/{slug}', ['middleware' => 'feature_control:20', 'uses' => 'NewsController@formData']);
    // preview news custom form
    Route::get('form-preview/{id_news}', 'NewsController@customFormPreview');
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'news', 'namespace' => 'Modules\Advert\Http\Controllers'], function()
{
    /* ADVERT */
    Route::any('advert', 'AdvertController@index');
});

/* Webview */
Route::group(['prefix' => 'news', 'namespace' => 'Modules\News\Http\Controllers'], function()
{
    // custom form
    Route::any('/webview/custom-form/{id_news}', 'WebviewNewsController@customFormView');
    // preview custom form success page
    // Route::get('news/webview/custom-form-success', 'WebviewNewsController@customFormSuccess');

    // news detail
    Route::any('/webview/{id}', 'WebviewNewsController@detail');
    Route::any('/test', 'WebviewNewsController@test');
});
