<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;

class ProductCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $rule = false;
        $post = $request->all();
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Product Catalog',
            'menu_active'    => 'product',
            'submenu_active' => 'product-catalog',
            'child_active'   => 'product-catalog-list',
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
            Session::forget('filter-list-product-catalog');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-product-catalog') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-product-catalog');
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

        $list = MyHelper::post('product-catalog'.$page, $post);

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
            Session::put('filter-list-product-catalog',$post);
        }

        return view('product::catalog.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $post = $request->except('_token');
        if(!$post){
            $data = [
                'title'          => 'Product',
                'sub_title'      => 'Create Product Catalog',
                'menu_active'    => 'product',
                'submenu_active' => 'product-catalog',
                'child_active'   => 'product-catalog-create',
            ];
            $data['products'] = MyHelper::post('product/be/icount/list', ['buyable' => 'true'])['result'] ?? [];
    
            return view('product::catalog.create', $data);
        }else{
            $result = MyHelper::post('product-catalog/create', $post);

            if(isset($result['status']) && $result['status'] == 'success'){
                return redirect('product/catalog/detail/'.$result['result']['id_product_catalog'])->withSuccess(['Success create product catalog']);
            }else{
                return redirect('product/catalog')->withErrors($result['messages'] ?? ['Failed create product catalog']);
            }
        }

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $result = MyHelper::post('product-catalog/detail', ['id_product_catalog' => $id]);

        $data = [
            'title'          => 'Product',
            'sub_title'      => 'Detail Product Catalog',
            'menu_active'    => 'product',
            'submenu_active' => 'product-catalog',
            'child_active'   => 'product-catalog-list',
        ];

        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result']['product_catalog'];
            $data['outlets'] = MyHelper::get('mitra/request/outlet')['result'] ?? [];
            $post_product = ['buyable' => 'true'];
            $post_product['company_type'] = $data['result']['company_type'];
            $data['products'] = MyHelper::post('product/be/icount/list', $post_product)['result'] ?? [];
            $data['conditions'] = "";
            return view('product::catalog.detail', $data);
        }else{
            return redirect('product/catalog')->withErrors($result['messages'] ?? ['Failed get detail user mitra']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('product::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $post = $request->except('_token');
        $result = MyHelper::post('product-catalog/update', $post);

        if(isset($result['status']) && $result['status'] == 'success'){
            return redirect('product/catalog/detail/'.$post['id_product_catalog'])->withSuccess(['Success update product catalog']);
        }else{
            return redirect('product/catalog/detail/'.$post['id_product_catalog'])->withErrors($result['messages'] ?? ['Failed update product catalog']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = MyHelper::post("product-catalog/delete", ['id_product_catalog' => $id]);
        return $result;
    }
}
