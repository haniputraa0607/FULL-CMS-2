<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class SettingEmployeeController extends Controller
{
 
    public function faqList() {
        $data = [];
        $data = [
            'title'   => 'Setting Faq Employee',
            'menu_active'    => 'faq',
            'submenu_active' => 'faq-list-employee'
        ];

        $faqList = MyHelper::post('employee/be/profile/faq',$data);

        if (isset($faqList['status']) && $faqList['status'] == 'success') {
            $data['result'] = array_map(function($var){
                $var['id_employee_faq'] = MyHelper::createSlug($var['id_employee_faq'],$var['created_at']);
                return $var;
            },$faqList['result']);
        } else {
            if (isset($faqList['status']) && $faqList['status'] == 'fail') {
                $data['result'] = [];

            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
                return view('setting::faq_employee.faqList', $data)->withErrors($e);
            }
        }
        return view('setting::faq_employee.faqList', $data);
    }
    public function faqListPopular() {
        $data = [];
        $data = [
            'title'   => 'Setting Faq Employee Popular',
            'menu_active'    => 'faq',
            'submenu_active' => 'faq-list-employee-popular'
        ];

        $faqList = MyHelper::post('employee/be/profile/faq/popular',$data);

        if (isset($faqList['status']) && $faqList['status'] == 'success') {
            $data['result'] = array_map(function($var){
                $var['id_employee_faq'] = MyHelper::createSlug($var['id_employee_faq'],$var['created_at']);
                return $var;
            },$faqList['result']);
        } else {
            if (isset($faqList['status']) && $faqList['status'] == 'fail') {
                $data['result'] = [];

            } else {
                $e = ['e' => 'Something went wrong. Please try again.'];
                return view('setting::faq_employee.faqList', $data)->withErrors($e);
            }
        }
        return view('setting::faq_employee.faqListPopular', $data);
    }

    public function faqCreate() {
        $data = [];
        $data = [
            'title'   => 'Setting Faq Employee',
            'menu_active'    => 'faq',
            'submenu_active' => 'faq-list-employee'
        ];

        return view('setting::faq_employee.faqCreate', $data);
    }

    public function faqStore(Request $request) {
        $data = $request->except('_token');

        $insert = MyHelper::post('employee/be/profile/faq/create', $data);

        return parent::redirect($insert, 'FAQ has been created.');
    }

    public function faqEdit($slug) {
      $exploded = MyHelper::explodeSlug($slug);
        $id = $exploded[0];
        $created_at = $exploded[1];
        $data = [];
        $data = [
            'title'   => 'Setting Faq Employee',
            'menu_active'    => 'faq',
            'submenu_active' => 'faq-list-employee'
        ];

       $edit = MyHelper::post('employee/be/profile/faq/detail', ['id_employee_faq' => $id,'created_at'=>$created_at]);

        if (isset($edit['status']) && $edit['status'] == 'success') {
            $data['faq'] = $edit['result'];
            if(isset($data['faq']['id_employee_faq'])){
                $data['faq']['id_employee_faq'] = $slug;
            }
            return view('setting::faq_employee.faqEdit', $data);
        }
        else {
            $e = ['e' => 'Something went wrong. Please try again.'];

            return back()->witherrors($e);
        }
    }

    public function faqUpdate(Request $request, $slug) {
        $exploded = MyHelper::explodeSlug($slug);
        $id = $exploded[0];
        $created_at = $exploded[1];
        $post =[
            'id_employee_faq'    => $id,
            'faq_question'  => $request['question'],
            'faq_answer'    => $request['answer']
        ];
        
        $update = MyHelper::post('employee/be/profile/faq/update', $post);

        return parent::redirect($update, 'FAQ has been updated.');
    }

    public function faqDelete($slug) {
        $exploded = MyHelper::explodeSlug($slug);
        $id = $exploded[0];
        $created_at = $exploded[1];
        $delete = MyHelper::post('employee/be/profile/faq/delete', ['id_employee_faq' => $id,'created_at',$created_at]);

        return parent::redirect($delete, 'FAQ has been deleted.');
    }
    public function faqPopularCreate($slug) {
        $exploded = MyHelper::explodeSlug($slug);
        $id = $exploded[0];
        $created_at = $exploded[1];
        $delete = MyHelper::post('employee/be/profile/faq/popular/create', ['id_employee_faq' => $id,'created_at',$created_at]);

        return parent::redirect($delete, 'FAQ popular has been created.');
    }
    public function faqPopularDelete($slug) {
        $exploded = MyHelper::explodeSlug($slug);
        $id = $exploded[0];
        $created_at = $exploded[1];
        $delete = MyHelper::post('employee/be/profile/faq/popular/delete', ['id_employee_faq' => $id,'created_at',$created_at]);

        return parent::redirect($delete, 'FAQ popular has been deleted.');
    }

}
