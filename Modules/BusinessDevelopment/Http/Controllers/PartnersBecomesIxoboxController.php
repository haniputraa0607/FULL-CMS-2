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

class PartnersBecomesIxoboxController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, $id)
    {
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/becomes-ixobox', ['id_partner' => $id]);
        $resultbecomes = MyHelper::post('partners/becomes-ixobox/becomesIxobox', ['id_partner' => $id]);
            $data = [
                'title'          => 'Partner',
                'sub_title'      => 'Partner Becomes Ixobox',
                'menu_active'    => 'partners',
                'submenu_active' => 'list-partners',
            ];
        if(isset($result['status']) && $result['status'] == 'success' && $resultbecomes['status'] == 'success' && isset($resultbecomes['status']) ){
            $data['partner'] = $result['result'];
            $becomes_ixobox = array();
            foreach ($resultbecomes['result'] as $value) {
                $enkrip = MyHelper::createSlug($value['id_partners_becomes_ixobox'], $value['created_at']);
                $value['detail'] = url('businessdev/partners/becomes-ixobox/detail').'/'.$enkrip;
                $value['reject'] = url('businessdev/partners/becomes-ixobox/reject').'/'.$enkrip;
                array_push($becomes_ixobox, $value);
            }
            $data['becomes_ixobox'] = $becomes_ixobox;
            $status = false;
            $action = true;
            $title_becomes = null;
            $data['url'] = false;
            if($data['partner']['status']=='Inactive'){
                $status = true;
                $lampiran = MyHelper::post('partners/becomes-ixobox/becomes', ['id_partner' => $id]);
                if(($lampiran['status']) && $lampiran['status'] == 'success' ){
                    if($lampiran['result']['status'] == 'Process' ||$lampiran['result']['status'] == 'Waiting'){
                        $action = false;
                    }
                }
                $title_becomes = 'Submission Active Partner';
                $data['url'] = true;
                
            }elseif($data['partner']['status']=='Active'){
                $status = true;
                $lampiran = MyHelper::post('partners/becomes-ixobox/becomes', ['id_partner' => $id]);
                if(($lampiran['status']) && $lampiran['status'] == 'success' ){
                    if($lampiran['result']['status'] == 'Process' ||$lampiran['result']['status'] == 'Waiting'){
                        $action = false;
                    }
                }
                $title_becomes = 'Submission Becomes Ixobox';
                
            }
            $data['status'] = $status;
            $data['action'] = $action;
            $data['title_becomes'] = $title_becomes;
            return view('businessdevelopment::becomes_ixobox.index', $data);
        }else{
            return redirect('businessdev/partners')->withErrors($result['messages'] ?? ['Failed get detail partner']);
        }
    }

    public function create(Request $request){
        $post = $request->except('_token');
        if(isset($post['close_date'])&& $post['close_date']!=null){
            $post['close_date'] = date('Y-m-d', strtotime($post['close_date']));
        }
        $query = MyHelper::post('partners/becomes-ixobox/create', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
            return back()->withSuccess(['Create Success']);
        }else{
            return back()->withErrors($query['messages']);
        }
    }

    public function createActive(Request $request){
        $post = $request->except('_token');
        if(isset($post['start_date'])&& $post['start_date']!=null){
            $post['start_date'] = date('Y-m-d', strtotime($post['start_date']));
        }
        $query = MyHelper::post('partners/becomes-ixobox/createActive', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
            return back()->withSuccess(['Create Success']);
        } else{
            return back()->withErrors($query['messages']);
        }
    }

    public function reject(Request $request){
        $post = $request->except('_token');
       $query = MyHelper::post('partners/becomes-ixobox/reject', $post);
       return $query;
    }

    public function detail(Request $request,$id){
        $enk = $id;
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/becomes-ixobox/detail', ['id_partners_becomes_ixobox' => $id]);
        $resultlampiran = MyHelper::post('partners/becomes-ixobox/lampiran/data', ['id_partners_becomes_ixobox' => $id]);
        $data = [
             'title'          => 'Partner',
             'sub_title'      => 'Partner Becomes Ixobox',
             'sub_title2'     => 'Detail Partner Becomes Ixobox',
             'url_sub_title2' => url('businessdev/partners/becomes-ixobox/detail').'/'.$enk,
             'menu_active'    => 'partners',
             'submenu_active' => 'list-partners',
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
                $data['title_partner'] = "DETAIL PARTNER BECOMES IXOBOX";
                $data['url'] = false;
            }
            $enkrip = MyHelper::createSlug($result['result']['partner']['id_partner'], $result['result']['partner']['created_at']);
            $data['url_sub_title'] = url('businessdev/partners/becomes-ixobox/').'/'.$enkrip;
            return view('businessdevelopment::becomes_ixobox.detail', $data);
        }else{
            return redirect('businessdev/partners')->withErrors($result['messages'] ?? ['Not Found']);
        }
    }

    public function update(Request $request){
        $post = $request->except('_token');
        if(isset($post['close_date'])&& $post['close_date']!=null){
            $post['close_date'] = date('Y-m-d', strtotime($post['close_date']));
        }
        $query = MyHelper::post('partners/becomes-ixobox/update', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
            return back()->withSuccess(['Update Success']);
        }else{
            return back()->withErrors($query['messages']);
        }
    }

    public function updateActive(Request $request){
        $post = $request->except('_token');
        if(isset($post['close_date'])&& $post['close_date']!=null){
            $post['close_date'] = date('Y-m-d', strtotime($post['close_date']));
        }
        $query = MyHelper::post('partners/becomes-ixobox/updateActive', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
            return back()->withSuccess(['Update Success']);
        }else{
            return back()->withErrors($query['messages']);
        }
    }

    public function lampiranDelete(Request $request)
    {
        $post = $request->except('_token'); 
        $query = MyHelper::post('partners/becomes-ixobox/lampiran/delete', $post);
        return $query; 
    }

    public function lampiranCreate(Request $request)
    {
        $post = $request->except('_token'); 
        if (isset($post["import_file"])) {
            $post['attachment'] = MyHelper::encodeImage($post['import_file']);
        }
        $query = MyHelper::post('partners/becomes-ixobox/lampiran/create', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
            return back()->withSuccess(['Create lampiran success']);
        }else{
            return back()->withErrors($query['messages']);
        }
    }

    public function success(Request $request)
    {
        $post = $request->except('_token');
        if(isset($post['status'])&&$post['status'] == "Close"){
            $query = MyHelper::post('partners/becomes-ixobox/success', $post);
        }elseif(isset($post['status'])&&$post['status'] == "Start"){
            $query = MyHelper::post('partners/becomes-ixobox/successActive', $post);
        }else{
            return response()->json(['status' => 'fail', 'messages' => $post['status']]);   
        }
        return $query;
    }
}
