<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_psychological" role="form" action="{{url('employee/reimbursement/update/'.$data['id_employee_reimbursement'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Finance Approval</h3></div>
			<hr style="border-top: 2px dashed;">
			<div class="form-group">
				<label class="col-md-4 control-label">Notes
				</label>
				<div class="col-md-6">
					<textarea class="form-control" name="data_document[process_notes]" placeholder="Notes" @if(isset($dataDoc['Fat Dept Approved']['process_notes'])) disabled @endif>@if(isset($dataDoc['Fat Dept Approved']['process_notes'])) {{$dataDoc['Fat Dept Approved']['process_notes']}}  @endif</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Attachment</label>
				<div class="col-md-6">
                                            @if(isset($dataDoc['Fat Dept Approved']['attachment']))
						@if(empty($dataDoc['Fat Dept Approved']['attachment']))
							<p style="margin-top: 2%">No file</p>
						@else
							<a style="margin-top: 2%" class="btn blue btn-xs" href="{{$dataDoc['Fat Dept Approved']['attachment'] }} "><i class="fa fa-download"></i></a>
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
			<input type="hidden" name="data_document[document_type]" value="Fat Dept Approved">
		</div>
		<input type="hidden" name="action_type" id="action_type_psychological" value="Fat Dept Approved">
		@if(!isset($dataDoc['Fat Dept Approved']))
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			@if(in_array($data['status'], ['HRGA Approved'])&&MyHelper::hasAccess([530], $grantedFeature))
                        <a class="btn red save" data-name="{{ $data['name_product'] }}" data-status="Rejected" data-form="approve">Reject</a>
                           <button class="btn blue">Submit</button>
                        @endif
		</div>
		@endif
</form>
</div>