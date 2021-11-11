<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

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

    	if (isset($post['photo'])) {
            $post['photo'] = MyHelper::encodeImage($post['photo']);
        }

        $create = MyHelper::post('product/product-group/create', $post);

     	if (($create['status'] ?? false) != 'success') {
        	return redirect('product/product-group')->withErrors($create['messages'] ?? ['Something went wrong']);
        } else {
        	return redirect('product/product-group')->withSuccess(['Product Group has been created']);
        }
    }

    public function update(Request $request)
    {
    	$post = $request->except('_token');

    	if (isset($post['photo'])) {
            $post['photo'] = MyHelper::encodeImage($post['photo']);
        }

        $update = MyHelper::post('product/product-group/update', $post);

     	if (($update['status'] ?? false) != 'success') {
        	return redirect('product/product-group')->withErrors($update['messages'] ?? ['Something went wrong']);
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

    public function detail(Request $request, $id_product_group)
    {
    	$data = [
            'title'          => 'Product',
            'sub_title'      => 'Detail Product Group',
            'menu_active'    => 'product',
            'submenu_active' => 'product-group',
        ];

        $detail = MyHelper::get('product/product-group/detail/' . $id_product_group);

        if (($detail['status'] ?? false) != 'success') {
        	return redirect('product/product-group')->withErrors($detail['messages'] ?? ['Product group detail not found']);
        }

        $data['product_group'] = $detail['result'] ?? [];

        return view('product::product_group.detail', $data);
    }

    public function productList(Request $request)
    {
        $post   = $request->all();
        $action = MyHelper::post('product/product-group/product-list', ['id_product_group' => $post['id_product_group']]);
        return $action;
    }

    public function addProduct(Request $request)
    {
        $post   = $request->except('_token');

        $action = MyHelper::post('product/product-group/add-product', $post);

        if (isset($action['status']) && $action['status'] == 'success') {
            return redirect('product/product-group/detail/' . $post['id_product_group'])->withSuccess(['Product has been added']);
        } else {
            return redirect('product/product-group/detail/' . $post['id_product_group'])->withInput()->withErrors($action['messages'] ?? ['Something went wrong']);
        }
    }

    public function removeProduct(Request $request)
    {
        $post   = $request->all();

        $delete = MyHelper::post('product/product-group/remove-product', ['id_product' => $post['id_product']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        } else {
            return "fail";
        }
    }

    public function updateProduct(Request $request)
    {
        $post   = $request->except('_token');
        $update = MyHelper::post('product/product-group/update-product', $post);

        if (isset($update['status']) && $update['status'] == 'success') {
            return redirect('product/product-group/detail/' . $post['id_product_group'])->withSuccess(['Product has been updated']);
        } else {
            return redirect('product/product-group/detail/' . $post['id_product_group'])->withInput()->withErrors($update['messages'] ?? ['Something went wrong']);
        }
    }

    public function listFeaturedProductGroup(Request $request)
    {
    	$data = [
            'title'          => 'Product',
            'sub_title'      => 'Featured Product Group',
            'menu_active'    => 'product',
            'submenu_active' => 'product-group',
        ];

        $post = $request->except('_token');

        $data['featured_product_groups'] = MyHelper::get('product/product-group/featured/list')['result'] ?? [];
        $data['product_groups'] = MyHelper::get('product/product-group/active-list')['result'] ?? [];

        return view('product::product_group.featured', $data);
    }

    public function createFeaturedProductGroup(Request $request)
    {
        $post = $request->except('_token');
        $result = MyHelper::post('product/product-group/featured/create', $post);

        return parent::redirect($result, 'New featured product group has been created.', 'product/product-group/featured');
    }

    public function updateFeaturedProductGroup(Request $request)
    {
        $post = $request->except('_token');
        $validatedData = $request->validate([
            'id_banner'    => 'required'
        ]);
        $result = MyHelper::post('product/product-group/featured/update', $post);
        return parent::redirect($result, 'Featured product group has been updated.', 'product/product-group/featured',[],true);
    }

    public function reorderFeaturedProductGroup(Request $request)
    {
        $post = $request->except("_token");
        $result = MyHelper::post('product/product-group/featured/reorder', $post);

        return parent::redirect($result, 'Featured product group has been sorted.', 'product/product-group/featured');
    }

    public function deleteFeaturedProductGroup($id_product_group)
    {
        $post['id_banner'] = $id_product_group;
        $result = MyHelper::post('product/product-group/featured/delete', $post);

        return parent::redirect($result, 'Featured product group has been deleted.', 'product/product-group/featured');
    }
}
