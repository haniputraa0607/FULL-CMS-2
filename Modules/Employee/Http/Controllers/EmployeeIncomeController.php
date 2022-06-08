<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class EmployeeIncomeController extends Controller
{
    public function setting_global_commission(Request $request){
        $post = $request->except('_token');
        $data = [
            'title'          => 'Setting Global Commission Engine',
            'menu_active'    => 'setting-comiisission-engine',
            'submenu_active'    => 'setting-comiisission-engine',
        ];
        if($post){
            $query = MyHelper::post('setting/global_commission_product_create', $post);
            if(($query['status']??'')=='success'){
                return redirect('setting/setting-global-commission')->with('success',['Success update data']);
            }else{
                return redirect('setting/setting-global-commission')->withErrors([$query['message']]);
            }
        }else{
            $query = MyHelper::get('setting/global_commission_product');
            $data['result'] = $query;
            return view('setting::setting_global_commission', $data);
        }
    }
}
