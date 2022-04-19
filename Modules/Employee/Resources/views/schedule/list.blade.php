<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script>
        var SweetAlert = function() {
            return {
                init: function() {
                    $(".sweetalert-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to delete this candidate?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, delete it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{ url('recruitment/hair-stylist/schedule/delete') }}",
                                        data : "_token="+token+"&id_user_hair_stylist="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                swal("Deleted!", "Candidate has been deleted.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('recruitment/hair-stylist/schedule')}}";
                                            }
                                            else if(result.status == "fail"){
                                                swal("Error!", "Failed to delete candidate. Candidate has been used.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete candidate.", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();

        jQuery(document).ready(function() {
            SweetAlert.init()
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

    <h1 class="page-title" style="margin-top: 0px;">
        {{$sub_title}}
    </h1>
    @include('layouts.notifications')

    <?php
    $date_start = '';
    $date_end = '';

    if(Session::has('filter-employee-schedule')){
        $search_param = Session::get('filter-employee-schedule');
        if(isset($search_param['date_start'])){
            $date_start = $search_param['date_start'];
        }

        if(isset($search_param['date_end'])){
            $date_end = $search_param['date_end'];
        }

        if(isset($search_param['rule'])){
            $rule = $search_param['rule'];
        }

        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
        }
    }
    ?>

    <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
        {{ csrf_field() }}
        @include('employee::schedule.filter')
    </form>

    <br>
    <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col" width="5%" class="text-center"> Action </th>
                <th scope="col" width="10%" class="text-center"> Name </th>
                <th scope="col" width="15%" class="text-center"> Phone </th>
                <th scope="col" width="20%" class="text-center"> Office </th>
                <th scope="col" width="20%" class="text-center"> Role Shift </th>
                <th scope="col" width="10%" class="text-center"> Status </th>
                <th scope="col" width="10%" class="text-center"> Month </th>
                <th scope="col" width="10%" class="text-center"> Year </th>
                <th scope="col" width="15%" class="text-center"> Request Date </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($data))
                @foreach($data as $val)
                	@php
                		$status = $val['office_hour_type'] == 'Without Shift' ? 'Non Shift' : ($val['approve_at'] ? 'Approved' : ($val['reject_at'] ? 'Rejected' : 'Pending'));
                		$color = ($status == 'Approved') ? '#26C281' : (($status == 'Rejected') ? '#E7505A' : '#ffc107');
                		$textColor = ($status == 'Pending') ? '#fff' : '#fff';
                		$month = date('F', mktime(0, 0, 0, $val['schedule_month'], 10));
                	@endphp
                    <tr>
                        <td>
                            @if(MyHelper::hasAccess([348,349], $grantedFeature))
                                <a class="btn btn-sm btn-info" target="_blank" href="{{ url('recruitment/hair-stylist/schedule/detail', $val['id_employee_schedule']) }}"><i class="fa fa-edit"></i></a>
                            @endif
                        </td>
                        <td>{{ $val['name'] }}</td>
                        <td class="text-center">{{ $val['phone'] }}</td>
                        <td>{{ $val['outlet_code'] .' - '. $val['outlet_name'] }}</td>
                        <td>{{ $val['role_name'] .' - '. $val['office_hour_type'] }}</td>
                        <td class="text-center">
                            @if($status == 'Non Shift')
                            -
                            @else
                            <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: {{ $color }};padding: 5px 12px;color: {{ $textColor }};">{{ $status }}</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $month }}</td>
                        <td class="text-center">{{ $val['schedule_year'] }}</td>
                        <td class="text-center">{{ date('d M Y H:i', strtotime($val['request_at'])) }}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
            @endif
            </tbody>
        </table>
    </div>
    <br>
    @if ($dataPaginator)
        {{ $dataPaginator->links() }}
    @endif
@endsection