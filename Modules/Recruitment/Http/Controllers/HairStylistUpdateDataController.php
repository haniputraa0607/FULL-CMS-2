<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class HairStylistUpdateDataController extends Controller
{
    public function list(Request $request){
        $post = $request->all();

        $data = [
            'title'          	=> 'Recruitment',
            'sub_title'      	=> 'Request Update Data',
            'menu_active'    	=> 'hairstylist-update-data',
            'submenu_active' 	=> 'hairstylist-update-data-list',
            'title_date_start' 	=> 'Request Start',
            'title_date_end' 	=> 'Request End'
        ];

        if(Session::has('filter-hs-update-data') && !empty($post) && !isset($post['filter'])){
            $page = 1;
            if(isset($post['page'])){
                $page = $post['page'];
            }
            $post = Session::get('filter-hs-update-data');
            $post['page'] = $page;
        }else{
            Session::forget('filter-hs-update-data');
        }

        $getList = MyHelper::post('recruitment/hairstylist/be/update-data/list',$post);

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
            Session::put('filter-hs-update-data',$post);
        }

        $month = [];
        for ($m=1; $m<=12; $m++) {
        	$month[] = [
        		'index' => $m,
        		'name' => date('F', mktime(0,0,0,$m, 1, date('Y')))
        	];
        }

        return view('recruitment::hair_stylist.update_data.list', $data);
    }

    public function detail(Request $request, $id){
        $detail = MyHelper::post('recruitment/hairstylist/be/update-data/detail',['id_hairstylist_update_data' => $id]);
        if(isset($detail['status']) && $detail['status'] == 'success'){
            $data = [
                'title'          => 'Recruitment',
                'sub_title'      => 'Request Update Data',
                'menu_active'    => 'hairstylist-update-data',
                'submenu_active' => 'hairstylist-update-data-list',
                'url_back'       => 'recruitment/hair-stylist/update-data'
            ];

            $data['data'] = $detail['result'];

            return view('recruitment::hair_stylist.update_data.detail', $data);
        }else{
            return redirect('recruitment/hair-stylist/update-data')->withErrors($store['messages']??['Failed get detail request update data']);
        }
    }

    public function update(Request $request, $id){
        $post = $request->except('_token');
        $post['id_hairstylist_update_data'] = $id;

        $update = MyHelper::post('recruitment/hairstylist/be/update-data/update',$post);

        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('recruitment/hair-stylist/update-data/detail/'.$id)->withSuccess(['Success update data request']);
        }else{
            return redirect('recruitment/hair-stylist/update-data/detail/'.$id)->withErrors($update['messages']??['Failed update data to approved']);
        }
    }
}
