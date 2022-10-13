<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_psychological" role="form" action="{{url('employee/cash-advance/update/'.$data['id_employee_cash_advance'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Director Approval</h3></div>
			<hr style="border-top: 2px dashed;">
                        @if(isset($dataDoc['HRGA/Direktur Approval']['name']))
                        <div class="form-group">
				<label class="col-md-2 control-label">Approved 
				</label>
				<div class="col-md-6">
                                    <input class="form-control" value="{{$dataDoc['HRGA/Direktur Approval']['name']??''}}" disabled>
				</div>
			</div>
                        @endif
			<div class="form-group">
				<label class="col-md-2 control-label">Notes
				</label>
				<div class="col-md-6">
					<textarea class="form-control" name="data_document[process_notes]" placeholder="Notes" @if(isset($dataDoc['HRGA/Direktur Approval']['process_notes'])) disabled @endif>@if(isset($dataDoc['HRGA/Direktur Approval']['process_notes'])) {{$dataDoc['HRGA/Direktur Approval']['process_notes']}}  @endif</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Attachment</label>
				<div class="col-md-6 fileinput fileinput-new" data-provides="fileinput">
                                            @if(isset($dataDoc['HRGA/Direktur Approval']['attachment']))
						@if(empty($dataDoc['HRGA/Direktur Approval']['attachment']))
							<p style="margin-top: 2%">No file</p>
						@else
							<a style="margin-top: 2%" class="btn blue btn-xs" href="{{$dataDoc['HRGA/Direktur Approval']['attachment'] }} "><i class="fa fa-download"></i></a>
						@endif
					@else
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
					@endif
				</div>
			</div>
			<input type="hidden" name="data_document[document_type]" value="HRGA/Direktur Approval">
		</div>
		<input type="hidden" name="action_type" id="action_type_psychological" value="HRGA/Direktur Approval">
		@if(!isset($dataDoc['HRGA/Direktur Approval']))
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			@if(in_array($data['status'], ['Manager Approval'])&&MyHelper::hasAccess([528], $grantedFeature))
                           <a class="btn red save" data-name="{{ $data['name'] }}" data-status="Rejected" data-form="approve">Reject</a>
                           <button class="btn blue">Submit</button>
                        @endif
		</div>
		@endif
</form>
</div>