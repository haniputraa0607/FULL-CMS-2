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

            if(empty($data['detail'])){
                return redirect('employee/office-hours')->withErrors(['Data not found']);
            }
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

        $data['default'] = MyHelper::get('employee/office-hours/default')['result']??null;
        $data['list'] = MyHelper::get('employee/office-hours')['result']??[];
        return view('employee::office_hours.list', $data);
    }

    public function officeHoursDelete(Request $request){
        $post = $request->except('_token');
        $delete = MyHelper::post('employee/office-hours/delete', $post);
        return $delete;
    }

    public function assign(Request $request){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Assigned Office Hours',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-office-hours',
                'child_active'   => 'employee-assigned-office-hours-list'
            ];

            $data['list'] = MyHelper::get('employee/office-hours/assign')['result']??[];
            $data['list_employee_office_hours'] = MyHelper::get('employee/office-hours')['result']??[];
            return view('employee::office_hours.assigned_list', $data);
        }else{
            $save = MyHelper::post('employee/office-hours/assign', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('employee/office-hours/assign')->withSuccess(['Success save data']);
            }else{
                return redirect('employee/office-hours/assign')->withErrors($save['messages']??['Failed save data']);
            }
        }
    }

    public function privacyPolicy(Request $request){
        $post = $request->except('_token');
        if(empty($post)){
            $data = [
                'title'          => 'Employee',
                'menu_active'    => 'employeeem',
                'submenu_active' => 'employee-privacy-policy',
                'sub_title'       => 'Privacy Policy',
                'subTitle'       => 'Privacy Policy',
                'label'          => 'Privacy Policy',
                'colLabel'       => 2,
                'colInput'       => 10,
                'key'            => 'value_text',
                'value'    => null,
            ];
            
            $result = MyHelper::get('employee/be/profile/privacy-policy')['result']??[];
            if($result){
                $data['id'] = $result['id_setting'];

                if (is_null($data['key'])) {
                    if (is_null($result['value'])) {
                        $data['key'] = 'value_text';
                    } else {
                        $data['key'] = 'value';
                    }
                }
                $data['value'] = $result[$data['key']];
            }
            return view('employee::privacy_policy', $data);
        }else{
            $update = MyHelper::post('employee/be/profile/privacy-policy/update', [$post['key'] => $post['value']]);
            if (isset($update['status']) && $update['status'] == "success") {
                return back()->withSuccess(['Success save data']);
            }else{
                return back()->withErrors(['Failed save data']);
            }
        }
    }
}
