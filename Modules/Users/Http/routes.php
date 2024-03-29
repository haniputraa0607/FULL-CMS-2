<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'job-level', 'namespace' => 'Modules\Users\Http\Controllers'], function()
{
    Route::get('/', ['middleware' => 'feature_control:323', 'uses' => 'JobLevelsController@index']);
    Route::get('position', ['middleware' => 'feature_control:323', 'uses' => 'JobLevelsController@position']);
    Route::post('position', ['middleware' => 'feature_control:326', 'uses' => 'JobLevelsController@position']);
    Route::get('create', ['middleware' => 'feature_control:324', 'uses' => 'JobLevelsController@create']);
    Route::post('store', ['middleware' => 'feature_control:324', 'uses' => 'JobLevelsController@store']);
    Route::get('edit/{id}', ['middleware' => 'feature_control:325,326', 'uses' => 'JobLevelsController@edit']);
    Route::post('update/{id}', ['middleware' => 'feature_control:326', 'uses' => 'JobLevelsController@update']);
    Route::any('delete/{id}', ['middleware' => 'feature_control:327', 'uses' => 'JobLevelsController@destroy']);
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'role', 'namespace' => 'Modules\Users\Http\Controllers'], function()
{
    Route::any('/', ['middleware' => 'feature_control:333', 'uses' => 'RolesController@index']);
    Route::get('create', ['middleware' => 'feature_control:334', 'uses' => 'RolesController@create']);
    Route::post('store', ['middleware' => 'feature_control:334', 'uses' => 'RolesController@store']);
    Route::get('edit/{id}', ['middleware' => 'feature_control:335,336', 'uses' => 'RolesController@edit']);
    Route::post('update/{id}', ['middleware' => 'feature_control:336', 'uses' => 'RolesController@update']);
    Route::any('delete/{id}', ['middleware' => 'feature_control:337', 'uses' => 'RolesController@destroy']);
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'user', 'namespace' => 'Modules\Users\Http\Controllers'], function()
{
    //user franchise
    Route::group(['prefix' => 'user-franchise'], function()
    {
        Route::any('/', 'UsersFranchiseController@index');
        Route::get('create', 'UsersFranchiseController@create');
        Route::post('store', 'UsersFranchiseController@store');
        Route::get('detail/{user_id}', 'UsersFranchiseController@detail');
        Route::post('update/{user_id}', 'UsersFranchiseController@update');
        Route::post('delete/{user_id}', 'UsersFranchiseController@destroy');

        Route::get('import', 'UsersFranchiseController@import');
        Route::any('export', 'UsersFranchiseController@export');
        Route::post('import/save', 'UsersFranchiseController@importSave');
    });

	/* department */
	Route::group(['prefix' => 'department'], function()
	{
		Route::get('/', ['middleware' => 'feature_control:328', 'uses' => 'DepartmentController@index']);
		Route::get('create', ['middleware' => 'feature_control:329', 'uses' => 'DepartmentController@create']);
	   	Route::post('store', ['middleware' => 'feature_control:329', 'uses' => 'DepartmentController@store']);
	    Route::get('edit/{id}', ['middleware' => 'feature_control:330', 'uses' => 'DepartmentController@edit']);
	   	Route::post('update/{id}', ['middleware' => 'feature_control:331', 'uses' => 'DepartmentController@update']);
	    Route::any('delete/{id}', ['middleware' => 'feature_control:332', 'uses' => 'DepartmentController@destroy']);
    	Route::any('sync', ['middleware' => 'feature_control:329', 'uses' => 'DepartmentController@syncIcount']);
	});

	Route::get('ajax/phone', 'UsersController@listPhoneUser');
	Route::get('ajax/email', 'UsersController@listEmailUser');
	Route::get('ajax/name', 'UsersController@listNameUser');
	Route::get('ajax/log/{id}/{log_type}', 'UsersController@showDetailLog');
	Route::get('ajax/verify_token', 'UsersController@verifyToken');
	Route::post('ajax/address/{phone}', 'UsersController@listAddressUser');

	Route::any('/', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@index']);

	Route::group(['middleware' => 'config_control:5', 'prefix' => 'adminoutlet'], function()
	{
		Route::any('/', ['middleware' => 'feature_control:9', 'uses' => 'UsersController@indexAdminOutlet']);
		Route::any('/create', ['middleware' => 'feature_control:4', 'uses' => 'UsersController@createAdminOutlet']);
		Route::any('/{phone}', ['middleware' => 'feature_control:4', 'uses' => 'UsersController@updateAdminOutlet']);
		Route::any('/delete/{phone}/{id_outlet}', ['middleware' => 'feature_control:4', 'uses' => 'UsersController@deleteAdminOutlet']);
	});

	Route::any('create', ['middleware' => 'feature_control:4', 'uses' => 'UsersController@create']);
	Route::any('export', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@getExport']);
	Route::any('activity', ['middleware' => 'feature_control:6', 'uses' => 'UsersController@activity']);
	Route::any('activity/export', ['middleware' => 'feature_control:6', 'uses' => 'UsersController@getExportActivities']);
    Route::any('search/reset', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@searchReset']);
    Route::get('delete/{phone}', ['middleware' => 'feature_control:5', 'uses' => 'UsersController@delete']);
	Route::get('delete/logApp/{id}', ['middleware' => 'feature_control:5', 'uses' => 'UsersController@deleteLogApp']);
	Route::get('delete/logBE/{id}', ['middleware' => 'feature_control:5', 'uses' => 'UsersController@deleteLogBE']);
    Route::any('detail/{phone}', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@show']);
    Route::any('detail/{phone}/favorite', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@favorite']);
    Route::any('detail/log/{phone}', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@showLog']);
    Route::any('log/{phone}/{tipe}', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@showAllLog']);
    Route::any('detail/transaction/{phone}', 'UsersController@showTransaction');
    Route::any('detail/treatment/{phone}', 'UsersController@showTreatment');
    Route::any('autoresponse-franchise/{subject}', ['middleware' => 'feature_control:304', 'uses' =>'UsersController@autoResponse']);
    Route::any('autoresponse/{subject}', ['middleware' => 'feature_control:92', 'uses' =>'UsersController@autoResponse']);
	Route::any('activity/{page}', ['middleware' => 'feature_control:6', 'uses' => 'UsersController@activity']);
});

/* Webview */
Route::group(['prefix' => 'webview/complete-profile', 'namespace' => 'Modules\Users\Http\Controllers'], function()
{
    Route::any('/', 'WebviewUserController@completeProfile');
    Route::post('/submit', 'WebviewUserController@completeProfileSubmit');
    Route::get('/success', 'WebviewUserController@completeProfileSuccess');
});