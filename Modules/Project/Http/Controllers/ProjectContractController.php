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
use App\Exports\SPKExport;
use App\Exports\Handover;

class ProjectContractController extends Controller
{
    public function create(Request $request)
    {
        $post = $request->except('_token');
        if (isset($request["import_file"])) {
            $post['attachment'] = MyHelper::encodeImage($request['import_file']);
        }
        $post['renovation_cost'] = str_replace(',','', $post['renovation_cost']??0);
        $query = MyHelper::post('project/create/contract', $post);
	if(isset($query['status']) && $query['status'] == 'success'){
            return redirect('project/detail'.'/'.$post['id_project'].'#fitout')->withSuccess(['Contract Success']);
	} else{
            return redirect('project/detail'.'/'.$post['id_project'].'#contract')->withErrors($query['messages']);
	}
    }
    public function next(Request $request)
    {
        $post = $request->except('_token'); 
	$query = MyHelper::post('project/next/contract', $post);
	return $query; 
    }
    public function delete(Request $request)
    {
        $post = $request->except('_token');
	$query = MyHelper::post('project/delete/contract', $post);
	return $query; 
    }
    
}
