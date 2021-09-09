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

class PartnersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $post = $request->all();
        $url = $request->url();
        if($url=='http://ixobox-cust-view.test/businessdev/partners'){
            $data = [
                'title'          => 'Partners',
                'sub_title'      => 'List Partners',
                'menu_active'    => 'partners',
                'submenu_active' => 'list-partners',
            ];
            $data['status'] = '';
        } else {
            $data = [
                'title'          => 'Candidate Partners',
                'sub_title'      => 'List Candidate Partners',
                'menu_active'    => 'partners',
                'submenu_active' => 'list-candidate-partners',
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
            Session::forget('filter-list-partners');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-partners') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-partners');
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

        $list = MyHelper::post('partners'.$page, $post);
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
            Session::put('filter-list-partners',$post);
        }
        return view('businessdevelopment::partners.list', $data);
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
    public function detail($user_id)
    {
        $result = MyHelper::post('partners/edit', ['id_partner' => $user_id]);
        if($result['result']['partner']['status']=='Candidate'){
            $data = [
                'title'          => 'Candidate Partner',
                'sub_title'      => 'Detail Candidate Partner',
                'menu_active'    => 'partners',
                'submenu_active' => 'list-candidate-partners',
            ];
        } else {
            $data = [
                'title'          => 'Partner',
                'sub_title'      => 'Detail Partner',
                'menu_active'    => 'partners',
                'submenu_active' => 'list-partners',
            ];
        }
        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result']['partner'];
            $data['bank'] = MyHelper::get('disburse/setting/list-bank-account')['result']['list_bank']??[];
            $data['cities'] = MyHelper::get('city/list')['result']??[];
            return view('businessdevelopment::partners.detail', $data);
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
            "email" => "required",
        ]);
        if(isset($request["status"]) && $request["status"] == 'on'){
            $post['status'] = 'Active';
            $request->validate([
                "ownership_status" => "required",
                "cooperation_scheme" => "required",
                "start_date" => "required",
                "end_date" => "required",
            ]);
        }if(isset($request["status"]) && $request["status"] == 'Active'){
            $post['status'] = $request["status"];
            $request->validate([
                "ownership_status" => "required",
                "cooperation_scheme" => "required",
                "password" => "required",
                "start_date" => "required",
                "end_date" => "required",
            ]);
        }
        if(isset($request["id_location"]) && $request["id_location"] != null){
            $request->validate([
                "nameLocation" => "required",
                "addressLocation" => "required",
                "latitudeLocation" => "required",
                "longitudeLocation" => "required",
                "id_cityLocation" => "required",
            ]);
        }
        $post = [
            "id_partner" => $id,
            "name" => $request["name"],
            "phone" => $request["phone"],
            "email" => $request["email"],
            "address" => $request["address"],
        ];
        if (isset($request['ownership_status'])){
            $post['ownership_status'] = $request['ownership_status'];
        } 
        if (isset($request['cooperation_scheme'])){
            $post['cooperation_scheme'] = $request['cooperation_scheme'];
        } 
        if (isset($request['id_bank_account'])){
            $post['id_bank_account'] = $request['id_bank_account'];
        }
        if ($request['start_date']!=null && $request["status"] == 'on'){
            $post['start_date'] = date('Y-m-d', strtotime($request['start_date']));
        } 
        if ($request['end_date']!=null && $request["status"] == 'on'){
            $post['end_date'] = date('Y-m-d', strtotime($request['end_date']));
        } 
        if(isset($request["status"]) && $request["status"] == 'on'){
            $post['status'] = 'Active';
        }
        if(isset($request["password"]) && $request["status"] == 'on'){
            $post['password'] = Hash::make($request["password"]);
        }
        if(isset($request["id_location"]) && $request["id_location"] != null){
            $postLocation = [
                "id_location" => $request["id_location"],
                "id_partner" => $id,
                "name" => $request["nameLocation"],
                "address" => $request["addressLocation"],
                "latitude" => $request["latitudeLocation"],
                "longitude" => $request["longitudeLocation"],
                "id_city" => $request["id_cityLocation"],
            ];
        }
        // dd($postLocation);
        $result = MyHelper::post('partners/update', $post);
        if (isset($result['status']) && $result['status'] == 'success') {
            if(isset($postLocation)){
                $result = MyHelper::post('partners/locations/update', $postLocation);
            }
        }
        if(isset($result['status']) && $result['status'] == 'success' && isset($request["status"])){
            return redirect('businessdev/partners/detail/'.$id)->withSuccess(['Success update candidate partner to partner']);
        }elseif(isset($result['status']) && $result['status'] == 'success'){
            return redirect('businessdev/partners/detail/'.$id)->withSuccess(['Success update candidate partner']);
        }else{
            return redirect('businessdev/partners/detail/'.$id)->withErrors($result['messages'] ?? ['Failed update detail candidate partner']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = MyHelper::post("partners/delete", ['id_partner' => $id]);
        return $result;
    }
}
