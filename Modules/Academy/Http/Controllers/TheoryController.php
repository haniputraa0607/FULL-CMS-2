<?php

namespace Modules\Academy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Session;

class TheoryController extends Controller
{
    public function categoryCreate(Request $request){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Category Theory',
                'sub_title'      => 'New Category Theory',
                'menu_active'    => 'theory',
                'submenu_active' => 'category-theory',
                'child_active'   => 'create-category-theory'
            ];

            return view('academy::theory.category_create', $data);
        }else{
            $save = MyHelper::post('theory/category/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('theory/category')->withSuccess(['Success save data']);
            }else{
                return redirect('theory/category/create')->withErrors($save['messages']??['Failed save data']);
            }
        }
    }

    public function categoryList(Request $request){
        $data = [
            'title'          => 'Category Theory',
            'sub_title'      => 'Category Theory List',
            'menu_active'    => 'theory',
            'submenu_active' => 'category-theory',
            'child_active'   => 'list-category-theory'
        ];

        $category = MyHelper::get('theory/category');

        if (isset($category['status']) && $category['status'] == "success") {
            $data['category'] = $category['result'];
        }
        else {
            $data['category'] = [];
        }

        return view('academy::theory.category_list', $data);
    }

    public function categoryDetail(Request $request, $id){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Category Theory',
                'sub_title'      => 'Category Theory Detail',
                'menu_active'    => 'theory',
                'submenu_active' => 'category-theory',
                'child_active'   => 'list-category-theory'
            ];

            $detail = MyHelper::post('theory/category', ['id_theory_category' => $id]);

            if (isset($detail['status']) && $detail['status'] == "success") {
                $data['detail'] = $detail['result'];
                $data['count_child'] = count($detail['result']['child']);
                return view('academy::theory.category_detail', $data);
            }else{
                return redirect('theory/category')->withErrors($save['messages']??['Failed get data']);
            }
        }else{
            $post['id_theory_category'] = $id;
            $save = MyHelper::post('theory/category/update', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('theory/category/detail/'.$id)->withSuccess(['Success save data']);
            }else{
                return redirect('theory/category/detail/'.$id)->withErrors($save['messages']??['Failed save data']);
            }
        }
    }

    public function theoryList(Request $request){
        $data = [
            'title'          => 'Theory',
            'sub_title'      => 'Theory List',
            'menu_active'    => 'theory',
            'submenu_active' => 'list-theory'
        ];

        $data['list'] = MyHelper::get('theory')['result']??[];
        return view('academy::theory.list', $data);
    }

    public function theoryCreate(Request $request){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Theory',
                'sub_title'      => 'New Theory',
                'menu_active'    => 'theory',
                'submenu_active' => 'new-theory'
            ];

            $data['list_category'] = MyHelper::get('theory/category')['result']??[];
            return view('academy::theory.create', $data);
        }else{
            $save = MyHelper::post('theory/create', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('theory')->withSuccess(['Success save data']);
            }else{
                return redirect('theory')->withErrors($save['messages']??['Failed save data']);
            }
        }
    }

    public function theoryDetail(Request $request, $id){
        $post = $request->except('_token');

        if(empty($post)){
            $data = [
                'title'          => 'Theory',
                'sub_title'      => 'Theory Detail',
                'menu_active'    => 'theory',
                'submenu_active' => 'list-theory'
            ];

            $detail = MyHelper::post('theory', ['id_theory' => $id]);

            if (isset($detail['status']) && $detail['status'] == "success") {
                $data['detail'] = $detail['result'];
                $data['count'] = count($detail['result']);
                $data['list_category'] = MyHelper::get('theory/category')['result']??[];
                return view('academy::theory.detail', $data);
            }else{
                return redirect('theory')->withErrors($save['messages']??['Failed get data']);
            }
        }else{
            $post['id_theory'] = $id;
            $save = MyHelper::post('theory/update', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('theory/detail/'.$id)->withSuccess(['Success save data']);
            }else{
                return redirect('theory/detail/'.$id)->withErrors($save['messages']??['Failed save data']);
            }
        }
    }

    public function theoryDelete(Request $request){
        $post = $request->except('_token');
        $delete = MyHelper::post('theory/delete', $post);
        return $delete;
    }

}
