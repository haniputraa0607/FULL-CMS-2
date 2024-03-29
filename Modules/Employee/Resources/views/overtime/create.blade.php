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

        function changeOutlet(val){
            var list = '<option></option>';
            $.ajax({
                type : "POST",
                url : "{{ url('employee/timeoff/list-hs') }}",
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
                url : "{{ url('employee/timeoff/list-date') }}",
                data : data,
                success: function(result){
                    if(result['status']=='success'){    
                        var new_result = jQuery.parseJSON(JSON.stringify(result['result']));
                        $('#list_date').empty();
                        $.each(new_result, function(i, index) {
                            list += '<option value="'+index.date+'" data-id="'+index.id_hairstylist_schedule_date+'" data-timestart="'+index.time_start+'" data-timeend="'+index.time_end+'">'+index.date_format+'</option>';
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

        $('#list_date').on('change',function(){
            var value = $(this).val();
            var start = $("#list_date option:selected").attr('data-timestart');
            var end = $("#list_date option:selected").attr('data-timeend');
            $('#time_start').remove();
            $('#place_time_start').append('<input type="text" id="time_start" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_start" value="'+start+'" disabled>')
            $('#time_end').remove();
            $('#place_time_end').append('<input type="text" id="time_end" data-placeholder="select time end" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_end" value="'+end+'" disabled>')
            $('.timepicker').timepicker({
                autoclose: true,
                minuteStep: 1,
                showSeconds: false,
            });
        })

        function submitOvertime() {
            var data = $('#create-overtime').serialize();
    
            var get_time = $('input[name=time]:checked').val();
            if(get_time==undefined){
                document.getElementById('cek_time').style.display = 'block';
            }else{
                document.getElementById('cek_time').style.display = 'none';
            }
            var check_after = $('#duration_after').css('display');
            var check_before = $('#duration_before').css('display');

            if (!$('form#create-overtime')[0].checkValidity() || check_after == 'block' || check_before == 'block') {
                toastr.warning("Incompleted Data. Please fill blank input.");
            }else{
                $('form#create-overtime').submit();
            }
        }
    
        function check_duration(){
            var list = $('#list_date option:selected').val();
            if(list!=''){
                var get_time = $('input[name=time]:checked').val();
                if(get_time!=undefined){
                    var split = $('#duration').val().split(":");
                    var style = '';
                    var id_alert = '';
                    if(get_time=='before'){
                        var time = $('#time_start').val().split(":");
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
                    }else if(get_time=='after'){
                        var time = $('#time_end').val().split(":");
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
            }
        }

        $('#duration').on('change',function(){
            check_duration();
        });

        $('input[name=time]').on('change',function(){
            var list = $('#list_date option:selected').val();
            if(list!=''){
                var time = $('#time_start').val();
                if(time!='0:00'){
                    document.getElementById('duration_before').style.display = 'none';
                    document.getElementById('duration_after').style.display = 'none';
                    check_duration();
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
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('employee/overtime/create') }}" method="post" enctype="multipart/form-data" id="create-overtime">
                <div class="form-body">
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Select Outlet <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama outlet hair stylist yang akan mengajukan lembur" data-container="body"></i></label>
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
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama hair stylist yang akan dibuat permohonan lembur" data-container="body"></i></label>
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
                        <label for="example-search-input" class="control-label col-md-4">Select Date Overtime <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih tanggal hair stylist akan lembur" data-container="body"></i></label>
                        <div class="col-md-3">
                            <select class="form-control select2" name="date" required id="list_date">
                                <option value="" selected disabled>Select Date</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Start Shift<span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih waktu mulai lembur untuk hair style" data-container="body"></i></label>
                        <div class="col-md-3" id="place_time_start">
                            <input type="text" id="time_start" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_start" value="00:00" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">End Shift<span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih waktu selesai lembur untuk hair style" data-container="body"></i></label>
                        <div class="col-md-3" id="place_time_end">
                            <input type="text" id="time_end" data-placeholder="select end start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_end" value="00:00" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Time To Take Overtime<span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Permohonan lembur untuk sebelum atau setelah shift" data-container="body"></i></label>
                        <div class="col-md-6">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="radio-1" name="time" class="md-radiobtn" value="before" required>
                                    <label for="radio-1">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Before Shift </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="radio-2" name="time" class="md-radiobtn" value="after" required>
                                    <label for="radio-2">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> After Shift </label>
                                </div>
                            </div>
                            <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="cek_time">Please select one of the options</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Duration <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Durasi waktu lembur hair stylist" data-container="body"></i></label>
                        <div class="col-md-6">
                            <div class="col-md-3 input-group">
                                <input type="text" data-placeholder="select duration" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" name="duration" value="00:00" data-show-meridian="false" readonly  id="duration">
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="duration_after">Maximal time for overtime after shift is 23:59</p>
                                    <p class="mt-1 mb-1" style="color: red; display: none; margin-top: 8px; margin-bottom: 8px" id="duration_before">Maximal time for overtime before shift is 00:00</p>
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
                            <a onclick="submitOvertime()" class="btn blue">Submit</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    


@endsection