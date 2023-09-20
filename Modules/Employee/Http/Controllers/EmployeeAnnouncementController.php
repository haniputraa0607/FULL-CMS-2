<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeAnnouncementController extends Controller
{
    public function create(Request $request){
		$data = [
            'title'          	=> 'Employee',
            'sub_title'      	=> 'New Announcement',
            'menu_active'    	=> 'employee',
            'submenu_active' 	=> 'employee-announcement',
            'child_active' 		=> 'employee-announcement-create',
            'filter_title'   	=> 'Rules Condition Announcement',
            'hide_search_button'=> 1,
            'without_form'		=> 1
        ];

		$post = $request->except(['_token','files']);

		if(!empty($post)){
			$action = MyHelper::post('employee/announcement/create', $post);
			if($action['status'] == 'success'){
				$saveType = isset($post['id_employee_announcement']) ? 'updated' : 'created';
				return redirect('employee/announcement')->withSuccess(['Announcement has been ' . $saveType . '.']);
			} else{
				return redirect('employee/announcement')->withErrors($action['messages']);
			}

		}

		$data['provinces'] = array_map(function($item) {
            return [$item['id_province'], $item['province_name']];
        }, MyHelper::get('province/list')['result'] ?? []);
        	
        $data['cities'] = array_map(function($item) {
            return [$item['id_city'], $item['city_name']];
        }, MyHelper::get('city/list')['result'] ?? []);

        $data['outlets'] = array_map(function($item) {
            return [$item['id_outlet'], $item['outlet_code'].' - '.$item['outlet_name']];
        }, MyHelper::post('outlet/be/list', ['office_only' => true])['result'] ?? []);

        $data['roles'] = array_map(function($item) {
            return [$item['id_role'], $item['role_name']];
        }, MyHelper::get('employee/office-hours/assign')['result'] ?? []);

		return view('employee::announcement.create', $data);
	}

    public function list(Request $request){
        $post = $request->all();

        $data = [
            'title'          	=> 'Employee',
            'sub_title'      	=> 'Announcement List',
            'menu_active'    	=> 'employee',
            'submenu_active' 	=> 'employee-announcement',
            'child_active' 		=> 'employee-announcement-list'
        ];

        if(Session::has('filter-employee-announcement') && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('filter-employee-announcement');
            $post['page'] = $page;
        }else{
            Session::forget('filter-employee-announcement');
        }
        $getList = MyHelper::post('employee/announcement',$post);

        if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $getList['result']['data'];
            $data['dataTotal']     = $getList['result']['total'];
            $data['dataPerPage']   = $getList['result']['from'];
            $data['dataUpTo']      = $getList['result']['from'] + count($getList['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($getList['result']['data'], $getList['result']['total'], $getList['result']['per_page'], $getList['result']['current_page'], ['path' => url()->current()]);

	        $data['provinces'] = [];
	        $getProvinces = MyHelper::get('province/list')['result'] ?? [];
	        foreach ($getProvinces as $val) {
	        	$data['provinces'][$val['id_province']] = $val['province_name'];
	        }

	        $data['cities'] = [];
	        $getCities = MyHelper::get('city/list')['result'] ?? [];
	        foreach ($getCities as $val) {
	        	$data['cities'][$val['id_city']] = $val['city_name'];
	        }

            $data['outlets'] = [];
            $getOutlets = MyHelper::post('outlet/be/list', ['office_only' => true])['result'] ?? [];
            foreach ($getOutlets as $val) {
	        	$data['outlets'][$val['id_outlet']] = $val['outlet_code'].' - '.$val['outlet_name'];
	        }
    
            $data['roles'] = [];
            $getRoles = MyHelper::get('employee/office-hours/assign')['result'] ?? [];
            foreach ($getRoles as $val) {
	        	$data['roles'][$val['id_role']] = $val['role_name'];
	        }

	        $data['subjects'] = [
	        	'id_province' => 'Province',
	        	'id_city' => 'City',
	        	'id_outlet' => 'Outlet',
	        	'id_role' => 'Level',
	        	'all_data' => 'All Data',
	        ];

        }else{
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if($post){
            Session::put('filter-employee-announcement',$post);
        }

        return view('employee::announcement.list', $data);
    }

    public function edit(Request $request, $id_employee_announcement) {
		$data = [
            'title'          	=> 'Employee',
            'sub_title'      	=> 'Edit Announcement',
            'menu_active'    	=> 'employee',
            'submenu_active' 	=> 'employee-announcement',
            'child_active' 		=> 'employee-announcement-list',
            'filter_title'   	=> 'Rules Condition Announcement',
            'hide_search_button'=> 1,
            'without_form'		=> 1,
            'hide_record_total' => 1
        ];

		$post = $request->except(['_token','files']);

		$action = MyHelper::post('employee/announcement/detail', ['id_employee_announcement' => $id_employee_announcement]);

		$data['ann'] = $action['result'] ?? [];
		$data['provinces'] = array_map(function($item) {
            return [$item['id_province'], $item['province_name']];
        }, MyHelper::get('province/list')['result'] ?? []);
        	
        $data['cities'] = array_map(function($item) {
            return [$item['id_city'], $item['city_name']];
        }, MyHelper::get('city/list')['result'] ?? []);

        $data['outlets'] = array_map(function($item) {
            return [$item['id_outlet'], $item['outlet_code'].' - '.$item['outlet_name']];
        }, MyHelper::post('outlet/be/list', ['office_only' => true])['result'] ?? []);

        $data['roles'] = array_map(function($item) {
            return [$item['id_role'], $item['role_name']];
        }, MyHelper::get('employee/office-hours/assign')['result'] ?? []);

        $data['rule'] = [];
        foreach ($data['ann']['employee_announcement_rule_parents'][0]['rules'] ?? [] as $key => $val) {
        	if (in_array($val['subject'], ['id_province','id_city','id_outlet','id_role'])) {
        		$data['rule'][] = [$val['subject'], $val['parameter']];
        	}
        }
        $data['operator'] = $data['ann']['employee_announcement_rule_parents'][0]['rule'] ?? 'and';

		return view('employee::announcement.create', $data);
	}

    public function delete($id_employee_announcement){
		$delete = MyHelper::post('employee/announcement/delete', ['id_employee_announcement' => $id_employee_announcement]);
		if($delete['status'] == 'success'){
			return back()->withSuccess($delete['result']);
		} else{
			return back()->withErrors($delete['messages']);
		}
    }
}
