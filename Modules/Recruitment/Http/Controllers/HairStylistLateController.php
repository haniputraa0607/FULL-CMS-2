<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class HairStylistLateController extends Controller
{
           
              
              //default_late 
              public function default_index_late(Request $request)
                {
                       $post = $request->all();
                 $url = $request->url();
                 $data = [ 
                            'title'             => 'Default Late Hair Stylist',
                            'sub_title'         => 'Default Late Salary Hairstylist',
                            'menu_active'       => 'default-hair-stylist',
                            'submenu_active'    => 'default-hair-stylist-late'
                        ];
                   $session = 'default-hair-stylist-late';
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
              
               $list = MyHelper::post('recruitment/hairstylist/be/group/late/default'.$page, $post)['result']??[];
               $val = array();
                foreach ($list as $value){
                    $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_default_late'],$value['created_at']);
                    array_push($val,$value);
                }
                $data['data'] = $val;
                return view('recruitment::default_income.late.index',$data);
                  }
              public function default_create_late(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/late/default/create', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Late Create Success']);
                        } else{
                                return back()->withInput($request->input())->withErrors($query['messages']);
                        }
                   
              }
              public function default_delete_late($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/late/default/delete', ['id_hairstylist_group_default_late'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_update_late(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/late/default/update', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                            return  redirect('recruitment/hair-stylist/default/late')->withSuccess(['Hair Stylist Group Late Update Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_detail_late($id)
            {
                 $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/late/default/detail',['id_hairstylist_group_default_late'=>$id]);
                    if(isset($query['status']) && $query['status'] == 'success'){
                        $data = [ 
                                  'title'             => 'Default Hair Stylist Late',
                                   'sub_title'         => 'Detail Default Hair Stylist Late',
                                   'menu_active'       => 'default-hair-stylist',
                                   'submenu_active'    => 'default-hair-stylist-late'
                               ];
                        $data['result']=$query['result'];
                            return view('recruitment::default_income.late.update',$data);
                    } else{
                            return back()->withErrors($query['messages']);
                    }
                   
              }    
              
}
