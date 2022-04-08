@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/global.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script>
        $('.timepicker').timepicker({
            autoclose: true,
            showSeconds: false,
        });

        var tmp = [0];
        function changeType(value) {
            if(value == 'Use Shift'){
                $('#use_shift').show();
                $('#without_shift').hide();

                if(tmp.length == 0){
                    addShift();
                }
                $('.shift_name').prop('required', true);
            }else{
                $('.shift_name').prop('required', false);
                $('#use_shift').hide();
                $('#without_shift').show();
            }
        }
        
        var i=1;
        function addShift() {
            var html =  '<div class="form-group" id="div_shift_child_'+i+'">'+
                        '<div class="col-md-3" style="text-align: right">'+
                        '<a class="btn btn-danger" onclick="deleteChild('+i+')">&nbsp;<i class="fa fa-trash"></i></a>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input name="shift['+i+'][name]" class="form-control shift_name" placeholder="Shift Name" required>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input type="text" style="background-color: white" id="time_start_'+i+'" data-placeholder="select time" name="shift['+i+'][start]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input type="text" style="background-color: white" id="time_end_'+i+'" data-placeholder="select time" name="shift['+i+'][end]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>'+
                        '</div>'+
                        '</div>';

            $("#div_shift_child").append(html);
            $('.timepicker').timepicker({
                autoclose: true,
                showSeconds: false,
            });
            tmp.push(i);
            i++;
        }

        function deleteChild(number){
            $('#div_shift_child_'+number).remove();
            var index = tmp.indexOf(number);
            if(index >= 0){
                tmp.splice(index, 1);
            }
        }
        
        function submit() {
            var name = $("#office_hour_name").val();
            var type = $("#office_hour_type").val();

            var err = '';
            if(name.trim().length === 0){
                err += 'Please input data name.\n';
            }

            if(type === ''){
                err += 'Please select type.\n';
            }

            if(type == 'Use Shift'){
                $('.shift_name').each(function(i, obj) {
                    var shift_name = this.value;
                    if(shift_name.trim().length === 0){
                        err += 'Please input data shift name.\n';
                        return false;
                    }
                });

                for (var j=0;j<tmp.length;j++){
                    var time_start = $('#time_start_'+tmp[j]).val();
                    var time_end = $('#time_end_'+tmp[j]).val();

                    if(time_start == '0:00' && time_end == '0:00'){
                        err += 'Time can not be 0:00 - 0:00\n';
                        break;
                    }
                }
            }else{
                var time_start = $('#time_start').val();
                var time_end = $('#time_end').val();

                if(time_start == '0:00' && time_end == '0:00'){
                    err += 'Time can not be 0:00 - 0:00\n';
                }
            }

            if(err !== ''){
                swal("Error!", err, "error");
            }else{
                $('form#form_submit').submit();
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
                <span class="caption-subject font-blue sbold uppercase">{{$sub_title??""}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" id="form_submit" role="form" action="{{url('employee/office-hours/create')}}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Default Office Hours</label>
                        <div class="col-md-8" style="margin-top: 0.7%">
                            <div class="icheck-list">
                                <label><input type="checkbox" class="icheck" name="employee_office_hour_default"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama jam kerja" data-container="body"></i>
                        </label>
                        <div class="col-md-5">
                            <input name="office_hour_name" id="office_hour_name" class="form-control" required placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Type <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe jam kerja" data-container="body"></i>
                        </label>
                        <div class="col-md-3">
                            <select class="form-control select2" id="office_hour_type" name="office_hour_type" onchange="changeType(this.value)" required>
                                <option></option>
                                <option value="Use Shift">Use Shift</option>
                                <option value="Without Shift">Without Shift</option>
                            </select>
                        </div>
                    </div>
                    <div id="without_shift" style="display: none">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Time <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Jam mulai dan jam selesai kerja" data-container="body"></i>
                            </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="text" style="background-color: white" data-placeholder="select time" id="time_start" name="office_hour_start" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="text" style="background-color: white" data-placeholder="select time" id="time_end" name="office_hour_end" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="use_shift" style="display: none">
                        <div class="form-group">
                            <div class="col-md-3"></div>
                            <div class="col-md-4">
                                <a class="btn btn-primary" onclick="addShift()">&nbsp;<i class="fa fa-plus-circle"></i> Add Shift </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">Shift Name</div>
                            <div class="col-md-3">Shift Start</div>
                            <div class="col-md-3">Shift End</div>
                        </div>
                        <div id="div_shift_child">
                            <div class="form-group" id="div_shift_child_0">
                                <div class="col-md-3" style="text-align: right">
                                    <a class="btn btn-danger" onclick="deleteChild(0)">&nbsp;<i class="fa fa-trash"></i></a>
                                </div>
                                <div class="col-md-3">
                                    <input name="shift[0][name]" class="form-control shift_name" placeholder="Shift Name">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" style="background-color: white" data-placeholder="select time" id="time_start_0"  name="shift[0][start]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" style="background-color: white" data-placeholder="select time" id="time_end_0" name="shift[0][end]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
            </form>
            <div class="form-actions" style="text-align: center">
                <button onclick="submit()" class="btn blue">Submit</button>
            </div>
        </div>
    </div>
@endsection
