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
        <script>
        document.getElementById("start").onchange = function () {
                var inputs1 = document.getElementById("hidden");
                inputs1.setAttribute("value", this.value-1);
                var inputs = document.getElementById("end");
                inputs.setAttribute("value", this.value-1);
            }
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

	@include('layouts.notifications')
	<br>
        <div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">This menu is used to set a start date and end date from attendance</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url('setting/setting-attendances-date')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
                                                     <div class="form-group">
                                                    <label for="example-search-input" class="control-label col-md-4">Start Date Attendance<span class="required" aria-required="true">*</span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Start date berisi data perhitungan absensi dimulai" data-container="body"></i></label>
                                                    <div class="col-md-5">
                                                        <input value="{{$result['start']??''}}" type="number" min="2" max="28" name="start" id="start" class="form-control" placeholder="Enter start date">
                                                    </div>
                                                </div>
					</div>
					<div class="form-body">
                                                     <div class="form-group">
                                                    <label for="example-search-input" class="control-label col-md-4">Middle of Month Attendance<span class="required" aria-required="true">*</span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Tengha bulan dihitung dari hari ke 13-16 yang berfungsi untuk mengirim pendapatan hs pada tengah bulan." data-container="body"></i></label>
                                                    <div class="col-md-5">
                                                        <input value="{{$result['middle']??''}}" type="number" min="13" max="16" name="middle" id="middle" class="form-control" placeholder="Enter start date">
                                                    </div>
                                                </div>
					</div>
					<div class="form-body">
                                                     <div class="form-group">
                                                    <label for="example-search-input" class="control-label col-md-4">End Date Attendance<span class="required" aria-required="true">*</span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="End date data untuk selesai perhitungan absensi. Tanggal selesai tidak boleh sama maupun melebihi tanggal mulai" data-container="body"></i></label>
                                                    <div class="col-md-5">
                                                        <input value="{{$result['end']??''}}" disabled type="number" min="1" max="27" name="hidden" id="hidden" class="form-control" placeholder="Enter end date">
                                                        <input value="{{$result['end']??''}}" type="hidden" min="1" max="27" name="end" id="end" class="form-control" placeholder="Enter end date">
                                                    </div>
                                                </div>
					</div>
                                        
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection