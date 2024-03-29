<?php

namespace Modules\ProductService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;


class ProductServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Product Service',
            'sub_title'      => 'List Product Service',
            'menu_active'    => 'product-service',
            'submenu_active' => 'product-service-list',
        ];

        $product = MyHelper::post('product-service', ['admin_list' => 1,'product_type' => 'service']);
        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }else {
            $data['product'] = [];
        }

        return view('productservice::index', $data);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    function detail(Request $request, $code) {
        $data = [
            'title'          => 'Product Service',
            'sub_title'      => 'Product Service Detail',
            'menu_active'    => 'product-service',
            'submenu_active' => 'product-service-list'
        ];

        $product = MyHelper::post('product-service', ['product_code' => $code, 'outlet_prices' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }else {
            return redirect('product-service/detail/'.$code)->withErrors($product['messages'] ?? ['Product not found']);
        }

        $post = $request->except('_token');

        if (empty($post) || (!isset($post['product_detail_visibility']) && !isset($post['product_price']) && isset($post['page']))) {
            $data['page'] = $post['page']??1;
            $dtDetail['id_product'] = $data['product'][0]['id_product'];
            $dtDetail['page'] = 1;
            $dtPrice['id_product'] = $data['product'][0]['id_product'];
            $dtPrice['page'] = 1;

            if(isset($post['type']) && $post['type'] == 'product_detail'){
                $dtDetail['page'] = $post['page'];
            }
            if(isset($post['type']) && $post['type'] == 'product_special_price'){
                $dtPrice['page'] = $post['page'];
            }

            $outlet = MyHelper::post('outlet/be/list/product-detail', $dtDetail);
            if (isset($outlet['status']) && $outlet['status'] == "success") {
                $data['outlet']          = $outlet['result']['data'];
                $data['outletTotal']     = $outlet['result']['total'];
                $data['outletPerPage']   = $outlet['result']['from'];
                $data['outletUpTo']      = $outlet['result']['from'] + count($outlet['result']['data'])-1;
                $data['outletPaginator'] = new LengthAwarePaginator($outlet['result']['data'], $outlet['result']['total'], $outlet['result']['per_page'], $outlet['result']['current_page'], ['path' => url()->current()]);
            }else{
                $data['outlet']          = [];
                $data['outletTotal']     = 0;
                $data['outletPerPage']   = 0;
                $data['outletUpTo']      = 0;
                $data['outletPaginator'] = false;
            }

            $outletsSpecialPrice = MyHelper::post('outlet/be/list/product-special-price', $dtPrice);
            if (isset($outletsSpecialPrice['status']) && $outletsSpecialPrice['status'] == "success") {
                $data['outletSpecialPrice']          = $outletsSpecialPrice['result']['data'];
                $data['outletSpecialPriceTotal']     = $outletsSpecialPrice['result']['total'];
                $data['outletSpecialPricePerPage']   = $outletsSpecialPrice['result']['from'];
                $data['outletSpecialPriceUpTo']      = $outletsSpecialPrice['result']['from'] + count($outletsSpecialPrice['result']['data'])-1;
                $data['outletSpecialPricePaginator'] = new LengthAwarePaginator($outletsSpecialPrice['result']['data'], $outletsSpecialPrice['result']['total'], $outletsSpecialPrice['result']['per_page'], $outletsSpecialPrice['result']['current_page'], ['path' => url()->current()]);
            }else{
                $data['outlet']          = [];
                $data['outletTotal']     = 0;
                $data['outletPerPage']   = 0;
                $data['outletSpecialPriceUpTo']      = 0;
                $data['outletSpecialPricePaginator'] = false;
            }

            $outletAll = MyHelper::post('outlet/be/list', ['admin' => 1, 'id_product' => $data['product'][0]['id_product']]);
            $data['outlet_all'] = [];
            if (isset($outletAll['status']) && $outletAll['status'] == 'success') {
                $data['outlet_all'] = $outletAll['result'];
            }

            $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
            $data['list_product_service_use'] = MyHelper::get('product-service/product-use/list')['result']??[];
            $data['product_uses'] = MyHelper::post('product/be/icount/list', ['type' => 'product_service'])['result'] ?? [];
            $data['product_uses_ima'] = MyHelper::post('product/be/icount/list', ['type' => 'service', 'buyable' => 'true', 'company_type' => 'ima'])['result'] ?? [];
            $data['product_uses_ims'] = MyHelper::post('product/be/icount/list', ['type' => 'service', 'buyable' => 'true', 'company_type' => 'ims'])['result'] ?? [];
            $data['product_icount_use_ima'] = $data['product'][0]['product_icount_use_ima'] ?? [];
            $data['product_icount_use_ims'] = $data['product'][0]['product_icount_use_ims'] ?? [];
            $data['product_hairstylist_category'] = array_column($data['product'][0]['product_hs_category']??[], 'id_hairstylist_category');
            $data['hairstylist_category'] = MyHelper::get('hairstylist/be/category')['result']??[];
            $commission = MyHelper::post('product/be/commission',['product_code' => $code])['result'] ?? [];
            if($commission){
                $data['commission'] = $commission;
                $data['commission']['status'] = 1;
            }else{
                $data['commission'] = [
                    'status' => 0,
                ];
            }
            $data['product_code'] = $code;
            return view('productservice::detail', $data);
        }
        else {

            if (isset($post['product_detail_visibility'])) {
                $save = MyHelper::post('product/detail/update', $post);
                return parent::redirect($save, 'Visibility setting has been updated.', 'product-service/detail/'.$code.'?page='.$post['page'].'&type='.$post['type'].'#outletsetting');
            }else if (isset($post['product_price'])) {
                $save = MyHelper::post('product/detail/update/price', $post);
                return parent::redirect($save, 'Product price setting has been updated.', 'product-service/detail/'.$code.'?page='.$post['page'].'&type='.$post['type'].'#outletpricesetting');
            }else{
                if (isset($post['photo'])) {
                    $post['photo'] = MyHelper::encodeImage($post['photo']);
                }

                if (isset($post['product_photo_detail'])) {
                    $post['product_photo_detail']      = MyHelper::encodeImage($post['product_photo_detail']);
                }

                $save = MyHelper::post('product/update', $post);
                return parent::redirect($save, 'Product service detail has been updated.', 'product-service/detail/'.$post['product_code']??$code.'#info');
            }
        }
    }

    function productUseUpdate(Request $request){
        $post = $request->except('_token');
        $is_true = false;
        if(!empty($post['product_icount_ima'])){
            $product_use_ima = [
                "product_icount" => $post['product_icount_ima'],
                "id_product" => $post['id_product'],
                "company_type" => 'ima'
            ];
            $store_icount_ima = MyHelper::post('product/pivot/update', $product_use_ima);
            if (isset($store_icount_ima['status']) && $store_icount_ima['status'] == "success") {
                $is_true = true;
            }else{
                $is_true = false;
            }
        }
        if(!empty($post['product_icount_ims'])){
            $product_use_ims = [
                "product_icount" => $post['product_icount_ims'],
                "id_product" => $post['id_product'],
                "company_type" => 'ims'
            ];
            $store_icount_ims = MyHelper::post('product/pivot/update', $product_use_ims);
            if (isset($store_icount_ims['status']) && $store_icount_ims['status'] == "success") {
                $is_true = true;
            }else{
                $is_true = false;
            }
        }

        if ($is_true) {
            return redirect(url()->previous().'#productuse')->with('success', ['Product use has been save.']);
        }
        else {
            return redirect(url()->previous().'#productuse')->witherrors(['Something went wrong. Please try again.']);
        }
        // return parent::redirect($save, 'Product use has been save.', 'product-service/detail/'.$post['product_code'].'#productuse');
    }

    public function visibility(Request $request, $key = null)
    {
        $visibility = strpos(url()->current(), 'visible');
        if($visibility <= 0){
            $visibility = 'Hidden';
        }else{
            $visibility = 'Visible';
        }
        $data = [
            'title'          => 'Product Service',
            'sub_title'      => $visibility.' Product Service List',
            'menu_active'    => 'product-service',
            'submenu_active' => 'product-service-list-'.lcfirst($visibility),
            'visibility'     => $visibility
        ];

        $post = $request->except('_token');
        if($key == null && empty($post)){
            Session::forget('idVisibility');
            Session::forget('idVisibility_allOutlet');
            Session::forget('idVisibility_allProduct');
        }

        if(isset($post['page'])){
            $page = $post['page'];
            unset($post['page']);
        }else{
            $page = null;
        }

        // Proses update visibility
        if ($post) {
            $ses = Session::get('idVisibility');
            if($ses){
                if(!$page) $page = 1;
                foreach ($ses as $key => $value1) {
                    foreach ($value1 as $i => $value2) {
                        foreach ($value2 as $j => $value) {
                            if($key == (int)$post['key'] && $i == (int)$page){
                            }else{
                                $post['id_visibility'][] = $value;
                            }
                        }
                    }
                }
            };
            if($visibility == 'Hidden'){
                $post['visibility'] = 'Visible';
            }else{
                $post['visibility'] = 'Hidden';
            }
            $save = MyHelper::post('product/update/visibility', $post);
            Session::forget('idVisibility');
            Session::forget('idVisibility_allOutlet');
            Session::forget('idVisibility_allProduct');
            if (isset($save['status']) && $save['status'] == "success") {
                return parent::redirect($save, 'Product service visibility has been updated.', 'product-service/'.strtolower($visibility).'/'.$post['key']);
            }else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }

                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }

        }

        $outlet = MyHelper::get('outlet/be/list');
        if (isset($outlet['status']) && $outlet['status'] == 'success') {
            $data['outlet'] = $outlet['result'];
        } elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
            return back()->witherrors([$outlet['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }

        if (!is_null($key)) {
            $data['key'] = $key;
        } else {
            $data['key'] = $data['outlet'][0]['id_outlet'];
        }

        if($page){
            $product = MyHelper::post('product-service?page='.$page, ['visibility' => $visibility, 'id_outlet' => $data['key'], 'pagination' => true]);
            $data['page'] = $page;
        }else{
            $product = MyHelper::post('product-service', ['visibility' => $visibility, 'id_outlet' => $data['key'], 'pagination' => true]);
            $data['page'] = 1;
        }

        if(Session::get('idVisibility')){
            $ses = Session::get('idVisibility');
            if(isset($ses[$data['key']]) && isset($ses[$data['key']][$data['page']])){
                $data['id_visibility'] = $ses[$data['key']][$data['page']];
            }else{
                $data['id_visibility'] = [];
            }
        }else{
            $data['id_visibility'] = [];
        }

        if(!empty(Session::get('idVisibility_allOutlet'))){
            $data['allOutlet'] = Session::get('idVisibility_allOutlet');
        }

        if(!empty(Session::get('idVisibility_allProduct'))){
            $ses = Session::get('idVisibility_allProduct');
            if(isset($ses[$data['key']]))
                $data['allProduct'] = $ses[$data['key']];
        }

        if (isset($product['status']) && $product['status'] == 'success') {
            $data['paginator'] = new LengthAwarePaginator($product['result']['data'], $product['result']['total'], $product['result']['per_page'], $product['result']['current_page'], ['path' => url()->current()]);
            $data['product'] = $product['result']['data'];
            $data['total'] = $product['result']['total'];
        } elseif (isset($product['status']) && $product['status'] == 'fail') {
            return back()->witherrors([$product['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }
        return view('productservice::visibility', $data);
    }

    public function positionAssign(Request $request) {
        $data = [
            'title'          => 'Manage Product Service Position',
            'sub_title'      => 'Assign Product Service Position',
            'menu_active'    => 'product-service',
            'submenu_active' => 'product-service-position'
        ];
        $product = MyHelper::post('product-service', ['admin_list' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }else {
            $data['product'] = [];
        }

        return view('productservice::position', $data);
    }

    public function positionAssignUpdate(Request $request){
        $post = $request->except('_token');
        if (!isset($post['product_ids'])) {
            return redirect('product-service/position/assign')->withErrors(['Data ID can not be empty'])->withInput();
        }
        $result = MyHelper::post('product/position/assign', $post);
        return parent::redirect($result, 'Position product service has been save.', 'product-service/position/assign');
    }
    function submitCommission(Request $request){
        $post = $request->except('_token');
        $save = MyHelper::post('product/be/commission/create', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('product-service/detail/'.$post['product_code'].'#commission')->with('success', ['Commission has been save.']);
        }
        else {
            return redirect('product-service/detail/'.$post['product_code'].'#commission')->witherrors(['Something went wrong. Please try again.']);
        }
    }

    public function deleteCommission($id, $id_commission){
        $delete = MyHelper::post('product/be/commission/delete',['id_product_commission_default_dynamic'=>$id_commission]);
        if(isset($delete['status']) && $delete['status'] == 'success'){
            return back()->withSuccess(['Success to delete dynamic rule']);
        }else{
            return back()->withErrors($query['messages']??'Failed to delete dynamic rule');
        }
    }   
}
