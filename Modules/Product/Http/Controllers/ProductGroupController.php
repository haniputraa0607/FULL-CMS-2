<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class ProductGroupController extends Controller
{
    public function list(Request $request)
    {
    	$data = [
            'title'          => 'Product',
            'sub_title'      => 'List Product Group',
            'menu_active'    => 'product',
            'submenu_active' => 'product-group',
        ];

        $productGroup = MyHelper::get('product/product-group/list');

        if (($productGroup['status'] ?? false) != 'success') {
        	return view('product::product_group.list', [])->withErrors($productGroup['messages'] ?? ['Something went wrong']);
        }
        $data['product_group'] = $productGroup['result'] ?? [];

        return view('product::product_group.list', $data);
    }

    public function create(Request $request)
    {
    	$post = $request->except('_token');

        $create = MyHelper::post('product/product-group/create', $post);

     	if (($create['status'] ?? false) != 'success') {
        	return redirect('product/product-group')->withErrors($productGroup['messages'] ?? ['Something went wrong']);
        } else {
        	return redirect('product/product-group')->withSuccess(['Product Group has been created']);
        }
    }

    public function update(Request $request)
    {
    	$post = $request->except('_token');

        $update = MyHelper::post('product/product-group/update', $post);

     	if (($update['status'] ?? false) != 'success') {
        	return redirect('product/product-group')->withErrors($productGroup['messages'] ?? ['Something went wrong']);
        } else {
        	return redirect('product/product-group')->withSuccess(['Product Group has been updated']);
        }
    }

    public function delete(Request $request)
    {
    	$post = $request->except('_token');

        $delete = MyHelper::post('product/product-group/delete', $post);

     	if (($delete['status'] ?? false) != 'success') {
        	return ['status' => 'fail', 'messages' => $delete['messages'] ?? ['Something went wrong']];
        } else {
        	return ['status' => 'success'];
        }
    }
}
