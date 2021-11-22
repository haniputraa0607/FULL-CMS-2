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
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
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

        $('#table-day_off_user_academy').dataTable({
            "ordering": false,
            "bLengthChange": false,
            ajax: {
                url : "{{url()->current()}}",
                type: 'GET',
                data: function (data) {
                    const info = $('#table-day_off_user_academy').DataTable().page.info();
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
                        if(row.approve_by == null && row.reject_by == null){
                            var html =
                                '<a class="btn green-jungle btn-sm sweetalert-approve" data-id="'+row.id_transaction_academy_schedule_day_off+'" data-name="'+row.name+'" data-dateold="'+row.schedule_date_old+'" data-datenew="'+row.schedule_date_new+'"> Approve</a>'+
                                '<a class="btn red btn-sm sweetalert-reject" data-id="'+row.id_transaction_academy_schedule_day_off+'" data-name="'+row.name+'" data-dateold="'+row.schedule_date_old+'" data-datenew="'+row.schedule_date_new+'"> Reject</a>'
                            ;
                        }else if(row.approve_by !== null){
                            var html = '<div class="badge" style="background-color: #26C281">Approved by '+row.approve_by_name+'</div>';
                        }else if(row.reject_by != null){
                            var html = '<div class="badge badge-danger">Rejected by '+row.reject_by_name+'</div>';
                        }

                        return html;
                    }
                },
                {
                    data: 'request_date',
                    render: function(value, type, row) {
                        return `${row.request_date}`;
                    }
                },
                {
                    data: 'name',
                    render: function(value, type, row) {
                        return '<b>Name :</b> '+ row.name+'<br><b>Phone :</b> '+row.phone+'<br><b>Email :</b> '+row.email;
                    }
                },
                {
                    data: 'schedule_date_old',
                    render: function(value, type, row) {
                        return `${row.schedule_date_old}`;
                    }
                },
                {
                    data: 'schedule_date_new',
                    render: function(value, type, row) {
                        return `${row.schedule_date_new}`;
                    }
                }
            ],
            searching: false,
            drawCallback: function( oSettings ) {
                $('.tooltips').tooltip();
                SweetAlertApprove.init();
                SweetAlertReject.init();
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

            SweetAlertApprove.init();
            SweetAlertReject.init();
        });

        var SweetAlertApprove = function() {
            return {
                init: function() {
                    $(".sweetalert-approve").each(function() {
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        let dateOld = $(this).data('dateold');
                        let dateNew = $(this).data('datenew');

                        var data = {
                                '_token' : '{{csrf_token()}}',
                                'id_transaction_academy_schedule_day_off':id,
                                'status': 'approve'
                            };
                        $(this).click(function() {
                            swal({
                                    title: "<b>Name :</b> "+name+"<br><b>Schedule old :</b> "+dateOld+"<br><b>Schedule new :</b> "+dateNew+"<br><br>Are you sure want to approve this day off?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    html: true,
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, approve it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('academy/transaction/user/schedule/day-off/action')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal({
                                                    title: 'Success!',
                                                    type: 'success',
                                                    showCancelButton: false,
                                                    showConfirmButton: false
                                                });
                                                window.location.reload();
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed update data .", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();

        var SweetAlertReject = function() {
            return {
                init: function() {
                    $(".sweetalert-reject").each(function() {
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        let dateOld = $(this).data('dateold');
                        let dateNew = $(this).data('datenew');

                        var data = {
                            '_token' : '{{csrf_token()}}',
                            'id_transaction_academy_schedule_day_off':id,
                            'status': 'reject'
                        };
                        $(this).click(function() {
                            swal({
                                    title: "<b>Name :</b> "+name+"<br><b>Schedule old :</b> "+dateOld+"<br><b>Schedule new :</b> "+dateNew+"<br><br>Are you sure want to reject this day off?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    html: true,
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, approve it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('academy/transaction/user/schedule/day-off/action')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal({
                                                    title: 'Success!',
                                                    type: 'success',
                                                    showCancelButton: false,
                                                    showConfirmButton: false
                                                });
                                                window.location.reload();
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed update data .", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();
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
                <span class="caption-subject font-blue sbold uppercase">Day Off User Academy</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" width="100%" id="table-day_off_user_academy" style="white-space: nowrap;">
                <thead>
                <tr>
                    <th>Actions</th>
                    <th>Request Date</th>
                    <th>Data User</th>
                    <th>Old Schedule</th>
                    <th>New Schedule</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

@endsection
