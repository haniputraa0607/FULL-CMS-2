<div style="margin-top: -4%">
	<form class="form-horizontal" role="form" action="{{url($url_back.'/update/'.$detail['id_user_hair_stylist'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Training Result</h3></div>
			<hr style="border-top: 2px dashed;">
			<div class="form-group">
				<label class="col-md-4 control-label">PIC Name <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-4">
					<input class="form-control" maxlength="200" type="text" name="data_document[2][process_name_by]"  @if(isset($dataDoc['Training Completed']['process_name_by'])) value="{{$dataDoc['Training Completed']['process_name_by']}}" disabled @endif placeholder="PIC Name" required/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Notes <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
					<textarea class="form-control" name="data_document[2][process_notes]" placeholder="Notes" @if(isset($dataDoc['Training Completed']['process_name_by'])) disabled @endif>@if(isset($dataDoc['Training Completed']['process_notes'])) {{$dataDoc['Training Completed']['process_notes']}} disabled @endif</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Attachment</label>
				<div class="col-md-6">
					@if(isset($dataDoc['Training Completed']['attachment']))
						@if(empty($dataDoc['Training Completed']['attachment']))
							<p style="margin-top: 2%">No file</p>
						@else
							<a style="margin-top: 2%" class="btn blue btn-xs" href="{{url('recruitment/hair-stylist/detail/download-file', $dataDoc['Training Completed']['id_user_hair_stylist_document'])}}"><i class="fa fa-download"></i></a>
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
								<input type="file" name="data_document[2][attachment]"> </span>
								<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
							</div>
						</div>
					@endif
				</div>
			</div>
			<input type="hidden" name="data_document[2][document_type]" value="Training Completed">
		</div>
		<input type="hidden" name="action_type" id="action_type" value="Training Completed">
		@if(!isset($dataDoc['Training Completed']))
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			<a class="btn red save" data-name="{{ $detail['fullname'] }}" data-status="reject">Reject</a>
			<button class="btn blue">Submit</button>
		</div>
		@endif
	</form>
</div>