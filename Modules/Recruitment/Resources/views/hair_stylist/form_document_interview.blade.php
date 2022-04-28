<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_interview" role="form" action="{{url($url_back.'/update/'.$detail['id_user_hair_stylist'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Data Interview</h3></div>
			<hr style="border-top: 2px dashed;">
			<div class="form-group">
				<label class="col-md-4 control-label">Interview Date <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-4">
					@if(isset($dataDoc['Interviewed']))
						<input type="text" class="form_datetime form-control" value="{{date('d-F-Y H:i', strtotime($dataDoc['Interviewed']['process_date']))}}" disabled>
					@else
						<div class="input-icon right">
							<div class="input-group">
								<input type="text" class="form_datetime form-control" name="data_document[process_date]" required autocomplete="off" placeholder="Interview Date" @if($detail['user_hair_stylist_status'] != 'Candidate') disabled @endif>
								<span class="input-group-btn">
						<button class="btn default" type="button">
							<i class="fa fa-calendar"></i>
						</button>
						<button class="btn default" type="button">
							<i class="fa fa-question-circle tooltips" data-original-title="Tanggal dan waktu interview" data-container="body"></i>
						</button>
						</span>
							</div>
						</div>
					@endif
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Interview By <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-4">
					<input class="form-control" maxlength="200" type="text" name="data_document[process_name_by]" @if(isset($dataDoc['Interviewed']['process_name_by'])) value="{{$dataDoc['Interviewed']['process_name_by']}}" disabled @endif placeholder="Interview by" required />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Notes <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
					<textarea class="form-control" name="data_document[process_notes]" placeholder="Notes" @if(isset($dataDoc['Interviewed']['process_name_by'])) disabled @endif @if($detail['user_hair_stylist_status'] != 'Candidate') disabled @endif>@if(isset($dataDoc['Interviewed']['process_notes'])) {{$dataDoc['Interviewed']['process_notes']}} @endif</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Attachment</label>
				<div class="col-md-6">
					@if(isset($dataDoc['Interviewed']['attachment']))
						@if(empty($dataDoc['Interviewed']['attachment']))
							<p style="margin-top: 2.3%">No file</p>
						@else
							<a style="margin-top: 2.3%" class="btn blue btn-xs" href="{{url('recruitment/hair-stylist/detail/download-file', $dataDoc['Interviewed']['id_user_hair_stylist_document'])}}"><i class="fa fa-download"></i></a>
						@endif
					@elseif($detail['user_hair_stylist_status'] != 'Candidate')
						<p style="margin-top: 2.3%">-</p>
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
			<input type="hidden" name="data_document[document_type]" value="Interviewed">
		</div>
		<input type="hidden" name="action_type" id="action_type_interview" value="Interviewed">
		@if(!isset($dataDoc['Interviewed']) && $detail['user_hair_stylist_status'] != 'Rejected')
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			<a class="btn red save" data-name="{{ $detail['fullname'] }}" data-status="Rejected" data-form="interview">Reject</a>
			<button class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>