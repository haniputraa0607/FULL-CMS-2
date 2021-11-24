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
    <script>
        $(".form_datetime").datetimepicker({
            format: "d-M-yyyy hh:ii",
            autoclose: true,
            todayBtn: true,
            minuteStep:1
        });
        
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
    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Schedule</span>
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
                <table class="table table-striped table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <th>Transaction Date</th>
                        <th>Recipt Number</th>
                        <th>Outlet</th>
                        <th>Course Name</th>
                        <th>Payment Type</th>
                        <th>Payment Status</th>
                        <th>Schedule</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($result as $res)
                            <tr>
                                <td>{{date('d M Y H:i', strtotime($res['transaction_date']))}}</td>
                                <td>{{$res['transaction_receipt_number']}}</td>
                                <td>{{$res['outlet']['outlet_code']}} - {{$res['outlet']['outlet_name']}}</td>
                                <td>{{$res['product_name']}}</td>
                                <td>
                                    @if($res['payment_method'] == 'one_time_payment')
                                        One-time Payment
                                    @else
                                        Cicilan Bertahap
                                    @endif
                                </td>
                                <td>
                                    @if ($res['transaction_payment_status'] == 'Completed')
                                        <div class="badge badge-success">Completed</div>
                                    @elseif($res['transaction_payment_status'] == 'Cancelled')
                                        <div class="badge badge-danger">Cancelled</div>
                                    @else
                                        <div class="badge badge-warning">Pending</div>
                                    @endif
                                </td>
                                <td>
                                    @if($res['transaction_payment_status'] != 'Cancelled')<a data-toggle="modal" href="#{{$res['transaction_receipt_number']}}" class="btn btn-sm blue"><i class="fa fa-edit"></i></a>@endif
                                </td>
                            </tr>
                            @if($res['transaction_payment_status'] != 'Cancelled')
                            <div class="modal fade" id="{{$res['transaction_receipt_number']}}" tabindex="-1" role="basic" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Schedule {{$res['product_name']}}</h4>
                                        </div>
                                        <form class="form-horizontal" role="form" action="{{url('academy/transaction/user/schedule/update/'.$res['id_transaction_academy'])}}" method="post">
                                        <div class="modal-body">
                                            <div @if($res['transaction_academy_total_meeting'] > 20) style="height: 600px;overflow-y: scroll;overflow-x: hidden" @endif>
                                                <?php
                                                if(!empty($res['transaction_academy_total_meeting'])){
                                                    $string = '';
                                                    $userSchedule = $res['transaction_academy']['user_schedule'];
                                                    $arrColumn = array_column($userSchedule, 'meeting');
                                                    $color = [
                                                        'Not Started' => 'grey',
                                                        'Attend' => 'green',
                                                        'Absent' => 'red'
                                                    ];
                                                    for($i=0;$i<$res['transaction_academy_total_meeting'];$i++){
                                                        $string .= '<div class="row">';
                                                        $string .= '<div class="col-md-6" style="margin-top: 2%">';
                                                        $string .= '<b>Pertemuan '.($i+1).'</b>';
                                                        $string .= '<div class="input-group">';
                                                        $search = array_search(($i+1), $arrColumn);
                                                        if($search === false){
                                                            $string .= '<input type="text" name="date['.($i+1).'][date]" class="form_datetime form-control" name="birthdate"  required autocomplete="off">';
                                                        }else{
                                                            $string .= '<input type="text" name="date['.($i+1).'][date]" class="form_datetime form-control" name="birthdate" value="'.date('d-M-Y H:i', strtotime($userSchedule[$search]['schedule_date'])).'" required autocomplete="off">';
                                                            $string .= '<input type="hidden" name="date['.($i+1).'][id_transaction_academy_schedule]" value="'.$userSchedule[$search]['id_transaction_academy_schedule'].'">';
                                                        }
                                                        $string .= '<span class="input-group-btn">';
                                                        $string .= '<button class="btn default" type="button">';
                                                        $string .= '<i class="fa fa-calendar"></i>';
                                                        $string .= '</button>';
                                                        $string .= '</span>';
                                                        $string .= '</div>';
                                                        $string .= '</div>';
                                                        $string .= '<div class="col-md-5" style="margin-top: 6%">';
                                                        if($search !== false){
                                                            $string .= '<select class="form-control select2" id="status_'.($i+1).'" name="date['.($i+1).'][transaction_academy_schedule_status]" style="color:'.$color[$userSchedule[$search]['transaction_academy_schedule_status']].';" onchange="changeColor('.($i+1).' ,this.value);">';
                                                            $string .= '<option '.($userSchedule[$search]['transaction_academy_schedule_status'] == 'Not Started' ? 'selected':'').' value="Not Started" style="color: grey">Not Started</option>';
                                                            $string .= '<option '.($userSchedule[$search]['transaction_academy_schedule_status'] == 'Attend' ? 'selected':'').' value="Attend" style="color: green">Attend</option>';
                                                            $string .= '<option '.($userSchedule[$search]['transaction_academy_schedule_status'] == 'Absent' ? 'selected':'').' value="Absent" style="color: red">Absent</option>';
                                                            $string .= '</select>';
                                                        }else{
                                                            $string .= '<select class="form-control select2" id="status_'.($i+1).'" name="date['.($i+1).'][transaction_academy_schedule_status]" style="color: grey;" onchange="changeColor('.($i+1).' ,this.value);">';
                                                            $string .= '<option value="Not Started" style="color: grey">Not Started</option>';
                                                            $string .= '<option value="Attend" style="color: green">Attend</option>';
                                                            $string .= '<option value="Absent" style="color: red">Absent</option>';
                                                            $string .= '</select>';
                                                        }

                                                        $string .= '</div>';
                                                        $string .= '</div>';
                                                    }

                                                    echo $string;
                                                }else{
                                                    echo '<h4><b>Data Not Found</b></h4>';
                                                }
                                                ?>
                                            </div>
                                            <input type="hidden" name="id_user" value="{{$res['id_user']}}">
                                        </div>
                                        <div class="modal-footer">
                                            {{ csrf_field() }}
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                            @if(!empty($res['transaction_academy_total_meeting']))
                                            <button type="submit" class="btn green">Save changes</button>
                                            @endif
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3><b>Data Not Found</b></h3>
            @endif
        </div>
    </div>

@endsection
