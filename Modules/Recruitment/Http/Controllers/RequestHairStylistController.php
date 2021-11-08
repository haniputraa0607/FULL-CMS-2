<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Session;

class RequestHairStylistController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Request Hair Stylist',
            'sub_title'      => 'List Request Hair Stylist',
            'menu_active'    => 'req-hair-stylist',
            'submenu_active' => 'list-req-hair-stylist',
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
            Session::forget('filter-list-req-hair-stylist');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-req-hair-stylist') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-req-hair-stylist');
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
        
        $list = MyHelper::post('mitra/request'.$page, $post);
        foreach($list['result']['data'] as $i => $req){
            if($req['id_hs']==null){
                $list['result']['data'][$i]['count'] = 0;
            }else{
                $json = json_decode($req['id_hs']??'' , true);
                if(is_array($json)){
                    $list['result']['data'][$i]['count'] = count((is_countable($json['id_hair_stylist'])?$json['id_hair_stylist']:[]));
                }
            }
        }
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
            Session::put('filter-list-req-hair-stylist',$post);
        }
        return view('recruitment::request.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $data = [
            'title'          => 'Request Hair Stylist',
            'sub_title'      => 'New Request Hair Stylist',
            'menu_active'    => 'req-hair-stylist',
            'submenu_active' => 'new-req-hair-stylist',
        ];  
        $listOutlet = MyHelper::get('mitra/request/outlet');
        $data['outlet'] = $listOutlet['result'];
        return view('recruitment::request.new', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        $post['applicant'] = session('name');
        $result = MyHelper::post('mitra/request/create', $post);
        if(isset($result['status']) && $result['status'] == 'success'){
            return redirect('recruitment/hair-stylist/request/detail/'.$result['result']['id_request_hair_stylist'])->withSuccess(['Success create a new request hair stylist']);
        }else{
            return redirect('recruitment/hair-stylist/request/detail/'.$result['result']['id_request_hair_stylist'])->withErrors($result['messages'] ?? ['Failed create a new request hair stylist']);
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $result = MyHelper::post('mitra/request/detail', ['id_request_hair_stylist' => $id]);
        $data = [
            'title'          => 'Request Hair Stylist',
            'sub_title'      => 'Detail Request Hair Stylist',
            'menu_active'    => 'req-hair-stylist',
            'submenu_active' => 'list-req-hair-stylist',
        ]; 
        $list_hs = MyHelper::post('mitra/request/list-hs', ['id_outlet' => $result['result']['request_hair_stylist']['id_outlet']])??[];
        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result']['request_hair_stylist'];
            $data['hairstylist'] = $list_hs;
            // dd($data);
            return view('recruitment::request.detail', $data);
        }else{
            return redirect('recruitment/request')->withErrors($result['messages'] ?? ['Failed get detail request hair stylist']);
        }
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
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            "outlate_name" => "required",
            "applicant" => "required",
            "number_of_request" => "required",
        ]);
        $old_req = MyHelper::post('mitra/request/detail', ['id_request_hair_stylist' => $id]);
        $old_req = $old_req['result']['request_hair_stylist'];
        $post = $request->except('_token','notes');
        if(isset($request['status']) && $request['status']=='on'){
            $request->validate([
                "notes" => "required",
            ]);
            $post['notes'] = $request['notes'];
            $post['status'] = 'Approve';
            if(isset($post['id_hs'])){
                $count = count($post['id_hs']);
                if($count==$post['number_of_request']){
                    $post['status'] = 'Done Approved';
                }else{
                    $post['status'] = 'Approve';
                }
            }
            $post['id_hs'] = [
                "id_hair_stylist" => $request['id_hs'],
            ];
            $post['id_hs'] = json_encode($post['id_hs']);
        }elseif(isset($request['status'])){
            if (isset($request['notes'])) {
                $post['notes'] = $request['notes'];
            }else{
                $post['notes'] = null;
            }
            if (isset($request['id_hs'])) {
                $post['id_hs'] = [
                    "id_hair_stylist" => $request['id_hs'],
                ];
                $post['id_hs'] = json_encode($post['id_hs']);
            }else{
                $post['id_hs'] = null;
            }
        }else{
            $post['notes'] = null;
            if($old_req['status']=='Approve'){
                $post['status'] = 'Request';
            }else{
                $post['status'] = $old_req['status'];
            }
            $post['id_hs'] = null;
        }
        $post['id_request_hair_stylist'] = $id;   
        $result = MyHelper::post('mitra/request/update', $post);
        if(isset($result['status']) && $result['status'] == 'success'){
            return redirect('recruitment/hair-stylist/request/detail/'.$id)->withSuccess(['Success update request hair stylist']);
        }else{
            return redirect('recruitment/hair-stylist/request/detail/'.$id)->withErrors($result['messages'] ?? ['Failed update request hair stylist']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = MyHelper::post("mitra/request/delete", ['id_request_hair_stylist' => $id]);
        return $result;
    }

    public function reject($id)
    {
        $reject_reqeust = [
            "id_request_hair_stylist" => $id,
            "status" => 'Rejected'
        ];
        $rejected = MyHelper::post('mitra/request/update', $reject_reqeust);
        return $rejected;
    }
}
