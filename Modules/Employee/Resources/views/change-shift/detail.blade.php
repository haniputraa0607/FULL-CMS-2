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
            var id_employee_change_shift = {{$result['id_employee_change_shift']}};
            var id_user = {{$result['user']['id']}};
            var change_shift_date = $('#list_date_start').val();
            var id_employee_office_hour_shift = $('#list_shift').val();
            var reason = $('#reason').val();
           

            var data = {
                '_token' : '{{csrf_token()}}',
                'id_employee_change_shift' : id_employee_change_shift,
                'id_user' : id_user,
                'change_shift_date' : change_shift_date,
                'id_employee_office_hour_shift' : id_employee_office_hour_shift,
                'reason' : reason,
                'approve' : true
            };
            swal({
                    title: "Approve?",
                    text: "This employee request change shift will be approved",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes, Approve this request!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type : "POST",
                        url : "{{url('employee/changeshift/update')}}/"+id_employee_change_shift,
                        data : data,
                        success : function(response) {
                            if (response.status == 'success') {
                                swal("Sent!", "Employee request change shift has been approved", "success")
                                location.href = "{{url('employee/changeshift/detail')}}/"+id_employee_change_shift;
                            }
                            else if(response.status == "fail"){
                                swal("Error!", response.messages, "error")
                            }
                            else {
                                swal("Error!", "Something went wrong. Failed to approve employee request change shift.", "error")
                            }
                        }
                    });
                }
            );
        }

        function selectMonthStart(val){
            var data = {
                'id_employee' : {{$result['user']['id']}},
                'month' : val,
                'year' : $('#year_start').val(),
            };
            listDateStart(data);

        }

        function selectYearStart(val){
            var data = {
                'id_employee' : {{$result['user']['id']}},
                'month' : $('#month_start').val(),
                'year' : val,
            };
            listDateStart(data);
        }

        function listDateStart(data){
            data['_token'] = '{{csrf_token()}}';
            var list = '<option></option>';
            var list_shift = '<option></option>';
            $.ajax({
                type : "POST",
                url : "{{ url('employee/changeshift/list-date') }}",
                data : data,
                success: function(result){
                    if(result['status']=='success'){    
                        var new_result = jQuery.parseJSON(JSON.stringify(result['result']['list_dates']));
                        $('#list_date_start').empty();
                        $.each(new_result, function(i, index) {
                            list += '<option value="'+index.date+'" data-id="'+index.id_employee_schedule+'" >'+index.date_format+'</option>';
                        });

                        var new_shifts = jQuery.parseJSON(JSON.stringify(result['result']['shifts']));
                        $('#list_shift').empty();
                        $.each(new_shifts, function(i, index) {
                            list_shift += '<option value="'+index.id_employee_office_hour_shift+'" >'+index.shift_name+'</option>';
                        });

                        $('#list_date_start').append(list);
                        $('#list_shift').append(list_shift);
                        $(".select2").select2({
                            placeholder: "Search"
                        });
                    }else if(result['status']=='fail'){
                        $('#list_date_start').empty();
                        $('#list_shift').empty();
                        toastr.warning(result['messages']);
                    }
                }
            });
        }

        function submitChangeShift(value) {
            var data = $('#update-change-shift').serialize();
        
            if (!$('form#update-change-shift')[0].checkValidity()) {
                toastr.warning("Incompleted Data. Please fill blank input.");
            }else{
                if(value=='submit'){
                    $('form#update-change-shift').submit();
                }else if(value=='approve'){
                    approvedTimeOff();
                }
            }
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
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('employee/changeshift/update') }}/{{ $result['id_employee_change_shift'] }}" method="post" enctype="multipart/form-data" id="update-change-shift">
                <div class="form-body">
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Select Office <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama kantor karyawan yang akan mengajukan izin" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" placeholder="Outlet name" value="{{ $result['user']['outlet']['outlet_name'] }}" readonly required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Select Employee <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama karyawan yang akan dibuat permohonan izin" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" placeholder="Employee name" value="{{ $result['user']['name'] }}" readonly required/>
                            <input class="form-control" type="hidden" name="id_user" value="{{ $result['user']['id'] }}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Month <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Bulan Ganti Shift" data-container="body"></i></label>
                        <div class="col-md-3">
                            <select class="form-control select2" name="month" id="month_start" required onchange="selectMonthStart(this.value)" @if($result['status'] != 'Pending') disabled @endif>
                                <option value="" selected disabled>Select Month</option>
                                <option value="1" @if(isset($result['month_change'])) @if($result['month_change'] == 1) selected @endif @endif>January</option>
                                <option value="2" @if(isset($result['month_change'])) @if($result['month_change'] == 2) selected @endif @endif>February</option>
                                <option value="3" @if(isset($result['month_change'])) @if($result['month_change'] == 3) selected @endif @endif>March</option>
                                <option value="4" @if(isset($result['month_change'])) @if($result['month_change'] == 4) selected @endif @endif>April</option>
                                <option value="5" @if(isset($result['month_change'])) @if($result['month_change'] == 5) selected @endif @endif>May</option>
                                <option value="6" @if(isset($result['month_change'])) @if($result['month_change'] == 6) selected @endif @endif>June</option>
                                <option value="7" @if(isset($result['month_change'])) @if($result['month_change'] == 7) selected @endif @endif>July</option>
                                <option value="8" @if(isset($result['month_change'])) @if($result['month_change'] == 8) selected @endif @endif>August</option>
                                <option value="9" @if(isset($result['month_change'])) @if($result['month_change'] == 9) selected @endif @endif>September</option>
                                <option value="10" @if(isset($result['month_change'])) @if($result['month_change'] == 10) selected @endif @endif>October</option>
                                <option value="11" @if(isset($result['month_change'])) @if($result['month_change'] == 11) selected @endif @endif>November</option>
                                <option value="12" @if(isset($result['month_change'])) @if($result['month_change'] == 12) selected @endif @endif>December</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Year <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tahun Ganti Shift" data-container="body"></i></label>
                        <div class="col-md-2">
                            <input class="form-control numberonly" type="text" maxlength="4" id="year_start" name="year" placeholder="Enter year" value="{{ $result['year_change'] }}" required onchange="selectYearStart(this.value)" @if($result['status'] != 'Pending') disabled @endif/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Date Change Shift <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih tanggal karyawan akan ganti shift" data-container="body"></i></label>
                        <div class="col-md-3">
                            @if($result['status'] != 'Pending') 
                            <input type="text" class="datepicker form-control" value="{{ date('d F Y', strtotime($result['change_shift_date'])) }}" disabled>
                            @else
                            <select class="form-control select2" name="change_shift_date" required id="list_date_start">
                                <option value="" selected disabled>Select Date</option>
                                @foreach($result['change_list_date'] ?? [] as $d => $date)
                                    <option value="{{$date['date']}}" data-id="{{ $date['id_employee_schedule'] }}" @if(isset($result['change_shift_date'])) @if(date('Y-m-d', strtotime($result['change_shift_date'])) == date('Y-m-d', strtotime($date['date']))) selected @endif @endif> {{$date['date_format']}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Shift <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Shift yang dipilih" data-container="body"></i></label>
                        <div class="col-md-5">
                            @if($result['status'] != 'Pending') 
                            <input class="form-control" type="text" placeholder="Outlet name" value="{{ $result['office_hour_shift']['shift_name'] }}" disabled/>
                            @else
                            <select class="form-control select2" name="id_employee_office_hour_shift" required id="list_shift" @if($result['status']!='Pending') disabled @endif>
                                <option value="" selected disabled>Select Shift</option>
                                @foreach($result['list_shift'] ?? [] as $d => $shift)
                                    <option value="{{$shift['id_employee_office_hour_shift']}}" @if(isset($result['id_employee_office_hour_shift'])) @if($result['id_employee_office_hour_shift'] == $shift['id_employee_office_hour_shift']) selected @endif @endif> {{$shift['shift_name']}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Reason <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Alasan ganti shift" data-container="body"></i></label>
                        <div class="col-md-5">
                            <textarea name="reason" id="reason" class="form-control" placeholder="Enter reason here" @if($result['status']!='Pending') disabled @endif>{{ $result['reason'] }}</textarea>
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
                            @if ($result['status'] == 'Pending')
                                <a onclick="submitChangeShift('submit')" class="btn blue">Submit</a>
                                <a onclick="submitChangeShift('approve')" id="approve" class="btn green approve">Approve</a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    


@endsection