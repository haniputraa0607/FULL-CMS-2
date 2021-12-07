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
				Penjualan Outlet
			</div>
		</div>
	</h1>

	@include('layouts.notifications')
	<br>
	<div class="m-heading-1 border-green m-bordered">
		<p>This menu is used to set a code for icount</p>
	</div>
	<br>
	<form role="form" class="form-horizontal" action="{{url('setting/setting-icount')}}" method="POST" enctype="multipart/form-data">
		<div class="form-body"> 
			<div class="form-group">
				<div class="input-icon left">
					<label for="example-search-input" class="control-label col-md-3">Pengajuan Outlet <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Code Penjualan Outlet Icount" data-container="body"></i></label>
				</div>
				<div class="col-md-7">
                                    <input class="form-control" type="text" name="penjualan_outlet" value="{{$penjualan_outlet??''}}" placeholder="Input Penjualan Outlet" required>
				</div>
			</div>
		</div>
		<div class="form-body"> 
			<div class="form-group">
				<div class="input-icon left">
					<label for="example-search-input" class="control-label col-md-3">Revenue Sharing <span class="required" aria-required="true"> * </span> <i class="fa fa-question-circle tooltips" data-original-title="Code Revenue Sharing" data-container="body"></i></label>
				</div>
				<div class="col-md-7">
                                    <input class="form-control" type="text" name="revenue_sharing" value="{{$revenue_sharing??''}}" placeholder="Input Revenue Sharing" required>
				</div>
			</div>
		</div>
		<div class="form-body"> 
			<div class="form-group">
				<div class="input-icon left">
					<label for="example-search-input" class="control-label col-md-3">Management Fee <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Code Management Fee" data-container="body"></i></label>
				</div>
				<div class="col-md-7">
                                    <input class="form-control" type="text" name="management_fee" value="{{$management_fee??''}}" placeholder="Input Management Fee" required>
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