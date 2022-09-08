<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
 
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
                                text: "You can continue to approve this ruquest employee later!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Yes, reject it!",
                                closeOnConfirm: false
                            },
                            function(){
                                $.ajax({
                                    type : "POST",
                                    url : "{{url('employee/request/reject')}}/"+id,
                                    data : {
                                        '_token' : '{{csrf_token()}}'
                                    },
                                    success : function(response) {
                                        if (response.status == 'success') {
                                            swal("Rejected!", "request employee has been rejected.", "success")
                                            location.href = "{{url('employee/request/detail')}}/"+id;
                                        }
                                        else if(response.status == "fail"){
                                            swal("Error!", "Failed to rejecte Request employee.", "error")
                                        }
                                        else {
                                            swal("Error!", "Something went wrong. Failed to reject Request employee.", "error")
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
        @if ($result['status']=='Approved' || $result['status']=='Done Approved')
        actionForm('approved', true);
        $('#real_approved_employee').show();
        @else    
        actionForm('approved', false);
        $('#real_approved_employee').hide();
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
            numberEmployee('approved_employee',state);
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
    function numberEmployee(idenity,state){
        if(state){
            var num = $('#number_of_request').val();
            for (let i = 0; i < num; i++) {
                $('#'+idenity).append(
                    '<div class="form-group">'+
                    '<label for="example-search-input" class="control-label col-md-4">Employee '+(i+1)+' '+
                    '<i class="fa fa-question-circle tooltips" data-original-title="Pilih employee ke '+(i+1)+'" data-container="body"></i></label>'+
                    '<div class="col-md-5 for_option_'+i+'">'+
                    '<select class="form-control select2 approvedForm id_employee_'+i+'" name="id_employee['+i+']" id="id_employee['+i+']" onchange="foreach_again(this.value,'+i+');" >'+
                    '<option value="" selected disabled>Select Employee</option>'+
                    '@foreach($employees as $h => $emp)'+
                    '<option id="list_option_'+i+'_{{$emp['id']}}" value="{{$emp['id']}}">{{$emp['name']}}</option>'+
                    '@endforeach'+
                    '</select>'+
                    '</div>'+
                    '</div>'
                );
                $('.select2').select2();
            }
        }else{
            $('#'+idenity).html('');
        }
    }

    function changeHS(id,no){
        var num = $('#number_of_request').val();
        for (let i = 0; i < num; i++) {
            if(i!=no){
                $('#list_option_'+i+'_'+id+'').remove();
            }
        }

    }

    function foreach_again(id,no){
        var num = $('#number_of_request').val();
        for (let i = 0; i < num; i++) {
            if(i!=no){
                var value = $('.id_employee_'+i+'').val();
                $('.for_option_'+i+'').html('');
                $('.for_option_'+i+'').append(
                    '<select class="form-control select2 approvedForm id_employee_'+i+'" name="id_employee['+i+']" id="id_employee['+i+']" onchange="foreach_again(this.value,'+i+');" >'+
                    '<option value="" selected disabled>Select Employee</option>'+
                    '@foreach($employees as $h => $emp)'+
                    '<option id="list_option_'+i+'_{{$emp['id']}}" value="{{$emp['id']}}">{{$emp['name']}}</option>'+
                    '@endforeach'+
                    '</select>'
                );
                for (let cek = 0; cek < num; cek++) {
                    let old = $('.id_employee_'+cek+'').val();
                    if(old != null){
                        $('#list_option_'+i+'_'+old+'').remove();
                    }
                }
                if(value != null){
                    $('#list_option_'+i+'_'+value+'').prop('selected',true);
                }
                $('.select2').select2();
            }
        }
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
                <span class="caption-subject font-dark sbold uppercase font-blue">Detail Request Employee</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Office Name <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama office yang membutuhkan employee" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" name="outlate_name" value="{{$result['outlet_request']['outlet_name']}}" readonly/>
                            <input type="hidden" name="id_user" value="{{ $result['id_user'] }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Department Name <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama department yang membutuhkan employee" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" name="department_name" value="{{$result['department_request']['department_name']}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Applicant <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Yang membuat permintaan" data-container="body"></i></label>
                        <div class="col-md-5 mt-2">
                            <label class="control-label"><a href="{{ $result['url_applicant'] }}">{{$result['applicant_request']['name']}}</a></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Number of Request <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah employee yang diminta oleh office" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control approvedFormTop" type="text" id="number_of_request" name="number_of_request" value="{{$result['number_of_request']}}" @if ($result['status']=='Approved'  || $result['status']=='Done Approved') readonly @endif/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Applicant Notes <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Catatan dari yang membuat permintaan" data-container="body"></i></label>
                        <div class="col-md-5">
                            <textarea name="notes" id="input-note-app" class="form-control" placeholder="Enter note here" readonly>{{ $result['notes_om'] }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Status <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Status Permintaan" data-container="body"></i></label>
                        <div class="col-md-5">
                            @if(MyHelper::hasAccess([542], $grantedFeature))
                            <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="Approved" name="status" data-off-color="default" data-off-text="@if ($result['status']=='Rejected') Rejected @else Request @endif" id="status" @if ($result['status']=='Approved'  || $result['status']=='Done Approved') checked readonly @endif>
                            @else
                                @if($result['status'] == 'Approved')
                                <span class="badge" style="background-color: #26C281; color: #ffffff">{{$result['status']}}</span>
                                @elseif($result['status'] == 'Request')
                                <span class="badge" style="background-color: #e1e445; color: #ffffff">{{$result['status']}}</span>
                                @elseif($result['status'] == 'Done Approved')
                                <span class="badge" style="background-color: #11407e; color: #ffffff">{{$result['status']}}</span>
                                @else
                                <span class="badge" style="background-color: #EF1E31; color: #ffffff">{{$result['status']}}</span>
                                @endif
                                <input type="hidden" name="status" id="status" value="{{ $result['status'] }}">
                            @endif
                        </div>
                    </div>
                    <div class="approved">
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Notes <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Catatan dari anda pada permintaan ini" data-container="body"></i></label>
                            <div class="col-md-5">
                                <textarea name="notes" id="input-note" class="form-control approvedForm" placeholder="Enter note here" @if(!MyHelper::hasAccess([542], $grantedFeature)) readonly @endif>{{ $result['notes'] }}</textarea>
                            </div>
                        </div>
                        <div id="approved_employee"></div>
                    </div>
                    @if ($result['status']=='Approved'  || $result['status']=='Done Approved')  
                    <div id="real_approved_employee">
                        @for($i=0;$i<$result['number_of_request'];$i++)
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Employee {{  $i+1 }} <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih employee ke {{  $i+1 }}" data-container="body"></i></label>
                                <div class="col-md-5 for_option_{{  $i }}">
                                    @if(MyHelper::hasAccess([542], $grantedFeature))
                                    <select class="form-control select2 selectApprove id_employee_{{  $i }}" name="id_employee[{{  $i }}]" id="id_employee[{{  $i }}]" onchange="foreach_again(this.value,{{  $i }});" >
                                        <option value="" selected>Select employee</option>  
                                        @foreach($employees as $e => $emp)
                                        <option id="list_option_{{  $i }}_{{$emp['id']}}" value="{{$emp['id']}}" @if(isset($result['id_employee'][$i])) @if($result['id_employee'][$i] == $emp['id'] ) selected @endif @endif >{{$emp['name']}}</option>
                                        @endforeach
                                    </select>
                                    @else
                                    @if(isset($result['id_employee'][$i]))
                                        @foreach($employees as $h => $emp)
                                                @if($result['id_employee'][$i] == $emp['id'])
                                                    <label for="example-search-input" class="control-label">{{ $emp['name'] }}</label>
                                                    <input type="hidden" name="id_employee[{{  $i }}]" id="id_employee[{{  $i }}]" value="{{ $result['id_employee'][$i] }}">
                                                @endif
                                        @endforeach
                                    @else
                                    <label for="example-search-input" class="control-label"> - </label>
                                    @endif
                                    @endif
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                    @endif
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn blue">Submit</button>
                            @if ($result['status']!='Rejected')
                            <a class="btn red sweetalert-reject" data-id="{{ $result['id_request_employee'] }}" data-name="{{ $result['applicant_request']['name'] }}">Reject</a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection