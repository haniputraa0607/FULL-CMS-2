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
            if(isset($data['result']['id_brand'])){
                $data['formSurvey'] = MyHelper::post('partners/form-survey',['id_brand' => $data['result']['id_brand']]);
            }else{
                $data['formSurvey'] = [];
            }
            
            return view('businessdevelopment::locations.detail', $data);
        }else{
            return redirect('businessdev/partners')->withErrors($result['messages'] ?? ['Failed get detail user mitra']);
        }
    }

    public function dataConfirmation($data){
        $send= [];

        if(isset($data['location_city'])){
            $send['city'] = ucwords(strtolower($data['location_city']['city_name'])).', '.$data['location_city']['province']['province_name'];
        }

        if($data['name'] != null){
            $send['lokasi'] = 'Ixobox '.$data['name'];
        }
        if($data['address'] != null){
            $send['address'] = $data['address'];
        }

        if($data['location_large'] != null){
            $send['large'] = $data['location_large'];
        }
        if($data['total_box'] != null){
            $send['box'] = $data['total_box'];
        }
        if($data['partnership_fee'] != null){
            $send['partnership_fee'] = $this->rupiah(isset($data['value_detail_decode']['Inisiasi Partner']['netto']) ? $data['value_detail_decode']['Inisiasi Partner']['netto'] : $data['partnership_fee']);
            $send['dp'] = $this->rupiah($data['partnership_fee']*0.2);
            $send['dp2'] = $this->rupiah($data['partnership_fee']*0.3);
            $send['final'] = $this->rupiah($data['partnership_fee']*0.5);
        }

        if($data['location_partner']){
            $send['pihak_dua'] = strtoupper($data['location_partner']['title']).' '.strtoupper($data['location_partner']['name']);
            $send['contact_person'] = $data['location_partner']['contact_person'];
        }

        if($data['start_date'] != null && $data['end_date'] != null){
            $send['waktu'] = $this->timeTotal(explode('-', date('Y-m-d', strtotime($data['start_date']))),explode('-', date('Y-m-d', strtotime($data['end_date']))));
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
            // "id_partner" => $request["id_partner"],
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
        
        if(isset($request["follow_up"]) && $request["follow_up"]=='Input Data Location'){
            $request->validate([
                "mall" => "required",
                "width" => "required",
                "height" => "required",
                "length" => "required",
                "location_large" => "required",
                "id_cityLocation" => "required",
            ]);
            $update_data_location = [
                "id_location" => $request["id_location"],
                "name" => $request["nameLocation"],
                "address" => $request["addressLocation"],  
                "id_city" => $request["id_cityLocation"],  
                "width" => $request["width"],  
                "height" => $request["height"],  
                "length" => $request["length"],  
                "location_large" => $request["location_large"],
                "mall" => $request["mall"]
            ];
        }

        $update_data_location['id_location'] = $request["id_location"];
        $update_data_location['status'] = 'Candidate';
        
        if($request["follow_up"]=='Approved'){
            $update_data_location['step_loc'] = 'Approved';
            $tab = '';
        }elseif($request["follow_up"]=='Survey Location'){
            $update_data_location['step_loc'] = 'Survey Location';
            $tab = '#survey';
        }elseif($request["follow_up"]=='Input Data Location'){
            $update_data_location['step_loc'] = 'Input Data Location';
            $tab = '#input';
        }else{
            $update_data_location['step_loc'] = 'On Follow Up';
            $tab = '#follow';
        }

        if (isset($request["import_file"])) {
            $post_follow_up['attachment'] = MyHelper::encodeImage($request['import_file']);
        }

        if(isset($request["follow_up"]) && $request["follow_up"]=='Survey Location'){
            $request->validate([
                "surye_note" => "required",
                "id_brand" => "required",
            ]);
            $form_survey = [
                "id_location"  => $request["id_location"],
                'note' => $request['surye_note'],
                'title' => $request['title'],
                'date' => date('Y-m-d', strtotime($request['survey_date'])),
                'surveyor' => $request['surveyor'],
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
            $update_data_location["id_brand"] = $request['id_brand'];
        }

        if(isset($request["follow_up"]) && $request["follow_up"]=='Approved'){
            $request->validate([
                "location_code" => "required",
                "no_loi" => "required",
                "date_loi" => "required",
                "rental_price" => "required",
                "service_charge" => "required",
                "promotion_levy" => "required",
            ]);
            if(!empty($request['start_date']) && !empty($request['end_date'])){
                if($request['end_date'] == $request['start_date']){
                    return redirect('businessdev/locations/detail/'.$request['id_location'].$tab)->withErrors($result['messages'] ?? ['The start date and end date must be different.']);
                }
            }
            $update_data_location["status"] = 'Active';
            $update_data_location["code"] = $request['location_code'];
            $update_data_location["rental_price" ] = preg_replace("/[^0-9]/", "", $request["rental_price"]);
            $update_data_location["service_charge"]  = preg_replace("/[^0-9]/", "", $request["service_charge"]);  
            $update_data_location["promotion_levy"]  = preg_replace("/[^0-9]/", "", $request["promotion_levy"]);  
            $update_data_location["start_date"]  = (empty($request['start_date']) ? null : date('Y-m-d', strtotime($request['start_date'])));
            $update_data_location["end_date"]  = (empty($request['start_date']) ? null : date('Y-m-d', strtotime($request['end_date'])));
            $update_data_location["no_loi"]  = $request["no_loi"];
            $update_data_location["date_loi"]  = date('Y-m-d', strtotime($request['date_loi']));
            $update_data_location["is_tax"]  = 0;
            $cek = [
                "id" => $request['id_location'],
                "code" => $request['location_code'],
                "table" => 'Locations'
            ];
            $cek_duplikat = MyHelper::post('partners/cek-duplikat', $cek);
            if(isset($cek_duplikat['status']) && $cek_duplikat['status'] == 'duplicate_code'){
                return redirect('businessdev/locations/detail/'.$request['id_location'])->withErrors($cek_duplikat['messages'] ?? ['Failed create step '.$request["follow_up"].' Code must be different'])->withInput($request->except('location_code'));
            }
        }

        if(isset($update_data_location) && !empty($update_data_location)){
            $post_loc['update_data_location'] = $update_data_location;
        }

        $location_update =  MyHelper::post('partners/locations/update', $post_loc);
        if (isset($location_update['status']) && $location_update['status'] == 'success') {
            $post['post_follow_up'] = $post_follow_up;
            if(isset($form_survey) && !empty($form_survey)){
                $post['form_survey'] = $form_survey;
            }
            $follow_up = MyHelper::post('partners/locations/create-follow-up', $post);
            if (isset($follow_up['status']) && $follow_up['status'] == 'success') {
                if(isset($update_data_location['status']) && !empty($update_data_location['status']) && $update_data_location['status']=='Active'){
                    return redirect('businessdev/locations/detail/'.$request['id_location'].$tab)->withSuccess(['Success update candidate location to location']); 
                }
                return redirect('businessdev/locations/detail/'.$request['id_location'].$tab)->withSuccess(['Success create step '.$request["follow_up"].'']);
            }else{
                return redirect('businessdev/locations/detail/'.$request['id_location'].$tab)->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
            }
        }else{
            return redirect('businessdev/locations/detail/'.$request['id_location'].$tab)->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
        }
    }

    public function detailFormSurvey($id){
        $result = MyHelper::post('partners/form-survey',['id_brand' => $id]);
        return $result;
    }

    public function detailStatus($id_location)
    {
        $result = MyHelper::post('partners/locations/edit', ['id_location' => $id_location]);

        $data = [
            'title'          => 'Partners',
            'sub_title'      => 'Detail Status Location Partner',
            'menu_active'    => 'partners',
            'submenu_active' => 'list-partners',
        ];
        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result']['location'];
            $data['steps'] = MyHelper::post('partners/locations/new-status', ['id_partner' => $data['result']['location_partner']['id_partner'],'id_location' => $id_location])['result']??[];
            $data['cities'] = MyHelper::get('city/list')['result']??[];
            $data['brands'] = MyHelper::get('partners/locations/brands')['result']??[];
            $data['list_starters'] = MyHelper::get('partners/list-location')['result']['starters']??[];
            $data['terms'] = MyHelper::get('partners/term')['result']??[];
            $data['confirmation'] = $this->dataConfirmation($result['result']['location']);
            // return $data;
            return view('businessdevelopment::locations.detail_status', $data);
        }else{
            return redirect('businessdev/partners')->withErrors($result['messages'] ?? ['Failed get detail user mitra']);
        }
    }

    public function settingBeforeAfter($key){
        $data = [];
        $colLabel = 2;
        $colInput = 10;
        $label = '';
        $title = 'Setting Landing Page';

        if($key == 'partner') {
            $sub_title = 'Form Registration Partner';
            $sub = 'partners';
            $active = 'landing-page';
            $label = 'Content';
            $key_setting = 'setting_partner_content';
        } elseif($key == 'location') {
            $sub_title = 'Form Registration Location';
            $sub = 'locations';
            $active = 'landing-page';
            $label = 'Content';
            $key_setting = 'setting_locations_content';
        } elseif($key == 'hairstylist') {
            $sub_title = 'Form Registration Hair Stylist';
            $sub = 'hair-stylist';
            $active = 'landing-page';
            $label = 'Content';
            $key_setting = 'setting_hairstylist_content';
        }

        $data = [
            'title'          => $title,
            'menu_active'    => $active,
            'submenu_active' => $sub,
            'sub_title'       => $sub_title,
            'label'          => $label,
            'colLabel'       => $colLabel,
            'colInput'       => $colInput,
            'key'            => $key_setting ?? null,
        ];

        $request['before'] = MyHelper::post('setting', ['key' => $key_setting.'_before']);
        $request['after'] = MyHelper::post('setting', ['key' => $key_setting.'_after']);

        if (isset($request['before']['status']) && $request['before']['status'] == 'success') {
            $result['before'] = $request['before']['result'];
            $data['before']['id'] = $result['before']['id_setting'];
            $data['before']['value'] = $result['before']['value_text'];

        }elseif(isset($request['before']['messages']) && $request['before']['messages'][0] == 'empty'){
            $data['before'] = null;
        }else {
            return redirect('home')->withErrors($request['before']['messages']);
        }

        if(isset($request['after']['status']) && $request['after']['status'] == 'success'){
            $result['after'] = $request['after']['result'];
            $data['after']['id'] = $result['after']['id_setting'];
            $data['after']['value'] = $result['after']['value_text'];

        }elseif(isset($request['after']['messages']) && $request['after']['messages'][0] == 'empty'){
            $data['after'] = null;
        }else {
            return redirect('home')->withErrors($request['after']['messages']);
        }

        return view('businessdevelopment::setting', $data);
    }

    public function settingUpdateBeforeAfter(Request $request, $key){
        $post = $request->except('_token');

        $update = MyHelper::post('partners/setting/update', ['key' => $key, 'value_before' => $post['value_before'], 'value_after' => $post['value_after']]);

        if($key == 'setting_partner_content'){
            $to = 'partner';
        }elseif($key == 'setting_locations_content'){
            $to = 'location';
        }else{ 
            $to = 'hairstylist';
        }

        return redirect('businessdev/setting/'.$to)->withSuccess(['Content Header and Footer has been updated.']);

    }
}
