<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class RecruitmentEmployeeController extends Controller
{
    public function create(Request $request){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Create Employee',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-create',
            ];
            $data['city'] = MyHelper::get('city/list')['result']??null;
            return view('employee::employee.create', $data);
        }else{
            return $post;
        }
    }
    public function index(Request $request){
      
         $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'List Employee',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-recruitment',
                'child_active'   => 'list-employee-recruitment',
            ];
            $data['status'] = 'Candidate';
            $session = "filter-list-employee";
         if( ($post['rule']??false) && !isset($post['draw']) ){
             session([$session => $post]);
        }elseif($post['clear']??false){
            session([$session => null]);
        }
        if(isset($post['reset']) && $post['reset'] == 1){
            Session::forget($session);
        }elseif(Session::has($session) && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get($session);
            $post['page'] = $pageSession;
            
        }
        if(isset($post['rule'])){
        	$data['rule'] = array_map('array_values', $post['rule']);
        }
        $page = '?page=1';
        if(isset($post['page'])){
            $page = '?page='.$post['page'];
        }
        $post['status'] = $data['status'];
        $list = MyHelper::post('employee/be/recruitment'.$page, $post);
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
            Session::put($session,$post);
        }
        return view('employee::employee.index', $data);
    }
    public function detail(Request $request,$id){
        $post = $request->all();
        $detail = MyHelper::post('employee/be/recruitment/detail',['id_employee' => $id]);
        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Detail Employee',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-recruitment',
                'child_active'   => 'list-employee-recruitment',
                'url_back'      => 'employee/recruitment',
                'page_type'     => 'candidate'
            ];
           $data['detail'] = $detail['result'];
           return view('employee::employee.detail', $data);
        }else{
            return redirect('employee/recruitment/candidate')->withErrors($store['messages']??['Failed get detail candidate']);
        }
    }
    public function candidate(Request $request){
      
         $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Candidate Employee',
                'sub_title'      => 'List Candidate Employee',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-recruitment',
                'child_active'   => 'list-employee-recruitment-candidate',
            ];
            $data['status'] = 'Candidate';
            $session = "filter-list-candidate-employee";
         if( ($post['rule']??false) && !isset($post['draw']) ){
             session([$session => $post]);
        }elseif($post['clear']??false){
            session([$session => null]);
        }
        if(isset($post['reset']) && $post['reset'] == 1){
            Session::forget($session);
        }elseif(Session::has($session) && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get($session);
            $post['page'] = $pageSession;
            
        }
        if(isset($post['rule'])){
        	$data['rule'] = array_map('array_values', $post['rule']);
        }
        $page = '?page=1';
        if(isset($post['page'])){
            $page = '?page='.$post['page'];
        }
        $post['status'] = $data['status'];
        $list = MyHelper::post('employee/be/recruitment/candidate'.$page, $post);
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
            Session::put($session,$post);
        }
        return view('employee::employee.list', $data);
    }
    public function detailcandidate(Request $request,$id){
        $post = $request->all();
        $detail = MyHelper::post('employee/be/recruitment/detail',['id_employee' => $id]);
        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data = [
                'title'          => 'Recruitment',
                'sub_title'      => 'Candidate Employee',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-recruitment',
                'child_active'   => 'list-employee-recruitment-candidate',
                'url_back'      => 'employee/recruitment/candidate',
                'page_type'     => 'candidate'
            ];
            $data['detail'] = $detail['result'];
            return view('employee::employee.detail', $data);
        }else{
            return redirect('employee/recruitment/candidate')->withErrors($store['messages']??['Failed get detail candidate']);
        }
    }
     public function candidateUpdate(Request $request, $id){
        $post = $request->except('_token');
        if(!empty($post['start_date'])){
            $post['start_date'] = date('Y-m-d', strtotime($post['start_date']));
        }
        if(!empty($post['end_date'])){
            $post['end_date'] = date('Y-m-d', strtotime($post['end_date']));
        }
        if(empty($post['action_type'])){
            return redirect('employee/recruitment/candidate/detail/'.$id)->withErrors(['Action type can not be empty']);
        }
        $post['id_employee'] = $id;
        $post['update_type'] = $post['action_type'];
        if(!empty($post['data_document'])){
            if(!empty($post['data_document']['attachment'])){
                $post['data_document']['ext'] = pathinfo($post['data_document']['attachment']->getClientOriginalName(), PATHINFO_EXTENSION);
                $post['data_document']['attachment'] = MyHelper::encodeImage($post['data_document']['attachment']);
            }
        }
        $update = MyHelper::post('employee/be/recruitment/update',$post);
        if(isset($update['status']) && $update['status'] == 'success' && $post['update_type'] == 'approve'){
            return redirect('employee/recruitment/candidate/detail/'.$id)->withSuccess(['Success update data to approved']);
        }elseif(isset($update['status']) && $update['status'] == 'success'){
            return redirect('employee/recruitment/candidate/detail/'.$id.($post['action_type'] == "reject" ? '#hs-info': '#candidate-status'))->withSuccess(['Success update data to '.$post['update_type']??""]);
        }else{
            return redirect('employee/recruitment/candidate/detail/'.$id)->withErrors($update['messages']??['Failed update data to approved']);
        }
    }
}
