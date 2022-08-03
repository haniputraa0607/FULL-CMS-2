<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeTimeOffOvertimeController extends Controller
{
    public function listTimeOff(Request $request)
    {
        $rule = false;
        $post = $request->all();
        $data = [
            'title'          	=> 'Employee',
            'sub_title'      	=> 'List Request Employee Time Off',
            'menu_active'    	=> 'employee',
            'submenu_active' 	=> 'employee-timeoff-overtime',
            'child_active' 		=> 'employee-timeoff-list',
        ];
        
        $order = 'created_at';
        $orderType = 'desc';
        $sorting = 0;
        if(isset($post['sorting'])){
            $sorting = 1;
            $order = $post['order'];
            $orderType = $post['order_type'];
        }
        if(isset($post['reset']) && $post['reset'] == 1){
            Session::forget('filter-list-employee-time-off');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-employee-time-off') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-employee-time-off');
            $post['page'] = $pageSession;
            if($sorting == 0 && !empty($post['order'])){
                $order = $post['order'];
                $orderType = $post['order_type'];
            }
        }
        $page = '?page=1';
        if(isset($post['page'])){
            $page = '?page='.$post['page'];
        }
        $data['order'] = $order;
        $data['order_type'] = $orderType;
        $post['order'] = $order;
        $post['order_type'] = $orderType;

        $list = MyHelper::post('employee/timeoff/list'.$page, $post);

        if(($list['status']??'')=='success'){
            $data['data']          = $list['result']['data'];
            $data['data_total']     = $list['result']['total'];
            $data['data_per_page']   = $list['result']['from'];
            $data['data_up_to']      = $list['result']['from'] + count($list['result']['data'])-1;
            $data['data_paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
            $data['rule'] = $rule;
        }else{
            $data['data']          = [];
            $data['data_total']     = 0;
            $data['data_per_page']   = 0;
            $data['data_up_to']      = 0;
            $data['data_paginator'] = false;
            $data['rule'] = false;
        }

        if($post){
            Session::put('filter-list-employee-time-off',$post);
        }

        return view('employee::timeoff.list', $data);
    }

    public function createTimeOff(Request $request)
    {
        $post = $request->except('_token');
        if(empty($post)){
            $data = [
                'title'          	=> 'Employee',
                'sub_title'      	=> 'Create Request Employee Time Off',
                'menu_active'    	=> 'employee',
                'submenu_active' 	=> 'employee-timeoff-overtime',
                'child_active' 		=> 'employee-timeoff-create',
            ];
            
            $data['employees'] = MyHelper::post('employee/list', [])['result']['data'] ?? [];
            $data['offices'] = MyHelper::get('mitra/request/office')['result'] ?? [];
            return view('employee::timeoff.create', $data);
        }else{
            $store = MyHelper::post('employee/timeoff/create', $post);
            if(isset($store['status']) && $store['status'] == 'success'){
                return redirect('employee/timeoff/detail/'.$store['result']['id_employee_time_off'])->withSuccess(['Success created employee request time off']);
            }else{
                return redirect('employee/timeoff')->withErrors($result['messages'] ?? ['Failed create employee request time off']);
            }
        }
    }

    public function listEmployee(Request $request)
    {
        $post = $request->except('_token');
        $list_employee = MyHelper::post('employee/timeoff/list-employee', $post);
        return $list_employee;
    }

    public function listDate(Request $request)
    {
        $post = $request->except('_token');
        $list_date = MyHelper::post('employee/timeoff/list-date', $post);
        return $list_date;
    }

    public function detailTimeOff($id)
    {
        $data = [
            'title'          	=> 'Employee',
            'sub_title'      	=> 'Detail Request Employee Time Off',
            'menu_active'    	=> 'employee',
            'submenu_active' 	=> 'employee-timeoff-overtime',
            'child_active' 		=> 'employee-timeoff-list',
        ];
        $result = MyHelper::post('employee/timeoff/detail', ['id_employee_time_off' => $id]);
        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result']['time_off'];
            $data['result']['month'] = date('m', strtotime( $data['result']['date']));
            $data['result']['year'] = date('Y', strtotime( $data['result']['date']));
            $data['result']['list_date'] = MyHelper::post('employee/timeoff/list-date', ['id_employee' => $data['result']['employee']['id'],'month' => $data['result']['month'],'year' => $data['result']['year']])['result'] ?? [];
            // return $data;
            return view('employee::timeoff.detail', $data);
        }else{
            return redirect('employee/timeoff')->withErrors($result['messages'] ?? ['Failed get detail employee request time off']);
        }
    }

    public function updateTimeOff(Request $request, $id)
    {
        $post = $request->except('_token');
        $post['id_employee_time_off'] = $id;
        $update = MyHelper::post('employee/timeoff/update', $post);
        if(isset($post['approve'])){
            return $update;
        }
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('employee/timeoff/detail/'.$id)->withSuccess(['Success udpated employee request time off']);
        }else{
            return redirect('employee/timeoff/detail/'.$id)->withErrors($result['messages'] ?? ['Failed updated employee request time off']);
        }
    }

    public function deleteTimeOff($id)
    {
        $result = MyHelper::post("employee/timeoff/delete", ['id_employee_time_off' => $id]);
        return $result;
    }

    //overtime

    public function createOvertime(Request $request)
    {
        $post = $request->except('_token');
        if(empty($post)){
            $data = [
                'title'          	=> 'Recruitment',
                'sub_title'      	=> 'Create Request Employee Overtime',
                'menu_active'    	=> 'employee',
                'submenu_active' 	=> 'employee-timeoff-overtime',
                'child_active' 		=> 'employee-overtime-create',
            ];
            
            $data['employees'] = MyHelper::post('employee/list', [])['result']['data'] ?? [];
            $data['offices'] = MyHelper::get('mitra/request/office')['result'] ?? [];
            return $data;
            return view('employee::overtime.create', $data);
        }else{
            $store = MyHelper::post('employee/overtime/create', $post);
            if(isset($store['status']) && $store['status'] == 'success'){
                return redirect('employee/overtime/detail/'.$store['result']['id_employee_overtime'])->withSuccess(['Success created employee request overtime']);
            }else{
                return redirect('employee/overtime')->withErrors($result['messages'] ?? ['Failed create employee request overtime']);
            }
        }
    }

    public function listOvertime(Request $request)
    {
        $rule = false;
        $post = $request->all();
        $data = [
            'title'          	=> 'Employee',
            'sub_title'      	=> 'List Request Employee Overtime',
            'menu_active'    	=> 'employee',
            'submenu_active' 	=> 'employee-timeoff-overtime',
            'child_active' 		=> 'employee-overtime-list',
        ];
        
        $order = 'created_at';
        $orderType = 'desc';
        $sorting = 0;
        if(isset($post['sorting'])){
            $sorting = 1;
            $order = $post['order'];
            $orderType = $post['order_type'];
        }
        if(isset($post['reset']) && $post['reset'] == 1){
            Session::forget('filter-employee-list-overtime');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-employee-list-overtime') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-employee-list-overtime');
            $post['page'] = $pageSession;
            if($sorting == 0 && !empty($post['order'])){
                $order = $post['order'];
                $orderType = $post['order_type'];
            }
        }
        $page = '?page=1';
        if(isset($post['page'])){
            $page = '?page='.$post['page'];
        }
        $data['order'] = $order;
        $data['order_type'] = $orderType;
        $post['order'] = $order;
        $post['order_type'] = $orderType;

        $list = MyHelper::post('employee/overtime/list'.$page, $post);

        if(($list['status']??'')=='success'){
            $data['data']          = $list['result']['data'];
            $data['data_total']     = $list['result']['total'];
            $data['data_per_page']   = $list['result']['from'];
            $data['data_up_to']      = $list['result']['from'] + count($list['result']['data'])-1;
            $data['data_paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
            $data['rule'] = $rule;
        }else{
            $data['data']          = [];
            $data['data_total']     = 0;
            $data['data_per_page']   = 0;
            $data['data_up_to']      = 0;
            $data['data_paginator'] = false;
            $data['rule'] = false;
        }

        if($post){
            Session::put('filter-employee-list-overtime',$post);
        }

        return view('employee::overtime.list', $data);
    }

    public function detailOvertime($id)
    {  
        $data = [
            'title'          	=> 'Employee',
            'sub_title'      	=> 'Detail Request Employee Overtime',
            'menu_active'    	=> 'employee',
            'submenu_active' 	=> 'employee-timeoff-overtime',
            'child_active' 		=> 'employee-overtime-list',
        ];
        $result = MyHelper::post('employee/overtime/detail', ['id_employee_overtime' => $id]);

        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result']['time_off'];
            $data['result']['month'] = date('m', strtotime( $data['result']['date']));
            $data['result']['year'] = date('Y', strtotime( $data['result']['date']));
            $data['result']['list_date'] = MyHelper::post('employee/timeoff/list-date', ['id_employee' => $data['result']['employee']['id'],'month' => $data['result']['month'],'year' => $data['result']['year']])['result'] ?? [];
            $time = MyHelper::post('employee/timeoff/list-date', ['id_employee' => $data['result']['employee']['id'],'month' => $data['result']['month'],'year' => $data['result']['year'], 'date' => $data['result']['date'], 'type' => 'getDetail'])['result'] ?? [];
            // return $data;
            return view('employee::overtime.detail', $data);
        }else{
            return redirect('employee/overtime')->withErrors($result['messages'] ?? ['Failed get detail employee request overtime']);
        }
    }

    public function updateOvertime(Request $request, $id)
    {
        $post = $request->except('_token');
        $post['id_employee_overtime'] = $id;
        return $update = MyHelper::post('employee/overtime/update', $post);

        if(isset($post['approve'])){
            return $update;
        }
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('employee/overtime/detail/'.$id)->withSuccess(['Success udpated employee request overtime']);
        }else{
            return redirect('employee/overtime/detail/'.$id)->withErrors($result['messages'] ?? ['Failed updated employee request overtime']);
        }
    }

    public function deleteOvertime($id)
    {
        $result = MyHelper::post("employee/overtime/delete", ['id_employee_overtime' => $id]);
        return $result;
    }
}
