<?php

namespace Modules\Academy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Session;

class ProductAcademyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Product Academy',
            'sub_title'      => 'List Product Academy',
            'menu_active'    => 'academy',
            'submenu_active' => 'product-academy-list',
        ];

        $product = MyHelper::post('academy/product', ['admin_list' => 1]);
        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }else {
            $data['product'] = [];
        }

        return view('academy::product.index', $data);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    function detail(Request $request, $code) {
        $data = [
            'title'          => 'Product Academy',
            'sub_title'      => 'Product Academy Detail',
            'menu_active'    => 'academy',
            'submenu_active' => 'product-academy-list'
        ];

        $product = MyHelper::post('academy/product', ['product_code' => $code, 'outlet_prices' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }else {
            return redirect('product-academy/detail/'.$code)->withErrors($product['messages'] ?? ['Product not found']);
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

            $dtDetail['outlet_academy_status'] = 1;
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

            $dtPrice['outlet_academy_status'] = 1;
            $outletsSpecialPrice = MyHelper::post('outlet/be/list/product-special-price', $dtPrice);
            if (isset($outletsSpecialPrice['status']) && $outletsSpecialPrice['status'] == "success") {
                $data['outletSpecialPrice']          = $outletsSpecialPrice['result']['data'];
                $data['outletSpecialPriceTotal']     = $outletsSpecialPrice['result']['total'];
                $data['outletSpecialPricePerPage']   = $outletsSpecialPrice['result']['from'];
                $data['outletSpecialPriceUpTo']      = $outletsSpecialPrice['result']['from'] + count($outletsSpecialPrice['result']['data'])-1;
                $data['outletSpecialPricePaginator'] = new LengthAwarePaginator($outletsSpecialPrice['result']['data'], $outletsSpecialPrice['result']['total'], $outletsSpecialPrice['result']['per_page'], $outletsSpecialPrice['result']['current_page'], ['path' => url()->current()]);
            }else{
                $data['outletSpecialPrice']          = [];
                $data['outletSpecialPriceTotal']     = 0;
                $data['outletSpecialPricePerPage']   = 0;
                $data['outletSpecialPriceUpTo']      = 0;
                $data['outletSpecialPricePaginator'] = false;
            }

            $outletAll = MyHelper::post('outlet/be/list', ['outlet_academy_status' => 1, 'admin' => 1, 'id_product' => $data['product'][0]['id_product']]);
            $data['outlet_all'] = [];
            if (isset($outletAll['status']) && $outletAll['status'] == 'success') {
                $data['outlet_all'] = $outletAll['result'];
            }
            $data['product_uses'] = MyHelper::post('product/be/icount/list', [])['result'] ?? [];
            $data['product_icount_use'] = $data['product'][0]['product_icount_use'] ?? [];
            $data['product_academy_theory'] = $data['product'][0]['product_academy_theory'] ?? [];
            $data['list_theory'] = MyHelper::get('theory')['result']??[];

            return view('academy::product.detail', $data);
        }
        else {
            if (isset($post['product_detail_visibility'])) {
                $save = MyHelper::post('product/detail/update', $post);
                return parent::redirect($save, 'Visibility setting has been updated.', 'product-academy/detail/'.$code.'?page='.$post['page'].'&type='.$post['type'].'#outletsetting');
            }else if (isset($post['product_price'])) {
                $save = MyHelper::post('product/detail/update/price', $post);
                return parent::redirect($save, 'Product price setting has been updated.', 'product-academy/detail/'.$code.'?page='.$post['page'].'&type='.$post['type'].'#outletpricesetting');
            }else{
                if (isset($post['photo'])) {
                    $post['photo'] = MyHelper::encodeImage($post['photo']);
                }

                if (isset($post['product_photo_detail'])) {
                    $post['product_photo_detail']      = MyHelper::encodeImage($post['product_photo_detail']);
                }

                $save = MyHelper::post('product/update', $post);
                return parent::redirect($save, 'Product service detail has been updated.', 'product-academy/detail/'.$post['product_code']??$code.'#info');
            }
        }
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
            'title'          => 'Product Academy',
            'sub_title'      => $visibility.' Product Academy List',
            'menu_active'    => 'academy',
            'submenu_active' => 'product-academy-list-'.lcfirst($visibility),
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
                return parent::redirect($save, 'Product academy visibility has been updated.', 'product-service/'.strtolower($visibility).'/'.$post['key']);
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

        $outlet = MyHelper::post('outlet/be/list', ['admin' =>  1, 'outlet_academy_status' => 1]);
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
            $product = MyHelper::post('academy/product?page='.$page, ['visibility' => $visibility, 'id_outlet' => $data['key'], 'pagination' => true]);
            $data['page'] = $page;
        }else{
            $product = MyHelper::post('academy/product', ['visibility' => $visibility, 'id_outlet' => $data['key'], 'pagination' => true]);
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
        return view('academy::product.visibility', $data);
    }

    public function positionAssign(Request $request) {
        $data = [
            'title'          => 'Manage Product Academy Position',
            'sub_title'      => 'Assign Product Academy Position',
            'menu_active'    => 'academy',
            'submenu_active' => 'product-academy-position'
        ];
        $product = MyHelper::post('academy/product', ['admin_list' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }else {
            $data['product'] = [];
        }

        return view('academy::product.position', $data);
    }

    public function positionAssignUpdate(Request $request){
        $post = $request->except('_token');
        if (!isset($post['product_ids'])) {
            return redirect('product-academy/position/assign')->withErrors(['Data ID can not be empty'])->withInput();
        }
        $result = MyHelper::post('product/position/assign', $post);
        return parent::redirect($result, 'Position product academy has been save.', 'product-academy/position/assign');
    }

    public function theoryUpdate(Request $request){
        $post = $request->except('_token');

        if(!empty($post['id_product'])){
            $result = MyHelper::post('academy/product/theory/save', $post);
            if(!empty($result['status']) && $result['status'] == 'success'){
                return redirect('product-academy/detail/'.$post['product_code'].'#theory')->withSuccess(['Success save data']);
            }else{
                return redirect('product-academy/detail/'.$post['product_code'].'#theory')->withErrors(['Failed save data theory']);
            }
        }else{
            return redirect('product-academy/detail/'.$post['product_code'].'#theory')->withErrors(['Something went wrong']);
        }
    }
}
