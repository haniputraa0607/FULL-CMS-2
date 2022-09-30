<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeChangeShiftController extends Controller
{
    public function listChangeShift(Request $request)
    {
        $rule = false;
        $post = $request->all();
        $data = [
            'title'          	=> 'Employee',
            'sub_title'      	=> 'List Request Employee Change Shift',
            'menu_active'    	=> 'employee',
            'submenu_active' 	=> 'employee-timeoff-overtime',
            'child_active' 		=> 'employee-changeshift-list',
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
            Session::forget('filter-list-employee-change-shift');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-employee-change-shift') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-employee-change-shift');
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

        $list = MyHelper::post('employee/change-shift/list'.$page, $post);

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
            Session::put('filter-list-employee-change-shift',$post);
        }

        return view('employee::change-shift.list', $data);
    }

    public function deleteChangeShift($id)
    {
        $result = MyHelper::post("employee/change-shift/delete", ['id_employee_change_shift' => $id]);
        return $result;
    }

    public function detailChangeShift($id)
    {
        $data = [
            'title'          	=> 'Employee',
            'sub_title'      	=> 'Detail Request Employee Time Off',
            'menu_active'    	=> 'employee',
            'submenu_active' 	=> 'employee-timeoff-overtime',
            'child_active' 		=> 'employee-changeshift-list',
        ];
        $result = MyHelper::post('employee/change-shift/detail', ['id_employee_change_shift' => $id]);
        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result']['change_shift'];
            $data['result']['month_change'] = date('m', strtotime( $data['result']['change_shift_date']));
            $data['result']['year_change'] = date('Y', strtotime( $data['result']['change_shift_date']));
            $list = MyHelper::post('employee/change-shift/list-date', ['id_employee' => $data['result']['user']['id'],'month' => $data['result']['month_change'],'year' => $data['result']['year_change']])['result'] ?? [];
            $data['result']['change_list_date'] = $list['list_dates'];
            $data['result']['list_shift'] = $list['shifts'];
            // return $data;
            return view('employee::change-shift.detail', $data);
        }else{
            return redirect('employee/timeoff')->withErrors($result['messages'] ?? ['Failed get detail employee request time off']);
        }
    }

    public function listDate(Request $request)
    {
        $post = $request->except('_token');
        $list_date = MyHelper::post('employee/change-shift/list-date', $post);
        return $list_date;
    }

    public function updateChangeShift(Request $request,$id){
        $post = $request->except('_token');
        $post['id_employee_change_shift'] = $id;
        $update = MyHelper::post('employee/change-shift/update', $post);
        if(isset($post['approve'])){
            return $update;
        }
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('employee/changeshift/detail/'.$id)->withSuccess(['Success udpated employee request change shift']);
        }else{
            return redirect('employee/changeshift/detail/'.$id)->withErrors($result['messages'] ?? ['Failed updated employee request change shift']);
        }
    }
}
