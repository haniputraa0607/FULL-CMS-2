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

	<script type="text/javascript">
		$('.timepicker').timepicker({
			autoclose: true,
			showSeconds: false,
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

    <div class="tab-pane" id="user-profile">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Home Service Setting</span>
						</div>
					</div>
					<div class="portlet-body">
						<form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST">
							<div class="form-group">
								<label class="col-md-3 control-label">Outlet </label>
								<div class="col-md-8">
									<div class="input-icon right">
										<select name="outlet" class="select2 form-control" data-placeholder="Select outlet">
											<option></option>
											@foreach($outlets as $o)
												<option value="{{$o['id_outlet']}}" @if($o['id_outlet']==$result['outlet']) selected @endif>{{$o['outlet_code']}} - {{$o['outlet_name']}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Time </label>
								<div class="col-md-4">
									<div class="input-icon right">
										<input type="text" data-placeholder="select time" name="time_start" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="{{$result['time_start']}}" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="input-icon right">
										<input type="text" data-placeholder="select time" name="time_end" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="{{$result['time_end']}}" readonly>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Time Duration </label>
								<div class="col-md-4">
									<div class="input-group">
										<input type="number" class="form-control" min="1" name="duration" value="{{$result['duration']}}">
										<span class="input-group-addon">minutes</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Radius </label>
								<div class="col-md-4">
									<div class="input-group">
										<span class="input-group-addon">maximum</span>
										<input type="number" class="form-control" min="1" name="radius" value="{{$result['radius']}}">
									</div>
								</div>
							</div>
							<div class="form-actions" style="text-align:center">
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