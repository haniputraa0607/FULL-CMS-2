<?php

namespace Modules\Academy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Session;

class AcademyController extends Controller
{
    public function settingInstallment(){
        $data = [
            'title'          => 'Academy',
            'sub_title'      => 'Setting Installment',
            'menu_active'    => 'academy-transaction',
            'submenu_active' => 'academy-installment'
        ];

        $data['result'] = MyHelper::get('academy/setting/installment')['result']??[];
        $data['arr_step_installment'] = json_encode(array_column($data['result'], 'total_installment'));
        return view('academy::installment', $data);
    }

    public function settingInstallmentSave(Request $request){
        $post = $request->except('_token');
        $save = MyHelper::post('academy/setting/installment/save', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('academy/setting/installment')->withSuccess(['Success save data']);
        }else{
            return redirect('academy/setting/installment')->withErrors(['Failed save data'])->withInput();
        }
    }

    public function settingBanner(){
        $data = [
            'title'          => 'Academy',
            'sub_title'      => 'Setting Banner',
            'menu_active'    => 'academy-transaction',
            'submenu_active' => 'academy-banner'
        ];

        $data['result'] = MyHelper::get('academy/setting/banner')['result']??[];
        return view('academy::banner', $data);
    }

    public function settingBannerSave(Request $request){
        $post = $request->except('_token');
        if(!empty($post['value'])){
            $post['value'] = MyHelper::encodeImage($post['value']);
        }
        $save = MyHelper::post('academy/setting/banner/save', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('academy/setting/banner')->withSuccess(['Success save data']);
        }else{
            return redirect('academy/setting/banner')->withErrors(['Failed save data'])->withInput();
        }
    }
}
