<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class HairStylistTimeOffOvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function listTimeOff(Request $request)
    {
        $rule = false;
        $post = $request->all();
        $data = [
            'title'          	=> 'Recruitment',
            'sub_title'      	=> 'List Request Hair Stylist Time Off',
            'menu_active'    	=> 'hairstylist-schedule',
            'submenu_active' 	=> 'hairstylist-schedule',
            'child_active' 		=> 'hairstylist-timeoff-list',
        ];
        
        $order = 'created_at';
        $orderType = 'desc';
        $sorting = 0;
        if(isset($post['sorting'])){
            $sorting = 1;
            $order = $post['order'];
            $orderType = $post['order_type'];
        }
        if(isset($post['reset']) && $post['reset'] == 1){
            Session::forget('filter-list-time-off');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-time-off') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-time-off');
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

        $list = MyHelper::post('recruitment/hairstylist/be/timeoff/list'.$page, $post);

        if(($list['status']??'')=='success'){
            $data['data']          = $list['result']['data'];
            $data['data_total']     = $list['result']['total'];
            $data['data_per_page']   = $list['result']['from'];
            $data['data_up_to']      = $list['result']['from'] + count($list['result']['data'])-1;
            $data['data_paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
            $data['rule'] = $rule;
        }else{
            $data['data']          = [];
            $data['data_total']     = 0;
            $data['data_per_page']   = 0;
            $data['data_up_to']      = 0;
            $data['data_paginator'] = false;
            $data['rule'] = false;
        }

        if($post){
            Session::put('filter-list-time-off',$post);
        }
        
        return view('recruitment::hair_stylist.timeoff.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function createTimeOff(Request $request)
    {
        $post = $request->except('_token');
        if(empty($post)){
            $data = [
                'title'          	=> 'Recruitment',
                'sub_title'      	=> 'Create Request Hair Stylist Time Off',
                'menu_active'    	=> 'hairstylist-schedule',
                'submenu_active' 	=> 'hairstylist-schedule',
                'child_active' 		=> 'hairstylist-timeoff-create',
            ];
            
            $data['hair_stylists'] = MyHelper::post('recruitment/hairstylist/be/list', [])['result']['data'];
            $data['outlets'] = MyHelper::get('mitra/request/outlet')['result'] ?? [];
            return view('recruitment::hair_stylist.timeoff.create', $data);
        }else{
            $store = MyHelper::post('recruitment/hairstylist/be/timeoff/create', $post);
            if(isset($store['status']) && $store['status'] == 'success'){
                return $store;
            }else{
                return $store;
            }
        }
    }

    public function listHS(Request $request)
    {
        $post = $request->except('_token');
        $list_hs = MyHelper::post('recruitment/hairstylist/be/timeoff/list-hs', $post);
        return $list_hs;
    }

    public function listDate(Request $request)
    {
        $post = $request->except('_token');
        $list_date = MyHelper::post('recruitment/hairstylist/be/timeoff/list-date', $post);
        return $list_date;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function detailTimeOff($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('recruitment::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateTimeOff(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function listOvertime()
    {

    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function createOvertime()
    {

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function detailOvertime($id)
    {

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateOvertime(Request $request, $id)
    {
        //
    }

}
