<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class HairStylistScheduleController extends Controller
{
    public function list(Request $request){
        $post = $request->all();

        $data = [
            'title'          	=> 'Recruitment',
            'sub_title'      	=> 'Schedule',
            'menu_active'    	=> 'hair-stylist',
            'submenu_active' 	=> 'hair-stylist-schedule',
            'title_date_start' 	=> 'Request Start',
            'title_date_end' 	=> 'Request End'
        ];

        if(Session::has('filter-hs-schedule') && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('filter-hs-schedule');
            $post['page'] = $page;
        }else{
            Session::forget('filter-hs-schedule');
        }
        $getList = MyHelper::post('recruitment/hairstylist/be/schedule/list',$post);

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
            Session::put('filter-hs-schedule',$post);
        }

        $data['outlets'] = MyHelper::get('outlet/be/list?log_save=0')['result'] ?? [];

        return view('recruitment::hair_stylist.schedule.list', $data);
    }

    public function detail(Request $request, $id){
        $detail = MyHelper::post('recruitment/hairstylist/be/schedule/detail',['id_hairstylist_schedule' => $id]);
        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data = [
                'title'          => 'Recruitment',
                'sub_title'      => 'Schedule',
                'menu_active'    => 'hair-stylist',
                'submenu_active' => 'hair-stylist-schedule',
                'url_back'       => 'recruitment/hair-stylist/schedule'
            ];

            $data['detail'] = $detail['result'];
            $data['schedules'] = MyHelper::get('recruitment/hairstylist/be/schedule/outlet?id_outlet='.$data['detail']['id_outlet'])['result'] ?? [];

            return view('recruitment::hair_stylist.schedule.detail', $data);
        }else{
            return redirect('recruitment/hair-stylist/schedule')->withErrors($store['messages']??['Failed get detail schedule']);
        }
    }

    public function update(Request $request, $id){
        $post = $request->except('_token');
        $post['id_hairstylist_schedule'] = $id;

        $update = MyHelper::post('recruitment/hairstylist/be/schedule/update',$post);

        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('recruitment/hair-stylist/schedule/detail/'.$id)->withSuccess(['Success update data schedule']);
        }else{
            return redirect('recruitment/hair-stylist/schedule/detail/'.$id)->withErrors($update['messages']??['Failed update data to approved']);
        }
    }
}
