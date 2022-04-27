<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_technical" role="form" action="{{url($url_back.'/update/'.$detail['id_user_hair_stylist'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Data Technical Test</h3></div>
			<hr style="border-top: 2px dashed;">
			<div class="form-group">
				<label class="col-md-4 control-label">Test Date <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-4">
					@if(isset($dataDoc['Technical Tested']))
						<input type="text" class="form_datetime form-control" value="{{date('d-F-Y H:i', strtotime($dataDoc['Technical Tested']['process_date']))}}" disabled>
					@else
						<div class="input-icon right">
							<div class="input-group">
								<input @if($detail['user_hair_stylist_status'] != 'Candidate') disabled @endif type="text" class="form_datetime form-control" name="data_document[process_date]" required autocomplete="off" placeholder="Test Date">
								<span class="input-group-btn">
						<button class="btn default" type="button">
							<i class="fa fa-calendar"></i>
						</button>
						<button class="btn default" type="button">
							<i class="fa fa-question-circle tooltips" data-original-title="Tanggal dan waktu tes teknis" data-container="body"></i>
						</button>
					</span>
							</div>
						</div>
					@endif
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Test By <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-4">
					<input class="form-control" @if($detail['user_hair_stylist_status'] != 'Candidate') disabled @endif maxlength="200" type="text" name="data_document[process_name_by]" @if(isset($dataDoc['Technical Tested'])) value="{{$dataDoc['Technical Tested']['process_name_by']}}" disabled @endif placeholder="Test By" required/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Notes <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
					<textarea class="form-control" @if($detail['user_hair_stylist_status'] != 'Candidate') disabled @endif name="data_document[process_notes]" placeholder="Notes" @if(isset($dataDoc['Technical Tested'])) disabled @endif>@if(isset($dataDoc['Technical Tested']['process_notes'])) {{$dataDoc['Technical Tested']['process_notes']}} disabled @endif</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Attachment</label>
				<div class="col-md-6">
					@if(isset($dataDoc['Technical Tested']['attachment']))
						@if(empty($dataDoc['Technical Tested']['attachment']))
							<p style="margin-top: 2%">No file</p>
						@else
							<a style="margin-top: 2%" class="btn blue btn-xs" href="{{url('recruitment/hair-stylist/detail/download-file', $dataDoc['Technical Tested']['id_user_hair_stylist_document'])}}"><i class="fa fa-download"></i></a>
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
					<input type="file" name="data_document[attachment]" @if($detail['user_hair_stylist_status'] != 'Candidate') disabled @endif> </span>
								<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
							</div>
						</div>
					@endif
				</div>
			</div>
			<input type="hidden" name="data_document[document_type]" value="Technical Tested">
		</div>
		<input type="hidden" name="action_type" id="action_type_technical" value="Technical Tested">
		<input type="hidden" name="tab_type" value="candidate-status">
		@if(!isset($dataDoc['Technical Tested']) && $detail['user_hair_stylist_status'] != 'Rejected'&& $detail['user_hair_stylist_status'] == 'Candidate')
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			<a class="btn red save" data-name="{{ $detail['fullname'] }}" data-status="Rejected" data-form="technical">Reject</a>
			<button class="btn blue">Submit</button>
		</div>
		@endif
	</form>
</div>