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

class OutletManageController extends Controller
{
    public function index(Request $request,$id){
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/outlet', ['id_partner' => $id]);
            $data = [
                'title'          => 'Partner',
                'sub_title'      => 'Manage Outlet',
                'menu_active'    => 'partners',
                'submenu_active' => 'manage-outlet',
            ];
        if(isset($result['status']) && $result['status'] == 'success'  ){
            $val = array();
            foreach ($result['result'] as $value) {
               if(!empty($value['cutoff'])){
                   if($value['cutoff']['status']!='Reject'){
                       $enkripsi = MyHelper::createSlug($value['cutoff']['id_outlet_cut_off'], $value['cutoff']['created_at']);
                       $value['url_detail'] = env('APP_URL').'businessdev/partners/outlet/cutoff/detail/'.$enkripsi;
                   }else{
                       $value['cutoff'] = false;
                   }
               }
               if(!empty($value['change'])){
                   if($value['change']['status']!='Reject'){
                       $enkripsi = MyHelper::createSlug($value['change']['id_outlet_change_ownership'], $value['change']['created_at']);
                       $value['url_detail'] = env('APP_URL').'businessdev/partners/outlet/change/detail/'.$enkripsi;
                       
                   }else{
                       $value['change'] = false;
                   }
               }
               if(!empty($value['close'])){
                       $enkripsi = MyHelper::createSlug($value['close']['id_outlet'], $value['close']['created_at']);
                       $value['url_detail_close'] = env('APP_URL').'businessdev/partners/outlet/close/list/'.$enkripsi;
               }
               array_push($val,$value);
            }
            $data['outlet'] = $val;
            $resultoutlet = MyHelper::post('partners/outlet/ready', ['id_partner' => $id]);
            $resultpartner = MyHelper::post('partners/outlet/partner', ['id_partner' => $id]);
            $data['listoutlet']=$resultoutlet['result'];
            $data['listpartner']=$resultpartner['result'];
            $data['id_partner'] = $id;
            return view('businessdevelopment::outlet_manage.index', $data);
        }else{
            return redirect()->back()->withErrors($result['messages'] ?? ['Failed get detail partner']);
        }
    }
    //cutoff
    public function detailCutoff(Request $request,$id){
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/outlet/cutoff/detail', ['id_outlet_cut_off' => $id]);
        $resultlampiran = MyHelper::post('partners/outlet/cutoff/lampiran/data', ['id_outlet_cut_off' => $id]);
           $data = [
                'title'          => 'Partner',
                'sub_title'      => 'Cut Off Outlet',
                'menu_active'    => 'partners',
                'submenu_active' => 'cut-off-outlet',
            ];
        if(isset($result['status']) && $result['status'] == 'success' ){
            $data['result'] = $result['result'];
            $lampiran = array();
            if(isset($resultlampiran['status'])&&$resultlampiran['status']=='success'){
                foreach ($resultlampiran['result'] as $value) {
                  array_push($lampiran, $value);
                }
            }
            $data['lampiran'] = $lampiran;
            $data['button'] = count($lampiran);
            return view('businessdevelopment::outlet_manage.detail', $data);
        }else{
            return redirect()->back()->withErrors($result['messages'] ?? ['Not Found']);
        }
    }
    public function createCutoff(Request $request){
        $post = $request->except('_token');
         if(isset($post['date'])&& $post['date']!=null){
        $post['date'] = date('Y-m-d', strtotime($post['date']));
        }
        $query = MyHelper::post('partners/outlet/cutoff/create', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                return back()->withSuccess(['Create Success']);
        } else{
                return back()->withErrors($query['messages']);
        } 
    }
    public function updateCutoff(Request $request){
         $post = $request->except('_token');
         if(isset($post['date'])&& $post['date']!=null){
        $post['date'] = date('Y-m-d', strtotime($post['date']));
        }
        $query = MyHelper::post('partners/outlet/cutoff/update', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                return back()->withSuccess(['Update Success']);
        } else{
                return back()->withErrors($query['messages']);
        }
    }
    public function rejectCutoff(Request $request){
         $post = $request->except('_token');
        $query = MyHelper::post('partners/outlet/cutoff/reject', $post);
        return $query;
    }
    public function successCutoff(Request $request){
         $post = $request->except('_token');
         $query = MyHelper::post('partners/outlet/cutoff/success', $post);
         return $query;
    }
    public function lampiranDeleteCutoff(Request $request)
    {
        $post = $request->except('_token'); 
	$query = MyHelper::post('partners/outlet/cutoff/lampiran/delete', $post);
        return $query; 
       
    }
    public function lampiranCreateCutoff(Request $request)
    {
        $post = $request->except('_token'); 
        if (isset($post["import_file"])) {
            $post['attachment'] = MyHelper::encodeImage($post['import_file']);
        }
	$query = MyHelper::post('partners/outlet/cutoff/lampiran/create', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                  return back()->withSuccess(['Create lampiran success']);
          } else{
                return back()->withErrors($query['messages']);
        }
       
    }
    
    //change_ownership
    public function detailChange(Request $request,$id){
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/outlet/change/detail', ['id_outlet_change_ownership' => $id]);
        $resultlampiran = MyHelper::post('partners/outlet/change/lampiran/data', ['id_outlet_change_ownership' => $id]);
           $data = [
                'title'          => 'Partner',
                'sub_title'      => 'Cut Off Outlet',
                'menu_active'    => 'partners',
                'submenu_active' => 'cut-off-outlet',
            ];
        if(isset($result['status']) && $result['status'] == 'success' ){
            $data['result'] = $result['result'];
            $lampiran = array();
            if(isset($resultlampiran['status'])&&$resultlampiran['status']=='success'){
            foreach ($resultlampiran['result'] as $value) {
              array_push($lampiran, $value);
            }
            }
            $data['lampiran'] = $lampiran;
            $data['button'] = count($lampiran);
            
            return view('businessdevelopment::outlet_manage.change_ownership.detail', $data);
        }else{
            return redirect()->back()->withErrors($result['messages'] ?? ['Not Found']);
        }
    }
    public function createChange(Request $request){
        $post = $request->except('_token');
         if(isset($post['date'])&& $post['date']!=null){
        $post['date'] = date('Y-m-d', strtotime($post['date']));
        }
        $query = MyHelper::post('partners/outlet/change/create', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                return back()->withSuccess(['Create Success']);
        } else{
                return back()->withErrors($query['messages']);
        }
    }
    public function updateChange(Request $request){
         $post = $request->except('_token');
         if(isset($post['date'])&& $post['date']!=null){
        $post['date'] = date('Y-m-d', strtotime($post['date']));
        }
        
        $query = MyHelper::post('partners/outlet/change/update', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                return back()->withSuccess(['Update Success']);
        } else{
                return back()->withErrors($query['messages']);
        }
    }
    public function rejectChange(Request $request){
         $post = $request->except('_token');
        $query = MyHelper::post('partners/outlet/change/reject', $post);
        return $query;
    }
    public function successChange(Request $request){
         $post = $request->except('_token');
         $query = MyHelper::post('partners/outlet/change/success', $post);
         return $query;
    }
    public function lampiranDeleteChange(Request $request)
    {
        $post = $request->except('_token'); 
	$query = MyHelper::post('partners/outlet/change/lampiran/delete', $post);
        return $query; 
       
    }
    public function lampiranCreateChange(Request $request)
    {
        $post = $request->except('_token'); 
        if (isset($post["import_file"])) {
            $post['attachment'] = MyHelper::encodeImage($post['import_file']);
        }
	$query = MyHelper::post('partners/outlet/change/lampiran/create', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                  return back()->withSuccess(['Create lampiran success']);
          } else{
                return back()->withErrors($query['messages']);
        }  
    }
    
    //Close
    public function listClose(Request $request,$id){
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/outlet/close/index', ['id_outlet' => $id]);
        $result1 = MyHelper::post('partners/outlet/close', ['id_outlet' => $id]);
           $data = [
                'title'          => 'Partner',
                'sub_title'      => 'List Close Temporary Outlet',
                'menu_active'    => 'partners',
                'submenu_active' => 'close-temporary-outlet',
            ];
        if(isset($result['status']) && $result['status'] == 'success' ){
            $data['result'] = array();
            $data['outlet'] = $result['result']['outlet'];
            foreach ($result['result']['list'] as $value) {
                $enkripsi = MyHelper::createSlug($value['id_outlet_close_temporary'], $value['created_at']);
                $value['url_detail'] = env('APP_URL').'businessdev/partners/outlet/close/detail/'.$enkripsi;
                array_push($data['result'],$value);
            }
            return $data;
            return view('businessdevelopment::outlet_manage.close_temporary.index', $data);
        }else{
            return redirect()->back()->withErrors($result['messages'] ?? ['Not Found']);
        }
    }
    public function detailClose(Request $request,$id){
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/outlet/close/detail', ['id_outlet_close_temporary' => $id]);
        $resultlampiran = MyHelper::post('partners/outlet/close/lampiran/data', ['id_outlet_close_temporary' => $id]);
           $data = [
                'title'          => 'Partner',
                'sub_title'      => 'Close Temporary Outlet',
                'menu_active'    => 'partners',
                'submenu_active' => 'close-temporary-outlet',
            ];
        if(isset($result['status']) && $result['status'] == 'success' ){
            $data['result'] = $result['result'];
            if($data['result']['jenis_active']=="Change Location"){
            $data['cities'] = MyHelper::get('city/list')['result']??[];
            $data['brands'] = MyHelper::get('partners/locations/brands')['result']??[];
            $data['confirmation'] = $this->dataConfirmation($result['result'],$data['cities']);
            if(isset($data['result']['id_brand'])){
                $data['formSurvey'] = MyHelper::post('partners/form-survey',['id_brand' => $data['result']['id_brand']]);
            }else{
                $data['formSurvey'] = [];
            }
            return view('businessdevelopment::outlet_manage.close_temporary.change_location.detail', $data);
            }
            $lampiran = array();
            if(isset($resultlampiran['status'])&&$resultlampiran['status']=='success'){
            foreach ($resultlampiran['result'] as $value) {
              array_push($lampiran, $value);
            }
            }
            $data['lampiran'] = $lampiran;
            $data['button'] = count($lampiran);
            return view('businessdevelopment::outlet_manage.close_temporary.detail', $data);
        }else{
            return redirect()->back()->withErrors($result['messages'] ?? ['Not Found']);
        }
    }
    public function createClose(Request $request){
        $post = $request->except('_token');
         if(isset($post['date'])&& $post['date']!=null){
        $post['date'] = date('Y-m-d', strtotime($post['date']));
        }
        $query = MyHelper::post('partners/outlet/close/create', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                return back()->withSuccess(['Create Success']);
        } else{
                return back()->withErrors($query['messages']);
        }
    }
    public function updateClose(Request $request){
         $post = $request->except('_token');
         if(isset($post['date'])&& $post['date']!=null){
        $post['date'] = date('Y-m-d', strtotime($post['date']));
        }
        $query = MyHelper::post('partners/outlet/close/update', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                return back()->withSuccess(['Update Success']);
        } else{
                return back()->withErrors($query['messages']);
        }
    }
    public function updateCloseActive(Request $request){
         $post = $request->except('_token');
         if(isset($post['date'])&& $post['date']!=null){
        $post['date'] = date('Y-m-d', strtotime($post['date']));
        }
        $query = MyHelper::post('partners/outlet/close/updateActive', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                return back()->withSuccess(['Update Success']);
        } else{
                return back()->withErrors($query['messages']);
        }
    }
    public function rejectClose(Request $request){
         $post = $request->except('_token');
        $query = MyHelper::post('partners/outlet/close/reject', $post);
        return $query;
    }
    public function successClose(Request $request){
         $post = $request->except('_token');
         $query = MyHelper::post('partners/outlet/close/success', $post);
         return $query;
    }
    public function lampiranDeleteClose(Request $request)
    {
        $post = $request->except('_token'); 
	$query = MyHelper::post('partners/outlet/close/lampiran/delete', $post);
        return $query; 
       
    }
    public function lampiranCreateClose(Request $request)
    {
        $post = $request->except('_token'); 
        if (isset($post["import_file"])) {
            $post['attachment'] = MyHelper::encodeImage($post['import_file']);
        }
	$query = MyHelper::post('partners/outlet/close/lampiran/create', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                  return back()->withSuccess(['Create lampiran success']);
          } else{
                return back()->withErrors($query['messages']);
        }  
    }
    
    //active
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
     public function dataConfirmation($data,$city){
        $send= [];
        foreach($city as $c){
            if($c['id_city']==$data['lokasi']['id_city']){
                $city_name = $c['city_name'];
            }
        }
        if($data['gender']=='Man'){
            $send['pihak_dua'] = 'BAPAK '.strtoupper($data['name_partner']);
        }elseif($data['gender']=='Woman'){
            $send['pihak_dua']  = 'IBU '.strtoupper($data['name_partner']);
        }

        if($data['lokasi']['mall'] != null && $data['lokasi']['id_city'] != null){
            $send['lokasi'] = strtoupper($data['lokasi']['mall']).' - '.strtoupper($city_name);
        }

        if($data['lokasi']['address'] != null){
            $send['address'] = $data['lokasi']['address'];
        }

        if($data['lokasi']['location_large'] != null){
            $send['large'] = $data['lokasi']['location_large'];
        }
        if($data['lokasi']['start_date'] != null && $data['lokasi']['end_date'] != null){
            $send['waktu'] = $this->timeTotal(explode('-',  date('Y-m-d', strtotime($data['lokasi']['start_date']))),explode('-',  date('Y-m-d', strtotime($data['lokasi']['end_date']))));
        }

        if($data['lokasi']['partnership_fee'] != null){
            $send['partnership_fee'] = $this->rupiah($data['lokasi']['partnership_fee']);
            $send['dp'] = $this->rupiah($data['lokasi']['partnership_fee']*0.2);
            $send['dp2'] = $this->rupiah($data['lokasi']['partnership_fee']*0.3);
            $send['final'] = $this->rupiah($data['lokasi']['partnership_fee']*0.5);
        }
        return $send;
    }
    public function rupiah($nominal){
        $rupiah = number_format($nominal ,0, ',' , '.' );
        return $rupiah.',-';
    }
    public function createActive(Request $request){
        $post = $request->except('_token');
         if(isset($post['date'])&& $post['date']!=null){
        $post['date'] = date('Y-m-d', strtotime($post['date']));
        }
        $query = MyHelper::post('partners/outlet/close/createActive', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                return back()->withSuccess(['Create Success']);
        } else{
                return back()->withErrors($query['messages']);
        }
    }
     public function followUp(Request $request){
        $request->validate([
            "import_file" => "mimes:pdf|max:2000",
            "note" => "required",
        ]);
        if(isset($request["follow_up"]) && $request["follow_up"]=='Follow Up 1'){
            $request->validate([
                "mall" => "required",
                "location_large" => "required",
                "rental_price" => "required",
                "service_charge" => "required",
                "promotion_levy" => "required",
                "renovation_cost" => "required",
                "partnership_fee" => "required",
                "income" => "required",
                
            ]);
            $update_data_location = [
                "id_outlet_close_temporary_location" => $request["id_outlet_close_temporary_location"],
                "start_date" => date('Y-m-d', strtotime($request['start_date'])),
                "end_date" => date('Y-m-d', strtotime($request['end_date'])),
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
        }
        $post_follow_up = [
            "id_outlet_close_temporary" => $request["id_outlet_close_temporary"],
            "follow_up" => $request["follow_up"],
            "note" => $request["note"],  
        ];
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
        }elseif($request["follow_up"]=='Approved'){
            $status_steps = 'Finished Follow Up';
        }else{
            $status_steps = 'On Follow Up';
        }
        $update_status_step = [
            "id_outlet_close_temporary" => $request["id_outlet_close_temporary"],
            "status_steps" => $status_steps,
            "status" => 'Process'
        ];
        if(isset($request["follow_up"]) && $request["follow_up"]=='Survey Location'){
            $request->validate([
                "surye_note" => "required",
            ]);
            $form_survey = [
                "id_outlet_close_temporary"  => $request["id_outlet_close_temporary"],
                'note' => $request['surye_note'],
                'date' => date("Y-m-d"),
                'surveyor' => session('name'),
            ];
            if($request["survey_potential"]=='OK'){
                $form_survey['potential'] = 1;
            } else{
                $form_survey['potential'] = 0;
            }
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
        if(isset($request["follow_up"]) && $request["follow_up"]=='Confirmation Letter'){
            $request->validate([
                "no_letter" => "required",
                "location_letter" => "required",
            ]);
            $data_confir = [
                "id_outlet_close_temporary"  => $request["id_outlet_close_temporary"],
                "no_letter" => $request["no_letter"],
                "location" => $request["location_letter"],
            ];
            $update_data_location = [
                "id_outlet_close_temporary_location" => $request["id_outlet_close_temporary_location"],
               "notes" => $request["payment_note"],
            ];
        }
        if(isset($request["follow_up"]) && $request["follow_up"]=='Payment'){
            $update_status_step['status'] = 'Waiting';
        }
        
        $partner_step = MyHelper::post('partners/outlet/close/updateStatus', $update_status_step);
        
        if (isset($partner_step['status']) && $partner_step['status'] == 'success') {
            $follow_up = MyHelper::post('partners/outlet/close/create-follow-up', $post_follow_up);
            
           if(isset($follow_up['status']) && $follow_up['status'] == 'success'){
            
                if(isset($update_data_location) && !empty($update_data_location)){
                    $location_update =  MyHelper::post('partners/outlet/close/locations', $update_data_location);
                    if (isset($location_update['status']) && $location_update['status'] == 'success') {
                        
                        if(isset($data_confir) && !empty($data_confir)){
                            $confirmation =  MyHelper::post('partners/outlet/close/confirmation-letter', $data_confir);
                            if (isset($confirmation['status']) && $confirmation['status'] == 'success') {
                                return redirect()->back()->withSuccess(['Success create step '.$request["follow_up"].'']);    
                            }else{
                                return redirect()->back()->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
                            }
                        }
                        return redirect()->back()->withSuccess(['Success create step '.$request["follow_up"].'']);    
                    }else{
                        return redirect()->back()->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
                    }
                }
                  
                if(isset($update_partner['status']) && !empty($update_partner['status']) && $update_partner['status'] == 'Active'){
                    return redirect()->back()->withSuccess(['Success update candidate partner to partner']); 
                }
                if(isset($form_survey) && !empty($form_survey)){
                    $create_form_survey =  MyHelper::post('partners/outlet/close/form-survey', $form_survey);
                    if (isset($create_form_survey['status']) && $create_form_survey['status'] == 'success') {
                        return redirect()->back()->withSuccess(['Success create step '.$request["follow_up"].'']);    
                    }else{
                        return redirect()->back()->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
                    }
                }
                return redirect()->back()->withSuccess(['Success create step '.$request["follow_up"].'']);    
            }else{
                return redirect()->back()->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
            }
        }elseif(isset($partner_step['status']) && $partner_step['status'] == 'fail_date'){
            return redirect()->back()->withErrors($partner_step['messages'] ?? ['Failed create step '.$request["follow_up"].''])->withInput( );
        }else{
            return redirect()->back()->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
        }
    }
 


}
