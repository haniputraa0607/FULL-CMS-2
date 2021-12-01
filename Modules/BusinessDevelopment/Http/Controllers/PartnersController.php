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
    public function index(Request $request,$type = null)
    {
        $rule = false;
        $post = $request->all();
        $url = $request->url();
        if($type!='candidate'){
            $data = [
                'title'          => 'Partners',
                'sub_title'      => 'List Partners',
                'menu_active'    => 'partners',
                'submenu_active' => 'list-partners',
            ];
            $data['status'] = 'Active';
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
        if(isset($post['rule']) && !empty($post['rule'])){
            $rule = true;
        }
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
        return ['asd'];
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function detail($user_id)
    {
        $result = MyHelper::post('partners/edit', ['id_partner' => $user_id]);
        if($result['result']['partner']['status']=='Candidate' || $result['result']['partner']['status']=='Rejected'){
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
            $data['bankName'] = MyHelper::get('disburse/bank')['result']??[];
            $data['brands'] = MyHelper::get('partners/locations/brands')['result']??[];
            $data['terms'] = MyHelper::get('partners/term')['result']??[];
            $data['confirmation'] = $this->dataConfirmation($result['result']['partner'],$data['cities']);
            if(isset($data['result']['partner_locations'][0]['id_brand'])){
                $data['formSurvey'] = MyHelper::post('partners/form-survey',['id_brand' => $data['result']['partner_locations'][0]['id_brand']]);
            }else{
                $data['formSurvey'] = [];
            }
            $enkripsi = MyHelper::createSlug($data['result']['id_partner'], $data['result']['created_at']);
            $data['url_partners_close_temporary'] = url('businessdev/partners/close-temporary/').'/'.$enkripsi;
            $data['url_outlet'] = url('businessdev/partners/outlet/').'/'.$enkripsi;
            $data['url_partners_close_total'] = url('businessdev/partners/close-permanent/').'/'.$enkripsi;
            $data['url_partners_becomes_ixobox'] = url('businessdev/partners/becomes-ixobox/').'/'.$enkripsi;
            // dd($data['confirmation']);
//            return $data;
            return view('businessdevelopment::partners.detail', $data);
        }else{
            return redirect('businessdev/partners')->withErrors($result['messages'] ?? ['Failed get detail user mitra']);
        }
    }

    public function dataConfirmation($data,$city){
        $send= [];
        if($data['partner_locations']){
            foreach($city as $c){
                if($c['id_city']==$data['partner_locations'][0]['id_city']){
                    $city_name = $c['city_name'];
                }
            }
            if($data['partner_locations'][0]['mall'] != null && $data['partner_locations'][0]['id_city'] != null){
                $send['lokasi'] = strtoupper($data['partner_locations'][0]['mall']).' - '.strtoupper($city_name);
            }
            if($data['partner_locations'][0]['address'] != null){
                $send['address'] = $data['partner_locations'][0]['address'];
            }
    
            if($data['partner_locations'][0]['location_large'] != null){
                $send['large'] = $data['partner_locations'][0]['location_large'];
            }
            if($data['partner_locations'][0]['partnership_fee'] != null){
                $send['partnership_fee'] = $this->rupiah($data['partner_locations'][0]['partnership_fee']);
                $send['dp'] = $this->rupiah($data['partner_locations'][0]['partnership_fee']*0.2);
                $send['dp2'] = $this->rupiah($data['partner_locations'][0]['partnership_fee']*0.3);
                $send['final'] = $this->rupiah($data['partner_locations'][0]['partnership_fee']*0.5);
            }
        }
        if($data['gender']=='Man'){
            $send['pihak_dua'] = 'BAPAK '.strtoupper($data['contact_person']);
        }elseif($data['gender']=='Woman'){
            $send['pihak_dua']  = 'IBU '.strtoupper($data['contact_person']);
        }

        if($data['start_date'] != null && $data['end_date'] != null){
            $send['waktu'] = $this->timeTotal(explode('-', $data['start_date']),explode('-', $data['end_date']));
        }

        return $send;
    }

    public function rupiah($nominal){
        $rupiah = number_format($nominal ,0, ',' , '.' );
        return $rupiah.',-';
    }

    public function timeTotal($start_date,$end_date){
        if($end_date[2]==$start_date[2] && $end_date[1]==$start_date[1]){
            $tahun = $end_date[0]-$start_date[0];
            $total_waktu = $tahun.' tahun';
        }elseif($end_date[1]==$start_date[1]){
            $selisih_tanggal = $end_date[2]-$start_date[2];
            if($start_date[1]==2){
                if($start_date[0]%4==0){
                    $jumlah_hari = 29;
                }else{
                    $jumlah_hari =28;
                }
            }elseif($start_date[1]==4 || $start_date[1]==6 || $start_date[1]==9 || $start_date[1]==11){
                $jumlah_hari = 30;
            }else{
                $jumlah_hari = 31;
            }
            if($selisih_tanggal>0){
                $tahun = $end_date[0]-$start_date[0];
                $tanggal = $end_date[2]-$start_date[2];
            }else{
                $awal = intval($start_date[2]);
                $akhir = intval($end_date[2]);
                $tahun = ($end_date[0]-$start_date[0])-1;
                $tanggal = ($jumlah_hari-$awal)+$akhir;
            }
            $total_waktu = $tahun.' tahun '.$tanggal.' hari';
        }elseif($end_date[2]==$start_date[2]){
            $selisih_bulan = $end_date[1]-$start_date[1];
            if($selisih_bulan>0){
                $tahun = $end_date[0]-$start_date[0];
                $bulan = $end_date[1]-$start_date[1];
            }else{
                $awal = intval($start_date[1]);
                $akhir = intval($end_date[1]);
                $tahun = ($end_date[0]-$start_date[0])-1;
                $bulan = (12-$awal)+$akhir;
            }
            $total_waktu = $tahun.' tahun '.$bulan.' bulan';
        }else{
            $selisih_bulan = $end_date[1]-$start_date[1];
            $selisih_tanggal = $end_date[2]-$start_date[2];
            if($start_date[1]==2){
                if($start_date[0]%4==0){
                    $jumlah_hari = 29;
                }else{
                    $jumlah_hari =28;
                }
            }elseif($start_date[1]==4 || $start_date[1]==6 || $start_date[1]==9 || $start_date[1]==11){
                $jumlah_hari = 30;
            }else{
                $jumlah_hari = 31;
            }
            if($selisih_tanggal>0){
                if($selisih_bulan>0){
                    $tahun = $end_date[0]-$start_date[0];
                    $bulan = $end_date[1]-$start_date[1];
                    $tanggal = $end_date[2]-$start_date[2];
                }else{
                    $awal = intval($start_date[1]);
                    $akhir = intval($end_date[1]);
                    $tahun = ($end_date[0]-$start_date[0])-1;
                    $bulan = (12-$awal)+$akhir;
                    $tanggal = $end_date[2]-$start_date[2];
                }
                $total_waktu = $tahun.' tahun '.$bulan.' bulan '.$tanggal.' hari';
            }else{
                if($selisih_bulan==1){
                    $tahun = $end_date[0]-$start_date[0];
                    $tanggal = ($jumlah_hari-$start_date[2])+$end_date[2];
                    $total_waktu = $tahun.' tahun '.$tanggal.' hari';
                }elseif($selisih_bulan>0){
                    $tahun = $end_date[0]-$start_date[0];
                    $bulan = $end_date[1]-$start_date[1];
                    $tanggal = ($jumlah_hari-$start_date[2])+$end_date[2];
                    $total_waktu = $tahun.' tahun '.$bulan.' bulan '.$tanggal.' hari';
                }else{
                    $awal = intval($start_date[1]);
                    $akhir = intval($end_date[1]);
                    $tahun = ($end_date[0]-$start_date[0])-1;
                    $bulan = (12-$awal)+$akhir;
                    $tanggal = ($jumlah_hari-$start_date[2])+$end_date[2];
                    $total_waktu = $tahun.' tahun '.$bulan.' bulan '.$tanggal.' hari';
                }
            }
            
        }
        return $total_waktu;
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
            "cp" => "required",
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
            $status = 'on';
        }if(isset($request["status"]) && $request["status"] == 'Active'){
            $post['status'] = $request["status"];
            $request->validate([
                "ownership_status" => "required",
                "cooperation_scheme" => "required",
                "pin" => "required|min:6",
                "start_date" => "required",
                "end_date" => "required",
            ]);
            $status = 'on';
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
            "contact_person" => $request["cp"],
            "phone" => $request["phone"],
            "email" => $request["email"],
            "address" => $request["address"],
        ];
        if (isset($request['gender'])){
            $post['gender'] = $request['gender'];
        } 
        if (isset($request['ownership_status']) && $status == 'on'){
            $post['ownership_status'] = $request['ownership_status'];
        } 
        if (isset($request['cooperation_scheme']) && $status == 'on'){
            $post['cooperation_scheme'] = $request['cooperation_scheme'];
        } 
        if (isset($request['id_bank_account']) && $status == 'on'){
            $post['id_bank_account'] = $request['id_bank_account'];
        }
        if ($request['start_date']!=null && $status == 'on'){
            $post['start_date'] = date('Y-m-d', strtotime($request['start_date']));
        } 
        if ($request['end_date']!=null && $status == 'on'){
            $post['end_date'] = date('Y-m-d', strtotime($request['end_date']));
        } 
        if(isset($request["status"]) && $status == 'on'){
            $post['status'] = 'Active';
        }
        if(isset($request["pin"]) && $status == 'on'){
            $post['password'] = Hash::make($request["pin"]);
            $post['pin'] = $request['pin'];
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
        $result = MyHelper::post('partners/update', $post);
        if (isset($result['status']) && $result['status'] == 'success') {
            if(isset($postLocation)){
                $result = MyHelper::post('partners/locations/update', $postLocation);
            }
        }
        if(isset($result['status']) && $result['status'] == 'success' && isset($post["status"])){
            if ($request["status"] == 'Active') {
                return redirect('businessdev/partners/detail/'.$id)->withSuccess(['Success update candidate partner to partner']);
            }else{
                return redirect('businessdev/partners/detail/'.$id)->withSuccess(['Success update partner']);
            }
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

    public function updateBankAccount(Request $request, $id_bank_account){
        $request->validate([
            "id_bank_name" => "required",
            "beneficiary_name" => "required",
            "beneficiary_account" => "required",
        ]);
        $post = [
            "id_bank_account" => $id_bank_account,
            "id_bank_name" => $request["id_bank_name"],
            "beneficiary_name" => $request["beneficiary_name"],
            "beneficiary_account" => $request["beneficiary_account"],
        ];
        $result = MyHelper::post('partners/bankaccount/update', $post);
        if(isset($result['status']) && $result['status'] == 'success'){
            return redirect('businessdev/partners/detail/'.$request['id_partner'])->withSuccess(['Success update bank account']);
        }else{
            return redirect('businessdev/partners/detail/'.$request['id_partner'])->withErrors($result['messages'] ?? ['Failed update detail bank account']);
        }

    }

    public function createBankAccount(Request $request){
        $request->validate([
            "id_bank_name" => "required",
            "beneficiary_name" => "required",
            "beneficiary_account" => "required",
        ]);
        $post = $request->all();
        $result = MyHelper::post('partners/bankaccount/update', $post);
        if(isset($result['status']) && $result['status'] == 'success'){
            return redirect('businessdev/partners/detail/'.$post['id_partner'])->withSuccess(['Success create bank account']);
        }else{
            return redirect('businessdev/partners/detail/'.$post['id_partner'])->withErrors($result['messages'] ?? ['Failed create bank account']);
        }

    }
    public function resetPin(Request $request, $id_partner){
        // dd($request->all());
        $request->validate([
            "new-pin" => "required|min:6",
            "confirm-pin" => "required|min:6|same:new-pin",
            "your-pin" => "required|min:6",
        ]);
        $post = $request->all();
        if(isset($post['your-pin'])){
			$checkpin = MyHelper::post('users/pin/check-backend', array('phone' => Session::get('phone'), 'pin' => $post['your-pin'], 'admin_panel' => 1));
			if($checkpin['status'] != "success")
				return back()->withErrors(['invalid_credentials' => 'Invalid PIN']);
			else
                $updatePassword = [
                    "id_partner" => $id_partner,
                    "password" => Hash::make($post["new-pin"]),
                ];
                $result = MyHelper::post('partners/update', $updatePassword);
                if(isset($result['status']) && $result['status'] == 'success'){
                    return redirect('businessdev/partners/detail/'.$id_partner)->withSuccess(['Success reset PIN']);
                }else{
                    return redirect('businessdev/partners/detail/'.$id_partner)->withErrors($result['messages'] ?? ['Failed reset PIN']);
                }
		}
        redirect('businessdev/partners/detail/'.$id_partner);
    }

    public function listRequestUpdate(Request $request){
        $data = [
            'title'          => 'Partners',
            'sub_title'      => 'List Request Update Partners',
            'menu_active'    => 'partners',
            'submenu_active' => 'list-request-update',
        ];
        $post = $request->all();
        $order = 'created_at';
        $orderType = 'desc';
        $sorting = 0;
        if(isset($post['sorting'])){
            $sorting = 1;
            $order = $post['order'];
            $orderType = $post['order_type'];
        }
        if(isset($post['reset']) && $post['reset'] == 1){
            Session::forget('filter-list-request-update');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-request-update') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-request-update');
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
        $list = MyHelper::post('partners/request-update'.$page, $post);
        
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
            Session::put('filter-list-request-update',$post);
        }
        return view('businessdevelopment::partners.list_request', $data);
    }

    public function destroyRequestUpdate($id){
        $result = MyHelper::post("partners/request-update/delete", ['id_partners_log' => $id]);
        return $result;
    }

    public function detailRequestUpdate($id)
    {
        $result = MyHelper::post('partners/request-update/detail', ['id_partners_log' => $id]);
        $data = [
            'title'          => 'Partners',
            'sub_title'      => 'Detail Request Update Partners',
            'menu_active'    => 'partners',
            'submenu_active' => 'list-request-update',
        ];
        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result']['partners_log'];
            return view('businessdevelopment::partners.detail_request', $data);
        }else{
            return redirect('businessdev/partners')->withErrors($result['messages'] ?? ['Failed get detail user mitra']);
        }
    }

    public function updateRequestUpdate(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
            "phone" => "required",
            "email" => "required",
            "address" => "required",
        ]);
        $post = $request->except('_token','old_name','old_phone','old_email','old_address');
        $post['request'] = 'approve';
        $result = MyHelper::post('partners/update', $post);
        if(isset($result['status']) && $result['status'] == 'success'){
            $delete = $this->destroyRequestUpdate($id);
            if(isset($delete['status']) && $delete['status'] == 'success'){
                return redirect('businessdev/partners/detail/'.$request['id_partner'])->withSuccess(['Success approve request update partner']);
            }else{
                return redirect('businessdev/partners/request-update/detail/'.$id)->withErrors($result['messages'] ?? ['Failed approve request update partner']);
            }
        }else{
            return redirect('businessdev/partners/request-update/detail/'.$id)->withErrors($result['messages'] ?? ['Failed approve request update partner']);
        }
    }
    public function approved(Request $request) {
        $update_status_step = [
            "id_partner" => $request["id_partner"],
            "status_steps" => "Finished Follow Up",
            "status" => 'Candidate'
        ];
        $partner_step = MyHelper::post('partners/update', $update_status_step);
       return $partner_step; 
    }
    public function followUp(Request $request){
        $request->validate([
            "import_file" => "mimes:pdf|max:2000",
            "note" => "required",
        ]);
        $post_follow_up = [
            "id_partner" => $request["id_partner"],
            "follow_up" => $request["follow_up"],
            "note" => $request["note"],  
        ];
        if(isset($request["follow_up"]) && $request["follow_up"]=='Follow Up 1'){
            $request->validate([
                "mall" => "required",
                "partner_code" => "required",
                "location_code" => "required",
                "location_large" => "required",
                "rental_price" => "required",
                "service_charge" => "required",
                "promotion_levy" => "required",
                "renovation_cost" => "required",
                "partnership_fee" => "required",
                "income" => "required",
                "npwp" => "required",
                "title" => "required",
                "npwp_name" => "required",
                "termpayment" => "required",
                "partner_note" => "required",    
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
            ];
            if (isset($request["mobile"]) && !empty($request["mobile"])) {
                $request->validate([
                    "mobile" => "numeric|min:10|max:13",
                ]);
            }
            $post_follow_up = [
                "id_partner" => $request["id_partner"],
                "follow_up" => "Follow Up",
                "note" => $request["note"],  
            ];
        }
        
        if (isset($request["import_file"])) {
            $post_follow_up['attachment'] = MyHelper::encodeImage($request['import_file']);
        }
        
        if($request["follow_up"]=='Payment'){
            $status_steps = 'Payment';
        }elseif($request["follow_up"]=='Confirmation Letter'){
            $status_steps = 'Confirmation Letter';
        }elseif($request["follow_up"]=='Calculation'){
            $status_steps = 'Calculation';
        }elseif($request["follow_up"]=='Survey Location'){
            $status_steps = 'Survey Location';
        }else{
            $status_steps = 'On Follow Up';
        }
        $update_partner = [
            "id_partner" => $request["id_partner"],
            "status_steps" => $status_steps,
            "status" => 'Candidate'
        ];
        if (isset($request["npwp"]) && $request["follow_up"]=='Follow Up 1') {
            $update_partner['npwp'] = $request['npwp'];
        }
        if (isset($request["title"]) && $request["follow_up"]=='Follow Up 1') {
            $update_partner['title'] = $request['title'];
        }
        if (isset($request["partner_code"]) && $request["follow_up"]=='Follow Up 1') {
            $update_partner['code'] = $request['partner_code'];
        }
        if (isset($request["mobile"]) && $request["follow_up"]=='Follow Up 1' && !empty($request["mobile"])) {
            $update_partner['mobile'] = $request['mobile'];
        }elseif(empty($request["mobile"]) && $request["follow_up"]=='Follow Up 1') {
            $update_partner['mobile'] = 'default';
        }
        if (isset($request["npwp_name"]) && $request["follow_up"]=='Follow Up 1') {
            $update_partner['npwp_name'] = $request['npwp_name'];
        }
        if (isset($request["npwp_address"]) && $request["follow_up"]=='Follow Up 1') {
            $update_partner['npwp_address'] = $request['npwp_address'];
        }
        if (isset($request["termpayment"]) && $request["follow_up"]=='Follow Up 1') {
            $update_partner['id_term_payment'] = $request['termpayment'];
        }
        if (isset($request["partner_note"]) && $request["follow_up"]=='Follow Up 1') {
            $update_partner['notes'] = $request['partner_note'];
        }
        if (isset($request['ownership_status']) && $request['follow_up']=='Follow Up 1'){
            $update_partner['ownership_status'] = $request['ownership_status'];
        } 
        if (isset($request['cooperation_scheme']) && $request['follow_up']=='Follow Up 1'){
            $update_partner['cooperation_scheme'] = $request['cooperation_scheme'];
        } 
        if (isset($request['id_bank_account']) && $request['follow_up']=='Follow Up 1'){
            $update_partner['id_bank_account'] = $request['id_bank_account'];
        }
        if ($request['start_date']!=null && $request['follow_up']=='Follow Up 1'){
            $update_partner['start_date'] = date('Y-m-d', strtotime($request['start_date']));
        } 
        if ($request['end_date']!=null && $request['follow_up']=='Follow Up 1'){
            $update_partner['end_date'] = date('Y-m-d', strtotime($request['end_date']));
        }

        if(isset($request["follow_up"]) && $request["follow_up"]=='Survey Location'){
            $request->validate([
                "surye_note" => "required",
            ]);
            $form_survey = [
                "id_partner"  => $request["id_partner"],
                'note' => $request['surye_note'],
                'date' => date("Y-m-d"),
                'surveyor' => session('name'),
            ];
            if(isset($request["survey_potential"]) && $request["survey_potential"]=='on'){
                $form_survey['potential'] = 1;
            } else{
                $form_survey['potential'] = 0;
            };
            $index_cat = 1;
            foreach($request['category'] as $cat){
                $name_cat = 'cat'.$index_cat;
                $form[$name_cat]['category'] = $cat['cat'];
                foreach($cat['question'] as $q => $que){
                    $form[$name_cat]['value'][$q]['question'] = $que['question'];
                    $form[$name_cat]['value'][$q]['answer'] = $que['answer'];
                }
                $index_cat++;
            }
            $form_survey["value"] = json_encode($form);
        }
        if(isset($request["follow_up"]) && $request["follow_up"]=='Calculation'){
            $request->validate([
                "total_payment" => "required",
            ]);
            $update_data_location = [
                "id_location" => $request["id_location"],
                "total_payment" => $request["total_payment"],
            ];
        }
        if(isset($request["follow_up"]) && $request["follow_up"]=='Confirmation Letter'){
            $request->validate([
                "no_letter" => "required",
                "location_letter" => "required",
            ]);
            $data_confir = [
                "id_partner"  => $request["id_partner"],
                "no_letter" => $request["no_letter"],
                "location" => $request["location_letter"],
            ];
            $update_data_location = [
                "id_location" => $request["id_location"],
                "notes" => $request["payment_note"],
            ];
        }
        if(isset($request["follow_up"]) && $request["follow_up"]=='Payment'){
            $update_partner['status'] = 'Active';
            $update_partner['pin'] = rand(100000,999999);
            $update_partner['password'] = Hash::make($update_partner["pin"]);
            $update_partner['trans_date'] = date('Y-m-d');
            $update_partner['due_date'] = date('Y-m-d', strtotime($request['due_date']));
            $update_data_location = [
                "id_location" => $request["id_location"],
                "status" => 'Active',
            ];
        }
        $partner_step = MyHelper::post('partners/update', $update_partner);
        if (isset($partner_step['status']) && $partner_step['status'] == 'success') {
            $post['post_follow_up'] = $post_follow_up;
            if(isset($form_survey) && !empty($form_survey)){
                $post['form_survey'] = $form_survey;
            }
            $follow_up = MyHelper::post('partners/create-follow-up', $post);
            if(isset($follow_up['status']) && $follow_up['status'] == 'success'){
                if(isset($update_data_location) && !empty($update_data_location)){
                    if(isset($update_data_location) && !empty($update_data_location)){
                        $post_loc['update_data_location'] = $update_data_location;
                    }
                    if (isset($data_confir) && !empty($data_confir)) {
                        $post_loc['data_confir'] = $data_confir;
                    }
                    if(isset($update_data_location['status']) && !empty($update_data_location['status']) && $update_data_location['status']=='Active'){
                        $post_loc['partner'] = $request['id_partner'];
                        $post_loc['location'] = $request['id_location'];
                    }
                    $location_update =  MyHelper::post('partners/locations/update', $post_loc);
                    if (isset($location_update['status']) && $location_update['status'] == 'success') {
                        if(isset($update_data_location['status']) && !empty($update_data_location['status']) && $update_data_location['status']=='Active'){
                            $project = MyHelper::get('project/initProject/'.$request['id_partner'].'/'.$request['id_location']);
                            if (isset($project['status']) && $project['status'] == 'success') {
                                return redirect('businessdev/partners/detail/'.$request['id_partner'])->withSuccess(['Success update candidate partner to partner']); 
                            }else{
                                return redirect('businessdev/partners/detail/'.$request['id_partner'])->withErrors($result['messages'] ?? ['Failed to update candidate partner to partner']);
                            }
                        }
                        return redirect('businessdev/partners/detail/'.$request['id_partner'])->withSuccess(['Success create step '.$request["follow_up"].'']);    
                    }else{
                        return redirect('businessdev/partners/detail/'.$request['id_partner'])->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
                    }
                }
                if(isset($update_partner['status']) && !empty($update_partner['status']) && $update_partner['status'] == 'Active'){
                    return redirect('businessdev/partners/detail/'.$request['id_partner'])->withSuccess(['Success update candidate partner to partner']); 
                }
                return redirect('businessdev/partners/detail/'.$request['id_partner'])->withSuccess(['Success create step '.$request["follow_up"].'']);    
            }else{
                return redirect('businessdev/partners/detail/'.$request['id_partner'])->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
            }
        }elseif(isset($partner_step['status']) && $partner_step['status'] == 'fail_date'){
            return redirect('businessdev/partners/detail/'.$request['id_partner'])->withErrors($partner_step['messages'] ?? ['Failed create step '.$request["follow_up"].''])->withInput( );
        }else{
            return redirect('businessdev/partners/detail/'.$request['id_partner'])->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
        }
    }

    public function rejectCandidate($id)
    {
        $reject_partner = [
            "id_partner" => $id,
            "status" => 'Rejected'
        ];
        $partner_step = MyHelper::post('partners/update', $reject_partner);
        return $partner_step;
    }

}
