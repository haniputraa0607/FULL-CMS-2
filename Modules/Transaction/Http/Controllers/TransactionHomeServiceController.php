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
            'sub_title'      => 'Detail Transaction',
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
}
