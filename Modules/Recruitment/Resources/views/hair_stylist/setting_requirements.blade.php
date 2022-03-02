@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
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

    <div class="tab-pane" id="user-profile">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Candidate Setting Requirements</span>
						</div>
					</div>
					<div class="portlet-body">
						<form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST">
							<div class="form-group">
								<label class="col-md-3 control-label">Male Age </label>
								<div class="col-md-4">
									<div class="input-group">
										<span class="input-group-addon">maximal</span>
										<input type="number" class="form-control" min="1" name="male_age" value="{{$male_age}}">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Male Height </label>
								<div class="col-md-4">
									<div class="input-group">
										<span class="input-group-addon">minimum</span>
										<input type="number" class="form-control" min="1" name="male_height" value="{{$male_height}}">
										<span class="input-group-addon">cm</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Female Age </label>
								<div class="col-md-4">
									<div class="input-group">
										<span class="input-group-addon">maximal</span>
										<input type="number" class="form-control" min="1" name="female_age" value="{{$female_age}}">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Female Height </label>
								<div class="col-md-4">
									<div class="input-group">
										<span class="input-group-addon">minimum</span>
										<input type="number" class="form-control" min="1" name="female_height" value="{{$female_height}}">
										<span class="input-group-addon">cm</span>
									</div>
								</div>
							</div>
							<div class="form-actions" style="text-align:center;margin-top: 5%">
								{{ csrf_field() }}
								<button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection