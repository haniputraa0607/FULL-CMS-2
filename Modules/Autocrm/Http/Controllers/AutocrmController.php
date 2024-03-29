<?php

namespace Modules\Autocrm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Lib\MyHelper;

class AutocrmController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(){
		$data = [ 'title'             => 'Auto CRM',
				  'menu_active'       => 'autocrm',
				  'submenu_active'    => ''
				];
		$query = MyHelper::get('autocrm/list');
		$test = MyHelper::get('autocrm/textreplace');
		
		$data['data'] = $query['result'];
		if($test['status'] == 'success'){
			$data['textreplaces'] = $test['result'];
		}

        return view('autocrm::index', $data);
    }
	
    public function email(Request $request){
		$post = $request->except('_token');
		$query = MyHelper::post('autocrm/update', $post);
		return back();
    }
	
	public function sms(Request $request){
		$post = $request->except('_token');
		$query = MyHelper::post('autocrm/update', $post);
		return back();
    }
	
	public function push(Request $request){
		$post = $request->except('_token');
		if (isset($post['autocrm_push_image'])) {
			$post['autocrm_push_image'] = MyHelper::encodeImage($post['autocrm_push_image']);
		}
		// print_r($post);exit;
		$query = MyHelper::post('autocrm/update', $post);
		return back();
    }
	
	public function inbox(Request $request){
		$post = $request->except('_token');
		$query = MyHelper::post('autocrm/update', $post);
		return back();
    }
	
	public function forward(Request $request){
		$post = $request->except('_token');
		$query = MyHelper::post('autocrm/update', $post);
		return back();
    }
	
    public function mediaOn($media, $id){
		$post = [];
		$post['id_autocrm'] = MyHelper::explodeSlug($id)[0]??'';

		if($media == 'email') $post['autocrm_email_toogle'] = '1';
		if($media == 'sms') $post['autocrm_sms_toogle'] = '1';
		if($media == 'push') $post['autocrm_push_toogle'] = '1';
		if($media == 'inbox') $post['autocrm_inbox_toogle'] = '1';
		if($media == 'forward') $post['autocrm_forward_toogle'] = '1';
		
		$query = MyHelper::post('autocrm/update', $post);
		return back();
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('autocrm::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('autocrm::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
    public function autoResponse(Request $request, $type, $subject=null){
		$autocrmSubject = ucwords(str_replace('-',' ',$subject));
		$data = [ 'title'             => 'About Auto Response '.$autocrmSubject,
				  'menu_active'       => 'about-autoresponse',
				  'submenu_active'    => 'about-autoresponse-'.$subject
				];
		if($subject == null){
			$subject = $type;
			$autocrmSubject = ucwords(str_replace('-',' ',$subject));
		}elseif ($subject == 'create-quest-voucher' || $subject == 'update-quest-voucher'){
            $data = [
                'title'             => ucfirst($type),
                'sub_title'         => ' Auto Response '.$autocrmSubject,
                'menu_active'       => 'quest',
                'submenu_active'    => 'quest-voucher',
                'child_active'      => $type.'-autoresponse-'.$subject,
                'type' 			    => $type
            ];
        }elseif (in_array(
        	$subject, 
        	[
	        	'mitra-hs---transaction-service-created',
	    		'mitra-hs---transaction-service-rejected',
	    		'mitra-hs---transaction-service-completed',
	    		'mitra-spv---transaction-product-created',
	    		'mitra-spv---transaction-product-rejected',
	    		'mitra-spv---transaction-product-taken',
	    		'transaction-service-completed',
	    		'transaction-product-taken'
		    ])
	    ){
			$autocrmSubject = ucwords(str_replace('---','%hyphen%',$subject));
			$autocrmSubject = ucwords(str_replace('-',' ',$autocrmSubject));
			$autocrmSubject = ucwords(str_replace('%hyphen%',' - ',$autocrmSubject));

			$menuActive = explode('-', $type)[0];

            $data = [
                'title'             => ucfirst($type),
                'sub_title'         => ' Auto Response '.$autocrmSubject,
                'menu_active'       => $menuActive,
                'submenu_active'    => $type,
                'child_active'      => $type.'-'.$subject,
                'type' 			    => $type
            ];
        }else{
			$data = [ 'title'             => ucfirst($type),
					  'sub_title'         => ' Auto Response '.$autocrmSubject,
					  'menu_active'       => $type,
					  'submenu_active'    => $type.'-autoresponse-'.$subject,
					  'type' 			  => $type
					];
		}
		if(stristr($subject, 'enquiry')){
			$data['menu_active'] = 'enquiries';
			$data['submenu_active'] = 'autoresponse-'.$subject;
			$autocrmSubject = str_replace('_','-',$autocrmSubject);
			$data['title'] = 'Auto Response '.$autocrmSubject;
		}
		$query = MyHelper::post('autocrm/list', ['autocrm_title' => $autocrmSubject]);
		$test = MyHelper::get('autocrm/textreplace');
		$auto = null;
		$post = $request->except('_token');
		if(!empty($post)){
			if(!isset($post['attachment_mail'])){
				$post['attachment_mail']=0;
			}
			if(!isset($post['attachment_forward'])){
				$post['attachment_forward']=0;
			}
			if (isset($post['autocrm_push_image'])) {
				$post['autocrm_push_image'] = MyHelper::encodeImage($post['autocrm_push_image']);
			}
			
			$query = MyHelper::post('autocrm/update', $post);
			// print_r($query);exit;
			return back()->withSuccess(['Response updated']);
		}
		if(isset($query['result'])){
			$auto = $query['result'];
		}else{
			return back()->withErrors(['No such response']);
		}

		if(strpos($type, 'enquir')!== false){
			$data['attachment'] = '1';
		}

        $data['click_inbox'] = [
            ['value' => "No Action",'title' => 'No Action']
        ];
        $data['click_notification'] = [
            ['value' => 'Home','title' => 'Home']
        ];

		switch ($subject){
			case 'report-point-reset':
				$data['noUser'] = true;
				$data['customNotes'] = 'Previous user point data will be attached to the attachment';
            case 'update-quest-voucher':
            case 'create-quest-voucher':
			case 'update-promo-campaign':
			case 'create-promo-campaign':
			case 'update-deals':
			case 'create-deals':
			case 'update-inject-voucher':
			case 'create-inject-voucher':
			case 'update-welcome-voucher':
			case 'create-welcome-voucher':
			case 'update-news':
			case 'create-news':
				$data['forwardOnly'] = true;
				break;
			case 'delivery-rejected':
				$data['forwardOnly'] = true;
				break;
			case 'outlet-pin-sent':
				$data['active_response'] = ['email'];
				$test['result'] = [];
					break;
			case 'request-admin-user-franchise':
				$data['active_response'] = ['email','forward'];
				$test['result'] = [];
					break;
			case 'outlet-pin-sent-user-franchise':
				$data['active_response'] = ['email'];
				$test['result'] = [];
					break;
            case 'register-candidate-hair-stylist':
            case 'rejected-candidate-hair-stylist':
            case 'approve-candidate-hair-stylist':
            case 'reset-password-user-hair-stylist':
                $data['active_response'] = ['email'];
                $data['menu_active'] = 'hair-stylist';
                $data['submenu_active'] = 'hairstylist-autoresponse-'.$subject;
                $test['result'] = [];
                break;
            case 'approve-day-off-user-academy':
            case 'reject-day-off-user-academy':
                $data['menu_active'] = 'academy-transaction';
                $data['submenu_active'] = 'academy-autoresponse-'.$subject;
                $test['result'] = [];
                $data['click_inbox'] = [
                    ['value' => "history_academy",'title' => 'History Academy']
                ];
                break;
            case 'academy-course-reminder':
            case 'payment-academy-installment-completed':
            case 'payment-academy-installment-cancelled':
            case 'payment-academy-installment-reminder':
            case 'payment-academy-installment-due-date':
                $data['menu_active'] = 'academy-transaction';
                $data['submenu_active'] = 'academy-autoresponse-'.$subject;
                $data['click_notification'] = [
                    ['value' => "history_academy",'title' => 'History Academy']
                ];
                $data['click_inbox'] = [
                    ['value' => "history_academy",'title' => 'History Academy']
                ];
                break;
            case 'home-service-mitra-get-order':
                $data['menu_active'] = 'home-service-transaction';
                $data['submenu_active'] = 'home-service-autoresponse-'.$subject;
                $data['click_notification'] = [
                    ['value' => "home_service_history",'title' => 'History Home Service']
                ];
                $data['click_inbox'] = [
                    ['value' => "home_service_history",'title' => 'History Home Service']
                ];
                break;
            case 'home-service-update-status':
                $data['menu_active'] = 'home-service-transaction';
                $data['submenu_active'] = 'home-service-autoresponse-'.$subject;
                $data['click_notification'] = [
                    ['value' => "history_home_service",'title' => 'History Home Service']
                ];
                $data['click_inbox'] = [
                    ['value' => "history_home_service",'title' => 'History Home Service']
                ];
                break;
            case 'mitra-hs---transaction-service-created':
    			$data['click_inbox'] = [
                    ['value' => "outlet_service_ongoing",'title' => 'Outlet Service Ongoing'],
                    ['value' => "No Action",'title' => 'No Action']
                ];
                $data['click_notification'] = [
                    ['value' => "outlet_service_ongoing",'title' => 'Outlet Service Ongoing'],
                    ['value' => 'Home','title' => 'Home']
                ];
                break;

    		case 'mitra-hs---transaction-service-rejected':
    		case 'mitra-hs---transaction-service-completed':
                $data['click_inbox'] = [
                    ['value' => "outlet_service_history",'title' => 'Outlet Service history'],
                    ['value' => "No Action",'title' => 'No Action']
                ];
                $data['click_notification'] = [
                    ['value' => "outlet_service_history",'title' => 'Outlet Service history'],
                    ['value' => 'Home','title' => 'Home']
                ];
                break;
            case 'transaction-service-completed':
            case 'transaction-product-taken':
            case 'transaction-completed':
            case 'transaction-rejected':
                $data['click_inbox'] = [
                    ['value' => "History Transaction",'title' => 'History Transaction'],
                    ['value' => "No Action",'title' => 'No Action']
                ];
                $data['click_notification'] = [
                    ['value' => "History Transaction",'title' => 'History Transaction'],
                    ['value' => 'Home','title' => 'Home']
                ];
                break;
            case 'claim-point-existing-member':
                $data['click_inbox'] = [
                    ['value' => "claim_existing_point",'title' => 'Claim Existing Point']
                ];
                $data['click_notification'] = [
                    ['value' => "claim_existing_point",'title' => 'Claim Existing Point']
                ];
                break;
		}

        switch ($subject) {
        	case 'receive-quest-point':
                $data['click_inbox'] = [
                    ['value' => "History Point Quest",'title' => 'History Point'],
                    ['value' => "Quest",'title' => 'Quest']
                ];
                $data['click_notification'] = [
                    ['value' => "History Point Quest",'title' => 'History Point'],
                    ['value' => "Quest",'title' => 'Quest']
                ];
                break;

            case 'receive-quest-voucher':
                $data['click_inbox'] = [
                    ['value' => "Voucher Quest",'title' => 'Voucher'],
                    ['value' => "Quest",'title' => 'Quest']
                ];
                $data['click_notification'] = [
                    ['value' => 'Voucher Quest','title' => 'Voucher'],
                    ['value' => "Quest",'title' => 'Quest']
                ];
                break;

            case 'quest-completed':
                $data['click_inbox'] = [
                    ['value' => "Quest",'title' => 'Quest']
                ];
                $data['click_notification'] = [
                    ['value' => "Quest",'title' => 'Quest']
                ];
            	break;

        	case 'reject-hairstylist-schedule':
        	case 'approve-hairstylist-schedule':
                $data['title']          	= ucfirst($type);
                $data['sub_title']      	= ' Auto Response '.$autocrmSubject;
                $data['menu_active']    	= 'hairstylist-schedule';
                $data['submenu_active'] 	= 'hairstylist-schedule';
                $data['child_active']   	= $type.'-autoresponse-'.$subject;
                $data['type'] 				= $type;
                $data['active_response'] 	= ['email','inbox'];
                $test['result'] 			= [];
            	break;

        	default:
        		# code...
        		break;
        }

		if($auto == null) return back()->withErrors(['No such response']);
		$data['data'] = $auto;
		if($test['status'] == 'success'){
			$data['textreplaces'] = $test['result'];
			$data['subject'] = $subject;
		}

		$getApiKey = MyHelper::get('setting/whatsapp?log_save=0');
		if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
			$data['api_key_whatsapp'] = $getApiKey['result']['value'];
		}else{
			$data['api_key_whatsapp'] = null;
		}

		$custom = [];
        if (isset($data['data']['custom_text_replace'])) {
			$custom = explode(';', $data['data']['custom_text_replace']);
			if($custom[count($custom) - 1] == ''){
				unset($custom[count($custom) - 1]);
			}
        }

		$data['custom'] = $custom;
		// dd($data);exit;
        return view('users::response', $data);
	}

	public function list(){
		$data = [ 'title'             => 'Auto CRM',
				  'sub_title'         => 'Auto CRM List',
				  'menu_active'       => 'autocrm',
				  'submenu_active'    => 'autocrm-list'
				];
		$query = MyHelper::get('autocrm/cron/list');
		$test = MyHelper::get('autocrm/textreplace');
		$data['result'] = parent::getData($query);

		if ($data['result']) {
			foreach ($data['result'] as $key => $value) {
				$data['result'][$key]['id_autocrm'] = MyHelper::createSlug($value['id_autocrm'], $value['created_at']);
			}
		}
		if($test['status'] == 'success'){
			foreach ($test['result'] as $key => $val) {
				$test['result'][$key]['id_text_replace'] = MyHelper::createSlug($val['id_text_replace'], $val['created_at']);
			}
			$data['textreplaces'] = $test['result'];
		}

        return view('autocrm::list', $data);
	}
	
	public function create(Request $request){
		$post = $request->except('_token');

		if(empty($post)){
			$data = [ 'title'             => 'Auto CRM',
					  'sub_title'         => 'New Auto CRM',
					  'menu_active'       => 'autocrm',
					  'submenu_active'    => 'autocrm-new'
					];
	
			$getCity = MyHelper::get('city/list?log_save=0');
			if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = [];
			
			$getProvince = MyHelper::get('province/list?log_save=0');
			if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = [];
			
			$getCourier = MyHelper::get('courier/list?log_save=0');
			if($getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = [];
			
			$getOutlet = MyHelper::get('outlet/be/list?log_save=0');
			if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];
			
			$getProduct = MyHelper::get('product/be/list?log_save=0');
			if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = [];
			
			$getTag = MyHelper::get('product/tag/list?log_save=0');
			if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];
			
			$getMembership = MyHelper::post('membership/be/list?log_save=0', []);
			if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];

            $data['deals'] = MyHelper::post('deals/list-all', ['deals_type' => 'Deals'])['result']??[];
            $data['quest'] = MyHelper::get('quest/list-all')['result']??[];
            $data['subscription'] = MyHelper::post('subscription/list-all', ['subscription_type' => 'Subscription'])['result']??[];

			$test = MyHelper::get('autocrm/textreplace?log_save=0');
			if($test['status'] == 'success'){
				$data['textreplaces'] = $test['result'];
			}

			$getApiKey = MyHelper::get('setting/whatsapp?log_save=0');
			if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
				$data['api_key_whatsapp'] = $getApiKey['result']['value'];
			}else{
				$data['api_key_whatsapp'] = null;
			}

			$data['data'] =[];
			$data['conditions'] = "";
			$data['rule'] = "";

			return view('autocrm::create', $data);
		}else{
			if (isset($post['autocrm_push_image'])) {
				$post['autocrm_push_image'] = MyHelper::encodeImage($post['autocrm_push_image']);
			}

			if (isset($post['whatsapp_content'])) {
				foreach($post['whatsapp_content'] as $key => $content){
					if($content['content'] || isset($content['content_file']) && $content['content_file']){
						if($content['content_type'] == 'image'){
							$post['whatsapp_content'][$key]['content'] = MyHelper::encodeImage($content['content']);
						}
						else if($content['content_type'] == 'file'){
							$post['whatsapp_content'][$key]['content'] = base64_encode(file_get_contents($content['content_file']));
							$post['whatsapp_content'][$key]['content_file_name'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_FILENAME);
							$post['whatsapp_content'][$key]['content_file_ext'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_EXTENSION);
							unset($post['whatsapp_content'][$key]['content_file']);
						}
					}
				}
			}

			$query = MyHelper::post('autocrm/cron/create', $post);
			// dd($query);
			return parent::redirect($query, 'Auto CRM has been created.', 'autocrm');
		}
	}

	public function detail(Request $request, $id_autocrm){
		$post = $request->except('_token');
		$id_autocrm = MyHelper::explodeSlug($id_autocrm)[0]??'';

		if(empty($post)){

			$data = [ 'title'             => 'Auto CRM',
				      'sub_title'         => 'Detail Auto CRM',
					  'menu_active'       => 'autocrm',
					  'submenu_active'    => 'autocrm-list'
					];
			$post['id_autocrm'] = $id_autocrm;	
			$query = MyHelper::post('autocrm/cron/list', $post);
			// dd($query);
			if(isset($query['status']) && $query['status'] == 'success'){
				$data['result'] = $query['result'];
			}else{
				return redirect('autocrm')->withErrors(['Data not found.']);
			}

			if(count($data['result']) > 0){
				$data['conditions'] = $data['result']['autocrm_rule_parents'];
			}else{
				$data['conditions'] = [];
			}
			
			$getCity = MyHelper::get('city/list?log_save=0');
			if($getCity['status'] == 'success') $data['city'] = $getCity['result']; else $data['city'] = [];
			
			$getProvince = MyHelper::get('province/list?log_save=0');
			if($getProvince['status'] == 'success') $data['province'] = $getProvince['result']; else $data['province'] = [];
			
			$getCourier = MyHelper::get('courier/list?log_save=0');
			if($getCourier['status'] == 'success') $data['couriers'] = $getCourier['result']; else $data['couriers'] = [];
			
			$getOutlet = MyHelper::get('outlet/be/list?log_save=0');
			if (isset($getOutlet['status']) && $getOutlet['status'] == 'success') $data['outlets'] = $getOutlet['result']; else $data['outlets'] = [];
			
			$getProduct = MyHelper::get('product/be/list?log_save=0');
			if (isset($getProduct['status']) && $getProduct['status'] == 'success') $data['products'] = $getProduct['result']; else $data['products'] = [];
			
			$getTag = MyHelper::get('product/tag/list?log_save=0');
			if (isset($getTag['status']) && $getTag['status'] == 'success') $data['tags'] = $getTag['result']; else $data['tags'] = [];
			
			$getMembership = MyHelper::post('membership/be/list?log_save=0', []);
			if (isset($getMembership['status']) && $getMembership['status'] == 'success') $data['memberships'] = $getMembership['result']; else $data['memberships'] = [];

            $data['deals'] = MyHelper::post('deals/list-all', ['deals_type' => 'Deals'])['result']??[];
            $data['quest'] = MyHelper::get('quest/list-all')['result']??[];
            $data['subscription'] = MyHelper::post('subscription/list-all', ['subscription_type' => 'Subscription'])['result']??[];

			$test = MyHelper::get('autocrm/textreplace?log_save=0');
			if($test['status'] == 'success'){
				$data['textreplaces'] = $test['result'];
			}else{
				$data['textreplaces'] = [];
			}

			$getApiKey = MyHelper::get('setting/whatsapp?log_save=0');
			if(isset($getApiKey['status']) && $getApiKey['status'] == 'success' && $getApiKey['result']['value']){
				$data['api_key_whatsapp'] = $getApiKey['result']['value'];
			}else{
				$data['api_key_whatsapp'] = null;
			}
			
			return view('autocrm::create', $data);
		}else{
			unset($post['files']);
			$post['id_autocrm'] = $id_autocrm;
			if (isset($post['autocrm_push_image'])) {
				$post['autocrm_push_image'] = MyHelper::encodeImage($post['autocrm_push_image']);
			}
			if(isset($post['radiomonth'])) unset($post['radiomonth']);

			if (isset($post['whatsapp_content'])) {
				foreach($post['whatsapp_content'] as $key => $content){
					if($content['content'] || isset($content['content_file']) && $content['content_file']){
						if($content['content_type'] == 'image'){
							$post['whatsapp_content'][$key]['content'] = MyHelper::encodeImage($content['content']);
						}
						else if($content['content_type'] == 'file'){
							$post['whatsapp_content'][$key]['content'] = base64_encode(file_get_contents($content['content_file']));
							$post['whatsapp_content'][$key]['content_file_name'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_FILENAME);
							$post['whatsapp_content'][$key]['content_file_ext'] = pathinfo($content['content_file']->getClientOriginalName(), PATHINFO_EXTENSION);
							unset($post['whatsapp_content'][$key]['content_file']);
						}
					}
				}
			}

			$query = MyHelper::post('autocrm/cron/update', $post);
			// dd($query);
			return parent::redirect($query, 'Auto CRM has been updated.', 'autocrm/edit/'.$id_autocrm);
		}
	}

	function deleteAutocrmCron(Request $request) {
        $post   = $request->all();
		$post['id_autocrm'] =  MyHelper::explodeSlug($post['id_autocrm'])[0]??'';

        $delete = MyHelper::post('autocrm/cron/delete', ['id_autocrm' => $post['id_autocrm']]);
        
        if (isset($delete['status']) && $delete['status'] == "success") {
            return "success";
        }
        else {
            return "fail";
        }
    }
	
}
