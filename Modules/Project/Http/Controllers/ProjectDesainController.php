<?php

namespace Modules\Project\Http\Controllers;

use App\Exports\MultisheetExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Session;
use Excel;
use App\Imports\FirstSheetOnlyImport;
use Illuminate\Support\Facades\Hash;

class ProjectDesainController extends Controller
{
    public function create(Request $request)
    {
        $post = $request->except('_token');
        if (isset($request["import_file"])) {
            $post['attachment'] = MyHelper::encodeImage($request['import_file']);
        }
	$query = MyHelper::post('project/create/desain', $post);
	if(isset($query['status']) && $query['status'] == 'success'){
            return redirect('project/detail'.'/'.$post['id_project'].'#contract')->withSuccess(['Create Desain Location Success']);
	} else{
	   return redirect('project/detail'.'/'.$post['id_project'].'#desain')->withErrors($query['messages']);
	}
    }
    public function next(Request $request)
    {
        $post = $request->except('_token'); 
	$query = MyHelper::post('project/next/desain', $post);
	return $query; 
    }
    public function delete(Request $request)
    {
         $post = $request->except('_token'); 
	$query = MyHelper::post('project/delete/desain', $post);
        return $query; 
       
    }
}
