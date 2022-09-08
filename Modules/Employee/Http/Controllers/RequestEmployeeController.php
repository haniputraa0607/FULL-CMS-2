<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Session;

class RequestEmployeeController extends Controller
{
    public function createRequest(Request $request){
        $post = $request->except('_token');
        
        if(empty($post)){
            $data = [
                'title'          => 'Request Employee',
                'sub_title'      => 'New Request Employee',
                'menu_active'    => 'employee-recruitment',
                'submenu_active' => 'create-request-employee',
            ];  
            $data['office'] = MyHelper::post('outlet/be/list', ['office_only' => true])['result'] ?? [];
            $data['department'] = MyHelper::post('users/department/list-department', [])['result'] ?? [];
            return view('employee::request.new', $data);
        }else{
            $result = MyHelper::post('employee/request/create', $post);
            if(isset($result['status']) && $result['status'] == 'success'){
                return redirect('employee/request/detail/'.$result['result']['id_request_employee'])->withSuccess(['Success create a new request employee']);
            }else{
                return redirect('employee/request/detail/'.$result['result']['id_request_employee'])->withErrors($result['messages'] ?? ['Failed create a new request employee']);
            }
        }
    }

    public function detailRequest(Request $request, $id){
        $post = $request->except('_token');

        if(empty($post)){
            $result = MyHelper::post('employee/request/detail', ['id_request_employee' => $id]);
            $data = [
                'title'          => 'Request Employee',
                'sub_title'      => 'Detail Request Employee',
                'menu_active'    => 'employee-recruitment',
                'submenu_active' => 'list-request-employee',
            ]; 
            $list_employee = MyHelper::post('employee/request/list-employee', ['id_outlet' => $result['result']['request_employee']['id_outlet'], 'id_department' => $result['result']['request_employee']['id_department']])??[];
            if(isset($result['status']) && $result['status'] == 'success'){
                $data['result'] = $result['result']['request_employee'];
                $data['result']['url_applicant'] = url('user/detail').'/'.$data['result']['applicant_request']['phone'];
                $data['employees'] = $list_employee;
                return view('employee::request.detail', $data);
            }else{
                return redirect('recruitment/request')->withErrors($result['messages'] ?? ['Failed get detail request hair stylist']);
            }
        }else{
            $request->validate([
                "outlate_name" => "required",
                "number_of_request" => "required",
            ]);
            $old_req = MyHelper::post('employee/request/detail', ['id_request_employee' => $id]);
            $old_req = $old_req['result']['request_employee'];
            if(isset($post['status']) && $post['status']=='on'){
                $request->validate([
                    "notes" => "required",
                ]);
                $post['notes'] = $request['notes'];
                $post['status'] = 'Approved';
                if(isset($post['id_employee'])){
                    $count = count($post['id_employee']);
                    if($count==$post['number_of_request']){
                        $post['status'] = 'Done Approved';
                    }else{
                        $post['status'] = 'Approved';
                    }
                }
                $post['id_employee'] = [
                    "id_employee" => $request['id_employee'],
                ];
                $post['id_employee'] = json_encode($post['id_employee']);
            }elseif(isset($post['status'])){
                if (isset($post['notes'])) {
                    $post['notes'] = $post['notes'];
                }else{
                    $post['notes'] = null;
                }
                if (isset($post['id_employee'])) {
                    $post['id_employee'] = [
                        "id_employee" => $post['id_employee'],
                    ];
                    $post['id_employee'] = json_encode($post['id_employee']);
                }else{
                    $post['id_employee'] = null;
                }
            }else{
                $post['notes'] = null;
                if($old_req['status']=='Approved'){
                    $post['status'] = 'Request';
                }else{
                    $post['status'] = $old_req['status'];
                }
                $post['id_employee'] = null;
            }
            $post['id_request_employee'] = $id;   
            $result = MyHelper::post('employee/request/update', $post);
            if(isset($result['status']) && $result['status'] == 'success'){
                return redirect('employee/request/detail/'.$id)->withSuccess(['Success update request employee']);
            }else{
                return redirect('employee/request/detail/'.$id)->withErrors($result['messages'] ?? ['Failed update request employee']);
            }
        }
    }

    public function destroy($id)
    {
        $result = MyHelper::post("employee/request/delete", ['id_request_employee' => $id]);
        return $result;
    }

    public function rejectRequest($id)
    {
        $reject_reqeust = [
            "id_request_employee" => $id,
            "status" => 'Rejected'
        ];
        $rejected = MyHelper::post('employee/request/update', $reject_reqeust);
        return $rejected;
    }
}
