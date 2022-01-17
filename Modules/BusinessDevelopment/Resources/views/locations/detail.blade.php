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
                                                swal("Deleted!", "User Mitra has been deleted.", "success")
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
                                    title: name+"\n\nAre you sure want to reject this candidate location?",
                                    text: "You can continue to approve this candidate location later!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, reject it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('businessdev/locations/reject')}}/"+id,
                                        data : {
                                            '_token' : '{{csrf_token()}}'
                                        },
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Rejected!", "Candidate Location has been rejected.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('businessdev/locations/detail')}}/"+id;
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to rejecte candidate location.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to reject candidate location.", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();

        $('#modalPartner').click(function(){
            let namaPartner = $('#input-name-partner').val();
            let nama = $('#input-name').val();
            let address = $('#input-address').val();
            let latitude = $('#input-latitude').val();
            let longitude = $('#input-longitude').val();
            let pic_name = $('#input-pic_name').val();
            let pic_contact = $('#input-pic_contact').val();
            let id_city = $('#input-id_city').val();
            let city_name = $('#input-id_city option:selected').text();
            city_name = city_name.replace('Select City','');
            $("#namePartner-modal").val(namaPartner);
            $("#name-modal").val(nama);
            $("#address-modal").val(address);
            $("#latitude-modal").val(latitude);
            $("#longitude-modal").val(longitude);
            $("#pic_name-modal").val(pic_name);
            $("#pic_contact-modal").val(pic_contact);
            $("#id_city-modal").val(id_city);
            $("#city_name-modal").val(city_name);
        });
        $('.datepicker').datepicker({
            'format' : 'dd MM yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });
        $('.select2').select2();
        function formSurveyModal(){
            let note = $('#noteSurvey').val();
            $('#formSurvey').modal('show');
            $("#noteModal").val(note);
        }
        function onlyNumber(id){
            $(id).on("keypress keyup blur",function (event) {    
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                 if ((event.which < 48 || event.which > 57)) {
                     event.preventDefault();
                 }
            });
        }
        $(document).ready(function() {
            onlyNumber("#location_large");
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
                <span class="caption-subject sbold uppercase font-blue">@if($title=='Candidate Location') Candidate Location Detail @else Location Detail @endif</span>
            </div>
        </div>
        <div class="tabbable-line tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#overview" data-toggle="tab"> Location Overview </a>
                </li>
                @if($title=='Candidate Location') 
                    <li>
                        <a href="#status" data-toggle="tab"> Status Locations </a>
                    </li>
                @endif
            </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="overview">
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form" action="{{url('businessdev/locations/update')}}/{{$result['id_location']}}" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            {{--  <input class="form-control" type="hidden" id="id_partner" name="id_partner" value="{{$result['id_partner']}}" readonly/>  --}}
                            {{--  <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Name Partner <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama partner pemilik lokasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-name-partner" name="namePartner" value="{{$result['location_partner']['name']}}" readonly/>
                                </div>
                            </div>  --}}
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Name Location <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama Lokasi yang dimiliki partner" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-name" name="name" value="{{$result['name']}}" placeholder="Enter name location here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Address Location <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap lokasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <textarea name="address" id="input-address" class="form-control" placeholder="Enter address location here">{{$result['address']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Latitude Location <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Titik garis lintang lokasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-latitude" name="latitude" value="{{$result['latitude']}}" placeholder="Enter latitude location here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Longitude Location <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Titik garis bujur lokasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-longitude" name="longitude" value="{{$result['longitude']}}" placeholder="Enter longitude location here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">PIC Name Location <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama penanggung jawab lokasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-pic_name" name="pic_name" value="{{$result['pic_name']}}" placeholder="Enter pic_name location here" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">PIC Contact Location <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Kontak yang dapat dihubungi dari penanggung jawab lokasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-pic_contact" name="pic_contact" value="{{$result['pic_contact']}}" placeholder="Enter pic_contact location here" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">City Location <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Kota/Kabupaten lokasi berasa" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <select class="form-control select2" name="id_city" id="input-id_city" required>
                                        <option value="" selected disabled>Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city['id_city']}}" @if($result['id_city'] == $city['id_city']) selected @endif>{{$city['city_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if($title=='Location') 
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Start Date 
                                    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal lokasi mulai disahkan" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="start_date" class="datepicker form-control" name="start_date" value="{{ (!empty($result['start_date']) ? date('d F Y', strtotime($result['start_date'])) : '')}}">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">End Date 
                                    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal lokasi berhenti beroperasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="end_date" class="datepicker form-control" name="end_date" value="{{ (!empty($result['end_date']) ? date('d F Y', strtotime($result['end_date'])) : '')}}">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-offset-4 col-md-8">
                                    <button type="submit" class="btn blue">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{--  tab status  --}}

            <div class="tab-pane" id="status">
                <div style="white-space: nowrap;">
                    <div class="portlet-body form">
                        <div class="tab-pane">
                            <div class="row">
                                <div class="col-md-3">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="@if($result['step_loc']=='On Follow Up' || $result['step_loc']==null || $result['step_loc']=='Finished Follow Up') active @endif">
                                            <a data-toggle="tab" href="#follow"><i class="fa fa-cog"></i> Follow Up </a>
                                        </li>
                                        <li class="@if($result['step_loc']=='Survey Location') active @endif" @if($result['step_loc']==null || $result['step_loc']=='On Follow Up') style="opacity: 0.4 !important" @endif>
                                            <a @if($result['step_loc']==null || $result['step_loc']=='On Follow Up') @else data-toggle="tab" @endif href="#survey"><i class="fa fa-cog"></i> Survey Location </a>
                                        </li>
                                        <li class="@if($result['step_loc']=='Approved') active @endif" @if($result['step_loc']==null || $result['step_loc']=='On Follow Up' || $result['step_loc']=='Finished Follow Up') style="opacity: 0.4 !important" @endif>
                                            <a @if($result['step_loc']==null || $result['step_loc']=='On Follow Up' || $result['step_loc']=='Finished Follow Up') @else data-toggle="tab" @endif href="#approved"><i class="fa fa-cog"></i> Approved </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="tab-content">
                                        <div class="tab-pane @if($result['step_loc']=='On Follow Up' || $result['step_loc']==null || $result['step_loc']=='Finished Follow Up') active @endif" id="follow">
                                            @include('businessdevelopment::locations.steps.follow_up')
                                        </div>
                                        <div class="tab-pane @if($result['step_loc']=='Survey Location') active @endif" id="survey">
                                            @include('businessdevelopment::locations.steps.survey_loc')
                                        </div>
                                        <div class="tab-pane @if($result['step_loc']=='Approved') active @endif" id="approved">
                                            @include('businessdevelopment::locations.steps.payment')
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



    <div class="modal fade" id="candidatePartnerModal" tabindex="-1" role="dialog" aria-labelledby="candidatePartnerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="candidatePartnerModalLabel">Approve Candidate Location</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" action="{{url('businessdev/locations/update')}}/{{$result['id_location']}}" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                        <input type="hidden" name='status' value="Active">
                        <input class="form-control" type="hidden" id="id_partner" name="id_partner" value="{{$result['id_partner']}}"/>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">Nama Partner <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan Password" data-container="body"></i></label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" id="namePartner-modal" name="namePartner" value="" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">Name Location <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" id="name-modal" name="name" value="" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">Address Location <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan alamat lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <textarea name="address" id="address-modal" class="form-control" readonly></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">Latitude Location <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan latitude lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" id="latitude-modal" name="latitude" value="" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">Longitude Location <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan longitude lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" id="longitude-modal" name="longitude" value="" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">PIC Name Location <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama pic lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" id="pic_name-modal" name="pic_name" value="" required readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">PIC Contact Location <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan kontak pic lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" id="pic_contact-modal" name="pic_contact" value="" required readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">City Location <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan kota lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <input class="form-control" type="hidden" id="id_city-modal" name="id_city" value="" readonly/>
                                <input class="form-control" type="text" id="city_name-modal" value="" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">Start Date <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Mulai Lokasi disetujui" data-container="body"></i></label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" id="start_date" class="datepicker form-control" name="start_date" value="">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">End Date <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Akhir Lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" id="end_date" class="datepicker form-control" name="end_date" value="">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer form-actions">
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn blue">Submit</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-sm" id="formSurvey" tabindex="-1" role="dialog" aria-labelledby="candidatePartnerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="candidatePartnerModalLabel">Form Survey</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" action="{{url('businessdev/locations/create-follow-up')}}" method="post" enctype="multipart/form-data">
                    @if (isset($formSurvey) && !empty($formSurvey))
                    <div class="form-body">
                        <input type="hidden" name="id_partner" value="{{$result['location_partner']['id_partner']}}">
                        <input type="hidden" name="id_location" value="{{$result['id_location']}}">
                        <input type="hidden" name='follow_up' id="followUpModal" value="Survey Location">
                        <input type="hidden" name='note' id="noteModal" value="">
                        <div class="form-group">
                            <label for="example-search-input" class="col-form-label col-md-6">Survey Location Title <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Judul dari survey lokasi yang telah dilakukan" data-container="body"></i></label>
                            <div class="col-md-6">
                                <input class="form-control" type="text" id="title" name="title" value="" placeholder="Enter title here" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="col-form-label col-md-6">Survey Location Date <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal survey lokasi dilakukan" data-container="body"></i></label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" id="survey_date" class="datepicker form-control" name="survey_date" value="{{ old('survey_date') ?? (!empty($result['survey_date']) ? date('d F Y', strtotime($result['start_date'])) : '')}}">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="col-form-label col-md-6">Surveyor Name <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Nama dari yang melakukan survey terhadap lokasi" data-container="body"></i></label>
                            <div class="col-md-6">
                                <input class="form-control" type="text" id="surveyor" name="surveyor" value="" placeholder="Enter surveyor here" required/>
                            </div>
                        </div>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($formSurvey as $x => $form)
                            <div class="form-group">
                                <div class="col-md-10">
                                    <label for="example-search-input"><span class="sbold uppercase font-black">{{ $form['category'] }}</span></label>
                                    <input type="hidden" name="category[{{ $i }}][cat]" value="{{ $form['category'] }}">
                                </div>
                            </div>
                            @foreach ($form["question"] as $x => $q )
                            <div class="form-group">
                                <div class="col-md-10">
                                    <input type="hidden" name="category[{{ $i }}][question][{{ $x }}][question]" value="{{ $q }}">
                                    <label for="example-search-input">{{ $q }}</label>
                                </div>
                                <div class="col-md-2">
                                    <select name="category[{{ $i }}][question][{{ $x }}][answer]" class="form-control input-sm select2" aria-placeholder="" required>
                                        <option value="" selected disabled> </option>
                                        <option value="a">A</option>
                                        <option value="b">B</option>
                                        <option value="c">C</option>
                                        <option value="d">D</option>
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        @php
                            $i++;
                        @endphp
                        @endforeach
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="example-search-input">Survey Potential
                                    <i class="fa fa-question-circle tooltips" data-original-title="Hasil dari survey yang dilakukan, lokasi yang diajukan diterima atau tidak" data-container="body"></i><br>
                            </div>
                            <div class="col-md-7">
                                <div class="input-icon right">  
                                    <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="OK" name="survey_potential" data-off-color="default" data-off-text="NOT OK" id="potential">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="example-search-input">Survey Note <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Catatan dari survey lokasi yang telah dilakukan" data-container="body"></i><br>
                            </div>
                            <div class="col-md-8">
                                <textarea style="height: 80px" name="surye_note" id="surye_note" class="form-control" placeholder="Enter survey note here" required></textarea>
                            </div>
                        </div> 
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="example-search-input">Import Attachment
                                    <i class="fa fa-question-circle tooltips" data-original-title="Unggah file jika ada lampiran yang diperlukan" data-container="body"></i><br>
                                    <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                            </div>
                            <div class="col-md-8" >
                                <div class="fileinput fileinput-new text-left" data-provides="fileinput">
                                    <div class="input-group input-small">
                                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                            <span class="fileinput-filename"> </span>
                                        </div>
                                        <span class="input-group-addon btn default btn-file">
                                                    <span class="fileinput-new"> Select file </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" class="file" name="import_file" id="attSurv">
                                                </span>
                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> X </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                        <center>
                            Form Survey for this brand has not been set yet
                        </center>
                    @endif
                    <div class="modal-footer form-actions">
                        {{ csrf_field() }}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        @if (isset($formSurvey) && !empty($formSurvey))
                        <button type="submit" class="btn blue">Submit</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection