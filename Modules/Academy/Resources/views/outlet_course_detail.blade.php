@include('academy::filter')
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    @yield('filter_script')
    <script>
        rules = {
            all_data:{
                display:'All Data',
                operator:[],
                opsi:[]
            },
            name:{
                display:'Customer Name',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[]
            },
            phone:{
                display:'Customer Phone',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[]
            },
            email:{
                display:'Customer Email',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[]
            },
        };

        function changeColor(id, value) {
            if(value == 'Attend'){
                $('#status_'+id).css('color', 'green');
            }else if(value == 'Absent'){
                $('#status_'+id).css('color', 'red');
            }else if(value == 'Not Started'){
                $('#status_'+id).css('color', 'grey');
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
    <a href="{{url('academy/transaction/outlet/course')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    @yield('filter_view')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Info</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-3"><b>Outlet Name</b></div>
                <div class="col-md-6">: {{$outlet['outlet_code']}} - {{$outlet['outlet_name']}}</div>
            </div>
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-3"><b>Course Name</b></div>
                <div class="col-md-6">: {{$course['product_name']}}</div>
            </div>
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-3"><b>Duration</b></div>
                <div class="col-md-6">: {{$course['product_academy_duration']}} Month</div>
            </div>
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-3"><b>Total Meeting</b></div>
                <div class="col-md-6">: {{$course['product_academy_total_meeting']}} x @ {{$course['product_academy_hours_meeting']}} Hours</div>
            </div>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">List Student</span>
            </div>
        </div>
        <div class="portlet-body form">
            <br>
            <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                <table class="table table-striped table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Student Phone</th>
                        <th>Student Email</th>
                        <th>Final Score</th>
                        <th>Next Meet Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (!empty($users))
                        @foreach ($users as $key=>$data)
                            <tr>
                                <td>{{$data['name']}}</td>
                                <td>{{$data['phone']}}</td>
                                <td>{{$data['email']}}</td>
                                <td>{{$data['final_score']}}</td>
                                <td>
                                    @if(!empty($data['next_meeting']['schedule_date']))
                                        {{date('d F Y H:i', strtotime($data['next_meeting']['schedule_date']))}}
                                    @else
                                        No Schedule
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-sm yellow" target="_blank" href="{{url('academy/transaction/outlet/course/detail/history', $data['id_transaction_academy'])}}">Detail</a>
                                    @if(!empty($data['next_meeting']['schedule_date']))
                                        <a data-toggle="modal" href="#attendance_{{$data['id_transaction_academy']}}" class="btn btn-sm green-jungle">Attendance</a>
                                        <div class="modal fade" id="attendance_{{$data['id_transaction_academy']}}" tabindex="-1" role="basic" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Attendance {{$data['name']}} <b>({{date('d F Y H:i', strtotime($data['next_meeting']['schedule_date']))}})</b></h4>
                                                    </div>
                                                    <form class="form-horizontal" role="form" action="{{url('academy/transaction/outlet/course/detail/attendace')}}" method="post">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="col-md-2 control-label" style="text-align: left">
                                                                    Attendance <span class="required" aria-required="true">*</span>
                                                                </label>
                                                                <div class="col-md-6">
                                                                    <select class="form-control select2" id="status_{{$key}}" name="transaction_academy_schedule_status" style="color: grey;" onchange="changeColor({{$key}},this.value);" required>
                                                                        <option value="Not Started" style="color: grey">Not Started</option>
                                                                        <option value="Attend" style="color: green">Attend</option>
                                                                        <option value="Absent" style="color: red">Absent</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            @foreach($theories as $key=>$theory)
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label" style="text-align: left;margin-top: -1.1%">
                                                                        @if($key == 0)
                                                                        Theory <span class="required" aria-required="true">*</span>
                                                                        @endif
                                                                    </label>
                                                                    <div class="col-md-1">
                                                                        @if(in_array($theory['id_theory'], $data['theory_checked']))
                                                                            <i class="fa fa-check"></i>
                                                                        @else
                                                                            <div class="icheck-list">
                                                                                <label><input type="checkbox" class="icheck" name="id_theory[]" value="{{$theory['id_theory']}}"> </label>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        {{$theory['theory_title']}}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <input type="hidden" name="id_user" value="{{$data['id']}}">
                                                            <input type="hidden" name="id_transaction_academy" value="{{$data['id_transaction_academy']}}">
                                                            <input type="hidden" name="id_transaction_academy_schedule" value="{{$data['next_meeting']['id_transaction_academy_schedule']}}">
                                                        </div>
                                                        <div class="modal-footer" style="text-align: center">
                                                            {{ csrf_field() }}
                                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn green">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!empty($data['theory_checked']))
                                        <a data-toggle="modal" href="#score_{{$data['id_transaction_academy']}}" class="btn btn-sm blue">Final Score</a>
                                        <div class="modal fade" id="score_{{$data['id_transaction_academy']}}" tabindex="-1" role="basic" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Final Score {{$data['name']}}</h4>
                                                    </div>
                                                    <form class="form-horizontal" role="form" action="{{url('academy/transaction/outlet/course/detail/final-score')}}" method="post">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label" style="text-align: left">
                                                                    Score <span class="required" aria-required="true">*</span>
                                                                </label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" maxlength="5" name="final_score" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id_transaction_academy" value="{{$data['id_transaction_academy']}}">
                                                        <div class="modal-footer" style="text-align: center">
                                                            {{ csrf_field() }}
                                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn green">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr style="text-align: center"><td colspan="5">Data Not Available</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
