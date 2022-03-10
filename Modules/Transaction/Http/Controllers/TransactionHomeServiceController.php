<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class TransactionHomeServiceController extends Controller
{
    public function listHomeService(Request $request)
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Transaction Home Service',
            'submenu_active' => 'transaction-home-service',
            'filter_title'   => 'Filter Transaction',
            'filter_date'    => true,
            'filter_date_today' => true,
        ];

        if(session('trx_home_service')){
            $extra=session('trx_home_service');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    '9998' => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1'
                    ],
                    '9999' => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1'
                    ]
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }

        if ($request->wantsJson()) {
            $data = MyHelper::post('transaction/home-service', $extra + $request->all());
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

        $data['payment_list'] = array_map(function($item) {
            if($item['payment_gateway'] == 'Cash'){
                return [$item['payment_gateway'].'-'.$item['payment_method'], $item['payment_method']];
            }else{
                return [$item['payment_gateway'].'-'.$item['payment_method'], $item['payment_gateway'].' - '.$item['payment_method']];
            }
        }, MyHelper::post('transaction/available-payment',['show_all' => 0])['result'] ?? []);

        if(!empty($data['payment_list'][0])){
            unset($data['payment_list'][0]);
            $data['payment_list'] = array_values($data['payment_list']);
        }

        return view('transaction::transaction.home_service', $data);
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
            session(['trx_home_service'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['trx_home_service'=>null]);
            return back();
        }

        return abort(404);
    }

    public function detailHomeService(Request $request, $id) {

        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Detail Transaction Home Service',
            'submenu_active' => 'transaction-home-service'
        ];

        $post['id_transaction'] = $id;
        $check = MyHelper::post('transaction/home-service/detail', $post);

    	if (isset($check['status']) && $check['status'] == 'success') {
    		$data['data'] = $check['result'];
    	} elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }
        return view('transaction::transactionDetailHomeService', $data);
    	
    }

    public function manageList(Request $request)
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Manage Home Service',
            'submenu_active' => 'manage-home-service',
            'filter_title'   => 'Filter Home Service',
            'filter_date'    => true,
            'filter_date_today' => true,
        ];

        if(session('manage_home_service')){
            $extra=session('manage_home_service');
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
        } else{
            $extra=[
                'rule' => [
                    '9998' => [
                        'subject' => 'transaction_date',
                        'operator' => '>=',
                        'parameter' => date('Y-m-01'),
                        'hide' => '1'
                    ],
                    '9999' => [
                        'subject' => 'transaction_date',
                        'operator' => '<=',
                        'parameter' => date('Y-m-d'),
                        'hide' => '1'
                    ]
                ],
                'operator' => ''
            ];
            $data['rule']=array_map('array_values', $extra['rule']);
            $data['operator']=$extra['operator'];
            $data['hide_record_total']=1;
        }

        if ($request->wantsJson()) {
            $data = MyHelper::post('transaction/home-service/manage', $extra + $request->all());
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

        $data['payment_list'] = array_map(function($item) {
            if($item['payment_gateway'] == 'Cash'){
                return [$item['payment_gateway'].'-'.$item['payment_method'], $item['payment_method']];
            }else{
                return [$item['payment_gateway'].'-'.$item['payment_method'], $item['payment_gateway'].' - '.$item['payment_method']];
            }
        }, MyHelper::post('transaction/available-payment',['show_all' => 0])['result'] ?? []);

        if(!empty($data['payment_list'][0])){
            unset($data['payment_list'][0]);
            $data['payment_list'] = array_values($data['payment_list']);
        }
        return view('transaction::home_service.manage_list', $data);
    }

    /**
     * apply filter.
     * @return Response
     */
    public function manageFilter(Request $request)
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
            session(['manage_home_service'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['manage_home_service'=>null]);
            return back();
        }

        return abort(404);
    }

    public function manageDetail(Request $request, $id) {

        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Detail Manage Home Service',
            'submenu_active' => 'manage-home-service'
        ];
        $post['id_transaction'] = $id;
        $check = MyHelper::post('transaction/home-service/manage/detail', $post);

    	if (isset($check['status']) && $check['status'] == 'success') {
    		$data['data'] = $check['result'];
    	} elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }
        return view('transaction::home_service.manage_detail', $data);
    }

    public function findHairstylist(Request $request)
    {
    	$post = $request->except('_token');
    	$listHs = MyHelper::post('transaction/home-service/manage/find-hs', $post);

    	return $listHs['result'] ?? [];
    }

    public function manageDetailUpdate(Request $request, $id)
    {
    	$post = $request->except('_token');

    	$update = MyHelper::post('transaction/home-service/manage/detail/update', $post);

        if (($update['status'] ?? false) == 'success') {
            return redirect()->back()->with('success',['Home service has been updated']);
        } else {
            return redirect()->back()->withInput()->withErrors($update['messages'] ?? ['Failed update home service']);
        }
    }
}
