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
            'menu_active'    	=> 'hairstylist-schedule',
            'submenu_active' 	=> 'hairstylist-schedule',
            'child_active' 		=> 'hairstylist-schedule-list',
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

        $month = [];
        for ($m=1; $m<=12; $m++) {
        	$month[] = [
        		'index' => $m,
        		'name' => date('F', mktime(0,0,0,$m, 1, date('Y')))
        	];
        }

        $data['months'] = $month;

        $data['years'] = MyHelper::get('recruitment/hairstylist/be/schedule/year-list')['result'] ?? [];
        $data['outlets'] = MyHelper::get('outlet/be/list?log_save=0')['result'] ?? [];

        return view('recruitment::hair_stylist.schedule.list', $data);
    }

    public function detail(Request $request, $id){
        $detail = MyHelper::post('recruitment/hairstylist/be/schedule/detail',['id_hairstylist_schedule' => $id]);

        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data = [
                'title'          => 'Recruitment',
                'sub_title'      => 'Schedule',
                'menu_active'    => 'hairstylist-schedule',
                'submenu_active' => 'hairstylist-schedule',
                'child_active' 	 => 'hairstylist-schedule-list',
                'url_back'       => 'recruitment/hair-stylist/schedule'
            ];

            $data['data'] = $detail['result'];

            return view('recruitment::hair_stylist.schedule.detail_v2', $data);
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

    public function create(Request $request){
        $data = [
            'title'          	=> 'Recruitment',
            'sub_title'      	=> 'Schedule',
            'menu_active'    	=> 'hairstylist-schedule',
            'submenu_active' 	=> 'hairstylist-schedule',
            'child_active' 		=> 'hairstylist-schedule-create',
        ];
        
        $data['hair_stylists'] = MyHelper::post('recruitment/hairstylist/be/list', [])['result']['data'];
        return view('recruitment::hair_stylist.schedule.create', $data);
    }

    public function check(Request $request){
        $post = $request->except('_token');
        $data =  MyHelper::post('recruitment/hairstylist/be/schedule/create',$post);

        if(isset($data['status']) && $data['status'] == 'success'){
            return $data;
        }else{
            return [
                'status' => $data['status'],
                'messages' => $data['messages'] ?? 'Something went wrong. Failed to create the schedule.'
            ];
        }
    }
}
