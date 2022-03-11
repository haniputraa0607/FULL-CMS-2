<?php

namespace Modules\BusinessDevelopment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class OutletStarterBundlingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Outlet Starter Bundling',
            'url_title'      => url()->current(),
            'sub_title'      => 'Manage Outlet Starter Bundling',
            'menu_active'    => 'outlet-starter-bundling',
            'submenu_active' => 'outlet-starter-bundling-list',
            'result'         => MyHelper::get('outlet-starter-bundling')['result'],
        ];

        return view('businessdevelopment::bundling.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Outlet Starter Bundling',
            'url_title'      => url()->current(),
            'sub_title'      => 'Create Outlet Starter Bundling',
            'menu_active'    => 'outlet-starter-bundling',
            'submenu_active' => 'new-outlet-starter-bundling',
        ];
        return view('businessdevelopment::bundling.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $result = MyHelper::post('outlet-starter-bundling/create', $request->all());
        if ($result['status'] == 'success') {
            return redirect(url('outlet-starter-bundling/detail/' . $request->code))->withSuccess([$result['result']['message'] ?? 'Success']);
        } else {
            return back()->withErrors($result['messages'] ?? ['Something went wrong'])->withInput();
        }
    }

    /**
     * Show the specified resource.
     * @param int $idICOUNT_URL = http://dev.ima.icount.id
     * @return Response
     */
    public function show($id)
    {
        $data = [
            'title'          => 'Outlet Starter Bundling',
            'url_title'      => url()->current(),
            'sub_title'      => 'Create Outlet Starter Bundling',
            'menu_active'    => 'outlet-starter-bundling',
            'submenu_active' => 'outlet-starter-bundling-list',
            'bundling'       => MyHelper::post('outlet-starter-bundling/detail', ['code' => $id])['result'] ?? false,
            'product_icounts' => MyHelper::post('product/be/icount/list', ['company_type' => 'ima','buyable' => 'true'])['result'] ?? []
        ];
        if (!$data['bundling']) {
            abort(404);
        }
        return view('businessdevelopment::bundling.show', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $result = MyHelper::post('outlet-starter-bundling/update', $request->all());
        if ($result['status'] == 'success') {
            return redirect(url('outlet-starter-bundling/detail/' . $request->code))->withSuccess([$result['result']['message'] ?? 'Success']);
        } else {
            return redirect(url('outlet-starter-bundling/detail/' . $request->code))->withErrors($result['messages'] ?? ['Something went wrong'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $result = MyHelper::post('outlet-starter-bundling/delete', $request->all());
        if ($result['status'] == 'success') {
            return redirect(url('outlet-starter-bundling'))->withSuccess([$result['result']['message'] ?? 'Success']);
        } else {
            return redirect(url('outlet-starter-bundling'))->withErrors($result['messages'] ?? ['Something went wrong'])->withInput();
        }
    }
}
