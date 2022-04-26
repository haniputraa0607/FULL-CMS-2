@include('filter-v2')

@section('page-style')
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
@yield('filter_script')

<script>
    rules={
        all_data:{
            display:'All Data',
            operator:[],
            opsi:[]
        },
        shift:{
            display:'Shift',
            operator:[],
            opsi:{!! json_encode(array_map(function ($sh) {
                return [$sh['shift_name'], $sh['shift_name']];
            }, $shift)) !!},
        },
        type:{
            display:'Type',
            operator:[],
            opsi:[
                ['clock_in', 'Clock In'],
                ['clock_out', 'Clock Out'],
            ],
        },
    };
</script>

<script type="text/javascript">
var table;
$(document).ready(function() {
    table = $('#main-table').DataTable({
        serverSide: true, 
        ajax: {
            url : "{{url()->current()}}",
            data: function (data) {
                const info = $('#main-table').DataTable().page.info();
                data.page = (info.start / info.length) + 1;
            },
            dataSrc: (res) => {
                $('#list-filter-result-counter').text(res.recordsTotal);
                return res.data;
            }
        },
        columns: [
            {
                data: 'datetime',
                render: data => new Date(data).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric",hour:"2-digit",minute:"2-digit"}),
            },
            {data: 'shift'},
            {
                data: 'type',
                render: data => data == 'clock_in' ? 'Clock In' : 'Clock Out',
            },
            {
                data: 'type',
                render: (data, type, full) => data == 'clock_in' ? full.clock_in_requirement : full.clock_out_requirement,
            },
            {
                data: 'latitude',
                render: (data, type, full) => full.latitude && full.longitude ? `<a href="https://maps.google.com/maps?q=${full.latitude},${full.longitude}" target="_blank">Show Location</a>` : '<em class="text-muted">No data</em>',
            },
            {
                data: 'photo_url',
                render: data => data ? `<a href="${data}" target="_blank">Show Photo</a>` : '<em class="text-muted">No data</em>',
            },
            {
                data: 'notes',
                render: data => data ? data : '-',
            },
            {
                data: 'id_employee_attendance_log',
                orderable: false,
                render: (data, type, full) => {
                    return `
                        <form action="{{url()->current()}}/update" method="post">
                        @csrf
                        <input type="hidden" name="id_employee_attendance_log" value="${data}"/>
                        <button type="submit" name="status" value="Approved" class="btn btn-primary btn-sm btn-inline" data-toggle="confirmation"><i class="fa fa-check"></i></button>
                        <button type="submit" name="status" value="Rejected" class="btn btn-danger btn-sm btn-inline" data-toggle="confirmation"><i class="fa fa-times"></i></button>
                        </form>
                    `;
                }
            },
        ],
        drawCallback: item => $('[data-toggle=confirmation]').confirmation(),
    });
});
</script>
@endsection

@extends('layouts.main')

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
    @yield('filter_view')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">List Pending Attendance</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover" width="100%" id="main-table">
                <thead>
                    <tr>
                        <th>Datetime</th>
                        <th>Shift</th>
                        <th>Type</th>
                        <th>Requirement</th>
                        <th>Location</th>
                        <th>Photo</th>
                        <th>Notes</th>
                        <th width="70px">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-detail" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Attendance Detail</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-3 control-label">Date</label>
                        <div class="col-md-8">
                            <input type="text" name="date" class="form_datetime form-control"  disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label">Shift</label>
                        <div class="col-md-8">
                            <input type="text" name="shift" class="form_datetime form-control"  disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label">Attendance Status</label>
                        <div class="col-md-8">
                            <input type="text" name="status" class="form_datetime form-control"  disabled>
                        </div>
                    </div>
                    <h3>Clock In</h3>
                    <div class="form-group row">
                        <label class="col-md-3 control-label">Clock In Requirement</label>
                        <div class="col-md-8">
                            <input type="text" name="clock_in_requirement" class="form_datetime form-control"  disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label">Clock In</label>
                        <div class="col-md-8">
                            <input type="text" name="clock_in" class="form_datetime form-control"  disabled>
                        </div>
                    </div>
                    <h3>Clock Out</h3>
                    <div class="form-group row">
                        <label class="col-md-3 control-label">Clock Out Requirement</label>
                        <div class="col-md-8">
                            <input type="text" name="clock_out_requirement" class="form_datetime form-control"  disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label">Clock Out</label>
                        <div class="col-md-8">
                            <input type="text" name="clock_out" class="form_datetime form-control"  disabled>
                        </div>
                    </div>
                    <h3>Attendance Logs</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Type</th>
                                <th>Notes</th>
                                <th>Location</th>
                                <th>Photo</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection