
@extends('layouts.main')

@section('page-style')
	<link href="{{ url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
@endsection

@section('page-plugin')
	<script src="{{ url('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ url('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script>
		$('.datepicker').datepicker({
			'format' : 'd-M-yyyy',
			'todayHighlight' : true,
			'autoclose' : true
		});
	</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
		</li>
	</ul>
</div>
@include('layouts.notifications')
<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">New Transaction Fake</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url('transaction/create/fake')}}" method="POST">
					{{ csrf_field() }}
					<div class="form-body">
                        <div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Date Start
							    <span class="required" aria-required="true"> * </span>  
							    </label>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="date_start" placeholder="Date Start" required>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
						</div>
                        <div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Date End
							    <span class="required" aria-required="true"> * </span>  
							    </label>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="date_end" placeholder="Date End" required>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
						</div>
                        <div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    Number Of Transactions
							    <span class="required" aria-required="true"> * </span>  
							    </label>
							</div>
							<div class="col-md-4">
								<input type="number" name="how_many" placeholder="Number of Transactions" class="form-control" required />
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
							    <label class="col-md-3 control-label">
							    User
							    <span class="required" aria-required="true"> * </span>  
							    </label>
							</div>
							<div class="col-md-6">
								<select name="id_user[]" class="form-control input-sm select2" multiple placeholder="Search User" data-placeholder="Choose User" required>
									<option value="">Select...</option>
									<option value="0">All User</option>
									@if(isset($user))
										@foreach($user as $row)
											<option value="{{$row['id']}}">{{$row['name']}} - {{$row['phone']}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
					</div>
					<div class="form-actions">
						{{ csrf_field() }}
						<div class="col-md-offset-3">
						<button type="submit" class="btn blue" id="checkBtn">Create</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection