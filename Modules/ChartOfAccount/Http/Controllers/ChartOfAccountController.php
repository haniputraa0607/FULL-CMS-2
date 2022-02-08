<?php

namespace Modules\ChartOfAccount\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Session;
use Illuminate\Pagination\LengthAwarePaginator;

class ChartOfAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request) 
    {
        $post = $request->all();
        $url = $request->url();
        $data = [
                'title'          => 'Chart Of Account',
                'menu_active'    => 'order',
                'submenu_active' => 'chart-of-account',
            ];
            
        $session = 'list-chart-of-account';
        $order = 'created_at';
        $orderType = 'desc';
        $sorting = 0;
        if(isset($post['sorting'])){
            $sorting = 1;
            $order = $post['order'];
            $orderType = $post['order_type'];
        }
        
        if( ($post['rule']??false) && !isset($post['draw']) ){
            session([$session => $post]);

        }elseif($post['clear']??false){
           session([$session => null]);
        }
        
        if(isset($post['reset']) && $post['reset'] == 1){
           Session::forget($session);
        }elseif(Session::has($session) && !empty($post) && !isset($post['filter'])){
           $pageSession = 1;
           if(isset($post['page'])){
               $pageSession = $post['page'];
           }
           $post = Session::get($session);
           $post['page'] = $pageSession;

        }
        if(isset($post['rule'])){
               $data['rule'] = array_map('array_values', $post['rule']);
        }
        $page = '?page=1';
        if(isset($post['page'])){
           $page = '?page='.$post['page'];
        }

        $list = MyHelper::post('chartofaccount/'.$page, $post);
        if(($list['status']??'')=='success'){
            $data['result'] = $list['result']['data'];
            $data['data_total']     = $list['result']['total'];
            $data['data_per_page']   = $list['result']['from'];
            $data['data_up_to']      = $list['result']['from'] + count($list['result']['data'])-1;
            $data['data_paginator'] = new LengthAwarePaginator($list['result']['data'], $list['result']['total'], $list['result']['per_page'], $list['result']['current_page'], ['path' => url()->current()]);
        }else{
            $data['data']          = [];
            $data['data_total']     = 0;
            $data['data_per_page']   = 0;
            $data['data_up_to']      = 0;
            $data['data_paginator'] = false;
        }
        if($post){
            Session::put($session,$post);
        }
        return view('chartofaccount::list', $data);
    }
    public function indexold() 
    {
        $result = MyHelper::get('chartofaccount');
          $data = [
                'title'          => 'Chart Of Account',
                'menu_active'    => 'order',
                'submenu_active'    => 'chart-of-account',
            ];
          $data['result'] = [];
          if(isset($result['status']) && $result['status'] == 'success'  ){
           $data['result'] = $result['result'];
           }
           return view('chartofaccount::list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function sync()
    {
        $result = MyHelper::get('chartofaccount/sync');
        if(isset($result['status']) && $result['status'] == 'success'  ){
           return back()->withSuccess(['Sync Success']);
        }elseif(isset($result['status']) && $result['status'] == 'fail'){
           return back()->withErrors([$result['messages']]); 
        }else{
            return back()->withErrors(['Sync Failed']);
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
        return view('chartofaccount::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('chartofaccount::edit');
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
