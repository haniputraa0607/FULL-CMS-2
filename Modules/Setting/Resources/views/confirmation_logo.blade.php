<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs     		= session('configs');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script>
		$(".file").change(function(e) {
			var type      = $(this).data('type');
			var widthImg  = 0;
			var heightImg = 0;
			var _URL = window.URL || window.webkitURL;
			var image, file;

			if ((file = this.files[0])) {
				image = new Image();
				var size = file.size/1024;

				image.onload = function() {
					if (this.width > 240 ||  this.height > 80) {
						toastr.warning("Please check dimension of your photo.");
						$("#removeImage").trigger( "click" );
					}

					if (size > 150) {
						toastr.warning("The maximum size is 10 KB");
						$("#removeImage").trigger( "click" );
					}
				};
				image.src = _URL.createObjectURL(file);
			}
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
				{{$title}}
			</li>
		</ul>
	</div>
	<br>

	<h1 class="page-title">
		<div class="row">
			<div class="col-md-6">
				Confirmation Letter Logo
			</div>
		</div>
	</h1>

	@include('layouts.notifications')
	<br>
	<div class="m-heading-1 border-green m-bordered">
		<p>This menu is used to set a logo that will be used in the confirmation letter</p>
	</div>
	<br>
	<form role="form" class="form-horizontal" action="{{url('setting/logo-confir')}}" method="POST" enctype="multipart/form-data">
		<div class="form-body"> 
			<div class="form-group">
				<div class="input-icon right">
					<label for="example-search-input" class="control-label col-md-3">Logo Confirmation Letter
                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih logo untuk header confirmation letter" data-container="body"></i><br>
                        <span class="required" aria-required="true"> (max dimension : 240*80)</span><br><span class="required" aria-required="true"> (PNG Only max 150 KB)</span></label>
				</div>
				<div class="col-md-8">
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<div class="fileinput-new thumbnail" style="width: 100px; height: 40px;">
							<img src="{{$image}}" alt="">
						</div>
						<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100px; max-height: 100px;"> </div>
						<div>
							<span class="btn default btn-file">
								<span class="fileinput-new"> Select image </span>
								<span class="fileinput-exists"> Change </span>
								<input type="file" accept="image/*" id="field_image" class="file" name="image">
							</span>
							<a href="javascript:;" id="removeImage" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="form-actions">
			{{ csrf_field() }}
			<div class="row col-md-12" style="text-align: center;margin-top: 3%;">
				<button type="submit" class="btn green">Submit</button>
			</div>
		</div>
	</form>
@endsection