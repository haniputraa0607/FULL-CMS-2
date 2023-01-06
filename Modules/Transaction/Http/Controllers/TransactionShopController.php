<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class TransactionShopController extends Controller
{
    public function listShop(Request $request)
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Transaction Shop',
            'submenu_active' => 'transaction-shop',
            'filter_title'   => 'Filter Transaction',
            'filter_date'    => true,
            'filter_date_today' => true,
        ];

        if(session('trx_shop')){
            $extra=session('trx_shop');
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
            $data = MyHelper::post('transaction/shop', $extra + $request->all());
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

        return view('transaction::transaction.shop', $data);
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
            session(['trx_shop'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['trx_shop'=>null]);
            return back();
        }

        return abort(404);
    }

    public function detailShop(Request $request, $id) {

        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Detail Transaction Shop',
            'submenu_active' => 'transaction-shop'
        ];

        $post['id_transaction'] = $id;
        $post['admin'] = 1;
        $check = MyHelper::post('transaction/shop/detail', $post);

    	if (isset($check['status']) && $check['status'] == 'success') {
    		$data['data'] = $check['result'];
            $data['manual_refund'] = MyHelper::post('transaction/manual-refund/detail', ['id_transaction' => $id])['result']??[];
    	} elseif (isset($check['status']) && $check['status'] == 'fail') {
            return redirect('transaction/shop')->withErrors(['Data failed']);
        } else {
            return redirect('transaction/shop')->withErrors(['Something went wrong, try again']);
        }
        return view('transaction::transactionDetailShop', $data);
    	
    }
}
