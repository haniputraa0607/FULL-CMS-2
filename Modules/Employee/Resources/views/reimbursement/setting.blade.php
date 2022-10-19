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
        }else{
                $("#change-type").hide();
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
        <div class="tabbable-line tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#overview" data-toggle="tab"> List Product Icount Reimbursement</a>
                </li>
                <li>
                    <a href="#create" data-toggle="tab">Create Product Icount Reimbursement</a>
                </li>
            </ul>
            <div class="tab-content">
            <div class="tab-pane active" id="overview">
                <div class="portlet-body form">
                    @yield('filter')
                    
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-blue sbold uppercase">{{ $sub_title }}</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                    <thead>
                                    <tr>
                                        <th class="text-nowrap text-center">Name</th>
                                        <th class="text-nowrap text-center">Product Icount</th>
                                        <th class="text-nowrap text-center">Code</th>
                                        <th class="text-nowrap text-center">Company Name</th>
                                        <th class="text-nowrap text-center">Value</th>
                                        <th class="text-nowrap text-center">Text</th>
                                        <th class="text-nowrap text-center">Type</th>
                                        <th class="text-nowrap text-center">Max Date</th>
                                        <th class="text-nowrap text-center">Month</th>
                                        <th class="text-nowrap text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($data))
                                        @foreach($data as $dt)
                                            <tr data-id="{{ $dt['id_employee_reimbursement_product_icount'] }}">
                                                <td style="text-align: center;">{{$dt['name']}}</td>
                                                <td style="text-align: center;">{{$dt['name_icount']}}</td>
                                                <td style="text-align: center;">{{$dt['code']}}</td>
                                                <td style="text-align: center;">{{$dt['company_type']}}</td>
                                                <td style="text-align: center;">{{number_format($dt['value']??0,0,',',',')}}</td>
                                                <td style="text-align: center;">{{$dt['value_text']}}</td>
                                                <td style="text-align: center;">{{$dt['type']}}</td>
                                                <td style="text-align: center;">{{$dt['max_approve_date']}}</td>
                                                <td style="text-align: center;">{{$dt['month']}}</td>
                                                <td style="text-align: center;">
                                                   <a href="{{ url('employee/reimbursement/setting/detail/'.$dt['id_enkripsi']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-pencil"></i> Edit</a>
                                                     <a class="btn btn-sm red btn-primary" href="{{url('employee/reimbursement/setting/delete/'.$dt['id_enkripsi'])}}"><i class="fa fa-trash-o"></i> Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" style="text-align: center">Data Not Available</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="tab-pane" id="create">
                <form class="form-horizontal" role="form" action="{{url('employee/reimbursement/setting/create')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                               <div class="form-group">
                                    <label class="col-md-4 control-label">Product Icount<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Product icount yang dapat digunakan pada reimbursement employee" data-container="body"></i>
                                    </label>
                                    <div class="col-md-5">
                                        <select  class="form-control select2" name="id_product_icount" id="id_product_icount" data-placeholder="Select Product Icount" required>
                                                <option ></option>
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
                                        <input class="form-control" name="name" id="name"  placeholder="Select Name" required>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Max Approve Date<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama yang akan keluar pada aplikasi" datroduct icount yang dapat digunakan pada cash_advance employee"a-container="body"></i>
                                    </label>
                                    <div class="col-md-5">
                                        <input type="number" min="1" max="28" class="form-control" name="max_approve_date" id="max_approve_date"  placeholder="Input Max Approve Date" required>

                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-md-4 control-label">Type<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Besaran maksimal reimbursement employee" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <select onchange="types()" name="type" id='type' placeholder="Masukkan Type" class="form-control" required>
                                            <option value="month">Monthly</option>
                                            <option value="year">Yearly</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="change-type">
                                    <label class="col-md-4 control-label">Month<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Bulan untuk reset nilai dari batas maksimal reimbursememt" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <input type="number" min="1" max="12" name="month" id='month'   placeholder="Masukkan bulan untuk reset nilai" class="form-control" />
                                     </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-md-4 control-label">Value
                                        <i class="fa fa-question-circle tooltips" data-original-title="Besaran maksimal reimbursement employee, jika kosong akan menggunakan nilai global" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <input type="text" name="value" id='value'   data-type="currency" placeholder="Masukkan value" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Formula
                                        <i class="fa fa-question-circle tooltips" data-original-title="Rumus balance yang digunakan dalam perhitungan batas maksimal pemberian reimbursement, jika kosong akan menggunakan formula global" data-container="body"></i>
                                    </label>
                                    <div class="col-md-6">
                                          <textarea name="value_text" id="formula" class="form-control" placeholder="Masukkan rumus perhitungan reimbursement"></textarea>
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
    </div>
@endsection