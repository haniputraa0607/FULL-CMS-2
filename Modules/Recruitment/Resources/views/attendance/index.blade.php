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
        user_hair_stylist_code:{
            display:'Hairstylist Code',
            operator:[
                ['=','='],
                ['like','like'],
            ],
            opsi:[],
        },
        fullname:{
            display:'Hairstylist Name',
            operator:[
                ['=','='],
                ['like','like'],
            ],
            opsi:[],
        },
        level:{
            display:'Hairstylist Level',
            operator:[
            ],
            opsi:[
                ['Hairstylist', 'Hairstylist'],
                ['Supervisor', 'Supervisor']
            ],
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
            {data: 'user_hair_stylist_code'},
            {data: 'fullname'},
            {data: 'total_schedule'},
            {data: 'total_ontime'},
            {data: 'total_late'},
            {data: 'total_absent'},
            {
                data: 'id_user_hair_stylist',
                orderable: false,
                render: (data, type, full) => {
                    return `
                        <a href="${'{{url('recruitment/hair-stylist/attendance/detail/::id::')}}'.replace('::id::', data)}" class="btn btn-primary btn-sm">Detail</a>
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
                <span class="caption-subject sbold uppercase font-blue">List Hairstylist Attendance</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover" width="100%" id="main-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Schedule</th>
                        <th>On Time</th>
                        <th>Late</th>
                        <th>Absent</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection