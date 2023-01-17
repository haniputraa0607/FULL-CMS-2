<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Session;

class RequestEmployeeController extends Controller
{
    public function createRequest(Request $request){
        $post = $request->except('_token');
        
        if(empty($post)){
            $data = [
                'title'          => 'Request Employee',
                'sub_title'      => 'New Request Employee',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-recruitment',
                'child_active'   => 'create-request-employee',
            ];  
            $data['office'] = MyHelper::post('outlet/be/list', ['office_only' => true])['result'] ?? [];
            $data['department'] = MyHelper::post('users/department/list-department', [])['result'] ?? [];
            return view('employee::request.new', $data);
        }else{
            $result = MyHelper::post('employee/request/create', $post);
            if(isset($result['status']) && $result['status'] == 'success'){
                return redirect('employee/request/detail/'.$result['result']['id_request_employee'])->withSuccess(['Success create a new request employee']);
            }else{
                return redirect('employee/request/detail/'.$result['result']['id_request_employee'])->withErrors($result['messages'] ?? ['Failed create a new request employee']);
            }
        }
    }

    public function detailRequest(Request $request, $id){
        $post = $request->except('_token');

        if(empty($post)){
            $result = MyHelper::post('employee/request/detail', ['id_request_employee' => $id]);
            $data = [
                'title'          => 'Request Employee',
                'sub_title'      => 'Detail Request Employee',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-recruitment',
                'child_active'   => 'list-request-employee',
            ]; 
            $list_employee = MyHelper::post('employee/request/list-employee', ['id_outlet' => $result['result']['request_employee']['id_outlet'], 'id_department' => $result['result']['request_employee']['id_department']])??[];
            if(isset($result['status']) && $result['status'] == 'success'){
                $data['result'] = $result['result']['request_employee'];
                $data['result']['url_applicant'] = url('user/detail').'/'.$data['result']['applicant_request']['phone'];
                $data['employees'] = $list_employee;
                return view('employee::request.detail', $data);
            }else{
                return redirect('recruitment/request')->withErrors($result['messages'] ?? ['Failed get detail request hair stylist']);
            }
        }else{
            $request->validate([
                "outlate_name" => "required",
                "number_of_request" => "required",
            ]);
            $old_req = MyHelper::post('employee/request/detail', ['id_request_employee' => $id]);
            $old_req = $old_req['result']['request_employee'];
            if(isset($post['status']) && $post['status']=='on'){
                $request->validate([
                    "notes" => "required",
                ]);
                $post['notes'] = $request['notes'];
                $post['status'] = 'Approved';
                if(isset($post['id_employee'])){
                    $count = count($post['id_employee']);
                    if($count==$post['number_of_request']){
                        $post['status'] = 'Done Approved';
                    }else{
                        $post['status'] = 'Approved';
                    }
                }
                $post['id_employee'] = [
                    "id" => $request['id_employee'],
                ];
                $post['id_employee'] = json_encode($post['id_employee']);
            }elseif(isset($post['status'])){
                if (isset($post['notes'])) {
                    $post['notes'] = $post['notes'];
                }else{
                    $post['notes'] = null;
                }
                if (isset($post['id_employee'])) {
                    $post['id_employee'] = [
                        "id" => $post['id_employee'],
                    ];
                    $post['id_employee'] = json_encode($post['id_employee']);
                }else{
                    $post['id_employee'] = null;
                }
            }else{
                $post['notes'] = null;
                if($old_req['status']=='Approved'){
                    $post['status'] = 'Request';
                }else{
                    $post['status'] = $old_req['status'];
                }
                $post['id_employee'] = null;
            }
            $post['id_request_employee'] = $id;   
            $result = MyHelper::post('employee/request/update', $post);
            if(isset($result['status']) && $result['status'] == 'success'){
                return redirect('employee/request/detail/'.$id)->withSuccess(['Success update request employee']);
            }else{
                return redirect('employee/request/detail/'.$id)->withErrors($result['messages'] ?? ['Failed update request employee']);
            }
        }
    }

    public function deleteRequest($id)
    {
        $result = MyHelper::post("employee/request/delete", ['id_request_employee' => $id]);
        return $result;
    }

    public function rejectRequest($id)
    {
        $reject_reqeust = [
            "id_request_employee" => $id,
            "status" => 'Rejected'
        ];
        $rejected = MyHelper::post('employee/request/update', $reject_reqeust);
        return $rejected;
    }

    public function indexRequest(Request $request){
        $post = $request->all();

        $data = [
            'title'          => 'Request Employee',
            'sub_title'      => 'List Request Employee',
            'menu_active'    => 'employee',
            'submenu_active' => 'employee-recruitment',
            'child_active'   => 'list-request-employee',
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
            Session::forget('filter-list-req-employee');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-req-employee') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-req-employee');
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
        // return $post;
        $list = MyHelper::post('employee/request/list'.$page, $post);
        foreach($list['result']['data'] as $i => $req){
            if($req['id_employee']==null){
                $list['result']['data'][$i]['count'] = 0;
            }else{
                $json = json_decode($req['id_employee']??'' , true);
                if(is_array($json)){
                    $list['result']['data'][$i]['count'] = count((is_countable($json['id'])?$json['id']:[]));
                }
            }
        }
        $list;
        if(($list['status']??'')=='success'){
            $data['data']          = $list['result']['data'];
            $data['data_total']     = $list['result']['total'];
            $data['data_per_page']   = $list['result']['from'];
            $data['data_up_to']      = $list['result']['from'] + count($list['result']['data'])-1;
            $data['data_paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['data']          = [];
            $data['data_total']     = 0;
            $data['data_per_page']   = 0;
            $data['data_up_to']      = 0;
            $data['data_paginator'] = false;
        }
        if($post){
            Session::put('filter-list-req-employee',$post);
        }
        return view('employee::request.list', $data);
    }

    public function finishRequest($id)
    {
        $result = MyHelper::post("employee/request/finish", ['id_request_employee' => $id]);
        return $result;
    }
}
