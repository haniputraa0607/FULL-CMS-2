@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-minicolors/jquery.minicolors.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-color-pickers.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    $('.select2').select2();
    function changeSelect(){
        setTimeout(function(){
            $(".select2").select2({
                placeholder: "Search"
            });
        }, 100);
    }
    var SweetAlertReject = function() {
        return {
            init: function() {
                $(".sweetalert-reject").each(function() {
                    var token  	= "{{ csrf_token() }}";
                    var pathname = window.location.pathname;
                    let id     	= $(this).data('id');
                    let name    = $(this).data('name');
                    $(this).click(function() {
                        swal({
                                title: "Request by "+name+"\n\nAre you sure want to reject this request?",
                                text: "You can continue to approve this ruquest hair stylist later!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Yes, reject it!",
                                closeOnConfirm: false
                            },
                            function(){
                                $.ajax({
                                    type : "POST",
                                    url : "{{url('recruitment/hair-stylist/request/reject')}}/"+id,
                                    data : {
                                        '_token' : '{{csrf_token()}}'
                                    },
                                    success : function(response) {
                                        if (response.status == 'success') {
                                            swal("Rejected!", "request hair stylist has been rejected.", "success")
                                            SweetAlert.init()
                                            location.href = "{{url('recruitment/hair-stylist/request/detail')}}/"+id;
                                        }
                                        else if(response.status == "fail"){
                                            swal("Error!", "Failed to rejecte Request hair stylist.", "error")
                                        }
                                        else {
                                            swal("Error!", "Something went wrong. Failed to reject Request hair stylist.", "error")
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
        @if ($result['status']=='Approved')
        actionForm('approved', true);
        $('#real_approved_hs').show();
        @else    
        actionForm('approved', false);
        $('#real_approved_hs').hide();
        @endif
        $('[data-switch=true]').bootstrapSwitch();
        $(document).ready(function () {
            $('.colorpicker').minicolors({
                format: 'hex',
                theme: 'bootstrap'
            })
        });
        $('#status').on('switchChange.bootstrapSwitch', function(event, state) {
            actionForm('approved', state);
            numberHS('approved_hs',state)
            
        });
    });
    function actionForm(identity, state) {
        if (state) {
            $('.'+identity).show();
            $('.'+identity+'Form').prop('required',true);
            $('.'+identity+'FormTop').prop('readonly',true);
        }
        else {
            $('.'+identity).hide();
            $('.'+identity+'Form').removeAttr('required');
            $('.'+identity+'FormTop').removeAttr('readonly');
            $('.'+identity+'Form').val('');
        }
    }
    function numberHS(idenity,state){
        if(state){
            var num = $('#number_of_request').val();
            for (let i = 0; i < num; i++) {
                $('#'+idenity).append(
                    '<div class="form-group">'+
                    '<label for="example-search-input" class="control-label col-md-4">Hair Stylist '+(i+1)+' <span class="required" aria-required="true">*</span>'+
                    '<i class="fa fa-question-circle tooltips" data-original-title="Original Partner Name" data-container="body"></i></label>'+
                    '<div class="col-md-5">'+
                    '<select class="form-control select2 approvedForm" name="id_hs['+i+']" id="id_hs['+i+']" onchange="changeHS(this.value);" required>'+
                    '<option value="" selected disabled>Select Hair Stylist</option>'+
                    '@foreach($hairstylist as $h => $hs)'+
                    '<option value="{{$hs['id_user_hair_stylist']}}" @if($result['id_hs'][0] ==$hs['id_user_hair_stylist'] ) selected @endif>{{$hs['fullname']}}</option>'+
                    '@endforeach'+
                    '</select>'+
                    '</div>'+
                    '</div>'
                );
                $('.select2').select2();
            }
        }else{
            $("#approved_hs").html('');
        }
    }

    function changeHS(name){
        
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
                <span class="caption-subject font-dark sbold uppercase font-blue">Detail Request Hair Stylist</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('recruitment/hair-stylist/request/update/'.$result['id_request_hair_stylist']) }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Outlet Name <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Original Partner Name" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="old_name" name="outlate_name" value="{{$result['outlet_request']['outlet_name']}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Applicant <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Original Partner Name" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control approvedFormTop" type="text" id="old_name" name="applicant" value="{{$result['applicant']}}" @if ($result['status']=='Approved') readonly @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Number of Request <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Original Partner Name" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control approvedFormTop" type="text" id="number_of_request" name="number_of_request" value="{{$result['number_of_request']}}" @if ($result['status']=='Approved') readonly @endif/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Status <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Original Partner Name" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="Approve" name="status" data-off-color="default" data-off-text="@if ($result['status']=='Rejected') Rejected @else Request @endif" id="status" @if ($result['status']=='Approved') checked @endif>
                        </div>
                    </div>
                    <div class="approved">
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Notes <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Original Partner Name" data-container="body"></i></label>
                            <div class="col-md-5">
                                <textarea name="notes" id="input-note" class="form-control approvedForm" placeholder="Enter note here">{{ $result['notes'] }}</textarea>
                            </div>
                        </div>
                        <div id="approved_hs"></div>
                        <div id="real_approved_hs">
                            @for($i=0;$i<$result['number_of_request'];$i++)
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Hair Stylist {{ $i+1 }} <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Original Partner Name" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <select class="form-control select2 approvedForm" name="id_hs[{{ $i }}]" id="id_hs[{{ $i }}]" onchange="changeHS(this.value);" required>
                                        <option value="" selected disabled>Select Hair Stylist</option>
                                        @foreach($hairstylist as $h => $hs)
                                        <option value="{{$hs['id_user_hair_stylist']}}" @if($result['id_hs'][$i] == $hs['id_user_hair_stylist'] ) selected @endif>{{$hs['fullname']}}</option>
                                        @endforeach     
                                    </select>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn blue">Submit</button>
                            @if ($result['status']!='Rejected')
                            <a class="btn red sweetalert-reject" data-id="{{ $result['id_request_hair_stylist'] }}" data-name="{{ $result['applicant'] }}">Reject</a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection