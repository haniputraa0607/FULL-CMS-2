<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_interview" role="form" action="{{url($url_back.'/update/'.$detail['id_employee'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Data Contract</h3></div>
			<hr style="border-top: 2px dashed;">
                        <div class="form-group">
				<label class="col-md-4 control-label">Start Date <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-4">
					@if(isset($dataDoc['Contract']))
						<input type="text" id="start" class="form_datetime form-control" value="{{date('d-F-Y', strtotime($detail['start_date']))}}" disabled>
					@else
						<div class="input-icon right">
							<div class="input-group">
								<input type="text" class="datepicker form-control" name="start_date" id="start_date" onchange='myFunction()' required autocomplete="off" placeholder="Start Date Contract">
								<span class="input-group-btn">
						<button class="btn default" type="button">
							<i class="fa fa-calendar"></i>
						</button>
						<button class="btn default" type="button">
							<i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai contract" data-container="body"></i>
						</button>
						</span>
							</div>
						</div>
					@endif
				</div>
			</div>
                        <div class="form-group">
				<label class="col-md-4 control-label">End Date <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-4">
					@if(isset($dataDoc['Contract']))
						<input type="text" class="form_datetime form-control" value="{{date('d-F-Y', strtotime($detail['end_date']))}}" disabled>
					@else
						<div class="input-icon right">
							<div class="input-group">
                                                            <input type="text" class="datepicker form-control" name="end_date" id="end_date" onchange='myFunction()' required autocomplete="off" placeholder="End Date Contract">
								<span class="input-group-btn">
						<button class="btn default" type="button">
							<i class="fa fa-calendar"></i>
						</button>
						<button class="btn default" type="button">
							<i class="fa fa-question-circle tooltips" data-original-title="Tanggal selesai contract" data-container="body"></i>
						</button>
						</span>
							</div>
						</div>
					@endif
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Notes <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
					<textarea class="form-control" name="data_document[process_notes]" placeholder="Notes" @if(isset($dataDoc['Contract']['process_notes'])) disabled @endif>@if(isset($dataDoc['Contract']['process_notes'])) {{$dataDoc['Contract']['process_notes']}}  @endif</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Attachment</label>
				<div class="col-md-6">
					@if(isset($dataDoc['Contract']['attachment']))
						@if(empty($dataDoc['Contract']['attachment']))
							<p style="margin-top: 2%">No file</p>
						@else
							<a style="margin-top: 2%" class="btn blue btn-xs" href="{{url('recruitment/hair-stylist/detail/download-file', $dataDoc['Contract']['id_employee_document'])}}"><i class="fa fa-download"></i></a>
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
			<input type="hidden" name="data_document[document_type]" value="Contract">
		</div>
		<input type="hidden" name="action_type" id="action_type_interview" value="Contract">
		@if(!isset($dataDoc['Contract']))
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			<a class="btn red save" data-name="{{ $detail['name'] }}" data-status="Rejected" data-form="interview">Reject</a>
                        <button id='submit' class="btn blue" disabled>Submit</button>
		</div>
		@endif
</form>
</div>
<script>
function myFunction() {
  var start = document.getElementById("start_date").value;
  var end = document.getElementById("end_date").value;
  if(start < end){
     $("#submit").removeAttr('disabled');
  }
}
</script>