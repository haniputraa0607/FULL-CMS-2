<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeLoanController extends Controller
{
  
    
    public function create_category(Request $request)
    {
        $post = $request->except('_token');
        $query = MyHelper::post('employee/loan/category/create', $post);
        if(isset($query['status']) && $query['status'] != 'success'){
                return redirect(url()->previous())->withErrors($query['messages']);
        }
         return redirect(url()->previous())->withSuccess(['Employee Loan Success']);
    }
    public function delete_category($id)
    {
      $id = MyHelper::explodeSlug($id)[0]??'';
       $query = MyHelper::post('employee/loan/category/delete', ['id_employee_category_loan'=>$id]);
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
                    'title'             => 'Loan Employee',
                    'sub_title'         => 'Category Loan Employee',
                    'menu_active'       => 'category-loan',
                    'child_active'      => 'category-loan'
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

       $list = MyHelper::post('employee/loan/category/list'.$page, $post)['result']??[];
       $val = array();
        foreach ($list as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_category_loan'],$value['created_at']);
            array_push($val,$value);
        }
         $data['data'] = $val;
        return view('employee::income.loan.category.index',$data);
          }
          
    //HS Loan
    public function index(Request $request)
    {
               $post = $request->all();
         $url = $request->url();
         $data = [ 
                    'title'             => 'Loan Employee',
                    'sub_title'         => 'Loan Employee',
                    'menu_active'       => 'employee-loan',
                    'child_active'    => 'employee-loan'
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
     $list = MyHelper::post('employee/loan'.$page, $post)['result']??[];
       $val = array();
        foreach ($list as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_loan'],$value['created_at']);
            array_push($val,$value);
        }
        $data['data'] = $val;
        $data['hs'] = MyHelper::post('employee/loan/hs'.$page, $post)['result']??[];
        $data['categorys'] = MyHelper::post('employee/loan/category/list'.$page, $post)['result']??[];
        return view('employee::income.loan.index',$data);
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
       $data['data'] = MyHelper::post('employee/loan',['id_employee_loan'=>$id])['result']??[];
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
        $query = MyHelper::post('employee/loan/create', $post);
        if(isset($query['status']) && $query['status'] != 'success'){
                return redirect(url()->previous().'#fixed')->withErrors($query['messages']);
        }
         return redirect(url()->previous())->withSuccess(['Loan Success']);
    }
    
    //sales payment
     public function index_sales(Request $request)
    {
         $post = $request->all();
         $url = $request->url();
         $data = [ 
                    'title'             => 'Sales Payment Employee',
                    'sub_title'         => 'Sales Payment Employee',
                    'menu_active'       => 'employee-loan-sales-payment',
                    'child_active'      => 'employee-loan-sales-payment',
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
    $list = MyHelper::post('employee/loan/sales'.$page, $post)['result']??[];
       $val = array();
        foreach ($list as $value){
            $value['id_enkripsi'] = MyHelper::createSlug($value['id_employee_sales_payment'],$value['created_at']);
            array_push($val,$value);
        }
        $data['data'] = $val;
        $data['hs'] = MyHelper::post('employee/loan/hs'.$page, $post)['result']??[];
        $data['categorys'] = MyHelper::post('employee/loan/category/list'.$page, $post)['result']??[];
        return view('employee::income.loan.index_sales',$data);
    }
     public function detail_sales($id)
    {
         $id = MyHelper::explodeSlug($id)[0]??'';
         $data = [ 
                    'title'             => 'Sales Payment Employee',
                    'sub_title'         => 'Detail Sales Payment Employee',
                    'menu_active'       => 'employee-loan-sales-payment',
                    'child_active'      => 'employee-loan-sales-payment',
                ];
         
        $list = MyHelper::post('employee/loan/sales/detail', ['id_employee_sales_payment'=>$id])['result']??[];
        $data['data'] = $list;
        $data['categorys'] = MyHelper::post('employee/loan/category/list',['id_employee_sales_payment'=>$id])['result']??[];
        return view('employee::income.loan.detail',$data);
    }
     public function create_sales(Request $request)
    {
         $post = $request->except('_token');
        $post['amount'] = str_replace(',','', $post['amount']??0);
        $post['effective_date'] = date('Y-m-d',strtotime($post['effective_date']));
        $query = MyHelper::post('employee/loan/sales/create', $post);
        if(isset($query['status']) && $query['status'] != 'success'){
                return redirect(url()->previous())->withErrors($query['messages']);
        }
         return redirect('employee/income/loan')->withSuccess(['Loan Success']);
    }
}
