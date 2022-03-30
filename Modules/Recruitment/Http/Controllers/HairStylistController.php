<?php

namespace Modules\Recruitment\Http\Controllers;

use App\Exports\MultisheetExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Excel;

class HairStylistController extends Controller
{
    public function candidatelist(Request $request){
        $post = $request->all();

        $data = [
            'title'          => 'Recruitment',
            'sub_title'      => 'Candidate',
            'menu_active'    => 'hair-stylist',
            'submenu_active' => 'hair-stylist-candidate',
            'title_date_start' => 'Register Start',
            'title_date_end' => 'Register End'
        ];

        if(Session::has('filter-hs-list-candidate') && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('filter-hs-list-candidate');
            $post['page'] = $page;
        }else{
            Session::forget('filter-hs-list-candidate');
        }

        $getList = MyHelper::post('recruitment/hairstylist/be/candidate/list',$post);

        if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $getList['result']['data'];
            $data['dataTotal']     = $getList['result']['total'];
            $data['dataPerPage']   = $getList['result']['from'];
            $data['dataUpTo']      = $getList['result']['from'] + count($getList['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($getList['result']['data'], $getList['result']['total'], $getList['result']['per_page'], $getList['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if($post){
            Session::put('filter-hs-list-candidate',$post);
        }

        return view('recruitment::hair_stylist.candidate_list', $data);
    }

    public function candidateDetail(Request $request, $id){
        $post = $request->all();
        $detail = MyHelper::post('recruitment/hairstylist/be/detail',['id_user_hair_stylist' => $id]);

        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data = [
                'title'          => 'Recruitment',
                'sub_title'      => 'Candidate',
                'menu_active'    => 'hair-stylist',
                'submenu_active' => 'hair-stylist-candidate',
                'url_back'      => 'recruitment/hair-stylist/candidate',
                'page_type'     => 'candidate'
            ];

            $data['detail'] = $detail['result'];
            $data['outlets'] = MyHelper::get('outlet/be/list/simple')['result']??[];
            $data['groups'] = MyHelper::get('recruitment/hairstylist/be/group')['result']['data']??[];
            $data['category_theories'] = MyHelper::get('theory/with-category')['result']??[];
            $data['step_approve'] = $post['step_approve']??0;
            $data['hairstylist_category'] = MyHelper::get('hairstylist/be/category')['result']??[];
            return view('recruitment::hair_stylist.detail', $data);
        }else{
            return redirect('recruitment/hair-stylist/candidate')->withErrors($store['messages']??['Failed get detail candidate']);
        }
    }

    public function candidateUpdate(Request $request, $id){
        $post = $request->except('_token');
        if(empty($post['action_type'])){
            return redirect('recruitment/hair-stylist/candidate/detail/'.$id)->withErrors(['Action type can not be empty']);
        }
        $post['id_user_hair_stylist'] = $id;
        $post['update_type'] = $post['action_type'];

        if(!empty($post['user_hair_stylist_photo'])){
            $post['user_hair_stylist_photo'] = MyHelper::encodeImage($post['user_hair_stylist_photo']);
        }else{
            unset($post['user_hair_stylist_photo']);
        }

        if(!empty($post['data_document'])){
            if(!empty($post['data_document']['attachment'])){
                $post['data_document']['ext'] = pathinfo($post['data_document']['attachment']->getClientOriginalName(), PATHINFO_EXTENSION);
                $post['data_document']['attachment'] = MyHelper::encodeImage($post['data_document']['attachment']);
            }
        }

        $update = MyHelper::post('recruitment/hairstylist/be/update',$post);
        if(isset($update['status']) && $update['status'] == 'success' && $post['update_type'] == 'approve'){
            return redirect('recruitment/hair-stylist/detail/'.$id)->withSuccess(['Success update data to approved']);
        }elseif(isset($update['status']) && $update['status'] == 'success'){
            return redirect('recruitment/hair-stylist/candidate/detail/'.$id.($post['action_type'] == "reject" ? '#hs-info': '#candidate-status'))->withSuccess(['Success update data to '.$post['update_type']??""]);
        }else{
            return redirect('recruitment/hair-stylist/candidate/detail/'.$id)->withErrors($update['messages']??['Failed update data to approved']);
        }
    }

    public function hslist(Request $request){
        $post = $request->all();

        $data = [
            'title'          => 'Recruitment',
            'sub_title'      => 'Hair Stylist',
            'menu_active'    => 'hair-stylist',
            'submenu_active' => 'hair-stylist-list',
            'title_date_start' => 'Join Date Start',
            'title_date_end' => 'Join Date End',
            'list_type' => 'hs'
        ];

        if(Session::has('filter-hs-list') && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('filter-hs-list');
            $post['page'] = $page;
        }else{
            Session::forget('filter-hs-list');
        }
        $getList = MyHelper::post('recruitment/hairstylist/be/list',$post);
        $data['outlets'] =  MyHelper::get('outlet/be/list/outlet')['result']??[''];
        if (isset($getList['status']) && $getList['status'] == "success") {
            $data['data']          = $getList['result']['data'];
            $data['dataTotal']     = $getList['result']['total'];
            $data['dataPerPage']   = $getList['result']['from'];
            $data['dataUpTo']      = $getList['result']['from'] + count($getList['result']['data'])-1;
            $data['dataPaginator'] = new LengthAwarePaginator($getList['result']['data'], $getList['result']['total'], $getList['result']['per_page'], $getList['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['data']          = [];
            $data['dataTotal']     = 0;
            $data['dataPerPage']   = 0;
            $data['dataUpTo']      = 0;
            $data['dataPaginator'] = false;
        }

        if($post){
            Session::put('filter-hs-list',$post);
        }

        return view('recruitment::hair_stylist.hs_list', $data);
    }

    public function hsDetail($id){
        $detail = MyHelper::post('recruitment/hairstylist/be/detail',['id_user_hair_stylist' => $id]);

        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data = [
                'title'          => 'Recruitment',
                'sub_title'      => 'Hair Stylist',
                'menu_active'    => 'hair-stylist',
                'submenu_active'  => 'hair-stylist-list',
                'url_back'      => 'recruitment/hair-stylist'
            ];

            $data['detail'] = $detail['result'];
            $data['outlets'] = MyHelper::get('outlet/be/list/simple')['result'] ?? [];
            $data['groups'] = MyHelper::get('recruitment/hairstylist/be/group/')['result']['data']??[];
            $order = MyHelper::post('recruitment/hairstylist/be/info-order', ['id_user_hair_stylist' => $id]);
            $data['order_outlet'] = $order['result']['order_outlet']??[];
            $data['order_home'] = $order['result']['order_home']??[];
            $data['schedules'] = [];
            if (!empty($data['detail']['id_outlet']) && $data['detail']['user_hair_stylist_status'] == 'Active') {
            	$data['schedules'] = MyHelper::get('recruitment/hairstylist/be/schedule/outlet?id_outlet='.$data['detail']['id_outlet'])['result'] ?? [];
            }
            $data['hairstylist_category'] = MyHelper::get('hairstylist/be/category')['result']??[];
            return view('recruitment::hair_stylist.detail', $data);
        }else{
            return redirect('recruitment/hair-stylist')->withErrors($store['messages']??['Failed get detail hair stylist']);
        }
    }

    public function hsUpdate(Request $request, $id){
        $post = $request->except('_token');
        $post['id_user_hair_stylist'] = $id;

        if(!empty($post['user_hair_stylist_photo'])){
            $post['user_hair_stylist_photo'] = MyHelper::encodeImage($post['user_hair_stylist_photo']);
        }else{
            unset($post['user_hair_stylist_photo']);
        }

        $update = MyHelper::post('recruitment/hairstylist/be/update',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('recruitment/hair-stylist/detail/'.$id)->withSuccess(['Success update data to hair stylist']);
        }else{
            return redirect('recruitment/hair-stylist/detail/'.$id)->withErrors($update['messages']??['Failed update data to hair stylist']);
        }
    }

    public function hsUpdateBox(Request $request, $id){
        $post = $request->except('_token');
        $post['id_user_hair_stylist'] = $id;

        $update = MyHelper::post('recruitment/hairstylist/be/update-box',$post);

        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('recruitment/hair-stylist/detail/'.$id)->withSuccess(['Success update box hair stylist']);
        }else{
            return redirect('recruitment/hair-stylist/detail/'.$id)->withErrors($update['messages']??['Failed update box hair stylist']);
        }
    }

    public function updateStatus(Request $request){
        $post = $request->except('_token');
        $update = MyHelper::post('recruitment/hairstylist/be/update-status',[
            'id_user_hair_stylist' => $post['id_user_hair_stylist'],
            'user_hair_stylist_status' => $post['user_hair_stylist_status']
        ]);
        return $update;
    }

    public function hsDownloadFile($id){
        $data = MyHelper::post('recruitment/hairstylist/be/detail/document', ['id_user_hair_stylist_document' => $id]);

        if(isset($data['status']) && $data['status'] == 'success'){
            $ext = explode(".",$data['result']['attachment'])[1]??null;
            if(empty($ext)){
                return redirect('recruitment/hair-stylist')->withErrors(['Extention not found']);
            }
            $filename = str_replace('/','_',strtolower(str_replace(' ','_',$data['result']['document_type'])).'_'.strtotime(date('Ymdhis')).'.'.$ext);
            $temp = tempnam(sys_get_temp_dir(), $filename);
            copy($data['result']['attachment'], $temp);
            return response()->download($temp, $filename)->deleteFileAfterSend(true);
        }else{
            return redirect('recruitment/hair-stylist')->withErrors(['File not found']);
        }
    }

    public function hsDownloadFileContract($id){
        $detail = MyHelper::post('recruitment/hairstylist/be/detail',['id_user_hair_stylist' => $id]);
        if(isset($detail['status']) && $detail['status'] == 'success'){
            $res = $detail['result'];
            $ext = explode(".",$res['file_contract'])[1]??null;
            if(empty($ext)){
                return redirect('recruitment/hair-stylist')->withErrors(['Extention not found']);
            }
            $filename = 'hs_'.$res['user_hair_stylist_code'].'.docx';
            $temp = tempnam(sys_get_temp_dir(), $filename);
            copy($res['file_contract'], $temp);
            return response()->download($temp, $filename)->deleteFileAfterSend(true);
        }else{
            return redirect('recruitment/hair-stylist')->withErrors(['File not found']);
        }
    }

    public function candidateDelete($id){
        $delete = MyHelper::post('recruitment/hairstylist/be/delete', ['id_user_hair_stylist' => $id]);
        return $delete;
    }

    public function moveOutlet(Request $request, $id){
        $post = $request->except('_token');
        $post['id_user_hair_stylist'] = $id;

        $update = MyHelper::post('recruitment/hairstylist/be/move-outlet',$post);

        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('recruitment/hair-stylist/detail/'.$id.'#hs-change-outlet')->withSuccess(['Success change outlet hair stylist']);
        }else{
            return redirect('recruitment/hair-stylist/detail/'.$id.'#hs-change-outlet')->withErrors($update['messages']??['Failed change outlet hair stylist']);
        }
    }

    public function candidateSettingRequirements(Request $request){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Recruitment',
                'sub_title'      => 'Hair Stylist',
                'menu_active'    => 'hair-stylist',
                'submenu_active' => 'hair-stylist-setting-requirements'
            ];

            $res = MyHelper::get('recruitment/hairstylist/be/setting-requirements')['result']??[];
            $data['male_age'] = $res['male_age']??'';
            $data['male_height'] = $res['male_height']??'';
            $data['female_age'] = $res['female_age']??'';
            $data['female_height'] = $res['female_height']??'';

            return view('recruitment::hair_stylist.setting_requirements', $data);
        }else{
            $update = MyHelper::post('recruitment/hairstylist/be/setting-requirements',$post);

            if(isset($update['status']) && $update['status'] == 'success'){
                return redirect('recruitment/hair-stylist/candidate/setting-requirements')->withSuccess(['Success update setting']);
            }else{
                return redirect('recruitment/hair-stylist/candidate/setting-requirements')->withErrors($update['messages']??['Failed update setting']);
            }
        }
    }

    public function exportCommision(Request $request){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Transaction',
                'sub_title'      => 'Export Commision',
                'menu_active'    => 'hair-stylist-export-commision',
                'submenu_active' => 'hair-stylist-export-commision',
            ];

            $data['outlets'] = MyHelper::get('outlet/be/list/simple')['result']??[];
            return view('recruitment::hair_stylist.export_commision', $data);
        }else{
            $data = MyHelper::post('hairstylist/be/export-commision',$post);

            if (isset($data['status']) && $data['status'] == "success") {
                $dataExport['All Type'] = $data['result'];
                $data = new MultisheetExport($dataExport);
                return Excel::download($data,'Commision_'.date('Ymdhis').'.xls');
            }else {
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    public function categoryCreate(Request $request){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Hair Stylist',
                'sub_title'      => 'New Hair Stylist Category',
                'menu_active'    => 'hair-stylist',
                'submenu_active' => 'hair-stylist-category',
                'child_active'   => 'create-hair-stylist-category'
            ];

            return view('recruitment::hair_stylist.category.category_create', $data);
        }else{
            $save = MyHelper::post('hairstylist/be/category/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('hair-stylist/category')->withSuccess(['Success save data']);
            }else{
                return redirect('hair-stylist/category/create')->withErrors($save['messages']??['Failed save data']);
            }
        }
    }

    public function categoryList(Request $request){
        $data = [
            'title'          => 'Hair Stylist',
            'sub_title'      => 'Hair Stylist Category List',
            'menu_active'    => 'hair-stylist',
            'submenu_active' => 'hair-stylist-category',
            'child_active'   => 'list-hair-stylist-category'
        ];

        $category = MyHelper::get('hairstylist/be/category');

        if (isset($category['status']) && $category['status'] == "success") {
            $data['category'] = $category['result'];
        }
        else {
            $data['category'] = [];
        }

        return view('recruitment::hair_stylist.category.category_list', $data);
    }

    public function categoryDetail(Request $request, $id){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Hair Stylist',
                'sub_title'      => 'Hair Stylist Category Detail',
                'menu_active'    => 'hair-stylist',
                'submenu_active' => 'hair-stylist-category',
                'child_active'   => 'list-hair-stylist-category'
            ];

            $detail = MyHelper::post('hairstylist/be/category', ['id_hairstylist_category' => $id]);

            if (isset($detail['status']) && $detail['status'] == "success") {
                $data['detail'] = $detail['result'];
                return view('recruitment::hair_stylist.category.category_detail', $data);
            }else{
                return redirect('hair-stylist/category')->withErrors($save['messages']??['Failed get data']);
            }
        }else{
            $post['id_hairstylist_category'] = $id;
            $save = MyHelper::post('hairstylist/be/category/update', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('hair-stylist/category/detail/'.$id)->withSuccess(['Success save data']);
            }else{
                return redirect('hair-stylist/category/detail/'.$id)->withErrors($save['messages']??['Failed save data']);
            }
        }
    }

    public function categoryDelete(Request $request, $id){
        $delete = MyHelper::post('hairstylist/be/category/delete', ['id_hairstylist_category' => $id]);
        return $delete;
    }
}
