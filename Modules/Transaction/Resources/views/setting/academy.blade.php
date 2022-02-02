@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
		$('.datepicker').datepicker({
			'format' : 'd-M-yyyy',
			'todayHighlight' : true,
			'autoclose' : true
		});
		
		function submit() {
			var date = $('#deadline').val();

			if(date > 28){
				swal("Warning", "Please input date above 28.", "info")
			}else{
				$('form#form_setting').submit();
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

    <div class="tab-pane" id="user-profile">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Academy Setting</span>
						</div>
					</div>
					<div class="portlet-body">
						<form role="form" class="form-horizontal" id="form_setting" action="{{url()->current()}}" method="POST">
							<div class="form-group">
								<label class="col-md-4 control-label">Installment Deadline Date
									<span class="required" aria-required="true"> *</span>
									<i class="fa fa-question-circle tooltips" data-original-title="Batas waktu pelunasan. Input maksimal adalah tanggal 28." data-container="body"></i>
								</label>
								<div class="col-md-4">
									<div class="input-group">
										<span class="input-group-addon">Every</span>
										<input type="number" class="form-control" min="1" maxlength="2" id="deadline" name="installment_deadline" value="{{$result['installment_deadline']}}">
										<span class="input-group-addon">th</span>
									</div>
								</div>
							</div>
							<br>
							<div class="form-actions" style="text-align:center">
								{{ csrf_field() }}
								<a onclick="submit()" class="btn green"><i class="fa fa-check"></i> Submit</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection