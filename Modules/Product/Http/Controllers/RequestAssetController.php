<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Excel;
use Session;

class RequestAssetController extends Controller
{
    public function create(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Request Asset',
            'sub_title'      => 'Create Request Asset',
            'menu_active'    => 'request-asset',
            'submenu_active' => 'create-request-asset',
        ];
        
        $data['outlets'] = MyHelper::get('mitra/request/outlet')['result'] ?? [];
        $data['offices'] = MyHelper::get('mitra/request/office')['result'] ?? [];
        $data['outlets'] = array_merge($data['outlets'],$data['offices']);
        $data['catalogs'] = MyHelper::post('req-product/list-catalog', ['company' => 'ima']);
        $data['conditions'] = "";

        return view('product::request_product.create_asset', $data);

    }
    
    public function store(Request $request)
    {
        $post = $request->except('_token');
        $post['from'] = 'Asset';
        $result = MyHelper::post('req-product/create', $post);
        
        if(isset($result['status']) && $result['status'] == 'success'){
            return redirect('req-asset/detail/'.$result['result']['id_request_product'])->withSuccess(['Success create a new request asset']);
        }else{
            return redirect('req-asset')->withErrors($result['messages'] ?? ['Failed create a new request asset']);
        }
    }

    public function index(Request $request)
    {
        $rule = false;
        $post = $request->all();
        $data = [
            'title'          => 'Request Asset',
            'sub_title'      => 'List Request Asset',
            'menu_active'    => 'request-asset',
            'submenu_active' => 'list-request-assets',
            'from'           => 'Asset'
        ];
        
        $order = 'created_at';
        $orderType = 'desc';
        $sorting = 0;
        if(isset($post['sorting'])){
            $sorting = 1;
            $order = $post['order'];
            $orderType = $post['order_type'];
        }
        if(isset($post['reset']) && $post['reset'] == 1){
            Session::forget('filter-list-request-product');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-request-product') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-request-product');
            $post['page'] = $pageSession;
            if($sorting == 0 && !empty($post['order'])){
                $order = $post['order'];
                $orderType = $post['order_type'];
            }
        }
        $page = '?page=1';
        if(isset($post['page'])){
            $page = '?page='.$post['page'];
        }
        $data['order'] = $order;
        $data['order_type'] = $orderType;
        $post['order'] = $order;
        $post['order_type'] = $orderType;
        $post['from'] = 'Asset';

        $list = MyHelper::post('req-product'.$page, $post);

        if(($list['status']??'')=='success'){
            $data['data']          = $list['result']['data'];
            $data['data_total']     = $list['result']['total'];
            $data['data_per_page']   = $list['result']['from'];
            $data['data_up_to']      = $list['result']['from'] + count($list['result']['data'])-1;
            $data['data_paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
            $data['rule'] = $rule;
        }else{
            $data['data']          = [];
            $data['data_total']     = 0;
            $data['data_per_page']   = 0;
            $data['data_up_to']      = 0;
            $data['data_paginator'] = false;
            $data['rule'] = false;
        }

        if($post){
            Session::put('filter-list-request-product',$post);
        }
        
        return view('product::request_product.list', $data);
    }

    public function edit($id)
    {
        $result = MyHelper::post('req-product/detail', ['id_request_product' => $id]);

        $data = [
            'title'          => 'Request Asset',
            'sub_title'      => 'Detail Request Asset',
            'menu_active'    => 'request-asset',
            'submenu_active' => 'list-request-assets',
            'from'           => 'Asset',
            'form_update'    => url('req-asset/update'),
        ];
        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result']['request_product'];
            $post_product = ['buyable' => 'true','catalog' => $data['result']['id_product_catalog'], 'company_type' => 'ima','from' => 'Assets'];
        
            $data['products'] = MyHelper::post('product/be/icount/list', $post_product) ?? [];
            $data['outlets'] = MyHelper::get('mitra/request/outlet')['result'] ?? [];
            $data['offices'] = MyHelper::get('mitra/request/office')['result'] ?? [];
            $data['outlets'] = array_merge($data['outlets'],$data['offices']);
            $data['conditions'] = "";

            return view('product::request_product.detail', $data);
        }else{
            return redirect('req-asset')->withErrors($result['messages'] ?? ['Failed get detail user mitra']);
        }
    }

    public function update(Request $request)
    {
        $post = $request->except('_token');
        $post['from'] = 'Asset';
        $result = MyHelper::post('req-product/update', $post);
        if(isset($post['status']) && $post['status']=='Draft'){
            return $result;
        }

        if(isset($result['status']) && $result['status'] == 'success'){
            return redirect('req-asset/detail/'.$post['id_request_product'])->withSuccess(['Success update request product']);
        }else{
            return redirect('req-asset/detail/'.$post['id_request_product'])->withErrors($result['messages'] ?? ['Failed update request product']);
        }
    }

}
