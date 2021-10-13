<?php

namespace Modules\Project\Http\Controllers;

use App\Exports\MultisheetExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Session;
use Excel;
use App\Imports\FirstSheetOnlyImport;
use Illuminate\Support\Facades\Hash;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request,$type = null)
    {
        $post = $request->all();
        $url = $request->url();
        if($type!='process'){
            $data = [
                'title'          => 'Project',
                'sub_title'      => 'List Project',
                'menu_active'    => 'project',
                'submenu_active' => 'list-project',
            ];
            $data['status'] = 'Active';
        } else {
            $data = [
                'title'          => 'Process Project',
                'sub_title'      => 'List Process Project',
                'menu_active'    => 'project',
                'submenu_active' => 'list-process-project',
            ];
            $data['status'] = 'Process';
        }
        
        $order = 'created_at';
        $orderType = 'desc';
        $sorting = 0;
        if(isset($post['sorting'])){
            $sorting = 1;
            $order = $post['order'];
            $orderType = $post['order_type'];
        }
        if(isset($post['reset']) && $post['reset'] == 1){
            Session::forget('filter-list-process');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-process') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-process');
            $post['page'] = $pageSession;
            if($sorting == 0 && !empty($post['order'])){
                $order = $post['order'];
                $orderType = $post['order_type'];
            }
        }
        $page = '?page=1';
        if(isset($post['page'])){
            $page = '?page='.$post['page'];
        }
        $data['order'] = $order;
        $data['order_type'] = $orderType;
        $post['order'] = $order;
        $post['order_type'] = $orderType;
        $post['status'] = $data['status'];
        
        $list = MyHelper::post('project/list'.$page, $post);
        if(($list['status']??'')=='success'){
            $data['data']          = $list['result']['data'];
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
            Session::put('filter-list-process',$post);
        }
        
        return view('project::project.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $post = $request->except('_token');
		if(isset($post) && !empty($post)){
                	$query = MyHelper::post('project/create', $post);
			if(isset($query['status']) && $query['status'] == 'success'){
				return back()->withSuccess(['Project Create Success']);
			} else{
				return back()->withErrors($query['messages']);
			}
			
		} else {
                        $data = [ 'title'             => 'New Project',
					  'menu_active'       => 'project',
					  'submenu_active'    => 'project-new'
					];
                        $getPartner = MyHelper::get('partner/select-list/partner');
			if($getPartner['status'] == 'success')
                            $data['partner'] = $getPartner['result'];
                        else $data['partner'] = null;
                        return view('project::project.create',$data);
			
		}
       
    }
    public function lokasi(Request $request)
    {
        $post['id_partner']=$request->id_partner;
        $getoutlet = MyHelper::post('partner/select-list/lokasi',$post);
        return $getoutlet;
			
    }
     public function detail($id)
    {
        
        $result = MyHelper::post('project/detail', ['id_project' => $id]);
//        return $result;
        if($result['result']['status']=='process'&&$result['status']=='success'){
            $data = [
                'title'          => 'Process Project',
                'sub_title'      => 'Detail Process Project',
                'menu_active'    => 'project',
                'submenu_active' => 'list-process-project',
            ];
        } else {
            $data = [
                'title'          => 'Project',
                'sub_title'      => 'Detail Project',
                'menu_active'    => 'project',
                'submenu_active' => 'list-project',
            ];
        }
        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result'];
            if($data['result']['project_survey']==null){
                $data['result']['project_survey']=array();
            }
            if($data['result']['project_desain']==null){
                $data['result']['project_desain']=array();
            }
            if($data['result']['project_contract']==null){
                $data['result']['project_contract']=array();
            }
            if($data['result']['project_fitout']==null){
                $data['result']['project_fitout']=array();
            }
//            return $data['result']['project_survey']['note'];
            // dd($data);
           
            return view('project::project.detail', $data);
        }else{
            return Redirect::back()->withErrors($result['messages'] ?? ['Failed get detail user mitra']);
        }
    }
}
