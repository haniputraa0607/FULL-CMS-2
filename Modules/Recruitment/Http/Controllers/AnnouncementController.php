<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class AnnouncementController extends Controller
{
	public function create(Request $request){
		$data = [
            'title'          	=> 'Recruitment',
            'sub_title'      	=> 'Announcement',
            'menu_active'    	=> 'hair-stylist',
            'submenu_active' 	=> 'hairstylist-announcement',
            'child_active' 		=> 'hairstylist-announcement-create',
            'filter_title'   	=> 'Filter Hairstylist',
            'hide_search_button'=> 1,
            'without_form'		=> 1
        ];

		$post = $request->except(['_token','files']);

		if(!empty($post)){
			$action = MyHelper::post('recruitment/hairstylist/be/announcement/create', $post);

			if($action['status'] == 'success'){
				$saveType = isset($post['id_hairstylist_announcement']) ? 'updated' : 'created';
				return redirect('recruitment/hair-stylist/announcement')->withSuccess(['Announcement has been ' . $saveType . '.']);
			} else{
				return redirect('recruitment/hair-stylist/announcement')->withErrors($action['messages']);
			}

		}

		$data['brands'] = array_map(function($item) {
            return [$item['id_brand'], $item['name_brand']];
        }, MyHelper::get('brand/be/list')['result'] ?? []);

		$data['provinces'] = array_map(function($item) {
            return [$item['id_province'], $item['province_name']];
        }, MyHelper::get('province/list')['result'] ?? []);
        	
        $data['cities'] = array_map(function($item) {
            return [$item['id_city'], $item['city_name']];
        }, MyHelper::get('city/list')['result'] ?? []);

        $data['outlets'] = array_map(function($item) {
            return [$item['id_outlet'], $item['outlet_code'].' - '.$item['outlet_name']];
        }, MyHelper::get('outlet/be/list')['result'] ?? []);

		return view('recruitment::hair_stylist.announcement.create', $data);
	}

	public function list(Request $request){
        $post = $request->all();

        $data = [
            'title'          	=> 'Recruitment',
            'sub_title'      	=> 'Announcement',
            'menu_active'    	=> 'hair-stylist',
            'submenu_active' 	=> 'hairstylist-announcement',
            'child_active' 		=> 'hairstylist-announcement-list'
        ];

        if(Session::has('filter-hs-announcement') && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('filter-hs-announcement');
            $post['page'] = $page;
        }else{
            Session::forget('filter-hs-announcement');
        }
        $getList = MyHelper::post('recruitment/hairstylist/be/announcement/list',$post);
        
        if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $getList['result']['data'];
            $data['dataTotal']     = $getList['result']['total'];
            $data['dataPerPage']   = $getList['result']['from'];
            $data['dataUpTo']      = $getList['result']['from'] + count($getList['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($getList['result']['data'], $getList['result']['total'], $getList['result']['per_page'], $getList['result']['current_page'], ['path' => url()->current()]);

	        $data['brands'] = [];
	        $getBrands = MyHelper::get('brand/be/list')['result'] ?? [];
	        foreach ($getBrands as $val) {
	        	$data['brands'][$val['id_brand']] = $val['name_brand'];
	        }

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
	        $getOutlets = MyHelper::get('outlet/be/list')['result'] ?? [];
	        foreach ($getOutlets as $val) {
	        	$data['outlets'][$val['id_outlet']] = $val['outlet_code'].' - '.$val['outlet_name'];
	        }

	        $data['subjects'] = [
	        	'id_brand' => 'Brand',
	        	'id_province' => 'Province',
	        	'id_city' => 'City',
	        	'id_outlet' => 'Outlet',
	        	'hairstylist_level' => 'Level',
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
            Session::put('filter-hs-announcement',$post);
        }

        return view('recruitment::hair_stylist.announcement.list', $data);
    }

    public function edit(Request $request, $id_hairstylist_announcement) {
		$data = [
            'title'          	=> 'Recruitment',
            'sub_title'      	=> 'Announcement',
            'menu_active'    	=> 'hair-stylist',
            'submenu_active' 	=> 'hairstylist-announcement',
            'child_active' 		=> 'hairstylist-announcement-list',
            'filter_title'   	=> 'Filter Hairstylist',
            'hide_search_button'=> 1,
            'without_form'		=> 1,
            'hide_record_total' => 1
        ];

		$post = $request->except(['_token','files']);

		$action = MyHelper::post('recruitment/hairstylist/be/announcement/detail', ['id_hairstylist_announcement' => $id_hairstylist_announcement]);

		$data['ann'] = $action['result'] ?? [];
		$data['brands'] = array_map(function($item) {
            return [$item['id_brand'], $item['name_brand']];
        }, MyHelper::get('brand/be/list')['result'] ?? []);

		$data['provinces'] = array_map(function($item) {
            return [$item['id_province'], $item['province_name']];
        }, MyHelper::get('province/list')['result'] ?? []);
        	
        $data['cities'] = array_map(function($item) {
            return [$item['id_city'], $item['city_name']];
        }, MyHelper::get('city/list')['result'] ?? []);

        $data['outlets'] = array_map(function($item) {
            return [$item['id_outlet'], $item['outlet_code'].' - '.$item['outlet_name']];
        }, MyHelper::get('outlet/be/list')['result'] ?? []);

        $data['rule'] = [];
        foreach ($data['ann']['hairstylist_announcement_rule_parents'][0]['rules'] ?? [] as $key => $val) {
        	if (in_array($val['subject'], ['id_brand','id_province','id_city','id_outlet','hairstylist_level'])) {
        		$data['rule'][] = [$val['subject'], $val['parameter']];
        	}
        }
        $data['operator'] = $data['ann']['hairstylist_announcement_rule_parents'][0]['rule'] ?? 'and';

		return view('recruitment::hair_stylist.announcement.create', $data);
	}

	public function delete($id_hairstylist_announcement){
		$delete = MyHelper::post('recruitment/hairstylist/be/announcement/delete', ['id_hairstylist_announcement' => $id_hairstylist_announcement]);
		if($delete['status'] == 'success'){
			return back()->withSuccess($delete['result']);
		} else{
			return back()->withErrors($delete['messages']);
		}
    }
}
