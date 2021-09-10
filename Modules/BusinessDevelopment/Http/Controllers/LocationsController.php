<?php

namespace Modules\BusinessDevelopment\Http\Controllers;

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

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $post = $request->all();
        $url = $request->url();
        if($url=='http://ixobox-cust-view.test/businessdev/locations'){
            $data = [
                'title'          => 'Locations',
                'sub_title'      => 'Locations List',
                'menu_active'    => 'locations',
                'submenu_active' => 'list-locations',
            ];
            $data['status'] = 'Active';
        } else {
            $data = [
                'title'          => 'Candidate Locations',
                'sub_title'      => 'Candidate Locations List',
                'menu_active'    => 'locations',
                'submenu_active' => 'list-candidate-locations',
            ];
            $data['status'] = 'Candidate';
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
            Session::forget('filter-list-locations');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-locations') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-locations');
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
        $list = MyHelper::post('partners/locations'.$page, $post);
        
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
            Session::put('filter-list-locations',$post);
        }
        return view('businessdevelopment::locations.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('businessdevelopment::create');
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
    public function show($id)
    {
        return view('businessdevelopment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function detail($id_location)
    {
        $result = MyHelper::post('partners/locations/edit', ['id_location' => $id_location]);
        if($result['result']['location']['status']=='Candidate'){
            $data = [
                'title'          => 'Candidate Location',
                'sub_title'      => 'Detail Candidate Location',
                'menu_active'    => 'locations',
                'submenu_active' => 'list-candidate-locations',
            ];
        } else {
            $data = [
                'title'          => 'Location',
                'sub_title'      => 'Detail Location',
                'menu_active'    => 'locations',
                'submenu_active' => 'list-locations',
            ];
        }
        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result']['location'];
            $data['cities'] = MyHelper::get('city/list')['result']??[];
            return view('businessdevelopment::locations.detail', $data);
        }else{
            return redirect('businessdev/partners')->withErrors($result['messages'] ?? ['Failed get detail user mitra']);
        }
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
            "name" => "required",
            "address" => "required",
            "latitude" => "required",
            "longitude" => "required",
            "id_city" => "required",
        ]);
        $post = [
            "id_location" => $id,
            "name" => $request["name"],
            "address" => $request["address"],
            "latitude" => $request["latitude"],
            "longitude" => $request["longitude"],
            "id_city" => $request["id_city"],
            "id_partner" => $request["id_partner"],
        ];
        if (isset($request['pic_name']) && $request["pic_name"] != null){
            $post['pic_name'] = $request['pic_name'];
        } else {
            $post['pic_name'] = '';
        }
        if (isset($request['pic_contact']) && $request["pic_contact"] != null){
            $post['pic_contact'] = $request['pic_contact'];
        } else {
            $post['pic_contact'] = '';
        }
        if (isset($request['status']) && $request["status"] == 'on'){
            $post['status'] = 'Active';
        }
        $result = MyHelper::post('partners/locations/update', $post);
        if(isset($result['status']) && $result['status'] == 'success' && $request["status"] == 'on'){
            return redirect('businessdev/locations/detail/'.$id)->withSuccess(['Success update candidate location to location']);
        }elseif(isset($result['status']) && $result['status'] == 'success'){
            return redirect('businessdev/locations/detail/'.$id)->withSuccess(['Success update candidate location']);
        }else{
            return redirect('businessdev/locations/detail/'.$id)->withErrors($result['messages'] ?? ['Failed update detail candidate location']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = MyHelper::post("partners/locations/delete", ['id_location' => $id]);
        return $result;
    }
}
