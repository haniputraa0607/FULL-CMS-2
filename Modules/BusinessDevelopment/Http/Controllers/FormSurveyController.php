<?php

namespace Modules\BusinessDevelopment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Lib\MyHelper;
use Session;
use Excel;
use App\Imports\FirstSheetOnlyImport;
use Illuminate\Support\Facades\Hash;

use function GuzzleHttp\json_encode;

class FormSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'title'          => 'Form Survey',
            'sub_title'      => 'List Form Survey',
            'menu_active'    => 'form-survey',
            'submenu_active' => 'list-form-survey',
        ];

        $form = MyHelper::get('partners/form-survey/list');

        if (isset($form['status']) && $form['status'] == "success") {
            $data['form'] = $form['result'];
        	$brand = MyHelper::get('brand');
            if (isset($brand['status']) && $brand['status'] == "success") {
                $data['brand'] = $brand['result'];
            }else {
                $data['brand'] = [];
            }
        } else {
            $data['form'] = [];
        }
        // dd($data['brand']);
        return view('businessdevelopment::form_survey.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('businessdevelopment::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */

    public function new(){
        $data = [
            'title'          => 'Form Survey',
            'sub_title'      => 'New Form Survey',
            'menu_active'    => 'form-survey',
            'submenu_active' => 'new-form-survey',
        ];

        $brand = MyHelper::get('brand')??[];
        $form = MyHelper::get('partners/form-survey/list');
        $new_brand = [];
        $nb = 0;
        if(isset($brand['result']) && !empty($brand['result'])){
            foreach($brand['result'] as $b){
                $cek = $this->cekBrand($b['id_brand'],$form['result']);
                if($cek==false){
                    $new_brand[$nb]=$b;
                    $nb++;
                }
                
            }
        }
        $data['brand'] = $new_brand;
        $data['conditions'] = "";
        if(isset($new_brand) && !empty($new_brand)){
            return view('businessdevelopment::form_survey.new', $data);
        }else{
            return redirect('businessdev/form-survey')->withErrors($result['messages'] ?? ['Cant create a new form survey. All brands already have form survey']);
        }

    }
    public function cekBrand($id,$form){
        foreach($form as $i => $f){
            if($id==$i){
                return true;
            }
        }
        return false;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('businessdevelopment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $result = MyHelper::post('partners/form-survey',['id_brand' => $id]);
        $brand = MyHelper::post('brand/show', ['id_brand' => $id]);
        $data = [
            'title'          => 'Form Survey',
            'sub_title'      => 'Detail Form Survey',
            'menu_active'    => 'form-survey',
            'submenu_active' => 'list-form-survey',
            'form_survey'    => $result,
            'brand'          => $brand['result'], 
            'id'             => $id,   
        ];
        // dd($data['form_survey']);
        return view('businessdevelopment::form_survey.form', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function store(Request $request, $type = null)
    {
        $result = MyHelper::get('partners/form-survey/all');
        $index_cat = 1;
        foreach($request['category'] as $cat){
            $name_cat = 'cat'.$index_cat;
            $form[$name_cat]["category"] = strtoupper($cat['cat']);
            $form[$name_cat]["question"] = $cat['question'];
            $index_cat++;
        }
        $result[$request['id_brand']] = $form;
        $post =[
            'key' => 'form_survey',
            'value_text' => json_encode($result),
        ];
        $post_form = MyHelper::post('partners/form-survey/store', $post);
        if (isset($post_form['status']) && $post_form['status'] == 'success') {
            if($type == 'new'){
                return redirect('businessdev/form-survey')->withSuccess(['Success create new form survey']);
            }elseif($type == 'update'){
                return redirect('businessdev/form-survey')->withSuccess(['Success update form survey']);
            }
        }else{
            if ($type == 'new') {
                return redirect('businessdev/form-survey')->withErrors($result['messages'] ?? ['Failed create new form survey']);
            }elseif($type == 'update'){
                return redirect('businessdev/form-survey')->withErrors($result['messages'] ?? ['Failed update form survey']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = MyHelper::get('partners/form-survey/all');
        unset($result[$id]);
        $post =[
            'key' => 'form_survey',
            'value_text' => json_encode($result),
        ];
        $post_form = MyHelper::post('partners/form-survey/store', $post);
        return $post_form;
    }
}
