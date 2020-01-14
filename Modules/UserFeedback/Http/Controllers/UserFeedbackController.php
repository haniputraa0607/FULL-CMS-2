<?php

namespace Modules\UserFeedback\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class UserFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request,$key = '')
    {                    
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'User Feedback List',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'user-feedback-list',
            'key'            => $key
        ];
        $page = $request->get('page')?:1;
        $post = [];
        if($key){
            $post['outlet_code'] = $key;
        }
        $data['feedbackData'] = MyHelper::post('user-feedback?page='.$page,$post)['result']??[];
        $data['outlets'] = MyHelper::get('outlet/be/list')['result']??[];
        $data['next_page'] = $data['feedbackData']['next_page_url']?url()->current().'?page='.($page+1):'';
        $data['prev_page'] = $data['feedbackData']['prev_page_url']?url()->current().'?page='.($page-1):'';
        return view('userfeedback::index',$data);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'User Feedback Detail',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'user-feedback-detail'
        ];
        $ids = explode('#',base64_decode($id));
        if(!is_numeric($ids[0])||!is_numeric($ids[1])){
            return back()->withErrors(['User feedback not found']);
        }
        $post = [
            'id_user_feedback' => $ids[0]??'',
            'id_transaction' => $ids[1]??''
        ];
        $data['feedback'] = MyHelper::post('user-feedback/detail',$post)['result']??false;
        if(!$data['feedback']){
            return back()->withErrors(['User feedback not found']);
        }
        return view('userfeedback::show',$data);
    }
    public function setting(Request $request) {
        $data = [
            'title'          => 'User Feedback',
            'sub_title'      => 'User Feedback Setting',
            'menu_active'    => 'user-feedback',
            'submenu_active' => 'feedback-setting'
        ];
        $ratings = MyHelper::post('setting',['key-like'=>'rating'])['result']??[];
        $popups = MyHelper::post('setting',['key-like'=>'popup'])['result']??[];
        $data['rating'] = [];
        $data['popup'] = [];
        foreach ($ratings as $rating) {
            $data['setting'][$rating['key']] = $rating;
        }
        foreach ($popups as $popup) {
            $data['setting'][$popup['key']] = $popup;
        }
        return view('userfeedback::setting',$data);
    }

    public function settingUpdate(Request $request) {
        $data = [
            'popup_min_interval' => ['value',$request->post('popup_min_interval')],
            'popup_max_refuse' => ['value',$request->post('popup_max_refuse')],
            'rating_question_text' => ['value_text',substr($request->post('rating_question_text'),0,40)]
        ];
        $update = MyHelper::post('setting/update2',['update'=>$data]);
        if(($update['status']??false)=='success'){
            return back()->with('success',['Success update setting']);
        }else{
            dd($update);
            return back()->withInput()->withErrors(['Failed update setting']);
        }
    }
}
