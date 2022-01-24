<?php

namespace Modules\Recruitment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class HairstylistAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'title'          => 'Hairstylist Schedule',
            'sub_title'      => 'Attendance',
            'menu_active'    => 'hairstylist',
            'submenu_active' => 'hairstylist-schedule',
            'child_active'   => 'hairstylist-attendance-list',
            'filter_title'   => 'Filter Hairstylist Attendance',
            'filter_date'    => true,
            'outlets'        => MyHelper::get('outlet/be/list/simple')['result'] ?? [],
        ];
        $post = $request->all();

        if(session('list_attendance_filter')){
            $extra=session('list_attendance_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    9998 => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1',
                    ],
                    9999 => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1',
                    ],
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }
        
        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('recruitment/hairstylist/be/attendance/list', $extra + $post);
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            return response()->json($arr_result);
        }

        return view('recruitment::attendance.index', $data);
    }

    /**
     * apply filter.
     * @return Response
     */
    public function filter(Request $request)
    {
        $post = $request->all();

        if(($post['rule']??false) && !isset($post['draw'])){
            if (($post['filter_type'] ?? false) == 'today') {
                $post['rule'][9998] = [
                    'subject' => 'transaction_date',
                    'operator' => '>=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
                $post['rule'][9999] = [
                    'subject' => 'transaction_date',
                    'operator' => '<=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
            }
            session(['list_attendance_filter'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['list_attendance_filter'=>null]);
            return back();
        }

        return abort(404);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function detail(Request $request, $id)
    {
        $data = [
            'title'          => 'Hairstylist Schedule',
            'sub_title'      => 'Attendance',
            'menu_active'    => 'hairstylist',
            'submenu_active' => 'hairstylist-schedule',
            'child_active'   => 'hairstylist-attendance-list',
            'filter_title'   => 'Filter Date',
            'filter_date'    => true,
        ];
        $post = $request->all();

        if(session('list_attendance_filter')){
            $extra=session('list_attendance_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    9998 => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1',
                    ],
                    9999 => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1',
                    ],
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }
        
        $extra['rule'][] = [
            'subject' => 'id_user_hair_stylist',
            'operator' => '=',
            'parameter' => $id,
            'hide' => '1',
        ];

        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('recruitment/hairstylist/be/attendance/detail', $extra + $post);
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            return response()->json($arr_result);
        }

        return view('recruitment::attendance.detail', $data);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function listPending(Request $request)
    {
        $data = [
            'title'          => 'Hairstylist Schedule',
            'sub_title'      => 'Attendance',
            'menu_active'    => 'hairstylist',
            'submenu_active' => 'hairstylist-schedule',
            'child_active'   => 'hairstylist-attendance-pending',
            'filter_title'   => 'Filter Pending Attendance',
            'filter_date'    => true,
            'outlets'        => MyHelper::get('outlet/be/list/simple')['result'] ?? [],
        ];
        $post = $request->all();

        if(session('list_attendance_pending_filter')){
            $extra=session('list_attendance_pending_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    9998 => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1',
                    ],
                    9999 => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1',
                    ],
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }
        
        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('recruitment/hairstylist/be/attendance-pending/list', $extra + $post);
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            return response()->json($arr_result);
        }

        return view('recruitment::attendance.list_pending', $data);
    }

    /**
     * apply filter.
     * @return Response
     */
    public function filterPending(Request $request)
    {
        $post = $request->all();

        if(($post['rule']??false) && !isset($post['draw'])){
            if (($post['filter_type'] ?? false) == 'today') {
                $post['rule'][9998] = [
                    'subject' => 'transaction_date',
                    'operator' => '>=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
                $post['rule'][9999] = [
                    'subject' => 'transaction_date',
                    'operator' => '<=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
            }
            session(['list_attendance_pending_filter'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['list_attendance_pending_filter'=>null]);
            return back();
        }

        return abort(404);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function detailPending(Request $request, $id)
    {
        $data = [
            'title'          => 'Hairstylist Schedule',
            'sub_title'      => 'Attendance',
            'menu_active'    => 'hairstylist',
            'submenu_active' => 'hairstylist-schedule',
            'child_active'   => 'hairstylist-attendance-pending',
            'filter_title'   => 'Filter Date',
            'filter_date'    => true,
        ];
        $post = $request->all();

        if(session('list_attendance_pending_filter')){
            $extra=session('list_attendance_pending_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    9998 => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1',
                    ],
                    9999 => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1',
                    ],
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }
        
        $extra['rule'][] = [
            'subject' => 'id_user_hair_stylist',
            'operator' => '=',
            'parameter' => $id,
            'hide' => '1',
        ];

        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('recruitment/hairstylist/be/attendance-pending/detail', $extra + $post);
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            return response()->json($arr_result);
        }

        return view('recruitment::attendance.detail_pending', $data);
    }

    public function updatePending(Request $request)
    {
        $update = MyHelper::post('recruitment/hairstylist/be/attendance-pending/update', $request->all());
        if (($update['status'] ?? false) == 'success') {
            return back()->withSuccess([$update['result']['message'] ?? 'Success update pending attendance']);
        }
        return back()->withErrors($update['messages'] ?? ['Something went wrong']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function listRequest(Request $request)
    {
        $data = [
            'title'          => 'Hairstylist Schedule',
            'sub_title'      => 'Attendance',
            'menu_active'    => 'hairstylist',
            'submenu_active' => 'hairstylist-schedule',
            'child_active'   => 'hairstylist-attendance-request',
            'filter_title'   => 'Filter Request Attendance',
            'filter_date'    => true,
            'outlets'        => MyHelper::get('outlet/be/list/simple')['result'] ?? [],
        ];
        $post = $request->all();

        if(session('list_attendance_request_filter')){
            $extra=session('list_attendance_request_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    9998 => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1',
                    ],
                    9999 => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1',
                    ],
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }
        
        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('recruitment/hairstylist/be/attendance-request/list', $extra + $post);
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            return response()->json($arr_result);
        }

        return view('recruitment::attendance.list_request', $data);
    }

    /**
     * apply filter.
     * @return Response
     */
    public function filterRequest(Request $request)
    {
        $post = $request->all();

        if(($post['rule']??false) && !isset($post['draw'])){
            if (($post['filter_type'] ?? false) == 'today') {
                $post['rule'][9998] = [
                    'subject' => 'transaction_date',
                    'operator' => '>=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
                $post['rule'][9999] = [
                    'subject' => 'transaction_date',
                    'operator' => '<=',
                    'parameter' => date('Y-m-d'),
                    'hide' => '1',
                ];
            }
            session(['list_attendance_request_filter'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['list_attendance_request_filter'=>null]);
            return back();
        }

        return abort(404);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function detailRequest(Request $request, $id)
    {
        $data = [
            'title'          => 'Hairstylist Schedule',
            'sub_title'      => 'Attendance',
            'menu_active'    => 'hairstylist',
            'submenu_active' => 'hairstylist-schedule',
            'child_active'   => 'hairstylist-attendance-request',
            'filter_title'   => 'Filter Date',
            'filter_date'    => true,
        ];
        $post = $request->all();

        if(session('list_attendance_request_filter')){
            $extra=session('list_attendance_request_filter');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    9998 => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1',
                    ],
                    9999 => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1',
                    ],
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }
        
        $extra['rule'][] = [
            'subject' => 'id_user_hair_stylist',
            'operator' => '=',
            'parameter' => $id,
            'hide' => '1',
        ];

        if ($request->wantsJson()) {
            $draw = $request->draw;

            $list = MyHelper::post('recruitment/hairstylist/be/attendance-request/detail', $extra + $post);
            if(isset($list['status']) && $list['status'] == 'success'){
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = $list['result']['total'];
                $arr_result['recordsFiltered'] = $list['result']['total'];
                $arr_result['data'] = $list['result']['data'];
            }else{
                $arr_result['draw'] = $draw;
                $arr_result['recordsTotal'] = 0;
                $arr_result['recordsFiltered'] = 0;
                $arr_result['data'] = array();
            }

            return response()->json($arr_result);
        }

        return view('recruitment::attendance.detail_request', $data);
    }

    public function updateRequest(Request $request)
    {
        $update = MyHelper::post('recruitment/hairstylist/be/attendance-request/update', $request->all());
        if (($update['status'] ?? false) == 'success') {
            return back()->withSuccess([$update['result']['message'] ?? 'Success update request attendance']);
        }
        return back()->withErrors($update['messages'] ?? ['Something went wrong']);
    }
}
