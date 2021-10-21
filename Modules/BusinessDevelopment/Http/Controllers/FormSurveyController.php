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
    public function store(Request $request)
    {
        $result = MyHelper::get('partners/form-survey/all');
        $value = $request->except('_token','id','name_brand');
        $tes = array_keys($value);
        $q = 0;
        $icat = 0;
        $cat = 1;
        $t = 0;
        foreach ($value as $v) {
            if ($tes[$t]=='cat'.$cat) {
                $category[$cat] = $v;
                $name_category[$cat] = $tes[$t];
                $cat++;
                $icat++;
                $q = 0;
            }else{
                $question[$icat][$q] = $v;
                $q++;
            }

            $t++;
        }
        foreach($category as $i => $cate){
            $category[$i] = strtoupper($cate);
        }
        foreach($name_category as $c => $value){
            $form_input[$value] = [
                'category' => $category[$c],
                'question' => $question[$c],
            ];
        }
        $result[$request['id']] = $form_input;
        $post =[
            'key' => 'form_survey',
            'value_text' => json_encode($result),
        ];
        $post_form = MyHelper::post('partners/form-survey/store', $post);
        if (isset($post_form['status']) && $post_form['status'] == 'success') {
            return redirect('businessdev/form-survey/detail/'.$request['id'])->withSuccess(['Success update candidate partner to partner']);
        }else{
            return redirect('businessdev/form-survey/detail/'.$request['id'])->withErrors($result['messages'] ?? ['Failed update detail candidate partner']);
        }
    }

    public function new(){
        $data = [
            'title'          => 'Form Survey',
            'sub_title'      => 'New Form Survey',
            'menu_active'    => 'form-survey',
            'submenu_active' => 'new-form-survey',
        ];

        $brand = MyHelper::get('brand');
        $form = MyHelper::get('partners/form-survey/list');
        $new_brand = [];
        $nb = 0;
        foreach($brand['result'] as $b){
            $cek = $this->cekBrand($b['id_brand'],$form['result']);
            if($cek==false){
                $new_brand[$nb]=$b;
                $nb++;
            }
            
        }
        $data['brand'] = $new_brand;
        $data['conditions'] = "";
        if(isset($new_brand) && !empty($new_brand)){
            return view('businessdevelopment::form_survey.new', $data);
        }else{
            return 'Tidak bisa buat baru';
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
    public function update(Request $request)
    {
        // dd($request->all());
        $result = MyHelper::get('partners/form-survey/all');
        $index_cat = 1;
        foreach($request['category'] as $cat){
            $q = 0;
            $name_cat = 'cat'.$index_cat;
            foreach($cat as $value){
                
            }
            $form[$name_cat]["category"] = $cat['cat'];
            $index_cat++;
        }
        return $x;
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
