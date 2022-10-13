<div style="margin-top: -4%">
<form class="form-horizontal" id="form_psychological" role="form" action="{{url('employee/cash-advance/update/'.$data['id_employee_cash_advance'])}}" method="post" enctype="multipart/form-data">
        <div class="form-body">
            <div style="text-align: center"><h3>Finance Approval</h3></div>
			<hr style="border-top: 2px dashed;">
            <div class="form-group">
                <label class=" col-md-2 control-label">Employee</label>
                <div class="col-md-6 ">
                    <input class="form-control" name="id_user" id="id_user" value="{{$data['user_name']??''}}" data-placeholder="Select Employee" disabled="">
                    <input class="form-control" type="hidden" name="id_employee_cash_advance" id="id_employee_cash_advance" value="{{$data['id_employee_cash_advance']}}" data-placeholder="Select Employee" >

                </div>
            </div>
            <div class="form-group">
                <label class=" col-md-2 control-label">Name</label>
                <div class="col-md-6 ">
                    <input class="form-control" name="id_user" id="key" value="{{$data['name']??''}}" data-placeholder="Select Employee" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class=" col-md-2 control-label">Price</label>
                <div class="col-md-6 ">
                    <input type="text" name="installment" id='installment' value="{{number_format($data['price']??0,0,',',',')}}" min="1" placeholder="Masukkan jumlah" class="form-control" disabled />
                </div>
            </div>
            <div class="form-group">
                <label class=" col-md-2 control-label">Notes Employee</label>
                <div class="col-md-6 ">
                    <textarea type="text" class="form-control" name="notes" id="notes" placeholder="Masukkan notes" disabled    >{{$data['notes']??''}}</textarea>
                </div>
            </div>
            @if(isset($dataDoc['Finance Approval']['name']))
            <div class="form-group">
                    <label class="col-md-2 control-label">Approved 
                    </label>
                    <div class="col-md-6">
                        <input class="form-control" value="{{$dataDoc['Finance Approval']['name']??''}}" disabled>
                    </div>
            </div>
            @endif
            <div class="form-group">
                        <label class=" col-md-2 control-label">Notes
                        </label>
                        <div class="col-md-6  ">
                                <textarea class="form-control" name="data_document[process_notes]" placeholder="Notes" @if(isset($dataDoc['Finance Approval']['process_notes'])) disabled @endif>@if(isset($dataDoc['Finance Approval']['process_notes'])) {{$dataDoc['Finance Approval']['process_notes']}}  @endif</textarea>
                        </div>
                </div>
                <div class="form-group">
                        <label class=" col-md-2 control-label">Attachment</label>
                        <div class="col-md-6 ">
                                    @if(isset($dataDoc['Finance Approval']['attachment']))
                                        @if(empty($dataDoc['HRGA/Direktur Approval']['attachment']))
                                                <p style="margin-top: 2%">No file</p>
                                        @else
                                                <a style="margin-top: 2%" class="btn blue btn-xs" href="{{$dataDoc['Finance Approval']['attachment'] }} "><i class="fa fa-download"></i></a>
                                        @endif
                                @else
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="input-group">
                                                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                <span class="fileinput-filename"> </span>
                                                        </div>
                                                        <span class="input-group-addon btn default btn-file">
                                                        <span class="fileinput-new"> Select file </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="file" name="data_document[attachment]"> </span>
                                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                </div>
                                        </div>
                                @endif
                        </div>
                </div>
    <input type="hidden" name="data_document[document_type]" value="Finance Approval">
    <input type="hidden" name="action_type" value="Finance Approval">
            @if($data['status']=='HRGA/Direktur Approval')
            <div class="form-actions">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <a class="btn red save" data-name="{{ $data['name'] }}" data-status="Rejected" data-form="approve">Reject</a>
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </form>
</div>