<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class ProductCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Product',
            'sub_title'      => 'List Product',
            'menu_active'    => 'product',
            'submenu_active' => 'product-catalog',
            'child_active'   => 'product-catalog-list',
        ];
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $post = $request->all();
        if(!$post){
            $data = [
                'title'          => 'Product',
                'sub_title'      => 'List Product',
                'menu_active'    => 'product',
                'submenu_active' => 'product-catalog',
                'child_active'   => 'product-catalog-create',
            ];
            $data['products'] = MyHelper::post('product/be/icount/list', ['buyable' => 'true'])['result'] ?? [];
    
            return view('product::catalog.create', $data);
        }else{
            return $post;
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
        return view('product::show');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
