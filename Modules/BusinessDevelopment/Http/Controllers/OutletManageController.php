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
           $data = [
                'title'          => 'Partner',
                'sub_title'      => 'List Close Temporary Outlet',
                'menu_active'    => 'partners',
                'submenu_active' => 'close-temporary-outlet',
            ];
        if(isset($result['status']) && $result['status'] == 'success' ){
            $data['result'] = array();
            foreach ($result['result'] as $value) {
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
           $data = [
                'title'          => 'Partner',
                'sub_title'      => 'Close Temporary Outlet',
                'menu_active'    => 'partners',
                'submenu_active' => 'close-temporary-outlet',
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
}
