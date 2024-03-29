<?php
    use App\Lib\MyHelper;
    $configs = session('configs');
 ?>
@extends('layouts.main')
@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
    	.datepicker{
			padding: 6px 12px;
		}
		.border-0 {
			/*border: 0px;*/
		}
		.text-bold {
			font-weight: bold;
		}
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function() {

	        $('.datepicker').datepicker({
	            'format' : 'dd MM yyyy',
	            'todayHighlight' : true,
	            'autoclose' : true
	        });

	        $('.timepicker').timepicker({
	            autoclose: true,
	            minuteStep: 1,
	            showSeconds: false
	        }).on('changeTime.timepicker', function(e) {
				var h= e.time.hours;

				if(h < parseInt("{{date('G', strtotime($data['setting_time_start']))}}")){
					$('.timepicker').val("{{date('G:i', strtotime($data['setting_time_start']))}}");
				}else if(h > parseInt("{{date('G', strtotime($data['setting_time_end']))}}")){
					$('.timepicker').val("{{date('G:i', strtotime($data['setting_time_end']))}}");
				}else{
					availableHS();
				}
			});

	        $('#reject-transaction').on('shown.bs.modal', function (e) {
	        	$('#reject-transaction').css("z-index", "10056");
			})

	        $('.select2').select2();

			availableHS();
        });
		
		function availableHS() {
			let token  = "{{ csrf_token() }}";
			var id_user_hair_stylist = "{{ $data['id_user_hair_stylist'] }}";
			var name = "{{ $data['hair_stylist_name'] }}";
			var date = $('#schedule_date').val();
			var time = $('#schedule_time').val();
			var hs_date = "{{date('d F Y', strtotime($data['booking_date']))}}";
			var hs_time = "{{date('H:i', strtotime($data['booking_time']))}}";

			$.ajax({
				type : "POST",
				url : "{{ url('transaction/home-service/manage/find-hs') }}",
				data : {
					"_token" : token,
					"id_trx": "{{ $data['id_transaction'] }}",
					"schedule_date" : $('#schedule_date').val(),
					"schedule_time" : $('#schedule_time').val()
				},
				success : function(result) {
					$('#select-hs').empty();
					var html = '<option value="" selected="selected" disabled>Select Hair Stylist</option>';
					if(result.length > 0){
						var res = result;
						if(date == hs_date && time == hs_time){
							html += '<option value="'+id_user_hair_stylist+'" selected>'+name+'</option>';
						}

						for(var i = 0;i<res.length;i++){
							html += '<option value="'+res[i].id_user_hair_stylist+'">'+res[i].nickname+' - '+res[i].fullname+'</option>';
						}
						$("#select-hs").append(html);
					}
				}
			});
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

    @include('layouts.notifications')

    @php $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; @endphp
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">{{ $title }}</span>
            </div>
            <div class="text-left">
            	@if (!empty($data['reject_at']))
            		<span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A; padding: 5px 12px; color: #fff; margin-top: 7px;margin-left: 10px">{{ 'Rejected' }}</span>
            	@endif
            </div>
        </div>
        <div class="tabbable-line tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#detail" data-toggle="tab"> Detail </a>
                </li>
                <li>
                    <a href="#update" data-toggle="tab"> Update </a>
                </li>
            </ul>
	        <div class="tab-content">
	        	<div class="tab-pane active" id="detail">
					@if (!empty($data['product_service']))
		            	<div class="portlet light bordered">
							<div class="portlet-title">
								<div class="caption font-blue ">
									<span class="caption-subject sbold uppercase">Home Service</span>
								</div>
							</div>
							@php
								$statusHS = [
									'Finding Hair Stylist' => [
										'color' => 'grey',
										'status' => 'Transaction waiting to finding hair stylist'
									],
									'Get Hair Stylist' => [
										'color' => 'yellow',
										'status' => 'Customer already get a hair stylist'
									],
									'On The Way' => [
										'color' => 'yellow',
										'status' => 'Hair stylist is his the way to the customer'
									],
									'Arrived' => [
										'color' => 'yellow',
										'status' => 'Hair stylist has arrived at the customer location'
									],
									'Start Service' => [
										'color' => 'blue',
										'status' => 'Service has started'
									],
									'Completed' => [
										'color' => 'green',
										'status' => 'Service has been completed'
									],
									'Cancelled' => [
										'color' => 'red',
										'status' => 'Service canceled'
									],
								];
							@endphp
							<div class="portlet box {{ $statusHS[$data['hair_stylist_status']]['color'] }}">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-gear"></i>Status Transaction Home Service</div>
									<div class="tools">
										<a href="javascript:;" class="collapse"> </a>
									</div>
								</div>
								<div class="portlet-body">
									<h5> {{ $statusHS[$data['hair_stylist_status']]['status'] }} </h5>
								</div>
							</div>
							<div class="portlet-body form">
				                <div class="form-horizontal" role="form" action="{{url('businessdev/partners/update')}}" method="post" enctype="multipart/form-data">
				            		@foreach ($data['product_service'] as $key => $s)
										<div class="portlet light bordered">
											<div class="portlet-title">
												<div class="caption font-blue ">
													<span class="caption-subject sbold uppercase">Service {{ $key+1 }}</span>
												</div>
											</div>
											<div class="portlet-body form">
								                <div class="form-horizontal" role="form" action="{{url('businessdev/partners/update')}}" method="post" enctype="multipart/form-data">
								                    <div class="form-body">
														<div div class="form-group">
															<label class="control-label col-md-4">Status </label>
															 <div class="col-md-5">
																 @php
																	 $serviceStatus = 'Pending';
																	 $statusColor = '#c9c9c7';
 
																	 if(isset($data['hair_stylist_status']) && $data['hair_stylist_status'] == 'Start Service'){
																		 $serviceStatus = 'In Progress';
																		 $statusColor = '#ffc107';
																	 }
																	 if ($s['transaction_product_completed_at']) {
																		 $serviceStatus =  'Completed';
																		 $statusColor = '#26C281';
																	 } 
																	 if ($s['reject_at']) {
																		 $serviceStatus =  'Rejected';
																		 $statusColor = '#E7505A';
																	 }
																 @endphp
																 <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: {{ $statusColor }}; padding: 5px 12px; color: #fff; margin-top: 5px">{{ $serviceStatus }}</span>
															 </div>
														 </div>
														 <div class="form-group">
															 <label class="control-label col-md-4">Hair Stylist </label>
															 <div class="col-md-5">
																 <span class="form-control border-0 text-bold">{{ $data['hair_stylist_name'] }}</span>
															 </div>
														 </div>
														 <div class="form-group">
							                                <label class="control-label col-md-4">Schedule Date </label>
							                                <div class="col-md-5">
											                    <span class="form-control border-0 text-bold">{{ $data['booking_date'] }}</span>
							                                </div>
							                            </div>

							                            <div class="form-group">
							                                <label class="control-label col-md-4">Schedule Time </label>
							                                <div class="col-md-5">
											                    <span class="form-control border-0 text-bold">{{ $data['booking_time'] }} {{ $data['booking_time_zone'] }}</span>
							                                </div>
							                            </div>

							                            <div class="form-group">
							                                <label class="control-label col-md-4">Service Name </label>
							                                <div class="col-md-5">
											                    <span class="form-control border-0 text-bold">{{ $s['product']['product_name'] }}</span>
							                                </div>
							                            </div>

							                            <div class="form-group">
							                                <label class="control-label col-md-4">Subtotal </label>
							                                <div class="col-md-5">
											                    <span class="form-control border-0 text-bold">IDR {{ number_format(($s['transaction_product_subtotal']),0,',','.') }}</span>
							                                </div>
							                            </div>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					@endif
	        	</div>
	        	<div class="tab-pane" id="update">
                	<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue ">
								<span class="caption-subject sbold uppercase">Update Transaction {{ $data['transaction_receipt_number'] }}</span>
							</div>
						</div>
	                    <div class="portlet-body form">
	                        <form class="form-horizontal" role="form" action="#" method="post" enctype="multipart/form-data">
	                            <div class="form-body">
		                            <div id="update-service-section">
											<div class="form-group">
												<label for="example-search-input" class="control-label col-md-4">Preference Hairstylist</label>
												<div class="col-md-5">
													<input name="note" class="form-control" value="{{($data['preference_hair_stylist'] == 'All' ? 'Random':$data['preference_hair_stylist'])}}" disabled>
												</div>
											</div>
											<div class="form-group">
			                                <label for="example-search-input" class="control-label col-md-4">Schedule Date <span class="required" aria-required="true">*</span>
			                                	<i class="fa fa-question-circle tooltips" data-original-title="Tanggal layanan dapat dimulai" data-container="body"></i></label>
			                                <div class="col-md-5">
			                                    <div class="input-group">
			                                    	@php
			                                    		$bookDate = $data['booking_date'] ? date('d F Y', strtotime($data['booking_date'])) : null;
			                                    	@endphp
			                                        <input type="text" class="datepicker form-control update-service-input" name="schedule_date" value="{{ $bookDate }}" onchange="availableHS()" autocomplete="off" id="schedule_date">
			                                        <span class="input-group-btn">
			                                            <button class="btn default" type="button">
			                                                <i class="fa fa-calendar"></i>
			                                            </button>
			                                        </span>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="form-group">
			                                <label for="example-search-input" class="control-label col-md-4">Schedule Time <span class="required" aria-required="true">*</span>
			                                	<i class="fa fa-question-circle tooltips" data-original-title="Waktu layanan dapat dimulai dari {{date('H:i', strtotime($data['setting_time_start']))}} sampai {{date('H:i', strtotime($data['setting_time_end']))}}" data-container="body"></i></label>
			                                <div class="col-md-2">
						                    	<input type="text" data-placeholder="select time end" class="form-control mt-repeater-input-inline kelas-close timepicker timepicker-no-seconds update-service-input" name="schedule_time" id="schedule_time" data-show-meridian="false" readonly value="{{ $data['booking_time'] ?? null }}">
			                                </div>
			                            </div>
			                            <div class="form-group">
		                                    <label for="example-search-input" class="control-label col-md-4">Hair Stylist <span class="required" aria-required="true">*</span>
		                                    	<i class="fa fa-question-circle tooltips" data-original-title="Pilih Hair Stylist yang akan melakukan layanan" data-container="body"></i></label>
		                                    <div class="col-md-5">
		                                        <select class="form-control select2 update-service-input" name="id_user_hair_stylist" id="select-hs" style="width: 100%">
		                                        </select>
		                                    </div>
		                                </div>
		                                <div class="form-group">
			                                <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
			                                    <i class="fa fa-question-circle tooltips" data-original-title="Catatan kenapa melakukan perubahan data" data-container="body"></i></label>
			                                <div class="col-md-5">
			                                    <textarea name="note" class="form-control update-service-input" placeholder="Enter note here" required></textarea>
			                                </div>
			                            </div>
			                            @if (empty($data['reject_at']))
				                            <div class="form-actions">
				                                {{ csrf_field() }}
				                                <div class="row">
				                                    <div class="col-md-offset-4 col-md-8">
				                                    	<input type="hidden" name="id_transaction" value="{{ $data['id_transaction'] }}">
				                                        <button type="submit" class="btn blue" name='submit_type' value="update">Update</button>
				                                        <button type="submit" class="btn red" name='submit_type' value="reject">Reject</button>
				                                    </div>
				                                </div>
				                            </div>
			                            @endif
		                            </div>
	                            </div>
	                        </form>
	                    </div>
                    </div>
	            </div>
	        </div>
    	</div>
    </div>

    {{-- Reject Transaction Modal --}}
	<div id="reject-transaction" class="modal fade bs-modal-sm" tabindex="-1" aria-hidden="true">
	    <div class="modal-dialog modal-sm">
	        <div class="modal-content">
	        	<form role="form" action="{{ url('transaction/outlet-service/reject') }}" method="post" enctype="multipart/form-data">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	                    <h4 class="modal-title">Reject Transaction</h4>
	                </div>
	                <div class="modal-body" style="padding-top: 0;padding-bottom: 0">
	                	<div class="row">
		                	<div class="form-group">
		                		<label class="control-label"> Reason <span class="required" aria-required="true"> * </span> </label>
                        		<textarea name="reject_reason" class="form-control" placeholder="Enter reject reason here" required></textarea>
	                        </div>
	                	</div>
	                </div>
	                <div class="modal-footer">
	        			{{ csrf_field() }}
	                    <input type="hidden" name="id_transaction" value="{{ $data['id_transaction'] }}">
	                	<input type="hidden" name="update_type" value="transaction">
	                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancel</button>
	                    <button type="submit" class="btn red" name='submit_type' value="reject">Reject</button>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
@endsection