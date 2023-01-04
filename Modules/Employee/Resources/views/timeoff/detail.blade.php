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
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
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
        $('.timepicker').timepicker({
            autoclose: true,
            minuteStep: 1,
            showSeconds: false,
        });
    </script>
    <script>
        $('.select2').select2();
        function changeSelect(){
            setTimeout(function(){
                $(".select2").select2({
                    placeholder: "Search"
                });
            }, 100);
        }
        $('.datepicker').datepicker({
            'format' : 'dd MM yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });
        
        function approvedTimeOff () {
            var id_employee_time_off = {{$result['id_employee_time_off']}};
            var id_outlet = {{$result['outlet']['id_outlet']}};
            var id = {{$result['employee']['id']}};
            var start_date = $('#list_date_start').val();
            var end_date = $('#list_date_end').val();
            var time_start = $('input[type=text][name=time_start]').val();
            var time_end = $('input[type=text][name=time_end]').val();
            var use_quota_time_off = null;
            if ($('.check_quota').is(":checked"))
            {
                use_quota_time_off = 1;
            }

            var data = {
                '_token' : '{{csrf_token()}}',
                'id_employee_time_off' : id_employee_time_off,
                'id_outlet' : id_outlet,
                'id_employee' : id,
                'start_date' : start_date,
                'end_date' : end_date,
                'time_start' : time_start,
                'time_end' : time_end,
                'use_quota_time_off' : use_quota_time_off,
                'approve' : true
            };
            swal({
                    title: "Approve?",
                    text: "This employee request time off will be approved",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes, Approve this request!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type : "POST",
                        url : "{{url('employee/timeoff/update')}}/"+id_employee_time_off,
                        data : data,
                        success : function(response) {
                            if (response.status == 'success') {
                                swal("Sent!", "Employee request time off has been approved", "success")
                                location.href = "{{url('employee/timeoff/detail')}}/"+id_employee_time_off;
                            }
                            else if(response.status == "fail"){
                                swal("Error!", response.messages, "error")
                            }
                            else {
                                swal("Error!", "Something went wrong. Failed to approve employee request time off.", "error")
                            }
                        }
                    });
                }
            );
        }

        function selectMonthStart(val){
            var data = {
                'id_employee' : {{$result['employee']['id']}},
                'month' : val,
                'year' : $('#year_start').val(),
                'type_request' : 'time_off'
            };
            listDateStart(data);

        }

        function selectYearStart(val){
            var data = {
                'id_employee' : {{$result['employee']['id']}},
                'month' : $('#month_start').val(),
                'year' : val,
                'type_request' : 'time_off'
            };
            listDateStart(data);
        }

        function listDateStart(data){
            data['_token'] = '{{csrf_token()}}';
            var list = '<option></option>';
            $.ajax({
                type : "POST",
                url : "{{ url('employee/timeoff/list-date') }}",
                data : data,
                success: function(result){
                    if(result['status']=='success'){    
                        var new_result = jQuery.parseJSON(JSON.stringify(result['result']));
                        $('#list_date_start').empty();
                        $.each(new_result, function(i, index) {
                            list += '<option value="'+index.date+'" data-id="'+index.id_employee_schedule+'" data-timestart="'+index.time_start+'" data-timeend="'+index.time_end+'">'+index.date_format+'</option>';
                        });
                        $('#list_date_start').append(list);
                        $(".select2").select2({
                            placeholder: "Search"
                        });
                    }else if(result['status']=='fail'){
                        $('#list_date_start').empty();
                        toastr.warning(result['messages']);
                    }
                }
            });
        }

        function selectMonthEnd(val){
            var data = {
                'id_employee' : {{$result['employee']['id']}},
                'month' : val,
                'year' : $('#year_end').val(),
                'type_request' : 'time_off'
            };
            listDateEnd(data);

        }

        function selectYearEnd(val){
            var data = {
                'id_employee' : {{$result['employee']['id']}},
                'month' : $('#month_end').val(),
                'year' : val,
                'type_request' : 'time_off'
            };
            listDateEnd(data);
        }

        function listDateEnd(data){
            data['_token'] = '{{csrf_token()}}';
            var list = '<option></option>';
            $.ajax({
                type : "POST",
                url : "{{ url('employee/timeoff/list-date') }}",
                data : data,
                success: function(result){
                    if(result['status']=='success'){    
                        var new_result = jQuery.parseJSON(JSON.stringify(result['result']));
                        $('#list_date_end').empty();
                        $.each(new_result, function(i, index) {
                            list += '<option value="'+index.date+'" data-id="'+index.id_employee_schedule+'" data-timestart="'+index.time_start+'" data-timeend="'+index.time_end+'">'+index.date_format+'</option>';
                        });
                        $('#list_date_end').append(list);
                        $(".select2").select2({
                            placeholder: "Search"
                        });
                    }else if(result['status']=='fail'){
                        $('#list_date_end').empty();
                        toastr.warning(result['messages']);
                    }
                }
            });
        }

        function submitTimeOff(value,form) {
            var data = $(`#${form}`).serialize();
        
            if (!$(`form#${form}`)[0].checkValidity()) {
                toastr.warning("Incompleted Data. Please fill blank input.");
            }else{
                if(value=='submit'){
                    $(`form#${form}`).submit();
                }else if(value=='approve'){
                    approvedTimeOff();
                }
            }
        }

        function rejectTimeOff(value){
            var id_employee_time_off = {{$result['id_employee_time_off']}};
            swal({
                    title: "Reject?",
                    text: "This employee request time off will be reject",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, Reject this request!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type : "POST",
                        url : "{{url('employee/timeoff/reject')}}/"+id_employee_time_off,
                        data : {
                                '_token' : '{{csrf_token()}}',
                                'id_employee_time_off' : id_employee_time_off,
                                'type' : value,
                            },
                        success : function(response) {
                            if (response.status == 'success') {
                                swal("Sent!", "Employee request time off has been reject", "success")
                                location.href = "{{url('employee/timeoff/detail')}}/"+id_employee_time_off;
                            }
                            else if(response.status == "fail"){
                                swal("Error!", response.messages, "error")
                            }
                            else {
                                swal("Error!", "Something went wrong. Failed to reject employee request time off.", "error")
                            }
                        }
                    });
                }
            );
        }
    
        $(document).ready(function() {
            $('[data-switch=true]').bootstrapSwitch();
            $('.numberonly').inputmask("remove");
            $('.numberonly').inputmask({
                removeMaskOnSubmit: true, 
				placeholder: "",
				alias: "numeric", 
				rightAlign: false,
                min : '',
				max: '9999',
                prefix : "",
            });
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
                <span class="caption-subject font-dark sbold uppercase font-blue">{{ $sub_title }}</span>
            </div>
        </div>
        <div class="tabbable-line boxless tabbable-reversed">
        	<ul class="nav nav-tabs">
                <li class="active">
                    <a href="#info" data-toggle="tab"> Info </a>
                </li>
                <li>
                    <a href="#status" data-toggle="tab"> Status Time Off</a>
                </li>
               
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="info">
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Select Office <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama kantor karyawan yang akan mengajukan izin" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" placeholder="Outlet name" value="{{ $result['outlet']['outlet_name'] }}" readonly required/>
                                    <input class="form-control" type="hidden" name="id_outlet" value="{{ $result['outlet']['id_outlet'] }}" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Select Employee <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama karyawan yang akan dibuat permohonan izin" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" placeholder="Employee name" value="{{ $result['employee']['name'] }}" readonly required/>
                                    <input class="form-control" type="hidden" name="id_employee" id="list_hs"  value="{{ $result['employee']['id'] }}" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Start Date Time Off <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih tanggal karyawan akan mulai cuti" data-container="body"></i></label>
                                <div class="col-md-3">
                                    <input type="text" class="datepicker form-control" value="{{ date('d F Y', strtotime($result['start_date'])) }}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">End Date Time Off <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih tanggal karyawan akan selesai cuti" data-container="body"></i></label>
                                <div class="col-md-3">
                                    <input type="text" class="datepicker form-control" value="{{ date('d F Y', strtotime($result['end_date'])) }}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Requested By <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Permohonan dibuat oleh user ini" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" placeholder="Enter request by" value="{{ $result['request']['name'] }}" required readonly/>
                                </div>
                            </div>
                            @if (isset($result['approve']))
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Approved By <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Permohonan disetujui oleh user ini" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" placeholder="Enter request by" value="{{ $result['approve']['name'] }}" required readonly/>
                                </div>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane" id="status">
                <div class="portlet-body form">
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <ul class="ver-inline-menu tabbable margin-bottom-10">
                                <li @if($result['status'] == 'Pending') class="active" @endif>
                                    <a @if(in_array($result['status'], ['Pending','Manager Approved', 'HRGA Approved'])) data-toggle="tab" href="#manager" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Manager Approval</a>
                                </li>
                                <li @if($result['status'] == 'Manager Approved' || $result['status'] == 'HRGA Approved') class="active" @endif>
                                    <a @if(in_array($result['status'], ['Manager Approved', 'HRGA Approved'])) data-toggle="tab" href="#hrga" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> HRGA Approval</a>
                                </li>
                            </ul>
                        </div>
                        @foreach($result['documents'] ?? [] as $doc)
                        <?php
                            $dataDoc[$doc['type']] = $doc;
                        ?>
                        @endforeach
                        <div class="col-md-9">
                            <div class="tab-content">
                                <div class="tab-pane @if($result['status'] == 'Pending') active @endif" id="manager">
                                    <form class="form-horizontal" role="form" action="{{ url('employee/timeoff/update') }}/{{ $result['id_employee_time_off'] }}" method="post" enctype="multipart/form-data" id="update-time-off-1">
                                        <div class="form-body">
                                            <input class="form-control" type="hidden" name="id_outlet" value="{{ $result['outlet']['id_outlet'] }}" readonly/>
                                            <input class="form-control" type="hidden" name="id_employee" id="list_hs"  value="{{ $result['employee']['id'] }}" readonly/>
                                            <input class="form-control" type="hidden" name="type" id="type"  value="Manager Approved" readonly/>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Start Month <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk bulan mulai cuti" data-container="body"></i></label>
                                                <div class="col-md-3">
                                                    <select class="form-control select2" name="month" id="month_start" required onchange="selectMonthStart(this.value)" @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at']))) disabled @endif>
                                                        <option value="" selected disabled>Select Month</option>
                                                        <option value="1" @if(isset($result['month_start'])) @if($result['month_start'] == 1) selected @endif @endif>January</option>
                                                        <option value="2" @if(isset($result['month_start'])) @if($result['month_start'] == 2) selected @endif @endif>February</option>
                                                        <option value="3" @if(isset($result['month_start'])) @if($result['month_start'] == 3) selected @endif @endif>March</option>
                                                        <option value="4" @if(isset($result['month_start'])) @if($result['month_start'] == 4) selected @endif @endif>April</option>
                                                        <option value="5" @if(isset($result['month_start'])) @if($result['month_start'] == 5) selected @endif @endif>May</option>
                                                        <option value="6" @if(isset($result['month_start'])) @if($result['month_start'] == 6) selected @endif @endif>June</option>
                                                        <option value="7" @if(isset($result['month_start'])) @if($result['month_start'] == 7) selected @endif @endif>July</option>
                                                        <option value="8" @if(isset($result['month_start'])) @if($result['month_start'] == 8) selected @endif @endif>August</option>
                                                        <option value="9" @if(isset($result['month_start'])) @if($result['month_start'] == 9) selected @endif @endif>September</option>
                                                        <option value="10" @if(isset($result['month_start'])) @if($result['month_start'] == 10) selected @endif @endif>October</option>
                                                        <option value="11" @if(isset($result['month_start'])) @if($result['month_start'] == 11) selected @endif @endif>November</option>
                                                        <option value="12" @if(isset($result['month_start'])) @if($result['month_start'] == 12) selected @endif @endif>December</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Start Year <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk tahun mulai cuti" data-container="body"></i></label>
                                                <div class="col-md-2">
                                                    <input class="form-control numberonly" type="text" maxlength="4" id="year_start" name="year" placeholder="Enter year" value="{{ $result['year_start'] }}" required onchange="selectYearStart(this.value)" @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at']))) disabled @endif/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Start Date Time Off <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih tanggal karyawan akan mulai cuti" data-container="body"></i></label>
                                                <div class="col-md-4">
                                                    @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])))
                                                    <input type="text" class="datepicker form-control" value="{{ date('d F Y', strtotime($result['start_date'])) }}" disabled>
                                                    @else
                                                    <select class="form-control select2" name="start_date" required id="list_date_start">
                                                        <option value="" selected disabled>Select Date</option>
                                                        @foreach($result['start_list_date'] ?? [] as $d => $date)
                                                            <option value="{{$date['date']}}" data-id="{{ $date['id_employee_schedule'] }}" data-timestart="{{ $date['time_start'] }}" data-timeend="{{ $date['time_end'] }}"  @if(isset($result['start_date'])) @if(date('Y-m-d', strtotime($result['start_date'])) == date('Y-m-d', strtotime($date['date']))) selected @endif @endif> {{$date['date_format']}}</option>
                                                        @endforeach
                                                    </select>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">End Month <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk bulan selesai cuti" data-container="body"></i></label>
                                                <div class="col-md-3">
                                                    <select class="form-control select2" name="month" id="month_end" required onchange="selectMonthEnd(this.value)" @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at']))) disabled @endif>
                                                        <option value="" selected disabled>Select Month</option>
                                                        <option value="1" @if(isset($result['month_end'])) @if($result['month_end'] == 1) selected @endif @endif>January</option>
                                                        <option value="2" @if(isset($result['month_end'])) @if($result['month_end'] == 2) selected @endif @endif>February</option>
                                                        <option value="3" @if(isset($result['month_end'])) @if($result['month_end'] == 3) selected @endif @endif>March</option>
                                                        <option value="4" @if(isset($result['month_end'])) @if($result['month_end'] == 4) selected @endif @endif>April</option>
                                                        <option value="5" @if(isset($result['month_end'])) @if($result['month_end'] == 5) selected @endif @endif>May</option>
                                                        <option value="6" @if(isset($result['month_end'])) @if($result['month_end'] == 6) selected @endif @endif>June</option>
                                                        <option value="7" @if(isset($result['month_end'])) @if($result['month_end'] == 7) selected @endif @endif>July</option>
                                                        <option value="8" @if(isset($result['month_end'])) @if($result['month_end'] == 8) selected @endif @endif>August</option>
                                                        <option value="9" @if(isset($result['month_end'])) @if($result['month_end'] == 9) selected @endif @endif>September</option>
                                                        <option value="10" @if(isset($result['month_end'])) @if($result['month_end'] == 10) selected @endif @endif>October</option>
                                                        <option value="11" @if(isset($result['month_end'])) @if($result['month_end'] == 11) selected @endif @endif>November</option>
                                                        <option value="12" @if(isset($result['month_end'])) @if($result['month_end'] == 12) selected @endif @endif>December</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">End Year <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk tahun selesai cuti" data-container="body"></i></label>
                                                <div class="col-md-2">
                                                    <input class="form-control numberonly" type="text" maxlength="4" id="year_end" name="year" placeholder="Enter year" value="{{ $result['year_end'] }}" required onchange="selectYearEnd(this.value)" @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at']))) disabled @endif/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">End Date Time Off <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih tanggal karyawan akan selesai cuti" data-container="body"></i></label>
                                                <div class="col-md-4">
                                                    @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])))
                                                    <input type="text" class="datepicker form-control" value="{{ date('d F Y', strtotime($result['end_date'])) }}" disabled>
                                                    @else
                                                    <select class="form-control select2" name="end_date" required id="list_date_end">
                                                        <option value="" selected disabled>Select Date</option>
                                                        @foreach($result['end_list_date'] ?? [] as $d => $date)
                                                            <option value="{{$date['date']}}" data-id="{{ $date['id_employee_schedule'] }}" data-timestart="{{ $date['time_start'] }}" data-timeend="{{ $date['time_end'] }}"  @if(isset($result['end_date'])) @if(date('Y-m-d', strtotime($result['end_date'])) == date('Y-m-d', strtotime($date['date']))) selected @endif @endif> {{$date['date_format']}}</option>
                                                        @endforeach
                                                    </select>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Uses Quota Time Off<span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Memakai jatah cuti atau tidak" data-container="body"></i></label>
                                                <div class="col-md-3">
                                                    <input type="checkbox" class="make-switch check_quota" data-size="small" data-on-color="info" data-on-text="Yes" data-off-color="default" name='use_quota_time_off' data-off-text="No" @if($result['use_quota_time_off'] == 1) checked @endif @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at']))) disabled @endif>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Notes
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Catatan dari manager" data-container="body"></i></label>
                                                <div class="col-md-5">
                                                    <textarea class="form-control" name="notes" placeholder="Notes" @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at']))) disabled @endif>@if(isset($dataDoc['Manager Approved']['notes'])) {{$dataDoc['Manager Approved']['notes']}}  @endif</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Attachment
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Dokumen dari manager" data-container="body"></i></label>
                                                <div class="col-md-5">
                                                    @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])))
                                                        <label for="example-search-input" class="control-label">
                                                        @if(empty($dataDoc['Manager Approved']['attachment']))
                                                            No Attachment
                                                        @else
                                                            <a href="{{$dataDoc['Manager Approved']['attachment'] }} ">Link Download Attachment</a>
                                                        @endif
                                                        </label>
                                                    @else
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="input-group input-large">
                                                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                    <span class="fileinput-filename"> </span>
                                                                </div>
                                                                <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> Select file </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" name="attachment"> </span>
                                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @if (isset($result['approve']))
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Approved By <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Permohonan disetujui oleh user ini" data-container="body"></i></label>
                                                <div class="col-md-5">
                                                    <input class="form-control" type="text" placeholder="Enter request by" value="{{ $result['approve']['name'] }}" required readonly/>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="form-actions">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    @if($result['status'] == 'Pending' && (!isset($result['approve_by']) && !isset($result['reject_at'])))
                                                        <a onclick="submitTimeOff('submit','update-time-off-1')" class="btn blue" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>Submit</a>
                                                        <a onclick="rejectTimeOff('Manager Approved')" id="approve" class="btn red reject">Reject</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane @if($result['status'] == 'Manager Approved' || $result['status'] == 'HRGA Approved') active @endif" id="hrga">
                                    <form class="form-horizontal" role="form" action="{{ url('employee/timeoff/update') }}/{{ $result['id_employee_time_off'] }}" method="post" enctype="multipart/form-data" id="update-time-off-2">
                                        <div class="form-body">
                                            <input class="form-control" type="hidden" name="id_outlet" value="{{ $result['outlet']['id_outlet'] }}" readonly/>
                                            <input class="form-control" type="hidden" name="id_employee" id="list_hs"  value="{{ $result['employee']['id'] }}" readonly/>
                                            <input class="form-control" type="hidden" name="type" id="type"  value="HRGA Approved" readonly/>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Notes
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Catatan dari direktur" data-container="body"></i></label>
                                                <div class="col-md-5">
                                                    <textarea class="form-control" name="notes" placeholder="Notes" @if($result['status'] != 'Manager Approved' || (isset($result['approve_by']) || isset($result['reject_at']))) disabled @endif>@if(isset($dataDoc['HRGA Approved']['notes'])) {{$dataDoc['HRGA Approved']['notes']}}  @endif</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Attachment
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Dokumen dari direktur" data-container="body"></i></label>
                                                <div class="col-md-5">
                                                    @if($result['status'] != 'Manager Approved' || (isset($result['approve_by']) || isset($result['reject_at'])))
                                                        <label for="example-search-input" class="control-label">
                                                        @if(empty($dataDoc['HRGA Approved']['attachment']))
                                                            No Attachment
                                                        @else
                                                            <a href="{{$dataDoc['HRGA Approved']['attachment'] }} ">Link Download Attachment</a>
                                                        @endif
                                                        </label>
                                                    @else
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="input-group input-large">
                                                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                    <span class="fileinput-filename"> </span>
                                                                </div>
                                                                <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> Select file </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" name="attachment"> </span>
                                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    @if($result['status'] == 'Manager Approved' && (!isset($result['approve_by']) && !isset($result['reject_at'])))
                                                        <a onclick="submitTimeOff('submit','update-time-off-2')" class="btn blue" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>Submit</a>
                                                        <a onclick="rejectTimeOff('HRGA Approved')" id="approve" class="btn red reject">Reject</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    


@endsection