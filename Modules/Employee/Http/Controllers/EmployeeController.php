<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class EmployeeController extends Controller
{
    public function officeHoursCreate(Request $request){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Office Hours',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-office-hours',
                'child_active'   => 'employee-office-hours-new'
            ];

            return view('employee::office_hours.create', $data);
        }else{
            $save = MyHelper::post('employee/office-hours/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('employee/office-hours')->withSuccess(['Success save data']);
            }else{
                return redirect('employee/office-hours/create')->withErrors($save['messages']??['Failed save data']);
            }
        }
    }

    public function officeHoursDetail(Request $request, $id){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Office Hours Detail',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-office-hours',
                'child_active'   => 'employee-office-hours-list'
            ];

            $data['detail'] = MyHelper::post('employee/office-hours/detail', ['id_employee_office_hour' => $id])['result']??[];
            return view('employee::office_hours.detail', $data);
        }else{
            $post['id_employee_office_hour'] = $id;
            $update = MyHelper::post('employee/office-hours/update', $post);
            if (isset($update['status']) && $update['status'] == "success") {
                return redirect('employee/office-hours/detail/'.$id)->withSuccess(['Success update detail']);
            }else{
                return redirect('employee/office-hours')->withErrors($save['messages']??['Failed update detail']);
            }
        }
    }

    public function officeHoursList(){
        $data = [
            'title'          => 'Employee',
            'sub_title'      => 'Office Hours List',
            'menu_active'    => 'employee',
            'submenu_active' => 'employee-office-hours',
            'child_active'   => 'employee-office-hours-list'
        ];

        $data['list'] = MyHelper::get('employee/office-hours')['result']??[];
        return view('employee::office_hours.list', $data);
    }

    public function officeHoursDelete(Request $request){
        $post = $request->except('_token');
        $delete = MyHelper::post('employee/office-hours/delete', $post);
        return $delete;
    }

    public function assignOfficeHoursCreate(Request $request){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Assign Office Hours',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-assign-office-hours',
                'child_active'   => 'employee-assign-office-hours-new'
            ];

            $data['job_levels'] = MyHelper::post('users/job-level',[])['result']??[];
            $data['departments'] = MyHelper::post('users/department',[])['result']??[];
            $data['office_hours'] = MyHelper::get('employee/office-hours')['result']??[];

            return view('employee::assign_office_hours.create', $data);
        }else{
            $save = MyHelper::post('employee/assign-office-hours/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('employee/assign-office-hours')->withSuccess(['Success save data']);
            }else{
                return redirect('employee/assign-office-hours/create')->withErrors($save['messages']??['Failed save data']);
            }
        }
    }

    public function assignOfficeHoursList(){
        $data = [
            'title'          => 'Employee',
            'sub_title'      => 'Assign Office Hours List',
            'menu_active'    => 'employee',
            'submenu_active' => 'employee-assign-office-hours',
            'child_active'   => 'employee-assign-office-hours-list'
        ];

        $data['list'] = MyHelper::get('employee/assign-office-hours')['result']??[];
        return view('employee::assign_office_hours.list', $data);
    }

    public function assignOfficeHoursDetail(Request $request, $id){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Assign Office Hours Detail',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-assign-office-hours',
                'child_active'   => 'employee-assign-office-hours-list'
            ];

            $data['job_levels'] = MyHelper::post('users/job-level',[])['result']??[];
            $data['departments'] = MyHelper::post('users/department',[])['result']??[];
            $data['office_hours'] = MyHelper::get('employee/office-hours')['result']??[];
            $data['detail'] = MyHelper::post('employee/assign-office-hours/detail', ['id_employee_office_hour_assign' => $id])['result']??[];
            return view('employee::assign_office_hours.detail', $data);
        }else{
            $post['id_employee_office_hour_assign'] = $id;
            $update = MyHelper::post('employee/assign-office-hours/update', $post);
            if (isset($update['status']) && $update['status'] == "success") {
                return redirect('employee/assign-office-hours/detail/'.$id)->withSuccess(['Success update detail']);
            }else{
                return redirect('employee/assign-office-hours')->withErrors($save['messages']??['Failed update detail']);
            }
        }
    }

    public function assignOfficeHoursDelete(Request $request){
        $post = $request->except('_token');
        $delete = MyHelper::post('employee/assign-office-hours/delete', $post);
        return $delete;
    }
}
