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
            public function index(Request $request)
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
            public function detail($id)
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
                        return view('recruitment::group.detail',$data);
                } else{
                        return back()->withErrors($query['messages']);
                }
              }

}
