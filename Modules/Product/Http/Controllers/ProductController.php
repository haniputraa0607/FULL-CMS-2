<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Excel;
use Session;

use App\Exports\ProductExport;
use App\Exports\MultisheetExport;
use App\Imports\ProductImport;
use App\Imports\FirstSheetOnlyImport;

class ProductController extends Controller
{
    function __construct() {
        date_default_timezone_set('Asia/Jakarta');
        $this->tag  = "Modules\Product\Http\Controllers\TagController";
    }

    // get category and position
    public function positionAssign(Request $request) {
        $data = [
            'title'          => 'Manage Product Position',
            'sub_title'      => 'Assign Products Position',
            'menu_active'    => 'product',
            'submenu_active' => 'product-position',
        ];

        $catParent = MyHelper::get('product/category/be/list');

        if (isset($catParent['status']) && $catParent['status'] == "success") {
            $data['category'] = $catParent['result'];
        }
        else {
            $data['category'] = [];
        }

        $product = MyHelper::get('product/be/list');

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $data['product'] = [];
        }
        // dd($data);

        return view('product::product.product-position', $data);
    }

    // ajax sort product
    public function positionProductAssign(Request $request)
    {
        $post = $request->except('_token');
        if (!isset($post['product_ids'])) {
            return [
                'status' => 'fail',
                'messages' => ['Product id is required']
            ];
        }
        $result = MyHelper::post('product/position/assign', $post);

        return parent::redirect($result, 'Position product has been save.', 'product/position/assign');
    }

    public function categoryAssign(Request $request) {
		$post = $request->except('_token');

		$data = [
            'title'          => 'Manage Product Category',
            'sub_title'      => 'Assign Products to Categories',
            'menu_active'    => 'product',
            'submenu_active' => 'product-category',
        ];

		if (!empty($post)) {
			$update = MyHelper::post('product/category/assign', $post);

			if (isset($update['status']) && $update['status'] == 'success') {
				// print_r($update);exit;
				return parent::redirect($update, 'Product categories has been updated.', 'product/category/assign');
			} elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
				return back()->withErrors($update['messages']);
			} else {
				return back()->witherrors(['Update Failed']);
			}
		}

		$catParent = MyHelper::get('product/category/be/list');

        if (isset($catParent['status']) && $catParent['status'] == "success") {
            $data['category'] = $catParent['result'];
        }
		else {
            $data['category'] = [];
        }

        $product = MyHelper::get('product/be/list');

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $data['product'] = [];
        }

        return view('product::product.product-category', $data);

	}

    public function importProduct($type) {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'Import Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-import',
            'type'           => $type
        ];
        switch ($type) {
            case 'global':
                $data['sub_title'] = 'Import Product Global';
                $data['submenu_active'] = 'product-import-global';
                $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
                break;

            case 'detail':
                $data['sub_title'] = 'Import Detail Product';
                $data['submenu_active'] = 'product-import-detail';
                $products = MyHelper::post('product/be/list', ['admin_list' => 1])['result']??[];
                if(!$products){
                    return redirect('product/import/global')->withErrors(['Product list empty','Upload global list product first']);
                }
                $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
                break;

            case 'price':
                $data['sub_title'] = 'Import Product Price';
                $data['submenu_active'] = 'product-import-price';
                $products = MyHelper::post('product/be/list', ['admin_list' => 1])['result']??[];
                if(!$products){
                    return redirect('product/import/global')->withErrors(['Product list empty','Upload global list product first']);
                }
                $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
                break;

            case 'modifier-price':
                $data['sub_title'] = 'Import Topping Price';
                $data['menu_active'] = 'product-modifier';
                $data['submenu_active'] = 'product-modifier-import-price';
                $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
                break;

            case 'modifier':
                $data['sub_title'] = 'Import Topping';
                $data['menu_active'] = 'product-modifier';
                $data['submenu_active'] = 'product-modifier-import-global';
                $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
                break;

            default:
                return abort(404);
                break;
        }
        return view('product::product.import.detail', $data);
    }

    /**
     * Export product
     */
    public function export(Request $request,$type) {
        $post = $request->except('_token');
        $data = MyHelper::post('product/export',['type'=>$type]+$post)['result']??[];
        if(!$data){
            return back()->withErrors(['Something went wrong']);
        }
        $tab_title = 'List Products';
        switch ($type) {
            case 'global':
                $tab_title = 'List Products';
                if(!$data['products']){
                    $data['products'] = [
                        [
                            'product_code' => '001',
                            'product_name' => 'Product 1',
                            'product_description' => 'Example product 1'
                        ],
                        [
                            'product_code' => '002',
                            'product_name' => 'Product 2',
                            'product_description' => 'Example product 2'
                        ],
                        [
                            'product_code' => '003',
                            'product_name' => 'Product 3',
                            'product_description' => 'Example product 3'
                        ],
                    ];
                }
                break;

            case 'detail':
                $tab_title = 'Product Detail';
                if(!$data['products']){
                    $data['products'] = [
                        [
                            'product_category_name' => 'Snacks',
                            'position' => '1',
                            'product_code' => '001',
                            'product_name' => 'Product 1',
                            'product_description' => 'Example product 1',
                            'product_visibility' => 'Visible'
                        ],
                        [
                            'product_category_name' => 'Snacks',
                            'position' => '2',
                            'product_code' => '002',
                            'product_name' => 'Product 2',
                            'product_description' => 'Example product 2',
                            'product_visibility' => 'Hidden'
                        ],
                        [
                            'product_category_name' => 'Drinks',
                            'position' => '1',
                            'product_code' => '003',
                            'product_name' => 'Product 3',
                            'product_description' => 'Example product 3',
                            'product_visibility' => 'Visible'
                        ],
                    ];
                }
                break;

            case 'price':
                $tab_title = 'Product Price';
                if(!$data['products']){
                    $data['products'] = [
                        [
                            'product_code' => '001',
                            'product_name' => 'Product 1',
                            'product_description' => 'Example product 1',
                            'global_price' => 10000,
                            'price_PP001' => 15000,
                            'price_BL012' =>13500
                        ],
                        [
                            'product_code' => '002',
                            'product_name' => 'Product 2',
                            'product_description' => 'Example product 2',
                            'global_price' => 20000,
                            'price_PP001' => 30000,
                            'price_BL012' =>25000
                        ],
                        [
                            'product_code' => '003',
                            'product_name' => 'Product 3',
                            'product_description' => 'Example product 3',
                            'global_price' => 12000,
                            'price_PP001' => 18000,
                            'price_BL012' =>15000
                        ],
                    ];
                }
                break;

            case 'modifier-price':
                $tab_title = 'Topping Price';
                if(!$data['products']){
                    $data['products'] = [
                        [
                            'type' => 'type1',
                            'code' => 'mod1',
                            'name' => 'Example Modifier 1',
                            'global_price' => 1000,
                            'price_PP001' => 1500,
                            'price_BL012' =>1350
                        ],
                        [
                            'type' => 'type1',
                            'code' => 'mod2',
                            'name' => 'Example Modifier 2',
                            'global_price' => 1400,
                            'price_PP001' => 1500,
                            'price_BL012' =>1600
                        ],
                        [
                            'type' => 'type2',
                            'code' => 'mod1',
                            'name' => 'Example Modifier 3',
                            'global_price' => 1200,
                            'price_PP001' => 1500,
                            'price_BL012' =>1500
                        ],
                    ];
                }
                $type = 'topping-price';
                break;

            case 'modifier':
                $tab_title = 'Topping';
                if(!$data['products']){
                    $data['products'] = [
                        [
                            'type' => 'type1',
                            'code' => 'mod1',
                            'name' => 'Example Modifier 1'
                        ],
                        [
                            'type' => 'type1',
                            'code' => 'mod2',
                            'name' => 'Example Modifier 2'
                        ],
                        [
                            'type' => 'type2',
                            'code' => 'mod1',
                            'name' => 'Example Modifier 3'
                        ],
                    ];
                }
                $type = 'topping';
                break;

            default:
                # code...
                break;
        }
        return Excel::download(new ProductExport($data['products'],$data['brand'],$tab_title),date('YmdHi').'_'.$type.'_'.$data['brand']['name_brand'].'.xlsx');
    }

    /**
     * Import product
     */
    public function import(Request $request,$type) {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $excel = \Excel::toArray(new ProductImport(),$request->file('import_file'))[0]??[];
            $data = [];
            $head = [];
            foreach ($excel as $key => $value) {
                if($key === 0 ){
                    $data['code_brand'] = $value[1];
                }elseif($key == 2){
                    $head = $value;
                }elseif($key !== 1){
                    $data['products'][] = array_combine($head, $value);
                }
            }
            if(!empty($data)){
                $code_brand = '';
                $import = MyHelper::post('product/import', [
                    'id_brand' => $post['id_brand'],
                    'type' => $type,
                    'data' => $data
                ]);
                return $import;
            }else{
                return [
                    'status'=>'fail',
                    'messages'=>['File empty']
                ];
            }
        }

        return [
            'status'=>'fail',
            'messages'=>['Something went wrong']
        ];
    }

    public function example(Request $request) {
        $post = $request->except('_token');
        $listProduct = MyHelper::get('product/export',['type'=>$type]+$post);
        $listOutlet = MyHelper::post('outlet/be/list', ['admin' => 1, 'type' => 'export']);
        $dataPrice = [];

        if (isset($listProduct['status']) && $listProduct['status'] == 'fail') {
            $dataProduct = [];
        } elseif (!isset($listProduct['status'])) {
            return back()->witherrors(['Something went wrong']);
        } else {
            $dataProduct = $listProduct;
        }

        if (isset($listOutlet['status']) && $listOutlet['status'] == 'fail') {
            $dataOutlet = [];
        } elseif (!isset($listOutlet['status'])) {
            return back()->witherrors(['Something went wrong']);
        } else {
            $dataOutlet = $listOutlet;
        }

        if (!empty($dataOutlet)) {
            $dataOutlet = json_decode(json_encode($listOutlet['result'], JSON_NUMERIC_CHECK), true);
        }

        if (!empty($dataProduct)) {
            foreach ($listProduct['result'] as $key => $value) {
                unset($listProduct['result'][$key]['id_product']);
                unset($listProduct['result'][$key]['id_product_category']);
                unset($listProduct['result'][$key]['created_at']);
                unset($listProduct['result'][$key]['updated_at']);
                unset($listProduct['result'][$key]['product_category']);
                unset($listProduct['result'][$key]['product_discounts']);
                unset($listProduct['result'][$key]['photos']);
            }

            $dataProduct = json_decode(json_encode($listProduct['result'], JSON_NUMERIC_CHECK), true);
        } else {

            $dataProduct[] = [
                'product_code'        => null,
                'product_name'        => null,
                'product_name_pos'    => null,
                'product_description' => null,
                'product_video'       => null,
                'product_weight'      => null,
            ];

            $dataProduct = json_decode(json_encode($dataProduct, JSON_NUMERIC_CHECK), true);
            return Excel::download(new ArrayExport($dataProduct),'product');
        }
        $excelData=[];
        // $excelData['Product']=$dataProduct;
        $excelData['Product']=array_map(function($x){
            // $x['category']=$x['category']['product_category_name'];
            $x['category']=$x['category']['id_product_category'];
            // $x['product_purchase_limitations']=$x['product_purchase_limitations']['product_purchase_limitation'];
            unset($x['product_purchase_limitations']);
            return $x;
        }, $dataProduct);
        //return $dataOutlet;
        foreach ($dataOutlet as $key => $value) {
            foreach ($value['product_prices'] as $row => $price) {
                $data = [
                    'product_code'       => $price['product']['product_code'],
                    'outlet_code'        => $value['outlet_code'],
                    'product_price'      => $price['product_price'],
                    'product_visibility' => $price['product_visibility']
                ];

                array_push($dataPrice, $data);
            }
            $outlet_name = substr($value['outlet_name'],0,31);
            $excelData[$outlet_name]=$dataPrice;
            $dataPrice = [];
        }
        return Excel::download(new MultisheetExport($excelData),'products.xlsx');
    }

    public function importProductSave(Request $request)
    {
        $post = $request->except('_token');

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::toCollection(new FirstSheetOnlyImport(),$request->file('import_file'));
            if(!empty($data)){
                $import = MyHelper::post('product/import', ['data' => $data]);
            }
        }

        return parent::redirect($import, 'Product has been updated.', 'product');
    }

    /**
     * get category
     */
    function category() {
        $data = [];

        $catParent = MyHelper::get('product/category/be/list');

        if (isset($catParent['status']) && $catParent['status'] == "success") {
            return $data = $catParent['result'];
        }
        return $data;
    }

    /**
     * create product
     */
    function create(Request $request) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Product',
                'sub_title'      => 'New Product',
                'menu_active'    => 'product',
                'submenu_active' => 'product-new',
            ];

            $data['parent'] = $this->category();
            $tags = MyHelper::get('product/tag/list');
            $data['tags'] = parent::getData($tags);
            $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
            return view('product::product.create', $data);
        }
        else {
            if (isset($post['next'])) {
                $next = 1;
                unset($post['next']);
            }

            if (isset($post['id_product_category']) && $post['id_product_category'] == 0) {
                unset($post['id_product_category']);
            }

            // print_r($post);exit;

            if (isset($post['photo'])) {
                $post['photo']      = MyHelper::encodeImage($post['photo']);
            }

            if (isset($post['product_photo_detail'])) {
                $post['product_photo_detail']      = MyHelper::encodeImage($post['product_photo_detail']);
            }

            $save = MyHelper::post('product/create', $post);

            if (isset($save['status']) && $save['status'] == 'success') {
                if (isset($post['id_tag']))  {
                    $saveRelation = app($this->tag)->createProductTag($save['result']['id_product'], $post['id_tag']);
                }
            }

            if (isset($next)) {
                $typemap = [
                    'product' => 'product',
                    'service' => 'product-service',
                    'academy' => 'product-academy',
                ];
                return parent::redirect($save, 'Product has been created.', ($typemap[$request->product_type] ?? 'product') . '/detail/'.$post['product_code'].'#photo');
            }
            else {
                return parent::redirect($save, 'Product has been created.');
            }
        }
    }

    /**
     * list
     */
    function listProduct(Request $request) {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-list',
        ];

        $product = MyHelper::post('product/be/list', ['admin_list' => 1, 'product_type' => 'product']);
		// print_r($product);exit;
        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $data['product'] = [];
        }
        // dd($data);

        return view('product::product.list', $data);

    }

    function addImage(Request $request) {
        $post = $request->except('_token');
        if (!empty($post)) {
            $name = explode('.',$request->file('file')->getClientOriginalName())[0];
            $post = MyHelper::encodeImage($request->file('file'));
            $save = MyHelper::post('product/photo/createAjax', ['name' => $name, 'photo' => $post]);
            return $save;
        }
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-image',
            'child_active'   => 'product-image-add',
        ];
        $product = MyHelper::post('product/be/list/image', ['admin_list' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $data['product'] = [];
        }
        return view('product::product.image', $data);
    }

    function addImageDetail(Request $request) {
        $post = $request->except('_token');
        if (!empty($post)) {
            $name = explode('.',$request->file('file')->getClientOriginalName())[0];
            $post = MyHelper::encodeImage($request->file('file'));
            $save = MyHelper::post('product/photo/createAjax', ['name' => $name, 'photo' => $post, 'detail' => 1]);
            return $save;
        }
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-image',
            'child_active'   => 'product-image-detail',
        ];
        $product = MyHelper::post('product/be/list/image', ['admin_list' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $data['product'] = [];
        }
        return view('product::product.image_detail', $data);
    }

    function listImage(Request $request) {
        $post = $request->except('_token');
        if (!empty($post)) {
            $name = explode('.',$request->file('file')->getClientOriginalName())[0];
            $post = MyHelper::encodeImage($request->file('file'));
            $save = MyHelper::post('product/photo/createAjax', ['name' => $name, 'photo' => $post]);
            return $save;
        }
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-image',
            'child_active'   => 'product-image-list',
        ];
        $product = MyHelper::post('product/be/list/image', ['admin_list' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $data['product'] = [];
        }
        return view('product::product.image', $data);
    }

    function overrideImage(Request $request) {
        $post = $request->except('_token');

        if (isset($post['state'])) {
            if ($post['state'] == 'true') {
                $status = 0;
            } else {
                $status = 1;
            }
            $setting = MyHelper::post('product/be/imageOverride', ['admin_list' => 1, 'status' => $status]);
            if ($setting['result'] == 'true') {
                $setting['result'] = $status;
                return $setting;
            }
        } else {
            $setting = MyHelper::post('product/be/imageOverride', ['admin_list' => 1]);
        }

        return $setting;
    }

	function listProductAjax(Request $request) {
        $product = MyHelper::get('product/be/list?log_save=0');

        if (isset($product['status']) && $product['status'] == "success") {
            $data = $product['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
    }
    
	function listProductAjaxSimple(Request $request) {
        $product = MyHelper::get('product/list/ajax?log_save=0');

        if (isset($product['status']) && $product['status'] == "success") {
            $data = $product['result'];
        }
        else {
            $data = [];
        }
		return response()->json($data);
    }

    /**
     * detail
     */
    function detail(Request $request, $code) {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'Product Detail',
            'menu_active'    => 'product',
            'submenu_active' => 'product-list',
        ];

        $product = MyHelper::post('product/be/list', ['product_code' => $code, 'outlet_prices' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $e = ['e' => 'Data product not found.'];
            return back()->witherrors($e);
        }

        $post = $request->except('_token');

        if (empty($post) || (!isset($post['product_detail_visibility']) && !isset($post['product_price']) && isset($post['page']))) {
            $data['parent'] = $this->category();
            $tags = MyHelper::get('product/tag/list');
            $data['tags'] = parent::getData($tags);
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
                $data['outletSpecialPrice']          = [];
                $data['outletSpecialPriceTotal']     = 0;
                $data['outletSpecialPricePerPage']   = 0;
                $data['outletSpecialPriceUpTo']      = 0;
                $data['outletSpecialPricePaginator'] = false;
            }

            $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
            $data['promo_categories'] = MyHelper::get('product/promo-category')['result']??[];
            $data['product'][0]['product_promo_categories'] = array_column($data['product'][0]['product_promo_categories'],'id_product_promo_category');
            $nextId = MyHelper::get('product/next/'.$data['product'][0]['id_product']);
            if (isset($nextId['result']['product_code'])) {
                $data['next_id'] = $nextId['result']['product_code'];
            }
            else {
                $data['next_id'] = null;
            }

            $outletAll = MyHelper::post('outlet/be/list', ['admin' => 1, 'id_product' => $data['product'][0]['id_product']]);
            $data['outlet_all'] = [];
            if (isset($outletAll['status']) && $outletAll['status'] == 'success') {
                $data['outlet_all'] = $outletAll['result'];
            }

            $data['product_variant'] = MyHelper::get('product-variant')['result'] ?? [];
            $data['product_variant_group'] = MyHelper::post('product-variant-group',  ['product_code' => $code])['result'] ?? [];
            $data['count'] = count($data['product_variant_group']);
            $data['product_uses'] = MyHelper::post('product/be/icount/list', [])['result'] ?? [];
            $data['product_icount_use'] = $data['product'][0]['product_icount_use'] ?? [];
            // return $data['product'][0]['id_product'];
            // return $data['product_icount_use'];
            $data['commission'] = MyHelper::post('product/be/commission',['product_code' => $code])['result'] ?? [];
            $data['product_code'] = $code;
//            return $data;
            return view('product::product.detail', $data);
        }
        else {

			 /**
             * update info
             */
            if (isset($post['id_product_category'])) {
                // kalo 0 => uncategorize
                if ($post['id_product_category'] == 0  || empty($post['id_product_category'])) {
                    $post['id_product_category'] = null;
                }

                if (isset($post['photo'])) {
                    $post['photo'] = MyHelper::encodeImage($post['photo']);
                }

                if (isset($post['product_photo_detail'])) {
                    $post['product_photo_detail']      = MyHelper::encodeImage($post['product_photo_detail']);
                }
                
                // update data
                $save = MyHelper::post('product/update', $post);

                unset($post['photo']);

                // update product tag
                if (isset($save['status']) && $save['status'] == 'success') {
                    // delete dulu
                    $deleteRelation = app($this->tag)->deleteAllProductTag($post['id_product']);
					// print_r($deleteRelation);exit;
                    // baru simpan
                    if (isset($post['id_tag']))  {
                        $saveRelation = app($this->tag)->createProductTag($post['id_product'], $post['id_tag']);
                    }
                }
                if($data['title']=='Product'){
                    return parent::redirect($save, 'Product info has been updated.', 'product/detail/'.$post['product_code'].'#info');
                }else{
                    return parent::redirect($save, 'Product info has been updated.', 'product/detail/'.$post['product_code'].'/icount#info');

                }
            }

            /**
             * jika outlet setting
             */
			if (isset($post['product_detail_visibility'])) {
				$save = MyHelper::post('product/detail/update', $post);
				// print_r($save);exit;
                if($data['title']=='Product'){
                    return parent::redirect($save, 'Visibility setting has been updated.', 'product/detail/'.$code.'?page='.$post['page'].'&type='.$post['type'].'#outletsetting');
                }else{
                    return parent::redirect($save, 'Visibility setting has been updated.', 'product/detail/'.$code.'/icount?page='.$post['page'].'&type='.$post['type'].'#outletsetting');

                }
			}

            /**
             * if price setting
             */

            if (isset($post['product_price'])) {
                $save = MyHelper::post('product/detail/update/price', $post);
                // print_r($save);exit;
                if ($data['title']=='Product') {
                    return parent::redirect($save, 'Product price setting has been updated.', 'product/detail/'.$code.'?page='.$post['page'].'&type='.$post['type'].'#outletpricesetting');
                }else{
                    return parent::redirect($save, 'Product price setting has been updated.', 'product/detail/'.$code.'/icount?page='.$post['page'].'&type='.$post['type'].'#outletpricesetting');
                }
            }

			/**
             * jika diskon
             */
            if (isset($post['type_disc'])) {
                unset($post['type_disc']);

                $post = array_filter($post);

                if (isset($post['discount_days'])) {
                    $post['discount_days'] = implode(",", $post['discount_days']);
                }

                if (isset($post['discount_time_start'])) {
                    $post['discount_time_start'] = date('H:i:s', strtotime($post['discount_time_start']));
                }

                if (isset($post['discount_time_end'])) {
                    $post['discount_time_end'] = date('H:i:s', strtotime($post['discount_time_end']));
                }

                $save = MyHelper::post('product/discount/create', $post);
                if($data['title']=='Product'){
                    return parent::redirect($save, 'Product discount has been added.', 'product/detail/'.$code.'#discount');
                }else{
                    return parent::redirect($save, 'Product discount has been added.', 'product/detail/'.$code.'/icount#discount');

                }
            }

            /**
             * jika foto
             */
            if (isset($post['photo'])) {
                $post['photo'] = MyHelper::encodeImage($post['photo']);
                /**
                 * save
                 */
                $save          = MyHelper::post('product/photo/create', $post);
                if ($data['title']=='Product') {
                    return parent::redirect($save, 'Product photo has been added.', 'product/detail/'.$code.'#photo');
                }else{
                    return parent::redirect($save, 'Product photo has been added.', 'product/detail/'.$code.'/icount#photo');
                }
            }

            /**
             * jika ada id_product_photo => untuk sorting
             */
            if (isset($post['id_product_photo'])) {
                for ($x= 0; $x < count($post['id_product_photo']); $x++) {
                    $data = [
                        'id_product_photo' => $post['id_product_photo'][$x],
                        'product_photo_order' => $x+1,
                    ];

                    /**
                     * save product photo
                     */
                    $save = MyHelper::post('product/photo/update', $data);

                    if (!isset($save['status']) || $save['status'] != "success") {
                        if($data['title']=='Product'){
                            return redirect('product/detail/'.$code.'#photo')->witherrors(['Something went wrong. Please try again.']);
                        }else{
                            return redirect('product/detail/'.$code.'/icount#photo')->witherrors(['Something went wrong. Please try again.']);
                        }
                    }
                }
                if($data['title']=='Product'){
                    return redirect('product/detail/'.$code.'#photo')->with('success', ['Photo\'s order has been updated']);
                }else{
                    return redirect('product/detail/'.$code.'/icount#photo')->with('success', ['Photo\'s order has been updated']);
                }
            }

        }
    }

    public function productVarianGroup(Request $request, $product_code){
        $post = $request->all();
        $post['product_code'] = $product_code;
        $create_update = MyHelper::post('product-variant-group', $post);

        if(($create_update['status']??'')=='success'){
            return redirect('product/detail/'.$product_code.'#variant-group')->with('success',['Update Product Variant Group Success']);
        }else{
            return redirect('product/detail/'.$product_code.'#variant-group')->withErrors($create_update['messages'] ?? ['Something went wrong']);
        }
    }

    public function deleteProductVarianGroup(Request $request){
        $post = $request->all();
        $delete = MyHelper::post('product-variant-group/delete', $post);
        return $delete;
    }
    /**
     * delete photo
     */
    function deletePhoto(Request $request) {
        $post   = $request->all();

        $delete = MyHelper::post('product/photo/delete', ['id_product_photo' => $post['id_product_photo']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    /**
     * delete discount
     */
    function deleteDiscount(Request $request) {
        $post   = $request->all();
        $delete = MyHelper::post('product/discount/delete', ['id_product_discount' => $post['id_product_discount']]);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    /**
     * update
     */
    function update(Request $request) {
        $post = $request->except('_token');
        $save = MyHelper::post('product/update', $post);

        if (isset($save['status']) && $save['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    /**
     * delete product
     */
    function delete(Request $request) {
        $post = $request->except('_token');
        $delete = MyHelper::post('product/delete', $post);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    public function price(Request $request, $key = null)
    {
        $data = [
            'title'          => 'Order',
            'sub_title'      => 'Outlet Product Price',
            'menu_active'    => 'product-price',
            'submenu_active' => 'product-price',
            'filter_title'   => 'Filter Product Price',
            'product_setting_type' => 'product_price'
        ];

        $post = $request->except('_token');
        if(isset($post['clear'])){
            session::forget('product_price_filter');
        	unset($post['page']);
        }

        if ((isset($post['rule']) || isset($post['operator']) )) {
        	unset($post['page']);
            session(['product_price_filter' => $post]);
            $data['rule']     = array_map('array_values', $post['rule']);
            $data['operator'] = $post['operator'];
        } elseif (session('product_price_filter')) {
            $filter             = session('product_price_filter');
            $data['rule']     = array_map('array_values', $filter['rule']);
            $data['operator'] = $filter['operator'];
        }

        if(isset($post['page'])){
            $page = $post['page'];
            unset($post['page']);
        }

        if ($post && (!isset($post['rule']) || !isset($post['operator'])) && !isset($post['clear'])) {
            if(isset($post['sameall']) && !empty($post['sameall'])){
                $dataToUpdate = [
                    'product_price'         => $post['price'][0],
                    'id_outlet'             => $post['id_outlet'],
                ];
                $updatePrice = MyHelper::post('product/prices/all-product', $dataToUpdate);

                if (isset($updatePrice['status']) && $updatePrice['status'] == 'success') {
                    return redirect('product/price/'.$key)->withSuccess(['Success update price']);
                } else {
                    return back()->witherrors([$updatePrice['messages']]);
                }
            }else{
                return $this->priceProcess($post);
            }
        }
        $data['admin'] = 1;
        $outlets = MyHelper::post('outlet/be/list', ['filter' => 'different_price'])['result'] ?? [];
        if (!$outlets) {
            $data['outlets'] = [];
        }else{
            $data['outlets'] = $outlets;
        }

        $data['pagination'] = true;
        $data['orderBy'] = 'product_name';

        if(!isset($data['product_name']) && Session::get('search_product_name')){
            $data['product_name'] = Session::get('search_product_name');
        }

        $data['update_price'] = 1;
        $data['admin_list'] = 1;
        if(isset($page)){
            $product = MyHelper::post('product/be/list?page='.$page, $data);
        }else{
            $product = MyHelper::post('product/be/list', $data);
        }
        if (isset($product['status']) && $product['status'] == 'success') {
            $data['product'] = $product['result']['data'];
            $data['total'] = $product['result']['total'];
            $data['paginator'] = new LengthAwarePaginator($product['result']['data'], $product['result']['total'], $product['result']['per_page'], $product['result']['current_page'], ['path' => url()->current()]);
        } elseif (isset($product['status']) && $product['status'] == 'fail') {
            return back()->witherrors([$product['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }

        if (!is_null($key)) {
            $data['key'] = $key;
        } else {
            $data['key'] = $data['outlets'][0]['id_outlet']??'';
        }

        return view('product::product.price', $data);
    }

    /* PROSES HARGA */
    function priceProcess($post)
    {
        $price = array_filter($post['price']);
        if (!empty($price)) {
            foreach ($price as $key => $value) {
                $data = [
                    'id_product'            => $post['id_product'][$key],
                    'product_price'         => $value,
                    'id_outlet'             => $post['id_outlet'],
                ];
                $save = MyHelper::post('product/prices', $data);
                if (isset($save['status']) && $save['status'] != "success") {
                    return back()->witherrors(['Product price failed to update']);
                }
            }
        }

        return back()->with('success', ['Product price has been updated.']);
    }

    public function productOutletDetail(Request $request, $key = null)
    {
        $data = [
            'title'          => 'Order',
            'sub_title'      => 'Outlet Product Detail',
            'menu_active'    => 'product-detail',
            'submenu_active' => 'product-detail',
            'filter_title'   => 'Filter Product Detail',
            'product_setting_type' => 'outlet_product_detail'
        ];

        $post = $request->except('_token');
        if(isset($post['clear'])){
            session::forget('product_detail_filter');
        }

        if(isset($post['page'])){
            $page = $post['page'];
            unset($post['page']);
        }

        if ($post && (!isset($post['rule']) || !isset($post['operator'])) && !isset($post['clear'])) {
            if(isset($post['sameall']) && !empty($post['sameall'])){
                $dataToUpdate = [
                    'product_visibility'    => $post['visible'][0],
                    'product_stock_status'  => $post['product_stock_status'][0],
                    'id_outlet'             => $post['id_outlet']
                ];
                $updatePrice = MyHelper::post('product/outlet-detail/all-product', $dataToUpdate);

                if (isset($updatePrice['status']) && $updatePrice['status'] == 'success') {
                    return redirect('product/outlet-detail/'.$key)->withSuccess(['Success update price']);
                } else {
                    return back()->witherrors([$updatePrice['messages']]);
                }
            }else{
                return $this->productOutletProcess($post);
            }
        }
        $data['admin'] = 1;
        $outlet = MyHelper::post('outlet/be/list', $data);

        if (isset($outlet['status']) && $outlet['status'] == 'success') {
            $data['outlets'] = $outlet['result'];
        } elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
            return back()->witherrors([$outlet['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }

        $data['pagination'] = true;
        $data['orderBy'] = 'product_name';

        if (session('product_detail_filter')) {
            $filter             = session('product_detail_filter');
            $data['rule']     = array_map('array_values', $filter['rule']);
            $data['operator'] = $filter['operator'];
        } else {
            if((isset($post['rule']) || isset($post['operator']) )){
                session(['product_detail_filter' => $post]);
                $data['rule']     = array_map('array_values', $post['rule']);
                $data['operator'] = $post['operator'];
            }
        }

        if(isset($page)){
            $product = MyHelper::post('product/be/list?page='.$page, $data);
        }else{
            $product = MyHelper::post('product/be/list', $data);
        }
        if (isset($product['status']) && $product['status'] == 'success') {
            $data['product'] = $product['result']['data'];
            $data['total'] = $product['result']['total'];
            $data['paginator'] = new LengthAwarePaginator($product['result']['data'], $product['result']['total'], $product['result']['per_page'], $product['result']['current_page'], ['path' => url()->current()]);
        } elseif (isset($product['status']) && $product['status'] == 'fail') {
            return back()->witherrors([$product['messages']]);
        } else {
            return back()->witherrors(['Product Not Found']);
        }

        if (!is_null($key)) {
            $data['key'] = $key;
        } else {
            $data['key'] = $data['outlets'][0]['id_outlet'];
        }

        return view('product::product.outlet-product-detail', $data);
    }


    function productOutletProcess($post)
    {
        if (!empty($post['visible'])) {
            foreach ($post['visible'] as $key => $value) {
                $data = [
                    'id_product'            => $post['id_product'][$key],
                    'product_visibility'    => $post['visible'][$key],
                    'product_stock_status'  => $post['product_stock_status'][$key],
                    'id_outlet'             => $post['id_outlet'],
                ];
                $save = MyHelper::post('product/outlet-detail', $data);
                if (isset($save['status']) && $save['status'] != "success") {
                    return back()->witherrors(['Product price failed to update']);
                }
            }
        }

        return back()->with('success', ['Product price has been updated.']);
    }

    public function updateAllowSync(Request $request)
    {
        $post = $request->except('_token');
        $update = MyHelper::post('product/update/allow_sync', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success'];
        }elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $update['messages']];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update product allow sync'];
        }
    }

    public function updateVisibility(Request $request)
    {
        $post = $request->except('_token');
        $update = MyHelper::post('product/update/visibility/global', $post);

        if (isset($update['status']) && $update['status'] == "success") {
            return ['status' => 'success'];
        }elseif (isset($update['status']) && $update['status'] == 'fail') {
            return ['status' => 'fail', 'messages' => $update['messages']];
        } else {
            return ['status' => 'fail', 'messages' => 'Something went wrong. Failed update product visibility'];
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
            'title'          => 'Product',
            'sub_title'      => $visibility.' Product List',
            'menu_active'    => 'product',
            'submenu_active' => 'product-list-'.lcfirst($visibility),
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
                return parent::redirect($save, 'Product visibility has been updated.', 'product/'.strtolower($visibility).'/'.$post['key']);
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
            $product = MyHelper::post('product/be/list?page='.$page, ['visibility' => $visibility, 'id_outlet' => $data['key'], 'pagination' => true]);
            $data['page'] = $page;
        }else{
            $product = MyHelper::post('product/be/list', ['visibility' => $visibility, 'id_outlet' => $data['key'], 'pagination' => true]);
            $data['page'] = 1;
        }
        // dd($product);
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
        return view('product::product.visibility', $data);
    }

    // menyimpan id_product & id_outlet yang di select ke session
    public function addIdVisibility(Request $request)
    {
        $post = $request->except('_token');
        $idVisibility = Session::get('idVisibility');
        $ses_allProduct = Session::get('idVisibility_allProduct');
        $countProduct = 0;

        if($post['checked'] == "true"){
            // select all product in all outlet
            if(isset($post['allOutlet'])){
                Session::put('idVisibility_allOutlet', true);
                $outlet = MyHelper::get('outlet/be/list');
                if (isset($outlet['status']) && $outlet['status'] == 'success') {
                    foreach ($outlet['result'] as $o => $dataOutlet) {
                        $ses_allProduct[$dataOutlet['id_outlet']] = true;
                        $product = MyHelper::post('product/be/list', ['visibility' => $post['visibility'], 'id_outlet' => $dataOutlet['id_outlet']]);
                        if (isset($product['status']) && $product['status'] == 'success') {
                            $page = 1;
                            $i = 1;
                            $idVisibility[$dataOutlet['id_outlet']][$page] = [];
                            foreach ($product['result'] as $key => $value) {
                                $idVisibility[$dataOutlet['id_outlet']][$page][] = $value['id_product'].'/'.$dataOutlet['id_outlet'];
                                if($i % 10 == 0){
                                    $page++;
                                }
                                $i++;
                                $countProduct++;
                            }
                        }
                    }
                }
            }
            // select all product in 1 outlet
            else if(isset($post['allProduct'])){
                $ses_allProduct[$post['key']] = true;
                Session::put('idVisibility_allProduct',$ses_allProduct);
                $product = MyHelper::post('product/be/list', ['visibility' => $post['visibility'], 'id_outlet' => $post['key']]);
                if (isset($product['status']) && $product['status'] == 'success') {
                    $page = 1;
                    $i = 1;
                    $idVisibility[$post['key']][$page] = [];
                    foreach ($product['result'] as $key => $value) {
                        $idVisibility[$post['key']][$page][] = $value['id_product'].'/'.$post['key'];
                        if($i % 10 == 0){
                            $page++;
                        }
                        $i++;
                        $countProduct++;
                    }
                }
            }else{
                $idVisibility[$post['key']][$post['page']] = explode(',',$post['id_visibility']);
            }
        }
        // for uncheck
        else{
            if(isset($post['allOutlet'])){
                $idVisibility = null;
                Session::forget('idVisibility');
                Session::forget('idVisibility_allOutlet');
                Session::forget('idVisibility_allProduct');
            } else if(isset($post['allProduct'])){
                unset($idVisibility[$post['key']]);
                unset($ses_allProduct[$post['key']]);
                Session::forget('idVisibility_allOutlet');
            }
        }
        Session::put('idVisibility_allProduct',$ses_allProduct);
        Session::put('idVisibility', $idVisibility);
        return Session::get('idVisibility');
    }

    public function photoDefault(Request $request) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Product',
                'sub_title'      => 'Photo Default',
                'menu_active'    => 'product',
                'submenu_active' => 'product-photo-default',
            ];

            $data['photo'] = env('STORAGE_URL_API').'img/product/item/default.png?';
            $data['photo_detail'] = env('STORAGE_URL_API').'img/product/item/detail/default.png?';

            return view('product::product.photo-default', $data);
        }else{
            if(isset($post['photo'])){
                $post['photo'] = MyHelper::encodeImage($post['photo']);
            }
            if(isset($post['photo_detail'])){
                $post['photo_detail'] = MyHelper::encodeImage($post['photo_detail']);
            }
            $default = MyHelper::post('product/photo/default', $post);
            if (isset($default['status']) && $default['status'] == 'success') {
                return parent::redirect($default, 'Product Photo Default has been updated.', 'product/photo/default');
            } elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
                return back()->witherrors([$outlet['messages']]);
            } else {
                return back()->witherrors(['Product Not Found']);
            }
        }
    }

    public function updateVisibilityProduct(Request $request){
        $post = $request->except('_token');
        $post['id_visibility'] = explode(',', $post['id_visibility']);
        $save = MyHelper::post('product/update/visibility', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            $data = ['status' => 'success'];
        }
        else {
            $data = ['status' => 'fail'];
            if(isset($save['messages'])){
                $data['messages'] = $save['messages'];
            }
        }
		return response()->json($data);
    }

    public function ajaxProductBrand(Request $request)
    {
    	$post=$request->except('_token');
        $product=MyHelper::post('product/ajax-product-brand', $post);
        return $product;
    }

     // ICOUNT
    public function listProductIcount(Request $request){
        $post = $request->all();
        $data = [
            'title'          => 'Product ICount',
            'sub_title'      => 'List Product ICount',
            'menu_active'    => 'product',
            'submenu_active' => 'product-icount-list',
        ];

        $product = MyHelper::post('product/be/icount/list', $post);
        // return $product;
        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $data['product'] = [];
        }
        // dd($data);

        return view('product::product.list_icount', $data);
    }

    public function syncIcount(Request $request){
        //sync with item icount
        $post = $request->except('_token');
        $sync = MyHelper::post('product/be/sync', $post);
        if(isset($sync['status']) && $sync['status'] == 'success'){
            return redirect('product/icount')->with('success', ['Product table is already synced with ICount']);
        }elseif(isset($sync['status']) && $sync['status'] == 'fail'){
            return redirect('product/icount')->withErrors([$sync['messages']]); 
        }else{
            return redirect('product/icount')->withErrors(['Failed to sync with ICount']);
        }

    }

    public function deleteIcount(Request $request){
        $post = $request->except('_token');
        $delete = MyHelper::post('product/icount/delete', $post);

        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }

    public function detailIcount(Request $request, $id_item) {
        $data = [
            'title'          => 'Product ICount',
            'sub_title'      => 'Product ICount Detail',
            'menu_active'    => 'product',
            'submenu_active' => 'product-icount-list',
        ];

        $product = MyHelper::post('product/be/icount/list', ['id_item' => $id_item, 'outlet_prices' => 1]);

        if (isset($product['status']) && $product['status'] == "success") {
            $data['product'] = $product['result'];
        }
        else {
            $e = ['e' => 'Data product not found.'];
            return back()->witherrors($e);
        }
        $post = $request->except('_token');


        if (empty($post)) {
            $data['parent'] = $this->category();
            $tags = MyHelper::get('product/tag/list');
            $data['tags'] = parent::getData($tags);
            $data['page'] = $post['page']??1;
            $dtDetail['id_product_icount'] = $data['product'][0]['id_product_icount'];
            $dtDetail['page'] = 1;
            $dtPrice['id_product_icount'] = $data['product'][0]['id_product_icount'];
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
                $data['outletSpecialPrice']          = [];
                $data['outletSpecialPriceTotal']     = 0;
                $data['outletSpecialPricePerPage']   = 0;
                $data['outletSpecialPriceUpTo']      = 0;
                $data['outletSpecialPricePaginator'] = false;
            }

            $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
            $nextId = MyHelper::get('product/next/'.$data['product'][0]['id_product_icount']);
            if (isset($nextId['result']['code'])) {
                $data['next_id'] = $nextId['result']['code'];
            }
            else {
                $data['next_id'] = null;
            }

            $outletAll = MyHelper::post('outlet/be/list', ['admin' => 1, 'id_product_icount' => $data['product'][0]['id_product_icount']]);
            $data['outlet_all'] = [];
            if (isset($outletAll['status']) && $outletAll['status'] == 'success') {
                $data['outlet_all'] = $outletAll['result'];
            }

            return view('product::product.detail_icount', $data);
        }
        else {

			 /**
             * update info
             */
            if (isset($post['id_product_category'])) {
                // kalo 0 => uncategorize
                if ($post['id_product_category'] == 0  || empty($post['id_product_category'])) {
                    $post['id_product_category'] = null;
                }

                if (isset($post['photo'])) {
                    $post['photo'] = MyHelper::encodeImage($post['photo']);
                }

                if (isset($post['product_photo_detail'])) {
                    $post['product_photo_detail']      = MyHelper::encodeImage($post['product_photo_detail']);
                }
                
                // update data
                $save = MyHelper::post('product/update', $post);

                unset($post['photo']);

                // update product tag
                if (isset($save['status']) && $save['status'] == 'success') {
                    // delete dulu
                    $deleteRelation = app($this->tag)->deleteAllProductTag($post['id_product']);
					// print_r($deleteRelation);exit;
                    // baru simpan
                    if (isset($post['id_tag']))  {
                        $saveRelation = app($this->tag)->createProductTag($post['id_product'], $post['id_tag']);
                    }
                }
                if($data['title']=='Product'){
                    return parent::redirect($save, 'Product info has been updated.', 'product/detail/'.$post['product_code'].'#info');
                }else{
                    return parent::redirect($save, 'Product info has been updated.', 'product/detail/'.$post['product_code'].'/icount#info');

                }
            }

        }
    }

    function updateProductUse(Request $request){
        $post = $request->except('_token');
        $save = MyHelper::post('product/pivot/update', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect(url()->previous().'#productuse')->with('success', ['Product use has been save.']);
        }
        else {
            return redirect(url()->previous().'#productuse')->witherrors(['Something went wrong. Please try again.']);
        }
    }
    function submitCommission(Request $request){
        $post = $request->except('_token');
        $save = MyHelper::post('product/be/commission/create', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('product/detail/'.$post['product_code'].'#commission')->with('success', ['Commission has been save.']);
        }
        else {
            return redirect('product/detail/'.$post['product_code'].'#commission')->witherrors(['Something went wrong. Please try again.']);
        }
    }
}
