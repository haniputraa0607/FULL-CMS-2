<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeIncentiveController extends Controller
{
  
    public function create_incentive(Request $request)
              {
               $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $data = array();
                 foreach (array_filter($post['id_employee_role_default_incentive']) as $key => $value) {
                     $b = array(
                         'id_employee_role_default_incentive' => $value,
                         'id_role' => $post['id_role'][$key],
                         'value' => $post['value'][$key],
                         'formula' => $post['formula'][$key],
                         'code' =>$post['code'][$key]
                     );
                     $query = MyHelper::post('employee/role/incentive/create', $b);
                        if(isset($query['status']) && $query['status'] != 'success'){
                                return redirect(url()->previous().'#insentif')->withErrors($query['messages']);
                        }
                 }
                   return redirect(url()->previous().'#insentif')->withSuccess(['Hair Stylist Group Incentive Update Success']);
              }
     //default insentif
            public function default_index_insentif(Request $request)
                {
                       $post = $request->all();
                 $url = $request->url();
                 $data = [ 
                            'title'             => 'Default Income Employee',
                            'sub_title'         => 'Default Incentive Salary Employee',
                            'menu_active'       => 'default-employee',
                            'child_active'    => 'default-employee-incentive'
                        ];
                   $session = 'default-employee-incentive';
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
              
               $list = MyHelper::post('employee/role/incentive/default'.$page, $post);
               if(($list['status']??'')=='success'){
                    $val = array();
                    foreach ($list['result']['data'] as $value){
                        $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_role_default_incentive'],$value['created_at']);
                        array_push($val,$value);
                    }
                   $data['data'] = $val;
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
               $textreplace = array(
                            array(
                                'keyword'=>'value',
                                'message'=>'Value'
                            ), 
                            array(
                                'keyword'=>'total_attend',
                                'message'=>'Total of attendance at work'
                            ), 
                            array(
                                'keyword'=>'total_late',
                                'message'=>'Total of late at work'
                            ), 
                            array(
                                'keyword'=>'total_absen',
                                'message'=>'Total of unpaid leave at work'
                            ), 
                            array(
                                'keyword'=>'+',
                                'message'=>'Added'
                            ), 
                            array(
                                'keyword'=>'-',
                                'message'=>'Subtraction'
                            ), 
                            array(
                                'keyword'=>'*',
                                'message'=>'Multiplication'
                            ), 
                            array(
                                'keyword'=>'/',
                                'message'=>'Distribution'
                            ), 
                        );
               $data['textreplace'] = $textreplace;
                return view('employee::income.incentive.index',$data);
                  }
              public function default_create_insentif(Request $request)
              {
                $post = $request->except('_token');
                $post['value'] = str_replace(',','', $post['value']??0);
                $query = MyHelper::post('employee/role/incentive/default/create', $post);
                    if(isset($query['status']) && $query['status'] == 'success'){
                            return back()->withSuccess(['Employee Incentive Create Success']);
                    } else{
                            return back()->withInput($request->input())->withErrors($query['messages']);
                    }
              }
              public function default_delete_insentif($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('employee/role/incentive/default/delete', ['id_employee_role_default_incentive'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_update_insentif(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('employee/role/incentive/default/update', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                            return back()->withSuccess(['Employee Incentive Update Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_detail_insentif($id)
            {
                 $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('employee/role/incentive/default/detail',['id_employee_role_default_incentive'=>$id]);
                    if(isset($query['status']) && $query['status'] == 'success'){
                        $data = [ 
                                  'title'             => 'Default Employee Incentive',
                                   'sub_title'         => 'Detail Default Employee Incentive',
                                   'menu_active'       => 'default-employee',
                                   'child_active'    => 'default-employee-incentive'
                               ];
                        $data['result']=$query['result'];
                        $textreplace = array(
                            array(
                                'keyword'=>'value',
                                'message'=>'Value'
                            ), 
                            array(
                                'keyword'=>'total_attend',
                                'message'=>'Total of attendance at work'
                            ), 
                            array(
                                'keyword'=>'total_late',
                                'message'=>'Total of late at work'
                            ), 
                            array(
                                'keyword'=>'total_absen',
                                'message'=>'Total of unpaid leave at work'
                            ), 
                            array(
                                'keyword'=>'+',
                                'message'=>'Added'
                            ), 
                            array(
                                'keyword'=>'-',
                                'message'=>'Subtraction'
                            ), 
                            array(
                                'keyword'=>'*',
                                'message'=>'Multiplication'
                            ), 
                            array(
                                'keyword'=>'/',
                                'message'=>'Distribution'
                            ), 
                        );
                        $data['textreplace'] = $textreplace;
                            return view('employee::income.incentive.update',$data);
                    } else{
                            return back()->withErrors($query['messages']);
                    }
                   
              }
}
