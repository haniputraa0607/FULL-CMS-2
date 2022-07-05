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
                <span class="caption-subject sbold uppercase font-blue">Default Fixed Incentive Salary Hair Stylist</span>
            </div>
        </div>
        <div class="tabbable-line tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#overview" data-toggle="tab"> List Default Fixed Incentive</a>
                </li>
                <li>
                    <a href="#create" data-toggle="tab">Create Default Fixed Incentive</a>
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
                                        <th class="text-nowrap text-center">Status</th>
                                        <th class="text-nowrap text-center">Type</th>
                                        <th class="text-nowrap text-center">Formula</th>
                                        <th class="text-nowrap text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($data))
                                        @foreach($data as $dt)
                                            <tr data-id="{{ $dt['id_hairstylist_group_default_fixed_incentive'] }}">
                                                <td style="text-align: center;">{{$dt['name_fixed_incentive']}}</td>
                                                <td style="text-align: center;">@if($dt['status']=="incentive") Incentive @else Salary Cut @endif</td>
                                                <td style="text-align: center;">{{$dt['type']}}</td>
                                                <td style="text-align: center;">{{$dt['formula']}}</td>
                                                <td style="text-align: center;">
                                                   <a href="{{ url('recruitment/hair-stylist/default/fixed-incentive/detail/'.$dt['id_enkripsi']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"></i> Detail</a>
                                                   <a class="btn btn-sm red btn-primary" href="{{url('recruitment/hair-stylist/default/fixed-incentive/delete/'.$dt['id_enkripsi'])}}"><i class="fa fa-trash-o"></i> Delete</a>
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
                <form class="form-horizontal" role="form" action="{{url('recruitment/hair-stylist/default/fixed-incentive/create')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Name<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Name Fixed Incentive" data-container="body"></i>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="name_fixed_incentive" value="{{old('name_fixed_incentive')}}" placeholder="Masukkan name fixed incentive" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Status<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Type fixed incentive, Single hanya satu data, Multiple banyak data detail" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <select  class="form-control select2" name="status" id="status"  data-placeholder="Select Status" required>
                                                <option></option>
                                                <option value="incentive" @if(old('status') == 'incentive') selected @endif>Incentive</option>
                                                <option value="salary_cut" @if(old('status') == 'salary_cut') selected @endif>Salary Cut</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Type<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Type fixed incentive, Single hanya satu data, Multiple banyak data detail" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <select  class="form-control" name="type" id="type" onchange="changeType()" data-placeholder="Select Type" required>
                                                <option value="Single" @if(old('type') == 'Single') selected @endif>Single</option>
                                                <option value="Multiple" @if(old('type') == 'Multiple') selected @endif>Multiple</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="formulas">
                                    <label class="col-md-4 control-label">Formula<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Outlet age dihitung dari pertama kali outlet buka data detail ada beberapa (Multiple), years of service dihitung dari masa kerja data detail ada beberapa (Multiple), monthly data detail hanya ada 1 (Single)" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <select class="form-control" name="formula" id="formula" data-placeholder="Select formula">
                                                <option value="outlet_age" @if(old('formula') == 'outlet_age') selected @endif>Outlet Age</option>
                                                <option value="years_of_service" @if(old('formula') == 'years_of_service') selected @endif>Years of service</option>
                                        </select>
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