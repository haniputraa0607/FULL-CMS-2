<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

    $user_request = false;
    if(session('id') == $result['id_request']){
        $user_request = true;
    }

    if(MyHelper::hasAccess([550], $grantedFeature)){
        $user_request = true;
    }

    $user_approve = false;
	if(MyHelper::hasAccess([552], $grantedFeature)){
        $user_approve = true;
    }

    $disabled = true;
    if($user_request || $user_approve){
        $disabled = false;
    }
    if($result['status'] == 'Rejected' || $result['status'] == 'Provided'){
        $disabled = true;
    }
 ?>
 
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-minicolors/jquery.minicolors.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
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
    $('.date_picker').datepicker({
        'format' : 'd MM yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    });
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
                                title: "Request by "+name+"\n\nAre you sure want to reject this design request?",
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
                                    url : "{{url('employee/design-request/reject')}}/"+id,
                                    data : {
                                        '_token' : '{{csrf_token()}}'
                                    },
                                    success : function(response) {
                                        if (response.status == 'success') {
                                            swal("Rejected!", "Design request has been rejectd.", "success")
                                            SweetAlertReject.init()
                                            location.href = "{{url('employee/design-request/detail')}}/"+id;
                                        }
                                        else if(response.status == "fail"){
                                            swal("Error!", "Failed to reject design request.", "error")
                                        }
                                        else {
                                            swal("Error!", "Something went wrong. Failed to reject partner.", "error")
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
        
        $('[data-switch=true]').bootstrapSwitch();
        $(document).ready(function () {
            $('.colorpicker').minicolors({
                format: 'hex',
                theme: 'bootstrap'
            })
        });
    });

    function changeStatus(val){
        if(val=='Pending'){
            $('#div_approved').hide();
            $('#estimated_date').prop('required',false);
            $('#div_finished').hide();
            $('#design_path').prop('required',false);
            $('#finished_note').prop('required',false);
        }else if(val=='Approved'){
            $('#div_approved').show();
            $('#estimated_date').prop('required',true);
            $('#div_finished').hide();
            $('#design_path').prop('required',false);
            $('#finished_note').prop('required',false);
        }else if(val=='Finished' || val=='Done Finished'){
            $('#div_approved').show();
            $('#estimated_date').prop('required',true);
            $('#div_finished').show();
            $('#design_path').prop('required',true);
            $('#finished_note').prop('required',true);
        }
    }

    function submitDesignReq(){
        var status = $('#status').val();
        if(status == 'Finished' || status == 'Done Finished'){
            var file = $('.fileinput-filename').html()
            if(file != ''){
                $('#design_path').prop('required',false);
            }else{
                $('#design_path').prop('required',true);
            }
        }

        var data = $('#form-update-design').serialize();
        
        if (!$('form#form-update-design')[0].checkValidity()) {
            toastr.warning("Incompleted Data. Please fill blank input.");
        }else{
            $('form#form-update-design').submit();
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
                <span class="caption-subject font-dark sbold uppercase font-blue">Detail Design Request</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="form-update-design">
                <div class="form-body">
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Title <span class="required" aria-required="true">*</span> 
                            <i class="fa fa-question-circle tooltips" data-original-title="Judul dari permintaan desain" data-container="body"></i></label>
                        <div class="col-md-4">
							<input type="text" id="title" name="title" placeholder="Title" class="form-control" value ="{{ $result['title'] ?? ''}}" required @if($disabled) disabled @endif />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Required Date <span class="required" aria-required="true">*</span> 
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal kebutuhan desain" data-container="body"></i></label>
                        <div class="col-md-4">
    						<div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form-control date_picker" name="required_date" id="required_date" required placeholder="Required Date Approved" value="{{ (!empty($result['required_date']) ? date('d F Y', strtotime($result['required_date'])) : '')}}" @if($disabled) disabled @endif>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Required Notes <span class="required" aria-required="true">*</span> 
                            <i class="fa fa-question-circle tooltips" data-original-title="Catatan dari kebutuhan desain" data-container="body"></i></label>
                        <div class="col-md-5">
                            <textarea name="required_note" id="required_note" class="form-control" placeholder="Enter required note here" required @if($disabled) disabled @endif>{{ $result['required_note'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Status <span class="required" aria-required="true">*</span> 
                            <i class="fa fa-question-circle tooltips" data-original-title="Status permintaan desain yang akan diubah" data-container="body"></i></label>
                        <div class="col-md-5">
                            <select class="form-control select2" name="status" id="status" required onchange="changeStatus(this.value)" @if($disabled) disabled @endif>
                                <option value="" selected disabled>Select Status</option>  
                                @if ($result['status']=='Pending' && ($user_request || $user_approve))
                                    <option value="Pending" @if ($result['status'] == 'Pending') selected @endif>Pending</option>
                                @endif
                                @if (($result['status']=='Pending' || $result['status']=='Approved') && $user_approve)
                                    <option value="Approved" @if ($result['status'] == 'Approved') selected @endif>Approve</option>
                                @endif
                                @if (($result['status']=='Approved' || $result['status']=='Finished') && $user_approve)
                                    <option value="Finished" @if ($result['status'] == 'Finished') selected @endif>Finish</option>
                                @endif
                                @if (($result['status']=='Finished' || $result['status']=='Done Finished') && $user_approve)
                                    <option value="Done Finished" @if ($result['status'] == 'Done Finished') selected @endif>Done Finish</option>
                                @endif
                                @if (($result['status']=='Done Finished' || $result['status']=='Provided') && $user_request)
                                    <option value="Provided" @if ($result['status'] == 'Provided') selected @endif>Provide</option>
                                @endif
                                @if ($result['status']=='Rejected')
                                    <option value="Rejected" @if ($result['status'] == 'Rejected') selected @endif>Rejected</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div  id="div_approved" @if($result['status'] == 'Pending') hidden @endif>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Estimated Date <span class="required" aria-required="true">*</span> 
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal estimasi desain selesai" data-container="body"></i></label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <div class="input-group">
                                        <input type="text" class="form-control date_picker" name="estimated_date" id="estimated_date" placeholder="Estimated Finish Date" value="{{ (!empty($result['estimated_date']) ? date('d F Y', strtotime($result['estimated_date'])) : '')}}" @if($disabled || !$user_approve) disabled @endif>
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($result['status'] != 'Pending')
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Approver
                                <i class="fa fa-question-circle tooltips" data-original-title="User yang menyetujui permintaan desain" data-container="body"></i></label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <div class="input-group">
                                        <label for="example-search-input" class="control-label">
                                            {{ $result['approve']['name'] }}
                                        <label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div id="div_finished" @if($result['status'] == 'Pending' || $result['status'] == 'Approved') hidden @endif>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Design <span class="required" aria-required="true">*</span> 
                                <i class="fa fa-question-circle tooltips" data-original-title="File Desain yang diminta" data-container="body"></i></label>
                            <div class="col-md-4">
                                @if ($result['status']=='Done Finished' || $result['status'] == 'Rejected' || $result['status'] == 'Provided') 
                                <label for="example-search-input" class="control-label">
                                    @if(isset($result['design_path']))
                                    <a href="{{ $result['design_path'] }}">Link Download Design</a>
                                    @else
                                    File Not Found 
                                    @endif
                                <label>
                                @else
                                <div class="fileinput fileinput-new text-left" data-provides="fileinput">
                                    <div class="input-group input-large">
                                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                            <span class="fileinput-filename"> @if (isset($result['design_path'])) {{ $result['design_path'] }} @endif</span>
                                        </div>
                                        <span class="input-group-addon btn default btn-file">
                                                    <span class="fileinput-new"> Select file </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" class="file" name="design_path" id="design_path" @if($disabled || !$user_approve) disabled @endif>
                                                </span>
                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Finished Notes <span class="required" aria-required="true">*</span> 
                                <i class="fa fa-question-circle tooltips" data-original-title="Catatan dari kebutuhan desain telah diselesai" data-container="body"></i></label>
                            <div class="col-md-5">
                                <textarea name="finished_note" id="finished_note" class="form-control" placeholder="Enter finished note here" @if($disabled || !$user_approve) disabled @endif>{{ $result['finished_note'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 text-center">
                            @if(!$disabled)
                            <a onclick="submitDesignReq()" class="btn blue">Submit</a>
                            @if ($result['status']!='Rejected')
                            <a class="btn red sweetalert-reject" data-id="{{ $result['id_design_request'] }}" data-name="{{ $result['request']['name'] }}">Reject</a>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection