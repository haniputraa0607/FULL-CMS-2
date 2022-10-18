<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class EmployeePerubahanDataController extends Controller
{
    public function index(Request $request){
      
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Employee Perubahan Data Pending',
                'menu_active'    => 'employee',
                'submenu_active'   => 'employee-perubahan-data',
                'child_active'   => 'employee-perubahan-data-pending',
            ];
            $session = "filter-list-employee-perubahan-data";
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
      $list = MyHelper::post('employee/be/profile/perubahan-data'.$page, $post);
       $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_perubahan_data'],date('Y-m-d H:i:s'));
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
        return view('employee::perubahan-data.index', $data);
    }
    public function detail($id)
    {
        $id = MyHelper::explodeSlug($id)[0]??'';
         $data = [ 
                    'title'          => 'Employee',
                    'sub_title'      => 'Detail Employee Perubahan Data',
                    'menu_active'    => 'employee',
                    'submenu_active'   => 'employee-perubahan-data',
                    'child_active'   => 'employee-perubahan-data-pending',
                ];
       $data['data'] = MyHelper::post('employee/be/profile/perubahan-data/detail',['id_employee_perubahan_data'=>$id])['result']??[];
       if($data['data']){
        return view('employee::perubahan-data.detail',$data);
       }
       return redirect()->back()->withErrors(['Loan not found']);
    }
    public function create(Request $request)
    {
        $post = $request->except('_token');
        $post['date_action'] = date('Y-m-d H:i:s');
        $post['id_approved'] = session('id_user');
        $query = MyHelper::post('employee/be/profile/perubahan-data/update',$post);
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
                'sub_title'      => 'History Employee Perubahan Data',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-perubahan-data',
                'child_active'   => 'employee-perubahan-data-history',
            ];
            $session = "filter-list-employee-perubahan-data-history";
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
       $list = MyHelper::post('employee/be/profile/perubahan-data/list'.$page, $post);
       $vas = array();
       foreach ($list['result']['data']??[] as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_perubahan_data'],date('Y-m-d H:i:s'));
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
        return view('employee::perubahan-data.list', $data);
    }
}
