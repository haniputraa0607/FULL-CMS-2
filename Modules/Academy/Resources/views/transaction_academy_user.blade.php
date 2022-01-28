@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
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

    <a href="{{url('academy/transaction/user/schedule')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Student Schedule</span>
            </div>
        </div>
        <div class="portlet-body">
            @if(!empty($result))
                <div class="row">
                    <div class="col-md-1"><b>Name</b> </div>
                    <div class="col-md-5">: {{$result[0]['user']['name']}}</div>
                </div>
                <div class="row">
                    <div class="col-md-1"><b>Phone</b> </div>
                    <div class="col-md-5">: {{$result[0]['user']['phone']}}</div>
                </div>
                <div class="row">
                    <div class="col-md-1"><b>Email</b> </div>
                    <div class="col-md-5">: {{$result[0]['user']['email']}}</div>
                </div>
                <br>
                <br>
                <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                    <table class="table table-striped table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>Payment Status</th>
                            <th>Payment Type</th>
                            <th>Transaction Date</th>
                            <th>Recipt Number</th>
                            <th>Outlet</th>
                            <th>Course Name</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($result as $res)
                                <tr>
                                    <td>
                                        @if($res['transaction_payment_status'] != 'Cancelled')
                                            <a href="{{url('academy/transaction/user/schedule/detail/list/'.$res['id_transaction_academy'])}}" target="_blank" class="btn btn-sm blue">Schedule</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($res['transaction_payment_status'] == 'Completed')
                                            <div class="badge badge-success">Completed</div>
                                        @elseif($res['transaction_payment_status'] == 'Cancelled')
                                            <div class="badge badge-danger">Cancelled</div>
                                        @elseif($res['payment_method'] != 'one_time_payment' && $res['transaction_payment_status'] == 'Pending')
                                            <div class="badge badge-warning">Pending {{count($res['transaction_academy']['completed_installment'])}}/{{count($res['transaction_academy']['all_installment'])}}</div>
                                        @else
                                            <div class="badge badge-warning">Pending</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($res['payment_method'] == 'one_time_payment')
                                            One-time Payment
                                        @else
                                            Cicilan Bertahap
                                        @endif
                                    </td>
                                    <td>{{date('d M Y H:i', strtotime($res['transaction_date']))}}</td>
                                    <td><a href="{{url('transaction/academy/detail/'.$res['id_transaction'])}}" target="_blank">{{$res['transaction_receipt_number']}}</a></td>
                                    <td>{{$res['outlet']['outlet_code']}} - {{$res['outlet']['outlet_name']}}</td>
                                    <td>{{$res['product_name']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h3><b>Data Not Found</b></h3>
            @endif
        </div>
    </div>

@endsection
