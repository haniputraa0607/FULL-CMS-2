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
        if(isset($result['status']) && $result['status'] == 'success'  ){
            $val = array();
            $data = [
                'title'          => 'Partner',
                'url_title'      => url('businessdev/partners/detail').'/'.$result['id_partner'],
                'sub_title'      => 'Manage Outlet',
                'menu_active'    => 'partners',
                'submenu_active' => 'manage-outlet',
            ];
            foreach ($result['result'] as $value) {
              $value['id_enkripsi'] = MyHelper::createSlug($value['id_outlet'], $value['created_at']);
               array_push($val,$value);
            };
            $data['outlet'] = $val;
            $resultoutlet = MyHelper::post('partners/outlet/ready', ['id_partner' => $id]);
            $resultactive = MyHelper::post('partners/outlet/active', ['id_partner' => $id]);
            $resultpartner = MyHelper::post('partners/outlet/partner', ['id_partner' => $id]);
            $data['listoutlet']=$resultoutlet['result']??[];
            $data['listpartner']=$resultpartner['result']??[];
            $data['listactive']=$resultactive['result']??[];
            $data['id_partner'] = $id;
            return view('businessdevelopment::outlet_manage.index', $data);
        }else{
            return redirect()->back()->withErrors($result['messages'] ?? ['Failed get detail partner']);
        }
    }
    public function detail(Request $request,$id){
        $id_detail = $id;
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/outlet/detail', ['id_outlet' => $id]);
        if(isset($result['status']) && $result['status'] == 'success'  ){
            $val = array();
            $id_outlet = MyHelper::createSlug($result['id_partner'], date('Y-m-d H:i:s'));
            $data = [
                'title'          => 'Partner',
                'url_title'      => url('businessdev/partners/detail').'/'.$result['id_partner'],
                'sub_title'      => 'Manage Outlet',
                'url_sub_title'  => url('businessdev/partners/outlet/').'/'.$id_outlet,
                'detail_sub_title' => 'Detail Manage Outlet',
                'menu_active'    => 'partners',
                'submenu_active' => 'close-temporary-outlet',
            ];
            foreach ($result['result'] as $value) {
              $value['id_enkripsi'] = MyHelper::createSlug($value['id_outlet_manage'], $value['created_at']);
               array_push($val,$value);
            };
            $data['result'] = $val;
            return view('businessdevelopment::outlet_manage.detail', $data);
        }else{
            return redirect()->back()->withErrors($result['messages'] ?? ['Failed get detail partner']);
        }
    }
    //cutoff
    public function detailCutoff(Request $request,$id){
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/outlet/cutoff/detail', ['id_outlet_cut_off' => $id]);
        $resultlampiran = MyHelper::post('partners/outlet/cutoff/lampiran/data', ['id_outlet_cut_off' => $id]);
        if(isset($result['status']) && $result['status'] == 'success' ){
            $id_outlet = MyHelper::createSlug($result['result']['id_partner'], $result['result']['created_at']);
            $data = [
                'title'             => 'Partner',
                'url_title'      => url('businessdev/partners/detail').'/'.$result['result']['id_partner'],
                'sub_title'         => 'Outlet Manage',
                'url_sub_title'  => url('businessdev/partners/outlet/').'/'.$id_outlet,
                'detail_sub_title'  => 'Cut Off Outlet',
                'menu_active'       => 'partners',
                'submenu_active'    => 'cut-off-outlet',
            ];
            $data['result'] = $result['result'];
            $lampiran = array();
            if(isset($resultlampiran['status'])&&$resultlampiran['status']=='success'){
                foreach ($resultlampiran['result'] as $value) {
                  array_push($lampiran, $value);
                }
            }
            $data['lampiran'] = $lampiran;
            $data['button'] = count($lampiran);
            return view('businessdevelopment::outlet_manage.detail_cutoff', $data);
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
        if(isset($result['status']) && $result['status'] == 'success' ){
             $id_outlet = MyHelper::createSlug($result['result']['id_partner'], $result['result']['created_at']);
            $data = [
                'title'             => 'Partner',
                'url_title'      => url('businessdev/partners/detail').'/'.$result['result']['id_partner'],
                'sub_title'         => 'Outlet Manage',
                'url_sub_title'  => url('businessdev/partners/outlet/').'/'.$id_outlet,
                'detail_sub_title'  => 'Change Ownership',
                'menu_active'       => 'partners',
                'submenu_active'    => 'Change Ownership',
            ];
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
           if(isset($result['status']) && $result['status'] == 'success' ){
            $id_partner = MyHelper::createSlug($result['result']['outlet']['id_partner'], $result['result']['outlet']['created_at']);
            $data = [
                'title'          => 'Partner',
                'url_title'      => url('businessdev/partners/detail').'/'.$result['result']['outlet']['id_partner'],
                'sub_title'      => 'Manage Outlet',
                'url_sub_title'  => url('businessdev/partners/outlet/').'/'.$id_partner,
                'list_sub_title' => 'List Close Temporary Outlet',
                'menu_active'    => 'partners',
                'submenu_active' => 'manage-outlet',
            ];
            $data['outlet'] = $result['result']['outlet'];
            $data['result'] = array();
            foreach ($result['result']['list'] as $value) {
                $enkripsi = MyHelper::createSlug($value['id_outlet_close_temporary'], $value['created_at']);
                $value['url_detail'] = env('APP_URL').'businessdev/partners/outlet/close/detail/'.$enkripsi;
                array_push($data['result'],$value);
            }
            return view('businessdevelopment::outlet_manage.close_temporary.index', $data);
        }else{
            return redirect()->back()->withErrors($result['messages'] ?? ['Not Found']);
        }
    }
    public function detailClose(Request $request,$id){
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/outlet/close/detail', ['id_outlet_close_temporary' => $id]);
        $resultlampiran = MyHelper::post('partners/outlet/close/lampiran/data', ['id_outlet_close_temporary' => $id]);
        if(isset($result['status']) && $result['status'] == 'success' ){
            $id_outlet = MyHelper::createSlug($result['result']['id_partner'], $result['result']['created_at']);
            $id_outlet_close_temporary = MyHelper::createSlug($result['result']['id_outlet'], $result['result']['created_at']);
             $data = [
                'title'          => 'Partner',
                'url_title'      => url('businessdev/partners/detail').'/'.$result['result']['id_partner'],
                'sub_title'      => 'Manage Outlet',
                'url_sub_title'  => url('businessdev/partners/outlet/').'/'.$id_outlet,
                'list_sub_title' => 'List Close Temporary Outlet',
                'url_list_sub_title'  => url('businessdev/partners/outlet/close/list').'/'.$id_outlet_close_temporary,
                'detail_sub_title' => 'Detail Close Temporary Outlet',
                'menu_active'    => 'partners',
                'submenu_active' => 'close-temporary-outlet',
            ];
            $data['result'] = $result['result'];
           
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
        if($data['partner']['partner_locations']){
            foreach($data['partner']['partner_locations'] as $key => $loc){
                foreach($city as $c){
                    if($c['id_city']==$loc['id_city']){
                        $city_name = $c['city_name'];
                    }
                }
                if($loc['mall'] != null && $loc['id_city'] != null){
                    $send['location'][$key]['lokasi'] = strtoupper($loc['mall']).' - '.strtoupper($city_name);
                }
                if($loc['address'] != null){
                    $send['location'][$key]['address'] = $loc['address'];
                }
        
                if($loc['location_large'] != null){
                    $send['location'][$key]['large'] = $loc['location_large'];
                }
                if($loc['partnership_fee'] != null){
                    $send['location'][$key]['partnership_fee'] = $this->rupiah($loc['total_payment']);
                    $send['location'][$key]['dp'] = $this->rupiah($loc['total_payment']*0.2);
                    $send['location'][$key]['dp2'] = $this->rupiah($loc['total_payment']*0.3);
                    $send['location'][$key]['final'] =$this->rupiah($loc['total_payment']*0.5);
                }
                $send['location'][$key]['id_location'] = $loc['id_location'];
            }
        }
        if($data['partner']['gender']=='Man'){
            $send['pihak_dua'] = 'BAPAK '.strtoupper($data['partner']['contact_person']);
        }elseif($data['partner']['gender']=='Woman'){
            $send['pihak_dua']  = 'IBU '.strtoupper($data['partner']['contact_person']);
        }

        if($data['partner']['start_date'] != null && $data['partner']['end_date'] != null){
            $send['waktu'] = $this->timeTotal(explode('-', $data['partner']['start_date']),explode('-', $data['partner']['end_date']));
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
    public function approved(Request $request) {
        $update_status_step = [
            "id_outlet_close_temporary" => $request["id_outlet_close_temporary"],
            "status_steps" => "Finished Follow Up",
            "status" => 'Process'
        ];
        $partner_step = MyHelper::post('partners/outlet/close/updateStatus', $update_status_step);
       return $partner_step; 
    }
    
    
    //change location
    public function detailChangeLoation(Request $request,$id){
         $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/outlet/change_location/detail', ['id_outlet_manage' => $id]);
        if(isset($result['status']) && $result['status'] == 'success' ){
            $id_outlet = MyHelper::createSlug($result['result']['id_partner'], $result['result']['created_at']);
            $id_outlet_manage = MyHelper::createSlug($result['result']['id_outlet'], $result['result']['created_at']);
             $data = [
                'title'          => 'Partner',
                'url_title'      => url('businessdev/partners/detail').'/'.$result['result']['id_partner'],
                'sub_title'      => 'Manage Outlet',
                'url_sub_title'  => url('businessdev/partners/outlet/').'/'.$id_outlet,
                'list_sub_title' => 'Detail Manage Outlet',
                'url_list_sub_title'  => url('businessdev/partners/outlet/detail').'/'.$id_outlet_manage,
                'detail_sub_title' => 'Detail Close Temporary Outlet',
                'menu_active'    => 'partners',
                'submenu_active' => 'close-temporary-outlet',
            ];
            $data['result'] = $result['result'];
            $partner = MyHelper::post('partners/edit', ['id_partner' => $result['result']['id_partner']]);  
        $data['id_outlet_change_location'] = $id;
        $data['partner'] = $partner['result']['partner'];
        $data['brands'] = MyHelper::get('partners/locations/brands')['result']??[];
        $data['list_locations'] = MyHelper::get('partners/list-location')['result']['locations']??[];
        $data['list_starters'] = MyHelper::get('partners/list-location')['result']['starters']??[];
            $id_outlet_starter_bundling = $data['partner']['partner_locations'][0]['id_outlet_starter_bundling']??null;
        $data['starter_products'] = MyHelper::post('partners/detail-bundling',["id_outlet_starter_bundling" => $id_outlet_starter_bundling])['result']??[];
        $data['products'] = MyHelper::post('product/be/icount/list', [])['result'] ?? [];
        $data['conditions'] = "";
        $data['terms'] = MyHelper::get('partners/term')['result']??[];
        $data['cities'] = MyHelper::get('city/list')['result']??[];
        $data['brands'] = MyHelper::get('partners/locations/brands')['result']??[];
        $data['confirmation'] = $this->dataConfirmation($partner['result'],$data['cities']);
        
            return view('businessdevelopment::outlet_manage.change_location.detail', $data);
        }else{
            return redirect()->back()->withErrors($result['messages'] ?? ['Not Found']);
        }
    }
    
    public function createChangeLocation(Request $request){
        $post = $request->except('_token');
         if(isset($post['date'])&& $post['date']!=null){
        $post['date'] = date('Y-m-d', strtotime($post['date']));
        }
        $query = MyHelper::post('partners/outlet/change_location/create', $post);
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
        $post_follow_up = [
            "id_outlet_change_location" => $request["id_outlet_change_location"],
            "id_partner" => $request["id_partner"],
            "id_location" => $request["to_id_location"],
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
        }elseif($request["follow_up"]=='Select Location'){
            $status_steps = 'Select Location';
        }
         $update_partner = [
            "id_outlet_change_location" => $request["id_outlet_change_location"],
            "status_steps" => $status_steps,
        ];
        if(isset($request["follow_up"]) && $request["follow_up"]=='Select Location'){
             $update_partner['id_location'] = $request["id_location"];
            $update_data_location = [
                "id_location" => $request["to_id_location"],
                "id_outlet_starter_bundling" => $request["id_outlet_starter_bundling"],
                "id_brand" => $request["id_brand"],
                "renovation_cost" => preg_replace("/[^0-9]/", "", $request["renovation_cost"]),
                "partnership_fee" => preg_replace("/[^0-9]/", "", $request["partnership_fee"]),
                "income" => preg_replace("/[^0-9]/", "", $request["income"]),
                "id_partner" => $request['id_partner'],
                "total_box" => $request['total_box'],
                "handover_date" => date('Y-m-d', strtotime($request['handover_date'])),
            ];
            $form_survey = [
                "id_partner"  => $request["id_partner"],
                "id_location"  => $request["id_location"],
            ];
            if ($request['start_date']!=null){
                $update_data_location['start_date'] = date('Y-m-d', strtotime($request['start_date']));
            } 
            if ($request['end_date']!=null){
                $update_data_location['end_date'] = date('Y-m-d', strtotime($request['end_date']));
            }
        }
        
        if (isset($request["termpayment"]) && $request["follow_up"]=='Select Location') {
            $update_data_location['id_term_of_payment'] = $request['termpayment'];
        }
        if (isset($request['company_type']) && $request['follow_up']=='Select Location'){
            $update_data_location['company_type'] = $request['company_type'];
        } 

        if (isset($request['ownership_status']) && $request['follow_up']=='Select Location'){
            $update_data_location['ownership_status'] = $request['ownership_status'];
        } 

        if (isset($request['cooperation_scheme']) && $request['follow_up']=='Select Location'){
            $update_data_location['cooperation_scheme'] = $request['cooperation_scheme'];
        } 

        if (isset($request["sharing_percent"]) && $request["follow_up"]=='Select Location') {
            $update_data_location['sharing_percent'] = 1;
        }elseif($request["follow_up"]=='Select Location'){
            $update_data_location['sharing_percent'] = 0;
        }

        if (isset($request["sharing_value"]) && $request["follow_up"]=='Select Location') {
            $update_data_location['sharing_value'] = $request['sharing_value'];
        }

        if(isset($request["follow_up"]) && $request["follow_up"]=='Calculation'){
            $request->validate([
                "total_payment" => "required",
            ]);
            $update_data_location = [
                "id_location" => $request["to_id_location"],
                "total_payment" => preg_replace("/[^0-9]/", "", $request["total_payment"]),
            ];
        }

        if(isset($request["follow_up"]) && $request["follow_up"]=='Confirmation Letter'){
            $request->validate([
                "no_letter" => "required",
                "location_letter" => "required",
            ]);
            $data_confir = [
                "id_outlet_change_location"  => $request["id_outlet_change_location"],
                "id_partner"  => $request["id_partner"],
                "id_location" => $request["to_id_location"],
                "no_letter" => $request["no_letter"],
                "location" => $request["location_letter"],
            ];
            $update_data_location = [
                "id_location" => $request["to_id_location"],
                "notes" => $request["payment_note"],
            ];
        }

        if(isset($request["follow_up"]) && $request["follow_up"]=='Payment'){
            $update_data_location = [
                "id_location" => $request["to_id_location"],
                "trans_date" => date('Y-m-d'),
                "due_date" => date('Y-m-d', strtotime($request['due_date'])),
                "no_spk" => $request["no_spk"],
                "date_spk" => date('Y-m-d', strtotime($request['date_spk'])),
            ];
            $post_follow_up['id_location'] = $request["to_id_location"];
            $update_partner['status'] = 'Waiting';
        }

        $post['post_follow_up'] = $post_follow_up;

        if(isset($form_survey) && !empty($form_survey)){
            $post['form_survey'] = $form_survey;
        }    
        
      
         $partner_step = MyHelper::post('partners/outlet/change_location/updateStatus', $update_partner);
          if (isset($partner_step['status']) && $partner_step['status'] == 'success') {
            if (isset($update_data_location) && !empty($update_data_location)) {
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
                $follow_up = MyHelper::post('partners/outlet/change_location/create-follow-up', $post);
                if(isset($follow_up['status']) && $follow_up['status'] == 'success'){
                    if(isset($data_confir) && !empty($data_confir)){
                         $confirmation =  MyHelper::post('partners/outlet/change_location/confirmation-letter', $data_confir);
                        if (isset($confirmation['status']) && $confirmation['status'] == 'success') {
                            return redirect()->back()->withSuccess(['Success create step '.$request["follow_up"].'']);    
                        }else{
                            return redirect()->back()->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
                        }
                    }
                    if(isset($form_survey) && !empty($form_survey)){
                        $create_form_survey =  MyHelper::post('partners/outlet/change_location/form-survey', $form_survey);
                        if (isset($create_form_survey['status']) && $create_form_survey['status'] == 'success') {
                            return redirect()->back()->withSuccess(['Success create step '.$request["follow_up"].'']);    
                        }else{
                            return redirect()->back()->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
                        }
                    }
                    return redirect()->back()->withSuccess(['Success create step '.$request["follow_up"].'']);    
                }else{
                    return back()->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
                }
            }else{
                return back()->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
            }
        }else{
            $follow_up = MyHelper::post('partners/outlet/change_location/create-follow-up', $post);
            if(isset($follow_up['status']) && $follow_up['status'] == 'success'){
                return back()->withSuccess(['Success create step '.$request["follow_up"].'']);    
            }else{
                return back()->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
                }
            }
          }else{
              return back()->withErrors($result['messages'] ?? ['Failed create step '.$request["follow_up"].'']);
          }
        return back()->withSuccess(['Success create step '.$request["follow_up"].'']);    

    }
  
}