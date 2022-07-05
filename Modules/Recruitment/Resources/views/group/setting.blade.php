<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .datepicker{
            padding: 6px 12px;
           }
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
      <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    
<script>
  $(document).ready(function () {
       var vals = <?php echo json_encode($mid['value_text']); ?>;
        vals.forEach(function(e){
        $('#code').find('option[value="'+e+'"]').attr("selected", "selected");
        $('#code').trigger('change');
        });
        var valss = <?php echo json_encode($end['value_text']); ?>;
        valss.forEach(function(e){
        $('#code_end').find('option[value="'+e+'"]').attr("selected", "selected");
        $('#code_end').trigger('change');
        });
        $("input[data-type='currency']").on({
            keyup: function() {
              formatCurrency($(this));
            },
            blur: function() { 
              formatCurrency($(this), "blur");
            }
        });
        

        function formatNumber(n) {
          // format number 1000000 to 1,234,567
          return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
          // appends $ to value, validates decimal side
          // and puts cursor back in right position.

          // get input value
          var input_val = input.val();

          // don't validate empty input
          if (input_val === "") { return; }

          // original length
          var original_len = input_val.length;

          // initial caret position 
          var caret_pos = input.prop("selectionStart");

          // check for decimal
          if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);


            // join number by .
            input_val = left_side ;

          } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;

            // final formatting
            
          }

          // send updated string to input
          input.val(input_val);

          // put caret back in the right position
          var updated_len = input_val.length;
          caret_pos = updated_len - original_len + caret_pos;
          input[0].setSelectionRange(caret_pos, caret_pos);
        }
    })
    function addFormula(param){
		var textvalue = $('#formula').val();
		var textvaluebaru = textvalue+" "+param;
		$('#formula').val(textvaluebaru);
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Setting Income</span>
            </div>
        </div>
        <div class="tabbable-line tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#incentive" data-toggle="tab">Incentive & Salary Cut</a>
                </li>
                <li>
                    <a href="#overtime" data-toggle="tab">Overtime</a>
                </li>
                <li>
                    <a href="#proteksi" data-toggle="tab">Proteksi</a>
                </li>
                <li>
                    <a href="#total" data-toggle="tab">Total Date</a>
                </li>
            </ul>
            <div class="tab-content">
            <div class="tab-pane active" id="incentive">
                    <div class="portlet light ">
                            <div class="portlet-title">
                                    <div class="caption font-blue ">
                                            <i class="icon-settings font-blue "></i>
                                            <span class="caption-subject bold uppercase">This menu is used to set a middle calculation income hairstylist</span>
                                    </div>
                            </div>
                            <div class="portlet-body form">
                                    <form role="form" class="form-horizontal" action="{{url('recruitment/hair-stylist/group/setting-income')}}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-body">
                                                <div id="id_commission">
                                                    <div class="form-group">
                                                        <label for="example-search-input" class="control-label col-md-4">Date<span class="required" aria-required="true">*</span>
                                                            <i class="fa fa-question-circle tooltips" data-original-title="tanggal pertengahan perhitungan absensi" data-container="body"></i></label>
                                                        <div class="col-md-2">
                                                            <input value="{{$result['mid_date']??''}}" required type="number" min="1" max="28" name="mid_date" id="mid_date" class="form-control" placeholder="Enter date">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="example-search-input" class="control-label col-md-4">Delivery date<span class="required" aria-required="true">*</span>
                                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal pengiriman pendapatan tengah bulan" data-container="body"></i></label>
                                                        <div class="col-md-2">
                                                            <input value="{{$result['delivery_mid_date']??''}}" required type="number" min="1" max="28" name="delivery_mid_date" id="delivery_mid_date" class="form-control" placeholder="Enter date">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="example-search-input" class="control-label col-md-4">Calculation Income Middle<span class="required" aria-required="true">*</span>
                                                            <i class="fa fa-question-circle tooltips" data-original-title="Besaran gaji pokok" data-container="body"></i></label>
                                                        <div class="col-md-6">
                                                          <select class="form-control select2" multiple="multiple" name="hs_income_calculation_mid[]" id="code" data-placeholder="Select">
                                                                    <option></option>
                                                                    @foreach($list as $val)
                                                                    <option value="{{$val['code']}}" >{{$val['name']}}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption font-blue ">
                                                    <i class="icon-settings font-blue "></i>
                                                    <span class="caption-subject bold uppercase">This menu is used to set a ended calculation income hairstylist</span>
                                            </div>
                                            <div class="form-body">
                                                    <div id="id_commission">
                                                        <div class="form-group">
                                                            <label for="example-search-input" class="control-label col-md-4">Date<span class="required" aria-required="true">*</span>
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal perhitungan akhir absensi" data-container="body"></i></label>
                                                            <div class="col-md-2">
                                                                <input value="{{$result['end_date']??''}}" requiredrequired type="number" min="2" max="28" name="end_date" id="end_date" class="form-control" placeholder="Enter start date">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="example-search-input" class="control-label col-md-4">Delivery date<span class="required" aria-required="true">*</span>
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal pengiriman pendapatan akhir bulan" data-container="body"></i></label>
                                                            <div class="col-md-2">
                                                                <input value="{{$result['delivery_end_date']??''}}" required type="number" min="1" max="28" name="delivery_end_date" id="delivery_end_date" class="form-control" placeholder="Enter date">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="example-search-input" class="control-label col-md-4">Calculation Income Ended<span class="required" aria-required="true">*</span>
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Besaran gaji pokok" data-container="body"></i></label>
                                                            <div class="col-md-6">
                                                              <select class="form-control select2" multiple="multiple" name="hs_income_calculation_end[]" id="code_end" data-placeholder="Select">
                                                                        <option></option>
                                                                        @foreach($list as $val)
                                                                        <option value="{{$val['code']}}" >{{$val['name']}}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="form-actions" style="text-align:center;">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn blue" id="checkBtn">Update</button>
                                            </div>
                                    </form>
                            </div>
                    </div>
            </div>
            <div class="tab-pane" id="overtime">
                <div class="portlet light">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">This menu is used to set a overtime minutes</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url('recruitment/hair-stylist/group/setting-overtime')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
                                                <div id="id_commission">
                                                     <div class="form-group">
                                                    <label for="example-search-input" class="control-label col-md-4">Overtime<span class="required" aria-required="true">*</span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Minimal waktu overtime (1-59)" data-container="body"></i></label>
                                                    <div class="col-md-2">
                                                        <input type="number" name="value" min="1" max="60" value="{{$overtime['value']??0}}" placeholder="Masukkan waktu (minutes)" class="form-control" required />
                                                    </div>
                                                </div>
                                                </div>
					</div>
                                        
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Update</button>
					</div>
				</form>
			</div>
		</div>
            </div>
            <div class="tab-pane" id="proteksi">
                <div class="portlet light ">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">This menu is used to set a proteksi outlet</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url('recruitment/hair-stylist/group/setting-proteksi')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
                                                <div id="id_commission">
                                                     <div class="form-group">
                                                    <label for="example-search-input" class="control-label col-md-4">Range<span class="required" aria-required="true">*</span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Maksimal umur outlet(bulan) yang dapat di proteksi" data-container="body"></i></label>
                                                    <div class="col-md-3">
                                                        <input type="number" name="range" value="{{$proteksi['range']??''}}" placeholder="Masukkan umur outlet yang dapat di proteksi" class="form-control" required />
                                                    </div>
                                                </div>
                                                     <div class="form-group">
                                                    <label for="example-search-input" class="control-label col-md-4">Nominal<span class="required" aria-required="true">*</span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Maksimal umur outlet(bulan) yang dapat di proteksi" data-container="body"></i></label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="value" data-type="currency" value="{{number_format($proteksi['value']??0,0,',',',')}}" placeholder="Masukan besaran nilai proteksi" class="form-control" required />
                                                    </div>
                                                </div>
                                                </div>
					</div>
                                        
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Update</button>
					</div>
				</form>
			</div>
		</div>
            </div>
            <div class="tab-pane" id="total">
                <div class="portlet light">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">This menu is used to set a overtime minutes</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url('recruitment/hair-stylist/group/setting-date')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
                                                <div id="id_commission">
                                                     <div class="form-group">
                                                    <label for="example-search-input" class="control-label col-md-4">Total Date<span class="required" aria-required="true">*</span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Total hari dalam satu bulan" data-container="body"></i></label>
                                                    <div class="col-md-2">
                                                        <input type="number" name="value" min="1" max="60" value="{{$date['value']??0}}" placeholder="Masukkan waktu (minutes)" class="form-control" required />
                                                    </div>
                                                </div>
                                                </div>
					</div>
                                        
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Update</button>
					</div>
				</form>
			</div>
		</div>
            </div>
        </div>
        </div>
    </div>
@endsection