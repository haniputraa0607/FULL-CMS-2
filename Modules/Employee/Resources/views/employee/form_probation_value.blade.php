@php
	$new_form = false;
	$open_detail = false;
	$edit_delete = 0;
	if($detail['id_manager'] == session('id_user')){
		$new_form = true;
		$edit_delete = 1;
		$open_detail = true;
	}
	
	if($detail['id_outlet'] == session('id_outlet') && MyHelper::hasAccess([529], $grantedFeature) && isset($form_eval) ){
		$edit_delete = 1;
		$open_detail = true;
	}
		
	if(MyHelper::hasAccess([528], $grantedFeature)){
		$edit_delete = 1;
		$open_detail = true;
	}

@endphp

<div style="margin-top: -4%">
	<div style="text-align: center"><h3>Form Evaluation</h3></div>
	<hr style="border-top: 2px dashed;">     
	
	@if ($new_form)
	<div id="new_form_eval">
		<div>
			<button class="btn green" type="button" data-toggle="modal" data-target="#NewFormEvaluation">New Form Evaluation</button>
		</div>
		<br>
	</div>
	@endif

	<div style="white-space: nowrap;" id="table_form_eval">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="kt_datatable">
				<thead>
				<tr>
					<th class="text-nowrap text-center">Updated At</th>
					<th class="text-nowrap text-center">Code</th>
					<th class="text-nowrap text-center">Status</th>
					<th class="text-nowrap text-center">File</th>
					<th class="text-nowrap text-center">Action</th>
				</tr>
				</thead>
				<tbody>
					@if(!empty($detail['employee']['form_evaluation']))
						@foreach($detail['employee']['form_evaluation'] as $table_eval)
						<tr data-id="{{ $table_eval['id_employee_form_evaluation'] }}">
							<td>{{date('d F Y H:i', strtotime($table_eval['updated_at']))}}</td>
							<td>{{$table_eval['code']}}</td>
							<td>
								@if ($table_eval['status_form'] == 'approve_manager')
									Approved By Manager
								@elseif ($table_eval['status_form'] == 'reject_hr')
									Rejected By HRGA
								@elseif ($table_eval['status_form'] == 'approve_hr')
									Approved By HRGA
								@elseif ($table_eval['status_form'] == 'reject_director')
									Rejected By Director
								@elseif ($table_eval['status_form'] == 'approve_director')
									Approved By Director
								@endif
							</td>
							<td>
								@if(isset($table_eval['directory']))
								<a href="{{ $table_eval['directory'] }}">Form Evaluation</a>
								@else
								File Not Found
								@endif
							</td>
							<td>
								<a @if (!$open_detail) disabled @endif class="btn btn-danger btn" onclick="deleteFormEval({{ $table_eval['id_employee_form_evaluation'] }},{{ $edit_delete }})">&nbsp;<i class="fa fa-trash"></i></a>    
								<a @if (!$open_detail) disabled @endif class="btn btn-info btn" onclick="editFormEval({{ $table_eval['id_employee_form_evaluation'] }},{{ $edit_delete }})">&nbsp;<i class="fa fa-pencil-square-o"></i></a>    
							</td>
						</tr>
						@endforeach
					@else
						<tr>
							<td colspan="10" style="text-align: center">No Follow Up Yet</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
	
	@if(isset($detail['employee']['form_evaluation']))
		@foreach ( $detail['employee']['form_evaluation'] ?? [] as $key_form => $form_eval )
			<div id="form_eval_{{ $form_eval['id_employee_form_evaluation'] }}" hidden>
				<div>
					<button class="btn yellow" type="button" onclick="BackFormEval({{ $form_eval['id_employee_form_evaluation'] }})">Back</button>
				</div>
				<br>
				@php
					$manager[$form_eval['id_employee_form_evaluation']] = false;
					if($detail['id_manager'] == session('id_user')){
						$manager[$form_eval['id_employee_form_evaluation']] = true;
						if(isset($form_eval['status_form'])){
							if($form_eval['status_form'] == 'approve_manager' || $form_eval['status_form'] == 'approve_hr' || $form_eval['status_form'] == 'approve_director' || $form_eval['status_form'] == 'reject_director'){
								$manager[$form_eval['id_employee_form_evaluation']] = false;
							}
						}
					}
				
					$hrga[$form_eval['id_employee_form_evaluation']] = false;
					if($detail['id_outlet'] == session('id_outlet') && MyHelper::hasAccess([529], $grantedFeature) && isset($form_eval) ){
						$hrga[$form_eval['id_employee_form_evaluation']] = true;
						if(isset($form_eval['status_form'])){
							if($form_eval['status_form'] == 'approve_hr' || $form_eval['status_form'] == 'approve_director' || $form_eval['status_form'] == 'reject_hr'){
								$hrga[$form_eval['id_employee_form_evaluation']] = false;
							}
						}
					}
					
					$director[$form_eval['id_employee_form_evaluation']] = false;	
					if(MyHelper::hasAccess([528], $grantedFeature) && isset($form_eval) && isset($form_eval['status_form']) && $form_eval['status_form'] == 'approve_hr' ){
						$director[$form_eval['id_employee_form_evaluation']] = true;
					}
				@endphp
				<form class="form-horizontal"  role="form" action="{{url('employee/recruitment/evaluation/'.$form_eval['id_employee_form_evaluation'])}}" method="post" enctype="multipart/form-data">
					<div class="form-body">
						<div class="form-group">
							<input type="hidden" name="status_form" value="approve_manager">
							<label  class="control-label col-md-4">Work Productivity
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Produktifitas karyawan dalam berkeja di masa percobaan" data-container="body"></i>
							</label>
							<div class="col-md-4">
								<select id="work_productivity" name="work_productivity" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif>
									<option selected disabled></option>
									<option value="Perfect"  @if(isset($form_eval['work_productivity']) && $form_eval['work_productivity'] == 'Perfect') selected @endif>Perfect</option>
									<option value="Good" @if(isset($form_eval['work_productivity']) && $form_eval['work_productivity'] == 'Good') selected @endif>Good</option>
									<option value="Enough" @if(isset($form_eval['work_productivity']) && $form_eval['work_productivity'] == 'Enough') selected @endif>Enough</option>
									<option value="Bad" @if(isset($form_eval['work_productivity']) && $form_eval['work_productivity'] == 'Bad') selected @endif>Bad</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label  class="control-label col-md-4">Work Quality
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Kualitas karyawan dalam berkeja di masa percobaan" data-container="body"></i>
							</label>
							<div class="col-md-4">
								<select id="work_quality" name="work_quality" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif>
									<option selected disabled></option>
									<option value="Perfect"  @if(isset($form_eval['work_quality']) && $form_eval['work_quality'] == 'Perfect') selected @endif>Perfect</option>
									<option value="Good" @if(isset($form_eval['work_quality']) && $form_eval['work_quality'] == 'Good') selected @endif>Good</option>
									<option value="Enough" @if(isset($form_eval['work_quality']) && $form_eval['work_quality'] == 'Enough') selected @endif>Enough</option>
									<option value="Bad" @if(isset($form_eval['work_quality']) && $form_eval['work_quality'] == 'Bad') selected @endif>Bad</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label  class="control-label col-md-4">Knowledge of Work and Task
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Pengetahuan karyawan tentang pekerjaan dan tugas di masa percobaan" data-container="body"></i>
							</label>
							<div class="col-md-4">
								<select id="knwolege_task" name="knwolege_task" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif>
									<option selected disabled></option>
									<option value="Perfect"  @if(isset($form_eval['knwolege_task']) && $form_eval['knwolege_task'] == 'Perfect') selected @endif>Perfect</option>
									<option value="Good" @if(isset($form_eval['knwolege_task']) && $form_eval['knwolege_task'] == 'Good') selected @endif>Good</option>
									<option value="Enough" @if(isset($form_eval['knwolege_task']) && $form_eval['knwolege_task'] == 'Enough') selected @endif>Enough</option>
									<option value="Bad" @if(isset($form_eval['knwolege_task']) && $form_eval['knwolege_task'] == 'Bad') selected @endif>Bad</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label  class="control-label col-md-4">Relationship With Superiors
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Hubungan karyawan dengan atasan di masa percobaan" data-container="body"></i>
							</label>
							<div class="col-md-4">
								<select id="relationship" name="relationship" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif>
									<option selected disabled></option>
									<option value="Perfect"  @if(isset($form_eval['relationship']) && $form_eval['relationship'] == 'Perfect') selected @endif>Perfect</option>
									<option value="Good" @if(isset($form_eval['relationship']) && $form_eval['relationship'] == 'Good') selected @endif>Good</option>
									<option value="Enough" @if(isset($form_eval['relationship']) && $form_eval['relationship'] == 'Enough') selected @endif>Enough</option>
									<option value="Bad" @if(isset($form_eval['relationship']) && $form_eval['relationship'] == 'Bad') selected @endif>Bad</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label  class="control-label col-md-4">Cooperation with Others
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Kerjasama karyawan dengan orang lain di masa percobaan" data-container="body"></i>
							</label>
							<div class="col-md-4">
								<select id="cooperation" name="cooperation" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif>
									<option selected disabled></option>
									<option value="Perfect"  @if(isset($form_eval['cooperation']) && $form_eval['cooperation'] == 'Perfect') selected @endif>Perfect</option>
									<option value="Good" @if(isset($form_eval['cooperation']) && $form_eval['cooperation'] == 'Good') selected @endif>Good</option>
									<option value="Enough" @if(isset($form_eval['cooperation']) && $form_eval['cooperation'] == 'Enough') selected @endif>Enough</option>
									<option value="Bad" @if(isset($form_eval['cooperation']) && $form_eval['cooperation'] == 'Bad') selected @endif>Bad</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label  class="control-label col-md-4">Presence and Discipline
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Kehadiran dan kedisiplinan karyawan di masa percobaan" data-container="body"></i>
							</label>
							<div class="col-md-4">
								<select id="discipline" name="discipline" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif>
									<option selected disabled></option>
									<option value="Perfect"  @if(isset($form_eval['discipline']) && $form_eval['discipline'] == 'Perfect') selected @endif>Perfect</option>
									<option value="Good" @if(isset($form_eval['discipline']) && $form_eval['discipline'] == 'Good') selected @endif>Good</option>
									<option value="Enough" @if(isset($form_eval['discipline']) && $form_eval['discipline'] == 'Enough') selected @endif>Enough</option>
									<option value="Bad" @if(isset($form_eval['discipline']) && $form_eval['discipline'] == 'Bad') selected @endif>Bad</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label  class="control-label col-md-4">Initiative and Creativity
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Inisiatif dan kreatifitas karyawan di masa percobaan" data-container="body"></i>
							</label>
							<div class="col-md-4">
								<select id="initiative" name="initiative" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif>
									<option selected disabled></option>
									<option value="Perfect"  @if(isset($form_eval['initiative']) && $form_eval['initiative'] == 'Perfect') selected @endif>Perfect</option>
									<option value="Good" @if(isset($form_eval['initiative']) && $form_eval['initiative'] == 'Good') selected @endif>Good</option>
									<option value="Enough" @if(isset($form_eval['initiative']) && $form_eval['initiative'] == 'Enough') selected @endif>Enough</option>
									<option value="Bad" @if(isset($form_eval['initiative']) && $form_eval['initiative'] == 'Bad') selected @endif>Bad</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label  class="control-label col-md-4">Expandable capacity
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Kapasitas karyawan yang dapat dikembangkan ke depan (kepemimpinan, kemampuan untuk melaksanakan tugas yang lebih kompleks, dan lain-lain)" data-container="body"></i>
							</label>
							<div class="col-md-4">
								<select id="expandable" name="expandable" class="form-control input-sm select2" data-placeholder="Select Value" required @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif>
									<option selected disabled></option>
									<option value="Perfect"  @if(isset($form_eval['expandable']) && $form_eval['expandable'] == 'Perfect') selected @endif>Perfect</option>
									<option value="Good" @if(isset($form_eval['expandable']) && $form_eval['expandable'] == 'Good') selected @endif>Good</option>
									<option value="Enough" @if(isset($form_eval['expandable']) && $form_eval['expandable'] == 'Enough') selected @endif>Enough</option>
									<option value="Bad" @if(isset($form_eval['expandable']) && $form_eval['expandable'] == 'Bad') selected @endif>Bad</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Comments and Suggestions
								<i class="fa fa-question-circle tooltips" data-original-title="Komentar dan saran untuk karyawan" data-container="body"></i>
							</label>
							<div class="col-md-6">
								<textarea class="form-control" name="comment" placeholder="Comments and Suggestions" @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif>{{ $form_eval['comment'] ?? '' }}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label  class="control-label col-md-4">Update Status Employee
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Rekomendasi perbaruan status karyawan dalam perusahaan" data-container="body"></i>
							</label>
							<div class="col-md-6">
								<select id="update_status" name="update_status" class="form-control input-sm select2" data-id="{{ $form_eval['id_employee_form_evaluation'] }}" data-placeholder="Select Value" required @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif onchange="changeUpdateStatus('manager',this.value,{{ $form_eval['id_employee_form_evaluation'] }})"> 
									<option selected disabled></option>
									@if ($detail['status_employee']!='Permanent' || !$manager[$form_eval['id_employee_form_evaluation']])
									<option value="Permanent" @if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Permanent') selected @endif>Recommended to be a Permanent Employee</option>
									@endif
									<option value="Terminated "@if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Terminated') selected @endif>Recommended Not to be Continued as An Employee</option>
									@if ($detail['status_employee']!='Permanent' || !$manager[$form_eval['id_employee_form_evaluation']])
									<option value="Extension"@if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Extension') selected @endif>Contract Extension</option>
									@endif
									<option value="Not Change" @if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Not Change') selected @endif>No Status Change</option>
								</select>
							</div>
						</div>
						<div class="form-group" id="div_extension_manager_{{ $form_eval['id_employee_form_evaluation'] }}" @if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Extension') @else hidden @endif>
							<label class="col-md-4 control-label">Contract Extension
								<i class="fa fa-question-circle tooltips" data-original-title="Komentar dan saran untuk karyawan" data-container="body"></i>
							</label>
							<div class="col-md-2">
								<input type="number" class="form-control" id="current_extension_{{ $form_eval['id_employee_form_evaluation'] }}" name="current_extension" placeholder="" value="{{ $form_eval['current_extension'] ?? '' }}" @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif @if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Extension') required @endif></input>
							</div>
							<div class="col-md-2">
								<select id="time_extension" name="time_extension_{{ $form_eval['id_employee_form_evaluation'] }}" class="form-control input-sm select2" @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif @if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Extension') required @endif>
									<option value="Month" @if(!isset($form_eval)) selected @elseif (isset($form_eval['time_extension']) && $form_eval['time_extension'] == 'Month') selected @endif>Months</option>
									<option value="Year" @if(isset($form_eval['time_extension']) && $form_eval['time_extension'] == 'Year') selected @endif>Years</option>
								</select>
							</div>
						</div>
					</div>
					@if(in_array($detail['status'], ['active']))
					<div class="row" style="text-align: center">
						{{ csrf_field() }}
									<button class="btn blue" @if(!$manager[$form_eval['id_employee_form_evaluation']]) disabled @endif>Submit</button>
					</div>
					@endif
				</form>
				<br>
				<form class="form-horizontal"  role="form" action="{{url('employee/recruitment/evaluation/'.$form_eval['id_employee_form_evaluation'])}}" method="post" enctype="multipart/form-data">
					<div class="form-body">
						<div style="text-align: center"><h3>Request Update From HRGA</h3></div>
						<hr style="border-top: 2px dashed;">  
						<div class="form-group">
							<input type="hidden" name="status_form" value="approve_hr">
							<label  class="control-label col-md-4">Update Status Employee
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Rekomendasi perbaruan status karyawan dalam perusahaan" data-container="body"></i>
							</label>
							<div class="col-md-6">
								<select id="update_status_hr" name="update_status" class="form-control input-sm select2" data-placeholder="Select Value" @if(!$hrga[$form_eval['id_employee_form_evaluation']]) disabled @endif onchange="changeUpdateStatus('hr',this.value,{{ $form_eval['id_employee_form_evaluation'] }})">
									<option selected disabled></option>
									@if ($detail['status_employee']!='Permanent' || !$manager[$form_eval['id_employee_form_evaluation']])
									<option value="Permanent" @if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Permanent') selected @endif>Recommended to be a Permanent Employee</option>
									@endif
									<option value="Terminated "@if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Terminated') selected @endif>Recommended Not to be Continued as An Employee</option>
									@if ($detail['status_employee']!='Permanent' || !$manager[$form_eval['id_employee_form_evaluation']])
									<option value="Extension"@if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Extension') selected @endif>Contract Extension</option>
									@endif
									<option value="Not Change"@if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Not Change') selected @endif>No Status Change</option>
			
								</select>
							</div>
						</div>
						<div class="form-group" id="div_extension_hrga_{{ $form_eval['id_employee_form_evaluation'] }}" @if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Extension') @else hidden @endif>
							<label class="col-md-4 control-label">Contract Extension
								<i class="fa fa-question-circle tooltips" data-original-title="Komentar dan saran untuk karyawan" data-container="body"></i>
							</label>
							<div class="col-md-2">
								<input type="number" class="form-control" id="current_extension_hr_{{ $form_eval['id_employee_form_evaluation'] }}" name="current_extension" placeholder="" value="{{ $form_eval['current_extension'] ?? '' }}" @if(!$hrga[$form_eval['id_employee_form_evaluation']]) disabled @endif @if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Extension') required @endif></input>
							</div>
							<div class="col-md-2">
								<select id="time_extension_hr__{{ $form_eval['id_employee_form_evaluation'] }}" name="time_extension" class="form-control input-sm select2" @if(!$hrga[$form_eval['id_employee_form_evaluation']]) disabled @endif @if(isset($form_eval['update_status']) && $form_eval['update_status'] == 'Extension') required @endif>
									<option value="Month" @if(!isset($form_eval)) selected @elseif (isset($form_eval['time_extension']) && $form_eval['time_extension'] == 'Month') selected @endif>Months</option>
									<option value="Year" @if(isset($form_eval['time_extension']) && $form_eval['time_extension'] == 'Year') selected @endif>Years</option>
								</select>
							</div>
						</div>
					</div>
					@if(in_array($detail['status'], ['active']))
					<div class="row" style="text-align: center">
						{{ csrf_field() }}
						@if($hrga[$form_eval['id_employee_form_evaluation']])
						<a class="btn btn-danger evaluation" data-id="{{ $form_eval['id_employee_form_evaluation'] }}" data-name="{{ $detail['name'] }}" data-status="reject_hr">Reject</a>
						@endif
						<button class="btn blue" @if(!$hrga[$form_eval['id_employee_form_evaluation']]) disabled @endif>Submit</button>
						@if($director[$form_eval['id_employee_form_evaluation']])
						<a class="btn btn-danger evaluation" data-id="{{ $form_eval['id_employee_form_evaluation'] }}" data-name="{{ $detail['name'] }}" data-status="reject_director">Reject</a>
						<a class="btn btn-success evaluation" data-id="{{ $form_eval['id_employee_form_evaluation'] }}" data-name="{{ $detail['name'] }}" data-status="approve_director">Approve</a>
						@endif
					</div>
					@endif
				</form>  
			</div>
		@endforeach
	@endif
</div>