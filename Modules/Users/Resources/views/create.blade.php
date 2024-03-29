@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		var city = <?php echo json_encode($city); ?>;

		function changeTrigger() {
			let userLevel = $('select[name=level] option:selected').val();
			$('#select_department, #select_job_level').hide().find('select').prop('disabled', true);
			if (userLevel == 'Admin') {
				$('#select_department, #select_job_level').show().find('select').prop('disabled', false);
			} else {
				$('#select_department, #select_job_level').hide().find('select').prop('disabled', true);
			}

			if(userLevel == 'Customer'){
				$('.div_role_outlet').hide();
				$('.select_outlet_role').prop('required',false);
			}else{
				$('.div_role_outlet').show();
				$('.select_outlet_role').prop('required',true);
			}
		}

		$("input[name=birthday]").on('change',function(){
			if($(this).val()!=''){
				var birthday = new Date($(this).val());
				var today = new Date();
				if(new Date(birthday) <= new Date(today)){
					document.getElementById('check_birthday').style.display = 'none';
				}else{
					document.getElementById('check_birthday').style.display = 'block';
				}
			}
		});

		function submitNewUser() {
            var check_birthday= $('#check_birthday').css('display');
			var check_address = /[a-zA-Z0-9]+$/.test($("textarea[name=address]").val());
            if(check_birthday == 'block'){
                toastr.warning("Birthday date can't be more than today");
			}else if(!check_address){
                toastr.warning("Invalid value address");
				document.getElementById('check_address').style.display = 'block';
            }else {
				document.getElementById('check_address').style.display = 'none';
                var data = $('#form-new-user').serialize();
                if (!$('form#form-new-user')[0].checkValidity()) {
                    toastr.warning("Incompleted Data. Please fill blank input.");
                }else{
                    $('form#form-new-user').submit();
                }
            }
        }

		function changeProv(val){
			$('#list_city').empty();
			var html = `<option></option>`;
			$.each(city, function(i, data) {
				if(val == data.id_province){
					html += `<option value='${data.id_city}'>${data.city_name}</option>`;
				}
			});
			$('#list_city').append(html);
			$(".select2").select2({	placeholder: "Select..."});
		}

		$(document).ready(function(){
			changeTrigger();
			$('select[name=level]').on('change',function(){
				changeTrigger();
			});
		});
	</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
            <i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="{{url('/user')}}">User</a>
            <i class="fa fa-circle"></i>
		</li>
		<li class="active"><a href="{{url('/user/create')}}">New User</a></li>
	</ul>
</div>
@include('layouts.notifications')
<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">New User Account</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form id="form-new-user" role="form" class="form-horizontal" action="{{url('user/create')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Name
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="name" placeholder="User Name (Required)" class="form-control" required />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Email
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Email user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="email" placeholder="Email (Required & Unique)" class="form-control" required autocomplete="new-password" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Phone
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon seluler" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="phone" placeholder="Phone Number (Required & Unique)" class="form-control" required autocomplete="new-password" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    PIN
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="PIN terdiri dari 6 digit angka" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="password" name="pin" placeholder="6 digits PIN (Leave empty to autogenerate)" class="form-control mask_number" maxlength="6" autocomplete="new-password" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Sent PIN to User?
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Pilih apakah akan mengirimkan PIN ke user (Yes/No)" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="sent_pin" class="form-control input-sm select2" data-placeholder="Yes / No" required>
									<option value="">Select...</option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Birthday
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal lahir user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy-mm-dd">
									<input type="text" class="form-control form-filter input-sm date-picker" name="birthday" placeholder="Birthday Date" required>
									<span class="input-group-btn">
										<button class="btn btn-sm default" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
								<p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="check_birthday">Birthday date can't be more than today</p>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Gender
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Jenis kelamin user (laki-laki/perempuan)" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="gender" class="form-control input-sm select2" data-placeholder="Male / Female" required>
									<option value="">Select...</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Celebrate
{{--							    <span class="required" aria-required="true"> * </span>--}}
							    <i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="celebrate" class="form-control input-sm select2" placeholder="Search Celebrate" data-placeholder="Choose Users Celebrate">
									<option value="">Select...</option>
									@if(isset($celebrate))
										@foreach($celebrate as $row)
											<option value="{{$row}}">{{$row}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Work
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="job" class="form-control input-sm select2" placeholder="Search Work" data-placeholder="Choose Users Work" required>
									<option value="">Select...</option>
									@if(isset($job))
										@foreach($job as $row)
											<option value="{{$row}}">{{$row}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Province
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="id_province" onchange="changeProv(this.value)" class="form-control input-sm select2" placeholder="Search Province" data-placeholder="Choose Users Province" required>
									<option value="">Select...</option>
									@if(isset($province))
										@foreach($province as $row)
											<option value="{{$row['id_province']}}">{{$row['province_name']}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    City
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="id_city" id="list_city" class="form-control input-sm select2" placeholder="Search City" data-placeholder="Choose Users City" required>
									<option value="">Select...</option>
									@if(isset($city))
										@foreach($city as $row)
											<option value="{{$row['id_city']}}">{{$row['city_name']}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Address
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<textarea type="text" name="address" placeholder="Input your address here..." class="form-control"></textarea>
								<p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="check_address">Invalid value address</p>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Level
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Hak akses yang diberikan ke user (admin/ customer)" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="level" class="form-control input-sm select2">
									<option value="Admin">Admin</option>
									<option value="Customer">Customer</option>
								</select>
							</div>
						</div>
						<div class="form-group div_role_outlet">
							<div class="input-icon right">
								<label class="col-md-3 control-label">
									Outlet
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Outlet cabang untuk karyawaan" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-9">
								<select name="id_outlet" class="form-control input-sm select2 select_outlet_role" data-placeholder="Search Outlet">
									<option></option>
									@foreach($outlets as $key => $val)
										<option value="{{ $val['id_outlet'] }}">{{ $val['outlet_code'] }} - {{ $val['outlet_name'] }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group div_role_outlet">
							<div class="input-icon right">
								<label class="col-md-3 control-label">
									Role
									<span class="required" aria-required="true"> * </span>
									<i class="fa fa-question-circle tooltips" data-original-title="Role untuk user" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-9">
								<select name="id_role" class="form-control input-sm select2 select_outlet_role" data-placeholder="Search Role">
									<option></option>
									@foreach($roles as $key => $val)
										<option value="{{ $val['id_role'] }}">{{ $val['role_name'] }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
								<label class="col-md-3 control-label">
									ID Card
									<i class="fa fa-question-circle tooltips" data-original-title="Foto KTP Customer" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-9">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px; height: 100px;">
										<img src="https://www.cs.emory.edu/site/media/rg5">
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100px; max-height: 100px;"> </div>
									<div>
										<span class="btn default btn-file">
											<span class="fileinput-new"> Select image </span>
											<span class="fileinput-exists"> Change </span>
											<input type="file" accept="image/*" id="field_image" class="file" name="id_card_image">
										</span>
										<a href="javascript:;" id="removeImage" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						{{-- <button type="submit" class="btn blue" id="checkBtn">Create</button> --}}
						<a id="btn-store" class="btn blue" onclick="submitNewUser()">Approve</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection