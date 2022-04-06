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
@endsection

@section('page-script')
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

        function changeType(value) {
            if(value == 'Use Shift'){
                $('#use_shift').show();
                $('#without_shift').hide();
            }else{
                $("#div_shift_child").empty();
                $('#use_shift').hide();
                $('#without_shift').show();
            }
        }
        
        var i={{count($detail['office_hour_shift']??[])}};
        function addShift() {
            var html =  '<div class="form-group" id="div_shift_child_'+i+'">'+
                        '<div class="col-md-3" style="text-align: right">'+
                        '<a class="btn btn-danger" onclick="deleteChild('+i+')">&nbsp;<i class="fa fa-trash"></i></a>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input name="shift['+i+'][name]" class="form-control" placeholder="Shift Name">'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input type="text" style="background-color: white" data-placeholder="select time" name="shift['+i+'][start]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input type="text" style="background-color: white" data-placeholder="select time" name="shift['+i+'][end]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>'+
                        '</div>'+
                        '</div>';

            $("#div_shift_child").append(html);
            $('.timepicker').timepicker({
                autoclose: true,
                showSeconds: false,
            });
            i++;
        }

        function deleteChild(number){
            $('#div_shift_child_'+number).remove();
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

    <a href="{{url('employee/office-hours')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    @include('layouts.notifications')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">{{$sub_title??""}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" id="form" role="form" action="{{url('employee/office-hours/update', $detail['id_employee_office_hour'])}}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Default Office Hours</label>
                        <div class="col-md-8" style="margin-top: 0.7%">
                            <div class="icheck-list">
                                <label><input type="checkbox" class="icheck" name="employee_office_hour_default" @if($detail['employee_office_hour_default'] == $detail['id_employee_office_hour']) checked @endif> </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama jam kerja" data-container="body"></i>
                        </label>
                        <div class="col-md-5">
                            <input name="office_hour_name" class="form-control" required placeholder="Name" value="{{$detail['office_hour_name']}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Type <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe jam kerja" data-container="body"></i>
                        </label>
                        <div class="col-md-3">
                            <select class="form-control select2" name="office_hour_type" onchange="changeType(this.value)" required>
                                <option></option>
                                <option value="Use Shift" @if($detail['office_hour_type'] == 'Use Shift') selected @endif>Use Shift</option>
                                <option value="Without Shift" @if($detail['office_hour_type'] == 'Without Shift') selected @endif>Without Shift</option>
                            </select>
                        </div>
                    </div>
                    <div id="without_shift" @if($detail['office_hour_type'] == 'Use Shift') style="display: none" @endif>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Time <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Jam mulai dan jam selesai kerja" data-container="body"></i>
                            </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="text" style="background-color: white" data-placeholder="select time" name="office_hour_start" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" @if(empty($detail['office_hour_start'])) value="00:00" @else value="{{date('H:i:s', strtotime($detail['office_hour_start']))}}" @endif readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="text" style="background-color: white" data-placeholder="select time" name="office_hour_end" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" @if(empty($detail['office_hour_end'])) value="00:00" @else value="{{date('H:i:s', strtotime($detail['office_hour_end']))}}" @endif readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="use_shift" @if($detail['office_hour_type'] == 'Without Shift') style="display: none" @endif>
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
                            @foreach($detail['office_hour_shift'] as $key=>$val)
                                <div class="form-group" id="div_shift_child_{{$key}}">
                                    <div class="col-md-3" style="text-align: right">
                                        <a class="btn btn-danger" onclick="deleteChild({{$key}})">&nbsp;<i class="fa fa-trash"></i></a>
                                    </div>
                                    <div class="col-md-3">
                                        <input name="shift[{{$key}}][name]" class="form-control" placeholder="Shift Name" value="{{$val['shift_name']}}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" style="background-color: white" data-placeholder="select time" name="shift[{{$key}}][start]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="{{date('H:i:s', strtotime($val['shift_start']))}}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" style="background-color: white" data-placeholder="select time" name="shift[{{$key}}][end]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="{{date('H:i:s', strtotime($val['shift_end']))}}" readonly>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-actions" style="text-align: center">
                    {{ csrf_field() }}
                    <button type="submit" class="btn blue">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection