@section('detail-schedule-style')
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

		.custom-date-box, .custom-date-box-header {
			text-align: center;
    		padding: 10px;
			border: 1px solid;
			margin-top: -1px;
    		margin-left: -1px;
		}

		.custom-date-box {
    		height: 100px;
		}

	</style>
@endsection

@section('detail-schedule')
	<div class="this-month">
		@php
			$day = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
			$dayCount = count($day);
			$hs_schedules = [];
			foreach ($detail['hairstylist_schedules'] ?? [] as $schedule) {
				foreach ($schedule['hairstylist_schedule_dates'] ?? [] as $val) {
					$year   = date('Y', strtotime($val['date']));
					$month  = date('m', strtotime($val['date']));
					$date 	= date('j', strtotime($val['date']));
					$hs_schedules[$year][$month][$date][$val['shift']] = $val;
				}
			}

			$thisMonth = date('m');
			$thisMonthYear = date('Y');
			$thisMonthDate = \App\Lib\MyHelper::getListDate($thisMonth, $thisMonthYear);
			$tmIndex = 0;
		@endphp
		<div><h1>{{ date('F Y') }}</h1></div>
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

				$nextMonth = date('m', strtotime("+1 Month".date('Y-m-01')));
				$nextMonthYear = date('Y', strtotime("+1 Month".date('Y-m-01')));
				$nextMonthDate = \App\Lib\MyHelper::getListDate($nextMonth, $nextMonthYear);
				$day = [ 
					1 => 'Sunday', 
					2 => 'Monday',
					3 => 'Tuesday',
					4 => 'Wednesday',
					5 => 'Thursday',
					6 => 'Friday',
					0 => 'Saturday',
				];
			@endphp
			@for ($i = 1; $i <= 42 ; $i++)
			    @if ($i % 7 == 1)
			    	@if (empty(($thisMonthDate[$tmIndex]['day'])))
			    		@break
			    	@endif
					<div class="row seven-cols">
				@endif
				@if ($day[$i % 7] == ($thisMonthDate[$tmIndex]['day'] ?? false))
					<div class="col-md-1 custom-date-box">
			        	<div class="card text-center">
			        		<div class="card-body">
				        		<div class="text-right" style="height:10px">
				        			@if (!empty($schedules[$thisMonthYear][$thisMonth][$thisMonthDate[$tmIndex]['date']]))
						        		<i class="fa fa-user tooltips" data-placement="bottom" data-original-title="list hairstylist
						        			<div class='text-left'>
						        			</br>
						        			@foreach ($schedules[$thisMonthYear][$thisMonth][$thisMonthDate[$tmIndex]['date']] as $schedule)
						        				@php
						        					$status = !empty($schedule['approve_at']) ? 'approved' : (!empty($schedule['reject_at']) ? 'rejected' : 'pending');
						        					$shift = ($schedule['shift'] == 'Morning') ? 'Pagi' : 'Sore';
						        					$color = ($status == 'approved') ? 'lightgreen' : (($status == 'rejected') ? 'orangered' : 'yellow');
						        				@endphp
												<p style='color: {{ $color }}; margin:0px;'> {{ $schedule['fullname'].' ('.$shift.') - '.$status }} </p>
						        			@endforeach
						        		</div>
										" data-container="body" data-html="true"></i>
									@else
										<div></div>
				        			@endif
								</div>
			        			<h4 class="card-title"><b>{{ $thisMonthDate[$tmIndex]['date'] }}</b></h4>
			        			@php
		        					$shift = null;
		        					if (count($hs_schedules[$thisMonthYear][$thisMonth][$thisMonthDate[$tmIndex]['date']] ?? []) == 2) {
		        						$shift = 'Full';
		        					} elseif ($hs_schedules[$thisMonthYear][$thisMonth][$thisMonthDate[$tmIndex]['date']]['Morning'] ?? false) {
		        						$shift = 'Morning';
		        					} elseif ($hs_schedules[$thisMonthYear][$thisMonth][$thisMonthDate[$tmIndex]['date']]['Evening'] ?? false) {
		        						$shift = 'Evening';
		        					} elseif ($hs_schedules[$thisMonthYear][$thisMonth][$thisMonthDate[$tmIndex]['date']]['Middle'] ?? false) {
		        						$shift = 'Middle';
		        					}

			        			@endphp
			        			<select disabled>
			        				<option></option>
			        				<option {{ $shift == 'Morning' ? 'selected' : null }}>Pagi</option>
			        				<option {{ $shift == 'Middle' ? 'selected' : null }}>Tengah</option>
			        				<option {{ $shift == 'Evening' ? 'selected' : null }}>Sore</option>
			        				<option {{ $shift == 'Full' ? 'selected' : null }}>Pagi & Sore</option>
			        			</select>
			        		</div>
			        	</div>
			        </div>
			        @php
			        	$tmIndex++;
			        @endphp
				@else
			        <div class="col-md-1 custom-date-box" style="background-color:lightgrey;">
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

	<div class="next-month" style="margin-top: 50px;">
		@php
			$day = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
			$dayCount = count($day);
			$nextMonth = date('m', strtotime("+1 Month".date('Y-m-01')));
			$nextMonthYear = date('Y', strtotime("+1 Month".date('Y-m-01')));
			$nextMonthDate = \App\Lib\MyHelper::getListDate($nextMonth, $nextMonthYear);
			$nmIndex = 0;
		@endphp
		<div><h1>{{ date('F Y', strtotime("+1 Month".date('Y-m-01'))) }}</h1></div>
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
					1 => 'Sunday', 
					2 => 'Monday',
					3 => 'Tuesday',
					4 => 'Wednesday',
					5 => 'Thursday',
					6 => 'Friday',
					0 => 'Saturday',
				];
			@endphp
			@for ($i = 1; $i <= 42 ; $i++)
			    @if ($i % 7 == 1)
			    	@if (empty(($nextMonthDate[$nmIndex]['day'])))
			    		@break
			    	@endif
					<div class="row seven-cols">
				@endif
				@if ($day[$i % 7] == ($nextMonthDate[$nmIndex]['day'] ?? false))
					<div class="col-md-1 custom-date-box">
			        	<div class="card text-center">
			        		<div class="card-body">
				        		<div class="text-right" style="height:10px">
				        			@if (!empty($schedules[$nextMonthYear][$nextMonth][$nextMonthDate[$nmIndex]['date']]))
						        		<i class="fa fa-user tooltips" data-placement="bottom" data-original-title="list hairstylist
						        			<div class='text-left'>
						        			</br>
						        			@foreach ($schedules[$nextMonthYear][$nextMonth][$nextMonthDate[$nmIndex]['date']] as $schedule)
						        				@php
						        					$status = !empty($schedule['approve_at']) ? 'approved' : (!empty($schedule['reject_at']) ? 'rejected' : 'pending');
						        					$shift = ($schedule['shift'] == 'Morning') ? 'Pagi' : 'Sore';
						        					$color = ($status == 'approved') ? 'lightgreen' : (($status == 'rejected') ? 'orangered' : 'yellow');
						        				@endphp
												<p style='color: {{ $color }}; margin:0px;'> {{ $schedule['fullname'].' ('.$shift.') - '.$status }} </p>
						        			@endforeach
						        		</div>
										" data-container="body" data-html="true"></i>
									@else
										<div></div>
				        			@endif
								</div>
			        			<h4 class="card-title"><b>{{ $nextMonthDate[$nmIndex]['date'] }}</b></h4>
			        			@php
		        					$shift = null;
		        					if (count($hs_schedules[$nextMonthYear][$nextMonth][$nextMonthDate[$nmIndex]['date']] ?? []) == 2) {
		        						$shift = 'Full';
		        					} elseif ($hs_schedules[$nextMonthYear][$nextMonth][$nextMonthDate[$nmIndex]['date']]['Morning'] ?? false) {
		        						$shift = 'Morning';
		        					} elseif ($hs_schedules[$nextMonthYear][$nextMonth][$nextMonthDate[$nmIndex]['date']]['Evening'] ?? false) {
		        						$shift = 'Evening';
		        					} elseif ($hs_schedules[$nextMonthYear][$nextMonth][$nextMonthDate[$nmIndex]['date']]['Middle'] ?? false) {
		        						$shift = 'Middle';
		        					}

			        			@endphp
			        			<select disabled>
			        				<option></option>
			        				<option {{ $shift == 'Morning' ? 'selected' : null }}>Pagi</option>
			        				<option {{ $shift == 'Middle' ? 'selected' : null }}>Tengah</option>
			        				<option {{ $shift == 'Evening' ? 'selected' : null }}>Sore</option>
			        				<option {{ $shift == 'Full' ? 'selected' : null }}>Pagi & Sore</option>
			        			</select>
			        		</div>
			        	</div>
			        </div>
			        @php
			        	$nmIndex++;
			        @endphp
				@else
			        <div class="col-md-1 custom-date-box" style="background-color:lightgrey;">
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

@endsection


@section('detail-schedule-script')
	<script type="text/javascript"></script>
@endsection