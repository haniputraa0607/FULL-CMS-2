@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp
@include('academy::filter')
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    @yield('filter_script')
    <script type="text/javascript">
        // range date trx, receipt, order id, outlet, customer
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

        $('#table-user_academy').dataTable({
            "ordering": false,
            "bLengthChange": false,
            ajax: {
                url : "{{url()->current()}}",
                type: 'GET',
                data: function (data) {
                    const info = $('#table-user_academy').DataTable().page.info();
                    data.page = (info.start / info.length) + 1;
                },
                dataSrc: (res) => {
                    $('#list-filter-result-counter').text(res.total);
                    return res.data;
                }
            },
            serverSide: true,
            columns: [
                {
                    data: 'id',
                    orderable: false,
                    render: function(value, type, row) {
                        const buttons = [
                            `<a class="btn blue btn-sm btn-outline" href="{{url('academy/transaction/user/schedule/detail')}}/${value}"><i class="fa fa-edit"></i> Schedule</a>`
                        ];

                        return buttons.join('');
                    }
                },
                {
                    data: 'name',
                    render: function(value, type, row) {
                        return `${row.name}`;
                    }
                },
                {
                    data: 'phone',
                    render: function(value, type, row) {
                        return `${row.phone}`;
                    }
                },
                {
                    data: 'email',
                    render: function(value, type, row) {
                        return `${row.email}`;
                    }
                }
            ],
            searching: false,
            drawCallback: function( oSettings ) {
                $('.tooltips').tooltip();
            },
            order: [[ 1, "desc" ]]
        });


        $(document).ready(function() {
            $(".form_datetime").datetimepicker({
                format: "d-M-yyyy hh:ii",
                autoclose: true,
                todayBtn: true,
                minuteStep: 1,
                endDate: new Date()
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
    @yield('filter_view')
    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">User Academy</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" width="100%" id="table-user_academy">
                <thead>
                <tr>
                    <th>Actions</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

@endsection
