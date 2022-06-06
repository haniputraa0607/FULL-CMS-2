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
        attendance_status:{
            display:'Attendance Status',
            operator:[],
            opsi:[
                ['ontime', 'On Time'],
                ['late', 'Late'],
                ['absent', 'Absent'],
            ],
        },
        shift:{
            display:'Shift',
            operator:[],
            opsi:{!! json_encode(array_map(function ($sh) {
                return [$sh['shift_name'], $sh['shift_name']];
            }, $shift)) !!},
        },
        id_outlet:{
            display:'Outlet',
            operator:[],
            opsi:{!! json_encode(array_map(function ($item) {
                return [$item['id_outlet'], $item['outlet_name']];
            }, $outlets)) !!},
            type:'multiple_select',
            placeholder: 'Select Outlet'
        },
    };
</script>

<script type="text/javascript">
var table;
function showDetail(dom) {
    const data = $(dom).data('data');
    $('#modal-detail [name=date]').val(new Date(data.date).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric"}));
    $('#modal-detail [name=shift]').val(data.shift);
    $('#modal-detail [name=office]').val(data.office ? data.office : '-');
    $('#modal-detail [name=outlet]').val(data.in_outlet ? data.in_outlet : '-');
    $('#modal-detail [name=clock_in]').val(data.clock_in);
    $('#modal-detail [name=clock_out]').val(data.clock_out);

    let html = '';
    html = data.outlet_attendance_logs.map(item => {
        return `
        <tr>
            <td>${new Date(item.datetime).toLocaleString('id-ID',{hour:"2-digit",minute:"2-digit"})}</td>
            <td>${item.type == 'clock_in' ? 'Clock In' : 'Clock Out'}</td>
            <td>${item.notes ? item.notes : '-'}</td>
            <td>${item.latitude && item.longitude ? `<a href="https://maps.google.com/maps?q=${item.latitude},${item.longitude}" target="_blank">Show Location</a>` : '<em class="text-muted">No data</em>'}</td>
            <td>${item.photo_url ? `<a href="${item.photo_url}" target="_blank">Show Photo</a>` : '<em class="text-muted">No data</em>'}</td>
        </tr>
        `;
    }).join('');
    $('#modal-detail tbody').html(html);

    $('#modal-detail').modal('show');
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/'/g, '&apos;').replace(/"/g, '&quot;');
}

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
                data: 'date',
                render: data => new Date(data).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric"}),
            },
            {data: 'in_outlet'},
            {data: 'clock_in'},
            {data: 'clock_out'},
            {
                data: 'id',
                orderable: false,
                render: (data, type, full) => {
                    return `
                        <button onclick="showDetail(this)" data-data='${htmlEntities(JSON.stringify(full))}' class="btn btn-primary btn-sm">Detail</button>
                    `;
                }
            },
        ]
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
                <span class="caption-subject sbold uppercase font-blue">List Employee Attendance</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover" width="100%" id="main-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Outlet</th>
                        <th>Clock In</th>
                        <th>Clock Out</th>
                        <th>Action</th>
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
                        <label class="col-md-3 control-label">Office</label>
                        <div class="col-md-8">
                            <input type="text" name="office" class="form_datetime form-control"  disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label">Outlet</label>
                        <div class="col-md-8">
                            <input type="text" name="outlet" class="form_datetime form-control"  disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label">Shift</label>
                        <div class="col-md-8">
                            <input type="text" name="shift" class="form_datetime form-control"  disabled>
                        </div>
                    </div>
                    <h3>Clock In</h3>
                    <div class="form-group row">
                        <label class="col-md-3 control-label">Clock In</label>
                        <div class="col-md-8">
                            <input type="text" name="clock_in" class="form_datetime form-control"  disabled>
                        </div>
                    </div>
                    <h3>Clock Out</h3>
                    <div class="form-group row">
                        <label class="col-md-3 control-label">Clock Out</label>
                        <div class="col-md-8">
                            <input type="text" name="clock_out" class="form_datetime form-control"  disabled>
                        </div>
                    </div>
                    <h3>Attendance Outlet Logs</h3>
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