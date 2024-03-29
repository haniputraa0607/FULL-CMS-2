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
    <a href="{{url('academy/transaction/outlet/course/detail/'.$outlet['id_outlet'].'/'.$course['id_product'])}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Info</span>
            </div>
            <div class="actions">
                <div style="border-bottom: solid 1px black;">
                    <h4><b>Final Score : {{$final_score}}</b></h4>
                </div>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-3"><b>User Name</b></div>
                <div class="col-md-6">: {{$user['name']}}</div>
            </div>
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-3"><b>User Phone</b></div>
                <div class="col-md-6">: {{$user['phone']}}</div>
            </div>
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
                <span class="caption-subject sbold uppercase font-blue">Theory Conclusion</span>
            </div>
        </div>
        <div class="portlet-body form">
            @foreach($conclusion as $c)
                <div class="row" style="margin-bottom: 1%">
                    <div class="col-md-5"><b>{{$c['theory_category_name']}}</b></div>
                    <div class="col-md-2"><input class="form-control" value="{{$c['conclusion_score']}}" disabled></div>
                </div>
            @endforeach
        </div>
    </div>

    <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
        <table class="table table-striped table-bordered table-hover" width="100%">
            <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
                <th>Theory Learned</th>
            </tr>
            </thead>
            <tbody>
            @if (!empty($schedule))
                @foreach ($schedule as $key=>$data)
                    <tr>
                        <td>{{date('d F Y H:i', strtotime($data['schedule_date']))}}</td>
                        <td>
                            @if($data['transaction_academy_schedule_status'] == 'Absent')
                                <b style="color: red">{{$data['transaction_academy_schedule_status']}}</b>
                            @elseif($data['transaction_academy_schedule_status'] == 'Attend')
                                <b style="color: green">{{$data['transaction_academy_schedule_status']}}</b>
                            @else
                                <b style="color: grey">{{$data['transaction_academy_schedule_status']}}</b>
                            @endif
                        </td>
                        <td>
                            @if(!empty($data['theory']))
                                <ul>
                                    @foreach($data['theory'] as $t)
                                        <li>{{$t['theory_title']}} : <b>{{$t['score']}}</b></li>
                                    @endforeach
                                </ul>
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
@endsection
