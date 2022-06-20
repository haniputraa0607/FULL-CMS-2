<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class HairStylistLoanController extends Controller
{
    public function create_category(Request $request)
    {
        $post = $request->except('_token');
        $query = MyHelper::post('recruitment/hairstylist/be/loan/category/create', $post);
        if(isset($query['status']) && $query['status'] != 'success'){
                return redirect(url()->previous().'#fixed')->withErrors($query['messages']);
        }
         return redirect(url()->previous())->withSuccess(['Hair Stylist Loan Success']);
    }
    public function delete_category($id)
    {
      $id = MyHelper::explodeSlug($id)[0]??'';
       $query = MyHelper::post('recruitment/hairstylist/be/loan/category/delete', ['id_hairstylist_category_loan'=>$id]);
              if(isset($query['status']) && $query['status'] == 'success'){
                      return back()->withSuccess(['Delete Success']);
              } else{
                      return back()->withErrors($query['messages']);
              }

    }
    public function index_category(Request $request)
    {
               $post = $request->all();
         $url = $request->url();
         $data = [ 
                    'title'             => 'Loan Hairstylist',
                    'sub_title'         => 'Category Loan Hairstylist',
                    'menu_active'       => 'category-loan',
                    'submenu_active'    => 'category-loan'
                ];
           $session = 'category-loan';
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

       $list = MyHelper::post('recruitment/hairstylist/be/loan/category/list'.$page, $post)['result']??[];
       $val = array();
        foreach ($list as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_category_loan'],$value['created_at']);
            array_push($val,$value);
        }
         $data['data'] = $val;
        return view('recruitment::loan.category.index',$data);
          }
          
    //HS Loan
    public function index(Request $request)
    {
               $post = $request->all();
         $url = $request->url();
         $data = [ 
                    'title'             => 'Loan Hairstylist',
                    'sub_title'         => 'Category Loan Hairstylist',
                    'menu_active'       => 'hs-loan',
                    'submenu_active'    => 'hs-loan'
                ];
           $session = 'category-loan';
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
       $list = MyHelper::post('recruitment/hairstylist/be/loan'.$page, $post)['result']??[];
       $val = array();
        foreach ($list as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_hairstylist_loan'],$value['created_at']);
            array_push($val,$value);
        }
        $data['data'] = $val;
         $data['hs'] = MyHelper::post('recruitment/hairstylist/be/loan/hs'.$page, $post)['result']??[];
         $data['categorys'] = MyHelper::post('recruitment/hairstylist/be/loan/category/list'.$page, $post)['result']??[];
        return view('recruitment::loan.index',$data);
    }
    public function detail($id)
    {
       $id = MyHelper::explodeSlug($id)[0]??'';
         $data = [ 
                    'title'             => 'Loan Hairstylist',
                    'sub_title'         => 'Category Loan Hairstylist',
                    'menu_active'       => 'hs-loan',
                    'submenu_active'    => 'hs-loan'
                ];
       $data['data'] = MyHelper::post('recruitment/hairstylist/be/loan',['id_hairstylist_loan'=>$id])['result']??[];
       if($data['data']){
        return view('recruitment::loan.update',$data);
       }
       return redirect('recruitment/hair-stylist/loan')->withErrors(['Loan not found']);
    }
    public function create(Request $request)
    {
        $post = $request->except('_token');
        $post['amount'] = str_replace(',','', $post['amount']??0);
        $post['effective_date'] = date('Y-m-d',strtotime($post['effective_date']));
        $query = MyHelper::post('recruitment/hairstylist/be/loan/create', $post);
        if(isset($query['status']) && $query['status'] != 'success'){
                return redirect(url()->previous().'#fixed')->withErrors($query['messages']);
        }
         return redirect(url()->previous())->withSuccess(['Hair Stylist Loan Success']);
    }
}
