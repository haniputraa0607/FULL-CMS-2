<?php

namespace Modules\Academy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Session;

class AcademyScheduleController extends Controller
{
    public function listUserAcademy(Request $request){
        $data = [
            'title'          => 'Academy',
            'menu_active'    => 'academy-transaction',
            'sub_title'      => 'Student List',
            'submenu_active' => 'academy-transaction-schedule',
            'filter_title'   => 'Filter Student',
            'filter_date'    => true,
            'filter_date_today' => true,
        ];

        if(session('academy_trx_user')){
            $extra=session('academy_trx_user');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra = [];
            $data['rule']=array_map('array_values', $extra['rule']??[]);
            $data['operator']=$extra['operator']??'';
            $data['hide_record_total']=1;
        }

        if ($request->wantsJson()) {
            $data = MyHelper::post('academy/transaction/user/schedule', $extra + $request->all());
            return $data['result'];
        }

        $dateRange = [];
        foreach ($data['rule']??[] as $rule) {
            if ($rule[0] == 'transaction_date') {
                if ($rule[1] == '<=') {
                    $dateRange[0] = $rule[2];
                } elseif ($rule[1] == '>=') {
                    $dateRange[1] = $rule[2];
                }
            }
        }

        if (count($dateRange) == 2 && $dateRange[0] == $dateRange[1] && $dateRange[0] == date('Y-m-d')) {
            $data['is_today'] = true;
        }

        return view('academy::list_user', $data);
    }

    public function filterListUserAcademy(Request $request)
    {
        $post = $request->all();
        if(($post['rule']??false) && !isset($post['draw'])){
            session(['academy_trx_user'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['academy_trx_user'=>null]);
            return back();
        }

        return abort(404);
    }

    public function detailScheduleUserAcademy($id_user){
        $data = [
            'title'          => 'Academy',
            'menu_active'    => 'academy-transaction',
            'sub_title'      => 'User Transaction Academy',
            'submenu_active' => 'academy-transaction-schedule'
        ];

        $res = MyHelper::post('academy/transaction/user/schedule/detail', ['id_user' => $id_user]);
        if(!empty($res['result'])){
            $data['result'] = $res['result'];
        }else{
            return redirect('academy/transaction/user/schedule')->withErrors($res['messages']??['Failed get detail user schedule']);
        }
        return view('academy::transaction_academy_user', $data);
    }

    public function listScheduleAcademy($id_transaction_academy){
        $data = [
            'title'          => 'Academy',
            'menu_active'    => 'academy-transaction',
            'sub_title'      => 'Student Schedule',
            'submenu_active' => 'academy-transaction-schedule'
        ];

        $res = MyHelper::post('academy/transaction/user/schedule/detail/list', ['id_transaction_academy' => $id_transaction_academy]);

        if(!empty($res['result'])){
            $data['res'] = $res['result'];
        }else{
            return redirect('academy/transaction/user/schedule')->withErrors($res['messages']??['Failed get detail list schedule']);
        }

        return view('academy::schedule_detail', $data);
    }

    public function updateScheduleUserAcademy(Request $request, $id_transaction_academy){
        $post = $request->except('_token');
        $update = MyHelper::post('academy/transaction/user/schedule/update', array_merge($post, ['id_transaction_academy' => $id_transaction_academy]));

        if(isset($update['status']) && $update['status'] == 'success'){
            return redirect('academy/transaction/user/schedule/detail/list/'.$id_transaction_academy)->withSuccess(['Success update user schedule']);
        }else{
            return redirect('academy/transaction/user/schedule/detail/list/'.$id_transaction_academy)->withErrors($update['messages']??['Failed update user schedule']);
        }
    }

    public function listDayOffUserAcademy(Request $request){
        $data = [
            'title'          => 'Academy',
            'menu_active'    => 'academy-transaction',
            'sub_title'      => 'Day Off User Academy',
            'submenu_active' => 'academy-transaction-day-off',
            'filter_title'   => 'Filter User'
        ];

        if(session('academy_trx_day_off_user')){
            $extra=session('academy_trx_day_off_user');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra = [];
            $data['rule']=array_map('array_values', $extra['rule']??[]);
            $data['operator']=$extra['operator']??'';
            $data['hide_record_total']=1;
        }

        if ($request->wantsJson()) {
            $data = MyHelper::post('academy/transaction/user/schedule/day-off', $extra + $request->all());
            return $data['result'];
        }

        $dateRange = [];
        foreach ($data['rule']??[] as $rule) {
            if ($rule[0] == 'transaction_date') {
                if ($rule[1] == '<=') {
                    $dateRange[0] = $rule[2];
                } elseif ($rule[1] == '>=') {
                    $dateRange[1] = $rule[2];
                }
            }
        }

        if (count($dateRange) == 2 && $dateRange[0] == $dateRange[1] && $dateRange[0] == date('Y-m-d')) {
            $data['is_today'] = true;
        }

        return view('academy::list_day_off_user', $data);
    }

    public function filterListDayOffUserAcademy(Request $request)
    {
        $post = $request->all();
        if(($post['rule']??false) && !isset($post['draw'])){
            session(['academy_trx_day_off_user'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['academy_trx_day_off_user'=>null]);
            return back();
        }

        return abort(404);
    }

    public function actionDayOffUserAcademy(Request $request){
        $post = $request->except('_token');
        $save = MyHelper::post('academy/transaction/user/schedule/day-off/action', $post);

        if(!empty($post['status']) && $post['status'] == 'approve'){
            return parent::redirect($save, 'Success approve day off.', 'academy/transaction/user/schedule/day-off');
        }
        return $save;
    }

    public function outletCourseAcademy($key = null){
        $data = [
            'title'          => 'Academy',
            'menu_active'    => 'academy-transaction',
            'sub_title'      => 'Outlet Course',
            'submenu_active' => 'academy-transaction-outlet-course'
        ];

        $outlet = MyHelper::post('outlet/be/list', ['admin' =>  1, 'outlet_academy_status' => 1]);
        if (isset($outlet['status']) && $outlet['status'] == 'success') {
            $data['outlet'] = $outlet['result'];
        } elseif (isset($outlet['status']) && $outlet['status'] == 'fail') {
            return back()->witherrors([$outlet['messages']]);
        } else {
            return back()->witherrors(['Outlet Not Found']);
        }

        if (!is_null($key)) {
            $data['key'] = $key;
        } else {
            $data['key'] = $data['outlet'][0]['id_outlet'];
        }

        $data['course'] = MyHelper::post('academy/transaction/outlet/course', ['id_outlet' => $data['key']])['result']??[];

        return view('academy::outlet_course', $data);
    }

    public function detailOutletCourseAcademy($id_outlet, $id_product){
        $data = [
            'title'          => 'Academy',
            'menu_active'    => 'academy-transaction',
            'sub_title'      => 'Outlet Course Detail',
            'submenu_active' => 'academy-transaction-outlet-course',
            'filter_title'   => 'Filter Student',
            'filter_date'    => true,
            'filter_date_today' => true,
        ];

        if(session('academy_course_detail_trx_user')){
            $extra=session('academy_course_detail_trx_user');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra = [];
            $data['rule']=array_map('array_values', $extra['rule']??[]);
            $data['operator']=$extra['operator']??'';
            $data['hide_record_total']=1;
        }
        $res = MyHelper::post('academy/transaction/outlet/course/detail', ['id_outlet' => $id_outlet, 'id_product' => $id_product]+$extra)['result']??[];
        $data['outlet'] = $res['outlet']??[];
        $data['course'] = $res['course']??[];
        $data['users'] = $res['users']??[];
        $data['theories'] = $res['theories']??[];
        $data['total'] = count($data['users']);

        if(empty($data['outlet'])){
            return redirect('academy/transaction/outlet/course')->withErrors(['Data not found']);
        }
        return view('academy::outlet_course_detail', $data);
    }

    public function filterCourseDetailUser(Request $request)
    {
        $post = $request->all();
        if(($post['rule']??false) && !isset($post['draw'])){
            session(['academy_course_detail_trx_user'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['academy_course_detail_trx_user'=>null]);
            return back();
        }

        return abort(404);
    }

    public function saveAttendanceCourseAcademy(Request $request){
        $post = $request->except('_token');

        $save = MyHelper::post('academy/transaction/outlet/course/attendance', $post);
        if(isset($save['status']) && $save['status'] == 'success'){
            return back()->withSuccess(['Update attendance success']);
        } else{
            return back()->withErrors($save['messages']??['Failed update attendance']);
        }
    }

    public function saveFinalScoreCourseAcademy(Request $request){
        $post = $request->except('_token');

        $save = MyHelper::post('academy/transaction/outlet/course/final-score', $post);
        if(isset($save['status']) && $save['status'] == 'success'){
            return back()->withSuccess(['Update final score success']);
        } else{
            return back()->withErrors($save['messages']??['Failed update final score']);
        }
    }

    public function courseDetailHistory($id){
        $data = [
            'title'          => 'Academy',
            'menu_active'    => 'academy-transaction',
            'sub_title'      => 'User Course Detail',
            'submenu_active' => 'academy-transaction-outlet-course'
        ];

        $detail = MyHelper::post('academy/transaction/outlet/course/user-detail', ['id_transaction_academy' => $id]);
        if (isset($detail['status']) && $detail['status'] == 'success') {
            $data['outlet'] = $detail['result']['outlet']??[];
            $data['course'] = $detail['result']['course']??[];
            $data['user'] = $detail['result']['user']??[];
            $data['theories'] = $detail['result']['theories']??[];
            $data['schedule'] = $detail['result']['schedule']??[];
        } elseif (isset($detail['status']) && $detail['status'] == 'fail') {
            return back()->witherrors([$detail['messages']]);
        } else {
            return back()->witherrors(['Detail Not Found']);
        }
        return view('academy::outlet_course_detail_user', $data);
    }
}
