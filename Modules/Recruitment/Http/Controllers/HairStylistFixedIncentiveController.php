<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class HairStylistFixedIncentiveController extends Controller
{
    public function create_fixed_incentive(Request $request)
    {
       $post = $request->except('_token');
       $post['value'] = str_replace(',','', $post['value']??0);
       $data = array();
       foreach (array_filter($post['id_hairstylist_group_default_fixed_incentive_detail']) as $key => $value) {
           $b = array(
               'id_hairstylist_group_default_fixed_incentive_detail' => $value,
               'id_hairstylist_group' => $post['id_hairstylist_group'][$key],
               'value' => $post['value'][$key],
           );
            $query = MyHelper::post('recruitment/hairstylist/be/group/fixed-incentive/create', $b);
              if(isset($query['status']) && $query['status'] != 'success'){
                      return redirect(url()->previous().'#fixed')->withErrors($query['messages']);
              }
       }
         return redirect(url()->previous().'#fixed')->withSuccess(['Hair Stylist Group Fixed Incentive Update Success']);
    }
    
    //default_fixed_incentive 
    public function default_index(Request $request)
                {
                       $post = $request->all();
                 $url = $request->url();
                 $data = [ 
                            'title'             => 'Default Fixed Incentive Hair Stylist',
                            'sub_title'         => 'Default Fixed Incentive Salary Hairstylist',
                            'menu_active'       => 'default-hair-stylist',
                            'submenu_active'    => 'default-hair-stylist-fixed-incentive'
                        ];
                   $session = 'default-hair-stylist-fixed_incentive';
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
              
              $list = MyHelper::post('recruitment/hairstylist/be/group/fixed-incentive/default'.$page, $post)['result']??[];
               $val = array();
                foreach ($list as $value){
                    $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_group_default_fixed_incentive'],$value['created_at']);
                    array_push($val,$value);
                }
                 $data['data'] = $val;
                return view('recruitment::default_income.fixed_incentive.index',$data);
                  }
              public function default_create(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 if($post['type']=="Single"){
                    $post['formula'] = "monthly"; 
                 }
                 $query = MyHelper::post('recruitment/hairstylist/be/group/fixed-incentive/default/create', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Incentive Create Success']);
                        } else{
                                return back()->withInput($request->input())->withErrors($query['messages']);
                        }
                   
              }
              public function default_delete($id)
              {
                $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/fixed-incentive/default/delete', ['id_hairstylist_group_default_fixed_incentive'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_update(Request $request)
              {
                 $post = $request->except('_token');
                 if($post['type']=="Single"){
                    $post['formula'] = "monthly"; 
                 }
                 $query = MyHelper::post('recruitment/hairstylist/be/group/fixed-incentive/default/update', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                            return back()->withSuccess(['Hair Stylist Group Incentive Update Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
            public function default_detail($id)
            {
                 $id = MyHelper::explodeSlug($id)[0]??'';
                 $query = MyHelper::post('recruitment/hairstylist/be/group/fixed-incentive/default/detail',['id_hairstylist_group_default_fixed_incentive'=>$id]);
                    if(isset($query['status']) && $query['status'] == 'success'){
                        $data = [ 
                                  'title'             => 'Default Hair Stylist Fixed Incentive',
                                   'sub_title'         => 'Detail Default Hair Stylist Fixed Incentive',
                                   'menu_active'       => 'default-hair-stylist',
                                   'submenu_active'    => 'default-hair-stylist-fixed-incentive'
                               ];
                        $data['result']=$query['result'];
                        $data['detail'] = MyHelper::post('recruitment/hairstylist/be/group/fixed-incentive/default/detail/list',['id_hairstylist_group_default_fixed_incentive'=>$id])['result']??[];
                        return view('recruitment::default_income.fixed_incentive.update',$data);
                    } else{
                        return back()->withErrors($query['messages']);
                    }
                   
              }
            public function create_type1(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/fixed-incentive/default/type1', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Incentive Create Success']);
                        } else{
                                return back()->withInput($request->input())->withErrors($query['messages']);
                        }
                   
              }
            public function create_type2(Request $request)
              {
                 $post = $request->except('_token');
                 $post['value'] = str_replace(',','', $post['value']??0);
                 $query = MyHelper::post('recruitment/hairstylist/be/group/fixed-incentive/default/type2', $post);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Hair Stylist Group Incentive Create Success']);
                        } else{
                                return back()->withInput($request->input())->withErrors($query['messages']);
                        }
                   
              }
             public function delete_detail($id)
              {
                 $query = MyHelper::post('recruitment/hairstylist/be/group/fixed-incentive/default/detail/delete', ['id_hairstylist_group_default_fixed_incentive_detail'=>$id]);
                        if(isset($query['status']) && $query['status'] == 'success'){
                                return back()->withSuccess(['Delete Success']);
                        } else{
                                return back()->withErrors($query['messages']);
                        }
                   
              }
}
