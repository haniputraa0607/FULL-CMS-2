<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main-closed')
@include('recruitment::hair_stylist.detail_schedule')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />

    @yield('detail-schedule-style')
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });

		$(".form_datetime").datetimepicker({
			format: "d-M-yyyy hh:ii",
			autoclose: true,
			todayBtn: true,
			minuteStep:1
		});

        var SweetAlert = function() {
            return {
                init: function() {
                    $(".approve-candidate").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to approve this candidate?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, approve it!",
                                    closeOnConfirm: false
                                },
                                function(){
									$('#action_type').val('approve');
                                    if ($('form#form-submit')[0].checkValidity()) {
										if(document.getElementById('auto_generate_pin').checked == false && $('#pin1').val() !== $('#pin2').val()){
											swal({
												title: "Woops!",
												text: 'Password didn\'t match',
												type: "warning",
												showCancelButton: true,
												showConfirmButton: false
											});
										}else{
											$('form#form-submit').submit();
										}
                                    }else{
                                        swal({
                                            title: "Incompleted Data",
                                            text: "Please fill blank input",
                                            type: "warning",
                                            showCancelButton: true,
                                            showConfirmButton: false
                                        });
                                    }
                                });
                        })
                    });

                    $(".save").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let name    = $(this).data('name');
						let status    = $(this).data('status');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want change to status "+status.toLowerCase()+" ?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, save it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $('#action_type').val(status);
                                    $('form#form-submit').submit();
                                });
                        })
                    })
                }
            }
        }();

        jQuery(document).ready(function() {
            SweetAlert.init()
        });

		$(".filePhoto").change(function(e) {
			var widthImg  = 300;
			var heightImg = 300;

			var _URL = window.URL || window.webkitURL;
			var image, file;

			if ((file = this.files[0])) {
				image = new Image();

				image.onload = function() {
					if (this.width != widthImg && this.height != heightImg) {
						toastr.warning("Please check dimension of your photo.");
						$('#image').children('img').attr('src', 'https://www.placehold.it/720x360/EFEFEF/AAAAAA&amp;text=no+image');
						$('#filePhoto').val("");
						$("#removeImage").trigger( "click" );
					}
				};

				image.src = _URL.createObjectURL(file);
			}

		});

		function changeAutoGeneratePin() {
			if(document.getElementById('auto_generate_pin').checked){
				$("#div_password").hide();
				$('#pin1').prop('required', false);
				$('#pin2').prop('required', false);
			}else{
				$("#div_password").show();
				$('#pin1').prop('required', true);
				$('#pin2').prop('required', true);
			}
		}
    </script>
@endsection

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $title }}</span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
                <li>
                    <span>{{ $sub_title }}</span>
                </li>
            @endif
        </ul>
    </div><br>

    <a href="{{url($url_back)}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Detail {{$sub_title}}</span>
            </div>
        </div>

        <div class="tabbable-line boxless tabbable-reversed">
        	<ul class="nav nav-tabs">
                <li class="active">
                    <a href="#hs-info" data-toggle="tab"> Info </a>
                </li>
                @if($detail['user_hair_stylist_status'] == 'Active')
	                <li>
	                    <a href="#hs-schedule" data-toggle="tab"> Schedule </a>
	                </li>
                @endif
            </ul>
        </div>

        <div class="portlet-body">
        	<div class="tab-content">
		        <div class="tab-pane active form" id="hs-info">
		            <form class="form-horizontal" id="form-submit" role="form" action="{{url($url_back.'/update/'.$detail['id_user_hair_stylist'])}}" method="post" enctype="multipart/form-data">
		                <div class="form-body">
							<div class="form-group">
								<label class="col-md-4 control-label">Status</label>
								<div class="col-md-6">
									@if($detail['user_hair_stylist_status'] == 'Candidate')
										<span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #9b9e9c;padding: 5px 12px;color: #fff;">Candidate</span>
									@elseif($detail['user_hair_stylist_status'] == 'Active')
										<span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Active</span>
									@elseif($detail['user_hair_stylist_status'] == 'Rejected')
										<span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Rejected</span>
									@elseif($detail['user_hair_stylist_status'] == 'Inactive')
										<span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Inactive</span>
									@else
										<span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #faf21e;padding: 5px 12px;color: #fff;">{{$detail['user_hair_stylist_status'] }}</span>
									@endif
								</div>
							</div>
		                    @if($detail['user_hair_stylist_status'] == 'Active' || $detail['user_hair_stylist_status'] == 'Inactive')
		                        <div class="form-group">
		                            <label class="col-md-4 control-label">Approve By</label>
		                            <div class="col-md-6">{{$detail['approve_by_name']}}</div>
		                        </div>
		                        <div class="form-group">
		                            <label class="col-md-4 control-label">Join Date</label>
		                            <div class="col-md-6">{{date('d M Y H:i', strtotime($detail['join_date']))}}</div>
		                        </div>
		                        <div class="form-group">
		                            <label class="col-md-4 control-label">Bank Account</label>
		                            <div class="col-md-6" style="margin-top: 1%">
		                                @if(empty($detail['beneficiary_account']))
		                                    -
		                                @else
		                                    {{$detail['bank_name']}}<br>
		                                    {{$detail['beneficiary_name']}}<br>
		                                    {{$detail['beneficiary_account']}}
		                                @endif
		                            </div>
		                        </div>
		                    @endif
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Nickname <span class="required" aria-required="true"> * </span>
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <input type="text" placeholder="Nickname" class="form-control" name="nickname" value="{{ $detail['nickname']}}" @if($detail['user_hair_stylist_status'] == 'Training Completed') required  @else readonly @endif>
		                            </div>
		                        </div>
		                    </div>
							<div class="form-group">
								<label class="col-md-4 control-label">
									Photo<span class="required" aria-required="true"> <br>(300*300) </span>
								</label>
								<div class="col-md-8">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
											<img src="@if(isset($detail['user_hair_stylist_photo'])){{$detail['user_hair_stylist_photo']}}@endif" alt="">
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" id="image" style="max-width: 200px; max-height: 200px;"></div>
										@if(!!in_array($detail['user_hair_stylist_status'], ['Active','Inactive']))
											<div>
												<span class="btn default btn-file">
												<span class="fileinput-new"> Select image </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file" class="filePhoto" id="fieldphoto" accept="image/*" name="user_hair_stylist_photo">
												</span>
												<a href="javascript:;" id="removeImage" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
											</div>
										@endif
									</div>
								</div>
							</div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Level <span class="required" aria-required="true"> * </span>
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <select  class="form-control select2" name="level" data-placeholder="Select level" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) disabled @endif>
		                                    <option></option>
		                                    <option value="Supervisor" @if($detail['level'] == 'Supervisor') selected @endif>Supervisor</option>
		                                    <option value="Hairstylist" @if($detail['level'] == 'Hairstylist') selected @endif>Hairstylist</option>
		                                </select>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Full Name <span class="required" aria-required="true"> * </span>
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <input type="text" placeholder="Full Name" class="form-control" name="fullname" value="{{ $detail['fullname']}}" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) readonly @endif>
		                            </div>
		                        </div>
		                    </div>
							<div class="form-group">
								<label class="col-md-4 control-label">Email <span class="required" aria-required="true"> * </span>
								</label>
								<div class="col-md-6">
									<div class="input-icon right">
										<input type="text" placeholder="Email" class="form-control" name="email" value="{{ $detail['email']}}" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) readonly @endif>
									</div>
								</div>
							</div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Phone <span class="required" aria-required="true"> * </span>
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <input type="text" placeholder="Phone" class="form-control" name="phone_number" value="{{ $detail['phone_number']}}" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) readonly @endif>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Gender <span class="required" aria-required="true"> * </span>
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <select  class="form-control select2" name="gender" data-placeholder="Select gender" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) disabled @endif>
		                                    <option></option>
		                                    <option value="Male" @if($detail['gender'] == 'Male') selected @endif>Male</option>
		                                    <option value="Female" @if($detail['gender'] == 'Female') selected @endif>Female</option>
		                                </select>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Nationality <span class="required" aria-required="true"> * </span>
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <input type="text" placeholder="Nationality" class="form-control" name="nationality" value="{{ $detail['nationality']}}" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) readonly @endif>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Birthplace <span class="required" aria-required="true"> * </span>
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <input type="text" placeholder="Birthplace" class="form-control" name="birthplace" value="{{ $detail['birthplace']}}" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) readonly @endif>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <div class="input-icon right">
		                            <label class="col-md-4 control-label">
		                                Birthdate
		                                <span class="required" aria-required="true"> * </span>
		                            </label>
		                        </div>
		                        <div class="col-md-6">
		                            <div class="input-group">
		                                <input type="text" class="datepicker form-control" name="birthdate" value="{{date('d-M-Y', strtotime($detail['birthdate']))}}" required autocomplete="off" @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) readonly @endif>
		                                <span class="input-group-btn">
		                                    <button class="btn default" type="button">
		                                        <i class="fa fa-calendar"></i>
		                                    </button>
		                                </span>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Religion <span class="required" aria-required="true"> * </span>
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <input type="text" placeholder="Religion" class="form-control" name="religion" value="{{ $detail['religion']}}" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) readonly @endif>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Height
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <input type="text" placeholder="Height" class="form-control" name="height" value="{{ (int)$detail['height']}}" @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) readonly @endif>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Weight
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <input type="text" placeholder="Weight" class="form-control" name="weight" value="{{ (int)$detail['weight']}}" @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) readonly @endif>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Recent Job
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <input type="text" placeholder="Recent Job" class="form-control" name="recent_job" value="{{ $detail['recent_job']}}" @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) readonly @endif>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Recent Company
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <input type="text" placeholder="Recent company" class="form-control" name="recent_company" value="{{ $detail['recent_company']}}" @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) readonly @endif>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Blood Type <span class="required" aria-required="true"> * </span>
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <select  class="form-control select2" name="blood_type" data-placeholder="Select blood type" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) disabled @endif>
		                                    <option></option>
		                                    <option value="A" @if($detail['blood_type'] == 'A') selected @endif>A</option>
		                                    <option value="B" @if($detail['blood_type'] == 'B') selected @endif>B</option>
		                                    <option value="AB" @if($detail['blood_type'] == 'AB') selected @endif>AB</option>
		                                    <option value="O" @if($detail['blood_type'] == 'O') selected @endif>O</option>
		                                </select>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Recent Address <span class="required" aria-required="true"> * </span>
		                        </label>
		                        <div class="col-md-6">
		                            <textarea type="text" name="recent_address" placeholder="Input recent address here" class="form-control" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) disabled @endif>{{$detail['recent_address']}}</textarea>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Postal Code <span class="required" aria-required="true"> * </span>
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <input type="text" placeholder="Postal Code" class="form-control" name="postal_code" value="{{ $detail['postal_code']}}" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) readonly @endif>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Marital Status <span class="required" aria-required="true"> * </span>
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <select  class="form-control select2" name="marital_status" data-placeholder="Select marital status" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) disabled @endif>
		                                    <option></option>
		                                    <option value="Single" @if($detail['marital_status'] == 'Single') selected @endif>Single</option>
		                                    <option value="Married" @if($detail['marital_status'] == 'Married') selected @endif>Married</option>
		                                    <option value="Widowed" @if($detail['marital_status'] == 'Widowed') selected @endif>Widowed</option>
		                                    <option value="Divorced" @if($detail['marital_status'] == 'Divorced') selected @endif>Divorced</option>
		                                </select>
		                            </div>
		                        </div>
		                    </div>

							@if($detail['user_hair_stylist_status'] == 'Training Completed')
								<div class="form-group">
									<label  class="control-label col-md-4">Auto Generate Password <span class="required" aria-required="true">*</span>
										<i class="fa fa-question-circle tooltips" data-original-title="Jika di centang maka password akan di generate otomatis oleh sistem" data-container="body"></i>
									</label>
									<div class="col-md-6">
										<label class="mt-checkbox mt-checkbox-outline">
											<input type="checkbox" name="auto_generate_pin" id="auto_generate_pin" class="same checkbox-product-price" onclick="changeAutoGeneratePin()"/>
											<span></span>
										</label>
									</div>
								</div>
								<div id="div_password">
									<div class="form-group">
										<label for="example-search-input" class="control-label col-md-4">Password <span class="required" aria-required="true">*</span>
											<i class="fa fa-question-circle tooltips" data-original-title="Masukkan password yang akan digunakan untuk login" data-container="body"></i>
										</label>
										<div class="col-md-6">
											<input class="form-control" maxlength="6" type="password" name="pin" id="pin1" value="{{old('pin')}}" placeholder="Enter password" required/>
										</div>
									</div>
									<div class="form-group">
										<label for="example-search-input" class="control-label col-md-4">Re-type Password <span class="required" aria-required="true">*</span>
											<i class="fa fa-question-circle tooltips" data-original-title="Ketik ulang password yang akan digunakan untuk login" data-container="body"></i>
										</label>
										<div class="col-md-6">
											<input class="form-control" maxlength="6" type="password" name="pin2" id="pin2" value="{{old('pin2')}}"placeholder="Re-type password" required/>
										</div>
									</div>
								</div>
							@endif

		                    <div class="form-group">
		                        <label class="col-md-4 control-label">Assign Outlet <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Penempatan outlet untuk hair stylist" data-container="body"></i>
		                        </label>
		                        <div class="col-md-6">
		                            <div class="input-icon right">
		                                <select  class="form-control select2" name="id_outlet" data-placeholder="Select outlet" @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive','Training Completed'])) disabled @endif>
		                                    <option></option>
		                                    @foreach($outlets as $outlet)
		                                        <option value="{{$outlet['id_outlet']}}" @if($outlet['id_outlet'] == $detail['id_outlet']) selected @endif>{{$outlet['outlet_code']}} - {{$outlet['outlet_name']}}</option>
		                                    @endforeach
		                                </select>
		                            </div>
		                        </div>
		                    </div>
		                </div>
						@if(!empty($detail['documents']))
							<br>
							<div style="text-align: center"><h4>Documents</h4></div>
							<div class="form-group">
								<div class="col-md-12">
									<table class="table table-striped table-bordered table-hover">
										<thead>
										<tr>
											<th scope="col" width="10%"> Attachment </th>
											<th scope="col" width="10%"> Document Type </th>
											<th scope="col" width="10%"> Process Date </th>
											<th scope="col" width="10%"> Name </th>
											<th scope="col" width="10%"> Notes </th>
											<th scope="col" width="10%"> Upload Date </th>
										</tr>
										</thead>
										<tbody>
										@foreach($detail['documents'] as $doc)
											<tr>
												<td style="text-align: center">
													@if(!empty($doc['attachment']))
														<a class="btn blue btn-xs" href="{{url('recruitment/hair-stylist/detail/download-file', $doc['id_user_hair_stylist_document'])}}"><i class="fa fa-download"></i></a>
													@endif
												</td>
												<td>{{$doc['document_type']}}</td>
												<td>{{date('d F M H:i', strtotime($doc['process_date']))}}</td>
												<td>{{$doc['process_name_by']}}</td>
												<td><p>{{$doc['process_notes']}}</p></td>
												<td>{{date('d F M H:i', strtotime($doc['created_at']))}}</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							</div>
						@endif

						@include('recruitment::hair_stylist.form_document')

                        <input type="hidden" name="action_type" id="action_type" value="">
		                @if(MyHelper::hasAccess([349], $grantedFeature) && $detail['user_hair_stylist_status'] != 'Rejected')
		                {{ csrf_field() }}
		                <div class="row" style="text-align: center">
		                    @if(in_array($detail['user_hair_stylist_status'], ['Candidate', 'Interviewed', 'Technical Tested', 'Training Completed']))
                                <a class="btn red save" data-name="{{ $detail['fullname'] }}" data-status="reject">Reject</a>
								@if($detail['user_hair_stylist_status'] == 'Candidate')
									<a class="btn blue save" data-name="{{ $detail['fullname'] }}" data-status="Interviewed">Submit</a>
								@elseif($detail['user_hair_stylist_status'] == 'Interviewed')
									<a class="btn blue save" data-name="{{ $detail['fullname'] }}" data-status="Technical Tested">Submit</a>
								@elseif($detail['user_hair_stylist_status'] == 'Technical Tested')
									<a class="btn blue save" data-name="{{ $detail['fullname'] }}" data-status="Training Completed">Submit</a>
								@else
									<a class="btn green-jungle approve-candidate" data-name="{{ $detail['fullname'] }}">Approve</a>
								@endif
		                    @else
		                        <button type="submit" class="btn blue">Update</button>
		                    @endif
		                </div>
		                @endif
		            </form>
		        </div>	
		        @if($detail['user_hair_stylist_status'] == 'Active')
			        <div class="tab-pane" id="hs-schedule">
			        	@yield('detail-schedule')
			        </div>
		        @endif
        	</div>
	    </div>
    </div>

@endsection