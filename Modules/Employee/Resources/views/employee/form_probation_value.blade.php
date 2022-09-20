@php
	$manager = false;
	if($detail['id_manager'] == session('id_user')){
		$manager = true;
	}

	$hrga = false;
	if($detail['id_outlet'] == session('id_outlet') && MyHelper::hasAccess([529], $grantedFeature && isset($detail['employee']['form_evaluation'])) ){
		$hrga = true;
	}
	
	$director = false;	
	if(MyHelper::hasAccess([528], $grantedFeature) && isset($detail['employee']['form_evaluation']) && isset($detail['employee']['form_evaluation']['status_form']) && $detail['employee']['form_evaluation']['status_form'] == 'approve_hr' ){
		$director = true;
	}
@endphp

<div style="margin-top: -4%">
	<form class="form-horizontal"  role="form" action="{{url('employee/recruitment/evaluation/'.$detail['id_employee'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Form Evaluation</h3></div>
			<hr style="border-top: 2px dashed;">               

			<div class="form-group">
				<input type="hidden" name="status_form" value="approve_manager">
				<label  class="control-label col-md-4">Work Productivity
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Produktifitas karyawan dalam berkeja di masa percobaan" data-container="body"></i>
				</label>
				<div class="col-md-4">
					<select id="work_productivity" name="work_productivity" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager) disabled @endif>
						<option selected disabled></option>
						<option value="Perfect"  @if(isset($detail['employee']['form_evaluation']['work_productivity']) && $detail['employee']['form_evaluation']['work_productivity'] == 'Perfect') selected @endif>Perfect</option>
						<option value="Good" @if(isset($detail['employee']['form_evaluation']['work_productivity']) && $detail['employee']['form_evaluation']['work_productivity'] == 'Good') selected @endif>Good</option>
						<option value="Enough" @if(isset($detail['employee']['form_evaluation']['work_productivity']) && $detail['employee']['form_evaluation']['work_productivity'] == 'Enough') selected @endif>Enough</option>
						<option value="Bad" @if(isset($detail['employee']['form_evaluation']['work_productivity']) && $detail['employee']['form_evaluation']['work_productivity'] == 'Bad') selected @endif>Bad</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Work Quality
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Kualitas karyawan dalam berkeja di masa percobaan" data-container="body"></i>
				</label>
				<div class="col-md-4">
					<select id="work_quality" name="work_quality" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager) disabled @endif>
						<option selected disabled></option>
						<option value="Perfect"  @if(isset($detail['employee']['form_evaluation']['work_quality']) && $detail['employee']['form_evaluation']['work_quality'] == 'Perfect') selected @endif>Perfect</option>
						<option value="Good" @if(isset($detail['employee']['form_evaluation']['work_quality']) && $detail['employee']['form_evaluation']['work_quality'] == 'Good') selected @endif>Good</option>
						<option value="Enough" @if(isset($detail['employee']['form_evaluation']['work_quality']) && $detail['employee']['form_evaluation']['work_quality'] == 'Enough') selected @endif>Enough</option>
						<option value="Bad" @if(isset($detail['employee']['form_evaluation']['work_quality']) && $detail['employee']['form_evaluation']['work_quality'] == 'Bad') selected @endif>Bad</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Knowledge of Work and Task
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Pengetahuan karyawan tentang pekerjaan dan tugas di masa percobaan" data-container="body"></i>
				</label>
				<div class="col-md-4">
					<select id="knwolege_task" name="knwolege_task" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager) disabled @endif>
						<option selected disabled></option>
						<option value="Perfect"  @if(isset($detail['employee']['form_evaluation']['knwolege_task']) && $detail['employee']['form_evaluation']['knwolege_task'] == 'Perfect') selected @endif>Perfect</option>
						<option value="Good" @if(isset($detail['employee']['form_evaluation']['knwolege_task']) && $detail['employee']['form_evaluation']['knwolege_task'] == 'Good') selected @endif>Good</option>
						<option value="Enough" @if(isset($detail['employee']['form_evaluation']['knwolege_task']) && $detail['employee']['form_evaluation']['knwolege_task'] == 'Enough') selected @endif>Enough</option>
						<option value="Bad" @if(isset($detail['employee']['form_evaluation']['knwolege_task']) && $detail['employee']['form_evaluation']['knwolege_task'] == 'Bad') selected @endif>Bad</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Relationship With Superiors
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Hubungan karyawan dengan atasan di masa percobaan" data-container="body"></i>
				</label>
				<div class="col-md-4">
					<select id="relationship" name="relationship" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager) disabled @endif>
						<option selected disabled></option>
						<option value="Perfect"  @if(isset($detail['employee']['form_evaluation']['relationship']) && $detail['employee']['form_evaluation']['relationship'] == 'Perfect') selected @endif>Perfect</option>
						<option value="Good" @if(isset($detail['employee']['form_evaluation']['relationship']) && $detail['employee']['form_evaluation']['relationship'] == 'Good') selected @endif>Good</option>
						<option value="Enough" @if(isset($detail['employee']['form_evaluation']['relationship']) && $detail['employee']['form_evaluation']['relationship'] == 'Enough') selected @endif>Enough</option>
						<option value="Bad" @if(isset($detail['employee']['form_evaluation']['relationship']) && $detail['employee']['form_evaluation']['relationship'] == 'Bad') selected @endif>Bad</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Cooperation with Others
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Kerjasama karyawan dengan orang lain di masa percobaan" data-container="body"></i>
				</label>
				<div class="col-md-4">
					<select id="cooperation" name="cooperation" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager) disabled @endif>
						<option selected disabled></option>
						<option value="Perfect"  @if(isset($detail['employee']['form_evaluation']['cooperation']) && $detail['employee']['form_evaluation']['cooperation'] == 'Perfect') selected @endif>Perfect</option>
						<option value="Good" @if(isset($detail['employee']['form_evaluation']['cooperation']) && $detail['employee']['form_evaluation']['cooperation'] == 'Good') selected @endif>Good</option>
						<option value="Enough" @if(isset($detail['employee']['form_evaluation']['cooperation']) && $detail['employee']['form_evaluation']['cooperation'] == 'Enough') selected @endif>Enough</option>
						<option value="Bad" @if(isset($detail['employee']['form_evaluation']['cooperation']) && $detail['employee']['form_evaluation']['cooperation'] == 'Bad') selected @endif>Bad</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Presence and Discipline
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Kehadiran dan kedisiplinan karyawan di masa percobaan" data-container="body"></i>
				</label>
				<div class="col-md-4">
					<select id="discipline" name="discipline" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager) disabled @endif>
						<option selected disabled></option>
						<option value="Perfect"  @if(isset($detail['employee']['form_evaluation']['discipline']) && $detail['employee']['form_evaluation']['discipline'] == 'Perfect') selected @endif>Perfect</option>
						<option value="Good" @if(isset($detail['employee']['form_evaluation']['discipline']) && $detail['employee']['form_evaluation']['discipline'] == 'Good') selected @endif>Good</option>
						<option value="Enough" @if(isset($detail['employee']['form_evaluation']['discipline']) && $detail['employee']['form_evaluation']['discipline'] == 'Enough') selected @endif>Enough</option>
						<option value="Bad" @if(isset($detail['employee']['form_evaluation']['discipline']) && $detail['employee']['form_evaluation']['discipline'] == 'Bad') selected @endif>Bad</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Initiative and Creativity
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Inisiatif dan kreatifitas karyawan di masa percobaan" data-container="body"></i>
				</label>
				<div class="col-md-4">
					<select id="initiative" name="initiative" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager) disabled @endif>
						<option selected disabled></option>
						<option value="Perfect"  @if(isset($detail['employee']['form_evaluation']['initiative']) && $detail['employee']['form_evaluation']['initiative'] == 'Perfect') selected @endif>Perfect</option>
						<option value="Good" @if(isset($detail['employee']['form_evaluation']['initiative']) && $detail['employee']['form_evaluation']['initiative'] == 'Good') selected @endif>Good</option>
						<option value="Enough" @if(isset($detail['employee']['form_evaluation']['initiative']) && $detail['employee']['form_evaluation']['initiative'] == 'Enough') selected @endif>Enough</option>
						<option value="Bad" @if(isset($detail['employee']['form_evaluation']['initiative']) && $detail['employee']['form_evaluation']['initiative'] == 'Bad') selected @endif>Bad</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Expandable capacity
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Kapasitas karyawan yang dapat dikembangkan ke depan (kepemimpinan, kemampuan untuk melaksanakan tugas yang lebih kompleks, dan lain-lain)" data-container="body"></i>
				</label>
				<div class="col-md-4">
					<select id="expandable" name="expandable" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager) disabled @endif>
						<option selected disabled></option>
						<option value="Perfect"  @if(isset($detail['employee']['form_evaluation']['expandable']) && $detail['employee']['form_evaluation']['expandable'] == 'Perfect') selected @endif>Perfect</option>
						<option value="Good" @if(isset($detail['employee']['form_evaluation']['expandable']) && $detail['employee']['form_evaluation']['expandable'] == 'Good') selected @endif>Good</option>
						<option value="Enough" @if(isset($detail['employee']['form_evaluation']['expandable']) && $detail['employee']['form_evaluation']['expandable'] == 'Enough') selected @endif>Enough</option>
						<option value="Bad" @if(isset($detail['employee']['form_evaluation']['expandable']) && $detail['employee']['form_evaluation']['expandable'] == 'Bad') selected @endif>Bad</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Comments and Suggestions
					<i class="fa fa-question-circle tooltips" data-original-title="Komentar dan saran untuk karyawan" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<textarea class="form-control" name="comment" placeholder="Comments and Suggestions" @if(!$manager) disabled @endif>{{ $detail['employee']['form_evaluation']['comment'] ?? '' }}</textarea>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Update Status Employee
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Rekomendasi perbaruan status karyawan dalam perusahaan" data-container="body"></i>
				</label>
				<div class="col-md-4">
					<select id="update_status" name="update_status" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager) disabled @endif>
						<option selected disabled></option>
						<option value="Permanent" @if(isset($detail['employee']['form_evaluation']['update_status']) && $detail['employee']['form_evaluation']['update_status'] == 'Permanent') selected @endif>Recommended to be a Permanent Employee</option>
						<option value="Terminated "@if(isset($detail['employee']['form_evaluation']['update_status']) && $detail['employee']['form_evaluation']['update_status'] == 'Terminated') selected @endif>Recommended Not to be Continued as An Employee</option>
						<option value="Extension"@if(isset($detail['employee']['form_evaluation']['update_status']) && $detail['employee']['form_evaluation']['update_status'] == 'Extension') selected @endif>Contract Extension</option>
					</select>
				</div>
			</div>
			<div class="form-group" id="div_extension_manager" @if(isset($detail['employee']['form_evaluation']['update_status']) && $detail['employee']['form_evaluation']['update_status'] == 'Extension') @else hidden @endif>
				<label class="col-md-4 control-label">Contract Extension
					<i class="fa fa-question-circle tooltips" data-original-title="Komentar dan saran untuk karyawan" data-container="body"></i>
				</label>
				<div class="col-md-2">
					<input type="number" class="form-control" id="current_extension" name="current_extension" placeholder="" value="{{ $detail['employee']['form_evaluation']['current_extension'] ?? '' }}" @if(!$manager) disabled @endif @if(isset($detail['employee']['form_evaluation']['update_status']) && $detail['employee']['form_evaluation']['update_status'] == 'Extension') required @endif></input>
				</div>
				<div class="col-md-2">
					<select id="time_extension" name="time_extension" class="form-control input-sm select2" @if(!$manager) disabled @endif @if(isset($detail['employee']['form_evaluation']['update_status']) && $detail['employee']['form_evaluation']['update_status'] == 'Extension') required @endif>
						<option value="Month" @if(!isset($detail['employee']['form_evaluation']['update_status'])) selected @elseif (isset($detail['employee']['form_evaluation']['update_status']) && $detail['employee']['form_evaluation']['update_status'] == 'Permanent') selected @endif>Months</option>
						<option value="Year " @if(isset($detail['employee']['form_evaluation']['update_status']) && $detail['employee']['form_evaluation']['update_status'] == 'Permanent') selected @endif>Years</option>
					</select>
				</div>
			</div>
		</div>
		@if(in_array($detail['status'], ['active']))
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
                        <button class="btn blue" @if(!$manager) disabled @endif>Submit</button>
		</div>
		@endif
	</form>
	<br>
	<form class="form-horizontal"  role="form" action="{{url('employee/recruitment/evaluation/'.$detail['id_employee'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Request Update From HRGA</h3></div>
			<hr style="border-top: 2px dashed;">  
			<div class="form-group">
				<label  class="control-label col-md-4">Update Status Employee
					<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Rekomendasi perbaruan status karyawan dalam perusahaan" data-container="body"></i>
				</label>
				<div class="col-md-4">
					<select id="update_status_hr" name="update_status" class="form-control input-sm select2" data-placeholder="Select Value" @if(!$hrga) disabled @endif>
						<option selected disabled></option>
						<option value="Permanent">Recommended to be a Permanent Employee</option>
						<option value="Terminated ">Recommended Not to be Continued as An Employee</option>
						<option value="Extension">Contract Extension</option>
					</select>
				</div>
			</div>
			<div class="form-group" id="div_extension_hrga" hidden>
				<label class="col-md-4 control-label">Contract Extension
					<i class="fa fa-question-circle tooltips" data-original-title="Komentar dan saran untuk karyawan" data-container="body"></i>
				</label>
				<div class="col-md-2">
					<input type="number" class="form-control" id="current_extension_hr" name="current_extension" placeholder="" @if(!$hrga) disabled @endif></input>
				</div>
				<div class="col-md-2">
					<select id="time_extension_hr" name="time_extension_hr" class="form-control input-sm select2" @if(!$hrga) disabled @endif>
						<option value="Month" selected>Months</option>
						<option value="Year ">Years</option>
					</select>
				</div>
			</div>
		</div>
		@if(in_array($detail['status'], ['active']))
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
                <button class="btn blue" @if(!$hrga) disabled @endif>Submit</button>
				@if($director)
				<a class="btn btn-danger">Reject</a>
				<a class="btn btn-success">Approve</a>
				@endif
		</div>
		@endif
	</form>           
</div>