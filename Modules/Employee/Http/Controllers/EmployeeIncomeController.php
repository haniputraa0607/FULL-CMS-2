<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class EmployeeIncomeController extends Controller
{
    public function setting_delivery(Request $request){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Setting Delivery Income',
            'menu_active'    => 'setting-delivery-income',
            'submenu_active'    => 'setting-delivery-income',
        ];
        if($post){
            $query = MyHelper::post('setting/setting-delivery-income-create', $post);
            if(($query['status']??'')=='success'){
                return back()->with('success',['Success update data']);
            }else{
                return back()->withErrors([$query['message']]);
            }
        }else{
            $query = MyHelper::get('setting/setting-delivery-income');
            $data['result'] = $query;
            return view('employee::income.setting_delivery_income', $data);
        }
    }
    public function default_basic_salary(Request $request){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Default Basic Salary',
            'menu_active'    => 'default-basic-salary',
            'submenu_active'    => 'default-basic-salary',
        ];
        if($post){
            $post['value'] = str_replace(',','', $post['value']??0);
            $query = MyHelper::post('setting/setting-basic-salary-create', $post);
            if(($query['status']??'')=='success'){
                return back()->with('success',['Success update data']);
            }else{
                return back()->withErrors([$query['message']]);
            }
        }else{
            $query = MyHelper::get('setting/setting-basic-salary');
            $data['result'] = $query;
            return view('employee::income.setting_basic_salary', $data);
        }
    }
}
