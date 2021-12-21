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
            public function indexold(Request $request)
              {
                 $data = [ 'title'             => 'List Hair Stylist Group',
                           'menu_active'       => 'hair-stylist-group',
                           'submenu_active'    => 'list-hair-stylist-group'
                        ];
                $query = MyHelper::get('recruitment/hairstylist/be/group/');
                if(isset($query['status']) && $query['status'] == 'success'){
                       $val = array();
                       foreach ($query['result'] as $value){
                           $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group'],$value['created_at']);
                           array_push($val,$value);
                       }
                       $data['data'] = $val;
                        return view('recruitment::group.list',$data);
                } else{
                        return back()->withErrors($query['messages']);
                }
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
                        $data['lisths'] = MyHelper::post('recruitment/hairstylist/be/group/hs',['id_hairstylist_group'=>$id])??[];
//                        return $data;
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

}
