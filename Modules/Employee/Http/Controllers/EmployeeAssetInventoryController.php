<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeAssetInventoryController extends Controller
{
  
    
    public function create_category(Request $request)
    {
        $post = $request->except('_token');
        $query = MyHelper::post('employee/be/asset-inventory/category/create', $post);
        if(isset($query['status']) && $query['status'] != 'success'){
                return redirect(url()->previous())->withErrors($query['messages']);
        }
         return redirect(url()->previous())->withSuccess(['Employee Loan Success']);
    }
    public function delete_category($id)
    {
      $id = MyHelper::explodeSlug($id)[0]??'';
       $query = MyHelper::post('employee/be/asset-inventory/category/delete', ['id_asset_inventory_category'=>$id]);
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
                    'title'             => 'Asset & Inventory Employee',
                    'sub_title'         => 'Category Asset & Inventory Employee',
                    'menu_active'       => 'category-asset-inventory',
                    'submenu_active'      => 'category-asset-inventory'
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

       $list = MyHelper::get('employee/be/asset-inventory/category'.$page, $post)['result']??[];
       $val = array();
        foreach ($list as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_asset_inventory_category'],date('Y-m-d H:i:s'));
            array_push($val,$value);
        }
         $data['data'] = $val;
        return view('employee::inventory.category.index',$data);
          }
          
    //HS Loan
    public function index(Request $request)
    {
               $post = $request->all();
         $url = $request->url();
         $data = [ 
                    'title'             => 'Asset & Inventory',
                    'sub_title'         => 'Asset & Inventory',
                    'menu_active'       => 'asset-inventory',
                    'submenu_active'    => 'asset-inventory'
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
    $list = MyHelper::post('employee/be/asset-inventory/list'.$page, $post)['result']??[];
       $val = array();
        foreach ($list as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_asset_inventory'],$value['created_at']);
            array_push($val,$value);
        }
        $data['list'] = $val;
        $data['categorys'] = MyHelper::get('employee/be/asset-inventory/category'.$page, $post)['result']??[];
        return view('employee::inventory.index',$data);
    }
    public function detail($id)
    {
       $id = MyHelper::explodeSlug($id)[0]??'';
         $data = [ 
                    'title'             => 'Loan Employee',
                    'sub_title'         => 'Category Loan Employee',
                    'menu_active'       => 'employee-loan',
                    'child_active'    => 'employee-loan'
                ];
       $data['data'] = MyHelper::post('employee/be/asset-inventory',['id_employee_loan'=>$id])['result']??[];
       if($data['data']){
        return view('employee::income.loan.update',$data);
       }
       return redirect('recruitment/hair-stylist/loan')->withErrors(['Loan not found']);
    }
    public function create(Request $request)
    {
        $post = $request->except('_token');
        $post['amount'] = str_replace(',','', $post['amount']??0);
        $post['effective_date'] = date('Y-m-d',strtotime($post['effective_date']));
        $query = MyHelper::post('employee/be/asset-inventory/create', $post);
        if(isset($query['status']) && $query['status'] != 'success'){
                return redirect(url()->previous().'#fixed')->withErrors($query['messages']);
        }
         return redirect(url()->previous())->withSuccess(['Hair Stylist Loan Success']);
    }
    public function delete($id)
    {
       $id = MyHelper::explodeSlug($id)[0]??'';
       return $query = MyHelper::post('employee/be/asset-inventory/delete', ['id_asset_inventory'=>$id]);
              if(isset($query['status']) && $query['status'] == 'success'){
                      return back()->withSuccess(['Delete Success']);
              } else{
                      return back()->withErrors($query['messages']);
              }
    }
    
    //loan
    public function index_loan(Request $request)
    {
               $post = $request->all();
         $url = $request->url();
         $data = [ 
                    'title'             => 'Asset & Inventory',
                    'sub_title'         => 'Loan Asset & Inventory',
                    'menu_active'       => 'asset-inventory-loan',
                    'child_active'    => 'asset-inventory-loan'
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
        $list = MyHelper::get('employee/be/asset-inventory/loan/list'.$page, $post)['result']??[];
       $val = array();
        foreach ($list as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_asset_inventory_log'],$value['created_at']);
            array_push($val,$value);
        }
        $data['list'] = $val;
        
        return view('employee::inventory.loan.index',$data);
    }
    public function index_loan_pending(Request $request)
    {
               $post = $request->all();
         $url = $request->url();
         $data = [ 
                    'title'             => 'Asset & Inventory',
                    'sub_title'         => 'Loan Asset & Inventory',
                    'menu_active'       => 'asset-inventory-loan-pending',
                    'child_active'    => 'asset-inventory-loan-pending'
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
        $list = MyHelper::get('employee/be/asset-inventory/loan/pending'.$page, $post)['result']??[];
       $val = array();
        foreach ($list as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_asset_inventory_log'],$value['created_at']);
            array_push($val,$value);
        }
        $data['list'] = $val;
        
        return view('employee::inventory.loan.index',$data);
    }
     public function detail_loan($id)
    {
       $id = MyHelper::explodeSlug($id)[0]??'';
         $data = [ 
                    'title'             => 'Asset & Inventory',
                    'sub_title'         => 'Detail Asset & Inventory',
                    'menu_active'       => 'asset-inventory-loan-pending',
                    'child_active'    => 'asset-inventory-loan-pending'
                ];
      $data['result'] = MyHelper::post('employee/be/asset-inventory/loan/detail',['id_asset_inventory_log'=>$id])['result']??[];
       if($data['result']){
        return view('employee::inventory.loan.detail',$data);
       }
       return back()->withErrors(['Loan not found']);
    }
    public function approve_loan(Request $request)
    {
         $post = $request->except('_token');
         if(!empty($post['attachment'])){
                $post['ext'] = pathinfo($post['attachment']->getClientOriginalName(), PATHINFO_EXTENSION);
                $post['attachment'] = MyHelper::encodeImage($post['attachment']);
            }
        $query = MyHelper::post('employee/be/asset-inventory/loan/approve', $post);
        if(isset($query['status']) && $query['status'] != 'success'){
                return back()->withErrors($query['messages']);
        }
         return redirect(url()->previous())->withSuccess(['Update Loan Assert & Inventoris Success']);
    }
    
    //index return
    public function index_return(Request $request)
    {
               $post = $request->all();
         $url = $request->url();
         $data = [ 
                    'title'             => 'Asset & Inventory',
                    'sub_title'         => 'Return Asset & Inventory',
                    'menu_active'       => 'asset-inventory-return',
                    'child_active'    => 'asset-inventory-return'
                ];
           $session = 'category-return';
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
        $list = MyHelper::get('employee/be/asset-inventory/return/list'.$page, $post)['result']??[];
       $val = array();
        foreach ($list as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_asset_inventory_log'],$value['created_at']);
            array_push($val,$value);
        }
        $data['list'] = $val;
        
        return view('employee::inventory.return.index',$data);
    }
    public function index_return_pending(Request $request)
    {
               $post = $request->all();
         $url = $request->url();
         $data = [ 
                    'title'             => 'Asset & Inventory',
                    'sub_title'         => 'Return Asset & Inventory',
                    'menu_active'       => 'asset-inventory-return-pending',
                    'child_active'    => 'asset-inventory-return-pending'
                ];
           $session = 'category-return';
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
        $list = MyHelper::get('employee/be/asset-inventory/return/pending'.$page, $post)['result']??[];
       $val = array();
        foreach ($list as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_asset_inventory_log'],$value['created_at']);
            array_push($val,$value);
        }
        $data['list'] = $val;
        
        return view('employee::inventory.return.index',$data);
    }
     public function detail_return($id)
    {
      $id = MyHelper::explodeSlug($id)[0]??'';
         $data = [ 
                    'title'             => 'Asset & Inventory',
                    'sub_title'         => 'Detail Asset & Inventory',
                    'menu_active'       => 'asset-inventory-return-pending',
                    'child_active'    => 'asset-inventory-return-pending'
                ];
      $data['result'] = MyHelper::post('employee/be/asset-inventory/return/detail',['id_asset_inventory_log'=>$id])['result']??[];
       if($data['result']){
        return view('employee::inventory.return.detail',$data);
       }
       return back()->withErrors(['Return not found']);
    }
    public function approve_return(Request $request)
    {
         $post = $request->except('_token');
         if(!empty($post['attachment'])){
                $post['ext'] = pathinfo($post['attachment']->getClientOriginalName(), PATHINFO_EXTENSION);
                $post['attachment'] = MyHelper::encodeImage($post['attachment']);
            }
        $query = MyHelper::post('employee/be/asset-inventory/return/approve', $post);
        if(isset($query['status']) && $query['status'] != 'success'){
                return back()->withErrors($query['messages']);
        }
         return redirect(url()->previous())->withSuccess(['Update Return Assert & Inventoris Success']);
    }
}
