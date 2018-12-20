<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'setting-fraud-detection', 'namespace' => 'Modules\SettingFraud\Http\Controllers'], function()
{
    Route::get('/', 'SettingFraudController@list');
    Route::any('detail/{id}', 'SettingFraudController@detail');
});
