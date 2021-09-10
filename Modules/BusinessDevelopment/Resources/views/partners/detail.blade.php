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
        $('.select2').select2();
        $(document).ready(function() {
            SweetAlert.init();
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
        @if($title=='Partner') <div class="tabbable-line tabbable-full-width">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#overview" data-toggle="tab"> Partner Overview </a>
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
            @endif
        </ul>
        @endif
        <div class="tab-content">
            <div class="tab-pane active" id="overview">
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form" action="{{url('businessdev/partners/update')}}/{{$result['id_partner']}}" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Name <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-name" name="name" value="{{$result['name']}}" placeholder="Enter name here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Phone <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan phone" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-phone" name="phone" value="{{$result['phone']}}" placeholder="Enter phone here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Email <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan email" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="email" id="input-email" name="email" value="{{$result['email']}}" placeholder="Enter email here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Address <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan address" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <textarea name="address" id="input-address" class="form-control" placeholder="Enter address here">{{$result['address']}}</textarea>
                                </div>
                            </div>
                            @if ($title=='Candidate Partner' && !empty($result['partner_locations']))
                            <div class="portlet light" style="margin-bottom: 0; padding-bottom: 0">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject sbold uppercase font-black">Candidate Location</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <input type="hidden" value="{{$result['partner_locations'][0]['id_location']}}" name="id_location" id="input-id_location">
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Location Name <span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Nama Calon Lokasi" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" id="input-name-location" name="nameLocation" value="{{$result['partner_locations'][0]['name']}}" placeholder="Enter location name here"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Location Address <span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Address Calon Lokasi" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <textarea name="addressLocation" id="input-address-location" class="form-control" placeholder="Enter location name here">{{$result['partner_locations'][0]['address']}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Location Latitude <span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Latitude Calon Lokasi" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" id="input-latitude-location" name="latitudeLocation" value="{{$result['partner_locations'][0]['latitude']}}" placeholder="Enter location name here"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Location Longitude <span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Longitude Calon Lokasi" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" id="input-longitude-location" name="longitudeLocation" value="{{$result['partner_locations'][0]['longitude']}}" placeholder="Enter location name here"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Location City <span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Kota Calon Lokasi" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <select class="form-control select2" name="id_cityLocation" id="id_cityLocation" required>
                                                    <option value="" selected disabled>Select City</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city['id_city']}}" @if($result['partner_locations'][0]['id_city'] == $city['id_city']) selected @endif>{{$city['city_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            @endif

                            @if ($title=='Candidate Partner')
                            <div class="portlet light" style="margin-bottom: 0; padding-top: 0">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject sbold uppercase font-black">Status Candidate</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    @endif
                                    <div class="form-group">
                                        <label for="example-search-input" class="control-label col-md-4">@if($title=='Candidate Partner') Approve Candidate @else Status @endif<span class="required" aria-required="true">*</span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih status partner" data-container="body"></i></label>
                                        <div class="col-md-5">
                                            @if($title=='Candidate Partner')
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#candidatePartnerModal" id="modalPartner">
                                                Insert Data Partner
                                            </button>
                                            @else
                                            <input data-switch="true" type="checkbox" name="status" data-on-text="Active" data-off-text="Inactive" {{$result['status'] ==  'Active' ? 'checked' : ''}}/>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($title=='Candidate Partner')
                                </div>
                            </div>
                            @endif
                            
                            @if($title=='Partner')
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Ownership Status <span class="required" aria-required="true">*</span>
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
                                <label for="example-search-input" class="control-label col-md-4">Coopertaion Scheme<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih Coopertaion Scheme" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <select name="cooperation_scheme" class="form-control input-sm select2" placeholder="Coopertaion Scheme">
                                        <option value="" selected disabled>Select Cooperation Scheme</option>
                                        <option value="Profit Sharing" @if(isset($result['cooperation_scheme'])) @if($result['cooperation_scheme'] == 'Profit Sharing') selected @endif @endif>Profit Sharing</option>
                                        <option value="Management Fee" @if(isset($result['cooperation_scheme'])) @if($result['cooperation_scheme'] == 'Management Fee') selected @endif @endif>Management Fee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Start Date <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Mulai menjadi Partner" data-container="body"></i></label>
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
                                    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Berakhir menjadi Partner" data-container="body"></i></label>
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
                                    <button type="submit" class="btn blue">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        {{-- tab 2 --}}
            <div class="tab-pane" id="locations">
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
                                                    <a href="{{ url('businessdev/locations/detail/'.$location['id_location']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-pencil"></i> Edit</a>
                                                    @endif
                                                    @if(MyHelper::hasAccess([345], $grantedFeature))
                                                    <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $location['id_location'] }}" data-name="{{ $location['name'] }}" data-partner="{{ $location['id_partner'] }}"><i class="fa fa-trash-o"></i> Delete</a>
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

            {{-- tab 3 --}}
            <div class="tab-pane" id="bank">
                <div style="white-space: nowrap;">
                    @if ($result['id_bank_account'])
                    <div class="portlet-body form">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/update-bank')}}/{{$result['id_bank_account']}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Bank Name <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih Bank" data-container="body"></i></label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" name="id_bank_name" id="id_bank_name" required>
                                            <option value="" selected disabled>Select Bank Name</option>
                                            @foreach($bankName as $b)
                                                <option value="{{$b['id_bank_name']}}" @if($result['partner_bank_account']['id_bank_name'] == $b['id_bank_name']) selected @endif>{{$b['bank_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Beneficiary Name <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama penerima" data-container="body"></i></label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="input-beneficiary_name" name="beneficiary_name" value="{{$result['partner_bank_account']['beneficiary_name']}}" placeholder="Enter beneficiary name"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Beneficiary Account <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukkan akun penerima" data-container="body"></i></label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="input-beneficiary_account" name="beneficiary_account" value="{{$result['partner_bank_account']['beneficiary_account']}}" placeholder="Enter beneficiary name"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Beneficiary Alias <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama alias penerima" data-container="body"></i></label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="input-beneficiary_alias" name="beneficiary_alias" value="{{$result['partner_bank_account']['beneficiary_alias']}}" placeholder="Enter beneficiary alias"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Beneficiary Email <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukkan email penerima" data-container="body"></i></label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="input-beneficiary_email" name="beneficiary_email" value="{{$result['partner_bank_account']['beneficiary_email']}}" placeholder="Enter beneficiary email"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Send Email to <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih metode kirim email" data-container="body"></i></label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" name="send_email_to" id="send_email_to" >
                                            <option value="">Select Email</option>
                                            <option value="Email Outlet" @if($result['partner_bank_account']['send_email_to'] == 'Email Outlet') selected @endif>Email Outlet</option>
                                            <option value="Email Bank" @if($result['partner_bank_account']['send_email_to'] == 'Email Bank') selected @endif>Email Bank</option>
                                        </select>
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
                    @else
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr><th colspan="10" style="text-align: center">Data Not Available</th></tr>
                        </thead>
                    </table>
                    @endif
                </div>
            </div>
        </div>
        @if($title=='Partner') </div> @endif
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
                            <label for="example-search-input" class="control-label col-md-5">Coopertaion Scheme<span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih Coopertaion Scheme" data-container="body"></i></label>
                            <div class="col-md-5">
                                <select name="cooperation_scheme" class="form-control input-sm select2" placeholder="Coopertaion Scheme">
                                    <option value="" selected disabled>Select Cooperation Scheme</option>
                                    <option value="Profit Sharing" @if(isset($result['cooperation_scheme'])) @if($result['cooperation_scheme'] == 'Profit Sharing') selected @endif @endif>Profit Sharing</option>
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
                            <label for="example-search-input" class="control-label col-md-5">Password <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan Password" data-container="body"></i></label>
                            <div class="col-md-5">
                                <input class="form-control" type="password" id="input-password" name="password" value="" placeholder="Enter password here"/>
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

@endsection