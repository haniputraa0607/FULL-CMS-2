<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class HairStylistOvertimeDayController extends Controller
{
           
              
              //default_overtime_day 
              public function default_index_overtime_day(Request $request)
                {
                       $post = $request->all();
                 $url = $request->url();
                 $data = [ 
                            'title'             => 'Default Overtime Day Hair Stylist',
                            'sub_title'         => 'Default Overtime Day Salary Hairstylist',
                            'menu_active'       => 'default-hair-stylist',
                            'submenu_active'    => 'default-hair-stylist-overtime-day'
                        ];
                   $session = 'default-hair-stylist-overtime-day';
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
              
               $list = MyHelper::post('recruitment/hairstylist/be/group/overtime-day/default'.$page, $post)['result']??[];
               $val = array();
                foreach ($list as $value){
                    $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_default_overtime_day'],$value['created_at']);
                    array_push($val,$value);
                }
                $data['data'] = $val;
                return view('recruitment::default_income.overtime_day.index',$data);
                  }
              public function default_create_overtime_day(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/overtime-day/default/create', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Overtime Day Create Success']);
                        } else{
                                return back()->withInput($request->input())->withErrors($query['messages']);
                        }
                   
              }
              public function default_delete_overtime_day($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/overtime-day/default/delete', ['id_hairstylist_group_default_overtime_day'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_update_overtime_day(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/overtime-day/default/update', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                            return  redirect('recruitment/hair-stylist/default/overtime_day')->withSuccess(['Hair Stylist Group Overtime Day Update Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_detail_overtime_day($id)
            {
                 $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/overtime-day/default/detail',['id_hairstylist_group_default_overtime_day'=>$id]);
                    if(isset($query['status']) && $query['status'] == 'success'){
                        $data = [ 
                                  'title'             => 'Default Hair Stylist Overtime Day',
                                   'sub_title'         => 'Detail Default Hair Stylist Overtime Day',
                                   'menu_active'       => 'default-hair-stylist',
                                   'submenu_active'    => 'default-hair-stylist-overtime-day'
                               ];
                        $data['result']=$query['result'];
                            return view('recruitment::default_income.overtime_day.update',$data);
                    } else{
                            return back()->withErrors($query['messages']);
                    }
                   
              }    
              
}
