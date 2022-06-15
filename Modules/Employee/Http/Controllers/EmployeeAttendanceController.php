<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeAttendanceController extends Controller
{

    public function list(Request $request)
    {
        $data = [
            'title'          => 'Employee',
            'sub_title'      => 'Attendance',
            'menu_active'    => 'employee',
            'submenu_active' => 'employee-schedule',
            'child_active'   => 'employee-attendance',
            'filter_title'   => 'Filter Employee Attendance',
            'filter_date'    => true,
            'outlets'        => MyHelper::post('outlet/be/list', ['office_only' => true])['result'] ?? [],
            'roles'          => MyHelper::get('employee/office-hours/assign')['result']??[],
        ];
        $post = $request->all();

        if(session('list_employee_attendance_filter')){
            $extra=session('list_employee_attendance_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    9998 => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1',
                    ],
                    9999 => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1',
                    ],
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }
        
        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('employee/attendance/list', $extra + $post);
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            return response()->json($arr_result);
        }
        
        return view('employee::attendance.index', $data);
    }

    public function filter(Request $request)
    {
        $post = $request->all();

        if(($post['rule']??false) && !isset($post['draw'])){
            if (($post['filter_type'] ?? false) == 'today') {
                $post['rule'][9998] = [
                    'subject' => 'transaction_date',
                    'operator' => '>=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
                $post['rule'][9999] = [
                    'subject' => 'transaction_date',
                    'operator' => '<=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
            }
            session(['list_employee_attendance_filter'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['list_employee_attendance_filter'=>null]);
            return back();
        }

        return abort(404);
    }

    public function detail(Request $request, $id)
    {
        $data = [
            'title'          => 'Employee',
            'sub_title'      => 'Detail Attendance',
            'menu_active'    => 'employee',
            'submenu_active' => 'employee-schedule',
            'child_active'   => 'employee-attendance',
            'filter_title'   => 'Filter Detail Employee Attendance',
            'filter_date'    => true,
            'shift'          => MyHelper::post('employee/shift', ['id' => $id])['result']??[],
        ];
        $post = $request->all();

        if(session('list_employee_attendance_filter')){
            $extra=session('list_employee_attendance_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    9998 => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1',
                    ],
                    9999 => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1',
                    ],
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }
        
        $extra['rule'][] = [
            'subject' => 'id',
            'operator' => '=',
            'parameter' => $id,
            'hide' => '1',
        ];

        if ($request->wantsJson()) {
            $draw = $request->draw;
            
            $list = MyHelper::post('employee/attendance/detail', $extra + $post);
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            foreach($arr_result['data'] ?? [] as $key => $change_shift){
                if($change_shift['shift'] == null){
                    $arr_result['data'][$key]['shift'] = '-';
                }
            }
            return response()->json($arr_result);
        }

        return view('employee::attendance.detail', $data);
    }

    public function setting(Request $request){
        if (empty($request->all())) {
            $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Attendance Setting',
                'menu_active'    => 'employee',
                'submenu_active' => 'employee-schedule',
                'child_active'   => 'employee-attendance-setting',
            ];

            $data['result'] = MyHelper::get('employee/attendance-setting')['result']??[];
            return view('employee::attendance.setting', $data);

        } else {

            $update = MyHelper::post('employee/attendance-setting', $request->all());

            if (($update['status'] ?? false) == 'success'){
                return back()->with('success', ['Attendance setting has been updated']);
            }else{
                return back()->withErrors($update['messages'] ?? ['Update failed']);
            }
        }
    }

    public function listPending(Request $request)
    {
        $data = [
            'title'          => 'Employee',
            'sub_title'      => 'Attendance Pending',
            'menu_active'    => 'employee',
            'submenu_active' => 'employee-schedule',
            'child_active'   => 'employee-attendance-pending',
            'filter_title'   => 'Filter Employee Pending Attendance',
            'filter_date'    => true,
            'outlets'        => MyHelper::post('outlet/be/list', ['office_only' => true])['result'] ?? [],
            'roles'          => MyHelper::get('employee/office-hours/assign')['result']??[],
        ];
        $post = $request->all();

        if(session('list_employee_attendance_pending_filter')){
            $extra=session('list_employee_attendance_pending_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    9998 => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1',
                    ],
                    9999 => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1',
                    ],
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }
        
        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('employee/attendance-pending/list', $extra + $post);
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            return response()->json($arr_result);
        }

        return view('employee::attendance.list_pending', $data);
    }

    /**
     * apply filter.
     * @return Response
     */
    public function filterPending(Request $request)
    {
        $post = $request->all();

        if(($post['rule']??false) && !isset($post['draw'])){
            if (($post['filter_type'] ?? false) == 'today') {
                $post['rule'][9998] = [
                    'subject' => 'transaction_date',
                    'operator' => '>=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
                $post['rule'][9999] = [
                    'subject' => 'transaction_date',
                    'operator' => '<=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
            }
            session(['list_employee_attendance_pending_filter'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['list_employee_attendance_pending_filter'=>null]);
            return back();
        }

        return abort(404);
    }

    public function detailPending(Request $request, $id)
    {
        $data = [
            'title'          => 'Employee',
            'sub_title'      => 'Attendance Pending',
            'menu_active'    => 'employee',
            'submenu_active' => 'employee-schedule',
            'child_active'   => 'employee-attendance-pending',
            'filter_title'   => 'Filter Detail Employee Pending Attendance',
            'filter_date'    => true,
            'shift'          => MyHelper::post('employee/shift', ['id' => $id])['result']??[],
        ];
        $post = $request->all();

        if(session('list_employee_attendance_pending_filter')){
            $extra=session('list_employee_attendance_pending_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    9998 => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1',
                    ],
                    9999 => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1',
                    ],
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }
        
        $extra['rule'][] = [
            'subject' => 'id',
            'operator' => '=',
            'parameter' => $id,
            'hide' => '1',
        ];

        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('employee/attendance-pending/detail', $extra + $post);
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            foreach($arr_result['data'] ?? [] as $key => $change_shift){
                if($change_shift['shift'] == null){
                    $arr_result['data'][$key]['shift'] = '-';
                }
            }

            return response()->json($arr_result);
        }

        return view('employee::attendance.detail_pending', $data);
    }

    public function updatePending(Request $request)
    {
        $update = MyHelper::post('employee/attendance-pending/update', $request->all());
        if (($update['status'] ?? false) == 'success') {
            return back()->withSuccess([$update['result']['message'] ?? 'Success update pending attendance']);
        }
        return back()->withErrors($update['messages'] ?? ['Something went wrong']);
    }

    public function listRequest(Request $request){
        $data = [
            'title'          => 'Employee',
            'sub_title'      => 'Attendance Request',
            'menu_active'    => 'employee',
            'submenu_active' => 'employee-schedule',
            'child_active'   => 'employee-attendance-request',
            'filter_title'   => 'Filter Employee Attendance Request',
            'filter_date'    => true,
            'outlets'        => MyHelper::post('outlet/be/list', ['office_only' => true])['result'] ?? [],
            'roles'          => MyHelper::get('employee/office-hours/assign')['result']??[],
        ];
        $post = $request->all();

        if(session('list_employee_attendance_request_filter')){
            $extra=session('list_employee_attendance_request_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    9998 => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1',
                    ],
                    9999 => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1',
                    ],
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }
        
        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('employee/attendance-request/list', $extra + $post);
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            return response()->json($arr_result);
        }
        
        return view('employee::attendance.request_index', $data);
    }

    public function filterRequest(Request $request){
        $post = $request->all();

        if(($post['rule']??false) && !isset($post['draw'])){
            if (($post['filter_type'] ?? false) == 'today') {
                $post['rule'][9998] = [
                    'subject' => 'transaction_date',
                    'operator' => '>=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
                $post['rule'][9999] = [
                    'subject' => 'transaction_date',
                    'operator' => '<=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
            }
            session(['list_employee_attendance_request_filter'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['list_employee_attendance_request_filter'=>null]);
            return back();
        }

        return abort(404);
    }

    public function detailRequest(Request $request, $id){
        $data = [
            'title'          => 'Employee',
            'sub_title'      => 'Attendance Request',
            'menu_active'    => 'employee',
            'submenu_active' => 'employee-schedule',
            'child_active'   => 'employee-attendance-request',
            'filter_title'   => 'Filter Detail Employee Attendance Request',
            'filter_date'    => true,
            'shift'          => MyHelper::post('employee/shift', ['id' => $id])['result']??[],
        ];
        $post = $request->all();

        if(session('list_employee_attendance_request_filter')){
            $extra=session('list_employee_attendance_request_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    9998 => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1',
                    ],
                    9999 => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1',
                    ],
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }
        
        $extra['rule'][] = [
            'subject' => 'id',
            'operator' => '=',
            'parameter' => $id,
            'hide' => '1',
        ];

        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('employee/attendance-request/detail', $extra + $post);
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            foreach($arr_result['data'] ?? [] as $key => $change_shift){
                if($change_shift['shift'] == null){
                    $arr_result['data'][$key]['shift'] = '-';
                }
            }

            return response()->json($arr_result);
        }

        return view('employee::attendance.request_detail', $data);
    }

    public function updateRequest(Request $request){
        $update = MyHelper::post('employee/attendance-request/update', $request->all());
        if (($update['status'] ?? false) == 'success') {
            return back()->withSuccess([$update['result']['message'] ?? 'Success update request attendance']);
        }
        return back()->withErrors($update['messages'] ?? ['Something went wrong']);
    }

    public function deleteDetail(Request $request){
        $post = $request->except('_token');
        $delete = MyHelper::post('employee/attendance/delete', $post);
        if (($delete['status'] ?? false) == 'success') {
            return back()->withSuccess([$delete['result']['message'] ?? 'Success delete attendance']);
        }
        return back()->withErrors($delete['messages'] ?? ['Something went wrong']);
    }
}
