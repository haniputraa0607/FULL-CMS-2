<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeOutletAttendanceController extends Controller
{
    public function list(Request $request)
    {
        $data = [
            'title'          => 'Employee',
            'sub_title'      => 'Attendance Outlet',
            'menu_active'    => 'employee',
            'submenu_active' => 'employee-schedule',
            'child_active'   => 'employee-attendance-outlet',
            'filter_title'   => 'Filter Employee Outlet Attendance',
            'filter_date'    => true,
            'offices'        => MyHelper::post('outlet/be/list', ['office_only' => true])['result'] ?? [],
            'roles'          => MyHelper::get('employee/office-hours/assign')['result']??[],
        ];
        $post = $request->all();

        if(session('list_employee_outlet_attendance_filter')){
            $extra=session('list_employee_outlet_attendance_filter');
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

            $list = MyHelper::post('employee/attendance-outlet/list', $extra + $post);
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
        
        return view('employee::attendance.outlet_index', $data);
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
            session(['list_employee_outlet_attendance_filter'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['list_employee_outlet_attendance_filter'=>null]);
            return back();
        }

        return abort(404);
    }
}
