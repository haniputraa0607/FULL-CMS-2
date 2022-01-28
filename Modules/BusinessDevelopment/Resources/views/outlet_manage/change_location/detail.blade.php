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
        .zoom-in {
			cursor: zoom-in;
            border: 1px solid;
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        $('.datepicker').datepicker({
            'format' : 'dd MM yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });
    </script>
    <script>
        var SweetAlertReject = function() {
            return {
                init: function() {
                    $(".sweetalert-reject").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname;
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        $(this).click(function() {
                            swal({
                                    title: "Are you sure want to reject this change location outlet?",
                                    text: "You can't continue to approve this change location outlet!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, reject it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('/businessdev/partners/outlet/change_location/reject')}}/"+id,
                                        data : {
                                            '_token' : '{{csrf_token()}}'
                                        },
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Rejected!", "Change location outlet has been rejected.", "success")
                                                location.reload();
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to reject outlet change location.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to reject outlet change location.", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();
      
        $(document).ready(function() {
            SweetAlertReject.init();
          
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
                <span> <a href='{{ $url_title }}'>{{ $title }}</a></span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span><a href='{{ $url_sub_title }}'>{{ $sub_title }}</a></span>
                 @if (!empty($detail_sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @endif
             @if (!empty($detail_sub_title))
            <li>
                <span>{{ $detail_sub_title }}</span>
            </li>
            @endif
        </ul>
    </div><br>

    @include('layouts.notifications')

         <div class="col-md-3">
                <ul class="ver-inline-menu tabbable margin-bottom-10">
                    <li class="@if($result['status_steps'] == null || $result['status_steps'] =='Select Location') active @endif">
                        <a data-toggle="tab" href="#newselect"><i class="fa fa-cog"></i> Select Location </a>
                    </li>
                    <li class="@if($result['status_steps']=='Calculation') active @endif" @if($result['status_steps']==null) style="opacity: 0.4 !important" @endif>
                        <a @if($result['status_steps']==null) @else data-toggle="tab" @endif href="#newcalcu"><i class="fa fa-cog"></i> Calculation </a>
                    </li>
                    <li class="@if($result['status_steps']=='Confirmation Letter') active @endif" @if($result['status_steps']==null || $result['status_steps']=='Select Location') style="opacity: 0.4 !important" @endif>
                        <a @if($result['status_steps']==null || $result['status_steps']=='Select Location') @else data-toggle="tab" @endif href="#newsurvey"><i class="fa fa-cog"></i> Confirmation Letter </a>
                    </li>
                    <li class="@if($result['status_steps']=='Payment') active @endif" @if($result['status_steps']==null || $result['status_steps']=='Select Location' || $result['status_steps']=='Calculation') style="opacity: 0.4 !important" @endif>
                        <a @if($result['status_steps']==null || $result['status_steps']=='Select Location' || $result['status_steps']=='Calculation') || $result['status_steps']=='Confirmation Letter') @else data-toggle="tab" @endif href="#newpayment"><i class="fa fa-cog"></i> Payment </a>
                    </li>
                </ul>
        </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane @if($result['status_steps'] == null || $result['status_steps']=='Select Location') active @endif" id="newselect">
                        @include('businessdevelopment::outlet_manage.change_location.select') 
                    </div>
                    <div class="tab-pane @if($result['status_steps']=='Calculation') active @endif" id="newcalcu">
                        @include('businessdevelopment::outlet_manage.change_location.calcu')
                    </div>
                    <div class="tab-pane @if($result['status_steps']=='Confirmation Letter') active @endif" id="newsurvey">
                        @include('businessdevelopment::outlet_manage.change_location.confirmation')
                    </div>
                    <div class="tab-pane @if($result['status_steps']=='Payment') active @endif" " id="newpayment">
                        @include('businessdevelopment::outlet_manage.change_location.payment')
                    </div>
                </div>
            </div>
    
@endsection