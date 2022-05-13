<?php

namespace Modules\Outlet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class OfficeBranchController extends Controller
{
    /**
     * list
     */
    public function index(Request $request) {
        $data = [
            'title'          => 'Office Branch',
            'sub_title'      => 'Office Branch List',
            'menu_active'    => 'office-branch',
            'submenu_active' => 'office-branch-list',
        ];

        // outlet
        $outlet = MyHelper::post('outlet/be/list', ['office_only' => 1, 'all_outlet' => 1]);

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        }
        else {
            $data['outlet'] = [];
        }

        return view('outlet::office.list', $data);
    }

    public function holiday(Request $request) {
        $data = [
            'title'          => 'Office Branch',
            'sub_title'      => 'Office Holliday',
            'menu_active'    => 'office-branch',
            'submenu_active' => 'office-branch-holiday',
        ];
        $outlet = MyHelper::post('outlet/be/list', ['office_only' => 1]);

        if (isset($outlet['status']) && $outlet['status'] == "success") {
            $data['outlet'] = $outlet['result'];
        }
        else {
            return redirect('office-branch/create')->withErrors('Create Outlet First');
        }

        $holiday = MyHelper::post('outlet/holiday/list', ['office_only' => 1]);
        if (isset($holiday['status']) && $holiday['status'] == "success") {
            $data['holiday'] = $holiday['result'];
        }
        else {
            $data['holiday'] = [];
        }
        return view('outlet::office.holiday', $data);
    }

    function detailHoliday(Request $request, $id_holiday) {
        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Office',
                'sub_title'      => 'Office Holliday',
                'menu_active'    => 'office-branch',
                'submenu_active' => 'office-branch-holiday',
            ];

            $holiday = MyHelper::post('outlet/holiday/list', ['id_holiday' => $id_holiday, 'office_only' => 1]);

            if (isset($holiday['status']) && $holiday['status'] == "success") {
                $data['holiday']    = $holiday['result'][0];
            }
            else {
                $e = ['e' => 'Data office holiday not found.'];
                return back()->witherrors($e);
            }

            $outlet = MyHelper::post('outlet/be/list', ['office_only' => 1]);

            if (isset($outlet['status']) && $outlet['status'] == "success") {
                $data['outlet'] = $outlet['result'];
            }
            else {
                $e = ['e' => 'Data outlet not found.'];
                return redirect('office-branch/list')->witherrors($e);
            }

            return view('outlet::outlet_holiday_update', $data);
        }
        //update
        else {

            $post['id_holiday'] = $id_holiday;
            $save = MyHelper::post('outlet/holiday/update', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return parent::redirect($save, 'Office Holiday has been updated.', 'office-branch/holiday');
            }else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }

                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }

                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }
    }

    /**
     * create
     */
    public function create(Request $request) {
        $post = $request->except('_token');

        if (empty($post)) {

            $data = [
                'title'          => 'Office Branch',
                'sub_title'      => 'New Office Branch',
                'menu_active'    => 'office-branch',
                'submenu_active' => 'office-branch-new',
            ];

            // province
            $data['province'] = app('Modules\Outlet\Http\Controllers\OutletController')->getPropinsi();
            $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
            $data['delivery'] = MyHelper::get('transaction/be/available-delivery')['result']['delivery']??[];
            return view('outlet::office.create', $data);
        }
        else {

            if(!empty($post['outlet_latitude']) && (strpos($post['outlet_latitude'], ',') !== false || $post['outlet_latitude'] == 'NaN')){
                return back()->withErrors(['Please input invalid latitude']);
            }

            if(!empty($post['outlet_longitude']) && (strpos($post['outlet_longitude'], ',') !== false || $post['outlet_longitude'] == 'NaN')){
                return back()->withErrors(['Please input invalid longitude']);
            }

            if(isset($post['ampas'])){
                unset($post['ampas']);
            }
            if (isset($post['next'])) {
                $next = 1;
                unset($post['next']);
            }

            $post = array_filter($post);

            $save = MyHelper::post('outlet/create', $post);
            // return $save;
            if (isset($save['status']) && $save['status'] == "success") {
                if (isset($next)) {
                    return parent::redirect($save, 'Office Branch has been created.', 'office-branch/detail/'.$save['result']['outlet_code'].'#photo');
                }
                else {
                    return parent::redirect($save, 'Office Branch has been created.', 'office-branch/list');
                }
            }else {
                   if (isset($save['errors'])) {
                       return back()->withErrors($save['errors'])->withInput();
                   }

                   if (isset($save['status']) && $save['status'] == "fail") {
                       return back()->withErrors($save['messages'])->withInput();
                   }

                   return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
               }

        }
    }

    /*
    Detail
    */
    function detail(Request $request, $code) {

        $post = $request->except('_token');

        if (empty($post)) {
            $data = [
                'title'          => 'Office Branch',
                'sub_title'      => 'Detail Office Branch',
                'menu_active'    => 'office-branch',
                'submenu_active' => 'office-branch-list',
            ];

            $outlet = MyHelper::post('outlet/be/list', ['outlet_code' => $code,'admin' => 1, 'qrcode' => 1, 'office_only' => 1]);
            $data['brands'] = MyHelper::get('brand/be/list')['result']??[];
            $data['delivery'] = MyHelper::get('transaction/be/available-delivery')['result']['delivery']??[];

            
            if (isset($outlet['status']) && $outlet['status'] == "success") {
                $data['outlet']    = $outlet['result'];
                $product = MyHelper::get('product/list/product-detail/'.$outlet['result'][0]['id_outlet']);
                
                if (isset($product['status']) && $product['status'] == "success") {
                    $data['product']    = $product['result'];
                }
                else {
                    $data['product'] = [];
                }
            }
            else {
                $e = ['e' => 'Data outlet not found'];
                return back()->witherrors($e);
            }


            // province
            $data['province'] = app('Modules\Outlet\Http\Controllers\OutletController')->getPropinsi();
            $data['default_box_url'] = MyHelper::post('setting', ['key'=>'outlet_box_default_url'])['result']['value']??null;
            // return $data;
            // print_r($data); exit();
            return view('outlet::office.detail', $data);
        }
        else {
            if(!empty($post['outlet_latitude']) && (strpos($post['outlet_latitude'], ',') !== false || $post['outlet_latitude'] == 'NaN')){
                return back()->withErrors(['Please input invalid latitude'])->withInput();
            }

            if(!empty($post['outlet_longitude']) && (strpos($post['outlet_longitude'], ',') !== false || $post['outlet_longitude'] == 'NaN')){
                return back()->withErrors(['Please input invalid longitude'])->withInput();
            }

            if(!empty($post['outlet_image'])){
                $post['outlet_image'] = MyHelper::encodeImage($post['outlet_image']);
            }

            //change pin
            // return $post;
            if(isset($post['outlet_pin']) || isset($post['generate_pin_outlet'])){
                if (!isset($post['generate_pin_outlet'])) {
                    $validator = Validator::make($request->all(), [
                        'outlet_pin' => 'required|confirmed|min:6|max:6',
                    ],[
                        'confirmed' => 'Re-type PIN does not match',
                        'min'       => 'PIN must 6 digit',
                        'max'       => 'PIN must 6 digit'
                    ]);

                    if ($validator->fails()) {
                        return redirect('office-branch/detail/'.$code.'#pin')
                                    ->withErrors($validator)
                                    ->withInput();
                    }
                }

                $save = MyHelper::post('outlet/update/pin', $post);
                return parent::redirect($save, 'Outlet pin has been changed.', 'office-branch/detail/'.$code.'#pin');
            }

            if (isset($post['generate_pin_outlet'])) {
                $save          = MyHelper::post('outlet/update/pin', $post);
                return parent::redirect($save, 'Outlet photo has been added.', 'office-branch/detail/'.$code.'#photo');
            }

            // photo
            if (isset($post['photo'])) {
                $post['photo'] = MyHelper::encodeImage($post['photo']);

                // save
                $save          = MyHelper::post('outlet/photo/create', $post);
                return parent::redirect($save, 'Outlet photo has been added.', 'office-branch/detail/'.$code.'#photo');
            }

            // order photo
            if (isset($post['id_outlet_photo'])) {
                for ($x= 0; $x < count($post['id_outlet_photo']); $x++) {
                    $data = [
                        'id_outlet_photo' => $post['id_outlet_photo'][$x],
                        'outlet_photo_order' => $x+1,
                    ];

                    /**
                     * save product photo
                     */
                    $save = MyHelper::post('outlet/photo/update', $data);

                    if (!isset($save['status']) || $save['status'] != "success") {
                        return redirect('office-branch/detail/'.$code.'#photo')->witherrors(['Something went wrong. Please try again.']);
                    }
                }

                return redirect('office-branch/detail/'.$code.'#photo')->with('success', ['Photo\'s order has been updated']);
            }

            // update
            if (isset($post['id_outlet'])) {
                if(!empty($post['outlet_open_hours'])) $post['outlet_open_hours']  = date('H:i:s', strtotime($post['outlet_open_hours']));
                if(!empty($post['outlet_open_hours'])) $post['outlet_close_hours'] = date('H:i:s', strtotime($post['outlet_close_hours']));

                $status_franchise = 0;

                if(isset($post['status_franchise'])){
                    $status_franchise = $post['status_franchise'];
                }
                
                $post = array_filter($post);
                if (isset($post["is_tax"]) && $post["is_tax"] == 'on') {
                    $post['is_tax'] = 10;
                }else{
                    $post['is_tax'] = 0;
                }

                $post['status_franchise'] = $status_franchise;

                $save = MyHelper::post('outlet/update', $post);

                if(isset($post['outlet_code'])){
                    $code = $post['outlet_code'];
                }

                if (isset($save['status']) && $save['status'] == "success") {
                    return parent::redirect($save, 'Outlet has been updated.', 'office-branch/detail/'.$code.'#info');
                }else {
                       if (isset($save['errors'])) {
                           return back()->withErrors($save['errors'])->withInput();
                       }

                       if (isset($save['status']) && $save['status'] == "fail") {
                           return back()->withErrors($save['messages'])->withInput();
                       }

                       return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
                }

            }
        }
    }

}
