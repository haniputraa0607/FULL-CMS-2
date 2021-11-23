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
        $('#modalSurvey').click(function(){
            let note = $('#noteSurvey').val();
            let sur_note = $('#surye_note').val();
            if ($('#potential').is(":checked"))
            {
                $('#potentialModal').val('OK');
            }else{
                $('#potentialModal').val('NOT OK');
            }
            $('#surveynoteModal').val(sur_note);
            $("#noteModal").val(note);

        });
        $('.datepicker').datepicker({
            'format' : 'dd MM yyyy',
            'todayHighlight' : true,
            'autoclose' : true
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
                <span> <a href='{{ $url_title }}'>{{ $title }}</a></span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span><a href='{{ $url_sub_title }}'>{{ $sub_title }}</a></span>
                @if (!empty($list_sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @endif
            @if (!empty($list_sub_title))
            <li>
                <span>{{ $list_sub_title }}</span>
            </li>
            @endif
        </ul>
    </div><br>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">{{$sub_title}}</span>
            </div>
        </div>
       <div class="tabbable-line tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#overview" data-toggle="tab">History Close </a>
                </li>
                @if($outlet['outlet_status']!='Active')
                <li>
                    <a href="#active" data-toggle="tab"> Activate Outlet</a>
                </li>
                @endif
            </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="overview">
                @include('businessdevelopment::outlet_manage.close_temporary.overview')
            </div>
            <div class="tab-pane" id="active">
                @if($result[0]['status']=='Process'||$result[0]['status']=='Waiting')
                Terdapat Proses yang sedang berjalan
                @else
                @include('businessdevelopment::outlet_manage.close_temporary.create_active')
                @endif
            </div>
        </div>
    </div>
    </div>
    

@endsection