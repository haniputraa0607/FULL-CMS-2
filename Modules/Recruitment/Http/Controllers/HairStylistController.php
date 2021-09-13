<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $detail = MyHelper::post('recruitment/hairstylist/be/detail',['id_user_hair_stylist' => $id]);

        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data = [
                'title'          => 'Recruitment',
                'sub_title'      => 'Candidate',
                'menu_active'    => 'hair-stylist',
                'submenu_active' => 'hair-stylist-candidate',
                'url_back'      => 'recruitment/hair-stylist/candidate'
            ];

            $data['detail'] = $detail['result'];
            $data['outlets'] = MyHelper::get('outlet/be/list/simple')['result']??[];
            return view('recruitment::hair_stylist.detail', $data);
        }else{
            return redirect('recruitment/hair-stylist/candidate')->withErrors($store['messages']??['Failed get detail candidate']);
        }
    }

    public function candidateUpdate(Request $request, $id){
        $post = $request->except('_token');
        $post['id_user_hair_stylist'] = $id;
        $post['update_type'] = 'approve';

        $update = MyHelper::post('recruitment/hairstylist/be/update',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('recruitment/hair-stylist/detail/'.$id)->withSuccess(['Success update data to approved']);
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
            $data['outlets'] = MyHelper::get('outlet/be/list/simple')['result']??[];
            return view('recruitment::hair_stylist.detail', $data);
        }else{
            return redirect('recruitment/hair-stylist')->withErrors($store['messages']??['Failed get detail hair stylist']);
        }
    }

    public function hsUpdate(Request $request, $id){
        $post = $request->except('_token');
        $post['id_user_hair_stylist'] = $id;

        $update = MyHelper::post('recruitment/hairstylist/be/update',$post);
        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('recruitment/hair-stylist/detail/'.$id)->withSuccess(['Success update data to hair stylist']);
        }else{
            return redirect('recruitment/hair-stylist/detail/'.$id)->withErrors($update['messages']??['Failed update data to hair stylist']);
        }
    }

    public function updateStatus(Request $request){
        $post = $request->except('_token');
        $update = MyHelper::post('recruitment/hairstylist/be/update',[
            'id_user_hair_stylist' => $post['id_user_hair_stylist'],
            'user_hair_stylist_status' => $post['user_hair_stylist_status']
        ]);
        return $update;
    }
}
