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

class PartnersClosePermanentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request,$id){
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/close-permanent', ['id_partner' => $id]);
        $resultpermanent = MyHelper::post('partners/close-permanent/closePermanent', ['id_partner' => $id]);
            $data = [
                'title'          => 'Partner',
                'sub_title'      => 'Partner Closure Permanent',
                'menu_active'    => 'partners',
                'submenu_active' => 'list-partners',
            ];
        if(isset($result['status']) && $result['status'] == 'success' && $resultpermanent['status'] == 'success' && isset($resultpermanent['status']) ){
            $data['partner'] = $result['result'];
            $close_permanent = array();
            foreach ($resultpermanent['result'] as $value) {
                $enkrip = MyHelper::createSlug($value['id_partners_close_permanent'], $value['created_at']);
                $value['detail'] = url('businessdev/partners/close-permanent/detail').'/'.$enkrip;
                $value['reject'] = url('businessdev/partners/close-permanent/reject').'/'.$enkrip;
                array_push($close_permanent, $value);
            }
            $data['close_permanent'] = $close_permanent;
            $status = false;
            $action = true;
            $title_permanent = null;
            $data['url'] = false;
            if($data['partner']['status']=='Inactive'){
                $status = true;
            $lampiran = MyHelper::post('partners/close-permanent/permanent', ['id_partner' => $id]);
                if(($lampiran['status']) && $lampiran['status'] == 'success' ){
                    if($lampiran['result']['status'] == 'Process' ||$lampiran['result']['status'] == 'Waiting'){
                        $action = false;
                    }
                }
                $title_permanent = 'Submission Active Partner';
                $data['url'] = true;
                
            }elseif($data['partner']['status']=='Active'){
                $status = true;
                $lampiran = MyHelper::post('partners/close-permanent/permanent', ['id_partner' => $id]);
                if(($lampiran['status']) && $lampiran['status'] == 'success' ){
                    if($lampiran['result']['status'] == 'Process' ||$lampiran['result']['status'] == 'Waiting'){
                        $action = false;
                    }
                }
                $title_permanent = 'Submission Closure Permanent';
                
            }
            $data['status'] = $status;
            $data['action'] = $action;
            $data['title_permanent'] = $title_permanent;
            return view('businessdevelopment::close_permanent.index', $data);
        }else{
            return redirect('businessdev/partners')->withErrors($result['messages'] ?? ['Failed get detail partner']);
        }
    }

    public function create(Request $request){
        $post = $request->except('_token');
        if(isset($post['close_date'])&& $post['close_date']!=null){
            $post['close_date'] = date('Y-m-d', strtotime($post['close_date']));
        }
        $query = MyHelper::post('partners/close-permanent/create', $post);
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
        $query = MyHelper::post('partners/close-permanent/createActive', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
            return back()->withSuccess(['Create Success']);
        } else{
            return back()->withErrors($query['messages']);
        }
    }

    public function reject(Request $request){
        $post = $request->except('_token');
       $query = MyHelper::post('partners/close-permanent/reject', $post);
       return $query;
    }

    public function detail(Request $request,$id){
        $enk = $id;
        $id = MyHelper::explodeSlug($id)[0]??'';
        $result = MyHelper::post('partners/close-permanent/detail', ['id_partners_close_permanent' => $id]);
        $resultlampiran = MyHelper::post('partners/close-permanent/lampiran/data', ['id_partners_close_permanent' => $id]);
        $data = [
             'title'          => 'Partner',
             'sub_title'      => 'Partner Closure Permanent',
             'sub_title2'     => 'Detail Partner Closure Permanent',
             'url_sub_title2' => url('businessdev/partners/close-permanent/detail').'/'.$enk,
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
                $data['title_partner'] = "DETAIL PARTNER CLOSURE PERMANENT";
                $data['url'] = false;
            }
            $enkrip = MyHelper::createSlug($result['result']['partner']['id_partner'], $result['result']['partner']['created_at']);
            $data['url_sub_title'] = url('businessdev/partners/close-permanent/').'/'.$enkrip;
            return view('businessdevelopment::close_permanent.detail', $data);
        }else{
            return redirect('businessdev/partners')->withErrors($result['messages'] ?? ['Not Found']);
        }
    }

    public function update(Request $request){
        $post = $request->except('_token');
        if(isset($post['close_date'])&& $post['close_date']!=null){
            $post['close_date'] = date('Y-m-d', strtotime($post['close_date']));
        }
        $query = MyHelper::post('partners/close-permanent/update', $post);
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
        $query = MyHelper::post('partners/close-permanent/updateActive', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
            return back()->withSuccess(['Update Success']);
        }else{
            return back()->withErrors($query['messages']);
        }
    }

    public function lampiranDelete(Request $request)
    {
        $post = $request->except('_token'); 
        $query = MyHelper::post('partners/close-permanent/lampiran/delete', $post);
        return $query; 
       
    }

    public function lampiranCreate(Request $request)
    {
        $post = $request->except('_token'); 
        if (isset($post["import_file"])) {
            $post['attachment'] = MyHelper::encodeImage($post['import_file']);
        }
        $query = MyHelper::post('partners/close-permanent/lampiran/create', $post);
        if(isset($query['status']) && $query['status'] == 'success'){
            return back()->withSuccess(['Create lampiran success']);
        }else{
            return back()->withErrors($query['messages']);
        }
    }

    public function success(Request $request){
        $post = $request->except('_token');
        if(isset($post['status'])&&$post['status'] == "Close"){
            $query = MyHelper::post('partners/close-permanent/success', $post);
        }elseif(isset($post['status'])&&$post['status'] == "Start"){
            $query = MyHelper::post('partners/close-permanent/successActive', $post);
        }else{
            return response()->json(['status' => 'fail', 'messages' => $post['status']]);   
        }
        return $query;
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
    public function edit($id)
    {
        return view('businessdevelopment::edit');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
