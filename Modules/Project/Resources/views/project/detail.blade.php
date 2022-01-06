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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        var SweetAlert = function() {
            return {
                init: function() {
                    $(".sweetalert-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname;
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let id_partner     	= $(this).data('partner');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to delete this locations?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, delete it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('businessdev/locations/delete')}}/"+id,
                                        data : {
                                            '_token' : '{{csrf_token()}}'
                                        },
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Location has been deleted.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('businessdev/partners/detail')}}/"+id_partner;
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to delete locations.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete locations.", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();
        var SweetAlertReject = function() {
            return {
                init: function() {
                    $(".sweetalert-reject").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname;
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to reject this candidate partner?",
                                    text: "You can continue to approve this candidate partner later!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, reject it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('businessdev/partners/reject')}}/"+id,
                                        data : {
                                            '_token' : '{{csrf_token()}}'
                                        },
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Rejected!", "Candidate Partner has been rejected.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('businessdev/partners/detail')}}/"+id;
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to rejecte candidate partner.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to reject candidate partner.", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();
        function totalTermin() {
            $("#total-satu").show();
            $("#total-dua").hide();
        }
        function totalTermin2() {
            $("#total-dua").show();
            $("#total-satu").hide();
            let name = $('#total-name').val();
            let email = $('#total-email').val();
            let start_date = $('#total-start-date').val();
            let end_date = $('#total-end-date').val();
            let total_date = $('#total-date').val();
            $("#rule-total-2").addClass("active");
            $("#name-total").text(function(i, origText){
                return origText + name;
            });
            $("#email-total").text(function(i, origText){
                return origText + email;
            });
            $("#start-date-total").text(function(i, origText){
                return origText + start_date;
            });
            $("#end-date-total").text(function(i, origText){
                return origText + end_date;
            });
            $("#date-total").text(function(i, origText){
                return origText + total_date;
            });
        }
        function backTotalTermin1() {
            $("#total-satu").show();
            $("#total-dua").hide();
            $("#name-total").html('Name : ');
            $("#email-total").html('Name : ');
            $("#start-date-total").html('Name : ');
            $("#end-date-total").html('Name : ');
            $("#date-total").html('Name : ');
            $("#rule-total-2").removeClass("active");
        }
        $('#modalPartner').click(function(){
            let nama = $('#input-name').val();
            let phone = $('#input-phone').val();
            let email = $('#input-email').val();
            let address = $('#input-address').val();
            let id_location = $('#input-id_location').val();
            let nameLocation = $('#input-name-location').val();
            let addressLocation = $('#input-address-location').val();
            let latitudeLocation = $('#input-latitude-location').val();
            let longitudeLocation = $('#input-longitude-location').val();
            let id_cityLocation = $('#id_cityLocation').val();
            $("#nameModal").val(nama);
            $("#phoneModal").val(phone);
            $("#emailModal").val(email);
            $("#addressModal").val(address);
            if(id_location != undefined){
                $("#id_locationModal").val(id_location);
            }
            if(nameLocation != undefined){
                $("#nameLocationModal").val(nameLocation);
            }
            if(addressLocation != undefined){
                $("#addressLocationModal").val(addressLocation);
            }
            if(latitudeLocation != undefined){
                $("#latitudeLocationModal").val(latitudeLocation);
            }
            if(longitudeLocation != undefined){
                $("#longitudeLocationModal").val(longitudeLocation);
            }
            if(id_cityLocation != undefined){
                $("#id_cityLocationModal").val(id_cityLocation);
            }

        });
        $('.datepicker').datepicker({
            'format' : 'dd MM yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });
        $(".form_datetime").datetimepicker({
			format: "dd MM yyyy hh:ii",
			autoclose: true,
			todayBtn: true,
			minuteStep:1
		});
        $('.select2').select2();
        $(document).ready(function() {
            $('#back-follow-up').hide();
            $('#input-follow-up').click(function(){
                $('#back-follow-up').show();
                $('#input-follow-up').hide();
            });
            $('#back-follow-up').click(function(){
                $('#input-follow-up').show();
                $('#back-follow-up').hide();
            });
            SweetAlert.init();
            SweetAlertReject.init();
            $('[data-switch=true]').bootstrapSwitch();
            $('#btn-submit').on('click', function(event) {
                if(document.getElementById('auto_generate_pin').checked == false){
                    if($('#pin1').val() !== $('#pin2').val()) {
                        Swal.fire(
                            "Woops!",
                            'Password didn\'t match' ,
                            "error"
                        )
                        event.preventDefault();
                        event.stopPropagation();
                    }
                }


                const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(!re.test($('#input-email').val())){
                    Swal.fire(
                        "Woops!",
                        'Format email is not valid' ,
                        "error"
                    )
                    event.preventDefault();
                    event.stopPropagation();
                }
            });
        });

        function changeLevel(value){
            if(value == 'User Franchise'){
                $("#select_outlet").show();
            }else{
                $("#select_outlet").hide();
            }
        }

        function changeResetPin() {
            if(document.getElementById('reset_pin').checked){
                $("#div_password").hide();
                $('#pin1').prop('required', false);
                $('#pin2').prop('required', false);
            }else{
                $("#div_password").show();
                $('#pin1').prop('required', true);
                $('#pin2').prop('required', true);
            }
        }

        $('#input-username').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z0-9_-]*$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            if (regex.test(str) || e.which == 8) {
                return true;
            }

            e.preventDefault();
            return false;
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
                <span class="caption-subject sbold uppercase font-blue">@if($title=='Process Project') Process Project Detail @else Project Detail @endif</span>
            </div>
        </div>
        <div class="tabbable-line tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#overview" data-toggle="tab"> Project Overview </a>
                </li>
                <li>
                    <a href="#confirmation" data-toggle="tab"> Confirmation Letter </a>
                </li>
                <li>
                    <a href="#status" data-toggle="tab"> Status Project </a>
                </li>
            </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="overview">
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form" action="{{url('project/update/detail')}}" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <input class="form-control" type="hidden" id="id_project" name="id_project" value="{{$result['id_project']}}"/>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Nama Project<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama Project" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input disabled class="form-control" type="text" id="input-name" name="name" value="{{$result['name']}}" placeholder="Enter name here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Nama Partner <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama Partner" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input disabled class="form-control" type="text" id="input-phone" name="phone" value="{{$result['name_partner']}}" placeholder="Enter phone here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Nama Lokasi <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama Lokasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input disabled class="form-control" type="email" id="input-email" name="email" value="{{$result['name_location']}}" placeholder="Enter email here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Note" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-phone" name="note" value="{{$result['note']}}" placeholder="Enter note"  @if($result['status']!='Process' ) disabled @endif />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Progres <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan address" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input disabled class="form-control" type="text" id="input-phone" name="phone" value="{{$result['progres']}}" placeholder="Enter progres"/>
                                </div>
                            </div>
                           @if($result['status']=="Success")
                           <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Link Download SPK Pembukaan Outlet<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <br>
                                        <a target="_blank" target='blank' href="{{url('project/excel/').'/'.$id_enkripsi}}"><i class="fa fa-download" style="font-size:48px"></i></a>
                                    </div>
                                </div>
                           @endif
                        </div>
                        @if($result['status']=="Process")
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-offset-4 col-md-8">
                                    <button type="submit" class="btn blue">Submit</button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>

            <div class="tab-pane" id="confirmation">
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject sbold uppercase font-black">Inisiasi Partner</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="form-body">
                                         <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Amount</label>
                                            <div class="col-md-5">
                                                <input class="form-control" disabled type="text"  value="{{"Rp " . number_format($initial['amount']??0,2,',','.')}}" placeholder="Enter location name here"/>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Tax</label>
                                            <div class="col-md-5">
                                                <input class="form-control" disabled type="text"  value="{{"Rp " . number_format($initial['tax_value']??0,2,',','.')}}" placeholder="Enter location name here"/>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Netto</label>
                                            <div class="col-md-5">
                                                <input class="form-control" disabled type="text"  value="{{"Rp " . number_format($initial['netto']??0,2,',','.')}}" placeholder="Enter location name here"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>     
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject sbold uppercase font-black">Invoice Confirmation Latter</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                     <div class="form-body">
                                         <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Amount</label>
                                            <div class="col-md-5">
                                                <input class="form-control" disabled type="text"  value="{{"Rp " . number_format($confirmation_letter['amount']??0,2,',','.')}}" placeholder="Enter location name here"/>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Tax</label>
                                            <div class="col-md-5">
                                                <input class="form-control" disabled type="text"  value="{{"Rp " . number_format($confirmation_letter['tax_value']??0,2,',','.')}}" placeholder="Enter location name here"/>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Netto</label>
                                            <div class="col-md-5">
                                                <input class="form-control" disabled type="text"  value="{{"Rp " . number_format($confirmation_letter['netto']??0,2,',','.')}}" placeholder="Enter location name here"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>

                       
                    </form>
                </div>
            </div>
            
            {{-- tab step --}}
            <div class="tab-pane" id="status">
                <div style="white-space: nowrap;">
                    <div class="portlet-body form">
                        <div class="tab-pane">
                            <div class="row">
                                <div class="col-md-3">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="@if($result['progres']=='Survey Location'||$result['status']=='Success') active @endif" @if($result['progres']==null ) style="opacity: 0.4 !important" @endif>
                                            <a data-toggle="tab" href="#survey"><i class="fa fa-cog"></i> Survey Location </a>
                                        </li>
                                        <li class="@if($result['progres']=='Desain Location' || $result['progres']==null ) active @endif" @if($result['progres']==null || $result['progres']=='Survey Location') style="opacity: 0.4 !important" @endif>
                                            <a @if($result['progres']==null || $result['progres']=='Survey Location') @else data-toggle="tab" @endif href="#desain"><i class="fa fa-cog"></i> Desain Location </a>
                                        </li>
                                        <li class="@if($result['progres']=='Contract') active @endif" @if($result['progres']==null || $result['progres']=='Desain Location' || $result['progres']=='Survey Location') style="opacity: 0.4 !important" @endif>
                                            <a @if($result['progres']==null || $result['progres']=='Desain Location' || $result['progres']=='Survey Location') @else data-toggle="tab" @endif href="#contract"><i class="fa fa-cog"></i> Contract </a>
                                        </li>
                                        <li class="@if($result['progres']=='Fit Out') active @endif" @if($result['progres']==null || $result['progres']=='Desain Location' || $result['progres']=='Survey Location'|| $result['progres']=='Contract') style="opacity: 0.4 !important" @endif>
                                            <a @if($result['progres']==null || $result['progres']=='Desain Location' || $result['progres']=='Survey Location'|| $result['progres']=='Contract') @else data-toggle="tab" @endif href="#fitout"><i class="fa fa-cog"></i> Fit Out </a>
                                        </li>
                                        <li class="@if($result['progres']=='Handover') active @endif" @if($result['progres']==null || $result['progres']=='Desain Location' || $result['progres']=='Survey Location'|| $result['progres']=='Contract'||$result['progres']=='Fit Out') style="opacity: 0.4 !important" @endif>
                                            <a @if($result['progres']==null || $result['progres']=='Desain Location' || $result['progres']=='Survey Location'|| $result['progres']=='Contract'||$result['progres']=='Fit Out') @else data-toggle="tab" @endif href="#handover"><i class="fa fa-cog"></i> Handover </a>
                                        </li>
                                        
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="tab-content">
                                        <div class="tab-pane @if($result['progres']=='Desain Location' || $result['progres']==null || $result['progres']=='Finished Follow Up') active @endif" id="desain">
                                            @include('project::project.steps.desain')
                                        </div>
                                        <div class="tab-pane @if($result['progres']=='Survey Location'||$result['status']=='Success') active @endif" id="survey">
                                            @include('project::project.steps.survey_loc')
                                        </div>
                                        <div class="tab-pane @if($result['progres']=='Contract') active @endif" id="contract">
                                            @include('project::project.steps.contract') 
                                        </div>
                                        <div class="tab-pane @if($result['progres']=='Fit Out') active @endif" id="fitout">
                                            @include('project::project.steps.fitout') 
                                        </div>
                                        <div class="tab-pane @if($result['progres']=='Handover') active @endif" id="handover">
                                            @include('project::project.steps.handover') 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    

@endsection