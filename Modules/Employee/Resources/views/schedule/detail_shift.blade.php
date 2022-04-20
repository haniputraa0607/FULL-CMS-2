<?php
	use App\Lib\MyHelper;
	$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />

    <style type="text/css">
		@media (min-width: 768px) {
		  .seven-cols .col-md-1,
		  .seven-cols .col-sm-1,
		  .seven-cols .col-lg-1  {
		    width: 100%;
		    *width: 100%;
		  }
		}


		@media (min-width: 992px) {
		  .seven-cols .col-md-1,
		  .seven-cols .col-sm-1,
		  .seven-cols .col-lg-1 {
		    width: 14.2857142857%;
		    *width: 14.2857142857%;
		  }
		}


		@media (min-width: 1200px) {
		  .seven-cols .col-md-1,
		  .seven-cols .col-sm-1,
		  .seven-cols .col-lg-1 {
		    width: 14.2857142857%;
		    *width: 14.2857142857%;
		  }
		}

		.custom-date-container {
			margin: 10px;
		}

		.custom-date-box  {
			text-align: center;
            padding: 4px;
			border: 1px solid rgb(223, 222, 222);
			margin-top: -1px;
    		margin-left: -1px;
		}

        .custom-date-box-header {
            text-align: center;
            padding: 0px;
			border: 1px solid rgb(223, 222, 222);
			margin-top: -1px;
    		margin-left: -1px;
        }

		.custom-date-box {
    		height: 100px;
		}

        .month-year {
            margin-bottom: 20px;    
        }

	</style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/apps/scripts/calendar.min.js') }}" type="text/javascript"></script>
    <script>
        $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });

        var SweetAlert = function() {
            return {
                init: function() {
                    $(".approve-schedule").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to approve this schedule?",
                                    text: "Your will not be able to undo this action!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, approve it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    if ($('form#form-submit')[0].checkValidity()) {
                                    	$('form#form-submit').append('<input type="hidden" name="update_type" value="approve" />');
                                        $('form#form-submit').submit();
                                    }else{
                                        swal({
                                            title: "Incompleted Data",
                                            text: "Please fill blank input",
                                            type: "warning",
                                            showCancelButton: true,
                                            showConfirmButton: false
                                        });
                                    }
                                });
                        })
                    })

                    $(".reject-schedule").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to reject this schedule?",
                                    text: "Your will not be able to undo this action!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, reject it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    if ($('form#form-submit')[0].checkValidity()) {
                                    	$('form#form-submit').append('<input type="hidden" name="update_type" value="reject" />');
                                        $('form#form-submit').submit();
                                    }else{
                                        swal({
                                            title: "Incompleted Data",
                                            text: "Please fill blank input",
                                            type: "warning",
                                            showCancelButton: true,
                                            showConfirmButton: false
                                        });
                                    }
                                });
                        })
                    })
                }
            }
        }();
        

        jQuery(document).ready(function() {
            SweetAlert.init()
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

    <a href="{{url($url_back)}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Detail {{$sub_title}}</span>
            </div>
        </div>

        <div class="portlet-body">
	        <div class="form">
	            <form class="form-horizontal" id="form-submit" role="form" action="{{url($url_back.'/update/'.$data['detail']['id_employee_schedule'])}}" method="post">
	                <div class="form-body">
		                @php
		            		$status = $data['detail']['approve_at'] ? 'Approved' : ($data['detail']['reject_at'] ? 'Rejected' : 'Pending');
	                		$color = ($status == 'Approved') ? '#26C281' : (($status == 'Rejected') ? '#E7505A' : '#ffc107');
	                		$textColor = ($status == 'Pending') ? '#fff' : '#fff';
	                	@endphp
		                <div class="form-group">
		                    <label class="col-md-2">Status</label>
		                    <div class="col-md-6">: 
			                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: {{ $color }};padding: 5px 12px;color: {{ $textColor }};">{{ $status }}</span>
			                </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-2">Approve By</label>
		                    <div class="col-md-6">: {{ $data['detail']['approve_by_name'] }}</div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-2">Last Updated By</label>
		                    <div class="col-md-6">: {{ $data['detail']['last_updated_by_name'] }}</div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-2">Name</label>
		                    <div class="col-md-6">: {{ $data['detail']['name'] }}</div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-2">Office</label>
		                    <div class="col-md-6">: 
		                    	<a href="{{ url('outlet/detail') }}/{{ $data['detail']['outlet']['outlet_code'] }}">{{ $data['detail']['outlet']['outlet_code'].' - '.$data['detail']['outlet']['outlet_name'] }}</a>
		                    </div>
		                </div>
                        <input type="hidden" name="id_employee_office_hour" value="{{ $data['detail']['id_employee_office_hour'] }}">
                        <input type="hidden" name="shift" value="{{ $shift }}">
                        @php
							$day = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
							$dayCount = count($day);
							$employee_schedules = [];
							foreach ($data['detail']['employee_schedule_dates'] ?? [] as $val) {
								$year   = date('Y', strtotime($val['date']));
								$month  = date('m', strtotime($val['date']));
								$date 	= date('j', strtotime($val['date']));
								$employee_schedules[$year][$month][$date][$val['shift']] = $val;
							}
                            $implode_date = date($data['detail']['schedule_year'].'-'.$data['detail']['schedule_month'].'-01');
							$scheduleDate = date('Y-m-d', strtotime($implode_date ?? date('Y-m-d')));
							$thisMonth = date('m', strtotime($scheduleDate));
                            $update = false;
                            if($thisMonth >= date('m')){
                                $update = true;
                            } 
							$thisMonthYear = date('Y', strtotime($scheduleDate));
							$thisMonthDate = \App\Lib\MyHelper::getListDate($thisMonth, $thisMonthYear);
							$tmIndex = 0;
							$index = 0;
						@endphp
						<div class="month-year"><h2>{{ date('F Y', strtotime($scheduleDate)) }}</h1></div>
						<div class="custom-date-container">
                            <div class="row seven-cols">
								@for ($i = 0; $i < $dayCount ; $i++)
									<div class="col-md-1 custom-date-box-header">
							        	<div class="card text-center">
							        		<div class="card-body">
							        			<h5 class="card-title"><b>{{ $day[$i] }}</b></h5>
							        		</div>
							        	</div>
							        </div>
								@endfor
							</div>
                            @php
								$day = [ 
									1 => 'Minggu', 
									2 => 'Senin',
									3 => 'Selasa',
									4 => 'Rabu',
									5 => 'Kamis',
									6 => 'Jumat',
									0 => 'Sabtu',
								];
							@endphp
							@for ($i = 1; $i <= 42 ; $i++)
                                @if ($i % 7 == 1)
							    	@if (empty(($data['list_date'][$index]['day'])))
							    		@break
							    	@endif
									<div class="row seven-cols">
								@endif
								@if ($day[$i % 7] == ($data['list_date'][$index]['day'] ?? false))
                                    @php
										$schInfo = $data['list_date'][$index];
                                        if($schInfo['date']>=date('Y-m-d')){
                                            $can_update = true;
                                            if($schInfo['date'] == date('Y-m-d') && isset($data['detail']['attendance'])){
                                                $can_update = false;
                                            }
                                        }else{
                                            $can_update = false;
                                        }
                                        if ($schInfo['is_closed'] == 1 || $schInfo['outlet_holiday']){
                                            $can_update = false;
                                        }
									@endphp
                                    <div class="col-md-1 custom-date-box" @if (!$can_update) style="background-color:rgb(230, 230, 230);" @endif>
							        	<div class="card text-center">
							        		<div class="card-body">
								        		<div class="text-right" style="height:10px">
								        			@if (!empty($schInfo['all_employee_schedule']))
										        		<i class="fa fa-user tooltips" data-placement="bottom" data-original-title="list employees
										        			<div class='text-left'>
										        			</br>
										        			@foreach ($schInfo['all_employee_schedule'] as $val)
										        				@php
										        					$status = !empty($val['approve_at']) ? 'approved' : (!empty($val['reject_at']) ? 'rejected' : 'pending');
										        					$shift = $val['shift'];
										        					$color = ($status == 'approved') ? 'lightgreen' : (($status == 'rejected') ? 'orangered' : 'yellow');
										        				@endphp
																<p style='color: {{ $color }}; margin:0px;'> {{ $val['name'].' ('.$shift.') - '.$status }} </p>
										        			@endforeach
										        		</div>
														" data-container="body" data-html="true"></i>
													@else
														<div></div>
								        			@endif
												</div>
							        			<h4 class="card-title"><b>{{ date('j', strtotime($schInfo['date'])) }}</b></h4>

						        				<div style="font-size: 12px; {{ ($schInfo['is_closed'] ?? true) ? 'margin-top: -10px' : 'margin-top: 16px' }};" >
						        					{{ ($schInfo['is_closed'] ?? true) ? $schInfo['outlet_holiday'] ?? 'Closed' : null }}
						        				</div>

                                               

							        			<select name="schedule[{{ $schInfo['date'] }}]" style="font-size:12px" {{ $can_update ? '' : 'disabled' }}>
							        				<option value=""></option>
							        				@foreach ($schInfo['outlet_shift']['shift'] ?? [] as $s)
						        						<option value="{{ $s }}" {{ $s == $schInfo['selected_shift'] ? 'selected' : null }}> {{ $s }}</option>
							        				@endforeach
							        			</select>
                                                @if (!$can_update)
                                                    <input type="hidden" name="schedule[{{ $schInfo['date'] }}]" value="{{ $schInfo['selected_shift'] }}">
                                                @endif
							        		</div>
							        	</div>
							        </div>
							        @php
							        	$index++;
							        @endphp
                                @else
                                    <div class="col-md-1 custom-date-box" style="background-color:rgb(172, 172, 172);">
							        	<div class="card text-center">
							        		<div class="card-body">
							        		</div>
							        	</div>
							        </div>
                                        
                                @endif

                                 @if ($i % 7 == 0 || $i == 42)
									</div>
								@endif
                            @endfor
                        </div>
	                </div>
                    @if(MyHelper::hasAccess([349], $grantedFeature) && $update)
	                {{ csrf_field() }}
	                <div class="row" style="text-align: center">
	                    @if(empty($data['detail']['approve_at']))
	                        <a class="btn green-jungle approve-schedule" data-name="{{ $data['detail']['name'] }}">Approve</a>
	                        {{-- 
		                        @if(empty($data['detail']['reject_at']))
		                        	<a class="btn red reject-schedule" data-name="{{ $data['detail']['fullname'] }}">Reject</a>
		                        @endif 
	                        --}}
	                    @else
	                        <button type="submit" class="btn blue">Update</button>
	                    @endif
	                </div>
	                @endif
	            </form>
	        </div>
	    </div>
    </div>

@endsection