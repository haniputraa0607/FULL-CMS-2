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
              
               $list = MyHelper::post('recruitment/hairstylist/be/group/'.$page, $post);
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
                 $id = MyHelper::explodeSlug($id)[0]??'';
                 $data = [ 
                                  'title'             => 'Hair Stylist Group',
                                  'sub_title'         => 'Detail Hair Stylist Group',
                                  'menu_active'       => 'hair-stylist-group',
                                  'submenu_active'    => 'list-hair-stylist-group'
                                ];
                $query = MyHelper::post('recruitment/hairstylist/be/group/detail',['id_hairstylist_group'=>$id]);
                if(isset($query['status']) && $query['status'] == 'success'){
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
                         $session3 = 'hair-stylist-group-filter-insentif';
                         $post3 = Session::get($session3);
                         $post3['id_hairstylist_group'] = $id;
                         $data['filter_insentif'] = $post3;
                          $list3 = MyHelper::post('recruitment/hairstylist/be/group/insentif'.$page,$post3)??[];
                          if(($list3['status']??'')=='success'){
                              $val1 = array();
                                foreach ($list3['result']['data'] as $value){
                                    $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_insentif'],date('Y-m-d H:i:s'));
                                    array_push($val1,$value);
                                }  
                           $data['insentif']['data'] = $val1;
                           $data['insentif']['data_total']     = $list3['result']['total'];
                           $data['insentif']['data_per_page']   = $list3['result']['from'];
                           $data['insentif']['data_up_to']      = $list3['result']['from'] + count($list['result']['data'])-1;
                           $data['insentif']['data_paginator'] = new LengthAwarePaginator($list3['result']['data'], $list3['result']['total'], $list3['result']['per_page'], $list3['result']['current_page'], ['path' => url()->current()]);
                       }else{
                           $data['insentif']['data']          = [];
                           $data['insentif']['data_total']     = 0;
                           $data['insentif']['data_per_page']   = 0;
                           $data['insentif']['data_up_to']      = 0;
                           $data['insentif']['data_paginator'] = false;
                       }
                         $session4 = 'hair-stylist-group-filter-potongan';
                         $post4 = Session::get($session4);
                         $post4['id_hairstylist_group'] = $id;
                         $data['filter_potongan'] = $post4;
                          $list4 = MyHelper::post('recruitment/hairstylist/be/group/potongan'.$page,$post4)??[];
                          if(($list4['status']??'')=='success'){
                              $val2 = array();
                                foreach ($list4['result']['data'] as $value){
                                    $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_potongan'],date('Y-m-d H:i:s'));
                                    array_push($val2,$value);
                                }  
                           $data['potongan']['data'] = $val2;
                           $data['potongan']['data_total']     = $list4['result']['total'];
                           $data['potongan']['data_per_page']   = $list4['result']['from'];
                           $data['potongan']['data_up_to']      = $list4['result']['from'] + count($list['result']['data'])-1;
                           $data['potongan']['data_paginator'] = new LengthAwarePaginator($list4['result']['data'], $list4['result']['total'], $list4['result']['per_page'], $list4['result']['current_page'], ['path' => url()->current()]);
                       }else{
                           $data['potongan']['data']          = [];
                           $data['potongan']['data_total']     = 0;
                           $data['potongan']['data_per_page']   = 0;
                           $data['potongan']['data_up_to']      = 0;
                           $data['potongan']['data_paginator'] = false;
                       }
                        $data['lisths'] = MyHelper::post('recruitment/hairstylist/be/group/hs',['id_hairstylist_group'=>$id])??[];
                        $list_insentif = MyHelper::post('recruitment/hairstylist/be/group/insentif/list_insentif',['id_hairstylist_group'=>$id]);
                        $data['list_insentif'] = $list_insentif['result']??[];
                        //list rumus insentif
                         $post5['id_hairstylist_group'] = $id;
                         $list5 = MyHelper::post('recruitment/hairstylist/be/group/insentif/list-rumus-insentif',$post5)??[];
                         $val5 = array();
                            foreach ($list5['result'] as $value){
                                $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_insentif_rumus'],date('Y-m-d H:i:s'));
                                array_push($val5,$value);
                            }  
                         $data['list_rumus_insentif'] = $val5;
                         $data['rumus_insentif'] = '';
                         $i = 0;
                         foreach ($data['list_rumus_insentif'] as $value) {
                             if($i==0){
                             $b[] = '('.$value['name_insentif']. ' * Jumlah '.$value['name_insentif'].')';
                              $data['rumus_insentif'] = implode(' ',$b);
                             }else{
                                 $b[] = '+ ('.$value['name_insentif']. ' * Jumlah '.$value['name_insentif'].')';
                                  $data['rumus_insentif'] =  implode(' ',$b);
                             }
                             $i++;
                         }
                         
                         $list_potongan = MyHelper::post('recruitment/hairstylist/be/group/potongan/list_potongan',['id_hairstylist_group'=>$id]);
                        $data['list_potongan'] = $list_potongan['result']??[];
                        //list rumus Potongan
                         $post6['id_hairstylist_group'] = $id;
                         $list6 = MyHelper::post('recruitment/hairstylist/be/group/potongan/list-rumus-potongan',$post6)??[];
                         $val6 = array();
                            foreach ($list6['result'] as $value){
                                $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_potongan_rumus'],date('Y-m-d H:i:s'));
                                array_push($val6,$value);
                            }  
                         $data['list_rumus_potongan'] = $val6;
                         $data['rumus_potongan'] = '';
                         $i = 0;
                         foreach ($data['list_rumus_potongan'] as $value) {
                             if($i==0){
                             $c[] = '('.$value['name_potongan']. ' * Jumlah '.$value['name_potongan'].')';
                              $data['rumus_potongan'] = implode(' ',$c);
                             }else{
                                 $c[] = '+ ('.$value['name_potongan']. ' * Jumlah '.$value['name_potongan'].')';
                                  $data['rumus_potongan'] =  implode(' ',$c);
                             }
                             $i++;
                         }
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
                 $query = MyHelper::post('recruitment/hairstylist/be/group/update_commission', $post);
                 
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
                                  'submenu_active'    => 'detail-hair-stylist-group-commission'
                                ];
                          $data['result']=$query['result'];
                            return view('recruitment::group.update',$data);
                    } else{
                            return back()->withErrors($query['messages']);
                    }
                   
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
               return back();
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
                 $post['price_insentif'] = str_replace(',','', $post['price_insentif']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/create', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Insentif Create Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
              public function delete_insentif($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/delete', ['id_hairstylist_group_insentif'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Insentif Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
           public function create_rumus_insentif(Request $request)
              {
                 $post = $request->except('_token');
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/create-rumus-insentif', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Rumus Hair Stylist Group Insentif Create Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
           public function delete_rumus_insentif($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/delete-rumus-insentif', ['id_hairstylist_group_insentif_rumus'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Rumus Hair Stylist Group Insentif Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function update_insentif(Request $request)
              {
                 $post = $request->except('_token');
                 $post['price_insentif'] = str_replace(',','', $post['price_insentif']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/insentif/update', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                             $id_enkripsi = MyHelper::createSlug($query['result']['id_hairstylist_group'],date('Y-m-d H:i:s'));
                                return  redirect('recruitment/hair-stylist/group/detail/'.$id_enkripsi)->withSuccess(['Hair Stylist Group Insentif Update Success']);
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
                                  'sub_title'         => 'Detail Hair Stylist Group Insentif',
                                  'menu_active'       => 'hair-stylist-group',
                                  'submenu_active'    => 'detail-hair-stylist-group-insentif'
                                ];
                          $data['result']=$query['result'];
                            return view('recruitment::group.update_insentif',$data);
                    } else{
                            return back()->withErrors($query['messages']);
                    }
                   
              }
           public function create_potongan(Request $request)
              {
                 $post = $request->except('_token');
                 $post['price_potongan'] = str_replace(',','', $post['price_potongan']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/potongan/create', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Insentif Create Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function update_potongan(Request $request)
              {
                 $post = $request->except('_token');
                 $post['price_potongan'] = str_replace(',','', $post['price_potongan']??0);
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
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/potongan/delete', ['id_hairstylist_group_potongan'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Potongan Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
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

}
