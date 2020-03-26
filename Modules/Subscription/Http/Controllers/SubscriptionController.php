<?php

namespace Modules\Subscription\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriptionController extends Controller
{

    function getData($access) {
        if (isset($access['status']) && $access['status'] == "success") {
            return $access['result'];
        }
        else {
            return [];
        }
    }

    public function index(Request $request)
    {
        $post=$request->except('_token');

        if($post){
            if(($post['clear']??false)=='session'){
                session(['subs_filter'=>[]]);
            }else{
                session(['subs_filter'=>$post]);
            }
            return back();
        }

        $data = [
            'title'          => 'subscription',
            'sub_title'      => 'subscription List',
            'menu_active'    => 'subscription',
            'submenu_active' => 'subscription-list'
        ];

        $post['newest'] = 1;
        $post['web'] = 1;
        $post['admin']=1;

        if(($filter=session('subs_filter'))&&is_array($filter))
        {
            $post=array_merge($filter,$post);
            if($filter['rule']??false)
            {
                $data['rule']=array_map('array_values', $filter['rule']);
            }
            if($filter['operator']??false)
            {
                $data['operator']=$filter['operator'];
            }
        }

        $data['subs'] = array_map(function($var){
            $var['id_subscription'] = MyHelper::createSlug($var['id_subscription'],$var['created_at']);
            return $var;
        },$this->getData(MyHelper::post('subscription/be/list', $post)));

        $post['select'] = ['id_outlet','outlet_code','outlet_name'];
        $data['outlets'] = $this->getData(MyHelper::post('outlet/ajax_handler', $post));
        // return $data;


        return view('subscription::list', $data);

    }

    public function participateAjax(Request $request) {

        $input = $request->query();
        $return = $input;
        $return['draw']=(int)$input['draw'];

        $participate = MyHelper::post('subscription/participate-ajax', $input);
        // return $participate;
        if ( ($participate['status']??'') == 'success') {
            $return['recordsTotal'] = $participate['count'];
            $return['recordsFiltered'] = $participate['count'];
            $return['data'] = array_map(function($x) use ($participate){
                $detailUrl=url('subscription/detail/'.$x['id_subscription'].'/'.$x['subscription_user_receipt_number']);
                $price = $x['subscription_price_point']??$x['subscription_price_point']??'Free';
                return [
                    $x['subscription_user_receipt_number'],
                    $x['name'].' - '.$x['phone'],
                    date('d M Y', strtotime($x['bought_at'])),
                    date('d M Y', strtotime($x['subscription_expired_at'])),
                    $x['paid_status'],
                    $price,
                    number_format($x['kuota'], 2).' | '.number_format($x['used'], 2).' | '.number_format($x['available'], 2),
                    "<a href='$detailUrl' data-popout='true' class='btn btn-sm blue'><i class='fa fa-search'></i></a>"
                ];
            },$participate['result']);
            return $return;
        } else {
            $return['recordsTotal'] = 0;
            $return['recordsFiltered'] = 0;
            $return['data'] = [];
            return $return;
        }
        return $participate;
    }

    public function transaction($slug, $subs_receipt)
    {
        $exploded = MyHelper::explodeSlug($slug);
        $id_subscription = $exploded[0];
        $created_at = $exploded[1];
        // return $subs_receipt;
        $post['id_subscription'] = $id_subscription;
        $post['created_at'] = $created_at;
        $post['subscription_user_receipt_number'] = $subs_receipt;

        $data = [
            'title'          => 'Subscription',
            'sub_title'      => 'Subscription Transaction Detail',
            'menu_active'    => 'subscription',
            'submenu_active' => 'subscription-list'
        ];

        // $data['trx'] = $this->getData(MyHelper::post('subscription/trx', $post));
        $data['trx'] = MyHelper::post('subscription/trx', $post);

        // return $data;


        return view('subscription::list_transaction', $data);
    }

    public function changeDateFormat($date)
    {
        if ( !empty($date) ) {
            $date = date('Y-m-d H:i:s', strtotime($date));
        }
        return $date;
    }

    public function create(Request $request, $slug=null)
    {
        if($slug){
            $exploded = MyHelper::explodeSlug($slug);
            $id_subscription = $exploded[0];
            $created_at = $exploded[1];
        }else{
            $id_subscription = null;
            $created_at = null;
        }
        $post = $request->except('_token');
        if (!empty($post)) {
            if($post['id_subscription']){
                $post['id_subscription'] = MyHelper::explodeSlug($post['id_subscription'])[0];
            }

            $post['subscription_start']         = $this->changeDateFormat($post['subscription_start']??null);
            $post['subscription_end']           = $this->changeDateFormat($post['subscription_end']??null);
            $post['subscription_publish_start'] = $this->changeDateFormat($post['subscription_publish_start']??null);
            $post['subscription_publish_end']   = $this->changeDateFormat($post['subscription_publish_end']??null);
            if (isset($post['subscription_image'])) {
                $post['subscription_image']         = MyHelper::encodeImage($post['subscription_image']);
            }

            $save = MyHelper::post('subscription/step1', $post);

            if ( ($save['status']??false) == "success") {
                isset($id_subscription) ? $message = ['Subscription has been Updated'] : $message = ['Subscription has been created'];
                return redirect('subscription/step2/'.MyHelper::createSlug($save['result']['id_subscription'],$save['result']['created_at']??''))->with('success', $message);
            }else{
                dd($save);
                return back()->withErrors($save['messages']??['Something went wrong'])->withInput();
            }
        }
        else {

            $data = [
                'title'          => 'Subscription',
                'sub_title'      => 'Subscription Create',
                'menu_active'    => 'subscription',
                'submenu_active' => 'subscription-create'
            ];
            
            if (isset($id_subscription)) {
                $data['subscription'] = MyHelper::post('subscription/show-step1', ['id_subscription' => $id_subscription])['result']??'';
                if ($data['subscription'] == '') {
                    return redirect('subscription')->withErrors('Subscription not found');
                }
                if(isset($data['subscription']['id_subscription'])) {
                    $data['subscription']['id_subscription'] = MyHelper::createSlug($data['subscription']['id_subscription'],$data['subscription']['id_subscription']??'');
                }
            }

            return view('subscription::step1', $data);
        }
    }

    public function step2(Request $request, $slug = null)
    {
        if($slug){
            $exploded = MyHelper::explodeSlug($slug);
            $id_subscription = $exploded[0];
            $created_at = $exploded[1];
        }else{
            $id_subscription = null;
            $created_at = null;
        }
        $post = $request->except('_token');

        if (!empty($post)) {
            if($post['id_subscription']){
                $post['id_subscription'] = MyHelper::explodeSlug($post['id_subscription'])[0];
            }
            $save = MyHelper::post('subscription/step2', $post);

            if ( ($save['status']??false) == "success") {
                return redirect('subscription/step3/'.$slug)->with('success', ['Subscription has been updated']);
            }else{
                return back()->withErrors($save['messages']??['Something went wrong'])->withInput();
            }
        }
        else {

            $data = [
                'title'          => 'Subscription',
                'sub_title'      => 'Subscription Create',
                'menu_active'    => 'subscription',
                'submenu_active' => 'subscription-create'
            ];

            $post['select'] = ['id_outlet','outlet_code','outlet_name'];
            $outlets = MyHelper::post('outlet/ajax_handler', $post);
            
            if (!empty($outlets['result'])) {
                $data['outlets'] = $outlets['result'];
            }
            if (isset($id_subscription)) {
                $data['subscription'] = MyHelper::post('subscription/show-step2', ['id_subscription' => $id_subscription])['result']??'';
// return                $data['subscription'] = MyHelper::post('subscription/show-step2', ['id_subscription' => $id_subscription]);
                if ($data['subscription'] == '') {
                    return redirect('subscription')->withErrors('Subscription not found');
                }
                $data['subscription']['id_subscription'] = MyHelper::createSlug($data['subscription']['id_subscription'],$data['subscription']['id_subscription']??'');
            }

            // DATA BRAND
        	$data['brands'] = MyHelper::get('brand/be/list')['result']??[];
// return $data;

            return view('subscription::step2', $data);
        }
    }

    public function step3(Request $request, $slug)
    {
        if($slug){
            $exploded = MyHelper::explodeSlug($slug);
            $id_subscription = $exploded[0];
            $created_at = $exploded[1];
        }else{
            $id_subscription = null;
            $created_at = null;
        }
        $post = $request->except('_token');
        if (!empty($post)) {
            if($post['id_subscription']){
                $post['id_subscription'] = MyHelper::explodeSlug($post['id_subscription'])[0];
            }

            $save = MyHelper::post('subscription/step3', $post);

            if ( ($save['status']??false) == "success") {
                return redirect('subscription/detail/'.$slug)->with('success', ['Subscription has been updated']);
            }else{
                return back()->withErrors($save['messages']??['Something went wrong'])->withInput();
            }
            return $post;
        }
        else {

            $data = [
                'title'          => 'Subscription',
                'sub_title'      => 'Subscription Create',
                'menu_active'    => 'subscription',
                'submenu_active' => 'subscription-create'
            ];

            $post['select'] = ['id_outlet','outlet_code','outlet_name'];
            $outlets = MyHelper::post('outlet/ajax_handler', $post);
            
            if (!empty($outlets['result'])) {
                $data['outlets'] = $outlets['result'];
            }

            if (isset($id_subscription)) {
                $data['subscription'] = MyHelper::post('subscription/show-step3', ['id_subscription' => $id_subscription])['result']??'';
                if ($data['subscription'] == '') {
                    return redirect('subscription')->withErrors('Subscription not found');
                }
                $data['subscription']['id_subscription'] = MyHelper::createSlug($data['subscription']['id_subscription'],$data['subscription']['id_subscription']??'');
            }

            return view('subscription::step3', $data);
        }
    }

    public function detail(Request $request, $slug, $subs_receipt=null)
    {
        $exploded = MyHelper::explodeSlug($slug);
        $id_subscription = $exploded[0];
        $created_at = $exploded[1];
        if (isset($subs_receipt)) {
            return $this->transaction($id_subscription, $subs_receipt);
        }
        $post = $request->except('_token');
        if (!empty($post)) {
            $post['id_subscription'] = $id_subscription;

            $post['subscription_start']         = $this->changeDateFormat($post['subscription_start']??null);
            $post['subscription_end']           = $this->changeDateFormat($post['subscription_end']??null);
            $post['subscription_publish_start'] = $this->changeDateFormat($post['subscription_publish_start']??null);
            $post['subscription_publish_end']   = $this->changeDateFormat($post['subscription_publish_end']??null);
            if (isset($post['subscription_image'])) {
                $post['subscription_image']         = MyHelper::encodeImage($post['subscription_image']);
            }

            $save = MyHelper::post('subscription/updateDetail', $post);

            if ( ($save['status']??false) == "success") {
                return redirect('subscription/detail/'.$slug)->with('success', ['Subscription has been updated']);
            }else{
                return back()->withErrors($save['messages']??['Something went wrong'])->withInput();
            }
        }
        else {

            $data = [
                'title'          => 'Subscription',
                'sub_title'      => 'Subscription Detail',
                'menu_active'    => 'subscription',
                'submenu_active' => 'subscription-List'
            ];
            

            if (!empty($outlets['result'])) {
                $data['outlets'] = $outlets['result'];
            }

            $data['subscription'] = MyHelper::post('subscription/show-detail', ['id_subscription' => $id_subscription])['result']??'';
            if ($data['subscription'] == '') {
                return redirect('subscription')->withErrors('Subscription not found');
            }
            $data['subscription']['id_subscription'] = $slug;

            $post['condition']['rules'] = [
            	'subject' => 'id_brand',
            	'parameter' => $data['subscription']['id_brand'],
            	'operator' => '='
            ];
            $post['condition'] = 'and';
            $post['select'] = ['id_outlet','outlet_code','outlet_name'];
            $outlets = MyHelper::post('outlet/ajax_handler', $post);

            $post['select'] = ['id_product','product_code','product_name'];
            $outlets = MyHelper::post('outlet/ajax_handler', $post);

        	$data['brands'] = MyHelper::get('brand/be/list')['result']??[];

            return view('subscription::detail', $data);
        }
    }
}
