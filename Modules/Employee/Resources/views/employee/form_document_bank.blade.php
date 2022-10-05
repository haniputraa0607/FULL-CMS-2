<div style="margin-top: -4%">
	<form class="form-horizontal"  role="form" action="{{url('employee/recruitment/complement/'.$detail['id_employee'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Data Complement</h3></div>
			<hr style="border-top: 2px dashed;">
                        <div class="form-group">
				<label  class="control-label col-md-4">Bank Name</label>
				<div class="col-md-6">
                                    <select name="id_bank_name" class="form-control input-sm select2" data-placeholder="Search Bank Name" >
                                                <option></option>
                                                @foreach($bank as $key => $val)
                                                    <option value="{{ $val['id_bank_name'] }}" @if($val['id_bank_name']==$detail['id_bank_name']) selected @endif>{{ $val['bank_name'] }}</option>
                                                @endforeach
                                            </select>
				</div>
			</div>
                        <div class="form-group">
				<label class="col-md-4 control-label">Bank Account name</label>
				<div class="col-md-6">
					<input class="form-control" maxlength="200" type="text" name="bank_account_name" value="{{$detail['bank_account_name']??''}}" placeholder="Bank Account Name" />
				</div>
			</div>
                        <div class="form-group">
				<label class="col-md-4 control-label">Bank Account Number</label>
				<div class="col-md-6">
					<input class="form-control" maxlength="200" id="banks" type="text" name="bank_account_number" value="{{$detail['bank_account_number']??''}}" placeholder="Bank Account Number" />
				</div>
			</div>
                        <div class="form-group">
				<label class="col-md-4 control-label">NPWP</label>
				<div class="col-md-6">
					<input class="form-control" id="npwp" maxlength="200" type="text" name="npwp" value="{{$detail['npwp']??''}}" placeholder="NPWP" />
				</div>
			</div>
                        <div class="form-group">
				<label class="col-md-4 control-label">NPWP Name</label>
				<div class="col-md-6">
					<input class="form-control" maxlength="200" type="text" name="npwp_name" value="{{$detail['npwp_name']??''}}" placeholder="NPWP Name" />
				</div>
			</div>
                        <div class="form-group">
				<label class="col-md-4 control-label">NPWP Address</label>
				<div class="col-md-6">
					<input class="form-control" maxlength="200" type="text" name="npwp_address" value="{{$detail['npwp_address']??''}}" placeholder="NPWP Address" />
				</div>
			</div>
                        <div class="form-group">
				<label class="col-md-4 control-label">Bpjs Kesehatan</label>
				<div class="col-md-6">
					<input class="form-control" min="15" max='18' type="text" id='bpjs_kesehatan' name="bpjs_kesehatan" value="{{$detail['bpjs_kesehatan']??''}}" placeholder="Nomor BPJS Kesehatan" />
				</div>
			</div>
                        <div class="form-group">
				<label class="col-md-4 control-label">Bpjs Ketenagakerjaan</label>
				<div class="col-md-6">
					<input class="form-control" min="11" max='12' type="text" id='bpjs_ketenagakerjaan' name="bpjs_ketenagakerjaan" value="{{$detail['bpjs_ketenagakerjaan']??''}}" placeholder="Nomor BPJS Ketenagakerjaan" />
				</div>
			</div>
                        <div class="form-group">
				<label class="col-md-4 control-label">Contact Person</label>
				<div class="col-md-6">
					<input class="form-control" maxlength="200" type="text" name="contact_person" value="{{$detail['contact_person']??''}}" placeholder="Contact Person" />
				</div>
			</div>
                        <div class="form-group">
				<label class="col-md-4 control-label">Tax</label>
				<div class="col-md-6">
					<input type="checkbox" class="make-switch" id="is_tax" data-size="small" data-on-color="success" data-on-text="Yes" name="is_tax" data-off-color="default" data-off-text="No" @if($detail['is_tax']==1) checked @endif>
				</div>
			</div>
                        <div class="form-group">
				<label class="col-md-4 control-label">Type</label>
				<div class="col-md-6">
					<select name="type" class="form-control input-sm select2" data-placeholder="Search Type" >
                                            <option value="0" @if($detail['type']==0) selected @endif>NIK</option>
                                            <option value="1" @if($detail['type']==1) selected @endif>NPWP</option>
                                            <option value="2" @if($detail['type']==2) selected @endif>Others</option>
                                        </select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Notes</label>
				<div class="col-md-6">
					<textarea class="form-control" name="notes" placeholder="Notes" >{{$detail['notes']}}</textarea>
				</div>
			</div>
                        <input class="form-control" maxlength="200" type="hidden" name="form" value="1" placeholder="Contact Person" />
				
                        
		</div>
		@if(in_array($detail['status'], ['active']))
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
                        <button class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>