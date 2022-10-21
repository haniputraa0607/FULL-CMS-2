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
    function changeType() {
			if( $("#type").val()== "Single"){
				$("#formulas").hide();
			}else{
				$("#formulas").show();
				$('#formula').prop('required', true);
			}
		}
    function types() {
        if($("#type").val() == 'year'){
                $("#change-type").show();
                $('#month').prop('required', true);
        }else{
                $("#change-type").hide();
                $('#month').prop('required', false);
        }
    }
    function addFormula(param){
		var textvalue = $('#formula').val();
		var textvaluebaru = textvalue+" "+param;
		$('#formula').val(textvaluebaru);
        }
  $(document).ready(function () {
      $("#formulas").hide();
        $("input[data-type='currency']").on({
            keyup: function() {
              formatCurrency($(this));
            },
            blur: function() { 
              formatCurrency($(this), "blur");
            }
        });
        
        types();
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
                <span class="caption-subject sbold uppercase font-blue">Product Icount Reimbursement</span>
            </div>
        </div>
            <div class="tab-content">
            <div class="tab-pane active" >
                <form class="form-horizontal" role="form" action="{{url('employee/reimbursement/setting/update')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                               <div class="form-group">
                                    <label class="col-md-4 control-label">Product Icount<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Product icount yang dapat digunakan pada reimbursement employee" data-container="body"></i>
                                    </label>
                                    <div class="col-md-5">
                                        <select  class="form-control select2" name="id_product_icount" id="id_product_icount" data-placeholder="Select Product Icount" required>
                                                <option value="{{$data['id_product_icount']}}">{{$data['name_icount']}}</option>
                                                @foreach($product as $va)
                                                <option value="{{$va['id_product_icount']}}">{{$va['name']}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Name<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama yang akan keluar pada aplikasi" datroduct icount yang dapat digunakan pada cash_advance employee"a-container="body"></i>
                                    </label>
                                    <div class="col-md-5">
                                        <input class="form-control" name="name" value="{{$data['name']}}" id="name"  placeholder="Select Name" required>
                                        <input class="form-control" type='hidden' name="id_employee_reimbursement_product_icount" value="{{$data['id_employee_reimbursement_product_icount']}}" id="id_employee_reimbursement_product_icount"  placeholder="Select Name" required>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Max Approve Date<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama yang akan keluar pada aplikasi" datroduct icount yang dapat digunakan pada cash_advance employee"a-container="body"></i>
                                    </label>
                                    <div class="col-md-5">
                                        <input type="number" min="1" value="{{$data['max_approve_date']}}"  max="28" class="form-control" name="max_approve_date" id="max_approve_date"  placeholder="Input Max Approve Date" required>

                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-md-4 control-label">Type<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Besaran maksimal reimbursement employee" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <select onchange="types()" name="type" id='type' placeholder="Masukkan Type" class="form-control" required>
                                            <option @if($data['type']=="month") selected @endif value="month">Monthly</option>
                                            <option @if($data['type']=="year") selected @endif value="year">Yearly</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="change-type">
                                    <label class="col-md-4 control-label">Month<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Bulan untuk reset nilai dari batas maksimal reimbursememt" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <select   name="month" id='month' placeholder="Masukkan month" class="form-control">
                                            <option @if($data['month']=="01") selected @endif value="01">Januari</option>
                                            <option @if($data['month']=="02") selected @endif value="02">Februari</option>
                                            <option @if($data['month']=="03") selected @endif value="03">Maret</option>
                                            <option @if($data['month']=="04") selected @endif value="04">April</option>
                                            <option @if($data['month']=="05") selected @endif value="05">Mei</option>
                                            <option @if($data['month']=="06") selected @endif value="06">Juni</option>
                                            <option @if($data['month']=="07") selected @endif value="07">Juli</option>
                                            <option @if($data['month']=="08") selected @endif value="08">Agustus</option>
                                            <option @if($data['month']=="09") selected @endif value="09">September</option>
                                            <option @if($data['month']=="10") selected @endif value="10">Oktober</option>
                                            <option @if($data['month']=="11") selected @endif value="11">November</option>
                                            <option @if($data['month']=="12") selected @endif value="12">Desember</option>
                                        </select>
                                     </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Reset Date<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal reset besaran reimbursement" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <input type="text" min="1" max="28" value="{{$data['reset_date']}}"  name="reset_date" id='reset_date'   data-type="currency" placeholder="Masukkan tanggal" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Formula
                                        <i class="fa fa-question-circle tooltips" data-original-title="Rumus balance yang digunakan dalam perhitungan batas maksimal pemberian reimbursement, jika kosong akan menggunakan formula global" data-container="body"></i>
                                    </label>
                                    <div class="col-md-6">
                                          <textarea required name="value_text" id="formula" class="form-control" placeholder="Masukkan rumus perhitungan reimbursement">{{$data['value_text']??''}}</textarea>
                                          <br>
                                          <div class="row">
                                                @foreach($textreplace as $key=>$row)
                                                        <div class="col-md-4" style="margin-bottom:5px;">
                                                                <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="{{ $row['message'] }}" onClick="addFormula('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                        </div>
                                                @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
            </div>
        </div>
    </div>
@endsection