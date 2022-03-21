<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class TransactionOutletServiceController extends Controller
{
    public function listOutletService(Request $request)
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Transaction Outlet Service',
            'submenu_active' => 'transaction-outlet-service',
            'filter_title'   => 'Filter Transaction',
            'filter_date'    => true,
            'filter_date_today' => true,
        ];

        if(session('trx_outlet_service')){
            $extra=session('trx_outlet_service');
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
            $data = MyHelper::post('transaction/outlet-service', $extra + $request->all());
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

        $data['outlets'] = array_map(function($item) {
            return [$item['id_outlet'], $item['outlet_code'].' - '.$item['outlet_name']];
        }, MyHelper::get('outlet/be/list')['result'] ?? []);

        $data['payment_list'] = array_map(function($item) {
            if($item['payment_gateway'] == 'Cash'){
                return [$item['payment_gateway'].'-'.$item['payment_method'], $item['payment_method']];
            }else{
                return [$item['payment_gateway'].'-'.$item['payment_method'], $item['payment_gateway'].' - '.$item['payment_method']];
            }
        }, MyHelper::post('transaction/available-payment',['show_all' => 0])['result'] ?? []);

        return view('transaction::transaction.outlet_service', $data);
    }

    /**
     * apply filter.
     * @return Response
     */
    public function filter(Request $request)
    {
        return $this->applyFilter($request, 'trx_outlet_service');
    }

    public function manageFilter(Request $request)
    {
        return $this->applyFilter($request, 'manage_outlet_service');
    }

    public function applyFilter($request, $sessionName = 'trx_outlet_service')
    {
    	$post = $request->all();

        if (($post['rule'] ?? false) && !isset($post['draw'])) {
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
            session([$sessionName => $post]);
            return back();
        }

        if ($post['clear'] ?? false) {
            session([$sessionName => null]);
            return back();
        }

        return abort(404);
    }

    public function detailOutletService(Request $request, $id) {

        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Detail Transaction',
            'submenu_active' => 'transaction-outlet-service'
        ];

        $post['id_transaction'] = $id;
        $check = MyHelper::post('transaction/outlet-service/detail', $post);
    	if (isset($check['status']) && $check['status'] == 'success') {
    		$data['data'] = $check['result'];
    	} elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }
        return view('transaction::transactionDetailOutletService', $data);
    	
    }

    public function ManageList(Request $request)
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Manage Outlet Service',
            'submenu_active' => 'manage-outlet-service',
            'filter_title'   => 'Filter Outlet Service',
            'filter_date'    => true,
            'filter_date_today' => true,
        ];

        if (session('manage_outlet_service')) {
            $extra = session('manage_outlet_service');
            $data['rule'] = array_map('array_values', $extra['rule']);
            $data['operator'] = $extra['operator'];
        } else {
            $extra = [
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
            $data['rule'] = array_map('array_values', $extra['rule']);
            $data['operator'] = $extra['operator'];
            $data['hide_record_total'] = 1;
        }

        if ($request->wantsJson()) {
            $data = MyHelper::post('transaction/outlet-service/manage', $extra + $request->all());
            return $data['result'];
        }
        
        $dateRange = [];
        foreach ($data['rule'] ?? [] as $rule) {
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

        $data['outlets'] = array_map(function($item) {
            return [$item['id_outlet'], $item['outlet_code'].' - '.$item['outlet_name']];
        }, MyHelper::get('outlet/be/list')['result'] ?? []);

        $data['payment_list'] = array_map(function($item) {
            if($item['payment_gateway'] == 'Cash'){
                return [$item['payment_gateway'].'-'.$item['payment_method'], $item['payment_method']];
            }else{
                return [$item['payment_gateway'].'-'.$item['payment_method'], $item['payment_gateway'].' - '.$item['payment_method']];
            }
        }, MyHelper::post('transaction/available-payment',['show_all' => 0])['result'] ?? []);

        return view('transaction::outlet_service.manage_list', $data);
    }

    public function manageDetail(Request $request, $id) {

        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Manage Outlet Service',
            'submenu_active' => 'manage-outlet-service'
        ];

        $check = MyHelper::get('transaction/outlet-service/manage/detail/'. $id);

    	if (isset($check['status']) && $check['status'] == 'success') {
    		$data['data'] = $check['result'];
    	} elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        return view('transaction::outlet_service.manage_detail', $data);
    }

    public function manageDetailUpdate(Request $request, $id)
    {
    	$post = $request->except('_token');

    	$update = MyHelper::post('transaction/outlet-service/manage/detail/'. $id, $post);

        if (($update['status'] ?? false) == 'success') {
            return redirect()->back()->with('success',['Success update '.$post['update_type']]);
        } else {
            return redirect()->back()->withInput()->withErrors($update['messages'] ?? ['Failed update outlet service']);
        }
    }

    public function rejectOutletService(Request $request)
    {
    	$post = $request->except('_token');

    	$update = MyHelper::post('transaction/outlet-service/reject', $post);

        if (($update['status'] ?? false) == 'success') {
            return redirect()->back()->with('success',['Success reject '.$post['update_type']]);
        } else {
            return redirect()->back()->withInput()->withErrors($update['messages'] ?? ['Failed reject outlet service']);
        }
    }

    public function availableHS(Request $request){
        $post = $request->except('_token');
        $res = MyHelper::post('product/be/available-hs', $post);
        return $res;
    }
}
