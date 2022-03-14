<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$step_approve = $step_approve??0;
$allTotalScore = 0;
$allMinScore = 0;
$totalTheories = 0;
?>
@extends('layouts.main-closed')
@include('recruitment::hair_stylist.detail_schedule')
@include('recruitment::hair_stylist.detail_box')

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
    @yield('detail-box-style')
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
                    $(".save").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let name    = $(this).data('name');
						let status    = $(this).data('status');
						let form    = $(this).data('form');
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
                                    $('#action_type_'+form).val(status);
                                    $('form#form_'+form).submit();
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

		$('.numeric').on('input', function (event) {
			this.value = this.value.replace(/[^0-9]/g, '');
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
		
		function submitScore() {
			$("#list_data_training").hide();
			$("#form_data_training").show();
		}

		function backToListTraining() {
			$("#list_data_training").show();
			$("#form_data_training").hide();
		}

		var prev_id_theory = '';
		function changeCategoryTheory(value) {
			$("#cat_"+value).show();
			if(prev_id_theory !== ''){
				$("#cat_"+prev_id_theory).hide();
			}
			prev_id_theory = value;
			conclusionScore(value);
			validationConclusion(value);
		}
		
		function nextStepFromTrainingResult(id) {
			var token  	= "{{ csrf_token() }}";
			swal({
				title: 'Are you sure want to next step "Approve"?',
				text: "Your will not be able to recover this data!",
				type: "info",
				showCancelButton: true,
				confirmButtonClass: "btn-info",
				confirmButtonText: "Yes, to next step!",
				closeOnConfirm: false
			},
			function(){
				$.ajax({
					type : "POST",
					url : "{{ url('recruitment/hair-stylist/update-status') }}",
					data : "_token="+token+"&id_user_hair_stylist="+id+"&user_hair_stylist_status=Training Completed",
					success : function(result) {
						if (result.status == "success") {
							swal({
								title: 'Updated!',
								text: "Success updated status.",
								type: "success",
								showCancelButton: false,
								showConfirmButton: false
							});
							SweetAlert.init()
							location.href = "{{url('recruitment/hair-stylist/candidate/detail')}}"+"/"+id+"?step_approve=1";
						}
						else {
							toastr.warning(result.messages);
						}
					}
				});
			});
		}
		
		function conclusionScore(id) {
			var total = 0;
			var j = 0;
			var disable_status = 0;
			$('#conclusion_score_'+id).val('');
			$('.score_theory_'+id).each(function(i, obj) {
				j++;
				var score_id = obj.id;
				var value = $('#'+score_id).val();
				var split = score_id.split('_');
				var id_theory = split[1];
				var minimum = $('#minimum_score_'+id_theory).val();
				$('#error_text_'+id_theory).hide();

				if(parseInt(value) < parseInt(minimum)){
					$('#passed_status_'+id_theory).val('Not Passed').trigger("change");
				}else{
					$('#passed_status_'+id_theory).val('Passed').trigger("change");
				}

				if(value > 100){
					disable_status = 1;
					$('#error_text_'+id_theory).show();
				}
				if(value){
					total = total + parseInt(value);
				}
			});

			var average = parseInt(total/j);
			$('#conclusion_score_'+id).val(average);

			var total_minimum_score = $('#conclusion_minimum_score_'+id).val();
			if(average < total_minimum_score){
				$('#conclusion_status_'+id).val('Not Passed').trigger("change");
			}else{
				$('#conclusion_status_'+id).val('Passed').trigger("change");
			}

			if(disable_status == 1){
				$("#btn_submit_traning").attr("disabled", true);
			}else{
				$("#btn_submit_traning").attr("disabled", false);
			}

			validationConclusion(id, 1);
		}
		
		function validationConclusion(id, not_check = 0) {
			var score = $('#conclusion_score_'+id).val();
			if(score > 100){
				$('#conclusion_error_text_'+id).show();
				$("#btn_submit_traning").attr("disabled", true);
			}else{
				$('#conclusion_error_text_'+id).hide();
				$("#btn_submit_traning").attr("disabled", false);
			}

			if(not_check == 0){
				var total_minimum_score = $('#conclusion_minimum_score_'+id).val();
				if(parseInt(score) < parseInt(total_minimum_score)){
					$('#conclusion_status_'+id).val('Not Passed').trigger("change");
				}else{
					$('#conclusion_status_'+id).val('Passed').trigger("change");
				}
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
                <li @if($step_approve == 0) class="active" @endif>
                    <a href="#hs-info" data-toggle="tab"> Info </a>
                </li>
				@if(!in_array($detail['user_hair_stylist_status'], ['Active', 'Inactive', 'Rejected']))
				<li @if($step_approve == 1) class="active" @endif>
					<a href="#candidate-status" data-toggle="tab"> Candidate Status </a>
				</li>
				@endif
                @if($detail['user_hair_stylist_status'] == 'Active')
					<li>
						<a href="#hs-change-outlet" data-toggle="tab"> Move Outlet </a>
					</li>
	                <li>
	                    <a href="#hs-schedule" data-toggle="tab"> Schedule </a>
	                </li>
	                <li>
	                    <a href="#hs-box" data-toggle="tab"> Box </a>
	                </li>
                @endif
            </ul>
        </div>

		<div class="tab-content">
			<div class="tab-pane @if($step_approve == 0) active @endif form" id="hs-info">
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
						<div class="form-group">
							<label class="col-md-4 control-label">Passed Status</label>
							<div class="col-md-6" style="margin-top: 0.7%">{{$detail['user_hair_stylist_passed_status']}}</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Score</label>
							<div class="col-md-6" style="margin-top: 0.7%">{{$detail['user_hair_stylist_score']}}</div>
						</div>
						@if($detail['user_hair_stylist_status'] == 'Active' || $detail['user_hair_stylist_status'] == 'Inactive')
							<div class="form-group">
								<label class="col-md-4 control-label">Approve By</label>
								<div class="col-md-6" style="margin-top: 0.7%">{{$detail['approve_by_name']}}</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label">Join Date</label>
								<div class="col-md-6" style="margin-top: 0.7%">{{date('d M Y H:i', strtotime($detail['join_date']))}}</div>
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
							<label class="col-md-4 control-label">NIK</label>
							<div class="col-md-6" style="margin-top: 0.7%"><b>{{$detail['user_hair_stylist_code']}}</b></div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Nickname <span class="required" aria-required="true"> * </span>
							</label>
							<div class="col-md-6">
								<div class="input-icon right">
									<input type="text" placeholder="Nickname" class="form-control" name="nickname" value="{{ $detail['nickname']}}" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Category <span class="required" aria-required="true"> * </span>
							</label>
							<div class="col-md-6">
								<div class="input-icon right">
									<select  class="form-control select2" name="id_hairstylist_category" data-placeholder="Select Category" required>
										<option></option>
										@foreach($hairstylist_category??[] as $category)
											<option value="{{$category['id_hairstylist_category']}}" @if($detail['id_hairstylist_category'] == $category['id_hairstylist_category']) selected @endif>{{$category['hairstylist_category_name']}}</option>
										@endforeach
									</select>
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

						@if(in_array($detail['user_hair_stylist_status'], ['Active','Inactive']))
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
										<input class="form-control" maxlength="6" type="password" name="pin" id="pin1" value="{{old('pin')}}" placeholder="Enter password" @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) required @endif/>
									</div>
								</div>
								<div class="form-group">
									<label for="example-search-input" class="control-label col-md-4">Re-type Password <span class="required" aria-required="true">*</span>
										<i class="fa fa-question-circle tooltips" data-original-title="Ketik ulang password yang akan digunakan untuk login" data-container="body"></i>
									</label>
									<div class="col-md-6">
										<input class="form-control" maxlength="6" type="password" name="pin2" id="pin2" value="{{old('pin2')}}"placeholder="Re-type password" @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) required @endif/>
									</div>
								</div>
							</div>
						@endif

						<div class="form-group">
							<label class="col-md-4 control-label">Assign Outlet</label>
							<div class="col-md-6">
								<div class="input-icon right">
									<select  class="form-control select2" name="id_outlet" data-placeholder="Select outlet" disabled>
										<option></option>
										@foreach($outlets as $outlet)
											<option value="{{$outlet['id_outlet']}}" @if($outlet['id_outlet'] == $detail['id_outlet']) selected @endif>{{$outlet['outlet_code']}} - {{$outlet['outlet_name']}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
                        <div class="form-group">
                                <label class="col-md-4 control-label">Group<span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Group hair stylist" data-container="body"></i>
                                </label>
                                <div class="col-md-6">
                                        <div class="input-icon right">
                                                <select  class="form-control select2" name="id_hairstylist_group" data-placeholder="Select Group" required>
                                                        <option></option>
                                                        @foreach($groups as $group)
                                                                <option value="{{$group['id_hairstylist_group']}}" @if($group['id_hairstylist_group'] == $detail['id_hairstylist_group']) selected @endif>{{$group['hair_stylist_group_code']}} - {{$group['hair_stylist_group_name']}}</option>
                                                        @endforeach
                                                </select>
                                        </div>
                                </div>
                        </div>
                        @if(!empty($detail['experiences']))
                        <div class="form-group">
							<label class="col-md-7 control-label" style="font-size: 18px; font-weight: bold; !important;">Work Experience</label>
						</div>
                            @foreach ($detail['experiences'] as $e => $experience)
                            @if ($e!=0)
                            <div class="row" style="margin-bottom: 15px">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-8">
                                    <hr style="border-top: 1px dashed;">
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="col-md-4 control-label">Barber / Salon Name
                                </label>
                                <div class="col-md-6">
                                    <div class="input-icon right">
                                        <input type="text" placeholder="Barber / Salon Name" class="form-control" value="{{ $experience['salon_name']}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Position
                                </label>
                                <div class="col-md-6">
                                    <div class="input-icon right">
                                        <input type="text" placeholder="Position" class="form-control" value="{{ $experience['position']}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Work Period
                                </label>
                                <div class="col-md-6">
                                    <div class="input-icon right">
                                        <input type="text" placeholder="Period" class="form-control" value="{{ $experience['period']}}" readonly>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
					</div>

					@if(!empty($detail['documents']))
						<br>
						<div style="text-align: center"><h4>Document Hair Stylist</h4></div>
						<div class="form-group">
							<div class="col-md-12">
								<table class="table table-striped table-bordered table-hover">
									<thead>
									<tr>
										<th scope="col" width="10%"> Action </th>
										<th scope="col" width="10%"> Process Type </th>
										<th scope="col" width="10%"> Process Date </th>
										<th scope="col" width="10%"> Name </th>
										<th scope="col" width="10%"> Notes </th>
										<th scope="col" width="10%"> Save Date </th>
									</tr>
									</thead>
									<tbody>
									@foreach($detail['documents'] as $doc)
										<?php
											if($doc['document_type'] == 'Training Completed'){
												$dataDoc[$doc['document_type']][] = $doc;
												$detailTheories = [];
												foreach ($doc['theories'] as $theory){
													$detailTheories[$theory['category_title']][] = $theory;
													$allTotalScore = $allTotalScore + $theory['score'];
													$allMinScore = $allMinScore + $theory['minimum_score'];
													$totalTheories++;
												}
											}else{
												$dataDoc[$doc['document_type']] = $doc;
											}
										?>
										<tr>
											<td>
												@if(!empty($doc['attachment']))
													<a class="btn blue" href="{{url('recruitment/hair-stylist/detail/download-file', $doc['id_user_hair_stylist_document'])}}">Attachment</a>
												@endif
												@if($doc['document_type'] == 'Training Completed' && !empty($detailTheories))
													<a data-toggle="modal" href="#detail_{{$doc['id_user_hair_stylist_document']}}" class="btn green-jungle">Score</a>
													<div id="detail_{{$doc['id_user_hair_stylist_document']}}" class="modal fade bs-modal-lg" tabindex="-1" aria-hidden="true">
														<div class="modal-dialog modal-lg">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">Detail Score</h4>
																</div>
																<div class="modal-body" style="margin-top: -4%">
																	<?php
																	$totalScore = 0;
																	$minScore = 0;
																	$detailTotalTheory = 0;
																	?>
																	@foreach($detailTheories as $keyT=>$t)
																		<div class="row">
																			<div class="col-md-12">
																				<p><b>{{$keyT}}</b></p>
																			</div>
																		</div>
																		@foreach($t as $data)
																			<?php
																				$totalScore = $totalScore + $data['score'];
																				$minScore = $minScore + $data['minimum_score'];
																				$detailTotalTheory++;
																			?>
																			<div class="row">
																				<div class="col-md-7" style="margin-top: -2%;">
																					<p>{{$data['theory_title']}}</p>
																				</div>
																				<div class="col-md-3">
																					<div class="input-group">
																						<input type="text" class="form-control" value="{{$data['score']}}" disabled>
																						<span class="input-group-addon">minimal {{$data['minimum_score']}}</span>
																					</div>
																				</div>
																				<div class="col-md-2">
																					<input type="text" class="form-control" value="{{$data['passed_status']}}" disabled>
																				</div>
																			</div>
																		@endforeach
																	@endforeach
																	<br>
																	<hr style="border-top: 1px solid black;">
																	<div class="row">
																		<div class="col-md-7" style="margin-top: 0.7%"><b>Conclusion Score</b></div>
																		<div class="col-md-3">
																			<div class="input-group">
																				<input type="text" class="form-control" value="{{(int)($totalScore/$detailTotalTheory)}}" disabled>
																				<span class="input-group-addon">minimal {{(int)($minScore/$detailTotalTheory)}}</span>
																			</div>
																		</div>
																		<div class="col-md-2">
																			<input type="text" class="form-control" value="{{$doc['conclusion_status']}}" disabled>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												@endif
											</td>
											<td>{{$doc['document_type']}}</td>
											<td>{{(!empty($doc['process_date']) ? date('d F Y H:i', strtotime($doc['process_date'])): '')}}</td>
											<td>{{$doc['process_name_by']}}</td>
											<td><p>{{$doc['process_notes']}}</p></td>
											<td>{{date('d F Y H:i', strtotime($doc['created_at']))}}</td>
										</tr>
									@endforeach
									</tbody>
								</table>
							</div>
						</div>
					@endif

					@if(MyHelper::hasAccess([349], $grantedFeature) && $detail['user_hair_stylist_status'] != 'Rejected')
						{{ csrf_field() }}
						<div class="row" style="text-align: center">
							@if(!in_array($detail['user_hair_stylist_status'], ['Candidate', 'Interviewed', 'Technical Tested', 'Training Completed']))
								<button type="submit" class="btn blue">Update</button>
							@endif
						</div>
					@endif
				</form>
			</div>
			@if(!in_array($detail['user_hair_stylist_status'], ['Active', 'Inactive', 'Rejected']))
			<div class="tab-pane @if($step_approve == 1) active @endif" id="candidate-status">
				<br>
				<br>
				<div class="row">
					<div class="col-md-3">
						<ul class="ver-inline-menu tabbable margin-bottom-10">
							<li @if($detail['user_hair_stylist_status'] == 'Candidate') class="active" @endif>
								<a @if(in_array($detail['user_hair_stylist_status'], ['Candidate', 'Interviewed', 'Psychological Tested', 'Technical Tested', 'Training Completed'])) data-toggle="tab" href="#interview" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Interview </a>
							</li>
							<li @if($detail['user_hair_stylist_status'] == 'Interviewed') class="active" @endif>
								<a  @if(in_array($detail['user_hair_stylist_status'], ['Interviewed', 'Psychological Tested', 'Technical Tested', 'Training Completed'])) data-toggle="tab" href="#psychological_test" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Psychological Test </a>
							</li>
							<li @if($detail['user_hair_stylist_status'] == 'Psychological Tested') class="active" @endif>
								<a  @if(in_array($detail['user_hair_stylist_status'], ['Psychological Tested', 'Technical Tested', 'Training Completed'])) data-toggle="tab" href="#technical_test" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Technical Test </a>
							</li>
							<li @if($detail['user_hair_stylist_status'] == 'Technical Tested') class="active" @endif>
								<a @if(in_array($detail['user_hair_stylist_status'], ['Technical Tested', 'Training Completed'])) data-toggle="tab"  href="#training_result" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Training Result</a>
							</li>
							<li @if($detail['user_hair_stylist_status'] == 'Training Completed') class="active" @endif>
								<a @if(in_array($detail['user_hair_stylist_status'], ['Training Completed']))  data-toggle="tab"  href="#approve" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Approve </a>
							</li>
						</ul>
					</div>
					<div class="col-md-9">
						<div class="tab-content">
							<div class="tab-pane @if($detail['user_hair_stylist_status'] == 'Candidate') active @endif" id="interview">
								@include('recruitment::hair_stylist.form_document_interview')
							</div>
							<div class="tab-pane @if($detail['user_hair_stylist_status'] == 'Interviewed') active @endif" id="psychological_test">
								@include('recruitment::hair_stylist.form_document_psychological')
							</div>
							<div class="tab-pane @if($detail['user_hair_stylist_status'] == 'Psychological Tested') active @endif" id="technical_test">
								@include('recruitment::hair_stylist.form_document_technical')
							</div>
							<div class="tab-pane @if($detail['user_hair_stylist_status'] == 'Technical Tested') active @endif" id="training_result">
								@include('recruitment::hair_stylist.form_document_training')
							</div>
							<div class="tab-pane @if($detail['user_hair_stylist_status'] == 'Training Completed') active @endif" id="approve">
								@include('recruitment::hair_stylist.form_approve')
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif
			@if($detail['user_hair_stylist_status'] == 'Active')
				<div class="tab-pane" id="hs-change-outlet">
					@include('recruitment::hair_stylist.move_outlet')
				</div>
				<div class="tab-pane" id="hs-schedule">
					@yield('detail-schedule')
				</div>
				<div class="tab-pane form" id="hs-box">
					@yield('detail-box')
				</div>
			@endif
		</div>
    </div>

@endsection