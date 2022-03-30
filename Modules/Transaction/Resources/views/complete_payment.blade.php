<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script>
        function findTransaction() {
            var token = "{{csrf_token()}}";
            var receipt = $('#transaction_receipt_number').val();

            if(receipt == ''){
                swal({
                    title: 'Warning!',
                    text: "Receipt Number can not be empty",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: true
                });
            }else{
                $.ajax({
                    type : "POST",
                    url : "{{ url('transaction/complete-payment/finding') }}",
                    data : {
                        "_token" : token,
                        "transaction_receipt_number" : receipt
                    },
                    success : function(result) {
                        if(result.status == 'fail'){
                            $('#title_trx_not_found').show();
                        }else{
                            var res = result.result;
                            $('#transaction_grandtotal').val(res.grandtotal);
                            $('#id_payment').val(res.id_payment);
                            $('#payment_type').val(res.trasaction_payment_type);
                            $('#payment_method').val(res.payment_method);
                        }
                    }
                });
            }
        }
        
        function clearData() {
            $('#transaction_grandtotal').val('');
            $('#id_payment').val('');
            $('#payment_type').val('');
            $('#payment_method').val('');
            $('#title_trx_not_found').hide();
        }
        
        function completedPayment() {
            var id_payment = $('#id_payment').val();
            var payment_method = $('#payment_method').val();

            if(id_payment === '' || payment_method === ''){
                swal({
                    title: 'Warning!',
                    text: "Can not completed this transaction. ID payment and payment method can not be empty.",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: true
                });
            }else{
                swal({
                        title: 'Warning!',
                        text: "Are you sure want to change this transaction to completed ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    },
                    function(){
                        $('form#form_completed').submit();
                    }
                );
            }
        }
    </script>
@endsection

@extends('layouts.main')

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $title }}</span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div><br>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-blue ">
                <i class="icon-settings font-blue "></i>
                <span class="caption-subject bold uppercase">Complete Payment</span>
            </div>
        </div>
        <div class="portlet-body">
            <form class="form-horizontal" id="form_completed" role="form" action="{{url('transaction/complete-payment')}}" method="post">
                <br>
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Receipt Number <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Silahkan memasukkan data receipt number dengan lengkap untuk melakukan pencarian transaksi" data-container="body"></i>
                        </label>
                        <div class="col-md-6">
                            <input class="form-control" placeholder="Receipt Number" name="transaction_receipt_number" onkeyup="clearData()" id="transaction_receipt_number">
                            <b style="font-size: 12px;color: red;display: none" id="title_trx_not_found">Transaction Not Found</b>
                        </div>
                        <div class="col-md-3">
                            <a class="btn-sm btn blue" onclick="findTransaction()">Find Transaction</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">ID Payment <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Silahkan memasukkan data id payment" data-container="body"></i>
                        </label>
                        <div class="col-md-6">
                            <input class="form-control" placeholder="ID Payment" name="id_payment" id="id_payment">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Payment Type
                        </label>
                        <div class="col-md-6">
                            <input class="form-control" placeholder="Payment Type" id="payment_type" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Payment Method
                        </label>
                        <div class="col-md-6">
                            <input class="form-control" placeholder="Payment Method" id="payment_method" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Grand Total
                        </label>
                        <div class="col-md-6">
                            <input class="form-control" placeholder="Grand Total" id="transaction_grandtotal" readonly>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="row" style="text-align: center;margin-top: 3%">
                    <a onclick="completedPayment()" class="btn green-jungle">Completed Payment</a>
                </div>
            </form>
        </div>
    </div>
@endsection