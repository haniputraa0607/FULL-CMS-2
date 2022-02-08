<?php

namespace Modules\Users\Http\Controllers;

use App\Exports\MultisheetExport;
use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Excel;

use App\Imports\FirstSheetOnlyImport;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
    	$data = [
            'title'          => 'Roles',
            'sub_title'      => 'Department List',
            'menu_active'    => 'user',
            'submenu_active' => 'role',
            'child_active' 	 => 'user-department-list'
        ];

        $data['get_department'] = MyHelper::post('users/department',$request->all())['result']??[];

        $data['departments'] = json_encode([]);
        if(!empty($data['get_department'])){
            $data['departments'] = json_encode($this->buildTree($data['get_department']));
        }
        return view('users::department.index', $data);
    }

    function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['id_parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['id_department']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $data = [
            'title'          => 'Department',
            'sub_title'      => 'New Department',
            'menu_active'    => 'user',
            'submenu_active' => 'user-department-new',
        ];

        return view('users::department.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        $store = MyHelper::post('users/department/store', $post);

        if ( ($store['status'] ?? false) == 'success' ) {
            return redirect('user/department')->with('success',['Create Department Success']);
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
            'sub_title'      => 'Department List',
            'menu_active'    => 'user',
            'submenu_active' => 'role',
            'child_active' 	 => 'user-department-list'
        ];

        $post['id_department'] = $id;
        $get_data = MyHelper::post('users/department/edit', $post);

        $data['all_parent'] = [];
        $data['department'] = [];
        if (($get_data['status'] ?? false) == 'success') {
            $data['all_parent'] = $get_data['result']['all_parent'];
            $data['department'] = $get_data['result']['department'];
        }

        return view('users::department.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = $request->except('_token');
        $post['id_department'] = $id;

        $update = MyHelper::post('users/department/update', $post);

        if (($update['status'] ?? false) == 'success') {
            return redirect('user/department/edit/'.$id)->with('success',['Updated Department Success']);
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
        $result = MyHelper::post('users/department/delete', ['id_department' => $id]);
        return $result;
    }

    public function syncIcount(Request $request){
        //sync with item icount
        $post = $request->except('_token');
        $sync = MyHelper::post('users/department/sync', $post);
        if(isset($sync['status']) && $sync['status'] == 'success'){
            return redirect('user/department')->with('success', ['Department table is already synced with ICount']);
        }elseif(isset($sync['status']) && $sync['status'] == 'fail'){
            return redirect('product/icount')->withErrors([$sync['messages']]); 
        }else{
            return redirect('user/department')->withErrors(['Failed to sync with ICount']);
        }

    }
}
