<?php

namespace Modules\Recruitment\Http\Controllers;

use App\Exports\DataExport;
use App\Exports\MultisheetExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Excel;
use App\Exports\PayrollExport;

class HairStylistHolidayController extends Controller
{
   

    public function create(Request $request)
    {
        $post = $request->except('_token');
        $post['holiday_date'] = date('Y-m-d', strtotime($post['holiday_date']));
        $query = MyHelper::post('hairstylist/be/holiday/create', $post);
        if(isset($query['status']) && $query['status'] != 'success'){
            return redirect(url()->previous())->withErrors($query['messages']);
        }
         return redirect(url()->previous())->withSuccess(['Hair Stylist Loan Success']);
    }
    public function update(Request $request)
    {
        $post = $request->except('_token');
        $post['holiday_date'] = date('Y-m-d', strtotime($post['holiday_date']));
        $query = MyHelper::post('hairstylist/be/holiday/update', $post);
        if(isset($query['status']) && $query['status'] != 'success'){
            return redirect(url()->previous())->withErrors($query['messages']);
        }
         return redirect(url()->previous())->withSuccess(['Hair Stylist Loan Success']);
    }
    public function delete($id)
    {
       $query = MyHelper::post('hairstylist/be/holiday/delete', ['id_hs_holiday'=>$id]);
              if(isset($query['status']) && $query['status'] == 'success'){
                      return back()->withSuccess(['Delete Success']);
              } else{
                      return back()->withErrors($query['messages']);
              }

    }
    public function index(Request $request)
    {
        $post = $request->all();
        $url = $request->url();
        $data = [ 
                    'title'             => 'Holiday Hairstylist',
                    'sub_title'         => 'Holiday Hairstylist',
                    'menu_active'       => 'hs-holiday',
                    'submenu_active'    => 'hs-holiday'
                ];
           $session = 'hs-holiday';
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
        $list = MyHelper::post('hairstylist/be/holiday'.$page, $post)['result']??[];
        $data['data'] = $list;
        return view('recruitment::holiday.index',$data);
    }
    public function detail($id)
    {
         $data = [ 
                    'title'             => 'Holiday Hairstylist',
                    'sub_title'         => 'Detail Holiday Hairstylist',
                    'menu_active'       => 'hs-holiday',
                    'submenu_active'    => 'hs-holiday'
                ];
       $data['result'] = MyHelper::post('hairstylist/be/holiday',['id_hs_holiday'=>$id])['result']??[];
       if($data['result']){
            return view('recruitment::holiday.update',$data);
       }
       return redirect('hair-stylist/holiday')->withErrors(['Holiday not found']);
    }
    public function generate()
    {
       $data['result'] = MyHelper::get('hairstylist/be/holiday/generate');
       if($data['result']){
           return back()->withSuccess(['Success']);
       }
       return redirect('hair-stylist/holiday')->withErrors(['Holiday not found']);
    }
    
     
}
