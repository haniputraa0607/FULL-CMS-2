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
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
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
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
     <script>
        $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });

		$(".form_datetime").datetimepicker({
			format: "d-M-yyyy hh:ii",
			autoclose: true,
			todayBtn: true,
			minuteStep:1
		});

    </script>
<script>
    function changeType() {
			if( $("#type").val()== "Type 1"){
				$("#id_hairstylist_category_loans").hide();
			}else{
				$("#id_hairstylist_category_loans").show();
				$('#id_hairstylist_category_loan').prop('required', true);
			}
		}
  $(document).ready(function () {
  
      $("#id_hairstylist_category_loans").hide();
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
                <span class="caption-subject sbold uppercase font-blue">Default Loan Hair Stylist</span>
            </div>
        </div>
        <div class="tabbable-line tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#overview" data-toggle="tab"> List Loan</a>
                </li>
                <li>
                    <a href="#create" data-toggle="tab">Create Loan</a>
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
                                        <th class="text-nowrap text-center">Code HS</th>
                                        <th class="text-nowrap text-center">Name HS</th>
                                        <th class="text-nowrap text-center">Name category</th>
                                        <th class="text-nowrap text-center">Amount</th>
                                        <th class="text-nowrap text-center">Installment</th>
                                        <th class="text-nowrap text-center">Effective Date</th>
                                        <th class="text-nowrap text-center">Type</th>
                                        <th class="text-nowrap text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($data))
                                        @foreach($data as $dt)
                                            <tr data-id="{{ $dt['id_hairstylist_loan'] }}">
                                                <td style="text-align: center;">{{$dt['user_hair_stylist_code']}}</td>
                                                <td style="text-align: center;">{{$dt['fullname']}}</td>
                                                <td style="text-align: center;">{{$dt['name_category_loan']}}</td>
                                                <td style="text-align: center;">{{number_format($dt['amount']??0,0,',',',')}}</td>
                                                <td style="text-align: center;">{{$dt['installment']}}</td>
                                                <td style="text-align: center;">{{date('d M Y',strtotime($dt['effective_date']))}}</td>
                                                <td style="text-align: center;">{{$dt['type']}}</td>
                                                <td style="text-align: center;">
                                                   <a href="{{ url('recruitment/hair-stylist/loan/detail/'.$dt['id_enkripsi']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"></i> Detail</a>
                                                   <!--<a class="btn btn-sm red btn-primary" href="{{url('recruitment/hair-stylist/loan/category/delete/'.$dt['id_enkripsi'])}}"><i class="fa fa-trash-o"></i> Delete</a>-->
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
                <form class="form-horizontal" role="form" action="{{url('recruitment/hair-stylist/loan/create')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Hair Stylist<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Name hairstylist" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <select class="form-control select2" name="id_user_hair_stylist" id="id_user_hair_stylist" data-placeholder="Select hairstylist">
                                                <option></option>
                                                @foreach($hs as $val)
                                                <option value="{{$val['id_user_hair_stylist']}}" >({{$val['user_hair_stylist_code']}}) {{$val['fullname']}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Name Category<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Name category" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <select class="form-control select2" name="id_hairstylist_category_loan" id="id_hairstylist_category_loan" data-placeholder="Select category loan">
                                                <option></option>
                                                @foreach($categorys as $list)
                                                <option value="{{$list['id_hairstylist_category_loan']}}" >{{$list['name_category_loan']}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Amount<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Besar peminjaman" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <input type="text" name="amount" id='amount' value="{{old('amount')}}" data-type="currency" placeholder="Masukkan besaran peminjaman" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Installment<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah cicilan" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <input type="number" name="installment" id='installment' value="{{old('installment')}}" min="1" placeholder="Masukkan jumlah" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Effective Date<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai pengembalian" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control datepicker" name="effective_date" id="effective_date" placeholder="Effective Date Contract" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Type<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Type" data-container="body"></i>
                                    </label>
                                    <div class="col-md-3">
                                        <select required class="form-control" name="type" id="id_hairstylist_category_loan" data-placeholder="Select category loan">
                                              <option value="Flat" >Flat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Notes</label>
                                    <div class="col-md-6">
                                        <textarea type="text" class="form-control" name="notes" id="notes" placeholder="Masukkan notes" ></textarea>
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