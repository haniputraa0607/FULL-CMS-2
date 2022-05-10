<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_psychological" role="form" action="{{url($url_back.'/update/'.$detail['id_user_hair_stylist'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Data Psychological Test</h3></div>
			<hr style="border-top: 2px dashed;">
			<div class="form-group">
				<label class="col-md-4 control-label">Notes
				</label>
				<div class="col-md-6">
					<textarea class="form-control" name="data_document[process_notes]" placeholder="Notes" @if(isset($dataDoc['Psychological Tested']['process_notes'])) disabled @endif>@if(isset($dataDoc['Psychological Tested']['process_notes'])) {{$dataDoc['Psychological Tested']['process_notes']}} @endif</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Attachment</label>
				<div class="col-md-6">
					@if(isset($dataDoc['Psychological Tested']['attachment']))
						@if(empty($dataDoc['Psychological Tested']['attachment']))
							<p style="margin-top: 2.3%">No file</p>
						@else
							<a style="margin-top: 2.3%" class="btn blue btn-xs" href="{{url('recruitment/hair-stylist/detail/download-file', $dataDoc['Psychological Tested']['id_user_hair_stylist_document'])}}"><i class="fa fa-download"></i></a>
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
								<input @if($detail['user_hair_stylist_status'] != 'Candidate') disabled @endif type="file" name="data_document[attachment]"> </span>
								<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
							</div>
						</div>
					@endif
				</div>
			</div>
			<input type="hidden" name="data_document[document_type]" value="Psychological Tested">
		</div>
		<input type="hidden" name="action_type" id="action_type_psychological" value="Psychological Tested">
		@if(!isset($dataDoc['Psychological Tested']) && $detail['user_hair_stylist_status'] != 'Rejected')
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			<a class="btn red save" data-name="{{ $detail['fullname'] }}" data-status="Rejected" data-form="psychological">Reject</a>
			<button class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>