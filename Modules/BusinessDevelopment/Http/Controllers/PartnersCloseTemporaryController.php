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

class PartnersCloseTemporaryController extends Controller
{
    public function index(Request $request,$id){
        $enk = $id;
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/close-temporary', ['id_partner' => $id]);
        $resulttemporary = MyHelper::post('partners/close-temporary/closeTemporary', ['id_partner' => $id]);
            $data = [
                'title'          => 'Partner',
                'url_title'      => url('businessdev/partners/detail').'/'.$id,
                'sub_title'      => 'Partner Closure Temporary',
                'url_sub_title'  =>url('businessdev/partners/close-temporary').'/'.$enk,
                'menu_active'    => 'partners',
                'submenu_active' => 'list-partners',
            ];
        if(isset($result['status']) && $result['status'] == 'success' && $resulttemporary['status'] == 'success' && isset($resulttemporary['status']) ){
            $data['partner'] = $result['result'];
            $close_temporary = array();
            foreach ($resulttemporary['result'] as $value) {
                $enkrip = MyHelper::createSlug($value['id_partners_close_temporary'], $value['created_at']);
                $value['detail'] = url('businessdev/partners/close-temporary/detail').'/'.$enkrip;
                $value['reject'] = url('businessdev/partners/close-temporary/reject').'/'.$enkrip;
                array_push($close_temporary, $value);
            }
            $data['close_temporary'] = $close_temporary;
            $status = false;
            $action = true;
            $title_temporary = null;
            $data['url'] = false;
            if($data['partner']['status']=='Inactive'){
                $status = true;
                $lampiran = MyHelper::post('partners/close-temporary/temporary', ['id_partner' => $id]);
                if(($lampiran['status']) && $lampiran['status'] == 'success' ){
                    if($lampiran['result']['status'] == 'Process' ||$lampiran['result']['status'] == 'Waiting'){
                        $action = false;
                    }
                }
                $title_temporary = 'Submission Active Partner';
                $data['url'] = true;
                
            }elseif($data['partner']['status']=='Active'){
                $status = true;
                $lampiran = MyHelper::post('partners/close-temporary/temporary', ['id_partner' => $id]);
                if(($lampiran['status']) && $lampiran['status'] == 'success' ){
                    if($lampiran['result']['status'] == 'Process' ||$lampiran['result']['status'] == 'Waiting'){
                        $action = false;
                    }
                }
                $title_temporary = 'Submission Closure Temporary';
                
            }
            $data['status'] = $status;
            $data['action'] = $action;
            $data['title_temporary'] = $title_temporary;
            return view('businessdevelopment::close_temporary.index', $data);
        }else{
            return redirect('businessdev/partners')->withErrors($result['messages'] ?? ['Failed get detail partner']);
        }
    }
    public function detail(Request $request,$id){
        $enk = $id;
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/close-temporary/detail', ['id_partners_close_temporary' => $id]);
        $resultlampiran = MyHelper::post('partners/close-temporary/lampiran/data', ['id_partners_close_temporary' => $id]);
           $data = [
                'title'          => 'Partner',
                'sub_title'      => 'Partner Closure Temporary',
                'sub_title2'     => 'Detail Partner Closure Temporary',
                'url_sub_title2' => url('businessdev/partners/close-temporary/detail').'/'.$enk,
                'menu_active'    => 'partners',
                'submenu_active' => 'detail-partner-closure-temporary',
            ];
        if(isset($result['status']) && $result['status'] == 'success' ){
            $data['result'] = $result['result'];
            $lampiran = array();
            foreach ($resultlampiran['result'] as $value) {
              array_push($lampiran, $value);
            }
            $data['lampiran'] = $lampiran;
            $data['button'] = count($lampiran);
            if(!empty($result['start_date'])){
                $data['title_partner'] = "DETAIL PARTNER ACTIVE";
                $data['url'] = true;
            }else{
                $data['title_partner'] = "DETAIL PARTNER CLOSURE TEMPORARY";
                $data['url'] = false;
            }
            $enkrip = MyHelper::createSlug($result['result']['partner']['id_partner'], $result['result']['partner']['created_at']);
            $data['url_title'] = url('businessdev/partners/detail/').'/'.$result['result']['id_partner'];
            $data['url_sub_title'] = url('businessdev/partners/close-temporary/').'/'.$enkrip;
            return view('businessdevelopment::close_temporary.detail', $data);
        }else{
            return redirect('businessdev/partners')->withErrors($result['messages'] ?? ['Not Found']);
        }
    }
    public function update(Request $request){
         $post = $request->except('_token');
         if(isset($post['close_date'])&& $post['close_date']!=null){
        $post['close_date'] = date('Y-m-d', strtotime($post['close_date']));
        }
        $query = MyHelper::post('partners/close-temporary/update', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                return back()->withSuccess(['Update Success']);
        } else{
                return back()->withErrors($query['messages']);
        }
    }
    public function updateActive(Request $request){
        $post = $request->except('_token');
        if(isset($post['close_date'])&& $post['close_date']!=null){
        $post['close_date'] = date('Y-m-d', strtotime($post['close_date']));
        }
        $query = MyHelper::post('partners/close-temporary/updateActive', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                return back()->withSuccess(['Update Success']);
        } else{
                return back()->withErrors($query['messages']);
        }
    }
    public function create(Request $request){
         $post = $request->except('_token');
         if(isset($post['close_date'])&& $post['close_date']!=null){
        $post['close_date'] = date('Y-m-d', strtotime($post['close_date']));
        }
        $query = MyHelper::post('partners/close-temporary/create', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                return back()->withSuccess(['Create Success']);
        } else{
                return back()->withErrors($query['messages']);
        }
    }
    public function createActive(Request $request){
         $post = $request->except('_token');
        if(isset($post['start_date'])&& $post['start_date']!=null){
        $post['start_date'] = date('Y-m-d', strtotime($post['start_date']));
        }
        $query = MyHelper::post('partners/close-temporary/createActive', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                return back()->withSuccess(['Create Success']);
        } else{
                return back()->withErrors($query['messages']);
        }
    }
    public function reject(Request $request){
         $post = $request->except('_token');
        $query = MyHelper::post('partners/close-temporary/reject', $post);
        return $query;
    }
    public function success(Request $request){
         $post = $request->except('_token');
         if(isset($post['status'])&&$post['status'] == "Close"){
            $query = MyHelper::post('partners/close-temporary/success', $post);
         }elseif(isset($post['status'])&&$post['status'] == "Start"){
             $query = MyHelper::post('partners/close-temporary/successActive', $post);
         }else{
          return response()->json(['status' => 'fail', 'messages' => $post['status']]);   
         }
        return $query;
    }
   
    public function lampiranDelete(Request $request)
    {
        $post = $request->except('_token'); 
	$query = MyHelper::post('partners/close-temporary/lampiran/delete', $post);
        return $query; 
       
    }
    public function lampiranCreate(Request $request)
    {
        $post = $request->except('_token'); 
        if (isset($post["import_file"])) {
            $post['attachment'] = MyHelper::encodeImage($post['import_file']);
        }
	$query = MyHelper::post('partners/close-temporary/lampiran/create', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
                  return back()->withSuccess(['Create lampiran success']);
          } else{
                return back()->withErrors($query['messages']);
        }
       
    }
}
