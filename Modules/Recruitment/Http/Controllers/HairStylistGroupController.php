<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class HairStylistGroupController extends Controller
{
            public function create(Request $request)
              {
                  $post = $request->except('_token');
                    if(isset($post) && !empty($post)){
                        $query = MyHelper::post('recruitment/hairstylist/be/group/create', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Create Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                    } else {
                        $data = [ 'title'             => 'New Hair Stylist Group',
                                  'menu_active'       => 'hair-stylist-group',
                                  'submenu_active'    => 'new-hair-stylist-group'
                                ];
                        return view('recruitment::group.create',$data);
                    }

              }
            public function update(Request $request)
              {
                  $post = $request->except('_token');
                        $query = MyHelper::post('recruitment/hairstylist/be/group/update', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Update Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
              }
            public function invite_hs(Request $request)
              {
                  $post = $request->except('_token');
                        $query = MyHelper::post('recruitment/hairstylist/be/group/invite_hs', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Invite Hair Stylist Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
              }
            public function index(Request $request)
              {
                 $post = $request->all();
                 $url = $request->url();
                 $data = [ 'title'             => 'List Hair Stylist Group',
                           'menu_active'       => 'hair-stylist-group',
                           'submenu_active'    => 'list-hair-stylist-group'
                        ];
                   $session = 'list-hair-stylist-group';
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
               $list = MyHelper::post('recruitment/hairstylist/be/group'.$page, $post);
               if(($list['status']??'')=='success'){
                    $val = array();
                    foreach ($list['result']['data'] as $value){
                        $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group'],$value['created_at']);
                        array_push($val,$value);
                    }
                   $data['data'] = $val;
                   $data['data_total']     = $list['result']['total'];
                   $data['data_per_page']   = $list['result']['from'];
                   $data['data_up_to']      = $list['result']['from'] + count($list['result']['data'])-1;
                   $data['data_paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
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
                return view('recruitment::group.list',$data);
              }
            public function detail($id,Request $request)
              {
                $id_before = $id;
                $id = MyHelper::explodeSlug($id)[0]??'';
                $data = [ 
                                  'title'             => 'Hair Stylist Group',
                                  'sub_title'         => 'Detail Hair Stylist Group',
                                  'menu_active'       => 'hair-stylist-group',
                                  'submenu_active'    => 'list-hair-stylist-group'
                                ];
                $query = MyHelper::post('recruitment/hairstylist/be/group/detail',['id_hairstylist_group'=>$id]);
                if(isset($query['status']) && $query['status'] == 'success'){
                        $data['id']  = $id;
                        $data['id_before']  = $id_before;
                         $data['result'] = $query['result'];
                        $post = $request->all();
                        $session = 'hair-stylist-group-filter-commission';
                        $post['id_hairstylist_group'] = $id;
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
                              $post['id_hairstylist_group'] = $id;
                            
                        }
                        if(isset($post['rule'])){
                           
                                $data['rule'] = array_map('array_values', $post['rule']);
                        }
                        $page = '?page=1';
                        if(isset($post['page'])){
                            $page = '?page='.$post['page'];
                        }
                          $list = MyHelper::post('recruitment/hairstylist/be/group/commission'.$page,$post)??[];
                          if(($list['status']??'')=='success'){
                             $val = array();
                                foreach ($list['result']['data'] as $value){
                                    $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_commission'],date('Y-m-d H:i:s'));
                                    array_push($val,$value);
                                }  
                           $data['commission']['data'] = $val;
                           $data['commission']['data_total']     = $list['result']['total'];
                           $data['commission']['data_per_page']   = $list['result']['from'];
                           $data['commission']['data_up_to']      = $list['result']['from'] + count($list['result']['data'])-1;
                           $data['commission']['data_paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
                       }else{
                           $data['commission']['data']          = [];
                           $data['commission']['data_total']     = 0;
                           $data['commission']['data_per_page']   = 0;
                           $data['commission']['data_up_to']      = 0;
                           $data['commission']['data_paginator'] = false;
                       }
                        if($post){
                            Session::put($session,$post);
                        }  
                        $data['product'] = MyHelper::post('recruitment/hairstylist/be/group/product',['id_hairstylist_group'=>$id])??[];
                         $session2 = 'hair-stylist-group-filter-hs';
                         $post2 = Session::get($session2);
                         $post2['id_hairstylist_group'] = $id;
                         $data['filter_hs'] = $post2;
                          $list2 = MyHelper::post('recruitment/hairstylist/be/group/list_hs'.$page,$post2)??[];
                          if(($list2['status']??'')=='success'){
                           $data['hs']['data'] = $list2['result']['data'];
                           $data['hs']['data_total']     = $list2['result']['total'];
                           $data['hs']['data_per_page']   = $list2['result']['from'];
                           $data['hs']['data_up_to']      = $list2['result']['from'] + count($list['result']['data'])-1;
                           $data['hs']['data_paginator'] = new LengthAwarePaginator($list2['result']['data'], $list2['result']['total'], $list2['result']['per_page'], $list2['result']['current_page'], ['path' => url()->current()]);
                       }else{
                           $data['hs']['data']          = [];
                           $data['hs']['data_total']     = 0;
                           $data['hs']['data_per_page']   = 0;
                           $data['hs']['data_up_to']      = 0;
                           $data['hs']['data_paginator'] = false;
                       }
                         $post3['id_hairstylist_group'] = $id;
                         $data['filter_insentif'] = $post3;
                         $data['list_default_insentif'] = MyHelper::post('recruitment/hairstylist/be/group/list_default_insentif',$post3)??[];
                         $insentif = MyHelper::post('recruitment/hairstylist/be/group/insentif'.$page,$post3)['result']??[];
                         $val2 = array();
                                foreach ($insentif as $value){
                                    $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_default_insentifs'],$id);
                                    array_push($val2,$value);
                                }  
                         $data['insentif'] = $val2;
                         $session4 = 'hair-stylist-group-filter-potongan';
                         $post4 = Session::get($session4);
                         $post4['id_hairstylist_group'] = $id;
                         $data['filter_potongan'] = $post4;
                         $data['list_default_potongan'] = MyHelper::post('recruitment/hairstylist/be/group/list_default_potongan',$post4)??[];
                         $potongan = MyHelper::post('recruitment/hairstylist/be/group/potongan',$post4)['result']??[];
                         $val3 = array();
                                foreach ($potongan as $value){
                                    $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_default_potongans'],$id);
                                    array_push($val3,$value);
                                }  
                        $data['potongan'] = $val3;
                        $data['list_default_overtime'] = MyHelper::post('recruitment/hairstylist/be/group/list_default_overtime',$post4)??[];
                       $overtime = MyHelper::post('recruitment/hairstylist/be/group/overtime',$post4)['result']??[];
                         $val5 = array();
                        foreach ($overtime as $value){
                            $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_default_overtimes'],$id);
                            array_push($val5,$value);
                        }  
                        $data['overtime'] = $val5;
                       $late = MyHelper::post('recruitment/hairstylist/be/group/late',$post4)['result']??[];
                         $val_late = array();
                        foreach ($late as $value){
                            $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_default_late'],$id);
                            array_push($val_late,$value);
                        }  
                        $overtime_day = MyHelper::post('recruitment/hairstylist/be/group/overtime-day',$post4)['result']??[];
                         $val55 = array();
                        foreach ($overtime_day as $value){
                            $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_default_overtime_day'],$id);
                            array_push($val55,$value);
                        }  
                        $data['overtime_day'] = $val55;
                       $proteksi_attendance = MyHelper::post('recruitment/hairstylist/be/group/proteksi-attendance',$post4)['result']??[];
                         $val5s = array();
                        foreach ($proteksi_attendance as $value){
                            $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_default_proteksi_attendance'],$id);
                            array_push($val5s,$value);
                        }  
                        $data['proteksi_attendance'] = $val5s;
                        $data['late'] = $val_late;
                        $fixed_incentive = MyHelper::post('recruitment/hairstylist/be/group/fixed-incentive',$post4)['result']??[];
                        $data['fixed_incentive'] = $fixed_incentive;
                        $proteksi = MyHelper::post('recruitment/hairstylist/be/group/proteksi',$post4)['result']??[];
                        $data['proteksi'] = $proteksi;
                        $data['lisths'] = MyHelper::post('recruitment/hairstylist/be/group/hs',['id_hairstylist_group'=>$id])['result']??[];
                        $textreplace = array(
                            array(
                                'keyword'=>'value',
                                'message'=>'Value'
                            ), 
                            array(
                                'keyword'=>'total_attend',
                                'message'=>'Total of attendance at work'
                            ), 
                            array(
                                'keyword'=>'total_late',
                                'message'=>'Total of late at work'
                            ), 
                            array(
                                'keyword'=>'total_absen',
                                'message'=>'Total of unpaid leave at work'
                            ), 
                            array(
                                'keyword'=>'+',
                                'message'=>'Added'
                            ), 
                            array(
                                'keyword'=>'-',
                                'message'=>'Subtraction'
                            ), 
                            array(
                                'keyword'=>'*',
                                'message'=>'Multiplication'
                            ), 
                            array(
                                'keyword'=>'/',
                                'message'=>'Distribution'
                            ), 
                        );
                        $data['textreplace'] = $textreplace;
                        return view('recruitment::group.detail',$data);
                } else{
                        return back()->withErrors($query['messages']);
                }
              }
            public function create_commission(Request $request)
              {
                 $post = $request->except('_token');
                 $query = MyHelper::post('recruitment/hairstylist/be/group/create_commission', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Commission Create Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function update_commission(Request $request)
              {
                 $post = $request->except('_token');
                 $query = MyHelper::post('recruitment/hairstylist/be/group/update_commission', $post);;
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Commission Update Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function detail_commission($id)
            {
                 $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/detail_commission',['id_hairstylist_group_commission'=>$id]);
                    if(isset($query['status']) && $query['status'] == 'success'){
                         $data = [ 
                                  'title'             => 'Hair Stylist Group',
                                  'sub_title'         => 'Detail Hair Stylist Group Commission',
                                  'menu_active'       => 'hair-stylist-group',
                                  'submenu_active'    => 'detail-hair-stylist-group-commission',
                                  'url_group'        => MyHelper::createSlug($query['result']['id_hairstylist_group'],$query['result']['created_at']),
                                ];
                          $data['result'] = $query['result'];
                          $data['result']['id_hairstylist_group_commission'] = $id;
                            return view('recruitment::group.update',$data);
                    } else{
                            return back()->withErrors($query['messages']);
                    }
                   
            }

            public function deleteCommission($id, $id_commission){
                $delete = MyHelper::post('recruitment/hairstylist/be/group/detail_commission/delete',['id_hairstylist_group_commission_dynamic'=>$id_commission]);
                if(isset($delete['status']) && $delete['status'] == 'success'){
                    return back()->withSuccess(['Success to delete dynamic rule']);
                }else{
                    return back()->withErrors($query['messages']??'Failed to delete dynamic rule');
                }
            }
            
            public function deleteCommissionProduct($slug, $id){
                $id_hs_group = MyHelper::explodeSlug($slug)[0]??'';
                $delete = MyHelper::post('recruitment/hairstylist/be/group/commission/delete',['id_hairstylist_group_commission'=>$id]);
                return $delete;
            }


            public function filter_commission(Request $request)
            {
                 $post = $request->all();
                
                 $session = 'hair-stylist-group-filter-commission';
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
               if($post){
                   Session::put($session,$post);
               }    
                return back();
           }
            public function filter_hs(Request $request)
            {
                 $post = $request->all();
                $session = 'hair-stylist-group-filter-hs';
                  if($post){
                   $b = Session::put($session,$post);
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
               $page = '?page=1';
               if(isset($post['page'])){
                   $page = '?page='.$post['page'];
               }
                if($post){
                   Session::put($session,$post);
               }
               return redirect('recruitment/hair-stylist/group/detail'.'/'.$post['id_before'].'#hs');
           }
            public function filter_insentif(Request $request)
            {
                 $post = $request->all();
                $session = 'hair-stylist-group-filter-insentif';
                 if($post){
                   Session::put($session,$post);
               }
              if(isset($post['reset']) && $post['reset'] == 1){
                   Session::forget($session);
               }elseif(Session::has($session) && !empty($post)){
                   $pageSession = 1;
                   if(isset($post['page'])){
                       $pageSession = $post['page'];
                   }
                   $post = Session::get($session);
                   $post['page'] = $pageSession;
               }
               $page = '?page=1';
               if(isset($post['page'])){
                   $page = '?page='.$post['page'];
               }
               return back();
           }
            public function filter_potongan(Request $request)
            {
                 $post = $request->all();
                $session = 'hair-stylist-group-filter-potongan';
                if($post){
                   Session::put($session,$post);
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
               $page = '?page=1';
               if(isset($post['page'])){
                   $page = '?page='.$post['page'];
               }
               if($post){
                   Session::put($session,$post);
               }    
               return back();
           }
           public function create_insentif(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $data = array();
                 foreach (array_filter($post['id_hairstylist_group_default_insentifs']) as $key => $value) {
                     $b = array(
                         'id_hairstylist_group_default_insentifs' => $value,
                         'id_hairstylist_group' => $post['id_hairstylist_group'][$key],
                         'value' => $post['value'][$key],
                         'formula' => $post['formula'][$key],
                         'code' =>$post['code'][$key]
                     );
                     $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/create', $b);
                        if(isset($query['status']) && $query['status'] != 'success'){
                                return redirect(url()->previous().'#insentif')->withErrors($query['messages']);
                        }
                 }
                   return redirect(url()->previous().'#insentif')->withSuccess(['Hair Stylist Group Incentive Update Success']);
              }
              public function delete_insentif($id)
              {
                $id = MyHelper::explodeSlug($id)??'';
                $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/delete', ['id_hairstylist_group_default_insentifs'=>$id[0]??'','id_hairstylist_group'=>$id[1]??'']);
                if(isset($query['status']) && $query['status'] == 'success'){
                    return redirect(url()->previous().'#insentif')->withSuccess(['Incentive Default Success']);
                } else{
                    return redirect(url()->previous().'#insentif')->withErrors($query['messages']);
                }
                   
              }
           public function create_rumus_insentif(Request $request)
              {
                 $post = $request->except('_token');
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/create-rumus-insentif', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Rumus Hair Stylist Group Incentive Create Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
           public function delete_rumus_insentif($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/delete-rumus-insentif', ['id_hairstylist_group_insentif_rumus'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Rumus Hair Stylist Group Incentive Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function update_insentif(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/update', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                             $id_enkripsi = MyHelper::createSlug($query['result']['id_hairstylist_group'],date('Y-m-d H:i:s'));
                                return  redirect('recruitment/hair-stylist/group/detail/'.$id_enkripsi)->withSuccess(['Hair Stylist Group Incentive Update Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function detail_insentif($id)
            {
                 $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/detail',['id_hairstylist_group_insentif'=>$id]);
                    if(isset($query['status']) && $query['status'] == 'success'){
                         $data = [ 
                                  'title'             => 'Hair Stylist Group',
                                  'sub_title'         => 'Detail Hair Stylist Group Incentive',
                                  'menu_active'       => 'hair-stylist-group',
                                  'submenu_active'    => 'detail-hair-stylist-group-insentif'
                                ];
                          $data['result']=$query['result'];
                            return view('recruitment::group.update_insentif',$data);
                    } else{
                            return back()->withErrors($query['messages']);
                    }
                   
              }
           public function create_overtime(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $data = array();
                 foreach (array_filter($post['id_hairstylist_group_default_overtimes']) as $key => $value) {
                     $b = array(
                         'id_hairstylist_group_default_overtimes' => $value,
                         'id_hairstylist_group' => $post['id_hairstylist_group'][$key],
                         'value' => $post['value'][$key],
                     );
                   $query = MyHelper::post('recruitment/hairstylist/be/group/overtime/create', $b);
                 }
                 return redirect(url()->previous().'#overtime')->withSuccess(['Hair Stylist Group Overtime Update Success']);
               
              }
           public function create_late(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $data = array();
                 foreach (array_filter($post['id_hairstylist_group_default_late']) as $key => $value) {
                     $b = array(
                         'id_hairstylist_group_default_late' => $value,
                         'id_hairstylist_group' => $post['id_hairstylist_group'][$key],
                         'value' => $post['value'][$key],
                     );
                   $query = MyHelper::post('recruitment/hairstylist/be/group/late/create', $b);
                 }
                 return redirect(url()->previous().'#late')->withSuccess(['Hair Stylist Group Late Update Success']);
              }
           public function create_overtime_day(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $data = array();
                 foreach (array_filter($post['id_hairstylist_group_default_overtime_day']) as $key => $value) {
                  $b = array(
                         'id_hairstylist_group_default_overtime_day' => $value,
                         'id_hairstylist_group' => $post['id_hairstylist_group'][$key],
                         'value' => $post['value'][$key],
                     );
                   $query = MyHelper::post('recruitment/hairstylist/be/group/overtime-day/create', $b);
                 }
                 return redirect(url()->previous().'#overtime_day')->withSuccess(['Hair Stylist Group Overtime Day Update Success']);
              }
           public function create_proteksi_attendance(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $data = array();
                 foreach (array_filter($post['id_hairstylist_group_default_proteksi_attendance']) as $key => $value) {
                  $b = array(
                         'id_hairstylist_group_default_proteksi_attendance' => $value,
                         'id_hairstylist_group' => $post['id_hairstylist_group'][$key],
                         'value' => str_replace(',','', $post['value'][$key]??null),
                         'amount' => str_replace(',','', $post['amount'][$key]??null),
                         'amount_day' => str_replace(',','', $post['amount_day'][$key]??null),
                         'amount_proteksi' => str_replace(',','', $post['amount_proteksi'][$key]??null),
                     );
                   $query = MyHelper::post('recruitment/hairstylist/be/group/proteksi-attendance/create', $b);
                 }
                 return redirect(url()->previous().'#attendance')->withSuccess(['Hair Stylist Group Overtime Day Update Success']);
              }
           public function create_potongan(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $data = array();
                 foreach (array_filter($post['id_hairstylist_group_default_potongans']) as $key => $value) {
                     $b = array(
                         'id_hairstylist_group_default_potongans' => $value,
                         'id_hairstylist_group' => $post['id_hairstylist_group'][$key],
                         'value' => $post['value'][$key],
                         'formula' => $post['formulas'][$key],
                         'code' =>$post['code'][$key]
                     );
                     $query = MyHelper::post('recruitment/hairstylist/be/group/potongan/create', $b);
                        if(isset($query['status']) && $query['status'] != 'success'){
                                return redirect(url()->previous().'#potongan')->withErrors($query['messages']);
                        }
                 }
                 return redirect(url()->previous().'#potongan')->withSuccess(['Hair Stylist Group Cuts Salary Update Success']);
               
              }
            public function update_potongan(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                $query = MyHelper::post('recruitment/hairstylist/be/group/potongan/update', $post);
                if(isset($query['status']) && $query['status'] == 'success'){
                        $id_enkripsi = MyHelper::createSlug($query['result']['id_hairstylist_group'],date('Y-m-d H:i:s'));
                        return redirect('recruitment/hair-stylist/group/detail/'.$id_enkripsi)->withSuccess(['Hair Stylist Group Potongan Update Success']);
                } else{
                        return back()->withErrors($query['messages']);
                }
                   
              }
            public function detail_potongan($id)
            {
                 $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/potongan/detail',['id_hairstylist_group_potongan'=>$id]);
                    if(isset($query['status']) && $query['status'] == 'success'){
                         $data = [ 
                                  'title'             => 'Hair Stylist Group',
                                  'sub_title'         => 'Detail Hair Stylist Group Commission',
                                  'menu_active'       => 'hair-stylist-group',
                                  'submenu_active'    => 'detail-hair-stylist-group-commission'
                                ];
                          $data['result']=$query['result'];
                            return view('recruitment::group.update_potongan',$data);
                    } else{
                            return back()->withErrors($query['messages']);
                    }
                   
              }
              public function delete_potongan($id)
              {
                $id = MyHelper::explodeSlug($id)??[];
                 $query = MyHelper::post('recruitment/hairstylist/be/group/potongan/delete', ['id_hairstylist_group_default_potongans'=>$id[0]??'','id_hairstylist_group'=>$id[1]??'']);
                    if(isset($query['status']) && $query['status'] == 'success'){
                            return redirect(url()->previous().'#potongan')->withSuccess(['Cuts Salary Default Success']);
                    } else{
                            return redirect(url()->previous().'#potongan')->withErrors($query['messages']);
                    }
                   
              }
              public function create_rumus_potongan(Request $request)
              {
                 $post = $request->except('_token');
                 $query = MyHelper::post('recruitment/hairstylist/be/group/potongan/create-rumus-potongan', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Rumus Hair Stylist Group Potongan Create Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
           public function delete_rumus_potongan($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/potongan/delete-rumus-potongan', ['id_hairstylist_group_potongan_rumus'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Rumus Hair Stylist Group Potongan Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
              
              
              //default_overtime 
              public function default_index_overtime(Request $request)
                {
                       $post = $request->all();
                 $url = $request->url();
                 $data = [ 
                            'title'             => 'Default Overtime Hair Stylist',
                            'sub_title'         => 'Default Overtime Salary Hairstylist',
                            'menu_active'       => 'default-hair-stylist',
                            'submenu_active'    => 'default-hair-stylist-overtime'
                        ];
                   $session = 'default-hair-stylist-overtime';
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
              
               $list = MyHelper::post('recruitment/hairstylist/be/group/overtime/default'.$page, $post)['result']??[];
               $val = array();
                foreach ($list as $value){
                    $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_default_overtimes'],$value['created_at']);
                    array_push($val,$value);
                }
                $data['data'] = $val;
                return view('recruitment::default_income.overtime.index',$data);
                  }
              public function default_create_overtime(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/overtime/default/create', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Overtime Create Success']);
                        } else{
                                return back()->withInput($request->input())->withErrors($query['messages']);
                        }
                   
              }
              public function default_delete_overtime($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/overtime/default/delete', ['id_hairstylist_group_default_overtimes'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_update_overtime(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/overtime/default/update', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                            return  redirect('recruitment/hair-stylist/default/overtime')->withSuccess(['Hair Stylist Group Overtime Update Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_detail_overtime($id)
            {
                 $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/overtime/default/detail',['id_hairstylist_group_default_overtimes'=>$id]);
                    if(isset($query['status']) && $query['status'] == 'success'){
                        $data = [ 
                                  'title'             => 'Default Hair Stylist Overtime',
                                   'sub_title'         => 'Detail Default Hair Stylist Overtime',
                                   'menu_active'       => 'default-hair-stylist',
                                   'submenu_active'    => 'default-hair-stylist-overtime'
                               ];
                        $data['result']=$query['result'];
                            return view('recruitment::default_income.overtime.update',$data);
                    } else{
                            return back()->withErrors($query['messages']);
                    }
                   
              }    
              //default insentif
            public function default_index_insentif(Request $request)
                {
                       $post = $request->all();
                 $url = $request->url();
                 $data = [ 
                            'title'             => 'Default Income Hair Stylist',
                            'sub_title'         => 'Default Incentive Salary Hairstylist',
                            'menu_active'       => 'default-hair-stylist',
                            'submenu_active'    => 'default-hair-stylist-insentif'
                        ];
                   $session = 'default-hair-stylist-insentif';
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
              
               $list = MyHelper::post('recruitment/hairstylist/be/group/insentif/default'.$page, $post);
               if(($list['status']??'')=='success'){
                    $val = array();
                    foreach ($list['result']['data'] as $value){
                        $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_default_insentifs'],$value['created_at']);
                        array_push($val,$value);
                    }
                   $data['data'] = $val;
                   $data['data_total']     = $list['result']['total'];
                   $data['data_per_page']   = $list['result']['from'];
                   $data['data_up_to']      = $list['result']['from'] + count($list['result']['data'])-1;
                   $data['data_paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
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
               $textreplace = array(
                            array(
                                'keyword'=>'value',
                                'message'=>'Value'
                            ), 
                            array(
                                'keyword'=>'total_attend',
                                'message'=>'Total of attendance at work'
                            ), 
                            array(
                                'keyword'=>'total_late',
                                'message'=>'Total of late at work'
                            ), 
                            array(
                                'keyword'=>'total_absen',
                                'message'=>'Total of unpaid leave at work'
                            ), 
                            array(
                                'keyword'=>'+',
                                'message'=>'Added'
                            ), 
                            array(
                                'keyword'=>'-',
                                'message'=>'Subtraction'
                            ), 
                            array(
                                'keyword'=>'*',
                                'message'=>'Multiplication'
                            ), 
                            array(
                                'keyword'=>'/',
                                'message'=>'Distribution'
                            ), 
                        );
               $data['textreplace'] = $textreplace;
                return view('recruitment::default_income.index',$data);
                  }
              public function default_create_insentif(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/default/create', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Incentive Create Success']);
                        } else{
                                return back()->withInput($request->input())->withErrors($query['messages']);
                        }
                   
              }
              public function default_delete_insentif($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/default/delete', ['id_hairstylist_group_default_insentifs'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_update_insentif(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/default/update', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                            return  redirect('recruitment/hair-stylist/default/insentif')->withSuccess(['Hair Stylist Group Incentive Update Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_detail_insentif($id)
            {
                 $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/default/detail',['id_hairstylist_group_default_insentifs'=>$id]);
                    if(isset($query['status']) && $query['status'] == 'success'){
                        $data = [ 
                                  'title'             => 'Default Hair Stylist Incentive',
                                   'sub_title'         => 'Detail Default Hair Stylist Incentive',
                                   'menu_active'       => 'default-hair-stylist',
                                   'submenu_active'    => 'default-hair-stylist-insentif'
                               ];
                        $data['result']=$query['result'];
                        $textreplace = array(
                            array(
                                'keyword'=>'value',
                                'message'=>'Value'
                            ), 
                            array(
                                'keyword'=>'total_attend',
                                'message'=>'Total of attendance at work'
                            ), 
                            array(
                                'keyword'=>'total_late',
                                'message'=>'Total of late at work'
                            ), 
                            array(
                                'keyword'=>'total_absen',
                                'message'=>'Total of unpaid leave at work'
                            ), 
                            array(
                                'keyword'=>'+',
                                'message'=>'Added'
                            ), 
                            array(
                                'keyword'=>'-',
                                'message'=>'Subtraction'
                            ), 
                            array(
                                'keyword'=>'*',
                                'message'=>'Multiplication'
                            ), 
                            array(
                                'keyword'=>'/',
                                'message'=>'Distribution'
                            ), 
                        );
                        $data['textreplace'] = $textreplace;
                            return view('recruitment::default_income.update',$data);
                    } else{
                            return back()->withErrors($query['messages']);
                    }
                   
              }
              
              //default_potongan
            public function default_index_potongan(Request $request)
                {
                       $post = $request->all();
                 $url = $request->url();
                 $data = [ 
                            'title'             => 'Default Income Hair Stylist',
                            'sub_title'         => 'Salary Cuts Default Hair Stylist',
                            'menu_active'       => 'default-hair-stylist',
                            'submenu_active'    => 'default-hair-stylist-potongan'
                        ];
                   $session = 'default-hair-stylist-potongan';
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
              
               $list = MyHelper::post('recruitment/hairstylist/be/group/potongan/default'.$page, $post);
               if(($list['status']??'')=='success'){
                    $val = array();
                    foreach ($list['result']['data'] as $value){
                        $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_default_potongans'],$value['created_at']);
                        array_push($val,$value);
                    }
                   $data['data'] = $val;
                   $data['data_total']     = $list['result']['total'];
                   $data['data_per_page']   = $list['result']['from'];
                   $data['data_up_to']      = $list['result']['from'] + count($list['result']['data'])-1;
                   $data['data_paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
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
               $textreplace = array(
                            array(
                                'keyword'=>'value',
                                'message'=>'Value'
                            ), 
                            array(
                                'keyword'=>'total_attend',
                                'message'=>'Total of attendance at work'
                            ), 
                            array(
                                'keyword'=>'total_late',
                                'message'=>'Total of late at work'
                            ), 
                            array(
                                'keyword'=>'total_absen',
                                'message'=>'Total of unpaid leave at work'
                            ), 
                            array(
                                'keyword'=>'+',
                                'message'=>'Added'
                            ), 
                            array(
                                'keyword'=>'-',
                                'message'=>'Subtraction'
                            ), 
                            array(
                                'keyword'=>'*',
                                'message'=>'Multiplication'
                            ), 
                            array(
                                'keyword'=>'/',
                                'message'=>'Distribution'
                            ), 
                        );
               $data['textreplace'] = $textreplace;
                return view('recruitment::default_income.potongan.index',$data);
                  }
              public function default_create_potongan(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/potongan/default/create', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Potongan Create Success']);
                        } else{
                                return back()->withInput($request->input())->withErrors($query['messages']);
                        }
                   
              }
              public function default_delete_potongan($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/potongan/default/delete', ['id_hairstylist_group_default_potongans'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_update_potongan(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/potongan/default/update', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                            return  redirect('recruitment/hair-stylist/default/potongan')->withSuccess(['Hair Stylist Group Potongan Update Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_detail_potongan($id)
            {
                 $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/potongan/default/detail',['id_hairstylist_group_default_potongans'=>$id]);
                    if(isset($query['status']) && $query['status'] == 'success'){
                        $data = [ 
                                  'title'             => 'Default Hair Stylist Potongan',
                                   'sub_title'         => 'Detail Default Hair Stylist Potongan',
                                   'menu_active'       => 'default-hair-stylist',
                                   'submenu_active'    => 'default-hair-stylist-potongan'
                               ];
                        $data['result']=$query['result'];
                        $textreplace = array(
                            array(
                                'keyword'=>'value',
                                'message'=>'Value'
                            ), 
                            array(
                                'keyword'=>'total_attend',
                                'message'=>'Total of attendance at work'
                            ), 
                            array(
                                'keyword'=>'total_late',
                                'message'=>'Total of late at work'
                            ), 
                            array(
                                'keyword'=>'total_absen',
                                'message'=>'Total of unpaid leave at work'
                            ),
                            array(
                                'keyword'=>'+',
                                'message'=>'Added'
                            ), 
                            array(
                                'keyword'=>'-',
                                'message'=>'Subtraction'
                            ), 
                            array(
                                'keyword'=>'*',
                                'message'=>'Multiplication'
                            ), 
                            array(
                                'keyword'=>'/',
                                'message'=>'Distribution'
                            ), 
                        );
                        $data['textreplace'] = $textreplace;
                        return view('recruitment::default_income.potongan.update',$data);
                    } else{
                        return back()->withErrors($query['messages']);
                    }
                   
              }
    public function setting_income(Request $request){
            $post = $request->except('_token');
            $data = [
                'title'          => 'Setting Income Hairstylist',
                'menu_active'    => 'setting-hs-income',
                'submenu_active'    => 'setting-hs-income',
            ];
           if($post){
            $query = MyHelper::post('setting/attendances_date_create', $post);;
            if(($query['status']??'')=='success'){
                return redirect('recruitment/hair-stylist/group/setting-income')->with('success',['Success update data']);
            }else{
                return redirect('recruitment/hair-stylist/group/setting-income')->withErrors([$query['message']]);
            }
        }else{
            $mid =  MyHelper::get('setting/hs-income-calculation-mid');
            if($mid){
                $data['mid'] = array(
                    'key' =>$mid['key'],
                    'value_text'=>json_decode($mid['value_text'])
                );
            }
            $end =  MyHelper::get('setting/hs-income-calculation-end');
            if($end){
                $data['end'] = array(
                    'key' =>$end['key'],
                    'value_text'=>json_decode($end['value_text'])
                );
            }
            $incentive = MyHelper::get('recruitment/hairstylist/be/group/setting_insentif')['result']??[];
            $list_potongan = array(array(
                'code'=>'product_commission',
                'name'=>'Product Commission'
            ));
            foreach($incentive as $value){
                $incen = array(
                    'code'=>'incentive_'.$value['code'],
                    'name'=>$value['name'],
                );
                array_push($list_potongan,$incen);
            }
            $potongan = MyHelper::get('recruitment/hairstylist/be/group/setting_potongan')['result']??[];
            foreach($potongan as $value){
                $incen = array(
                    'code'=>'salary_cut_'.$value['code'],
                    'name'=>$value['name'],
                );
                array_push($list_potongan,$incen);
            }
            $data['list'] = $list_potongan;
            $query = MyHelper::get('setting/attendances_date');
            $data['result'] = $query;
            $data['overtime'] = MyHelper::get('setting/overtime-hs');
            $data['proteksi'] =  MyHelper::get('setting/proteksi-hs')['value_text']??[];
            if($data['proteksi']){
           $data['proteksi'] = json_decode($data['proteksi'],true);
            }
            $data['date'] = MyHelper::get('setting/total-date-hs');
            return view('recruitment::group.setting', $data);
        }
        }
        public function setting_income_middle(Request $request)
              {
                 $post = $request->except('_token');
                 $query = MyHelper::post('setting/hs-income-calculation-mid-create', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Update Setting Success']);
                        } else{
                                return back()->withInput($request->input())->withErrors($query['messages']);
                        }
                   
              }
        public function setting_income_end(Request $request)
        {
           $post = $request->except('_token');
           $query = MyHelper::post('setting/hs-income-calculation-end-create', $post);
                  if(isset($query['status']) && $query['status'] == 'success'){
                          return back()->withSuccess(['Update Setting Success']);
                  } else{
                          return back()->withInput($request->input())->withErrors($query['messages']);
                  }

        }
        public function setting_overtime(Request $request){
            $post = $request->except('_token');
            $data = [
                'title'          => 'Setting Overtime Hairstylist',
                'menu_active'    => 'setting-hs-overtime',
                'submenu_active'    => 'setting-hs-overtime',
            ];
           if($post){
                $query = MyHelper::post('setting/overtime-hs-create', $post);
                  if(isset($query['status']) && $query['status'] == 'success'){
                          return back()->withSuccess(['Update Setting Success']);
                  } else{
                          return back()->withInput($request->input())->withErrors($query['messages']);
                  }
           }
            $data['result'] =  MyHelper::get('setting/overtime-hs');
            return view('recruitment::group.setting_overtime', $data);
        }
        public function setting_total_date(Request $request){
            $post = $request->except('_token');
           if($post){
                $query = MyHelper::post('setting/total-date-hs-create', $post);
                  if(isset($query['status']) && $query['status'] == 'success'){
                          return back()->withSuccess(['Update Setting Success']);
                  } else{
                          return back()->withInput($request->input())->withErrors($query['messages']);
                  }
           }
           return back()->withInput($request->input())->withErrors(['Incomplete Data']);
        }
        public function setting_proteksi(Request $request){
            $post = $request->except('_token');
            $data = [
                'title'          => 'Setting Proteksi Hairstylist',
                'menu_active'    => 'setting-hs-proteksi',
                'submenu_active'    => 'setting-hs-proteksi',
            ];
           if($post){
               $post['value'] = str_replace(',','', $post['value']??0);
                $query = MyHelper::post('setting/proteksi-hs-create', $post);
                  if(isset($query['status']) && $query['status'] == 'success'){
                          return back()->withSuccess(['Update Setting Success']);
                  } else{
                          return back()->withInput($request->input())->withErrors($query['messages']);
                  }
           }
            $data['result'] =  MyHelper::get('setting/proteksi-hs')['value_text']??[];
            if($data['result']){
            $data['result'] = json_decode($data['result'],true);
            }
            return view('recruitment::group.setting_proteksi', $data);
        }
        public function create_proteksi(Request $request){
            $post = $request->except('_token');
            $post['value'] = str_replace(',','', $post['value']??0);
            $query = MyHelper::post('recruitment/hairstylist/be/group/proteksi/create', $post);
            if(isset($query['status']) && $query['status'] == 'success'){
                    return back()->withSuccess(['Hair Stylist Group Proteksi Update Success']);
            } else{
                    return back()->withInput($request->input())->withErrors($query['messages']);
            }
        }
}
