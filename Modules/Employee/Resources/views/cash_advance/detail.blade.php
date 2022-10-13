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
        $('.date-picker').datepicker({
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
  $(document).ready(function () {
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
     var SweetAlert = function() {
            return {
                init: function() {
                    $(".save").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let name    = $(this).data('name');
						let status    = $(this).data('status');
						let form    = $(this).data('form');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want change to status "+status.toLowerCase()+" ?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, save it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                   $.ajax({
                                        type : "POST",
                                        url : "{{url('employee/cash-advance/reject/'.$data['id_employee_cash_advance'])}}",
                                        data : {
                                            '_token' : '{{csrf_token()}}'
                                        },
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Employee Cash Advance has been rejected.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('employee/cash-advance/detail/'.$data['id_employee_cash_advance'])}}"
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to reject cash advance.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to reject cash advance.", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();
     var SweetAlertSubmit = function() {
            return {
                init: function() {
                    $(".icount").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let name    = $(this).data('name');
						let status    = $(this).data('status');
						let form    = $(this).data('form');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to request to Icount ?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, save it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    location.href = "{{url('employee/cash-advance/icount/'.$data['id_employee_cash_advance'])}}"
                                });
                        })
                    })
                }
            }
        }();
        jQuery(document).ready(function() {
            SweetAlert.init()
            SweetAlertSubmit.init()
        });
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
                <span class="caption-subject sbold uppercase font-blue">Detail Cash Advance</span>
            </div>
        </div>
        <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">{{$sub_title}}</span>
            </div>
        </div>

        <div class="tabbable-line boxless tabbable-reversed">
        	<ul class="nav nav-tabs">
                <li class="active">
                    <a href="#info" data-toggle="tab"> Info </a>
                </li>
                <li>
                    <a href="#status" data-toggle="tab"> Status Reimbursement</a>
                </li>
               
            </ul>
        </div>

		<div class="tab-content">
                    <div class="tab-pane active form" id="info">
                            <form class="form-horizontal" role="form" action="{{url('employee/cash-advance/create')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Employee</label>
                                    <div class="col-md-4 input-group">
                                        <input class="form-control" name="id_user" id="id_user" value="{{$data['user_name']??''}}" data-placeholder="Select Employee" disabled="">
                                        <input class="form-control" type="hidden" name="id_employee_cash_advance" id="id_employee_cash_advance" value="{{$data['id_employee_cash_advance']}}" data-placeholder="Select Employee" >
                                               
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Status</label>
                                    <div class="col-md-4 input-group">
                                        <input class="form-control" name="id_user" id="key" value="{{$data['status']??''}}" data-placeholder="Select Employee" disabled="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Name Product Icount</label>
                                    <div class="col-md-4 input-group">
                                        <input class="form-control" name="id_user" id="key" value="{{$data['name']??''}}" data-placeholder="Select Employee" disabled="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Price</label>
                                    <div class="col-md-4 input-group">
                                        <input type="text" name="installment" id='installment' value="{{number_format($data['price']??0,0,',',',')}}" min="1" placeholder="Masukkan jumlah" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Notes Employee</label>
                                    <div class="col-md-6 input-group">
                                        <textarea type="text" class="form-control" name="notes" id="notes" placeholder="Masukkan notes" disabled    >{{$data['notes']??''}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane " id="status">
                            <br>
                            <br>
                            <div class="row">
                                    <div class="col-md-4">
                                            <ul class="ver-inline-menu tabbable margin-bottom-10">
                                                    <li @if($data['status'] == 'Pending') class="active" @endif>
                                                            <a @if(in_array($data['status'], ['Rejected','Pending','Manager Approval','HRGA/Direktur Approval','Finance Approval','Approve','Success'])) data-toggle="tab" href="#manager" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> 
                                                                Manager Approval</a>
                                                    </li>
                                                    <li @if($data['status'] == 'Manager Approval') class="active" @endif>
                                                            <a @if(in_array($data['status'], ['Rejected','Manager Approval','HRGA/Direktur Approval','Finance Approval','Approve','Success'])) data-toggle="tab" href="#director" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> 
                                                                Director/HRGA Approval</a>
                                                    </li>
                                                    <li @if($data['status'] == 'HRGA/Direktur Approval') class="active" @endif>
                                                            <a  @if(in_array($data['status'], ['Rejected','HRGA/Direktur Approval','Finance Approval','Approve','Success'])) data-toggle="tab" href="#fat" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> 
                                                                Finance Approval</a>
                                                    </li>
                                                    <li @if($data['status'] == 'Finance Approval') class="active" @endif>
                                                            <a  @if(in_array($data['status'], ['Rejected','Finance Approval','Approve','Success'])) data-toggle="tab" href="#approved" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> 
                                                                Realisasi</a>
                                                    </li>
                                                    <li class="active">
                                                            <a  @if(in_array($data['status'], ['Rejected','Realisasi','Approve','Success'])) data-toggle="tab" href="#realisasi" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> 
                                                                Icount Callback</a>
                                                    </li>

                                            </ul>
                                    </div>
                                @foreach($data['document'] as $doc)
                                                                            <?php
                                                                                            $dataDoc[$doc['document_type']] = $doc;
                                                                            ?>
                                @endforeach
                                    <div class="col-md-8">
                                            <div class="tab-content">
                                                    <div class="tab-pane @if($data['status'] == 'Pending') active @endif" id="manager">
                                                              
                                                            @if(isset($dataDoc['Manager Approval']))
                                                                 @include('employee::cash_advance.form_manager')
                                                            @else
                                                            @if($data['id_manager']==session('id_user')||session('level')=="Super Admin")
                                                                 @include('employee::cash_advance.form_manager')
                                                            @else
                                                                Hanya Atasan Employee yang dapat merubah data 
                                                            @endif
                                                           @endif
                                                    </div>
                                                <div class="tab-pane @if($data['status'] == 'Manager Approval') active @endif" id="director">
                                                            @if(isset($dataDoc['Director Approved']))
                                                            @include('employee::cash_advance.form_director')
                                                           @else
                                                            @if(MyHelper::hasAccess([528,529], $grantedFeature)||session('level')=="Super Admin")
                                                            @include('employee::cash_advance.form_director')
                                                            @else
                                                            Hanya hak akses Director atau HRGA yang dapat merubah data 
                                                            @endif
                                                           @endif
                                                    </div>
                                                    <div class="tab-pane @if($data['status'] == 'HRGA/Direktur Approval') active @endif" id="fat">
                                                           @if(isset($dataDoc['Director Approved']))
                                                            @include('employee::cash_advance.form_finance')
                                                           @else
                                                            @if(MyHelper::hasAccess([530], $grantedFeature)||session('level')=="Super Admin")
                                                            @include('employee::cash_advance.form_finance')
                                                            @else
                                                            Hanya hak akses Finance yang dapat merubah data 
                                                            @endif
                                                           @endif
                                                           
                                                    </div>
                                                    <div class="tab-pane @if($data['status'] == 'Finance Approval') active @endif" id="approved">
                                                           @include('employee::cash_advance.form_approved')
                                                           
                                                    </div>
                                                    <div class="tab-pane active" id="realisasi">
                                                           @include('employee::cash_advance.callback')
                                                           
                                                    </div>

                                            </div>
                                    </div>
                            </div>
                    </div>
		</div>
    </div>
    </div>
@endsection