<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs     		= session('configs');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />

	<style type="text/css">
		.click-to{
			margin-top: 10px;
		}
		.modal .click-to-type .form-control,
		.modal .click-to-type .select2-container{
			display: none;
		}
		.modal .select2-selection{
			position: relative;
		}
	</style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

	<script>
	    $( "#sortable-ft-product-group" ).sortable();
	    $( "#sortable-ft-product-group" ).disableSelection();

	    $('.datetime').datetimepicker({
	        format: "dd M yyyy hh:ii",
	        autoclose: true,
	        todayBtn: true,
	        minuteStep:1
	    });

	    $('#featured_product_group .btn-edit').click(function() {
			var id = $(this).data('id');
			var banner_end = $(this).data('end-date');
			var banner_start = $(this).data('start-date');
			var image = $(this).data('img');
			var id_product_group = $(this).data('id-product-group');
			var promo_title = $(this).data('group-name');

			// assign value to form
			$('#id_banner').val(id);
			$('#banner_end').val(banner_end).datetimepicker({
		        format: "dd M yyyy hh:ii",
		        autoclose: true,
		        todayBtn: true,
		        minuteStep:1
		    });
			$('#banner_start').val(banner_start).datetimepicker({
		        format: "dd M yyyy hh:ii",
		        autoclose: true,
		        todayBtn: true,
		        minuteStep:1
		    });
			$('#id_product_group').find('option').first().attr('value',id_product_group).text(promo_title);
			$('#id_product_group').select2().trigger('change');
			$('#edit-banner-img').attr('src', image);
	    });

	    $('#featured_product_group .btn-delete').click(function() {
			var id 		= $(this).data('id');
			var link 	= "{{ url('product/product-group/featured/delete') }}/" + id;
			swal({
			  title: "Are you sure want to delete this featured product group ? ",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Yes, delete it",
			  closeOnConfirm: false
			},
			function(){
				window.location = link;
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
			<a href="javascript:;">Setting</a>
		</li>
	</ul>
</div>
<br>
@include('layouts.notifications')

<div class="" id="featured_product_group">
    <div style="margin:20px 0">
        <a class="btn blue btn-outline sbold" data-toggle="modal" href="#modalFeaturedProductGroup"> New Featured Product Group
        	<i class="fa fa-question-circle tooltips" data-original-title="Membuat featured product group di halaman online shop aplikasi mobile" data-container="body"></i>
        </a>
    </div>

	<div class="row" style="margin-top:20px">
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">List Featured Product Group</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="alert alert-warning">
					    <p> To arrange the order of product group, drag and drop on the product group in the order of the desired image.</p>
					</div>
					@if(!empty($featured_product_groups))
					<form action="{{ url('product/product-group/featured/reorder') }}" method="POST">
						<div class="clearfix" id="sortable-ft-product-group">
							@foreach ($featured_product_groups ?? [] as $key => $featured_product_group)
				 			<div class="portlet portlet-sortable light bordered col-md-3">
				 				<div class="portlet-title">
									<div class="row">
										<div class="col-md-2">
				 				  			<span class="caption-subject bold" style="font-size: 12px !important;">{{ $key + 1 }}</span>
										</div>
										<div class="col-md-10 text-right">
												<a class="btn blue btn-circle btn-edit" href="#modalFeaturedProductGroupUpdate" 
													data-toggle="modal" 
													data-start-date="{{ date('d M Y H:i',strtotime($featured_product_group['banner_start'])) }}" 
													data-end-date="{{ date('d M Y H:i',strtotime($featured_product_group['banner_end'])) }}" 
													data-id-product-group="{{ $featured_product_group['id_reference'] }}" 
													data-group-name="{{ $featured_product_group['product_group_name'] }}" 
													data-img="{{ $featured_product_group['image_url'] }}" 
													data-id="{{ $featured_product_group['id_banner'] }}"
													><i class="fa fa-pencil"></i> </a>
												<a class="btn red-mint btn-circle btn-delete" data-id="{{ $featured_product_group['id_banner'] }}"><i class="fa fa-trash-o"></i> </a>
										</div>
									</div>
				 				</div>
				 			 	<div class="portlet-body">
				 			   		<input type="hidden" name="id_banner[]" value="{{ $featured_product_group['id_banner'] }}">
				 			   		<center><img src="{{ $featured_product_group['image_url'] ?? null }}" alt="product group Image" width="150"></center>
				 			 	</div>
				 			 	<div class="click-to text-center">
				 			 		<div>{{ $featured_product_group['product_group_name'] }}</div>
				 			 		<div>{!! date('d M Y H:i:s',strtotime($featured_product_group['banner_start']))."<br> - <br>".date('d M Y H:i:s',strtotime($featured_product_group['banner_end'])) !!}</div>
				 			 	</div>
				 			</div>
				 			@endforeach
						</div>
						<div class="text-center">
							{{ csrf_field() }}
							<input type="submit" value="Update Sorting" class="btn blue">
						</div>
					</form>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalFeaturedProductGroupUpdate" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Featured Product Group</h4>
			</div>
			<div class="modal-body form">
				<br>
				<form role="form" action="{{url('product/product-group/featured/update')}}" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id_banner" id="id_banner">
					<div class="row">
						<div class="col-md-3 text-right">
							<label class="control-label">Banner Image <span class="required" aria-required="true"> * (750*375)</span></label><br>
						</div>
						<div class="col-md-8">
							<div class="form-body">
								<div class="form-body">
									<div class="form-group">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 200px;">
												<img src="https://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=750+x+375" alt="" id="edit-banner-img">
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
											<div>
												<span class="btn default btn-file">
												<span class="fileinput-new"> Select image </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file" accept="image/*" name="banner_image">
												</span>
												<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>Product Group</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<select class="select2 form-control" name="id_product_group" id="id_product_group" style="width: 100%">
									<option></option>
									@foreach($product_groups as $val)
									<option value="{{$val['id_product_group']}}">{{$val['product_group_name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>Start Date</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="datetime form-control" name="banner_start" id="banner_start" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>End Date</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="datetime form-control" name="banner_end" id="banner_end" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="form-actions" style="text-align:center">
						{{ csrf_field() }}
						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
						<button type="submit" class="btn blue" id="checkBtn">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalFeaturedProductGroup" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Create Featured Product Group</h4>
			</div>
			<div class="modal-body form">
				<br>
				<form role="form" action="{{url('product/product-group/featured/create')}}" method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-3 text-right">
							<label class="control-label">Banner Image <span class="required" aria-required="true"> * (750*375)</span></label><br>
						</div>
						<div class="col-md-8">
							<div class="form-body">
								<div class="form-group">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 200px;">
											<img src="https://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=750+x+375" alt="">
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
										<div>
											<span class="btn default btn-file">
											<span class="fileinput-new"> Select image </span>
											<span class="fileinput-exists"> Change </span>
											<input type="file" accept="image/*" name="banner_image" required>
											</span>
											<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>Product Group</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<select class="select2 form-control" name="id_product_group" style="width: 100%">
									<option></option>
									@foreach($product_groups as $val)
									<option value="{{$val['id_product_group']}}">{{$val['product_group_name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>Start Date</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="datetime form-control" name="banner_start" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 text-right">
							<label>End Date</label>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<input type="text" class="datetime form-control" name="banner_end" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="form-actions" style="text-align:center">
						{{ csrf_field() }}
						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
						<button type="submit" class="btn blue" id="checkBtn">Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection