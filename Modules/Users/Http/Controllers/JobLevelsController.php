<?php

namespace Modules\Users\Http\Controllers;

use App\Exports\MultisheetExport;
use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Excel;

use App\Imports\FirstSheetOnlyImport;

class JobLevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'Job Levels',
            'sub_title'      => 'Job Level List',
            'menu_active'    => 'user',
            'submenu_active' => 'role',
            'child_active' => 'job-level-list',
        ];

        $data['get_job_level'] = MyHelper::post('users/job-level',$request->all())['result']??[];

        $data['job_levels'] = json_encode([]);
        if(!empty($data['get_job_level'])){
            $data['job_levels'] = json_encode($this->buildTree($data['get_job_level']));
        }
        return view('users::job_levels.index', $data);
    }

    public function position(Request $request)
    {
        $post = $request->all();
        $data = [
            'title'          => 'Job Levels',
            'sub_title'      => 'Job Level Position',
            'menu_active'    => 'user',
            'submenu_active'    => 'role',
            'child_active' => 'job-level-position',
        ];

        if(empty($post)){
            $data['get_job_level'] = MyHelper::post('users/job-level',$request->all())['result']??[];

            $data['job_levels'] = json_encode([]);
            if(!empty($data['get_job_level'])){
                $data['job_levels'] = json_encode($this->buildTree($data['get_job_level']));
            }
            return view('users::job_levels.position', $data);
        }else{
            $update_potition = MyHelper::post('users/job-level/position', $post);
            if(($update_potition['status']??'')=='success'){
                return redirect('job-level/position')->with('success', ['Update position success']);
            }else{
                return redirect('job-level/position')->withErrors($update_potition['messages'] ?? ['Something went wrong']);
            }
        }
    }

    function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['id_parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['id_job_level']);
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
    public function create()
    {
        $data = [
            'title'          => 'Job Levels',
            'sub_title'      => 'New Job Level',
            'menu_active'    => 'user',
            'submenu_active'    => 'role',
            'child_active'  => 'job-level-new',
        ];
        return view('users::job_levels.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $store = MyHelper::post('users/job-level/store', $post);

        if(($store['status']??'')=='success'){
            return redirect('job-level')->with('success',['Create job level Success']);
        }else{
            return back()->withInput()->withErrors($store['messages'] ?? ['Something went wrong']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('users::job_levels.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'title'          => 'Job Levels',
            'sub_title'      => 'Update Job Level',
            'menu_active'    => 'user',
            'submenu_active'    => 'role',
            'child_active' => 'job-level-list',
        ];

        $post['id_job_level'] = $id;
        $get_data = MyHelper::post('users/job-level/edit', $post);

        $data['all_parent'] = [];
        $data['job_level'] = [];
        if(($get_data['status']??'')=='success'){
            $data['all_parent'] = $get_data['result']['all_parent'];
            $data['job_level'] = $get_data['result']['job_level'];
        }

        return view('users::job_levels.edit', $data);
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
        $post['id_job_level'] = $id;


        if(isset($post['job_level_visibility'])) {
            $post['job_level_visibility'] = 'Visible';
        }else{
            $post['job_level_visibility'] = 'Hidden';
        }

        $update = MyHelper::post('users/job-level/update', $post);

        if(($update['status']??'')=='success'){
            return redirect('job-level/edit/'.$id)->with('success',['Updated job level Success']);
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
        $result = MyHelper::post('users/job-level/delete', ['id_job_level' => $id]);
        return $result;
    }
}
