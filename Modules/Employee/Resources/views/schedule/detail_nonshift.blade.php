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

        

        jQuery(document).ready(function() {

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
	                </div>
                    @php
                        $implode_date = date($data['detail']['schedule_year'].'-'.$data['detail']['schedule_month'].'-01');
						$scheduleDate = date('Y-m-d', strtotime($implode_date ?? date('Y-m-d')));
						$thisMonth = date('m', strtotime($scheduleDate));
                    @endphp
					<div class="month-year"><h2>{{ date('F Y', strtotime($scheduleDate)) }}</h1></div>
                        
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center" width="200px">Date</th>
                                    <th class="text-nowrap text-center">Status</th>
                                    <th class="text-nowrap text-center">Schedule In</th>
                                    <th class="text-nowrap text-center">Schedule Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['list_date'] ?? [] as $list)  
                                @php
                                    if($list['is_closed'] == 0){
                                        $status = true;
                                        $class = 'active';
                                        $v_status = 'Normal';
                                    }else{
                                        $status = false;
                                        $class = 'danger';
                                        if(isset($list['holiday'])){
                                            $v_status = $list['holiday'];
                                        }else{
                                            $v_status = 'Day Off';
                                        }
                                    }
                                @endphp
                                <tr class="{{ $class }}">
                                    <td class="text-nowrap">{{ $list['date'] }}</td>
                                    <td class="text-nowrap text-center">{{ $v_status }}</td>
                                    <td class="text-nowrap text-center">@if ($status){{ $list['time_start'] }} @else - @endif</td>
                                    <td class="text-nowrap text-center">@if ($status){{ $list['time_end'] }} @else - @endif</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
	            </form>
	        </div>
	    </div>
    </div>

@endsection