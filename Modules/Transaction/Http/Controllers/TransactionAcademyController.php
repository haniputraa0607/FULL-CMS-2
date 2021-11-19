<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;

class TransactionAcademyController extends Controller
{
    public function listAcademy(Request $request)
    {
        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Transaction Academy',
            'submenu_active' => 'transaction-academy',
            'filter_title'   => 'Filter Transaction',
            'filter_date'    => true,
            'filter_date_today' => true,
        ];

        if(session('trx_acedemy')){
            $extra=session('trx_acedemy');
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
            $data = MyHelper::post('transaction/academy', $extra + $request->all());
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

        return view('transaction::transaction.academy', $data);
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
            session(['trx_acedemy'=>$post]);
            return back();
        }

        if($post['clear']??false){
            session(['trx_acedemy'=>null]);
            return back();
        }

        return abort(404);
    }

    public function detailAcademy(Request $request, $id) {

        $data = [
            'title'          => 'Transaction',
            'menu_active'    => 'transaction',
            'sub_title'      => 'Detail Transaction Academy',
            'submenu_active' => 'transaction-academy'
        ];

        $post['id_transaction'] = $id;
        $check = MyHelper::post('transaction/academy/detail', $post);

        if (isset($check['status']) && $check['status'] == 'success') {
            $data['data'] = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }
        return view('transaction::transactionDetailAcademy', $data);

    }
}
