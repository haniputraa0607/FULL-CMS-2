<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    
    $this_user = 0;
    if($result['employee']['employee']['id_manager'] == session('id_user')){
		$this_user = 1;
	}

    if($result['employee']['id_outlet'] == session('id_outlet') && MyHelper::hasAccess([529], $grantedFeature) ){
        $this_user = 2;
	}
    
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
        
        $('#approve').click(function() {
            var cek_start_rest= $('#cek_start_rest').css('display');
            var cek_end_rest= $('#cek_end_rest').css('display');
            if(cek_start_rest == 'block'){
                toastr.warning("Start Time Rest cannot be smaller than the start overtime");
            }else if(cek_end_rest == 'block'){
                toastr.warning("End Time Rest cannot be bigger than the end overtime");
            }else {
                var id_employee_overtime = {{$result['id_employee_overtime']}};
                var id_employee = {{$result['id_employee']}};
                var id_outlet = {{$result['id_outlet']}};
                var date = $('#list_date').val();
                var month = $('#month').val();
                var year = $('#year').val();
                var rest_before = $('#time_start_rest').val();
                var rest_after = $('#time_end_rest').val();
                var time = $('input[name=time]:checked').val();
    
                var data = {
                    '_token' : '{{csrf_token()}}',
                    'id_employee_overtime' : id_employee_overtime,
                    'id_employee' : id_employee,
                    'id_outlet' : id_outlet,
                    'month' : month,
                    'year' : year,
                    'date' : date,
                    'schedule_in' : '{{ $result['schedule_in'] }}',
                    'schedule_out' : '{{ $result['schedule_out'] }}',
                    'time' : time,
                    'rest_before' : rest_before,
                    'rest_after' : rest_after,
                    'approve' : true
                };

                if(time=='before'){
                    data['time_start_overtime'] = $('#time_start_overtime').val();
                }else if(time=='after'){
                    data['time_end_overtime'] = $('#time_end_overtime').val();
                }
                swal({
                        title: "Confirm?",
                        text: "This employee request overtime will be approved",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Yes, Approve this request!",
                        closeOnConfirm: false
                    },
                    function(){
                        $.ajax({
                            type : "POST",
                            url : "{{url('employee/overtime/update')}}/"+id_employee_overtime,
                            data : data,
                            success : function(response) {
                                if (response.status == 'success') {
                                    swal("Sent!", "Employee request overtime has been approved", "success")
                                    location.href = "{{url('employee/overtime/detail')}}/"+id_employee_overtime;
                                }
                                else if(response.status == "fail"){
                                    swal("Error!", "Failed to approve employee request Overtime.", "error")
                                }
                                else {
                                    swal("Error!", "Something went wrong. Failed to approve employee request overtime.", "error")
                                }
                            }
                        });
                    }
                );
            }

        })

        function selectMonth(val){
            var data = {
                'id_employee' : $('#list_hs').val(),
                'month' : val,
                'year' : $('#year').val(),
                'type_request' : 'overtime'
            };
            listDate(data);

        }

        function selectYear(val){
            var data = {
                'id_employee' : $('#list_hs').val(),
                'month' : $('#month').val(),
                'year' : val,
                'type_request' : 'overtime'
            };
            listDate(data);
        }

        function listDate(data){
            data['_token'] = '{{csrf_token()}}';
            var list = '<option></option>';
            $.ajax({
                type : "POST",
                url : "{{ url('employee/timeoff/list-date') }}",
                data : data,
                success: function(result){
                    if(result['status']=='success'){    
                        var new_result = jQuery.parseJSON(JSON.stringify(result['result']));
                        $.each(new_result, function(i, index) {
                            list += '<option value="'+index.date+'" data-id="'+index.id_employee_schedule+'" data-timestart="'+index.time_start+'" data-timeend="'+index.time_end+'">'+index.date_format+'</option>';
                        });
                    }else if(result['status']=='fail'){
                        toastr.warning(result['messages']);
                    }
                    $('#list_date').empty();
                    $('#list_date').append(list);
                    $(".select2").select2({
                        placeholder: "Search"
                    });
                    $('#time_start').val('00:00');
                    $('#time_end').val('00:00');
                    $('#time_start_overtime').val('00:00');
                    $('#time_end_overtime').val('00:00');
                    $('#time_start_rest').val('00:00');
                    $('#time_end_rest').val('00:00');
                    $('#time_start_overtime').prop('disabled',false);
                    $('#time_end_overtime').prop('disabled',false);
                    $('#radio14').prop('checked',false);
                    $('#radio16').prop('checked',false);
                }
            });
        }

        $('#list_date').on('change',function(){
            var value = $(this).val();
            var start = $("#list_date option:selected").attr('data-timestart');
            var end = $("#list_date option:selected").attr('data-timeend');
            $('#timezone_start').remove();
            $('#timezone_end').remove();
            $('#time_start').remove();
            $('#place_time_start').append('<div class="input-group"><input type="text" id="time_start" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_start" value="'+start+'" disabled><span class="input-group-addon" id="timezone_start">{{ $result['time_zone'] }}</span></div>')
            $('#time_end').remove();
            $('#place_time_end').append('<div class="input-group"><input type="text" id="time_end" data-placeholder="select time end" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_end" value="'+end+'" disabled><span class="input-group-addon" id="timezone_end">{{ $result['time_zone'] }}</span></div>')
            $('.timepicker').timepicker({
                autoclose: true,
                minuteStep: 1,
                showSeconds: false,
            });
            $('#time_start_overtime').val('00:00');
            $('#time_end_overtime').val('00:00');
            $('#time_start_overtime').prop('disabled',false);
            $('#time_end_overtime').prop('disabled',false);
            $('#time_start_rest').val('00:00');
            $('#time_end_rest').val('00:00');
            $('#radio14').prop('checked',false);
            $('#radio16').prop('checked',false);
        })

        function submitOvertime(value,form) {

            if(value=='update-overtime-1'){
                var cek_start_rest= $('#cek_start_rest').css('display');
                var cek_end_rest= $('#cek_end_rest').css('display'); 
            }
            if(value=='update-overtime-1' && cek_start_rest == 'block'){
                toastr.warning("Start Time Rest cannot be smaller than the start overtime");
            }else if(value=='update-overtime-1' && cek_end_rest == 'block'){
                toastr.warning("End Time Rest cannot be bigger than the end overtime");
            }else {
                var data = $(`#${form}`).serialize();
        
                if(value=='update-overtime-1'){
                    var get_time = $('input[name=time]:checked').val();
                    if(get_time==undefined){
                        document.getElementById('cek_time').style.display = 'block';
                    }else{
                        document.getElementById('cek_time').style.display = 'none';
                    }
                }
                if (!$(`form#${form}`)[0].checkValidity()) {
                    toastr.warning("Incompleted Data. Please fill blank input.");
                }else{
                    if(value=='submit'){
                        $(`form#${form}`).submit();
                    }
                }
            }
        }

        function rejectOvertime(value){
            var id_employee_overtime = {{$result['id_employee_overtime']}};
            swal({
                    title: "Reject?",
                    text: "This employee request overtime will be reject",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, Reject this request!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type : "POST",
                        url : "{{url('employee/overtime/reject')}}/"+id_employee_overtime,
                        data : {
                                '_token' : '{{csrf_token()}}',
                                'id_employee_overtime' : id_employee_overtime,
                                'type' : value,
                            },
                        success : function(response) {
                            if (response.status == 'success') {
                                swal("Sent!", "Employee request overtime has been reject", "success")
                                location.href = "{{url('employee/overtime/detail')}}/"+id_employee_overtime;
                            }
                            else if(response.status == "fail"){
                                swal("Error!", response.messages, "error")
                            }
                            else {
                                swal("Error!", "Something went wrong. Failed to reject employee request overtime.", "error")
                            }
                        }
                    });
                }
            );
        }

        $('input:radio[name="time"]').change(function(){
            var time = $('input[name="time"]:checked').val();
            $('#time_start_rest').val('00:00');
            $('#time_end_rest').val('00:00');
            $('#time_start_overtime').val('00:00');
            $('#time_end_overtime').val('00:00');
            if(time=='before'){
                $('#time_end_overtime').val('{{ $result['schedule_in'] }}');
                $('#time_end_overtime').prop('disabled', true);
                $('#time_start_overtime').prop('disabled', false);
            }else if(time=='after'){
                $('#time_start_overtime').val('{{ $result['schedule_out'] }}');
                $('#time_end_overtime').val('23:59');
                $('#time_start_overtime').prop('disabled', true);
                $('#time_end_overtime').prop('disabled', false);
            }
        });

        $('#time_start_rest').change(function(){
            var split =  $('#time_start_overtime').val().split(":");
            var split2 =  $('#time_end_overtime').val().split(":");
            var this_val = $(this).val().split(":");
            var check = false;
            if(parseInt(split[0]) <= parseInt(this_val[0])){
                if(parseInt(split[0]) == parseInt(this_val[0]) && parseInt(split[1]) > parseInt(this_val[1])){
                    check = true;
                }
            }else{
                check = true;
            }

            if(parseInt(split2[0]) >= parseInt(this_val[0])){
                if(parseInt(split2[0]) == parseInt(this_val[0]) && parseInt(split2[1]) < parseInt(this_val[1])){
                    check = true;
                }
            }else{
                check = true;
            }

            if($(this).val() == '0:00' && $('#time_end_rest').val() == '0:00'){
                check = false;
            }

            if(check == true){
                document.getElementById('cek_start_rest').style.display = 'block';
            }else{
                document.getElementById('cek_start_rest').style.display = 'none';
            }
        });

        $('#time_end_rest').change(function(){
            var split =  $('#time_end_overtime').val().split(":");
            var split2 =  $('#time_start_overtime').val().split(":");
            var this_val = $(this).val().split(":");
            var check = false;
            if(parseInt(split[0]) >= parseInt(this_val[0])){
                if(parseInt(split[0]) == parseInt(this_val[0]) && parseInt(split[1]) < parseInt(this_val[1])){
                    check = true;
                }
            }else{
                check = true;
            }

            if(parseInt(split2[0]) <= parseInt(this_val[0])){
                if(parseInt(split2[0]) == parseInt(this_val[0]) && parseInt(split2[1]) > parseInt(this_val[1])){
                    check = true;
                }
            }else{
                check = true;
            }

            if($(this).val() == '0:00' && $('#time_start_rest').val() == '0:00'){
                check = false;
            }

            if(check == true){
                document.getElementById('cek_end_rest').style.display = 'block';
            }else{
                document.getElementById('cek_end_rest').style.display = 'none';
            }
        });

        $('#time_start_overtime').on('change',function(){
            var list = $('#list_date option:selected').val();
            if(list!=''){
                var get_time = $('input[name=time]:checked').val();
                if(get_time=='before'){
                        var time = $(this).val().split(":");
                        console.log(time);
                        var minute = 0;
                        var hour = 0;
                        var hold = 0;
                        minute = parseInt(time[1]) - parseInt(split[1]);
                        if(minute < 0){
                            minute = parseInt(minute) + 60;
                            hold = 1;
                        }
                        hour = parseInt(time[0]) - parseInt(split[0]) - parseInt(hold);
                        if(hour>=0){
                            if(minute>=0){
                                style = 'none';
                            }else{
                                style = 'block';
                            }   
                        }else{
                            style = 'block';
                        }
                        document.getElementById('duration_before').style.display = style;
                    }
            }
        });

        $('#time_end_overtime').on('change',function(){
            var list = $('#list_date option:selected').val();
            if(list!=''){
                var get_time = $('input[name=time]:checked').val();
                if(get_time=='after'){
                        var time = $(this).val().split(":");
                        console.log(time);
                        var minute = 0;
                        var hour = 0;
                        var hold = 0;
                        minute = parseInt(split[1]) + parseInt(time[1]);
                        if(minute > 60){
                            minute = parseInt(minute) - 60;
                            hold = 1;
                        }
                        hour = parseInt(split[0]) + parseInt(time[0]) + parseInt(hold);
                        if(hour<=23){
                            if(minute<=59){
                                style = 'none';
                            }else{
                                style = 'block';
                            }   
                        }else{
                            style = 'block';
                        }
                        document.getElementById('duration_after').style.display = style;
                    }
            }
        });
    
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
                    <a href="#status" data-toggle="tab"> Status Overtime</a>
                </li>
               
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="info">
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form" action="{{ url('employee/overtime/update') }}/{{ $result['id_employee_overtime'] }}" method="post" enctype="multipart/form-data" id="update-overtime">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Select Outlet <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama outlet karyawan yang akan mengajukan lembur" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" placeholder="Outlet name" value="{{ $result['outlet']['outlet_name'] }}" readonly required/>
                                    <input class="form-control" type="hidden" name="id_outlet" value="{{ $result['outlet']['id_outlet'] }}" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Select Employee <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama karyawan yang akan dibuat permohonan lembur" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" placeholder="Hair Stylist name" value="{{ $result['employee']['name'] }}" readonly required/>
                                    <input class="form-control" type="hidden" name="id_employee" id="list_hs"  value="{{ $result['employee']['id'] }}" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Select Date Overtime <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih tanggal karyawan akan lembur" data-container="body"></i></label>
                                <div class="col-md-3">
                                    <input type="text" class="datepicker form-control" value="{{ date('d F Y', strtotime($result['date'])) }}" disabled>    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Time To Take Overtime<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Permohonan lembur untuk sebelum atau setelah shift" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" placeholder="Hair Stylist name" value="@if ($result['time']=='before') Before Shift @else After Shift @endif" readonly required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Start Overtime<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih waktu mulai lembur untuk karyawan" data-container="body"></i></label>
                                <div class="col-md-3">
                                    <div class="col-md-12 input-group">
                                        <input type="text" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" value="{{ $result['start_overtime'] }}" disabled >
                                        <span class="input-group-addon">{{ $result['time_zone'] }}</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="duration_before">Minimal time start is 00:00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">End Overtime<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih waktu selesai lembur untuk karyawan" data-container="body"></i></label>
                                <div class="col-md-3">
                                    <div class="col-md-12 input-group">
                                        <input type="text" data-placeholder="select end start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" value="{{ $result['end_overtime'] }}" disabled>
                                        <span class="input-group-addon">{{ $result['time_zone'] }}</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="duration_after">Maximal time end is 23:59</p>
                                        </div>
                                    </div>
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
                            {{--  <input type="hidden" name="id_employee_schedule" value="">  --}}
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
                                    <form class="form-horizontal" role="form" action="{{ url('employee/overtime/update') }}/{{ $result['id_employee_overtime'] }}" method="post" enctype="multipart/form-data" id="update-overtime-1">
                                        <div class="form-body">
                                            <input class="form-control" type="hidden" name="type" id="type"  value="Manager Approved" readonly/>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Select Outlet <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama outlet karyawan yang akan mengajukan lembur" data-container="body"></i></label>
                                                <div class="col-md-5">
                                                    <input class="form-control" type="text" placeholder="Outlet name" value="{{ $result['outlet']['outlet_name'] }}" readonly required/>
                                                    <input class="form-control" type="hidden" name="id_outlet" value="{{ $result['outlet']['id_outlet'] }}" readonly/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Select Employee <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama karyawan yang akan dibuat permohonan lembur" data-container="body"></i></label>
                                                <div class="col-md-5">
                                                    <input class="form-control" type="text" placeholder="Hair Stylist name" value="{{ $result['employee']['name'] }}" readonly required/>
                                                    <input class="form-control" type="hidden" name="id_employee" id="list_hs"  value="{{ $result['employee']['id'] }}" readonly/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Month <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk bulan yang di pilih" data-container="body"></i></label>
                                                <div class="col-md-3">
                                                    <select class="form-control select2" name="month" id="month" required onchange="selectMonth(this.value)" @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])) || $this_user != 1) disabled @endif>
                                                        <option value="" selected disabled>Select Month</option>
                                                        <option value="1" @if(isset($result['month'])) @if($result['month'] == 1) selected @endif @endif>January</option>
                                                        <option value="2" @if(isset($result['month'])) @if($result['month'] == 2) selected @endif @endif>February</option>
                                                        <option value="3" @if(isset($result['month'])) @if($result['month'] == 3) selected @endif @endif>March</option>
                                                        <option value="4" @if(isset($result['month'])) @if($result['month'] == 4) selected @endif @endif>April</option>
                                                        <option value="5" @if(isset($result['month'])) @if($result['month'] == 5) selected @endif @endif>May</option>
                                                        <option value="6" @if(isset($result['month'])) @if($result['month'] == 6) selected @endif @endif>June</option>
                                                        <option value="7" @if(isset($result['month'])) @if($result['month'] == 7) selected @endif @endif>July</option>
                                                        <option value="8" @if(isset($result['month'])) @if($result['month'] == 8) selected @endif @endif>August</option>
                                                        <option value="9" @if(isset($result['month'])) @if($result['month'] == 9) selected @endif @endif>September</option>
                                                        <option value="10" @if(isset($result['month'])) @if($result['month'] == 10) selected @endif @endif>October</option>
                                                        <option value="11" @if(isset($result['month'])) @if($result['month'] == 11) selected @endif @endif>November</option>
                                                        <option value="12" @if(isset($result['month'])) @if($result['month'] == 12) selected @endif @endif>December</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Year <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk tahun yang di pilih" data-container="body"></i></label>
                                                <div class="col-md-2">
                                                    <input class="form-control numberonly" type="text" maxlength="4" id="year" name="year" placeholder="Enter year" value="{{ $result['year'] }}" required onchange="selectYear(this.value)" @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])) || $this_user != 1) disabled @endif/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Select Date Overtime <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih tanggal karyawan akan lembur" data-container="body"></i></label>
                                                <div class="col-md-4">
                                                    @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])) || $this_user != 1)
                                                    <input type="text" class="datepicker form-control" value="{{ date('d F Y', strtotime($result['date'])) }}" disabled>
                                                    @else
                                                    <select class="form-control select2" name="date" required id="list_date">
                                                        <option value="" selected disabled>Select Date</option>
                                                        @foreach($result['list_date'] as $d => $date)
                                                            <option value="{{$date['date']}}" data-id="{{ $date['id_employee_schedule'] }}" data-timestart="{{ $date['time_start'] }}" data-timeend="{{ $date['time_end'] }}"  @if(isset($result['date'])) @if(date('Y-m-d', strtotime($result['date'])) == date('Y-m-d', strtotime($date['date']))) selected @endif @endif> {{$date['date_format']}}</option>
                                                        @endforeach
                                                    </select>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Start Shift<span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Waktu karyawan mulai kerja" data-container="body"></i></label>
                                                <div class="col-md-3" id="place_time_start">
                                                    <div class="input-group">
                                                        <input type="text" id="time_start" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_start" value="{{ $result['schedule_in'] }}" disabled>
                                                        <span class="input-group-addon" id="timezone_start">{{ $result['time_zone'] }}</span>
                                                    </div>
                                                    <input type="hidden" name="schedule_in" value="{{ $result['schedule_in'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">End Shift<span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Waktu karywan selesai kerja" data-container="body"></i></label>
                                                <div class="col-md-3" id="place_time_end">
                                                    <div class="input-group">
                                                        <input type="text" id="time_end" data-placeholder="select end start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_end" value="{{ $result['schedule_out'] }}" disabled>
                                                        <span class="input-group-addon" id="timezone_end">{{ $result['time_zone'] }}</span>
                                                    </div>
                                                    <input type="hidden" name="schedule_out" value="{{ $result['schedule_out'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Time To Take Overtime<span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Permohonan lembur untuk sebelum atau setelah shift" data-container="body"></i></label>
                                                <div class="col-md-6">
                                                    <div class="md-radio-inline">
                                                        <div class="md-radio">
                                                            <input type="radio" id="radio14" name="time" class="md-radiobtn" value="before" @if($result['time']=='before') checked @endif required @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])) || $this_user != 1) disabled @endif>
                                                            <label for="radio14">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> Before Shift </label>
                                                        </div>
                                                        <div class="md-radio">
                                                            <input type="radio" id="radio16" name="time" class="md-radiobtn" value="after" @if($result['time']=='after') checked @endif required @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])) || $this_user != 1) disabled @endif>
                                                            <label for="radio16">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> After Shift </label>
                                                        </div>
                                                    </div>
                                                    <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="cek_time">Please select one of the options</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Start Overtime<span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih waktu mulai lembur untuk karyawan" data-container="body"></i></label>
                                                <div class="col-md-3">
                                                    <div class="col-md-12 input-group">
                                                        <input type="text" id="time_start_overtime" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_start_overtime" value="{{ $result['start_overtime'] }}" @if($result['time']=='after') disabled @endif @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])) || $this_user != 1) disabled @endif>
                                                        <span class="input-group-addon">{{ $result['time_zone'] }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="duration_before">Minimal time start is 00:00</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">End Overtime<span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih waktu selesai lembur untuk karyawan" data-container="body"></i></label>
                                                <div class="col-md-3">
                                                    <div class="col-md-12 input-group">
                                                        <input type="text" id="time_end_overtime" data-placeholder="select end start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_end_overtime" value="{{ $result['end_overtime'] }}" @if($result['time']=='before') disabled @endif @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])) || $this_user != 1) disabled @endif>
                                                        <span class="input-group-addon">{{ $result['time_zone'] }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="duration_after">Maximal time end is 23:59</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Start Rest<span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih waktu mulai istirahat lembur untuk karyawan" data-container="body"></i></label>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <input type="text" id="time_start_rest" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="rest_before" value="{{ $result['rest_before'] ?? '00:00' }}" @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])) || $this_user != 1) disabled @endif>
                                                        <span class="input-group-addon">{{ $result['time_zone'] }}</span>
                                                    </div>
                                                    <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="cek_start_rest">Start rest overtime cant smaller than start overtime</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">End Rest<span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih waktu selesai istirahat lembur untuk karyawan" data-container="body"></i></label>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <input type="text" id="time_end_rest" data-placeholder="select end start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="rest_after" value="{{ $result['rest_after'] ?? '00:00'}}" @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])) || $this_user != 1) disabled @endif>
                                                        <span class="input-group-addon">{{ $result['time_zone'] }}</span>
                                                    </div>
                                                    <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="cek_end_rest">End rest overtime cant bigger than end overtime</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Requested By <span class="required" aria-required="true">*</span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Permohonan dibuat oleh user ini" data-container="body"></i></label>
                                                <div class="col-md-5">
                                                    <input class="form-control" type="text" placeholder="Enter request by" value="{{ $result['request']['name'] }}" required readonly/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Notes
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Catatan dari manager" data-container="body"></i></label>
                                                <div class="col-md-5">
                                                    <textarea class="form-control" name="notes" placeholder="Notes" @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])) || $this_user != 1) disabled @endif>@if(isset($dataDoc['Manager Approved']['notes'])) {{$dataDoc['Manager Approved']['notes']}}  @endif</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Attachment
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Dokumen dari manager" data-container="body"></i></label>
                                                <div class="col-md-5">
                                                    @if($result['status'] != 'Pending' || (isset($result['approve_by']) || isset($result['reject_at'])) || $this_user != 1)
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
                                            {{--  <input type="hidden" name="id_employee_schedule" value="">  --}}
                                        </div>
                                        <div class="form-actions">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                   
<!--                                                    @if(session('level') == 'Super Admin')
                                                          <a onclick="submitOvertime('submit','update-overtime-1')" class="btn blue" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>Submit</a>
                                                        <a onclick="rejectOvertime('Manager Approved')" class="btn red reject">Reject</a>
                                                    @else
                                                        @if(MyHelper::hasAccess([529], $grantedFeature))
                                                              <a onclick="submitOvertime('submit','update-overtime-1')" class="btn blue" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>Submit</a>
                                                        <a onclick="rejectOvertime('Manager Approved')" class="btn red reject">Reject</a>
                                                        @endif
                                                    @endif-->
                                                    @if(session('level') == 'Super Admin')
                                                          <a onclick="submitOvertime('submit','update-overtime-1')" class="btn blue" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>Submit</a>
                                                        <a onclick="rejectOvertime('Manager Approved')" class="btn red reject">Reject</a>
                                                    @elseif($result['status'] == 'Pending' && (!isset($result['approve_by']) && !isset($result['reject_at'])) && $this_user == 1)
                                                        <a onclick="submitOvertime('submit','update-overtime-1')" class="btn blue" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>Submit</a>
                                                        <a onclick="rejectOvertime('Manager Approved')" class="btn red reject">Reject</a>
                                                    @else
                                                        Hanya Manager yang dapat merubah data
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane @if($result['status'] == 'Manager Approved' || $result['status'] == 'HRGA Approved') active @endif" id="hrga">
                                    <form class="form-horizontal" role="form" action="{{ url('employee/overtime/update') }}/{{ $result['id_employee_overtime'] }}" method="post" enctype="multipart/form-data" id="update-overtime-2">
                                        <div class="form-body">
                                            <input class="form-control" type="hidden" name="id_outlet" value="{{ $result['outlet']['id_outlet'] }}" readonly/>
                                            <input class="form-control" type="hidden" name="id_employee" id="list_hs"  value="{{ $result['employee']['id'] }}" readonly/>
                                            <input class="form-control" type="hidden" name="type" id="type"  value="HRGA Approved" readonly/>
                                            <input type="hidden" name="schedule_in" value="{{ $result['schedule_in'] }}">
                                            <input type="hidden" name="schedule_out" value="{{ $result['schedule_out'] }}">
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
<!--                                                    @if($result['status'] == 'Manager Approved' && (!isset($result['approve_by']) && !isset($result['reject_at'])) && $this_user == 2)
                                                        <a onclick="submitOvertime('submit','update-overtime-2')" class="btn blue" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>Submit</a>
                                                        <a onclick="rejectOvertime('HRGA Approved')" class="btn red reject">Reject</a>
                                                    @endif-->
                                                    @if(session('level') == 'Super Admin')
                                                        <a onclick="submitOvertime('submit','update-overtime-2')" class="btn blue" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>Submit</a>
                                                        <a onclick="rejectOvertime('HRGA Approved')" class="btn red reject">Reject</a>
                                                    @else
                                                        @if(MyHelper::hasAccess([529], $grantedFeature))
                                                            <a onclick="submitOvertime('submit','update-overtime-2')" class="btn blue" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>Submit</a>
                                                            <a onclick="rejectOvertime('HRGA Approved')" class="btn red reject">Reject</a>
                                                        @else
                                                            Hanya hak akses HRGA yang dapat merubah data 
                                                        @endif
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