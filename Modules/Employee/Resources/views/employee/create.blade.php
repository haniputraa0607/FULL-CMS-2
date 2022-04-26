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
	<script type="text/javascript">
		function changeTrigger() {
			let userLevel = $('select[name=level] option:selected').val();
			$('#select_department, #select_job_level').hide().find('select').prop('disabled', true);
			if (userLevel == 'Admin') {
				$('#select_department, #select_job_level').show().find('select').prop('disabled', false);
			} else {
				$('#select_department, #select_job_level').hide().find('select').prop('disabled', true);
			}
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
		<li class="active"><a href="{{url('/user/create')}}">New Customer</a></li>
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
				<form role="form" class="form-horizontal" action="{{url('employee/recruitment/create')}}" method="POST" enctype="multipart/form-data">
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
							    Nickname
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama panggilan user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="nickname" placeholder="Nickname (Required)" class="form-control" required />
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
								<input type="text" id="phone" name="phone" placeholder="Phone Number (Required & Unique)" class="form-control" required autocomplete="new-password" />
							</div>
						</div>
                                                <div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Birthplace
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan tempat lahir" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="birthplace" placeholder="Birthplace" class="form-control" required />
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
									<input type="text"  data-date-format="yyyy-mm-dd" class="form-control form-filter input-sm date-picker" name="birthday" placeholder="Birthday Date" required>
									<span class="input-group-btn">
										<button class="btn btn-sm default" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
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
							    Blood Type
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Golongan darah user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="blood_type" placeholder="Blood Type" class="form-control" autocomplete="blood_type" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Height
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Tinggi badan user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="number" name="height" placeholder="Height" class="form-control" autocomplete="height" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Weight
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Berat badan user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="number" name="weight" placeholder="Weight" class="form-control" autocomplete="weight" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Country
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kewarganegaraan user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="country" placeholder="Country" class="form-control" autocomplete="country" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Place of Origin
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Daerah Asal/Suku user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="place_of_origin" placeholder="Place of Origin" class="form-control" autocomplete="place_of_origin" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Religion
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kepercayaan user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="religion" placeholder="Religion" class="form-control" autocomplete="religion" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Card Number
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Nomor KTP user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="card_number" id="card_number" placeholder="Card Number" class="form-control" autocomplete="card_number" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    City
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kota sesuai KTP user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="id_city_ktp" class="form-control input-sm select2" placeholder="Search City" data-placeholder="Choose Users City" required>
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
							    <i class="fa fa-question-circle tooltips" data-original-title="Alamat sesuai KTP user" data-container="body" ></i>
							    </label>
							</div>
							<div class="col-md-9">
								<textarea required type="text" name="address_ktp" placeholder="Input your address here..." class="form-control"></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Postcode
							    <i class="fa fa-question-circle tooltips" data-original-title="Kode pos sesuai KTP user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="postcode_ktp" placeholder="Postcode KTP" class="form-control" autocomplete="postcode" />
							</div>
						</div>
                                                <div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Landline Number
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon rumah" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" id="phone_number" name="phone_number" placeholder="Landline Number" class="form-control" required autocomplete="phone_number" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    City Domicile
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="id_city_domicile" class="form-control input-sm select2" placeholder="Search City" data-placeholder="Choose Users City" required>
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
							    Address Domicile
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Alamat domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<textarea type="text" name="address_domicile" placeholder="Input your address here..." class="form-control" required></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Postcode Domicile
                                                            <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Kode pos domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="postcode_domicile" placeholder="Postcode Domicile" class="form-control" autocomplete="postcode" required/>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Status Domicile
                                                            <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Status alamat domisili user" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" required name="status_address_domicile" placeholder="Status Domicile" class="form-control" autocomplete="status_address_domicile" />
							</div>
						</div>
                                                <div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Marital Status
							    <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Status perkawinan" data-container="body" required></i>
							    </label>
							</div>
							<div class="col-md-9">
								<select name="marital_status" class="form-control input-sm select2" data-placeholder="Marital Status" required>
									<option value="">Select...</option>
									<option value="Lajang">Lajang</option>
									<option value="Menikah">Menikah</option>
									<option value="Janda">Janda</option>
									<option value="Duda">Duda</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Married Date
							    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal pernikahan" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy-mm-dd">
									<input type="text" class="form-control form-filter  data-date-format="yyyy-mm-dd" input-sm date-picker" name="married_date" placeholder="Married Date" >
									<span class="input-group-btn">
										<button class="btn btn-sm default" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
						</div>
                                                <div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Applied Position
                                                            <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Posisi yang dilamar" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" required name="applied_position" placeholder="Applied Position" class="form-control" autocomplete="applied_position" />
							</div>
						</div>
                                                <div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Other Position
                                                            <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Posisi lain yang diminati" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" required name="other_position" placeholder="Other Position" class="form-control" autocomplete="other_position" />
							</div>
						</div>
                                                <div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Vacancy Information
                                                            <span class="required" aria-required="true"> * </span>
							    <i class="fa fa-question-circle tooltips" data-original-title="Sumber informasi lowongan" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" required name="vacancy_information" placeholder="Vacancy Information" class="form-control" autocomplete="vacancy_information" />
							</div>
						</div>
                                                <div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
                                                            Relatives
							    <i class="fa fa-question-circle tooltips" data-original-title="Memiliki anggota keluarga/kerabat yang masih Aktif sebagai karyawan/ Hair Stylist di Ixobox/Goonting" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								 <input type="checkbox" class="make-switch" data-size="small"  data-on-color="success" data-on-text="Ya" name="relatives" data-off-color="default" data-off-text="Tidak" id="relatives">
							</div>
						</div>
                                                <div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
                                                            Relative Name
							    <i class="fa fa-question-circle tooltips" data-original-title="Nama anggota keluarga/kerabat yang masih Aktif sebagai karyawan/ Hair Stylist di Ixobox/Goonting" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="relative_name" placeholder="Relative Name" class="form-control" autocomplete="relative_name" />
							</div>
						</div>
                                                <div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Relative Position
							    <i class="fa fa-question-circle tooltips" data-original-title="Posisi jabatan anggota keluarga/kerabat yang masih Aktif sebagai karyawan/ Hair Stylist di Ixobox/Goonting" data-container="body"></i>
							    </label>
							</div>
							<div class="col-md-9">
								<input type="text" name="relative_position" placeholder="Relative Position" class="form-control" autocomplete="relative_position" />
							</div>
						</div>
					</div>
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
function number(id){
    $(id).inputmask("remove");
    $(id).inputmask({
        mask: "9999 9999 999999",
        removeMaskOnSubmit: true,
        placeholder:"",
        prefix: "",
        //digits: 0,
        // groupSeparator: '.',
        rightAlign: false,
        greedy: false,
        autoGroup: true,
        digitsOptional: false,
    });
}
function number_ktp(id){
    $(id).inputmask("remove");
    $(id).inputmask({
        mask: "9999999999999999",
        removeMaskOnSubmit: true,
        placeholder:"",
        prefix: "",
        //digits: 0,
        // groupSeparator: '.',
        rightAlign: false,
        greedy: false,
        autoGroup: true,
        digitsOptional: false,
    });
}
        $(document).ready(function() {
            number("#phone");
            number("#phone_number");
            number_ktp("#card_number");
        });
 </script>
@endsection