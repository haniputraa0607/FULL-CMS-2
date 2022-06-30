<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeRoleController extends Controller
{
  
   public function index(Request $request)
              {
                 $post = $request->all();
                 $url = $request->url();
                 $data = [ 'title'             => 'List Role',
                           'menu_active'       => 'Role',
                           'submenu_active'    => 'list-role'
                        ];
                   $session = 'list-hair-stylist-group';
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
               $list = MyHelper::post('employee/role'.$page, $post);
               if(($list['status']??'')=='success'){
                    $val = array();
                    foreach ($list['result']['data'] as $value){
                        $value['id_enkripsi'] = MyHelper::createSlug($value['id_role'],$value['created_at']);
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
                return view('employee::income.role.list',$data);
              }
            public function detail($id,Request $request)
              {
                $id_before = $id;
                $id = MyHelper::explodeSlug($id)[0]??'';
                $data = [ 
                                  'title'             => 'Role',
                                  'sub_title'         => 'Detail Role',
                                  'menu_active'       => 'Role',
                                  'submenu_active'    => 'list-role'
                                ];
                $query = MyHelper::post('employee/role/detail',['id_role'=>$id]);
                if(isset($query['status']) && $query['status'] == 'success'){
                        $data['id']  = $id;
                        $data['id_before']  = $id_before;
                        $data['result'] = $query['result'];
                        $post = $request->all();
                        
                      
                         $post3['id_role'] = $id;
                         $data['filter_insentif'] = $post3;
                         $data['list_default_insentif'] = MyHelper::post('employee/role/list-default-incentive',$post3);
                         $insentif = MyHelper::post('employee/role/incentive',$post3)['result']??[];
                         $val2 = array();
                                foreach ($insentif as $value){
                                    $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_role_default_incentive'],$id);
                                    array_push($val2,$value);
                                }  
                         $data['insentif'] = $val2;
                         $session4 = 'hair-stylist-group-filter-potongan';
                         $post4 = Session::get($session4);
                         $post4['id_role'] = $id;
                         $data['filter_potongan'] = $post4;
                         $data['list_default_potongan'] = MyHelper::post('employee/role/list-default-salary-cut',$post4);
                         $potongan = MyHelper::post('employee/role/salary-cut',$post4)['result']??[];
                         $val3 = array();
                                foreach ($potongan as $value){
                                    $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_role_default_salary_cut'],$id);
                                    array_push($val3,$value);
                                }  
                       $data['potongan'] = $val3;
                       $overtime = MyHelper::post('employee/role/overtime',$post4)['result']??[];
                         $val5 = array();
                        foreach ($overtime as $value){
                            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_role_default_overtime'],$id);
                            array_push($val5,$value);
                        }  
                        $data['overtime'] = $val5;
                        $fixed_incentive = MyHelper::post('employee/role/fixed-incentive',$post4)['result']??[];
                        $data['fixed_incentive'] = $fixed_incentive;
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
                        return view('employee::income.role.detail',$data);
                } else{
                        return back()->withErrors($query['messages']);
                }
              }
}
