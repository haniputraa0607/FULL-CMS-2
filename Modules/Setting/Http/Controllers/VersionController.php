<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class VersionController extends Controller
{
    function index(Request $request)
    {
        $post = $request->except('_token');
        $data = [
            'title'             => 'Version Control Setting',
            'menu_active'       => 'setting-version',
            'submenu_active'    => 'setting-version'
        ];
        if (!empty($post)) {
            if (isset($post['Display']['version_image_mobile'])) {
                $post['Display']['version_image_mobile'] = MyHelper::encodeImage($post['Display']['version_image_mobile']);
            } elseif (isset($post['Display']['version_image_outlet'])) {
                $post['Display']['version_image_outlet'] = MyHelper::encodeImage($post['Display']['version_image_outlet']);
            } elseif (isset($post['Display']['version_image_mitra'])) {
                $post['Display']['version_image_mitra'] = MyHelper::encodeImage($post['Display']['version_image_mitra']);
            } elseif (isset($post['Display']['version_image_employee'])) {
                $post['Display']['version_image_employee'] = MyHelper::encodeImage($post['Display']['version_image_employee']);
            } elseif (isset($post['Display']['version_image_web'])) {
                $post['Display']['version_image_web'] = MyHelper::encodeImage($post['Display']['version_image_web']);
            }
            
            $save = MyHelper::post('version/update', $post);
            if (isset($save['status']) && $save['status'] == "success") {
                return redirect('version')->withSuccess(['Version Setting has been updated.']);
            } else {
                if (isset($save['errors'])) {
                    return back()->withErrors($save['errors'])->withInput();
                }
                if (isset($save['status']) && $save['status'] == "fail") {
                    return back()->withErrors($save['messages'])->withInput();
                }
                return back()->withErrors(['Something when wrong. Please try again.'])->withInput();
            }
        }

        $version = MyHelper::get('version/list');
        if (isset($version['status']) && $version['status'] == "success") {
            $data['version'] = $version['result'];
        } else {
            $data['version'] = [
            	'Android' 	    => [], 
            	'IOS' 		    => [], 
            	'OutletApp'     => [],
            	'MitraApp' 	    => [],
            	'EmployeeAndrioid' 	=> [],
            	'EmployeeIOS' 	=> [],
            	'WebApp' 	    => []
            ];
        }
        
        return view('setting::version.setting-version', $data);
    }
}
