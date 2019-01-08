<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;

use App\Lib\MyHelper;

class WebviewUserController extends Controller
{
    // get webview form
    public function completeProfile(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return abort(404);
        }

        $user = parent::getData(MyHelper::getWithBearer('users/get', $bearer));
        if (empty($user)) {
            return [
                'status' => 'fail',
                'messages' => 'Unauthorize.'
            ];
        }

        $data['cities'] = parent::getData(MyHelper::get('city/list'));

        $data['user'] = [];
        // get only some data
        if ($user) {
            $user_data['phone']    = $user['phone'];
            $user_data['gender']   = $user['gender'];
            $user_data['birthday'] = $user['birthday'];
            $user_data['id_city']  = $user['id_city'];
            
            $data['user'] = $user_data;
        }
        
        return view('users::webview_complete_profile', $data);
    }

    public function completeProfileSubmit(Request $request, $user_phone)
    {
        $post = $request->except('_token');
        $post['phone'] = $user_phone;

        // convert date format
        if (isset($post['birthday'])) {
            $post['birthday'] = date('Y-m-d', strtotime($post['birthday']));
        }
        
        $result = MyHelper::post('users/complete-profile', $post);

        if ($result['status']=="success") {
            $data['messages'] = ["Save data success", "Thank you"];
            return view('users::webview_complete_profile_success', $data);
        }
        else{
            return back()->withInput()->withErrors(['Save data fail']);
        }
    }

}
