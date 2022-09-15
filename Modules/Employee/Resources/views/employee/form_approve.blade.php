<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_approve" role="form" action="{{url('employee/recruitment/update/'.$detail['id_employee'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Approve Action</h3></div>
			<hr style="border-top: 2px dashed;">

			<div class="form-group">
				<label  class="control-label col-md-4">Type Contract Employee
					<i class="fa fa-question-circle tooltips" data-original-title="Jika di centang maka sebegai karyawan tetap, jika tidak maka sebagai karyawan kontrak" data-container="body"></i>
				</label>
				<div class="col-md-4">
					{{-- <input type="checkbox" class="make-switch" id="status_employee" data-size="small" onchange="changeStatusEmployee()" data-on-color="success" data-on-text="Tetap" name="status_employee" data-off-color="default" data-off-text="Kontrak" @if($detail['status_employee']==1) checked @endif  @if(isset($dataDoc['Approved'])) disabled @endif> --}}

					<select onchange="changeStatusEmployee(this.value)" id="status_employee" name="status_employee" class="form-control input-sm select2" data-placeholder="Select Type Contract" required>
						<option selected disabled></option>
						<option value="Permanent" @if($detail['status_employee']=='Permanent') selected @endif>Permanent</option>
						<option value="Contract" @if($detail['status_employee']=='Contract') selected @endif>Contract</option>
						<option value="Probation" @if($detail['status_employee']=='Probation') selected @endif>Probation</option>
					</select>
				</div>
			</div>
			<div class="form-group" id="show_start">
				<label class="col-md-4 control-label">Start Date <span class="required" aria-required="true"> * </span>
					</label>
				<div class="col-md-4" >
					@if(isset($dataDoc['Approved']))
					<input type="text" id="start" class="form_datetime form-control" value="{{date('d-F-Y', strtotime($detail['start_date']))}}" disabled>
					@else
					<div class="input-icon right">
						<div class="input-group">
							<input type="text" class="form-control date_picker" name="start_date" id="start_date" value="{{isset($detail['start_date']) ? date('Y-m-d', strtotime($detail['start_date'])) : '' }}" required autocomplete="off" placeholder="Start Date Approved">
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
			<div class="form-group" id="show_end">
				<label class="col-md-4 control-label">End Date <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-4">
					@if(isset($dataDoc['Approved']))
						@if($detail['status_employee']=='Contract' || $detail['status_employee']=='Probation')
							<input type="text" class="date_picker form-control" value="{{date('d-F-Y', strtotime($detail['end_date']))}}" disabled>
						@endif 
						
					@else
						<div class="input-icon right">
							<div class="input-group">
								<input type="text" class="form-control date_picker" name="end_date" id="end_date" onchange='myFunction()' required autocomplete="off" placeholder="End Date Approved">
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
				<label class="col-md-4 control-label">Notes
				</label>
				<div class="col-md-6">
					<textarea class="form-control" name="data_document[process_notes]" placeholder="Notes" @if(isset($dataDoc['Approved']['process_notes'])) disabled @endif>@if(isset($dataDoc['Approved']['process_notes'])) {{$dataDoc['Approved']['process_notes']}}  @endif</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Attachment</label>
				<div class="col-md-6">
					@if(isset($dataDoc['Approved']['attachment']))
						@if(empty($dataDoc['Approved']['attachment']))
							<p style="margin-top: 2%">No file</p>
						@else
							<a style="margin-top: 2%" class="btn blue btn-xs" href="{{$dataDoc['Approved']['attachment'] }} "><i class="fa fa-download"></i></a>
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
			<input type="hidden" name="data_document[document_type]" value="Approved">
                          <hr style="border-top: 2px dashed;">
                        @if($detail['status_approved'] == 'Contract')
			<div class="form-group">
				<label  class="control-label col-md-4">Office
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Kantor admin" data-container="body"></i>
				</label>
				<div class="col-md-6">
                                    <select onchange="manager()" id="id_outlet" name="id_outlet" class="form-control input-sm select2" data-placeholder="Search Office" required>
                                                <option></option>
                                                @foreach($outlets as $key => $val)
                                                    <option value="{{ $val['id_outlet'] }}">{{ $val['outlet_code'] }} - {{ $val['outlet_name'] }}</option>
                                                @endforeach
                                            </select>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Role
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Jabatan admin" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<select name="id_role" class="form-control input-sm select2" data-placeholder="Search Role" required>
                                            <option></option>
                                            @foreach($roles as $key => $val)
                                                <option value="{{ $val['id_role'] }}" >{{ $val['role_name'] }}</option>
                                            @endforeach
                                        </select>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Department
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Department dalam satu office" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<select onchange="manager()" id="id_department" name="id_department" class="form-control input-sm select2" data-placeholder="Search Department" required>
                                            <option></option>
                                            @foreach($departments as $key => $val)
                                                <option value="{{ $val['id_department'] }}" >{{ $val['department_name'] }}</option>
                                            @endforeach
                                        </select>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Manager
                                    <i class="fa fa-question-circle tooltips" data-original-title="Manager dalam satu kantor sesuai department" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<select name="id_manager" id="id_manager" class="form-control input-sm select2" data-placeholder="Search Manager">
                                        </select>
				</div>
			</div>
<!--			<div class="form-group">
				<label  class="control-label col-md-4">Auto Generate PIN
					<i class="fa fa-question-circle tooltips" data-original-title="Jika di centang maka pin akan di generate otomatis oleh sistem" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<label class="mt-checkbox mt-checkbox-outline">
						<input type="checkbox" name="auto_generate_pin" id="auto_generate_pin" class="same checkbox-product-price" onclick="changeAutoGeneratePinApprove()"/>
						<span></span>
					</label>
				</div>
			</div>
			<div id="div_password">
				<div class="form-group">
					<label for="example-search-input" class="control-label col-md-4">PIN 
						<i class="fa fa-question-circle tooltips" data-original-title="Masukkan pin yang akan digunakan untuk login" data-container="body"></i>
					</label>
					<div class="col-md-6">
						<input class="form-control" maxlength="6" type="password" onkeyup="matchPassword('app')" name="pin" id="pinapp1" placeholder="Enter PIN" required autocomplete="new-password"/>
					</div>
				</div>
				<div class="form-group">
					<label for="example-search-input" class="control-label col-md-4">Re-type PIN 
						<i class="fa fa-question-circle tooltips" data-original-title="Ketik ulang pin yang akan digunakan untuk login" data-container="body"></i>
					</label>
					<div class="col-md-6">
						<input class="form-control" maxlength="6" onkeyup="matchPassword('app')" type="password" name="pin2" id="pinapp2" placeholder="Re-type PIN" required autocomplete="new-password"/>
						<b style="color: red;font-size: 12px;display: none" id="alert_password_app">Password des not match</b>
					</div>
				</div>
			</div>-->
                        @endif
		</div>
		<input type="hidden" name="action_type" id="action_type_approve" value="Approved">
                @if($detail['status_approved'] == 'Contract')
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
                        @if(in_array($detail['status'], ['candidate']))
                            <a class="btn red save" data-name="{{ $detail['name'] }}" data-status="Rejected" data-form="approve">Reject</a>
                            <button class="btn green-jungle" id="btn_submit_app">Approve</button>
                        @endif
		</div>
                @endif
	</form>
</div>