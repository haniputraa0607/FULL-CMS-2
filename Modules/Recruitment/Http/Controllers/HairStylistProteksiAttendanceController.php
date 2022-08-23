<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class HairStylistProteksiAttendanceController extends Controller
{
           
              
              //default_overtime_day 
              public function default_index_proteksi_attendance(Request $request)
                {
                       $post = $request->all();
                 $url = $request->url();
                 $data = [ 
                            'title'             => 'Default Proteksi Attendance Hair Stylist',
                            'sub_title'         => 'Default Proteksi Attendance Salary Hairstylist',
                            'menu_active'       => 'default-hair-stylist',
                            'submenu_active'    => 'default-hair-stylist-proteksi-attendance'
                        ];
                   $session = 'default-hair-stylist-proteksi-attendance';
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
              
               $list = MyHelper::post('recruitment/hairstylist/be/group/proteksi-attendance/default'.$page, $post)['result']??[];
                $data['data'] = $list;
                return view('recruitment::default_income.proteksi_attendance.index',$data);
                  }
              public function default_create_proteksi_attendance(Request $request)
              {
                 $post = $request->except('_token');
                 
                 foreach (array_filter($post['month']) as $key => $value) {
                 $post['amount'][$key] = str_replace(',','', $post['amount'][$key]??0);
                 $post['amount_day'][$key] = str_replace(',','', $post['amount_day'][$key]??0);
                  $b = array(
                         'value' => $post['value'][$key],
                         'amount' => $post['amount'][$key],
                         'amount_day' => $post['amount_day'][$key],
                         'month' => $value
                     );
                 $query = MyHelper::post('recruitment/hairstylist/be/group/proteksi-attendance/default/create', $b);
                 }
                 return redirect()->back()->withSuccess(['Hair Stylist Group Proteksi Attendance Create Success']);
                   
              }
              public function default_delete_proteksi_attendance($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/proteksi-attendance/default/delete', ['id_hairstylist_group_default_proteksi_attendance'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_update_proteksi_attendance(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/proteksi-attendance/default/update', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                            return  redirect('recruitment/hair-stylist/default/proteksi_attendance')->withSuccess(['Hair Stylist Group Proteksi Attendance Update Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_detail_proteksi_attendance($id)
            {
                 $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/proteksi-attendance/default/detail',['id_hairstylist_group_default_proteksi_attendance'=>$id]);
                    if(isset($query['status']) && $query['status'] == 'success'){
                        $data = [ 
                                  'title'             => 'Default Hair Stylist Proteksi Attendance',
                                   'sub_title'         => 'Detail Default Hair Stylist Proteksi Attendance',
                                   'menu_active'       => 'default-hair-stylist',
                                   'submenu_active'    => 'default-hair-stylist-proteksi-attendance'
                               ];
                        $data['result']=$query['result'];
                            return view('recruitment::default_income.proteksi_attendance.update',$data);
                    } else{
                            return back()->withErrors($query['messages']);
                    }
                   
              }    
              
}
