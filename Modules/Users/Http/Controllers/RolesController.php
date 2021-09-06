<?php

namespace Modules\Users\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Excel;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'Roles',
            'sub_title'      => 'Role List',
            'menu_active'    => 'user',
            'submenu_active' => 'role',
            'child_active' => 'role-list',
        ];
        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('users/role',$request->all());
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            return response()->json($arr_result);
        }

        return view('users::roles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'title'          => 'Roles',
            'sub_title'      => 'New Roles',
            'menu_active'    => 'user',
            'submenu_active'    => 'role',
            'child_active'  => 'role-new',
        ];
        $data['feature_all'] = MyHelper::get('feature?log_save=0')['result']??[];
        $data['job_levels'] = MyHelper::post('users/job-level',[])['result']??[];
        $data['departments'] = MyHelper::post('users/department',[])['result']??[];
        return view('users::roles.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $store = MyHelper::post('users/role/store', $post);

        if(($store['status']??'')=='success'){
            return redirect('role')->with('success',['Create role Success']);
        }else{
            return back()->withInput()->withErrors($store['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'title'          => 'Roles',
            'sub_title'      => 'Update Role',
            'menu_active'    => 'user',
            'submenu_active'    => 'role',
            'child_active' => 'role-list',
        ];

        $post['id_role'] = $id;
        $detail = MyHelper::post('users/role/edit', $post)['result']??[];

        if(empty($detail)){
            return redirect('role')->withErrors($store['messages'] ?? ['Something went wrong']);
        }else{
            $data['detail'] = $detail;
        }
        $data['feature_all'] = MyHelper::get('feature?log_save=0')['result']??[];
        $data['job_levels'] = MyHelper::post('users/job-level',[])['result']??[];
        $data['departments'] = MyHelper::post('users/department',[])['result']??[];
        return view('users::roles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->all();
        $post['id_role'] = $id;
        $update = MyHelper::post('users/role/update', $post);

        if(($update['status']??'')=='success'){
            return redirect('role/edit/'.$id)->with('success',['Updated Role Success']);
        }else{
            return back()->withInput()->withErrors($update['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = MyHelper::post('users/role/delete', ['id_role' => $id]);
        if(($result['status']??'')=='success'){
            return redirect('role')->with('success',['Delete Role Success']);
        }else{
            return back()->withInput()->withErrors($update['messages'] ?? ['Something went wrong']);
        }
    }
}
