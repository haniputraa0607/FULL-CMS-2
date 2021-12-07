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

    	function changeTrigger () {
			$('#update-service-section').hide();
			$('.update-service-input').prop('required', false);
			let serviceObj = $('select[name=id_transaction_product_service] option:selected');
			let service = serviceObj.val();

			if (service != '') {
				let date = serviceObj.data('date') ?? null;
				let time = serviceObj.data('time') ?? null;
				let hs = serviceObj.data('hs') ?? null;

				$('#update-service-section').show();

				$('#update-service-section [name="schedule_date"]').datepicker({dateFormat: "dd MM yyyy"});
				$('#update-service-section [name="schedule_date"]').datepicker("setDate", $.datepicker.parseDate( "yy-mm-dd", date ));

				$('#update-service-section [name="schedule_time"]').timepicker('setTime', time);
	        	$('#update-service-section select[name="id_user_hair_stylist"]').val(hs).trigger('change');

				$('.update-service-input').prop('required', true);
				console.log(date, time, hs);
			}
		}

        $(document).ready(function() {
        	changeTrigger();

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
	        	console.log(id, code, name, photo, desc);
	        })

        	$('select[name=id_transaction_product_service]').on('change', function() {
        		changeTrigger();
	        })
        });

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
	            	@if (!empty($data['service']))
		            	<div class="portlet light bordered">
							<div class="portlet-title">
								<div class="caption font-blue ">
									<span class="caption-subject sbold uppercase">Service</span>
								</div>
							</div>
			                <div class="portlet-body form">
				                <div class="form-horizontal" role="form" action="{{url('businessdev/partners/update')}}" method="post" enctype="multipart/form-data">
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
							                                <label class="control-label col-md-4">Schedule Time </label>
							                                <div class="col-md-5">
											                    <span class="form-control border-0 text-bold">{{ $s['schedule_time'] }}</span>
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
								                    <span class="form-control border-0 text-bold">{{ $p['transaction_product_subtotal'] }}</span>
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
		                                                <option value="{{$s['detail']['transaction_product_service']['id_transaction_product_service']}}" 
		                                                	data-date="{{ $s['detail']['transaction_product_service']['schedule_date'] }}"
		                                                	data-time="{{ $s['schedule_time'] }}"
		                                                	data-hs="{{ $s['detail']['transaction_product_service']['id_user_hair_stylist'] }}"
		                                                >{{ $s['product_name'] . ' (' . $s['order_id'] . ')' }}</option>
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
				                                        <input type="text" class="datepicker form-control update-service-input" name="schedule_date" value="" autocomplete="off">
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
				                                	<i class="fa fa-question-circle tooltips" data-original-title="Waktu layanan dapat dimulai" data-container="body"></i></label>
				                                <div class="col-md-2">
							                    	<input type="text" data-placeholder="select time end" class="form-control mt-repeater-input-inline kelas-close timepicker timepicker-no-seconds update-service-input" name="schedule_time" data-show-meridian="false" readonly>
				                                </div>
				                            </div>
				                            <div class="form-group">
			                                    <label for="example-search-input" class="control-label col-md-4">Hair Stylist <span class="required" aria-required="true">*</span>
			                                    	<i class="fa fa-question-circle tooltips" data-original-title="Pilih Hair Stylist yang akan melakukan layanan" data-container="body"></i></label>
			                                    <div class="col-md-5">
			                                        <select class="form-control select2 update-service-input" name="id_user_hair_stylist" id="id_user_hair_stylist" required style="width: 100%">
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
				                                        <button type="submit" class="btn blue" value="update">Update</button>
				                                        <button type="submit" class="btn red" value="reject">Reject</button>
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
				                <form class="form-horizontal" role="form" action="{{url('businessdev/partners/update')}}" method="post" enctype="multipart/form-data">
				            		<div class="form-body">
		                                <div class="form-group">
		                                    <label for="example-search-input" class="control-label col-md-4">Product <span class="required" aria-required="true">*</span>
		                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih product" data-container="body"></i></label>
		                                    <div class="col-md-5">
		                                        <select class="form-control select2" name="id_bank_name" id="id_bank_name" required style="width: 100%">
		                                            <option value="" selected disabled>Select Product</option>
		                                            @foreach($data['product'] ?? [] as $p)
		                                                <option value="{{ $p['detail']['id_transaction_product'] }}">{{ $p['product_name'] }}</option>
		                                            @endforeach
		                                        </select>
		                                    </div>
		                                </div>
		                                <div class="form-group">
			                                <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
			                                    <i class="fa fa-question-circle tooltips" data-original-title="Catatan" data-container="body"></i></label>
			                                <div class="col-md-5">
			                                    <textarea name="note" id="input-address" class="form-control" placeholder="Enter address here">{{ $result['address'] ?? null }}</textarea>
			                                </div>
			                            </div>
		                            </div>
		                            <div class="form-actions">
		                                {{ csrf_field() }}
		                                <div class="row">
		                                	<div class="col-md-offset-4 col-md-8">
		                                    	<input type="hidden" name="update_type" value="service">
		                                        <button type="submit" class="btn blue" value="update">Confirm</button>
		                                        <button type="submit" class="btn red" value="reject">Reject</button>
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


@endsection