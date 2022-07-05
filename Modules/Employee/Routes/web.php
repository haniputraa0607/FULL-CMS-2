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

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'employee'], function()
{
    Route::group(['prefix' => 'office-hours'], function(){
        Route::get('/', ['middleware' => 'feature_control:444', 'uses' => 'EmployeeController@officeHoursList']);
        Route::get('create', ['middleware' => 'feature_control:444', 'uses' => 'EmployeeController@officeHoursCreate']);
        Route::post('create', ['middleware' => 'feature_control:444', 'uses' => 'EmployeeController@officeHoursCreate']);
        Route::get('detail/{id}', ['middleware' => 'feature_control:443,445', 'uses' => 'EmployeeController@officeHoursDetail']);
        Route::post('update/{id}', ['middleware' => 'feature_control:445', 'uses' => 'EmployeeController@officeHoursDetail']);
        Route::post('delete', ['middleware' => 'feature_control:446', 'uses' => 'EmployeeController@officeHoursDelete']);
        Route::any('assign', ['uses' => 'EmployeeController@assign']);
    });

    Route::group(['prefix' => 'announcement'], function(){
        Route::any('/', ['middleware' => 'feature_control:464,465,467,468', 'uses' => 'EmployeeAnnouncementController@list']);
        Route::any('create', ['middleware' => 'feature_control:466', 'uses' => 'EmployeeAnnouncementController@create']);
        Route::any('edit/{id}', ['middleware' => 'feature_control:465,467', 'uses' => 'EmployeeAnnouncementController@edit']);
		Route::any('delete/{id}', ['middleware' => 'feature_control:468', 'uses' => 'EmployeeAnnouncementController@delete']);
    });

    Route::group(['prefix' => 'schedule'], function(){
        Route::any('/', ['middleware' => 'feature_control:472,473,474', 'uses' => 'EmployeeScheduleController@list']);
	    Route::any('create', ['middleware' => 'feature_control:475', 'uses' => 'EmployeeScheduleController@create']);
	    Route::get('detail/{shift}/{id}', ['middleware' => 'feature_control:473', 'uses' => 'EmployeeScheduleController@detail']);
	    Route::post('update/{id}', ['middleware' => 'feature_control:474', 'uses' => 'EmployeeScheduleController@update']);
	    Route::post('/check', ['middleware' => 'feature_control:475', 'uses' => 'EmployeeScheduleController@check']);
    });
     Route::group(['prefix' => 'recruitment'], function(){
        Route::any('', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@index']);
        Route::any('detail/{id}', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@detail']);
        Route::any('candidate', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@candidate']);
        Route::any('candidate/detail/{id}', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@detailcandidate']);
        Route::any('update/{id}', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@update']);
        Route::post('complement/{id}', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@complement']);
        Route::any('reject/{id}', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@reject']);
        Route::any('create-business-partner', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@CreateBusinessPartner']);
//        Route::any('create', ['middleware' => 'feature_control:444', 'uses' => 'RecruitmentEmployeeController@create']);
    });

    Route::group(['prefix' => 'attendance'], function(){
        Route::get('/', ['uses' => 'EmployeeAttendanceController@list']);
        Route::post('/', ['uses' => 'EmployeeAttendanceController@filter']);
        Route::get('detail/{id}', ['uses' => 'EmployeeAttendanceController@detail']);
        Route::post('detail/{id}', ['uses' => 'EmployeeAttendanceController@filter']);
        Route::post('delete/{id}', ['uses' => 'EmployeeAttendanceController@deleteDetail']);
        Route::any('setting', ['uses' => 'EmployeeAttendanceController@setting']);
        Route::get('pending', ['uses' => 'EmployeeAttendanceController@listPending']);
        Route::post('pending', ['uses' => 'EmployeeAttendanceController@filterPending']);
        Route::get('pending/detail/{id}', ['uses' => 'EmployeeAttendanceController@detailPending']);
        Route::post('pending/detail/{id}', ['uses' => 'EmployeeAttendanceController@filterPending']);
        Route::post('pending/detail/{id}/update', ['uses' => 'EmployeeAttendanceController@updatePending']);
    });

    Route::group(['prefix' => 'attendance-outlet'], function(){
        Route::get('/', ['uses' => 'EmployeeOutletAttendanceController@list']);
        Route::post('/', ['uses' => 'EmployeeOutletAttendanceController@filter']);
        Route::get('detail/{id}', ['uses' => 'EmployeeOutletAttendanceController@detail']);
        Route::post('detail/{id}', ['uses' => 'EmployeeOutletAttendanceController@filter']);
        Route::post('delete/{id}', ['uses' => 'EmployeeOutletAttendanceController@deleteDetail']);
        Route::get('pending', ['uses' => 'EmployeeOutletAttendanceController@listPending']);
        Route::post('pending', ['uses' => 'EmployeeOutletAttendanceController@filterPending']);
        Route::get('pending/detail/{id}', ['uses' => 'EmployeeOutletAttendanceController@detailPending']);
        Route::post('pending/detail/{id}', ['uses' => 'EmployeeOutletAttendanceController@filterPending']);
        Route::post('pending/detail/{id}/update', ['uses' => 'EmployeeOutletAttendanceController@updatePending']);
        Route::get('request', ['uses' => 'EmployeeOutletAttendanceController@listRequest']);
        Route::post('request', ['uses' => 'EmployeeOutletAttendanceController@filterRequest']);
        Route::get('request/detail/{id}', ['uses' => 'EmployeeOutletAttendanceController@detailRequest']);
        Route::post('request/detail/{id}', ['uses' => 'EmployeeOutletAttendanceController@filterRequest']);
        Route::post('request/detail/{id}/update', ['uses' => 'EmployeeOutletAttendanceController@updateRequest']);
    });

    Route::group(['prefix' => 'attendance-request'], function(){
        Route::get('/', ['uses' => 'EmployeeAttendanceController@listRequest']);
        Route::post('/', ['uses' => 'EmployeeAttendanceController@filterRequest']);
        Route::get('detail/{id}', ['uses' => 'EmployeeAttendanceController@detailRequest']);
        Route::post('detail/{id}', ['uses' => 'EmployeeAttendanceController@filterRequest']);
        Route::post('detail/{id}/update', ['uses' => 'EmployeeAttendanceController@updateRequest']);
    });

    Route::group(['prefix' => 'timeoff'], function()
	{
	    Route::any('/', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeTimeOffOvertimeController@listTimeOff']);
	    Route::any('create', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeTimeOffOvertimeController@createTimeOff']);
	    Route::post('list-employee', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeTimeOffOvertimeController@listEmployee']);
	    Route::post('list-date', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeTimeOffOvertimeController@listDate']);
	    Route::post('delete/{id}', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeTimeOffOvertimeController@deleteTimeOff']);
	    Route::get('detail/{id}', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeTimeOffOvertimeController@detailTimeOff']);
	    Route::post('update/{id}', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeTimeOffOvertimeController@updateTimeOff']);
	});

	Route::group(['prefix' => 'overtime'], function()
	{
	    Route::any('/', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeTimeOffOvertimeController@listOvertime']);
	    Route::any('create', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeTimeOffOvertimeController@createOvertime']);
	    Route::post('delete/{id}', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeTimeOffOvertimeController@deleteOvertime']);
	    Route::get('detail/{id}', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeTimeOffOvertimeController@detailOvertime']);
	    Route::post('update/{id}', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeTimeOffOvertimeController@updateOvertime']);
	});
	Route::group(['prefix' => 'income'], function()
	{
	    Route::any('/setting-delivery', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeIncomeController@setting_delivery']);
            Route::group(['prefix' => 'role'], function()
                {  
                    Route::post('basic-salary/create', ['middleware' => 'feature_control:396', 'uses' => 'EmployeeRoleController@create_basic']);	  	    
                    Route::any('detail/{id}', ['middleware' => 'feature_control:396', 'uses' => 'EmployeeRoleController@detail']);	  	    
                    Route::any('/', ['middleware' => 'feature_control:393', 'uses' => 'EmployeeRoleController@index']);	    	    
                    Route::post('fixed-incentive/create', ['middleware' => 'feature_control:396', 'uses' => 'EmployeeFixedIncentiveController@create_fixed_incentive']);
                     Route::group(['prefix' => 'incentive'], function()
                    {
                        Route::post('create', ['middleware' => 'feature_control:425', 'uses' => 'EmployeeIncentiveController@create_incentive']);	    
                            	
                    });	 	    
                     Route::group(['prefix' => 'salary-cut'], function()
                    {
                        Route::post('create', ['middleware' => 'feature_control:425', 'uses' => 'EmployeeSalaryCutController@create_salary_cut']);	    
                            	
                    });	 	    
                });
            Route::group(['prefix' => 'loan'], function()
            {
                Route::any('/category', ['middleware' => 'feature_control:428,429,430', 'uses' => 'EmployeeLoanController@index_category']);
                Route::post('/category/create', ['middleware' => 'feature_control:428,429,430', 'uses' => 'EmployeeLoanController@create_category']);
                Route::post('/category/delete/{id}', ['middleware' => 'feature_control:428,429,430', 'uses' => 'EmployeeLoanController@delete_category']);
                Route::any('/', ['middleware' => 'feature_control:428,429,430', 'uses' => 'EmployeeLoanController@index']);
                Route::post('/create', ['middleware' => 'feature_control:428,429,430', 'uses' => 'EmployeeLoanController@create']);
                Route::get('/detail/{id}', ['middleware' => 'feature_control:428,429,430', 'uses' => 'EmployeeLoanController@detail']);
            });
            Route::group(['prefix' => 'default'], function()
            {
                Route::group(['prefix' => 'incentive'], function()
            {
                Route::post('create', ['middleware' => 'feature_control:425', 'uses' => 'EmployeeIncentiveController@default_create_insentif']);	    
                Route::post('update', ['middleware' => 'feature_control:425', 'uses' => 'EmployeeIncentiveController@default_update_insentif']);	    
                Route::get('detail/{id}', ['middleware' => 'feature_control:425', 'uses' => 'EmployeeIncentiveController@default_detail_insentif']);	    
                Route::any('delete/{id}', ['middleware' => 'feature_control:425', 'uses' => 'EmployeeIncentiveController@default_delete_insentif']);	    
                Route::any('/', ['middleware' => 'feature_control:425', 'uses' => 'EmployeeIncentiveController@default_index_insentif']);	    	
            });
            Route::group(['prefix' => 'salary-cut'], function()
            {
                Route::post('create', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeSalaryCutController@default_create_salary_cut']);	    
                Route::post('update', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeSalaryCutController@default_update_salary_cut']);	    
                Route::get('detail/{id}', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeSalaryCutController@default_detail_salary_cut']);	    
                Route::any('delete/{id}', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeSalaryCutController@default_delete_salary_cut']);	    
                Route::any('/', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeSalaryCutController@default_index_salary_cut']);	 
            });
                Route::group(['prefix' => 'overtime'], function()
                {
                    Route::post('create', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeOvertimeController@default_create']);	    
                    Route::post('update', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeOvertimeController@default_update']);	    
                    Route::get('detail/{id}', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeOvertimeController@default_detail']);	    
                    Route::any('delete/{id}', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeOvertimeController@default_delete']);	    
                    Route::any('/', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeOvertimeController@default_index']);	      
                    Route::any('/detail/delete/{id}', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeOvertimeController@delete_detail']);	    

                });
                Route::group(['prefix' => 'fixed-incentive'], function()
                {
                    Route::post('create', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeFixedIncentiveController@default_create']);	    
                    Route::post('update', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeFixedIncentiveController@default_update']);	    
                    Route::get('detail/{id}', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeFixedIncentiveController@default_detail']);	    
                    Route::any('delete/{id}', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeFixedIncentiveController@default_delete']);	    
                    Route::any('/', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeFixedIncentiveController@default_index']);	    
                    Route::any('/type1', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeFixedIncentiveController@create_type1']);	    
                    Route::any('/type2', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeFixedIncentiveController@create_type2']);	    
                    Route::any('/detail/delete/{id}', ['middleware' => 'feature_control:426', 'uses' => 'EmployeeFixedIncentiveController@delete_detail']);	    

                });
                Route::any('/basic-salary', ['middleware' => 'feature_control:472', 'uses' => 'EmployeeIncomeController@default_basic_salary']);
                
            });
	});

});
