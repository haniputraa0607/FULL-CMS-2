<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class WebviewController extends Controller
{

    public function detail(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

    	$data = json_decode(base64_decode($request->get('data')), true);
    	$data['check'] = 1;
    	$check = MyHelper::post('transaction/detail/webview', $data);
    	if (isset($check['status']) && $check['status'] == 'success') {
    		$data = $check['result'];
    	} elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

    	if ($data['kind'] == 'Delivery') {
    		$view = 'detail_transaction_deliv';
    	}

    	if ($data['kind'] == 'Pickup Order') {
    		$view = 'detail_transaction_pickup';
    	}

    	if ($data['kind'] == 'Offline') {
    		$view = 'detail_transaction_off';
    	}

    	if ($data['kind'] == 'Voucher') {
    		$view = 'detail_transaction_voucher';
    	}

        if (isset($data['success'])) {
            $view = 'transaction_success';
        }

        if ($data['transaction_payment_status'] == 'Pending') {
            $view = 'transaction_proccess';
            if (isset($data['data_payment'])) {
                foreach ($data['data_payment'] as $key => $value) {
                    if ($value['type'] != 'Midtrans') {
                        continue;
                    } else {
                        if (isset($value['eci'])) {
                            $view = 'transaction_pending';
                        }
                    }
                }
            }
        }

    	if (isset($data['order_label_v2'])) {
    		$data['order_label_v2'] = explode(',', $data['order_label_v2']);
    		$data['order_v2'] = explode(',', $data['order_v2']);
    	}
        return view('transaction::webview.'.$view.'')->with(compact('data'));
    }

    public function outletSuccess(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        $data = json_decode(base64_decode($request->get('data')), true);
        $data['check'] = 1;
        $check = MyHelper::post('outletapp/order/detail/view', $data);
        if (isset($check['status']) && $check['status'] == 'success') {
            $data = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        if (isset($data['order_label_v2'])) {
            $data['order_label_v2'] = explode(',', $data['order_label_v2']);
            $data['order_v2'] = explode(',', $data['order_v2']);
        }
        return view('transaction::webview.outlet_app')->with(compact('data'));
    }

    public function detailPoint(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        $data = json_decode(base64_decode($request->get('data')), true);
        $data['check'] = 1;
        $check = MyHelper::post('transaction/detail/webview/point', $data);

        if (isset($check['status']) && $check['status'] == 'success') {
            $data = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        if ($data['type'] == 'trx') {
            $view = 'detail_point_online';
        }

        if ($data['type'] == 'voucher') {
            $view = 'detail_point_voucher';
        }

        return view('transaction::webview.'.$view.'')->with(compact('data'));
    }

    public function detailBalance(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }
        
        $data = json_decode(base64_decode($request->get('data')), true);
        $data['check'] = 1;
        $check = MyHelper::post('transaction/detail/webview/balance', $data);

        if (isset($check['status']) && $check['status'] == 'success') {
            $data = $check['result'];
        } elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        if ($data['type'] == 'trx') {
            $view = 'detail_balance_online';
        }

        if ($data['type'] == 'voucher') {
            $view = 'detail_balance_voucher';
        }

        return view('transaction::webview.'.$view.'')->with(compact('data'));
    }

    public function success()
    {
        return view('transaction::webview.transaction_success');
    }

    public function receiptOutletapp(Request $request)
    {
        $bearer = $request->header('Authorization');
        if ($bearer == "") {
            return view('error', ['msg' => 'Unauthenticated']);
        }

        $data = json_decode(base64_decode($request->get('data')), true);
    	$check = MyHelper::postWithBearer('outletapp/order/detail/view', $data, $bearer);
      
    	if (isset($check['status']) && $check['status'] == 'success') {
    		$data = $check['result'];
    	} elseif (isset($check['status']) && $check['status'] == 'fail') {
            return view('error', ['msg' => 'Data failed']);
        } else {
            return view('error', ['msg' => 'Something went wrong, try again']);
        }

        return view('transaction::webview.receipt-outletapp')->with(compact('data'));
    }
}
