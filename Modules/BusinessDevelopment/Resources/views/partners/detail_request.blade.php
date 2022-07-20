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
                <span class="caption-subject sbold uppercase font-blue">Approve Request Update Data Partner</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{url('businessdev/partners/request-update/update')}}/{{$result['id_partners_log']}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                  <div class="portlet light" style="margin-bottom: 0; padding-bottom: 0">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject sbold uppercase font-black">Original Data Partner</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Partner Name <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Original Partner Name" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="old_name" name="old_name" value="{{$result['original_data']['name']}}" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Partner Phone <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Original Partner phone" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="old_phone" name="old_phone" value="{{$result['original_data']['phone']}}" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Partner Email <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Original Partner email" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="old_email" name="old_email" value="{{$result['original_data']['email']}}" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Partner Name <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Original Partner Name" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <textarea name="old_address" id="old_address" class="form-control" readonly>{{$result['original_data']['address']}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject sbold uppercase font-black">Request Data Partner</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="form-body">
                            <input type="hidden" name="id_partner" value="{{ $result['id_partner'] }}">
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">New Partner Name <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Original Partner Name" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="name" name="name" value="{{$result['update_name']}}" placeholder="The new partner name"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">New Partner Phone <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Original Partner phone" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="phone" name="phone" value="{{$result['update_phone']}}" placeholder="The new partner phone"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">New Partner Email <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Original Partner email" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="email" name="email" value="{{$result['update_email']}}" placeholder="The new partner email"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">New Partner Name <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Original Partner Name" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <textarea name="address" id="address" class="form-control" placeholder="The new partner addre">{{$result['update_address']}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-4 col-md-8">
                            @if ($result['update_status']=='process')
                            <button type="submit" class="btn blue">Approve</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection