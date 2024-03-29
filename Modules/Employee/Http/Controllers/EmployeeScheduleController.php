<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;



class EmployeeScheduleController extends Controller
{
    public function create(Request $request){
        $data = [
            'title'          	=> 'Employee',
            'sub_title'      	=> 'Schedule',
            'menu_active'    	=> 'employee',
            'submenu_active' 	=> 'employee-schedule',
            'child_active' 		=> 'employee-schedule-create',
        ];

        $data['employees'] = MyHelper::post('employee/list', [])['result']['data'] ?? [];
        return view('employee::schedule.create', $data);
    }

    public function check(Request $request){
        $post = $request->except('_token');
        $data =  MyHelper::post('employee/schedule/create',$post);

        if(isset($data['status']) && $data['status'] == 'success'){
            return $data;
        }else{
            return [
                'status' => $data['status'],
                'messages' => $data['messages'] ?? 'Something went wrong. Failed to create the schedule.'
            ];
        }
    }

    public function list(Request $request){
        $post = $request->all();

        $data = [
            'title'          	=> 'Employee',
            'sub_title'      	=> 'Schedule',
            'menu_active'    	=> 'employee-schedule',
            'submenu_active' 	=> 'employee-schedule',
            'child_active' 		=> 'employee-schedule-list',
            'title_date_start' 	=> 'Request Start',
            'title_date_end' 	=> 'Request End'
        ];

        if(Session::has('filter-employee-schedule') && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('filter-employee-schedule');
            $post['page'] = $page;
        }else{
            Session::forget('filter-employee-schedule');
        }
        $getList = MyHelper::post('employee/schedule/list',$post);
        // return $getList;

        if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $getList['result']['data'];
            $data['dataTotal']     = $getList['result']['total'];
            $data['dataPerPage']   = $getList['result']['from'];
            $data['dataUpTo']      = $getList['result']['from'] + count($getList['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($getList['result']['data'], $getList['result']['total'], $getList['result']['per_page'], $getList['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if($post){
            Session::put('filter-employee-schedule',$post);
        }

        $month = [];
        for ($m=1; $m<=12; $m++) {
        	$month[] = [
        		'index' => $m,
        		'name' => date('F', mktime(0,0,0,$m, 1, date('Y')))
        	];
        }

        $data['months'] = $month;

        $data['years'] = MyHelper::get('employee/schedule/year-list')['result'] ?? [];
        $data['outlets'] = MyHelper::post('outlet/be/list', ['office_only' => true])['result'] ?? [];
        $data['roles'] = MyHelper::get('employee/office-hours/assign')['result']??[];

        return view('employee::schedule.list', $data);
    }

    public function detail(Request $request, $shift, $id){
        if($shift == 'use-shift'){
            $detail = MyHelper::post('employee/schedule/detail/use-shift',['id_employee_schedule' => $id]);
        }else{
            $detail = MyHelper::post('employee/schedule/detail/without-shift',['id_employee_schedule' => $id]);
        }

        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data = [
                'title'          => 'Employee',
                'sub_title'      => 'Schedule',
                'menu_active'    => 'employee-schedule',
                'submenu_active' => 'employee-schedule',
                'child_active' 	 => 'employee-schedule-list',
                'url_back'       => 'employee/schedule',
                'shift'          => $shift
            ];

            $data['data'] = $detail['result'];
            if($shift == 'use-shift'){
                return view('employee::schedule.detail_shift', $data);
            }else{
                return view('employee::schedule.detail_nonshift', $data);
            }
        }else{
            return redirect('employee/schedule')->withErrors($store['messages']??['Failed get detail schedule']);
        }
    }

    public function update(Request $request, $id){
        $post = $request->except('_token');
        $post['id_employee_schedule'] = $id;
        $shift = $post['shift'];
        unset($post['shift']);

        $update = MyHelper::post('employee/schedule/update',$post);
        
        if(isset($update['status']) && $update['status'] == 'success'){
            if(isset($post['update_type']) && $post['update_type'] == 'approve'){
                return redirect('employee/schedule/detail/'.$shift.'/'.$id)->withSuccess(['Success approve data schedule']);
            }
            return redirect('employee/schedule/detail/'.$shift.'/'.$id)->withSuccess(['Success update data schedule']);
        }else{
            return redirect('employee/schedule/detail/'.$shift.'/'.$id)->withErrors($update['messages']??['Failed update data to approved']);
        }
    }
}
