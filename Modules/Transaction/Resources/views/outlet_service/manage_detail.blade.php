<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
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
    <style>
        .datepicker{
            padding: 6px 12px;
           }
        .zoom-in {
			cursor: zoom-in;
            border: 1px solid;
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

    	function changeTriggerService() {
			$('#update-service-section').hide();
			$('.update-service-input').prop('required', false);
			let serviceObj = $('select[name=id_transaction_product_service] option:selected');
			let service = serviceObj.val();
			$('#schedule_date').val('');

			if (service != '') {
				let date = serviceObj.data('date') ?? null;
				let hs = serviceObj.data('hs') ?? null;
				let idTrxProduct = serviceObj.data('id_trx_product') ?? null;
				$('#update-service-section').show();

				$('#update-service-section [name="schedule_date"]').datepicker({dateFormat: "dd MM yyyy"});
				$('#update-service-section [name="schedule_date"]').datepicker("setDate", $.datepicker.parseDate( "yy-mm-dd", date ));

	        	$('#update-service-section select[name="id_user_hair_stylist"]').val(hs);

	        	$('#update-service-section [name="id_transaction_product"]').val(idTrxProduct);

				$('.update-service-input').prop('required', true);

	        	$('#update-service-section select[name="id_user_hair_stylist"]').prop('required', false);
				
				if(serviceObj.data('serviceStatus')){
					$('.service-reject').hide();
				}else{
					$('.service-reject').show();
				}
				
			}
		}

		function changeTriggerProduct() {
			$('#update-product-section').hide();
			$('.update-product-input').prop('required', false);
			let serviceObj = $('select[name=id_product] option:selected');
			let service = serviceObj.val();

			if (service != '') {
				let idTrxProduct = serviceObj.data('id_trx_product') ?? null;

				$('#update-product-section').show();

	        	$('#update-product-section [name="id_transaction_product"]').val(idTrxProduct);

				$('.update-product-input').prop('required', true);
			}
		}

        $(document).ready(function() {
        	changeTriggerService();
        	changeTriggerProduct();

	        $('.datepicker').datepicker({
	            'format' : 'dd MM yyyy',
	            'todayHighlight' : true,
	            'autoclose' : true
	        });

	        $('.timepicker').timepicker({
	            autoclose: true,
	            minuteStep: 1,
	            showSeconds: false,

	        });
	        $('.select2').select2();

        	$('#list-form').on('click', '.update-button', function() {
	        	let id = $(this).data('id') ?? null;
	        	let code = $(this).data('code') ?? null;
	        	let name = $(this).data('name') ?? null;
	        	let photo = $(this).data('photo') ?? null;
	        	let desc = $(this).data('desc') ?? null;
	        	$('#update [name="id_product_group"]').val(id);
	        	$('#update [name="product_group_code"]').val(code);
	        	$('#update [name="product_group_name"]').val(name);
	        	$('#edit-img').attr('src', photo);
	        	$('#update [name="photo"]').attr("src",photo);
	        	$('#update [name="product_group_description"]').val(desc);
	        })

        	$('select[name=id_transaction_product_service]').on('change', function() {
        		changeTriggerService();
	        })

	        $('select[name=id_product]').on('change', function() {
        		changeTriggerProduct();
	        })
        });

    	function availableHS() {
			let serviceObj = $('select[name=id_transaction_product_service] option:selected');
			let service = serviceObj.val();

			if (service != '') {
				var date = $('#schedule_date').val();
				var id_product = serviceObj.data('id_product') ?? null;
				var hs = serviceObj.data('hs') ?? null;
				var hs_date = serviceObj.data('datefull') ?? null;

				if(date !== ""){
					let token  = "{{ csrf_token() }}";

					$.ajax({
						type : "POST",
						url : "{{ url('transaction/outlet-service/manage/available-hs') }}",
						data : {
							"_token" : token,
							"id_outlet": "{{$data['outlet']['id_outlet']??null}}",
							"id_product" : id_product,
							"booking_date": date,
						},
						success : function(result) {
							$('#id_user_hair_stylist').empty();
							var html = '<option value="" selected="selected" disabled>Select Hair Stylist</option>';
							if(result.status == 'success' && result.result.length > 0){
								console.log(html);
								var res = result.result;
								for(var i = 0;i<res.length;i++){
									if(res[i].available_status === true) {
										html += '<option value="' + res[i].id_user_hair_stylist + '">' + res[i].nickname + ' - ' + res[i].name + '</option>';
									}else if(res[i].available_status === false && hs == res[i].id_user_hair_stylist && date == hs_date){
										html += '<option value="' + res[i].id_user_hair_stylist + '" selected>' + res[i].nickname + ' - ' + res[i].name + '</option>';
									}
								}
								$("#id_user_hair_stylist").append(html);
							}
							console.log(12);
						}
					});
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

    @include('layouts.notifications')

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
                @if (empty($data['reject_at']))
	                <li>
	                    <a href="#update" data-toggle="tab"> Update </a>
	                </li>
                @endif
            </ul>
	        <div class="tab-content">
	            <div class="tab-pane active" id="detail">
	            	@if (!empty($data['service']))
		            	<div class="portlet light bordered">
							<div class="portlet-title">
								<div class="caption font-blue ">
									<span class="caption-subject sbold uppercase">Service</span>
								</div>
							</div>
			                <div class="portlet-body form">
				                <div class="form-horizontal" role="form" action="{{url('businessdev/partners/update')}}" method="post" enctype="multipart/form-data">
									<?php
										$oneIsCompleted = 0;
									?>
				            		@foreach ($data['service'] as $s)
				            			<div class="portlet light bordered">
											<div class="portlet-title">
												<div class="caption font-blue ">
													<span class="caption-subject sbold uppercase">{{ $s['order_id'] }}</span>
												</div>
											</div>
							                <div class="portlet-body form">
								                <div class="form-horizontal" role="form" action="{{url('businessdev/partners/update')}}" method="post" enctype="multipart/form-data">
								                    <div class="form-body">
								                    	<div class="form-group">
							                                <label class="control-label col-md-4">Status </label>
							                                <div class="col-md-5">
							                                	@php
							                                		$serviceStatus = 'Pending';
																	$statusColor = '#c9c9c7';
																	if(isset($s['detail']['transaction_product_service']['service_status']) && $s['detail']['transaction_product_service']['service_status'] == 'In Progress'){
																		$serviceStatus = 'In Progress';
                                                                        $oneIsCompleted = 1;
																		$statusColor = '#ffc107';
																	}
																	if ($s['detail']['transaction_product_completed_at']) {
							                                			$serviceStatus =  'Completed';
																		$statusColor = '#26C281';
                                                                        $oneIsCompleted = 1;
																	} 
							                                		if ($s['detail']['reject_at']) {
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
											                    <span class="form-control border-0 text-bold">{{ $s['hairstylist_name'] }}</span>
							                                </div>
							                            </div>

							                            <div class="form-group">
							                                <label class="control-label col-md-4">Schedule Date </label>
							                                <div class="col-md-5">
											                    <span class="form-control border-0 text-bold">{{ $s['schedule_date'] }}</span>
							                                </div>
							                            </div>

							                            <div class="form-group">
							                                <label class="control-label col-md-4">Service Name </label>
							                                <div class="col-md-5">
											                    <span class="form-control border-0 text-bold">{{ $s['product_name'] }}</span>
							                                </div>
							                            </div>

							                            <div class="form-group">
							                                <label class="control-label col-md-4">Subtotal </label>
							                                <div class="col-md-5">
											                    <span class="form-control border-0 text-bold">{{ $s['subtotal'] }}</span>
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

	            	@if (!empty($data['product']))
		            	<div class="portlet light bordered">
							<div class="portlet-title">
								<div class="caption font-blue ">
									<span class="caption-subject sbold uppercase">Product</span>
								</div>
							</div>
			                <div class="portlet-body form">
				                <div class="form-horizontal" role="form" action="{{url('businessdev/partners/update')}}" method="post" enctype="multipart/form-data">
				            		@foreach ($data['product'] as $p)
					                    <div class="form-body">
					                    	<div class="form-group">
				                                <label class="control-label col-md-4">Status </label>
				                                <div class="col-md-5">
				                                	@php
				                                		$productStatus = $p['detail']['reject_at'] ? 'Rejected' : 'Active';
				                                		$statusColor = ($productStatus == 'Active') ? '#26C281' : '#E7505A';
				                                	@endphp
								                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: {{ $statusColor }}; padding: 5px 12px; color: #fff; margin-top: 5px">{{ $productStatus }}</span>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="example-search-input" class="control-label col-md-4">Product Name </label>
				                                <div class="col-md-5">
								                    <span class="form-control border-0 text-bold">{{ $p['product_name'] }}</span>
				                                </div>
				                            </div>
				                    		<div class="form-group">
				                                <label for="example-search-input" class="control-label col-md-4">Product Quantity </label>
				                                <div class="col-md-5">
								                    <span class="form-control border-0 text-bold">{{ $p['transaction_product_qty'] }}</span>
				                                </div>
				                            </div>

				                            <div class="form-group">
				                                <label for="example-search-input" class="control-label col-md-4">Product Price </label>
				                                <div class="col-md-5">
								                    <span class="form-control border-0 text-bold">{{ $p['transaction_product_price'] }}</span>
				                                </div>
				                            </div>

				                            <div class="form-group">
				                                <label for="example-search-input" class="control-label col-md-4">Subtotal </label>
				                                <div class="col-md-5">
								                    <span class="form-control border-0 text-bold">{{ $p['subtotal'] }}</span>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="example-search-input" class="control-label col-md-4">Photo </label>
				                                <div class="col-md-5">
						                    		<img src="{{ $p['photo'] }}" style="width: 100px">
				                                </div>
				                            </div>
					                    </div>
					                    <hr>
					            	@endforeach
					            </div>
				            </div>
		            	</div>
	            	@endif
	            </div>

	            <div class="tab-pane" id="update">
	            	@if (empty($data['need_manual_void']) && $oneIsCompleted == 0)
		            	<div class="text-right">
	        				<a data-toggle="modal" href="#reject-transaction" class="btn red" style="margin-bottom: 15px">Reject Transaction</a>
		            	</div>
	            	@endif

	            	@if (!empty($data['service']))
	                	<div class="portlet light bordered">
							<div class="portlet-title">
								<div class="caption font-blue ">
									<span class="caption-subject sbold uppercase">Service</span>
								</div>
							</div>
		                    <div class="portlet-body form">
		                        <form class="form-horizontal" role="form" action="#" method="post" enctype="multipart/form-data">
		                            <div class="form-body">
		                                <div class="form-group">
		                                    <label for="example-search-input" class="control-label col-md-4">Service <span class="required" aria-required="true">*</span>
		                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih service yang akan dilakukan perubahan data" data-container="body"></i></label>
		                                    <div class="col-md-5">
		                                        <select class="form-control select2" name="id_transaction_product_service" id="id_transaction_product_service" required style="width: 100%">
		                                            <option value="" selected disabled>Select Service</option>
		                                            @foreach($data['service'] ?? [] as $s)
		                                            	@php
		                                            		$disabled = ($s['detail']['reject_at'] || $s['detail']['transaction_product_completed_at'] || isset($s['service_status'])) ? 'disabled' : null;
		                                            		$status = null;
					                                		if ($s['detail']['transaction_product_service']['is_conflict']) {
					                                			$status =  ' (Conflict)';
					                                		} 
					                                		if ($s['detail']['reject_at']) {
					                                			$status =  ' (Rejected)';
					                                		}

					                                		if ($s['detail']['transaction_product_completed_at']) {
					                                			$status =  ' (Completed)';
					                                		}

															if (isset($s['service_status'])) {
					                                			$status =  ' ('.$s['service_status'].')';
					                                		}
		                                            	@endphp
		                                                <option value="{{$s['detail']['transaction_product_service']['id_transaction_product_service']}}"
															data-datefull="{{ date('d F Y', strtotime($s['detail']['transaction_product_service']['schedule_date'])) }}"
		                                                	data-date="{{ $s['detail']['transaction_product_service']['schedule_date'] }}"
		                                                	data-hs="{{ $s['detail']['transaction_product_service']['id_user_hair_stylist'] }}"
		                                                	data-id_trx_product="{{ $s['detail']['id_transaction_product'] }}"
															data-id_product="{{ $s['detail']['id_product'] }}"
															data-service-status="{{$s['detail']['transaction_product_service']['service_status']}}"
		                                                	{{ $disabled }}
		                                                >{{ $s['product_name'] . ' (' . $s['order_id'] . ')' . $status }}</option>
		                                            @endforeach
		                                        </select>
		                                    </div>
		                                </div>
			                            <div id="update-service-section">
			                                <div class="form-group">
				                                <label for="example-search-input" class="control-label col-md-4">Schedule Date <span class="required" aria-required="true">*</span>
				                                	<i class="fa fa-question-circle tooltips" data-original-title="Tanggal layanan dapat dimulai" data-container="body"></i></label>
				                                <div class="col-md-5">
				                                    <div class="input-group">
				                                        <input type="text" onchange="availableHS()" class="datepicker form-control update-service-input" id="schedule_date" name="schedule_date" value="" autocomplete="off">
				                                        <span class="input-group-btn">
				                                            <button class="btn default" type="button">
				                                                <i class="fa fa-calendar"></i>
				                                            </button>
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="form-group">
			                                    <label for="example-search-input" class="control-label col-md-4">Hair Stylist <span class="required" aria-required="true">*</span>
			                                    	<i class="fa fa-question-circle tooltips" data-original-title="Pilih Hair Stylist yang akan melakukan layanan" data-container="body"></i></label>
			                                    <div class="col-md-5">
			                                        <select class="form-control select2 update-service-input" name="id_user_hair_stylist" id="id_user_hair_stylist"  style="width: 100%">
			                                            <option value="" selected disabled>Select Hair Stylist</option>
			                                            @foreach($data['list_hs'] ?? [] as $h)
			                                                <option value="{{ $h['id_user_hair_stylist'] }}">{{ $h['nickname'] . ' - ' . $h['fullname'] }}</option>
			                                            @endforeach
			                                        </select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
				                                <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
				                                    <i class="fa fa-question-circle tooltips" data-original-title="Catatan kenapa melakukan perubahan data" data-container="body"></i></label>
				                                <div class="col-md-5">
				                                    <textarea name="note" class="form-control update-service-input" placeholder="Enter note here"></textarea>
				                                </div>
				                            </div>
				                            <div class="form-actions">
				                                {{ csrf_field() }}
				                                <div class="row">
				                                    <div class="col-md-offset-4 col-md-8">
				                                    	<input type="hidden" name="update_type" value="service">
				                                    	<input type="hidden" name="id_transaction_product" value="">
				                                        <button type="submit" class="btn blue" name='submit_type' value="update">Update</button>
				                                        <button type="submit" class="btn red service-reject" name='submit_type' value="reject">Reject</button>
				                                    </div>
				                                </div>
				                            </div>
			                            </div>
		                            </div>
		                        </form>
		                    </div>
	                    </div>
	                @endif

	                @if (!empty($data['product']))
		                <div class="portlet light bordered">
							<div class="portlet-title">
								<div class="caption font-blue ">
									<span class="caption-subject sbold uppercase">Product</span>
								</div>
							</div>
			                <div class="portlet-body form">
				                <form class="form-horizontal" role="form" action="#" method="post" enctype="multipart/form-data">
				            		<div class="form-body">
		                                <div class="form-group">
		                                    <label for="example-search-input" class="control-label col-md-4">Product <span class="required" aria-required="true">*</span>
		                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih product" data-container="body"></i></label>
		                                    <div class="col-md-5">
		                                        <select class="form-control select2 update-product-input" name="id_product" required style="width: 100%">
		                                            <option value="" selected disabled>Select Product</option>
		                                            @foreach($data['product'] ?? [] as $p)
		                                            	@php
		                                            		$disabled = ($p['detail']['reject_at'] || $p['detail']['transaction_product_completed_at']) ? 'disabled' : null;
		                                            		$rejected = $p['detail']['reject_at'] ? 'Rejected' : null;
		                                            		$completed = $p['detail']['transaction_product_completed_at'] ? 'Completed' : null;
		                                            	@endphp
		                                                <option value="{{ $p['detail']['id_transaction_product'] }}"
		                                                	data-id_trx_product="{{ $p['detail']['id_transaction_product'] }}"
		                                                	{{ $disabled }}
		                                                >{{ $p['product_name'] }} {{ $rejected ?: $completed }}</option>
		                                            @endforeach
		                                        </select>
		                                    </div>
		                                </div>
		                                <div id="update-product-section">
			                                <div class="form-group">
				                                <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
				                                    <i class="fa fa-question-circle tooltips" data-original-title="Catatan" data-container="body"></i></label>
				                                <div class="col-md-5">
				                                    <textarea name="note" id="note" class="form-control update-product-input" placeholder="notes">{{ $result['address'] ?? null }}</textarea>
				                                </div>
				                            </div>
				                            <div class="form-actions">
				                                {{ csrf_field() }}
				                                <div class="row">
				                                	<div class="col-md-offset-4 col-md-8">
				                                		<input type="hidden" name="id_transaction_product" value="">
				                                    	<input type="hidden" name="update_type" value="product">
				                                        <button type="submit" class="btn red" name='submit_type' value="reject">Reject</button>
				                                    </div>
				                                </div>
				                            </div>
			                            </div>
		                            </div>
					            </form>
				            </div>
		            	</div>
	                @endif
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