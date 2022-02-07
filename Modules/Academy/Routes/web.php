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
Route::group(['middleware' => 'validate_session', 'prefix' => 'academy'], function(){
    Route::get('setting/installment', ['middleware' => 'feature_control:376', 'uses' => 'AcademyController@settingInstallment']);
    Route::post('setting/installment', ['middleware' => 'feature_control:376', 'uses' => 'AcademyController@settingInstallmentSave']);

    Route::get('setting/banner', ['middleware' => 'feature_control:376', 'uses' => 'AcademyController@settingBanner']);
    Route::post('setting/banner', ['middleware' => 'feature_control:376', 'uses' => 'AcademyController@settingBannerSave']);

    Route::get('transaction/user/schedule', ['middleware' => 'feature_control:390,391', 'uses' => 'AcademyScheduleController@listUserAcademy']);
    Route::post('transaction/user/schedule', ['middleware' => 'feature_control:390,391', 'uses' => 'AcademyScheduleController@filterListUserAcademy']);
    Route::get('transaction/user/schedule/detail/{id_user}', ['middleware' => 'feature_control:390,391', 'uses' => 'AcademyScheduleController@detailScheduleUserAcademy']);
    Route::get('transaction/user/schedule/detail/list/{id_transaction_academy}', ['middleware' => 'feature_control:390,391', 'uses' => 'AcademyScheduleController@listScheduleAcademy']);
    Route::post('transaction/user/schedule/update/{id_transaction_academy}', ['middleware' => 'feature_control:390,391', 'uses' => 'AcademyScheduleController@updateScheduleUserAcademy']);

    Route::get('transaction/user/schedule/day-off', ['middleware' => 'feature_control:390,391', 'uses' => 'AcademyScheduleController@listDayOffUserAcademy']);
    Route::post('transaction/user/schedule/day-off', ['middleware' => 'feature_control:390,391', 'uses' => 'AcademyScheduleController@filterListDayOffUserAcademy']);
    Route::post('transaction/user/schedule/day-off/action', ['middleware' => 'feature_control:391', 'uses' => 'AcademyScheduleController@actionDayOffUserAcademy']);

    Route::any('transaction/outlet/course/{key?}', ['middleware' => 'feature_control:390,391', 'uses' => 'AcademyScheduleController@outletCourseAcademy']);
    Route::post('transaction/outlet/course/detail/attendace', ['middleware' => 'feature_control:390,391', 'uses' => 'AcademyScheduleController@saveAttendanceCourseAcademy']);
    Route::post('transaction/outlet/course/detail/final-score', ['middleware' => 'feature_control:390,391', 'uses' => 'AcademyScheduleController@saveFinalScoreCourseAcademy']);
    Route::get('transaction/outlet/course/detail/history/{id}', ['uses' => 'AcademyScheduleController@courseDetailHistory']);
    Route::get('transaction/outlet/course/detail/{id_outlet}/{id_product}', ['middleware' => 'feature_control:390,391', 'uses' => 'AcademyScheduleController@detailOutletCourseAcademy']);
    Route::post('transaction/outlet/course/detail/{id_outlet}/{id_product}', ['middleware' => 'feature_control:390,391', 'uses' => 'AcademyScheduleController@filterCourseDetailUser']);
});

Route::group(['middleware' => 'validate_session', 'prefix' => 'product-academy'], function(){
    Route::get('/', ['middleware' => 'feature_control:373,374', 'uses' => 'ProductAcademyController@index']);
    Route::any('detail/{code}', ['middleware' => 'feature_control:374,376', 'uses' => 'ProductAcademyController@detail']);
    Route::post('product-use/update', ['middleware' => 'feature_control:376', 'uses' => 'ProductAcademyController@productUseUpdate']);
    Route::get('position/assign', ['middleware' => ['feature_control:376'], 'uses' => 'ProductAcademyController@positionAssign']);
    Route::post('position/assign', ['middleware' => ['feature_control:376'], 'uses' => 'ProductAcademyController@positionAssignUpdate']);
    Route::any('visible/{key?}', ['middleware' => 'feature_control:376', 'uses' => 'ProductAcademyController@visibility']);
    Route::any('hidden/{key?}', ['middleware' => 'feature_control:376', 'uses' => 'ProductAcademyController@visibility']);
    Route::post('theory/save', ['middleware' => 'feature_control:374,376', 'uses' => 'ProductAcademyController@theoryUpdate']);
});

Route::group(['middleware' => 'validate_session', 'prefix' => 'theory'], function(){
    Route::get('category/create', ['middleware' => 'feature_control:438', 'uses' => 'TheoryController@categoryCreate']);
    Route::post('category/create', ['middleware' => 'feature_control:438', 'uses' => 'TheoryController@categoryCreate']);
    Route::get('category', 'TheoryController@categoryList');
    Route::get('category/detail/{id}', 'TheoryController@categoryDetail');
    Route::post('category/update/{id}', 'TheoryController@categoryDetail');

    Route::get('create', ['middleware' => 'feature_control:438', 'uses' => 'TheoryController@theoryCreate']);
    Route::post('create', ['middleware' => 'feature_control:438', 'uses' => 'TheoryController@theoryCreate']);
    Route::get('{id?}', 'TheoryController@theoryList');
    Route::post('delete', 'TheoryController@theoryDelete');
    Route::get('detail/{id}', 'TheoryController@theoryDetail');
    Route::post('update/{id}', 'TheoryController@theoryDetail');
});

