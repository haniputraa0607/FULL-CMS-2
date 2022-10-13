@if(isset($data['id_purchase_deposit_request']))
<div style="margin-top: -4%">
    <form class="form-horizontal" role="form" action="{{url('employee/cash-advance/update/'.$data['id_employee_cash_advance'])}}" method="post" enctype="multipart/form-data">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-4 control-label">Purchase Deposit Request ID</label>
                    <div class="col-md-4 input-group">
                        <input class="form-control" name="id_user" id="id_user" value="{{$data['value_detail']->PurchaseDepositRequestID??''}}" data-placeholder="Select Employee" disabled="">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Voucher No</label>
                    <div class="col-md-4 input-group">
                        <input class="form-control" name="id_user" id="id_user" value="{{$data['value_detail']->VoucherNo??''}}" data-placeholder="Select Employee" disabled="">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Trans Date</label>
                    <div class="col-md-4 input-group">
                        <input class="form-control" name="id_user" id="id_user" value="{{date('Y-m-d',strtotime($data['value_detail']->TransDate))}}" data-placeholder="Select Employee" disabled="">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Tax</label>
                    <div class="col-md-4 input-group">
                        <input class="form-control" name="id_user" id="id_user" value="{{$data['value_detail']->Tax??''}}" data-placeholder="Select Employee" disabled="">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Amount</label>
                    <div class="col-md-4 input-group">
                        <input class="form-control" name="id_user" id="id_user" value="{{number_format($data['value_detail']->Netto??0,0,',',',')}}" data-placeholder="Select Employee" disabled="">

                    </div>
                </div>
            </div>
        </form>
</div>
@else
Request Cash advance ke Icount tidak ada. Silahkan ajukan lagi.
<div class="row" style="text-align: center;margin-top: 10px">
    <form class="form-horizontal form-icount" role="form" action="{{url('employee/cash-advance/icount/'.$data['id_employee_cash_advance'])}}" method="post" enctype="multipart/form-data">
         
        </form>
    <a class="btn green icount" data-name="{{ $data['name'] }}" data-status="Rejected" data-form="approve">Request Icount</a>
 </div>
@endif