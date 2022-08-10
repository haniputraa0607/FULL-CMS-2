<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class HairStylistIncomeController extends Controller
{
    public function index(Request $request){
      
         $post = $request->all();
        $url = $request->url();
       $data = [
            'title'          => 'Hairstylist',
           'sub_title'      => 'Income Hairstylist',
            'menu_active'    => 'hair-stylist',
            'submenu_active'    => 'hair-stylist-income',
        ];
            $session = "payslip-employee";
         if( ($post['rule']??false) && !isset($post['draw']) ){
             session([$session => $post]);
        }elseif($post['clear']??false){
            session([$session => null]);
        }
        if(isset($post['reset']) && $post['reset'] == 1){
            Session::forget($session);
        }elseif(Session::has($session) && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get($session);
            $post['page'] = $pageSession;
            
        }
        if(isset($post['rule'])){
        	$data['rule'] = array_map('array_values', $post['rule']);
        }
        $page = '?page=1';
        if(isset($post['page'])){
            $page = '?page='.$post['page'];
        }
        $list = MyHelper::post('recruitment/hairstylist/be/income'.$page, $post);
        if(($list['status']??'')=='success'){
            $val = array();
            foreach ($list['result']['data'] as $value){
                $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_income'],date('Y-m-d H:i:s'));
                array_push($val,$value);
            }
            $data['data']          = $val;
            $data['data_total']     = $list['result']['total'];
            $data['data_per_page']   = $list['result']['from'];
            $data['data_up_to']      = $list['result']['from'] + count($list['result']['data'])-1;
            $data['data_paginator'] = new LengthAwarePaginator($val, $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['data']          = [];
            $data['data_total']     = 0;
            $data['data_per_page']   = 0;
            $data['data_up_to']      = 0;
            $data['data_paginator'] = false;
        }
        if($post){
            Session::put($session,$post);
        }
        $outlet= MyHelper::post('recruitment/hairstylist/be/income/outlet'.$page, $post)['result']??[];
        $data['outlet'] = [];
        foreach($outlet as $value){
            $data['outlet'][] = array(
                $value['id_outlet'],$value['outlet_name']
            );
        }
        return view('recruitment::payslip.index', $data);
    }
    public function detail($id){
      $id = MyHelper::explodeSlug($id)[0]??'';
         $data = [ 
                    'title'          => 'Hairstylist',
                    'sub_title'      => 'Detail Hairstylist',
                     'menu_active'    => 'hair-stylist',
                     'submenu_active'    => 'hair-stylist-income',
                ];
      $data['data'] = MyHelper::post('recruitment/hairstylist/be/income/detail',['id_hairstylist_income'=>$id])['result']??[];
       if($data['data']){
        return view('recruitment::payslip.detail',$data);
       }
       return back('')->withErrors(['Data not found']);
    }
}
