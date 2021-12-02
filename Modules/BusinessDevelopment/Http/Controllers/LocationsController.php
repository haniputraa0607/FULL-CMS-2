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
    public function index(Request $request, $type = null)
    {
        $rule = false;
        $post = $request->all();
        $url = $request->url();
        if($type!='candidate'){
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
            $data['brands'] = MyHelper::get('partners/locations/brands')['result']??[];
            // dd($data['result']);
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
        $request->validate([
            "name" => "required",
            "address" => "required",
            "latitude" => "required",
            "longitude" => "required",
            "id_city" => "required",
        ]);
        if (isset($request['status'])){
            $request->validate([
                "start_date" => "required",
                "end_date" => "required"
            ]);
        }
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
        }elseif(isset($request['status']) && $request["status"] == 'Active'){
            $post['status'] = 'Active';
        }
        if ($request['start_date']!=null && $post['status'] == 'Active'){
            $post['start_date'] = date('Y-m-d', strtotime($request['start_date']));
        } 
        if ($request['end_date']!=null && $post['status'] == 'Active'){
            $post['end_date'] = date('Y-m-d', strtotime($request['end_date']));
        }
        $result = MyHelper::post('partners/locations/update', $post);
        if(isset($result['status']) && $result['status'] == 'success' && isset($post["status"])){
            if($request["status"] == 'on'){
                return redirect('businessdev/locations/detail/'.$id)->withSuccess(['Success update location']);
            }else{
                return redirect('businessdev/locations/detail/'.$id)->withSuccess(['Success update candidate location to location']);
            }
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

    public function approved(Request $request) {
        $update_status_step = [
            "id_location" => $request["id_location"],
            "step_loc" => "Finished Follow Up",
            "status" => 'Candidate'
        ];
        $location_step = MyHelper::post('partners/locations/update', $update_status_step);
        return $location_step; 
    }

    public function followUp(Request $request){
        $request->validate([
            "import_file" => "mimes:pdf|max:2000",
            "note" => "required",
        ]);
        $post_follow_up = [
            "id_location" => $request["id_location"],
            "follow_up" => $request["follow_up"],
            "note" => $request["note"],  
        ];

        if(isset($request["follow_up"]) && $request["follow_up"]=='Follow Up 1'){
            $request->validate([
                "mall" => "required",
                "location_code" => "required",
                "location_large" => "required",
                "rental_price" => "required",
                "service_charge" => "required",
                "promotion_levy" => "required",
                "renovation_cost" => "required",
                "partnership_fee" => "required",
                "income" => "required"    
            ]);
            $update_data_location = [
                "id_location" => $request["id_location"],
                "code" => $request["location_code"],
                "name" => $request["nameLocation"],
                "address" => $request["addressLocation"],  
                "id_city" => $request["id_cityLocation"],  
                "id_brand" => $request["id_brand"],  
                "location_large" => $request["location_large"],  
                "rental_price" => $request["rental_price"],  
                "service_charge" => $request["service_charge"],  
                "promotion_levy" => $request["promotion_levy"],  
                "renovation_cost" => $request["renovation_cost"],  
                "partnership_fee" => $request["partnership_fee"],  
                "income" => $request["income"],   
                "mall" => $request["mall"],   
                "start_date" => date('Y-m-d', strtotime($request['start_date'])),  
                "end_date" => date('Y-m-d', strtotime($request['end_date']))
            ];
            $post_follow_up = [
                "id_location" => $request["id_location"],
                "follow_up" => "Follow Up",
                "note" => $request["note"],  
            ];
        }

        $update_data_location['id_location'] = $request["id_location"];
        $update_data_location['status'] = 'Candidate';
        if($request["follow_up"]=='Payment'){
            $update_data_location['step_loc'] = 'Payment';
        }elseif($request["follow_up"]=='Confirmation Letter'){
            $update_data_location['step_loc'] = 'Confirmation Letter';
        }elseif($request["follow_up"]=='Calculation'){
            $update_data_location['step_loc'] = 'Calculation';
        }elseif($request["follow_up"]=='Survey Location'){
            $update_data_location['step_loc'] = 'Survey Location';
        }else{
            $update_data_location['step_loc'] = 'On Follow Up';
        }

        if (isset($request["import_file"])) {
            $post_follow_up['attachment'] = MyHelper::encodeImage($request['import_file']);
        }

        $location_update =  MyHelper::post('partners/locations/update', $update_data_location);
        if (isset($location_update['status']) && $location_update['status'] == 'success') {
            $post['post_follow_up'] = $post_follow_up;
            $follow_up = MyHelper::post('partners/locations/create-follow-up', $post);
            if (isset($follow_up['status']) && $follow_up['status'] == 'success') {
                return redirect('businessdev/locations/detail/'.$request['id_location'])->withSuccess(['Success create step '.$request["follow_up"].'']);
            }else{
                return redirect('businessdev/locations/detail/'.$request['id_location'])->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
            }
        }elseif(isset($location_update['status']) && $location_update['status'] == 'fail_date'){
            return redirect('businessdev/locations/detail/'.$request['id_location'])->withErrors($location_update['messages'] ?? ['Failed create step '.$request["follow_up"].''])->withInput();
        }else{
            return redirect('businessdev/locations/detail/'.$request['id_location'])->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
        }
    }
}
