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
            minuteStep: 5,
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
            var id_hairstylist_overtime = {{$result['id_hairstylist_overtime']}};
            var id_hs = {{$result['id_user_hair_stylist']}};
            var date = $('#list_date').val();
            var duration = $('input[type=text][name=duration]').val();
            var time = $('input[name=time]:checked').val();

            var data = {
                '_token' : '{{csrf_token()}}',
                'id_hairstylist_overtime' : id_hairstylist_overtime,
                'id_hs' : id_hs,
                'date' : date,
                'time' : time,
                'duration' : duration,
                'approve' : true
            };
            swal({
                    title: "Confirm?",
                    text: "This hair style request overtime will be approved",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes, Approve this request!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type : "POST",
                        url : "{{url('recruitment/hair-stylist/overtime/update')}}/"+id_hairstylist_overtime,
                        data : data,
                        success : function(response) {
                            if (response.status == 'success') {
                                swal("Sent!", "Hair Stylist request overtime has been approved", "success")
                                location.href = "{{url('recruitment/hair-stylist/overtime/detail')}}/"+id_hairstylist_overtime;
                            }
                            else if(response.status == "fail"){
                                swal("Error!", "Failed to approve hair stylist request 0vertime.", "error")
                            }
                            else {
                                swal("Error!", "Something went wrong. Failed to approve hair stylist request overtime.", "error")
                            }
                        }
                    });
                }
            );
        })

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

        $('#list_date').on('change',function(){
            var value = $(this).val();
            var start = $("#list_date option:selected").attr('data-timestart');
            var end = $("#list_date option:selected").attr('data-timeend');
            var timezone = $("#list_date option:selected").attr('data-timezone');
            $('#timezone_start').remove();
            $('#timezone_end').remove();
            $('#time_start').remove();
            $('#place_time_start').append('<input type="text" id="time_start" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_start" value="'+start+'" disabled><span class="input-group-addon" id="timezone_start">'+timezone+'</span>')
            $('#time_end').remove();
            $('#place_time_end').append('<input type="text" id="time_end" data-placeholder="select time end" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_end" value="'+end+'" disabled><span class="input-group-addon" id="timezone_end">'+timezone+'</span>')
            $('.timepicker').timepicker({
                autoclose: true,
                minuteStep: 5,
                showSeconds: false,
            });
        })

        function updateOvertime() {
            var data = $('#update-overtime').serialize();
    
            var get_time = $('input[name=time]:checked').val();
            if(get_time==undefined){
                document.getElementById('cek_time').style.display = 'block';
            }else{
                document.getElementById('cek_time').style.display = 'none';
            }
            if (!$('form#update-overtime')[0].checkValidity()) {
                toastr.warning("Incompleted Data. Please fill blank input.");
            }else{
                $('form#update-overtime').submit();
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
            <form class="form-horizontal" role="form" action="{{ url('recruitment/hair-stylist/overtime/update') }}/{{ $result['id_hairstylist_overtime'] }}" method="post" enctype="multipart/form-data" id="update-overtime">
                <div class="form-body">
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Select Outlet <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama outlet hair stylist yang akan mengajukan lembur" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" placeholder="Outlet name" value="{{ $result['outlet']['outlet_name'] }}" readonly required/>
                            <input class="form-control" type="hidden" name="id_outlet" value="{{ $result['outlet']['id_outlet'] }}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Select Hair Stylist <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih nama hair stylist yang akan dibuat permohonan lembur" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" placeholder="Hair Stylist name" value="{{ $result['hair_stylist']['fullname'] }}" readonly required/>
                            <input class="form-control" type="hidden" name="id_hs" id="list_hs"  value="{{ $result['hair_stylist']['id_user_hair_stylist'] }}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Month <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk bulan yang di pilih" data-container="body"></i></label>
                        <div class="col-md-3">
                            <select class="form-control select2" name="month" id="month" required onchange="selectMonth(this.value)" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>
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
                            <input class="form-control numberonly" type="text" maxlength="4" id="year" name="year" placeholder="Enter year" value="{{ $result['year'] }}" required onchange="selectYear(this.value)" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Select Date Overtime <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih tanggal hair stylist akan lembur" data-container="body"></i></label>
                        <div class="col-md-3">
                            @if(isset($result['approve_by']) || isset($result['reject_at']))
                            <input type="text" class="datepicker form-control" value="{{ date('d F Y', strtotime($result['date'])) }}" disabled>
                            @else
                            <select class="form-control select2" name="date" required id="list_date">
                                <option value="" selected disabled>Select Date</option>
                                @foreach($result['list_date'] as $d => $date)
                                    <option value="{{$date['date']}}" data-id="{{ $date['id_hairstylist_schedule_date'] }}" data-timestart="{{ $date['time_start'] }}" data-timeend="{{ $date['time_end'] }}" data-timezone="{{ $date['timezone'] }}" @if(isset($result['date'])) @if($result['date'] == $date['date']) selected @endif @endif> {{$date['date_format']}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Start Shift<span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih waktu mulai lembur untuk hair style" data-container="body"></i></label>
                        <div class="col-md-3">
                            <div class="input-group" id="place_time_start">
                                <input type="text" id="time_start" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_start" value="{{ $result['time_start'] }}" disabled>
                                <span class="input-group-addon" id="timezone_start">{{ $result['timezone'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">End Shift<span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih waktu selesai lembur untuk hair style" data-container="body"></i></label>
                        <div class="col-md-3">
                            <div class="input-group" id="place_time_end">
                                <input type="text" id="time_end" data-placeholder="select end start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" data-show-meridian="false" name="time_end" value="{{ $result['time_end'] }}" disabled>
                                <span class="input-group-addon" id="timezone_end">{{ $result['timezone'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Time To Take Overtime<span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Permohonan lembur untuk sebelum atau setelah shift" data-container="body"></i></label>
                        <div class="col-md-6">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="radio14" name="time" class="md-radiobtn" value="before" @if($result['time']=='before') checked @endif required @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>
                                    <label for="radio14">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Before Shift </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="radio16" name="time" class="md-radiobtn" value="after" @if($result['time']=='after') checked @endif required @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>
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
                        <label for="example-search-input" class="control-label col-md-4">Duration <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Durasi waktu lembur hair stylist" data-container="body"></i></label>
                        <div class="col-md-2">
                            <input type="text" data-placeholder="select duration" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" name="duration" value="{{ $result['duration'] }}" data-show-meridian="false" id="duration" readonly @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>
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
                    <input type="hidden" name="id_hairstylist_schedule_date" value="">
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 text-center">
                            @if (empty($result['reject_at']))
                                @if(empty($result['approve']))
                                <a onclick="updateOvertime()" class="btn blue">Submit</a>
                                <a id="approve" class="btn green approve">Approve</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    


@endsection