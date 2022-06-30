<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
class EmployeeOvertimeController extends Controller
{
    public function create_overtime(Request $request)
    {
       $post = $request->except('_token');
       $post['value'] = str_replace(',','', $post['value']??0);
       $data = array();
       foreach (array_filter($post['id_employee_role_default_overtime_detail']) as $key => $value) {
           $b = array(
               'id_employee_role_default_overtime_detail' => $value,
               'id_role' => $post['id_role'][$key],
               'value' => $post['value'][$key],
           );
            $query = MyHelper::post('employee/role/overtime/create', $b);
              if(isset($query['status']) && $query['status'] != 'success'){
                      return redirect(url()->previous().'#overtime')->withErrors($query['messages']);
              }
       }
         return redirect(url()->previous().'#overtime')->withSuccess(['Employee Overtime Update Success']);
    }
    
    //default_overtime 
    public function default_index(Request $request)
                {
                       $post = $request->all();
                 $url = $request->url();
                 $data = [ 
                            'title'             => 'Default Overtime Employee',
                            'sub_title'         => 'Default Overtime Salary Employee',
                            'menu_active'       => 'employee',
                            'child_active'    => 'default-employee-overtime'
                        ];
                   $session = 'default-employee-overtime';
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
              
              $list = MyHelper::post('employee/role/overtime/default'.$page, $post)['result']??[];
               $val = array();
                foreach ($list as $value){
                    $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_role_default_overtime'],$value['created_at']);
                    array_push($val,$value);
                }
                 $data['data'] = $val;
                return view('employee::income.overtime.index',$data);
                  }
              public function default_create(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                
                 $query = MyHelper::post('employee/role/overtime/default/create', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Employee Incentive Create Success']);
                        } else{
                                return back()->withInput($request->input())->withErrors($query['messages']);
                        }
                   
              }
              public function default_delete($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('employee/role/overtime/default/delete', ['id_employee_role_default_overtime'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_update(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                $query = MyHelper::post('employee/role/overtime/default/update', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                            return back()->withSuccess(['Employee Incentive Update Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_detail($id)
            {
                 $id = MyHelper::explodeSlug($id)[0]??'';
                $query = MyHelper::post('employee/role/overtime/default/detail',['id_employee_role_default_overtime'=>$id]);
                    if(isset($query['status']) && $query['status'] == 'success'){
                        $data = [ 
                                  'title'             => 'Default Employee Overtime',
                                   'sub_title'         => 'Detail Default Employee Overtime',
                                   'menu_active'       => 'employee',
                                   'child_active'    => 'default-employee-overtime'
                               ];
                        $data['result']=$query['result'];
                       $data['detail'] = MyHelper::post('employee/role/overtime/default/detail/list',['id_employee_role_default_overtime'=>$id])['result']??[];
                        return view('employee::income.overtime.update',$data);
                    } else{
                        return back()->withErrors($query['messages']);
                    }
                   
              }
            
             public function delete_detail($id)
              {
                 $query = MyHelper::post('employee/role/overtime/default/detail/delete', ['id_employee_role_default_overtime_detail'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
}
