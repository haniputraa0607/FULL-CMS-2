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
    public function settingInstalment(){
        $data = [
            'title'          => 'Academy',
            'sub_title'      => 'Setting Instalment',
            'menu_active'    => 'academy',
            'submenu_active' => 'academy-instalment'
        ];

        $data['result'] = MyHelper::get('academy/setting/instalment')['result']??[];
        $data['arr_step_instalment'] = json_encode(array_column($data['result'], 'total_instalment'));
        return view('academy::instalment', $data);
    }

    public function settingInstalmentSave(Request $request){
        $post = $request->except('_token');
        $save = MyHelper::post('academy/setting/instalment/save', $post);
        if (isset($save['status']) && $save['status'] == "success") {
            return redirect('academy/setting/instalment')->withSuccess(['Success save data']);
        }else{
            return redirect('academy/setting/instalment')->withErrors(['Failed save data'])->withInput();
        }
    }

    public function settingBanner(){
        $data = [
            'title'          => 'Academy',
            'sub_title'      => 'Setting Banner',
            'menu_active'    => 'academy',
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
