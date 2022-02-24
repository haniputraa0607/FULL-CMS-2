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
        
        function formSurveyModal(){
            let note = $('#noteSurvey').val();
            $('#formSurvey').modal('show');
            $("#noteModal").val(note);
        }
        $('.datepicker').datepicker({
            'format' : 'dd MM yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });
        
        $('.select2').select2();
        function number(id){
            $(id).inputmask("remove");
            $(id).inputmask({
                mask: "9999 9999 999999",
                removeMaskOnSubmit: true,
                placeholder:"",
                prefix: "",
                //digits: 0,
                // groupSeparator: '.',
                rightAlign: false,
                greedy: false,
                autoGroup: true,
                digitsOptional: false,
            });
        }
        function onlyNumber(id){
            $(id).on("keypress keyup blur",function (event) {    
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                 if ((event.which < 48 || event.which > 57)) {
                     event.preventDefault();
                 }
            });
        }
        function isEmail(id_email) {
            email = $(id_email).val();
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(regex.test(email)) {
                $('#invalidEmail').remove();
                return true;
            }else{
                $('#col-email').append('<div class="invalid-feedback text-danger" id="invalidEmail">Invalid Format Email.</div>');
                return false;
            }
        }
        $('#submitUpdate').click(function(){
            if(isEmail("#input-email")==false){
                return false
            }
        });
        $(document).ready(function() {
            visible()
            var sharing_value = {{$result["sharing_value"]}}
            $('#sharing_value').val(sharing_value);
            number("#input-phone");
            number("#input-mobile");
            number("#mobile");
            onlyNumber("#input-beneficiary_account");
            onlyNumber("#location_large");
            isEmail("#input-email");
            $('.numberonly').inputmask("remove");
            $('.numberonly').inputmask({
                removeMaskOnSubmit: true, 
				placeholder: "",
				alias: "currency", 
				digits: 0, 
				rightAlign: false,
				max: '999999999999999',
                prefix : "",
            });
            $('#back-follow-up').hide();
            $('#input-follow-up').click(function(){
                $('#back-follow-up').show();
                $('#input-follow-up').hide();
            });
            $('#back-follow-up').click(function(){
                $('#input-follow-up').show();
                $('#back-follow-up').hide();
            });

            $('#back-survey-loc').hide();
            $('#input-survey-loc').click(function(){
                $('#back-survey-loc').show();
                $('#input-survey-loc').hide();
            });
            $('#back-survey-loc').click(function(){
                $('#input-survey-loc').show();
                $('#back-survey-loc').hide();
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
                <span class="caption-subject sbold uppercase font-blue">@if($title=='Candidate Partner') Candidate Partner Detail @else Partner Detail @endif</span>
            </div>
        </div>
        <div class="tabbable-line tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#overview" data-toggle="tab"> Partner Overview </a>
                </li>
                @if($title=='Partner') 
                    <li>
                        <a href="#document" data-toggle="tab"> Partner Document </a>
                    </li>
                    @if(MyHelper::hasAccess([342], $grantedFeature))
                    <li>
                        <a href="#locations" data-toggle="tab"> Partner Locations </a>
                    </li>
                    @endif
                    @if(MyHelper::hasAccess([351,352], $grantedFeature))
                    <li>
                        <a href="#bank" data-toggle="tab"> Partner Bank Account </a>
                    </li>
                    <li>
                        <a href="#manage" data-toggle="tab"> Manage Partner </a>
                    </li>
                    @endif
                    <li>
                        <a href="#resetpass" data-toggle="tab"> Reset PIN </a>
                    </li>
                @endif
                    <li>
                        <a href="#status" data-toggle="tab"> Status Partner </a>
                    </li>
                @if($title=='Partner') 
                    <li>
                        <a href="#newloc" data-toggle="tab"> New Location </a>
                    </li>
                @endif
            </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="overview">
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form" action="{{url('businessdev/partners/update')}}/{{$result['id_partner']}}" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Title <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Badan usaha perusahaan partner (PT/CV/Persero/dll)" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-title" name="title" value="{{$result['title']}}" placeholder="Enter title here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Name <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama perusahaan/instansi yang menjalin kontrak kerja sama dengan IXOBOX" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-name" name="name" value="{{$result['name']}}" placeholder="Enter name here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Contact Person <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Perwakilan dari perusahaan/instansi yang selalu dapat dihubungi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-cp" name="cp" value="{{$result['contact_person']}}" placeholder="Enter contact person here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Contact Person Gender <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Jenis kelamin dari contact person" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <select name="gender" class="form-control input-sm select2" placeholder="Select Gender" required>
                                        <option value="" selected disabled>Select Gender</option>
                                        <option value="Man" @if(isset($result['gender'])) @if($result['gender'] == 'Man') selected @endif @endif>Man</option>
                                        <option value="Woman" @if(isset($result['gender'])) @if($result['gender'] == 'Woman') selected @endif @endif>Woman</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Phone <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon perusahaan/instansi yang dapat dihubungi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-phone" name="phone" value="{{$result['phone']}}" placeholder="Enter phone here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Mobile <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon partner yang terintegrasi ke whats app, jika tidak diisi default nomor telepon yang terdaftar sebelumnya" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-mobile" name="mobile" value="{{$result['mobile']}}" placeholder="Enter mobile here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Email <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Alamat email perusahaan/instansi yang dapat dihubungi" data-container="body"></i></label>
                                <div class="col-md-5" id="col-email">
                                    <input class="form-control" type="email" id="input-email" name="email" value="{{$result['email']}}" placeholder="Enter email here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Address <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap perusahaan/instansi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <textarea name="address" id="input-address" class="form-control" placeholder="Enter address here">{{$result['address']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Notes <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Catatan tentang perusahaan/instansi partner" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <textarea name="notes" id="input-notes" class="form-control" placeholder="Enter notes here">{{$result['notes']}}</textarea>
                                </div>
                            </div>
                            {{--  @if ($title=='Candidate Partner' && !empty($result['partner_locations']))
                            <div class="portlet light" style="margin-bottom: 0; padding-bottom: 0">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject sbold uppercase font-black">Candidate Location</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <input type="hidden" value="{{$result['partner_locations'][0]['id_location']??''}}" name="id_location" id="input-id_location">
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Location Name <span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Nama calon lokasi yang diajukan oleh perusahaan/instansi" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" id="input-name-location" name="nameLocation" value="{{$result['partner_locations'][0]['name']??''}}" placeholder="Enter location name here"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Location Address <span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap calon lokasi yang diajukan" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <textarea name="addressLocation" id="input-address-location" class="form-control" placeholder="Enter location name here">{{$result['partner_locations'][0]['address']??''}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Location Latitude <span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Garis lintang dari calon lokasi yang diajukan" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" id="input-latitude-location" name="latitudeLocation" value="{{$result['partner_locations'][0]['latitude']??''}}" placeholder="Enter location name here"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Location Longitude <span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Garis bujur dari calon lokasi yang diajukan" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" id="input-longitude-location" name="longitudeLocation" value="{{$result['partner_locations'][0]['longitude']??''}}" placeholder="Enter location name here"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Location City <span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Kota/Kabupaten dari calon lokasi" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <select class="form-control select2" name="id_cityLocation" id="id_cityLocation" required>
                                                    <option value="" selected disabled>Select City</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city['id_city']}}" @if($result['partner_locations'][0]['id_city']??'' == $city['id_city']) selected @endif>{{$city['city_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            @endif  --}}

                            @if($title=='Partner')
                            <input type="hidden" value="on" name="status">
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Start Date <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai menjadi partner atau tanggal kerja sama dimulai" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="start_date" class="datepicker form-control" name="start_date" value="{{ (!empty($result['start_date']) ? date('d F Y', strtotime($result['start_date'])) : '')}}" >
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">End Date <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal berakhir menjadi partner atau tanggal kerja sama selesai" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="end_date" class="datepicker form-control" name="end_date" value="{{ (!empty($result['end_date']) ? date('d F Y', strtotime($result['end_date'])) : '')}}" >
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
                                    <button type="submit" id="submitUpdate" class="btn blue">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- tab 2 --}}
            <div class="tab-pane" id="locations">
                <div class="portlet-body form">
                    <div style="white-space: nowrap;">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Created At</th>
                                    <th class="text-nowrap text-center">Name Location</th>
                                    <th class="text-nowrap text-center">Address</th>
                                    <th class="text-nowrap text-center">Status</th>
                                    @if(MyHelper::hasAccess([343,344,345], $grantedFeature))
                                    <th class="text-nowrap text-center">Action</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($result['partner_locations']))
                                        @foreach($result['partner_locations'] as $location)
                                            <tr data-id="{{ $location['id_location'] }}">
                                                <td>{{date('d F Y H:i', strtotime($location['created_at']))}}</td>
                                                <td>{{$location['name']}}</td>
                                                <td>{{$location['address']}}</td>
                                                <td>
                                                    @if($location['status'] == 'Active')
                                                        <span class="badge" style="background-color: #26C281; color: #ffffff">{{$location['status']}}</span>
                                                    @elseif($location['status'] == 'Candidate')
                                                        <span class="badge" style="background-color: #e1e445; color: #ffffff">{{$location['status']}}</span>
                                                    @else
                                                        <span class="badge" style="background-color: #EF1E31; color: #ffffff">{{$location['status']}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(MyHelper::hasAccess([343,344], $grantedFeature))
                                                    <a href="{{ url('businessdev/locations/detail-status/'.$location['id_location']) }}" class="btn btn-sm green text-nowrap"><i class="fa fa-pencil"></i> Log Status</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(MyHelper::hasAccess([343,344], $grantedFeature))
                                                    <a href="{{ url('businessdev/locations/detail/'.$location['id_location']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-pencil"></i> Edit</a>
                                                    @endif
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

            {{-- tab 3 --}}
            <div class="tab-pane" id="bank">
                <div style="white-space: nowrap;">
                    <div class="portlet-body form">
                        @if ($result['id_bank_account'])
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/update-bank')}}/{{$result['id_bank_account']}}" method="post" enctype="multipart/form-data">
                        @else
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/create-bank')}}" method="post" enctype="multipart/form-data">
                        @endif
                            <div class="form-body">
                                <input type="hidden" name="id_partner" id="id_partner" value="{{$result['id_partner']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Bank Name <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama bank" data-container="body"></i></label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" name="id_bank_name" id="id_bank_name" required>
                                            <option value="" selected disabled>Select Bank Name</option>
                                            @foreach($bankName as $b)
                                                <option value="{{$b['id_bank_name']}}" @if(isset($result['partner_bank_account']))@if($result['partner_bank_account']['id_bank_name'] == $b['id_bank_name']) selected @endif @endif>{{$b['bank_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Beneficiary Name <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama pemilik rekening" data-container="body"></i></label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="input-beneficiary_name" name="beneficiary_name" value="<?php if(isset($result['partner_bank_account'])) echo $result['partner_bank_account']['beneficiary_name'] ?>" placeholder="Enter beneficiary name" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Beneficiary Account <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nomor rekening partner" data-container="body"></i></label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="input-beneficiary_account" name="beneficiary_account" value="<?php if(isset($result['partner_bank_account'])) echo $result['partner_bank_account']['beneficiary_account'] ?>" placeholder="Enter beneficiary name" required/>
                                    </div>
                                </div>
                            </div>
                            @if(MyHelper::hasAccess([352], $grantedFeature))
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
            </div>

            {{-- tab 4 --}}
            <div class="tab-pane" id="manage">
                <div style="white-space: nowrap;">
                    <div class="portlet-body form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-black">Partner Becomes Ixobox</span>
                                        </div>
                                    </div> 
                                    <div class="portlet-body form">
                                        <a class="btn btn-primary" href="{{$url_partners_becomes_ixobox}}" >Go to The Form</a>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-sm-6">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-black">Partner Closure Permanent</span>
                                        </div>
                                    </div> 
                                    <div class="portlet-body form">
                                        <a class="btn btn-primary" href="{{$url_partners_close_total}}" >Go to The Form</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-black">Partner Closure Temporary</span>
                                        </div>
                                    </div> 
                                    <div class="portlet-body">
                                        <a class="btn btn-primary" href="{{$url_partners_close_temporary}}" >Go to The Form</a>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-sm-6">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-black">Manage Outlet</span>
                                        </div>
                                    </div> 
                                    <div class="portlet-body">
                                        <a class="btn btn-primary" href="{{$url_outlet}}">Go to The Form</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>

            {{--  manage tab 4  --}}

            {{--  tab change  --}}
            <div class="tab-pane" id="change">
                @include('businessdevelopment::partners.manage.change')
            </div>

            {{--  tab change  --}}
            <div class="tab-pane" id="closure">
                @include('businessdevelopment::partners.manage.closure')
            </div>

            {{--  tab change  --}}
            <div class="tab-pane" id="tempo">
                @include('businessdevelopment::partners.manage.tempo')
            </div>

            {{--  tab change  --}}
            <div class="tab-pane" id="exchange">
                @include('businessdevelopment::partners.manage.exchange')
            </div>

            {{--  end of manage tab 4  --}}



            {{-- tab 5 --}}
            <div class="tab-pane" id="resetpass">
                <div style="white-space: nowrap;">
                    <div class="portlet-body form">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/reset-pin')}}/{{$result['id_partner']}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">New PIN <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukkan pin baru untuk partner" data-container="body"></i></label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="password" id="input-new-pin" name="new-pin"  placeholder="Enter new pin" maxlength="6" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Confirm PIN <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Ketik ulang pin baru untuk konfirmasi" data-container="body"></i></label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="password" id="input-confirm-pin" name="confirm-pin"  placeholder="Reenter new pin" maxlength="6" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Your PIN <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukkan pin anda" data-container="body"></i></label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="password" id="input-your-pin" name="your-pin"  placeholder="Enter your pin" maxlength="6" required/>
                                    </div>
                                </div>
                            </div>
                            @if(MyHelper::hasAccess([342], $grantedFeature))
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
            </div>

            {{-- tab step --}}
            <div class="tab-pane" id="status">
                <div style="white-space: nowrap;">
                    <div class="portlet-body form">
                        <div class="tab-pane">
                            <div class="row">
                                <div class="col-md-3">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="@if($result['status_steps']=='On Follow Up' || $result['status_steps']==null || $result['status_steps']=='Finished Follow Up') active @endif">
                                            <a data-toggle="tab" href="#follow"><i class="fa fa-cog"></i> Follow Up </a>
                                        </li>
                                        <li class="@if($result['status_steps']=='Input Data Partner') active @endif" @if($result['status_steps']==null || $result['status_steps']=='On Follow Up') style="opacity: 0.4 !important" @endif>
                                            <a @if($result['status_steps']==null || $result['status_steps']=='On Follow Up') @else data-toggle="tab" @endif href="#input"><i class="fa fa-cog"></i> Input Data Partner </a>
                                        </li>
                                        <li class="@if($result['status_steps']=='Survey Location' || $result['status_steps']=='Finished Survey Location') active @endif" @if($result['status_steps']==null || $result['status_steps']=='On Follow Up' || $result['status_steps']=='Finished Follow Up') style="opacity: 0.4 !important" @endif>
                                            <a @if($result['status_steps']==null || $result['status_steps']=='On Follow Up' || $result['status_steps']=='Finished Follow Up') @else data-toggle="tab" @endif href="#survey"><i class="fa fa-cog"></i> Survey Location </a>
                                        </li>
                                        <li class="@if($result['status_steps']=='Select Location') active @endif" @if($result['status_steps']==null || $result['status_steps']=='On Follow Up' || $result['status_steps'] =='Finished Follow Up' || $result['status_steps']=='Input Data Partner' || $result['status_steps']=='Survey Location') style="opacity: 0.4 !important" @endif>
                                            <a @if($result['status_steps']==null || $result['status_steps']=='On Follow Up' || $result['status_steps']=='Finished Follow Up' || $result['status_steps']=='Input Data Partner' || $result['status_steps']=='Survey Location') @else data-toggle="tab" @endif href="#select"><i class="fa fa-cog"></i> Select Location </a>
                                        </li>
                                        <li class="@if($result['status_steps']=='Calculation') active @endif" <a @if($result['status_steps']=='Select Location' || $result['status_steps']=='Calculation' || $result['status_steps']=='Confirmation Letter' || $result['status_steps']=='Payment') @else style="opacity: 0.4 !important" @endif>
                                            <a @if($result['status_steps']=='Select Location' || $result['status_steps']=='Calculation' || $result['status_steps']=='Confirmation Letter' || $result['status_steps']=='Payment') data-toggle="tab" @endif href="#calcu"><i class="fa fa-cog"></i> Calculation </a>
                                        </li>
                                        <li class="@if($result['status_steps']=='Confirmation Letter') active @endif" <a @if($result['status_steps']=='Calculation' || $result['status_steps']=='Confirmation Letter' || $result['status_steps']=='Payment') @else style="opacity: 0.4 !important" @endif>
                                            <a @if($result['status_steps']=='Calculation' || $result['status_steps']=='Confirmation Letter' || $result['status_steps']=='Payment') data-toggle="tab" @endif href="#confirm"><i class="fa fa-cog"></i> Confirmation Letter </a>
                                        </li>
                                        <li class="@if($result['status_steps']=='Payment') active @endif" @if($result['status_steps']=='Confirmation Letter' || $result['status_steps']=='Payment') @else style="opacity: 0.4 !important" @endif>
                                            <a @if($result['status_steps']=='Confirmation Letter' || $result['status_steps']=='Payment') data-toggle="tab" @endif href="#payment"><i class="fa fa-cog"></i> Payment </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="tab-content">
                                        <div class="tab-pane @if($result['status_steps']=='On Follow Up' || $result['status_steps']==null || $result['status_steps']=='Finished Follow Up') active @endif" id="follow">
                                            @include('businessdevelopment::partners.steps.follow_up')
                                        </div>
                                        <div class="tab-pane @if($result['status_steps']=='Input Data Partner') active @endif" id="input">
                                            @include('businessdevelopment::partners.steps.input')
                                        </div>
                                        <div class="tab-pane @if($result['status_steps']=='Survey Location' || $result['status_steps']=='Finished Survey Location') active @endif" id="survey">
                                            @include('businessdevelopment::partners.steps.survey_loc')
                                        </div>
                                        <div class="tab-pane @if($result['status_steps']=='Select Location') active @endif" id="select">
                                            @include('businessdevelopment::partners.steps.select') 
                                        </div>
                                        <div class="tab-pane @if($result['status_steps']=='Calculation') active @endif" id="calcu">
                                            @include('businessdevelopment::partners.steps.calcu')
                                        </div>
                                        <div class="tab-pane @if($result['status_steps']=='Confirmation Letter') active @endif" id="confirm">
                                            @include('businessdevelopment::partners.steps.confirmation')
                                        </div>
                                        <div class="tab-pane @if($result['status_steps']=='Payment') active @endif" id="payment">
                                            @include('businessdevelopment::partners.steps.payment')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--  tab new location  --}}
            <div class="tab-pane" id="newloc">
                <div style="white-space: nowrap;">
                    <div class="portlet-body form">
                        <div class="tab-pane">
                            <div class="row">
                                <?php 
                                    if($result['partner_new_step'])
                                    {
                                        foreach($result['partner_new_step'] as $key => $new_steps){
                                            $index_step = $new_steps['index'];
                                            $new_location = $new_steps['follow_up'];
                                        }
                                        if($new_location == 'Payment'){
                                            $index_step = $index_step+1;
                                            $new_location = null;
                                        }
                                    }else{
                                        $index_step = 1;
                                        $new_location = null;
                                    }
                                ?>
                                <div class="col-md-3">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="@if($new_location == null || $new_location =='Select Location') active @endif">
                                            <a data-toggle="tab" href="#newselect"><i class="fa fa-cog"></i> Select Location </a>
                                        </li>
                                        <li class="@if($new_location=='Calculation') active @endif" @if($new_location==null) style="opacity: 0.4 !important" @endif>
                                            <a @if($new_location==null) @else data-toggle="tab" @endif href="#newcalcu"><i class="fa fa-cog"></i> Calculation </a>
                                        </li>
                                        <li class="@if($new_location=='Confirmation Letter') active @endif" @if($new_location==null || $new_location=='Select Location') style="opacity: 0.4 !important" @endif>
                                            <a @if($new_location==null || $new_location=='Select Location') @else data-toggle="tab" @endif href="#newsurvey"><i class="fa fa-cog"></i> Confirmation Letter </a>
                                        </li>
                                        <li class="@if($new_location=='Payment') active @endif" @if($new_location==null || $new_location=='Select Location' || $new_location=='Calculation') style="opacity: 0.4 !important" @endif>
                                            <a @if($new_location==null || $new_location=='Select Location' || $new_location=='Calculation') @else data-toggle="tab" @endif href="#newpayment"><i class="fa fa-cog"></i> Payment </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="tab-content">
                                        <div class="tab-pane @if($new_location == null || $new_location=='Select Location') active @endif" id="newselect">
                                            @include('businessdevelopment::partners.new_steps.select') 
                                        </div>
                                        <div class="tab-pane @if($new_location=='Calculation') active @endif" id="newcalcu">
                                            @include('businessdevelopment::partners.new_steps.calcu')
                                        </div>
                                        <div class="tab-pane @if($new_location=='Confirmation Letter') active @endif" id="newsurvey">
                                            @include('businessdevelopment::partners.new_steps.confirmation')
                                        </div>
                                        <div class="tab-pane" id="newpayment">
                                            @include('businessdevelopment::partners.new_steps.payment')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- tab document --}}
            <div class="tab-pane" id="document">
                <div class="portlet-body form">
                    <div style="white-space: nowrap;">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-dark sbold uppercase font-yellow">Confirmation Letter</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                    <thead>
                                    <tr>
                                        <th class="text-nowrap text-center">Created At</th>
                                        <th class="text-nowrap text-center">No Letter</th>
                                        <th class="text-nowrap text-center">Location</th>
                                        <th class="text-nowrap text-center">Attachment</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($result['partner_confirmation']))
                                            @foreach($result['partner_confirmation'] as $confirmation_letter)
                                                <tr data-id="{{ $confirmation_letter['id_confirmation_letter'] }}">
                                                    <td>{{date('d F Y H:i', strtotime($confirmation_letter['created_at']))}}</td>
                                                    <td>{{$confirmation_letter['no_letter']}}</td>
                                                    @php
                                                        if(!empty($result['partner_locations'])){
                                                            foreach($result['partner_locations'] as $loc){
                                                                if($loc['id_location']==$confirmation_letter['id_location']){
                                                                    $name_loc = $loc['name'];
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    <td>{{$name_loc}}</td>
                                                    <td>
                                                        <a href="{{ $confirmation_letter['attachment']??'' }}">Download Confirmation Letter</a>
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
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-dark sbold uppercase font-yellow">Form Survey</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                    <thead>
                                    <tr>
                                        <th class="text-nowrap text-center">Created At</th>
                                        <th class="text-nowrap text-center">Surveyor</th>
                                        <th class="text-nowrap text-center">Location</th>
                                        <th class="text-nowrap text-center">Attachment</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($result['partner_survey']))
                                            @foreach($result['partner_survey'] as $form_survey)
                                                <tr data-id="{{ $form_survey['id_form_survey'] }}">
                                                    <td>{{date('d F Y H:i', strtotime($form_survey['created_at']))}}</td>
                                                    <td>{{$form_survey['surveyor']}}</td>
                                                    @php
                                                    if(!empty($result['partner_locations'])){
                                                        foreach($result['partner_locations'] as $loc){
                                                            if($loc['id_location']==$form_survey['id_location']){
                                                                $name_loc = $loc['name'];
                                                            }
                                                        }
                                                    }
                                                    @endphp
                                                    <td>{{$name_loc}}</td>
                                                    <td>
                                                        <a href="{{ $form_survey['attachment']??'' }}">Download Form Survey</a>
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
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-dark sbold uppercase font-yellow">Surat Perintah Kerja</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                    <thead>
                                    <tr>
                                        <th class="text-nowrap text-center">Date</th>
                                        <th class="text-nowrap text-center">No SPK</th>
                                        <th class="text-nowrap text-center">Location</th>
                                        <th class="text-nowrap text-center">Attachment</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($result['partner_locations']))
                                            @foreach($result['partner_locations'] as $spk)
                                                @if (!empty($spk['no_spk']))
                                                <tr>
                                                    <td>{{date('d F Y H:i', strtotime($spk['date_spk']))}}</td>
                                                    <td>{{$spk['no_spk']}}</td>
                                                    <td>{{$spk['name']}}</td>
                                                    <td>
                                                        <a target="_blank" target='blank' href="{{url('businessdev/partners/generate-spk').'/'.$result['id_partner'].'/'.$spk['id_location']}}">Download SPK</a>
                                                    </td>
                                                </tr>
                                                @endif
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
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-dark sbold uppercase font-yellow">Legal Agreement</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                    <thead>
                                    <tr>
                                        <th class="text-nowrap text-center">Created At</th>
                                        <th class="text-nowrap text-center">No Letter</th>
                                        <th class="text-nowrap text-center">Location</th>
                                        <th class="text-nowrap text-center">Attachment</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($result['partner_legal_agreement']))
                                            @foreach($result['partner_legal_agreement'] as $legal)
                                                <tr data-id="{{ $legal['id_legal_agreement'] }}">
                                                    <td>{{date('d F Y H:i', strtotime($legal['created_at']))}}</td>
                                                    <td>{{$legal['no_letter']}}</td>
                                                    @php
                                                    if(!empty($result['partner_locations'])){
                                                        foreach($result['partner_locations'] as $loc){
                                                            if($loc['id_location']==$legal['id_location']){
                                                                $name_loc = $loc['name'];
                                                            }
                                                        }
                                                    }
                                                    @endphp
                                                    <td>{{$name_loc}}</td>
                                                    <td>
                                                        <a href="{{ $legal['attachment']??'' }}">Download Legal Agreement</a>
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
            
        </div>
    </div>
    
    <div class="modal fade" id="candidatePartnerModal" tabindex="-1" role="dialog" aria-labelledby="candidatePartnerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="candidatePartnerModalLabel">Insert Data Partner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" action="{{url('businessdev/partners/update')}}/{{$result['id_partner']}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name='status' value="Active">
                    <input type="hidden" name='name' id="nameModal" value="">
                    <input type="hidden" name='phone' id="phoneModal" value="">
                    <input type="hidden" name='email' id="emailModal" value="">
                    <input type="hidden" name='address' id="addressModal" value="">
                    <input type="hidden" name='id_location' id="id_locationModal" value="">
                    <input type="hidden" name='nameLocation' id="nameLocationModal" value="">
                    <input type="hidden" name='addressLocation' id="addressLocationModal" value="">
                    <input type="hidden" name='latitudeLocation' id="latitudeLocationModal" value="">
                    <input type="hidden" name='longitudeLocation' id="longitudeLocationModal" value="">
                    <input type="hidden" name='id_cityLocation' id="id_cityLocationModal" value="">
                    <div class="form-body">
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">Ownership Status <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih Ownership Status" data-container="body"></i></label>
                            <div class="col-md-5">
                                <select name="ownership_status" class="form-control input-sm select2" placeholder="Ownership Status">
                                    <option value="" selected disabled>Select Ownership Status</option>
                                    <option value="Central" @if(isset($result['ownership_status'])) @if($result['ownership_status'] == 'Central') selected @endif @endif>Central</option>
                                    <option value="Partner" @if(isset($result['ownership_status'])) @if($result['ownership_status'] == 'Partner') selected @endif @endif>Partner</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">Cooperation Scheme<span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih Cooperation Scheme" data-container="body"></i></label>
                            <div class="col-md-5">
                                <select name="cooperation_scheme" class="form-control input-sm select2" placeholder="Cooperation Scheme">
                                    <option value="" selected disabled>Select Cooperation Scheme</option>
                                    <option value="Revenue Sharing" @if(isset($result['cooperation_scheme'])) @if($result['cooperation_scheme'] == 'Revenue Sharing') selected @endif @endif>Revenue Sharing</option>
                                    <option value="Management Fee" @if(isset($result['cooperation_scheme'])) @if($result['cooperation_scheme'] == 'Management Fee') selected @endif @endif>Management Fee</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">Bank Account<span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih Bank Account" data-container="body"></i></label>
                            <div class="col-md-5">
                                <select name="id_bank_account" class="form-control input-sm select2" placeholder="Bank Account">
                                    <option value="" selected disabled>Select Bank Account</option>
                                    @foreach($bank as $b)
                                    <option value="{{$b['id_bank_account']}}" @if($result['id_bank_account'] == $b['id_bank_account']) selected @endif>{{$b['id_bank_account']}} - {{$b['beneficiary_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">Start Date <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Mulai menjadi Partner" data-container="body"></i></label>
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
                            <label for="example-search-input" class="control-label col-md-5">End Date <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Berakhir menjadi Partner" data-container="body"></i></label>
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
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-5">PIN <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan pin" data-container="body"></i></label>
                            <div class="col-md-5">
                                <input class="form-control" type="password" id="input-pin" name="pin" value="" placeholder="Enter pin here" maxlength="6"/>
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
                <form class="form-horizontal" role="form" action="{{url('businessdev/partners/create-follow-up')}}" method="post" enctype="multipart/form-data">
                @if (isset($formSurvey) && !empty($formSurvey))
                <div class="form-body">
                    <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                    <input type="hidden" name="id_location" value="{{$result['partner_locations'][0]['id_partner']??''}}">
                    <input type="hidden" name='follow_up' id="followUpModal" value="Survey Location">
                    <input type="hidden" name='note' id="noteModal" value="">
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