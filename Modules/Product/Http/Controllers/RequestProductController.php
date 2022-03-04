<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Excel;
use Session;

class RequestProductController extends Controller
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
            'title'          => 'Request Product',
            'sub_title'      => 'List Request Product',
            'menu_active'    => 'request-product',
            'submenu_active' => 'list-request-product',
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

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Request Product',
            'sub_title'      => 'Create Request Product',
            'menu_active'    => 'request-product',
            'submenu_active' => 'create-request-product',
        ];

        $data['products'] = MyHelper::post('product/be/icount/list', [])['result'] ?? [];
        $data['outlets'] = MyHelper::get('mitra/request/outlet')['result'] ?? [];
        $data['conditions'] = "";
        
        return view('product::request_product.create', $data);

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        $result = MyHelper::post('req-product/create', $post);

        if(isset($result['status']) && $result['status'] == 'success'){
            return redirect('req-product')->withSuccess(['Success create a new request product']);
        }else{
            return redirect('req-product')->withErrors($result['messages'] ?? ['Failed create a new request product']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $result = MyHelper::post('req-product/detail', ['id_request_product' => $id]);
        $data = [
            'title'          => 'Request Product',
            'sub_title'      => 'Detail Request Product',
            'menu_active'    => 'request-product',
            'submenu_active' => 'list-request-product',
        ];
        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result']['request_product'];
            $data['products'] = MyHelper::post('product/be/icount/list', [])['result'] ?? [];
            $data['outlets'] = MyHelper::get('mitra/request/outlet')['result'] ?? [];
            $data['conditions'] = "";

            return view('product::request_product.detail', $data);
        }else{
            return redirect('req-product')->withErrors($result['messages'] ?? ['Failed get detail user mitra']);
        }
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
        $result = MyHelper::post('req-product/update', $post);

        if(isset($result['status']) && $result['status'] == 'success'){
            return redirect('req-product/detail/'.$post['id_request_product'])->withSuccess(['Success update request product']);
        }else{
            return redirect('req-product/detail/'.$post['id_request_product'])->withErrors($result['messages'] ?? ['Failed update request product']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = MyHelper::post("req-product/delete", ['id_request_product' => $id]);
        return $result;
    }

    public function createDelivery($id = null)
    {
        $data = [
            'title'          => 'Delivery Product',
            'sub_title'      => 'Create Delivery Product',
            'menu_active'    => 'delivery-product',
            'submenu_active' => 'create-delivery-product',
        ];

        if($id){
            $result = MyHelper::post('req-product/detail', ['id_request_product' => $id]);
            $data['result'] = $result['result']['request_product'] ?? [];
            $data['requests'] = MyHelper::post('req-product/all',['id_outlet' => $data['result']['id_outlet'],'type' => $data['result']['type']])['result'] ?? [];
        }else{
            $result = ['status' => 'success'];
            $data['result'] = [];
            $data['requests'] = MyHelper::get('req-product/all')['result'] ?? [];
        }

        if(isset($result['status']) && $result['status'] == 'success'){
            $post_product = [];
            if(isset($data['result']['id_request_product'])){
                if($data['result']['request_product_outlet']['location_outlet']['company_type']=='PT IMA'){
                    $company = 'ima';
                }elseif($data['result']['request_product_outlet']['location_outlet']['company_type']=='PT IMS'){
                    $company = 'ims';
                }
                $post_product['company_type'] = $company;
            }
            $data['products'] = MyHelper::post('product/be/icount/list', $post_product)['result'] ?? [];
            $data['outlets'] = MyHelper::get('mitra/request/outlet')['result'] ?? [];
            $data['conditions'] = "";

            return view('product::request_product.create_delivery', $data);
        }else{
            return redirect('req-product')->withErrors($result['messages'] ?? ['Failed get detail user mitra']);
        }
    }

    public function storeDelivery(Request $request)
    {
        $post = $request->except('_token');
        $result = MyHelper::post('dev-product/create', $post);
        if(isset($result['status']) && $result['status'] == 'success'){
            return redirect('dev-product/detail/'.$result['result']['id_delivery_product'])->withSuccess(['Success create delivery product']);
        }else{
            return redirect('dev-product')->withErrors($result['messages'] ?? ['Failed create delivery product']);
        }
    }

    public function indexDelivery(Request $request)
    {
        $rule = false;
        $post = $request->all();
        $data = [
            'title'          => 'Delivery Product',
            'sub_title'      => 'List Delivery Product',
            'menu_active'    => 'delivery-product',
            'submenu_active' => 'list-delivery-product',
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
            Session::forget('filter-list-delivery-product');
            $post['filter_type'] = 'today';
        }elseif(Session::has('filter-list-delivery-product') && !empty($post) && !isset($post['filter'])){
            $pageSession = 1;
            if(isset($post['page'])){
                $pageSession = $post['page'];
            }
            $post = Session::get('filter-list-delivery-product');
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

        $list = MyHelper::post('dev-product'.$page, $post);

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
            Session::put('filter-list-delivery-product',$post);
        }

        return view('product::request_product.list_dev', $data);
    }

    public function destroyDelivery($id)
    {
        $result = MyHelper::post("dev-product/delete", ['id_delivery_product' => $id]);
        return $result;
    }

    public function editDelivery($id)
    {
        $result = MyHelper::post('dev-product/detail', ['id_delivery_product' => $id]);

        $data = [
            'title'          => 'Delivery Product',
            'sub_title'      => 'Detail Delivery Product',
            'menu_active'    => 'delivery-product',
            'submenu_active' => 'list-delivery-product',
        ];
        if(isset($result['status']) && $result['status'] == 'success'){
            $data['result'] = $result['result']['delivery_product'];
            $data['outlets'] = MyHelper::get('mitra/request/outlet')['result'] ?? [];
            $post_product = [];
            if(isset($data['result']['id_delivery_product'])){
                if($data['result']['delivery_product_outlet']['location_outlet']['company_type']=='PT IMA'){
                    $company = 'ima';
                }elseif($data['result']['delivery_product_outlet']['location_outlet']['company_type']=='PT IMS'){
                    $company = 'ims';
                }
                $post_product['company_type'] = $company;
            }
            $data['products'] = MyHelper::post('product/be/icount/list', $post_product)['result'] ?? [];
            $data['requests'] = MyHelper::post('req-product/all',['id_outlet' => $data['result']['id_outlet'],'type' => $data['result']['type']])['result'] ?? [];
            $data['conditions'] = "";

            return view('product::request_product.detail_dev', $data);
        }else{
            return redirect('req-product')->withErrors($result['messages'] ?? ['Failed get detail user mitra']);
        }
    }

    public function updateDelivery(Request $request)
    {
        $request->validate([
            "delivery_date" => "required"
        ]);
        $post = $request->except('_token');
        $result = MyHelper::post('dev-product/update', $post);
        if(isset($post['status']) && $post['status'] == 'On Progress'){
            return $result;
        }
        if(isset($result['status']) && $result['status'] == 'success'){
            return redirect('dev-product/detail/'.$post['id_delivery_product'])->withSuccess(['Success update delivery product']);
        }else{
            return redirect('dev-product/detail/'.$post['id_delivery_product'])->withErrors($result['messages'] ?? ['Failed update delivery product']);
        }
    }

    public function getRequest(Request $request){
        
        $post = $request->except('_token');
        $request = MyHelper::post('req-product/all',$post)['result'] ?? [];
        return $request;
    }
}
