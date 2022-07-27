<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_interview" role="form" action="{{url('employee/recruitment/update/'.$detail['id_employee'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Approved HRGA (Human Resource and General Affair)</h3></div>
			<hr style="border-top: 2px dashed;">
			<div class="form-group">
				<label class="col-md-4 control-label">Approved By <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-4">
					<input class="form-control" maxlength="200" type="text" name="data_document[process_name_by]" @if(isset($dataDoc['HRGA']['process_name_by'])) value="{{$dataDoc['HRGA']['process_name_by']}}" disabled @endif placeholder="HRGA by" required/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Notes
				</label>
				<div class="col-md-6">
					<textarea class="form-control" name="data_document[process_notes]" placeholder="Notes" @if(isset($dataDoc['HRGA']['process_name_by'])) disabled @endif>@if(isset($dataDoc['HRGA']['process_notes'])) {{$dataDoc['HRGA']['process_notes']}}  @endif</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Attachment</label>
				<div class="col-md-6">
					@if(isset($dataDoc['HRGA']['attachment']))
						@if(empty($dataDoc['HRGA']['attachment']))
							<p style="margin-top: 2%">No file</p>
						@else
							<a style="margin-top: 2%" class="btn blue btn-xs" href="{{$dataDoc['HRGA']['attachment'] }} "><i class="fa fa-download"></i></a>
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
			<input type="hidden" name="data_document[document_type]" value="HRGA">
		</div>
		<input type="hidden" name="action_type" id="action_type_interview" value="HRGA">
		@if(!isset($dataDoc['HRGA']))
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			@if(in_array($detail['status'], ['candidate']))
                            <a class="btn red save" data-name="{{ $detail['name'] }}" data-status="Rejected" data-form="interview">Reject</a>
                            <button class="btn blue">Submit</button>
                        @endif
		</div>
		@endif
</form>
</div>