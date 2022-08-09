<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeIncomeController extends Controller
{
    public function setting_delivery(Request $request){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Setting Delivery Income',
            'menu_active'    => 'setting-delivery-income',
            'submenu_active'    => 'setting-delivery-income',
        ];
        if($post){
            $post['value_text']=array(
                'start'=>$post['start'],
                'end'=>$post['end'],
            );
           $query = MyHelper::post('setting/setting-delivery-income-create', $post);
            if(($query['status']??'')=='success'){
                return back()->with('success',['Success update data']);
            }else{
                return back()->withErrors([$query['message']]);
            }
        }else{
            $query = MyHelper::get('setting/setting-delivery-income');
            $data['value'] = $query['value']??'';
            if(isset($query['value_text'])){
                
            $query['value_text'] = json_decode($query['value_text'],true)??[];
            }
            $data['start'] = $query['value_text']['start']??'';
            $data['end'] = $query['value_text']['end']??'';
            return view('employee::income.setting_delivery_income', $data);
        }
    }
    public function default_basic_salary(Request $request){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Default Basic Salary',
            'menu_active'    => 'default-basic-salary',
            'submenu_active'    => 'default-basic-salary',
        ];
        if($post){
            $post['value'] = str_replace(',','', $post['value']??0);
            $query = MyHelper::post('setting/setting-basic-salary-create', $post);
            if(($query['status']??'')=='success'){
                return back()->with('success',['Success update data']);
            }else{
                return back()->withErrors([$query['message']]);
            }
        }else{
            $query = MyHelper::get('setting/setting-basic-salary');
            $data['result'] = $query;
            return view('employee::income.setting_basic_salary', $data);
        }
    }
   
    public function index(Request $request){
      
         $post = $request->all();
        $url = $request->url();
       $data = [
            'title'          => 'Employee',
           'sub_title'      => 'Income Employee',
            'menu_active'    => 'employee',
            'submenu_active'    => 'income-employee',
        ];
            $session = "payslip-employee";
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
        $list = MyHelper::post('employee/be/income'.$page, $post);
        if(($list['status']??'')=='success'){
            $val = array();
            foreach ($list['result']['data'] as $value){
                $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_income'],date('Y-m-d H:i:s'));
                array_push($val,$value);
            }
            $data['data']          = $val;
            $data['data_total']     = $list['result']['total'];
            $data['data_per_page']   = $list['result']['from'];
            $data['data_up_to']      = $list['result']['from'] + count($list['result']['data'])-1;
            $data['data_paginator'] = new LengthAwarePaginator($val, $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
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
        $outlet= MyHelper::post('employee/be/income/outlet'.$page, $post)['result']??[];
        $data['outlet'] = [];
        foreach($outlet as $value){
            $data['outlet'][] = array(
                $value['id_outlet'],$value['outlet_name']
            );
        }
        return view('employee::income.payslip.index', $data);
    }
    public function detail($id){
      $id = MyHelper::explodeSlug($id)[0]??'';
         $data = [ 
                    'title'          => 'Employee',
                    'sub_title'      => 'Detail Employee',
                     'menu_active'    => 'employee',
                     'submenu_active'    => 'income-employee',
                ];
      $data['data'] = MyHelper::post('employee/be/income/detail',['id_employee_income'=>$id])['result']??[];
       if($data['data']){
        return view('employee::income.payslip.detail',$data);
       }
       return back('')->withErrors(['Data not found']);
    }
}
