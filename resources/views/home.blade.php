@extends('layouts.main')

@section('page-style')
	<style type="text/css">
		.chartdiv {
			width   : 100%;
			height  : 400px;
		}
	</style>

<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script>
	AmCharts.addInitHandler(function(chart) {
		// check if there are graphs with autoColor: true set
		var warna = [
            '#FF0F00',
            '#FF6600',
            '#FF9E01',
            '#FCD202',
            '#F8FF01',
            '#B0DE09',
            '#04D215',
            '#0D8ECF',
            '#0D52D1',
            '#2A0CD0',
        ];
		for(var i = 0; i < chart.graphs.length; i++) {
			var graph = chart.graphs[i];
			if (graph.autoColor !== true)
			continue;
			var colorKey = "autoColor-"+i;
			graph.lineColorField = colorKey;
			graph.fillColorsField = colorKey;
			for(var x = 0; x < chart.dataProvider.length; x++) {
			var color = warna[x]
			chart.dataProvider[x][colorKey] = color;
			}
		}

	}, ["serial"]);
</script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/table-datatables-scroller.min.js')}}" type="text/javascript"></script>
	<script>
		$('.sample').DataTable({
                "searching": false,
                "paging": false,
                "ordering": false,
                "info": false,
				"scrollY": 150,
        });
	</script>
            <script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var datas = '';
        var datass = '';
        $.ajax({
                type: "get",
                url: "{{ url('home/user') }}",
                dataType: 'json',
                cache: false,
                success: function(data) {
                    $.each(data.dashboard_card, function( key, value ) {
                         if(value.card_name == "Total Transaction Count"){
                            icon = '<i class="fa fa-check-square"></i>';    
                            }else if(value.card_name == "Total Transaction Value"){
                             icon = '<i class="fa fa-check-square"></i>';
                            }else if(value.card_name == "Average Transaction"){
                             icon = '<i class="fa fa-money"></i>';    
                            }else if(value.card_name == "Average per Day"){
                             icon = '<i class="fa fa-balance-scale"></i>';
                            }else if(value.card_name == "New Customer"){
                             icon = '<i class="fa fa-user-plus"></i>';
                            }else if(value.card_name == "Total IOS Customer"){
                             icon = '<i class="fa fa-apple"></i>';
                            }else if(value.card_name == "Total Android Customer"){
                                 icon = '<i class="fa fa-android"></i>';
                            }else if(value.card_name == "Total Male Customer"){
                                 icon = '<i class="fa fa-male"></i>';
                            }else if(value.card_name == "Total Female Customer"){
                                 icon = '<i class="fa fa-female"></i>';
                            }else if(value.card_name == "Total Customer Not Verified"){
                                 icon = '<i class="fa fa-times-circle"></i>';
                            }else if(value.card_name == 'Total Customer' || value.card_name == 'Total User'){
                                 icon = '<i class="fa fa-users"></i>';
                            }else if(value.card_name == "Total Customer Subscribed"){
                                 icon = '<i class="fa fa-lock"></i>';
                            }else if(value.card_name == "Total Customer Unsubscribed"){
                                 icon = '<i class="<i class="fa fa-unlock"></i>"></i>';
                            }else{
                                 icon = '<i class="fa fa-balance-scale"></i>';
                            }
                        datas += '<div class="col-md-4" style="margin-top:20px">\n\
                                    <div class="dashboard-stat grey">\n\
                                        <div class="visual">\n\
                                            '+icon+'\n\
                                        </div>\n\
                                        <div class="details">\n\
                                            <div class="number">\n\
                                                <span data-counter="counterup" data-value="'+value.value+'">'+value.value_text+'</span>\n\
                                            </div>\n\
                                            <div class="desc">'+value.card_name+'</div>\n\
                                        </div>\n\
                                        <a class="more" href="'+value.url+'">'+value.text+'<i class="m-icon-swapright m-icon-white"></i></a>\n\
                                    </div>\n\
                                   </div>'
                    });
                    if(datas){
                     $('#user').html(datas)
                    }
                 $('#users').html(data.section_title)
                },
                error: function(data) {
                    console.log('gagal')
                }
            });
        
        $.ajax({
                type: "get",
                url: "{{ url('home/transaction') }}",
                dataType: 'json',
                cache: false,
                success: function(data) {
                    $.each(data.dashboard_card, function( key, value ) {
                         if(value.card_name == "Total Transaction Count"){
                            icon = '<i class="fa fa-check-square"></i>';    
                            }else if(value.card_name == "Total Transaction Value"){
                             icon = '<i class="fa fa-check-square"></i>';
                            }else if(value.card_name == "Average Transaction"){
                             icon = '<i class="fa fa-money"></i>';    
                            }else if(value.card_name == "Average per Day"){
                             icon = '<i class="fa fa-balance-scale"></i>';
                            }else if(value.card_name == "New Customer"){
                             icon = '<i class="fa fa-user-plus"></i>';
                            }else if(value.card_name == "Total IOS Customer"){
                             icon = '<i class="fa fa-apple"></i>';
                            }else if(value.card_name == "Total Android Customer"){
                                 icon = '<i class="fa fa-android"></i>';
                            }else if(value.card_name == "Total Male Customer"){
                                 icon = '<i class="fa fa-male"></i>';
                            }else if(value.card_name == "Total Female Customer"){
                                 icon = '<i class="fa fa-female"></i>';
                            }else if(value.card_name == "Total Customer Not Verified"){
                                 icon = '<i class="fa fa-times-circle"></i>';
                            }else if(value.card_name == 'Total Customer' || value.card_name == 'Total User'){
                                 icon = '<i class="fa fa-users"></i>';
                            }else if(value.card_name == "Total Customer Subscribed"){
                                 icon = '<i class="fa fa-lock"></i>';
                            }else if(value.card_name == "Total Customer Unsubscribed"){
                                 icon = '<i class="<i class="fa fa-unlock"></i>"></i>';
                            }else{
                                 icon = '<i class="fa fa-balance-scale"></i>';
                            }
                        datass += '<div class="col-md-4" style="margin-top:20px">\n\
                                    <div class="dashboard-stat grey">\n\
                                        <div class="visual">\n\
                                            '+icon+'\n\
                                        </div>\n\
                                        <div class="details">\n\
                                            <div class="number">\n\
                                                <span data-counter="counterup" data-value="'+value.value+'">'+value.value_text+'</span>\n\
                                            </div>\n\
                                            <div class="desc">'+value.card_name+'</div>\n\
                                        </div>\n\
                                        <a class="more" href="'+value.url+'">'+value.text+'<i class="m-icon-swapright m-icon-white"></i></a>\n\
                                    </div>\n\
                                   </div>'
                    });
                    if(datass){
                     $('#transaction').html(datass)
                    }
                 $('#transactions').html(data.section_title)
                },
                error: function(data) {
                    console.log('gagal')
                }
            });
    });
</script>
@endsection

@section('content')

	<?php
		use App\Lib\MyHelper;
		$grantedFeature     = session('granted_features');
	?>

	@if(MyHelper::hasAccess([1], $grantedFeature))
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="{{url('/')}}">Home</a>
			</li>
		</ul>
	</div>
	<h1 class="page-title">
		<i class="fa fa-home font-blue"></i>
		<span class="caption-subject font-blue-sharp sbold">{{$title}}</span>
	</h1>
	<div class="portlet light">
		<div class="portlet-body">
			@include('layouts.notifications')
			Hello<br>
			<b>{{Session::get('name')}}</b><br>
			<b>{{Session::get('phone')}}</b><br><br>

			<?php setlocale(LC_MONETARY, 'id_ID'); ?>
			<?php date_default_timezone_set("Asia/Jakarta");
			$thn = $year;
			$bln = $month;

			$m_start    = date('m', strtotime($bln));
			$date_start = $thn.'-'.$m_start.'-01';

			$m_end      = date('m-t', strtotime($bln));
			$date_end   = $thn.'-'.$m_end;

			$thnnow = date('Y');
			$thnnowminspuluh = $thnnow - 20;
			?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="glyphicon glyphicon-stats"></i>
						<span class="caption-subject bold">Summary Data Filter</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						@if($thn == 'alltime' || strpos($thn, 'last') !== false)
							<div class="col-lg-3" style="margin-top:20px"></div>
						@else
							<div class="col-lg-2" style="margin-top:20px"></div>
						@endif
						<div class="col-lg-3" style="text-align:right;margin-top:20px">
							@if(strpos($thn, 'last') !== false)
								<select id="bulane" class="form-control" name="thn" onChange="gantiHome(this.value);">
									<option value="last7days" @if($thn == 'last7days') selected @endif>Last 1 Week</option>
									<option value="last30days" @if($thn == 'last30days') selected @endif>Last 30 Days</option>
									<option value="last3months" @if($thn == 'last3months') selected @endif>Last 3 Months</option>
								</select>
							@else
								<a href="{{URL::to('home')}}/last30days" class="btn grey btn-block">Last 30 Days</a>
							@endif
						</div>
						<div class="col-lg-3" style="text-align:right;margin-top:20px">
							@if($thn == 'alltime')
								<a href="{{URL::to('home')}}/alltime" class="btn green btn-block">All Time</a>
							@else
								<a href="{{URL::to('home')}}/alltime" class="btn grey btn-block">All Time</a>
							@endif
						</div>
						@if($thn == 'alltime' || strpos($thn, 'last') !== false)
							<div class="col-lg-3" style="text-align:right;margin-top:20px">
								<a href="{{URL::to('home/'.date('Y').'/'.date('m'))}}" class="btn grey btn-block">This Month</a>
							</div>
						@else
						<div class="col-lg-2" style="text-align:right;margin-top:20px">
							<select id="bulane" class="form-control" name="month" onChange="gantiHome();">
								<option value="1" @if($bln == '1') selected @endif>January</option>
								<option value="2" @if($bln == '2') selected @endif>February</option>
								<option value="3" @if($bln == '3') selected @endif>March</option>
								<option value="4" @if($bln == '4') selected @endif>April</option>
								<option value="5" @if($bln == '5') selected @endif>May</option>
								<option value="6" @if($bln == '6') selected @endif>June</option>
								<option value="7" @if($bln == '7') selected @endif>July</option>
								<option value="8" @if($bln == '8') selected @endif>August</option>
								<option value="9" @if($bln == '9') selected @endif>September</option>
								<option value="10" @if($bln == '10') selected @endif>October</option>
								<option value="11" @if($bln == '11') selected @endif>November</option>
								<option value="12" @if($bln == '12') selected @endif>December</option>
							</select>
						</div>
						<div class="col-lg-2" style="text-align:right;margin-top:20px">
						<select id="tahune" class="form-control" name="year" onChange="gantiHome();">
							@for($x = $thnnow; $x >= $thnnowminspuluh; $x-- )
							<option value="{{$x}}" @if($x == $thn) selected @endif>{{$x}}</option>
							@endfor
						</select>
						</div>
						@endif
					</div>
				</div>
			</div>
                            <div class="portlet box blue">
                                    <div class="portlet-title">
                                            <div class="caption">
                                                    <i class="glyphicon glyphicon-stats"></i>
                                                    <span class="caption-subject bold">
                                                        <div id="transactions"></div>
                                                    </span>
                                            </div>
                                    </div>
                                    <div class="portlet-body">
                                            <div class="row">
                                                <div id="transaction"></div>
                                            </div>
                                    </div>
                            </div>
                            <div class="portlet box blue">
                                    <div class="portlet-title">
                                            <div class="caption">
                                                    <i class="glyphicon glyphicon-stats"></i>
                                                    <span class="caption-subject bold">
                                                        <div id="users"></div>
                                                    </span>
                                            </div>
                                    </div>
                                    <div class="portlet-body">
                                            <div class="row">
                                                <div class="col-md-12">
						 <div id="user"></div>	
						</div>
                                            </div>
                                    </div>
                            </div>

	</div>
	<script>
	function gantiHome(thn = null){
		if(thn == null){
			var bulane = document.getElementById('bulane').value;
			var tahune = document.getElementById('tahune').value;
			var lokasine = "{{URL::to('home')}}/"+tahune+"/"+bulane;
		}else{
			var lokasine = "{{URL::to('home')}}/"+thn;
		}
		window.location.href = lokasine;
	}
	</script>
        

	@endif

@endsection
