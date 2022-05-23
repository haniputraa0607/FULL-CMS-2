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
        name:{
            display:'Employee Name',
            operator:[
                ['=','='],
                ['like','like'],
            ],
            opsi:[],
        },
        id_role:{
            display:'Role',
            operator:[],
            opsi:{!! json_encode(array_map(function ($item) {
                return [$item['id_role'], $item['role_name']];
            }, $roles)) !!},
        },
        id_outlets:{
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
$(document).ready(function() {
    table = $('#main-table').DataTable({
        serverSide: true, 
        searching: false,
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
            {data: 'name'},
            {data: 'role_name'},
            {data: 'total_pending'},
            {
                data: 'id',
                orderable: false,
                render: (data, type, full) => {
                    return `
                        <a href="${'{{url('employee/attendance-outlet/pending/detail/::id::')}}'.replace('::id::', data)}" class="btn btn-primary btn-sm">Detail</a>
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
                <span class="caption-subject sbold uppercase font-blue">List Employee Attendance Outlet</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover" width="100%" id="main-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Total Pending</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection