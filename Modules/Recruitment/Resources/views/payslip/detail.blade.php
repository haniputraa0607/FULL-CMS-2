@include('employee::income.payslip.filter')
<?php
use App\Lib\MyHelper;
$configs    		= session('configs');
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main-closed')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
    	.middle-center {
            vertical-align: middle!important;
            text-align: center;
        }
        .middle-left {
            vertical-align: middle!important;
            text-align: left;
        }
        .paginator-right {
            display: flex;
            justify-content: flex-end;
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
        var table;

        var SweetAlert = function() {
            return {
                init: function() {
                    $(".sweetalert-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        var data = {
                            '_token' : '{{csrf_token()}}',
                            'id_employee':id
                                        };
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to reject this employee?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, reject it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('employee/reject/data')}}",
                                        data : data,
                                        success : function(response) {
                                            console.log(data)
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Request Update has been deleted.", "success")
                                                SweetAlert.init()
                                                window.location.reload(true);
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to delete partner.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete partner.", "error")
                                            }
                                        }
                                    });
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
    @yield('child-script')
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
<div class="portlet light bordered">
		<div class="portlet-body form">
                    <form role="form" class="form-horizontal" action="{{url('recruitment/hair-stylist/default/fixed-incentive/update')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-6"><div class="form-body">
                                      <div class="form-group">
                                        <div class="col-md-4">Name</div>
                                        <div class="col-md-6">
                                           : {{$data['fullname']??''}}
                                        </div>
                                       </div>
                                      <div class="form-group">
                                        <div class="col-md-4">Email</div>
                                        <div class="col-md-6">
                                           : {{$data['email']??''}}
                                        </div>
                                       </div>
                                      <div class="form-group">
                                        <label class="col-md-4">Phone</label>
                                        <div class="col-md-6">
                                           : {{$data['phone_number']??''}}
                                        </div>
                                       </div>
                                      <div class="form-group">
                                        <label class="col-md-4">Outlet</label>
                                        <div class="col-md-6">
                                           : {{$data['outlet_name']??''}}
                                        </div>
                                       </div>
                            </div></div>
                            <div class="col-sm-6"><div class="form-body">
                                      <div class="form-group">
                                        <label class="col-md-4">Amount</label>
                                        <div class="col-md-6">
                                            : Rp {{number_format($data['amount']??0,0,',',',')}}
                                        </div>
                                       </div>
                                      <div class="form-group">
                                        <label class="col-md-4">Periode</label>
                                        <div class="col-md-6">
                                            : {{$data['periode']??''}}
                                        </div>
                                       </div>
                                      <div class="form-group">
                                        <label class="col-md-4">Start Date</label>
                                        <div class="col-md-6">
                                            : {{$data['start_date']??''}}
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-md-4">End Date</label>
                                        <div class="col-md-6">
                                            : {{$data['end_date']??''}}
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
	</div>
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
                            <th class="text-nowrap text-center">Source</th>
                            <th class="text-nowrap text-center">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data['hairstylist_income_details']))
                            @foreach($data['hairstylist_income_details'] as $dt)
                                <tr data-id="{{ $dt['id_hairstylist_income_detail'] }}">
                                    <td class="text-nowrap text-center">{{$dt['source']}}</td>
                                    <td class="text-nowrap text-center">{{number_format($dt['amount']??0,0,',',',')}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" style="text-align: center">Data Not Available</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
        </div>
        </div>
    </div>



@endsection