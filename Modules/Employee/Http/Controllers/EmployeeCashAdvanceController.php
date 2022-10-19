<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class EmployeeCashAdvanceController extends Controller
{
    public function index(Request $request){
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Cash Advance Pending',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-cash-advance',
                'child_active'   => 'employee-cash-advance-pending',
            ];
            $session = "filter-list-employee-cash-advance";
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
       $list = MyHelper::post('employee/be/cash-advance'.$page, $post);
       $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_cash_advance'],date('Y-m-d H:i:s'));
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
        return view('employee::cash_advance.index', $data);
    }
    public function detail($id)
    {
         $data = [ 
                    'title'          => 'Employee',
                    'sub_title'      => 'Detail Employee Cash Advance',
                    'menu_active'    => 'employee',
                    'submenu_active'   => 'employee-cash-advance',
                    'child_active'   => 'employee-cash-advance-pending',
                ];
         $id = MyHelper::explodeSlug($id)[0]??'';
      $data['data'] = MyHelper::post('employee/be/cash-advance/detail',['id_employee_cash_advance'=>$id])['result']??[];
      if(isset($data['data']['value_detail'])){
          $data['data']['value_detail'] = json_decode($data['data']['value_detail']??null);
      }
      if($data['data']){
        return view('employee::cash_advance.detail',$data);
       }
       return redirect()->back()->withErrors(['Cash Advance not found']);
    }
    public function create(Request $request)
    {
        $post = $request->except('_token');
        $query = MyHelper::post('employee/be/cash-advance/approved',$post);
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
                'sub_title'      => 'History Employee Cash Advance',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-cash-advance',
                'child_active'   => 'employee-cash-advance-history',
            ];
            $session = "filter-list-employee-cash-advance-history";
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
       $list = MyHelper::post('employee/be/cash-advance/list'.$page, $post);
       $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_cash_advance'],date('Y-m-d H:i:s'));
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
        return view('employee::cash_advance.list', $data);
    }
    public function manager(Request $request){
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Cash Advance Manager',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-cash-advance',
                'child_active'   => 'employee-cash-advance-manager',
            ];
            $session = "filter-list-employee-cash-advance-manager";
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
       $list = MyHelper::post('employee/be/cash-advance/manager'.$page, $post);
        $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_cash_advance'],date('Y-m-d H:i:s'));
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
        return view('employee::cash_advance.manager', $data);
    }
    public function manager_detail($id)
    {
         $data = [ 
                    'title'          => 'Employee',
                    'sub_title'      => 'Detail Employee Cash Advance',
                    'menu_active'    => 'employee',
                    'submenu_active'   => 'employee-cash-advance',
                    'child_active'   => 'employee-cash-advance-pending',
                ];
           $id = MyHelper::explodeSlug($id)[0]??'';
       $data['data'] = MyHelper::post('employee/be/cash-advance/detail',['id_employee_cash_advance'=>$id])['result']??[];
       if($data['data']){
        return view('employee::cash_advance.manager_detail',$data);
       }
       return redirect()->back()->withErrors(['Cash Advance not found']);
    }
    public function update(Request $request,$id) {
        $id = MyHelper::explodeSlug($id)[0]??'';
        $post = $request->except('_token');
        if(empty($post['action_type'])){
            return back()->withErrors(['Action type can not be empty']);
        }
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
        $post['id_employee_cash_advance'] = $id;
        $post['update_type'] = $post['action_type'];
        if(!empty($post['data_document'])){
            if(!empty($post['data_document']['attachment'])){
                $post['data_document']['ext'] = pathinfo($post['data_document']['attachment']->getClientOriginalName(), PATHINFO_EXTENSION);
                $post['data_document']['attachment'] = MyHelper::encodeImage($post['data_document']['attachment']);
            }
        }
     return $update = MyHelper::post('employee/be/cash-advance/update',$post);
       if(isset($update['status']) && $update['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success update data to '.$post['update_type']??""]);
        }else{
            return redirect()->back()->withErrors($update['messages']??['Failed update data to approved']);
        }
    }
    public function director_hrga(Request $request){
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Cash Advance Pending',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-cash-advance',
                'child_active'   => 'employee-cash-advance-director-hrga',
            ];
            $session = "filter-list-employee-cash-advance";
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
       $list = MyHelper::post('employee/be/cash_advance'.$page, $post);
         $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_cash_advance'],date('Y-m-d H:i:s'));
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
        return view('employee::cash_advance.index', $data);
    }
    public function finance(Request $request){
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Cash Advance Pending',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-cash-advance',
                'child_active'   => 'employee-cash-advance-finance',
            ];
            $session = "filter-list-employee-cash-advance";
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
       $list = MyHelper::post('employee/be/cash-advance'.$page, $post);
         $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_cash_advance'],date('Y-m-d H:i:s'));
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
        return view('employee::cash_advance.index', $data);
    }
     public function reject(Request $request, $id){
        $post = $request->except('_token');
        $id = MyHelper::explodeSlug($id)[0]??'';
        $post['id_employee_cash_advance'] = $id;
        $update = MyHelper::post('employee/be/cash-advance/reject',$post);
        if(isset($post['status']) && $post['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success reject cash advance']);
        }else{
            return redirect()->back()->withErrors($post['messages']??['Failed delete data']);
        }
    }
     public function icount(Request $request, $id){
         $id = MyHelper::explodeSlug($id)[0]??'';
        $post = $request->except('_token');
        $post['id_employee_cash_advance'] = $id;
        $post = MyHelper::post('employee/be/cash-advance/icount',$post);
        if(isset($post['status']) && $post['status'] == 'success'){
            return redirect('employee/cash-advance/detail/'.$id.'#approved')->withSuccess(['Success icount update']);
        }else{
            return redirect('employee/cash-advance/detail/'.$id.'#approved')->withErrors($post['messages']??['Failed request icount']);
        }
    }
    public function setting(Request $request){
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Cash Advance Product Icount',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-cash-advance',
                'child_active'   => 'employee-cash-advance-product-icount',
            ];
            $session = "filter-list-employee-cash-advance";
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
       $list = MyHelper::post('employee/be/cash-advance/list_dropdown'.$page, $post);
       $data['product'] = MyHelper::post('employee/be/cash-advance/dropdown'.$page, $post)['result']??[];
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
        return view('employee::cash_advance.setting', $data);
    }
    public function setting_create(Request $request){
        $post = $request->all();
        $post = MyHelper::post('employee/be/cash-advance/dropdown/create', $post);
        if(isset($post['status']) && $post['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success create data ']);
        }else{
            return redirect()->back()->withErrors($post['messages']??['Failed create data']);
        }
    }
    public function delete_create($id){
        $post = MyHelper::post('employee/be/cash-advance/dropdown/delete', ['id_employee_cash_advance_product_icount'=>$id]);
        if(isset($post['status']) && $post['status'] == 'success'){
            return redirect()->back()->withSuccess(['Success delete data ']);
        }else{
            return redirect()->back()->withErrors($post['messages']??['Failed delete data']);
        }
    }
}
