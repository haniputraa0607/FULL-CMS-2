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

        function changeOutlet(val){
            var list = '<option></option>';
            $.ajax({
                type : "POST",
                url : "{{ url('recruitment/hair-stylist/timeoff/list-hs') }}",
                data : {
                    '_token' : '{{csrf_token()}}',
                    'id_outlet' : val,
                },
                success : function(result) {
                    $('#list_hs').empty();
                    if(result.length > 0){
                        $.each(result, function(i, index) {
                            list += '<option value="'+index.id_user_hair_stylist+'">'+index.fullname+'</option>';
                          });
                    }
                    $('#list_hs').append(list);
                    $(".select2").select2({
                        placeholder: "Search"
                    });
                },
                error : function(result) {
                    toastr.warning("Something went wrong. Failed to get list hair stylist.");
                }
            });
        }

        function selectHS(val){
            var data = {
                'id_user_hair_stylist' : val,
                'month' : $('#month').val(),
                'year' : $('#year').val(),
            };
            listDate(data);
        }

        function selectMonth(val){
            var data = {
                'id_user_hair_stylist' : $('#list_hs').val(),
                'month' : val,
                'year' : $('#year').val(),
            };
            listDate(data);

        }

        function selectYear(val){
            var data = {
                'id_user_hair_stylist' : $('#list_hs').val(),
                'month' : $('#month').val(),
                'year' : val,
            };
            listDate(data);
        }

        function listDate(data){
            data['_token'] = '{{csrf_token()}}';
            var list = '<option></option>';
            $.ajax({
                type : "POST",
                url : "{{ url('recruitment/hair-stylist/timeoff/list-date') }}",
                data : data,
                success: function(result){
                    if(result['status']=='success'){    
                        var new_result = jQuery.parseJSON(JSON.stringify(result['result']));
                        $('#list_date').empty();
                        $.each(new_result, function(i, index) {
                            list += '<option value="'+index.date+'" data-id="'+index.id_hairstylist_schedule_date+'" data-timestart="'+index.time_start+'" data-timeend="'+index.time_end+'" data-timezone="'+index.timezone+'">'+index.date_format+'</option>';
                        });
                        $('#list_date').append(list);
                        $(".select2").select2({
                            placeholder: "Search"
                        });
                    }else if(result['status']=='fail'){
                        toastr.warning(result['messages']);
                    }
                }
            });
        }

        $('#list_date').on("change",function(){
            var value = $(this).val();
            var start = $("#list_date option:selected").attr('data-timestart');
            var end = $("#list_date option:selected").attr('data-timeend');
            var id = $("#list_date option:selected").attr('data-id');
            var timezone = $("#list_date option:selected").attr('data-timezone');
            $('#timezone_start').remove();
            $('#timezone_end').remove();
            $('#time_start').remove();
            $('#place_time_start').append('<input type="text" id="time_start" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_start" value="'+start+'" readonly><span class="input-group-addon" id="timezone_start">'+timezone+'</span>');
            $('#time_end').remove();
            $('#place_time_end').append('<input type="text" id="time_end" data-placeholder="select time end" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_end" value="'+end+'" readonly><span class="input-group-addon" id="timezone_end">'+timezone+'</span>');
            $('.timepicker').timepicker({
                autoclose: true,
                minuteStep: 1,
                showSeconds: false,
            });
            var type = $('input[type=hidden][name=id_hairstylist_schedule_date]').val(id);
        });

        function submitTimeOff() {

            var cek_start_time = $('#cek_start_time').css('display');
            var cek_end_time = $('#cek_end_time').css('display');
            var cek_smaller = $('#cek_smaller').css('display');
            var cek_bigger = $('#cek_bigger').css('display');

            if(cek_start_time == 'block'){
                toastr.warning("Start Time Off cannot be smaller than the shift schedule");
            }else if(cek_end_time == 'block'){
                toastr.warning("End Time Off cannot be bigger than the shift schedule");
            }else if(cek_smaller == 'block'){
                toastr.warning("Start Time Off cannot be bigger than the end time off");
            }else if(cek_bigger == 'block'){
                toastr.warning("End Time Off cannot be smaller than the start time off");
            }else{
                var data = $('#create-time-off').serialize();
    
                if (!$('form#create-time-off')[0].checkValidity()) {
                    toastr.warning("Incompleted Data. Please fill blank input.");
                }else{
                    $('form#create-time-off').submit();
                }
            }

        }

        $('#place_time_start').on("change","#time_start",function(){
            var list = $('#list_date option:selected').val();
            if(list!=''){
                changeStartTime();
            }
            if($(this).val()!='0:00'){
                checkStartEnd();
            }
        });

        function changeStartTime(){
            var split =  $('#place_time_start #time_start').val().split(":");
            var time_start_picker = $("#list_date option:selected").attr('data-timestart').split(":");
            var smaller = false;
            if(parseInt(split[0]) >= parseInt(time_start_picker[0])){
                if(parseInt(split[0]) == parseInt(time_start_picker[0]) && parseInt(split[1]) < parseInt(time_start_picker[1])){
                    smaller = true;
                }
            }else{
                smaller = true;
            }
            if(smaller == true){
                document.getElementById('cek_start_time').style.display = 'block';
            }else{
                document.getElementById('cek_start_time').style.display = 'none';
            }
        }

        $('#place_time_end').on("change","#time_end",function(){
            var list = $('#list_date option:selected').val();
            if(list!=''){
                changeEndTime();
            }
            if($(this).val()!='0:00'){
                checkStartEnd();
            }
        });
        
        function changeEndTime(){
            var split =  $('#place_time_end #time_end').val().split(":");
            var time_end_picker = $("#list_date option:selected").attr('data-timeend').split(":");
            var bigger = false;
            if(parseInt(split[0]) <= parseInt(time_end_picker[0])){
                if(parseInt(split[0]) == parseInt(time_end_picker[0]) && parseInt(split[1]) > parseInt(time_end_picker[1])){
                    bigger = true;
                }
            }else{
                bigger = true;
            }
            if(bigger == true){
                document.getElementById('cek_end_time').style.display = 'block';
            }else{
                document.getElementById('cek_end_time').style.display = 'none';
            }
        }

        function checkStartEnd(){
            var end = $('#place_time_end #time_end').val().split(":");
            var start = $('#place_time_start #time_start').val().split(":");
            var smaller = false;
            if(parseInt(start[0]) <= parseInt(end[0])){
                if(parseInt(start[0]) == parseInt(end[0]) && parseInt(start[1]) >= parseInt(end[1])){
                    smaller = true;
                }
            }else{
                smaller = true;
            }
            if(smaller == true){
                document.getElementById('cek_smaller').style.display = 'block';
            }else{
                document.getElementById('cek_smaller').style.display = 'none';
            }

            var bigger = false;
            if(parseInt(end[0]) >= parseInt(start[0])){
                if(parseInt(end[0]) == parseInt(start[0]) && parseInt(end[1]) <= parseInt(start[1])){
                    bigger = true;
                }
            }else{
                bigger = true;
            }
            if(bigger == true){
                document.getElementById('cek_bigger').style.display = 'block';
            }else{
                document.getElementById('cek_bigger').style.display = 'none';
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
            <form class="form-horizontal" role="form" action="{{ url('recruitment/hair-stylist/timeoff/create') }}" method="post" enctype="multipart/form-data" id="create-time-off">
                <div class="form-body">
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Select Outlet <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama outlet hair stylist yang akan mengajukan izin" data-container="body"></i></label>
                        <div class="col-md-5">
                            <select class="form-control select2" name="id_outlet" required onchange="changeOutlet(this.value)">
                                <option value="" selected disabled>Select Hair Stylist</option>
                                @foreach($outlets as $out => $outlet)
                                    <option value="{{$outlet['id_outlet']}}">{{$outlet['outlet_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Select Hair Stylist <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama hair stylist yang akan dibuat permohonan izin" data-container="body"></i></label>
                        <div class="col-md-5">
                            <select class="form-control select2" name="id_hs" required id="list_hs" onchange="selectHS(this.value)">
                                <option value="" selected disabled>Select Hair Stylist</option>
                                @foreach($hair_stylists as $o => $hs)
                                    <option value="{{$hs['id_user_hair_stylist']}}">{{$hs['fullname']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Month <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk bulan yang di pilih" data-container="body"></i></label>
                        <div class="col-md-3">
                            <select class="form-control select2" name="month" id="month" required onchange="selectMonth(this.value)">
                                <option value="" selected disabled>Select Month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Year <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk tahun yang di pilih" data-container="body"></i></label>
                        <div class="col-md-2">
                            <input class="form-control numberonly" type="text" maxlength="4" id="year" name="year" placeholder="Enter year" value="" required onchange="selectYear(this.value)"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Select Date Time Off <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih tanggal hair stylist akan izin" data-container="body"></i></label>
                        <div class="col-md-3">
                            <select class="form-control select2" name="date" required id="list_date">
                                <option value="" selected disabled>Select Date</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Start Time Off<span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih waktu mulai izin untuk hair style" data-container="body"></i></label>
                        <div class="col-md-6">
                            <div class="col-md-5 input-group" id="place_time_start">
                                <input type="text" id="time_start" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_start" value="0:00" readonly>
                                <span class="input-group-addon" id="timezone_start">WIB</span>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="cek_start_time">Start Time Off cannot be smaller than the shift schedule</p>
                                    <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="cek_smaller">Start Time Off cannot be bigger than the end time off</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">End Time Off<span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih waktu selesai izin untuk hair style" data-container="body"></i></label>
                        <div class="col-md-6">
                            <div class="col-md-5 input-group" id="place_time_end">
                                <input type="text" id="time_end" data-placeholder="select end start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_end" value="0:00" readonly>
                                <span class="input-group-addon" id="timezone_end">WIB</span>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="cek_end_time">End Time Off cannot be bigger than the shift schedule</p>
                                    <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="cek_bigger">End Time Off cannot be smaller than the start time off</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_hairstylist_schedule_date" value="">
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a onclick="submitTimeOff()" class="btn blue">Submit</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    


@endsection