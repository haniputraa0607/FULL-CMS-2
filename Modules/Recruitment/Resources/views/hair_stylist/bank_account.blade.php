<div style="margin-top: 5%">
	<form class="form-horizontal" id="form_approve" role="form" action="{{url('recruitment/hair-stylist/bank-account/save')}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div class="form-group">
				<label class="col-md-3 control-label">Bank Name <span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Bank yang digunakan" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<div class="input-icon right">
						<select  class="form-control select2" name="id_bank_name" data-placeholder="Select bank">
							<option></option>
							@foreach($banks as $bank)
								<option value="{{$bank['id_bank_name']}}" @if($bank['id_bank_name'] == $detail['id_bank_name']) selected @endif>{{$bank['bank_name']}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Beneficiary Name <span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Nama pemilik akun" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<input type="text" placeholder="Beneficiary Name" maxlength="150" class="form-control" name="beneficiary_name" value="{{ $detail['beneficiary_name']}}" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Beneficiary Account <span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Nomor pemilik akun" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<input type="text" placeholder="Beneficiary Account" maxlength="30" class="form-control onlynumber" name="beneficiary_account" value="{{ $detail['beneficiary_account']}}" required>
				</div>
			</div>
			<input type="hidden" name="id_user_hair_stylist" value="{{$detail['id_user_hair_stylist']}}">
		</div>
		<div class="row" style="text-align: center;margin-top: 4%">
			{{ csrf_field() }}
			<button class="btn blue">Submit</button>
		</div>
	</form>
</div>