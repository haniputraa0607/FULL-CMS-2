<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_psychological" role="form" action="{{url($url_back.'/update/'.$detail['id_employee'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Data Bank</h3></div>
			<hr style="border-top: 2px dashed;">
                        <div class="form-group">
				<label class="col-md-4 control-label">Bank Account Name <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama akun bank BCA" data-container="body"></i>
				</label>
				<div class="col-md-4">
					<input class="form-control" maxlength="200" type="text" name="bank_account_name" @if(isset($detail['bank_account_name'])) value="{{$detail['bank_account_name']}}" disabled @endif placeholder="Bank Account Name" required/>
				</div>
			</div>
                        <div class="form-group">
				<label class="col-md-4 control-label">Bank Account Number <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nomor rekening akun bank BCA" data-container="body"></i>
				</label>
				<div class="col-md-4">
					<input class="form-control" maxlength="200" type="text" name="bank_account_number" @if(isset($detail['bank_account_number'])) value="{{$detail['bank_account_number']}}" disabled @endif placeholder="Bank Account Number" required/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Notes
				</label>
				<div class="col-md-6">
					<textarea class="form-control" name="data_document[process_notes]" placeholder="Notes" @if(isset($dataDoc['Success']['process_notes'])) disabled @endif>@if(isset($dataDoc['Success']['process_notes'])) {{$dataDoc['Success']['process_notes']}}  @endif</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Attachment</label>
				<div class="col-md-6">
					@if(isset($dataDoc['Success']['attachment']))
						@if(empty($dataDoc['Success']['attachment']))
							<p style="margin-top: 2%">No file</p>
						@else
							<a style="margin-top: 2%" class="btn blue btn-xs" href="{{url('recruitment/hair-stylist/detail/download-file', $dataDoc['Success']['id_employee_document'])}}"><i class="fa fa-download"></i></a>
						@endif
					@else
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="input-group input-large">
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
			<input type="hidden" name="data_document[document_type]" value="Success">
		</div>
		<input type="hidden" name="action_type" id="action_type_psychological" value="Success">
		@if(!isset($dataDoc['Success']))
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			<button class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>