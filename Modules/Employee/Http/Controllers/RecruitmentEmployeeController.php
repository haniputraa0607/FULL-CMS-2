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
        $vas = array();
        foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee'],date('Y-m-d H:i:s'));
            array_push($vas,$value);
        }
        if(($list['status']??'')=='success'){
            $data['data']          = $vas;
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
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Detail Employee',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-recruitment',
                'child_active'   => 'list-employee-recruitment',
                'url_back'      => 'employee/recruitment',
                'page_type'     => 'candidate'
            ];
        $data['id_enkripsi'] = $id;
        $id = MyHelper::explodeSlug($id)[0]??'';
        $detail = MyHelper::post('employee/be/recruitment/detail',['id_employee' => $id]);
        if(isset($detail['status']) && $detail['status'] == 'success'){
           $data['detail'] = $detail['result'];
           $data['roles'] = MyHelper::get('users/role/list-all')['result'] ?? [];
           $data['outlets'] = MyHelper::post('outlet/be/list',['office_only'=>1])['result'] ?? [];
           $data['bank'] = MyHelper::get('employee/be/recruitment/bank')['result'] ?? [];
           $data['cities'] = MyHelper::get('city/list')['result']??[];
           $data['departments'] = MyHelper::post('users/department',$request->all())['result']??[];
          return view('employee::employee.detail', $data);
        }else{
            return redirect('employee/recruitment')->withErrors($store['messages']??['Failed get detail candidate']);
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
       $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee'],date('Y-m-d H:i:s'));
            array_push($vas,$value);
        }
        if(($list['status']??'')=='success'){
            $data['data']          = $vas;
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
         $data = [
                'title'          => 'Recruitment',
                'sub_title'      => 'Candidate Employee',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-recruitment',
                'child_active'   => 'list-employee-recruitment-candidate',
                'url_back'      => 'employee/recruitment/candidate',
                'page_type'     => 'candidate'
            ];
        $data['id_enkripsi'] = $id;
        $id = MyHelper::explodeSlug($id)[0]??'';
       $detail = MyHelper::post('employee/be/recruitment/detail',['id_employee' => $id]);
        if(isset($detail['status']) && $detail['status'] == 'success'){
           
            $data['detail'] = $detail['result'];
            $data['roles'] = MyHelper::get('users/role/list-all')['result'] ?? [];
            $data['outlets'] = MyHelper::post('outlet/be/list',['office_only'=>1])['result'] ?? [];
            $data['bank'] = MyHelper::get('employee/be/recruitment/bank')['result'] ?? [];
            $data['cities'] = MyHelper::get('city/list')['result']??[];
            $data['departments'] = MyHelper::post('users/department',$request->all())['result']??[];
            
            return view('employee::employee.detail', $data);
        }else{
            return redirect('employee/recruitment/candidate')->withErrors($store['messages']??['Failed get detail candidate']);
        }
    }
     public function update(Request $request, $id){
        $post = $request->except('_token');
        $ids =  MyHelper::createSlug($id,date('Y-m-d H:i:s'));
        if($post['action_type'] == 'Approved'){
            if($post['status_employee'] == 'Permanent'){
                $post['start_date'] = date('Y-m-d', strtotime($post['start_date']));
            }else{
                if(!empty($post['start_date'])){
                    $post['start_date'] = date('Y-m-d', strtotime($post['start_date']));
                }
                if(!empty($post['end_date'])){
                    $post['end_date'] = date('Y-m-d', strtotime($post['end_date']));
                }
            }
        }
        
        if(empty($post['action_type'])){
            return redirect('employee/recruitment/candidate/detail/'.$ids)->withErrors(['Action type can not be empty']);
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
            return redirect('employee/recruitment/candidate/detail/'.$ids)->withSuccess(['Success update data to approved']);
        }elseif(isset($update['status']) && $update['status'] == 'success'){
            return redirect('employee/recruitment/candidate/detail/'.$ids.($post['action_type'] == "reject" ? '#hs-info': '#candidate-status'))->withSuccess(['Success update data to '.$post['update_type']??""]);
        }else{
            return redirect('employee/recruitment/candidate/detail/'.$ids)->withErrors($update['messages']??['Failed update data to approved']);
        }
    }
    public function reject(Request $request, $id){
        $post = $request->except('_token');
        $id = MyHelper::explodeSlug($id)[0]??'';
        $post['id_employee'] = $id;
        $update = MyHelper::post('employee/be/recruitment/reject',$post);
        return $update;
    }
    public function complement(Request $request, $id){
        $post = $request->except('_token');
        if(isset($post['form'])){
            if(isset($post['is_tax'])){
                $post['is_tax'] = 1;
            }else{
                $post['is_tax'] = 0;
            }
        }
        $ids = MyHelper::explodeSlug($id)[0]??'';
        $post['id_employee'] = $ids;
        $update = MyHelper::post('employee/be/recruitment/complement',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('employee/recruitment/detail/'.$id)->withSuccess(['Success update data']);
        }else{
            return redirect('employee/recruitment/detail/'.$id)->withErrors($update['messages']??['Failed update data']);
        }
    }
    public function contact_create(Request $request,$id){
        $post = $request->except('_token');
        $id = MyHelper::createSlug($id,date('Y-m-d H:i:s'));
        $update = MyHelper::post('employee/be/profile/emergency/create',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('employee/recruitment/detail/'.$id.'#contact')->withSuccess(['Success create contact data']);
        }else{
            return redirect('employee/recruitment/detail/'.$id.'#contact')->withErrors($update['messages']??['Failed update data']);
        }
    }
    public function contact_delete($id){
        $post['id_employee_emergency_contact'] = $id;
        $update = MyHelper::post('employee/be/profile/emergency/delete',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success delete contact data']);
        }else{
            return redirect()->back()->withErrors($update['messages']??['Failed update data']);
        }
    }

    public function CreateBusinessPartner(Request $request){
        $post = $request->except('_token');
        return $update = MyHelper::post('employee/be/recruitment/create-business-partner',$post);
    }
    public function manager(Request $request){
        $post = $request->except('_token');
        return $update = MyHelper::post('employee/be/recruitment/manager',$post)['result']??[];
    }

    public function deleteCustomLink($id){
        return $update = MyHelper::post('employee/be/recruitment/delete-custom-link', ['id_employee_custom_link' => $id]);
    }

    public function addCustomLink(Request $request, $id_employee){
        $post = $request->except('_token');
        $post['id_employee'] = $id_employee;
        return $update = MyHelper::post('employee/be/recruitment/add-custom-link', $post);
    }

    public function employeeEvaluation(Request $request, $id){
        $post = $request->except('_token');
        $post['id_employee_form_evaluation'] = $id;

        $update = MyHelper::post('employee/be/recruitment/evaluation',$post);
        if($post['status_form'] == 'reject_hr' || $post['status_form'] == 'reject_director' || $post['status_form'] == 'approve_director'){
            return $update;
        }else{
            if(isset($update['status']) && $update['status'] == 'success'){
                return redirect()->back()->withSuccess(['Success update data']);
            }else{
                return redirect()->back()->withErrors($update['messages']??['Failed update data']);
            }
        }
    }

    public function employeeEvaluationDelete($id){
        return $update = MyHelper::post('employee/be/recruitment/evaluation/delete', ['id_employee_form_evaluation' => $id]);
    }

    public function employeeEvaluationNew(Request $request, $id){
        $post = $request->except('_token');
        $post['id_employee'] = $id;

        $update = MyHelper::post('employee/be/recruitment/evaluation',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success update data']);
        }else{
            return redirect()->back()->withErrors($update['messages']??['Failed update data']);
        }
        
    }
}
