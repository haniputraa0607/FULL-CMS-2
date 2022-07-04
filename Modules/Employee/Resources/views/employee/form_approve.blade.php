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
                                    <input type="checkbox" class="make-switch" id="status_employee" data-size="small" onchange="changeStatusEmployee()" data-on-color="success" data-on-text="Tetap" name="status_employee" data-off-color="default" data-off-text="Kontrak" @if($detail['status_employee']==1) checked @endif  @if(isset($dataDoc['Approved'])) disabled @endif>
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
                                                            <input type="text" class="form-control" disabled name="start_date" id="start_date" value="{{date('Y-m-d')}}"  required autocomplete="off" placeholder="Start Date Approved">
                                                            <input type="hidden" class="form-control datepicker" name="start_date" value="{{date('Y-m-d')}}" required autocomplete="off" placeholder="Start Date Approved">
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
                                                @if($detail['status_employee']==0)
                                                    <input type="text" class="form_datetime form-control" value="{{date('d-F-Y', strtotime($detail['end_date']))}}" disabled>
                                                @endif 
						
					@else
						<div class="input-icon right">
							<div class="input-group">
                                                            <input type="text" class="form-control datepicker" name="end_date" id="end_date" onchange='myFunction()' required autocomplete="off" placeholder="End Date Approved">
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
				<label class="col-md-4 control-label">Notes<span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
					<textarea required class="form-control" name="data_document[process_notes]" placeholder="Notes" @if(isset($dataDoc['Approved']['process_notes'])) disabled @endif>@if(isset($dataDoc['Approved']['process_notes'])) {{$dataDoc['Approved']['process_notes']}}  @endif</textarea>
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
                                    <select name="id_outlet" class="form-control input-sm select2" data-placeholder="Search Outlet" required>
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
			</div>
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