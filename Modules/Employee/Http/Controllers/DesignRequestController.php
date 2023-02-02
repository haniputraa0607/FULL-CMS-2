<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class DesignRequestController extends Controller
{
    public function createDesignRequest(Request $request){
        $post = $request->except('_token');
        
        if(empty($post)){
            $data = [
                'title'          => 'Design Request',
                'sub_title'      => 'Create Design Request',
                'menu_active'    => 'design-request',
                'submenu_active' => 'create-design-request',
            ];
            
            return view('employee::design_request.create', $data);
        }else{
            $result = MyHelper::post('employee/design-request/create', $post);
            if(isset($result['status']) && $result['status'] == 'success'){
                return redirect('employee/design-request/detail/'.$result['result']['id_design_request'])->withSuccess(['Success create a new design request']);
            }else{
                return redirect('employee/design-request')->withErrors($result['messages'] ?? ['Failed create a new design request']);
            }
        }
    }

    public function listDesignRequest(Request $request){
        $post = $request->all();

        $data = [
            'title'          => 'Design Request',
            'sub_title'      => 'List Design Request',
            'menu_active'    => 'design-request',
            'submenu_active' => 'list-design-request',
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
            Session::forget('filter-list-design-request');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-design-request') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-design-request');
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

        $list = MyHelper::post('employee/design-request/list'.$page, $post);
        
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
            Session::put('filter-list-design-request',$post);
        }
        return view('employee::design_request.list', $data);
    }

    public function rejectDesignRequest($id)
    {
        $reject_reqeust = [
            "id_design_request" => $id,
            "status" => 'Rejected'
        ];
        $rejected = MyHelper::post('employee/design-request/update', $reject_reqeust);
        return $rejected;
    }

    public function detailDesignRequest(Request $request, $id)
    {
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Design Request',
                'sub_title'      => 'Detail Design Request',
                'menu_active'    => 'design-request',
                'submenu_active' => 'list-design-request',
            ];  

            $result = MyHelper::post('employee/design-request/detail', ['id_design_request' => $id]);
            if(isset($result['status']) && $result['status'] == 'success'){
                $data['result'] = $result['result']['design_request'];
                return view('employee::design_request.detail', $data);
            }else{
                return redirect('recruitment/design-request')->withErrors($result['messages'] ?? ['Failed get detail design request']);
            }
        }else{
            if(isset($post['design_path'])){
                $post['original_name_design_path'] = $post['design_path']->getClientOriginalName();
                $post['design_path'] = MyHelper::encodeImage($post['design_path']);
            }
            $post['id_design_request'] = $id;
            $result = MyHelper::post('employee/design-request/update', $post);
            if(isset($result['status']) && $result['status'] == 'success'){
                return redirect('employee/design-request/detail/'.$id)->withSuccess(['Success update design request']);
            }else{
                return redirect('employee/design-request/detail/'.$id)->withErrors($result['messages'] ?? ['Failed update design request']);
            }
        }
    }
}
