<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class EmployeeReimbursementController extends Controller
{
    public function index(Request $request){
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Reimbursement Pending',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-reimbursement',
                'child_active'   => 'employee-reimbursement-pending',
            ];
            $session = "filter-list-employee-reimbursement";
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
       $list = MyHelper::post('employee/be/reimbursement'.$page, $post);
       $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_reimbursement'],date('Y-m-d H:i:s'));
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
        return view('employee::reimbursement.index', $data);
    }
    public function detail($id)
    {
        $id = MyHelper::explodeSlug($id)[0]??'';
         $data = [ 
                    'title'          => 'Employee',
                    'sub_title'      => 'Detail Employee Reimbursement',
                    'menu_active'    => 'employee',
                    'submenu_active'   => 'employee-reimbursement',
                    'child_active'   => 'employee-reimbursement-pending',
                ];
      $data['data'] = MyHelper::post('employee/be/reimbursement/detail',['id_employee_reimbursement'=>$id])['result']??[];
       if($data['data']){
        return view('employee::reimbursement.detail',$data);
       }
       return redirect()->back()->withErrors(['Reimbursement not found']);
    }
    public function create(Request $request)
    {
        $post = $request->except('_token');
        $query = MyHelper::post('employee/be/reimbursement/approved',$post);
        if(isset($query['status']) && $query['status'] != 'success'){
                return redirect(url()->previous())->withErrors($query['messages']);
        }
         return redirect(url()->previous())->withSuccess(['Update Data Success']);
    }
    public function index_action(Request $request){
      
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'History Employee Reimbursement',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-reimbursement',
                'child_active'   => 'employee-reimbursement-history',
            ];
            $session = "filter-list-employee-reimbursement-history";
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
       $list = MyHelper::post('employee/be/reimbursement/list'.$page, $post);
       $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_reimbursement'],date('Y-m-d H:i:s'));
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
        return view('employee::reimbursement.list', $data);
    }
    public function manager(Request $request){
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Reimbursement Manager',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-reimbursement',
                'child_active'   => 'employee-reimbursement-manager',
            ];
            $session = "filter-list-employee-reimbursement-manager";
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
       $list = MyHelper::post('employee/be/reimbursement/manager'.$page, $post);
       $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_reimbursement'],date('Y-m-d H:i:s'));
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
        return view('employee::reimbursement.manager', $data);
    }
    public function manager_detail($id)
    {
         $data = [ 
                    'title'          => 'Employee',
                    'sub_title'      => 'Detail Employee Reimbursement',
                    'menu_active'    => 'employee',
                    'submenu_active'   => 'employee-reimbursement',
                    'child_active'   => 'employee-reimbursement-pending',
                ];
         $id = MyHelper::explodeSlug($id)[0]??'';
       $data['data'] = MyHelper::post('employee/be/reimbursement/detail',['id_employee_reimbursement'=>$id])['result']??[];
       if($data['data']){
        return view('employee::reimbursement.manager_detail',$data);
       }
       return redirect()->back()->withErrors(['Reimbursement not found']);
    }
    public function update(Request $request,$id) {
        $post = $request->except('_token');
        if($post['action_type'] == 'Approved'){
            if(!empty($post['status_employee'])){
                $post['status_employee'] = 1;
                $post['start_date'] = date('Y-m-d', strtotime($post['start_date']));
            }else{
                $post['status_employee'] = 0;
                if(!empty($post['start_date'])){
                    $post['start_date'] = date('Y-m-d', strtotime($post['start_date']));
                }
                if(!empty($post['end_date'])){
                    $post['end_date'] = date('Y-m-d', strtotime($post['end_date']));
                }
            }
        }
        
        if(empty($post['action_type'])){
            return back()->withErrors(['Action type can not be empty']);
        }
        $post['id_employee_reimbursement'] = $id;
        $post['update_type'] = $post['action_type'];
        if(!empty($post['data_document'])){
            if(!empty($post['data_document']['attachment'])){
                $post['data_document']['ext'] = pathinfo($post['data_document']['attachment']->getClientOriginalName(), PATHINFO_EXTENSION);
                $post['data_document']['attachment'] = MyHelper::encodeImage($post['data_document']['attachment']);
            }
        }
        $update = MyHelper::post('employee/be/reimbursement/update',$post);
       if(isset($update['status']) && $update['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success update data to '.$post['update_type']??""]);
        }else{
            return redirect()->back()->withErrors($update['messages']??['Failed update data to approved']);
        }
    }
    public function director(Request $request){
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Reimbursement Pending',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-reimbursement',
                'child_active'   => 'employee-reimbursement-director',
            ];
            $session = "filter-list-employee-reimbursement";
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
       $list = MyHelper::post('employee/be/reimbursement'.$page, $post);
       $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_reimbursement'],date('Y-m-d H:i:s'));
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
        return view('employee::reimbursement.index', $data);
    }
    public function hrga(Request $request){
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Reimbursement Pending',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-reimbursement',
                'child_active'   => 'employee-reimbursement-hrga',
            ];
            $session = "filter-list-employee-reimbursement";
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
       $list = MyHelper::post('employee/be/reimbursement'.$page, $post);
       $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_reimbursement'],date('Y-m-d H:i:s'));
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
        return view('employee::reimbursement.index', $data);
    }
    public function finance(Request $request){
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Reimbursement Pending',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-reimbursement',
                'child_active'   => 'employee-reimbursement-finance',
            ];
            $session = "filter-list-employee-reimbursement";
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
       $list = MyHelper::post('employee/be/reimbursement'.$page, $post);
       $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_reimbursement'],date('Y-m-d H:i:s'));
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
        return view('employee::reimbursement.index', $data);
    }
    public function setting(Request $request){
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Reimbursement Product Icount',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-reimbursement',
                'child_active'   => 'employee-reimbursement-product-icount',
            ];
            $session = "filter-list-employee-reimbursement";
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
       $list = MyHelper::post('employee/be/reimbursement/list_dropdown'.$page, $post);
       $data['product'] = MyHelper::post('employee/be/reimbursement/dropdown'.$page, $post)['result']??[];
       $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_reimbursement_product_icount'],date('Y-m-d H:i:s'));
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
        $data['textreplace']  = array(
                            array(
                                'keyword'=>'basic_salary',
                                'message'=>'Besaran gaji pokok yang diterima setiap bulan'
                            ), 
                            array(
                                'keyword'=>'*',
                                'message'=>'Multiplication'
                            ), 
                        );
        return view('employee::reimbursement.setting', $data);
    }
    public function setting_detail($id){
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Reimbursement Product Icount',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-reimbursement',
                'child_active'   => 'employee-reimbursement-product-icount',
            ];
       
        $id = MyHelper::explodeSlug($id)[0]??'';   
       $data['data'] = MyHelper::post('employee/be/reimbursement/dropdown/detail',['id_employee_reimbursement_product_icount'=>$id] )['result']??[];
       $data['product'] = MyHelper::post('employee/be/reimbursement/dropdown', [])['result']??[];
       $data['textreplace']  = array(
                            array(
                                'keyword'=>'basic_salary',
                                'message'=>'Besaran gaji pokok yang diterima setiap bulan.'
                            ), 
                            array(
                                'keyword'=>'*',
                                'message'=>'Multiplication'
                            ), 
                        );
        return view('employee::reimbursement.setting_detail', $data);
    }
    public function setting_update(Request $request){
        $post = $request->all();
        $post = MyHelper::post('employee/be/reimbursement/dropdown/update', $post);
        if(isset($post['status']) && $post['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success update data ']);
        }else{
            return redirect()->back()->withErrors($post['messages']??['Failed update data']);
        }
    }
    public function setting_create(Request $request){
        $post = $request->all();
        $post = MyHelper::post('employee/be/reimbursement/dropdown/create', $post);
        if(isset($post['status']) && $post['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success create data ']);
        }else{
            return redirect()->back()->withErrors($post['messages']??['Failed create data']);
        }
    }
    public function delete_create($id){
        $id = MyHelper::explodeSlug($id)[0]??'';
        $post = MyHelper::post('employee/be/reimbursement/dropdown/delete', ['id_employee_reimbursement_product_icount'=>$id]);
        if(isset($post['status']) && $post['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success delete data ']);
        }else{
            return redirect()->back()->withErrors($post['messages']??['Failed delete data']);
        }
    }
    public function global(Request $request)
    {
         $post = $request->except('_token');
         if($post){
             $post['value'] = str_replace(',','', $post['value']??0);
           $query = MyHelper::post('setting/balance-global-reimbursement-create',$post);
            if(isset($query['status']) && $query['status'] == 'success'){
                    return redirect('employee/reimbursement/setting/global')->withSuccess(['Global Balance Create Success']);
            } else{
                    return redirect('employee/reimbursement/setting/global')->withInput($request->input())->withErrors($query['messages']);
            }
        }
         $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Global Balance Reimbursement',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-reimbursement',
                'child_active'   => 'employee-reimbursement-global',
            ];
        $data['data'] = MyHelper::get('setting/balance-global-reimbursement');
        $data['textreplace']  = array(
                            array(
                                'keyword'=>'basic_salary',
                                'message'=>'Besaran gaji pokok yang diterima setiap bulan.'
                            ), 
                            array(
                                'keyword'=>'*',
                                'message'=>'Multiplication'
                            ), 
                        );
        return view('employee::reimbursement.balance',$data);
    }
}
