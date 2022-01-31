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

    <a href="{{url('academy/transaction/user/schedule/detail', $res['id_user'])}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Schedule</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-3"><b>Name</b> </div>
                <div class="col-md-5">: {{$res['user']['name']}}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Phone</b> </div>
                <div class="col-md-5">: {{$res['user']['phone']}}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Email</b> </div>
                <div class="col-md-5">: {{$res['user']['email']}}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Outlet</b> </div>
                <div class="col-md-5">: {{$res['outlet']['outlet_code']}} - {{$res['outlet']['outlet_name']}}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Course Name</b> </div>
                <div class="col-md-5">: {{$res['product_name']}}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Recipt Number</b> </div>
                <div class="col-md-5">: {{$res['transaction_receipt_number']}}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Transaction Date</b> </div>
                <div class="col-md-5">: {{date('d F Y H:i', strtotime($res['transaction_date']))}}</div>
            </div>
            <br>
            @if($res['status_dp'] == false)
                <div class="alert alert-block alert-danger fade in">
                    <p class="alert-heading">Can not setting schedule because <b>Down Payment</b> has not reached 50%.</p>
                </div>
            @endif
            <form class="form-horizontal" role="form" action="{{url('academy/transaction/user/schedule/update/'.$res['id_transaction_academy'])}}" method="post">
                <div class="form-body">
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
                        for($i=1;$i<=$res['transaction_academy_total_meeting'];$i++){
                            $string .= '<div class="row">';
                            $string .= '<div class="col-md-6" style="margin-top: 2%">';
                            $string .= '<b>Pertemuan '.($i).'</b>';
                            $string .= '<div class="input-group">';
                            $search = array_search(($i), $arrColumn);
                            if($search === false){
                                $string .= '<input type="text" name="date['.($i).'][date]" class="form_datetime form-control" required autocomplete="off" readonly style="background-color:white;">';
                            }else{
                                $string .= '<input type="text" name="date['.($i).'][date]" class="form_datetime form-control" value="'.date('d-M-Y H:i', strtotime($userSchedule[$search]['schedule_date'])).'" required autocomplete="off" readonly style="background-color:white;">';
                                $string .= '<input type="hidden" name="date['.($i).'][id_transaction_academy_schedule]" value="'.$userSchedule[$search]['id_transaction_academy_schedule'].'">';
                            }
                            $string .= '<span class="input-group-btn">';
                            $string .= '<button class="btn default" type="button">';
                            $string .= '<i class="fa fa-calendar"></i>';
                            $string .= '</button>';
                            $string .= '</span>';
                            $string .= '</div>';
                            $string .= '</div>';

                            if(($i+1) <= $res['transaction_academy_total_meeting']){
                                $string .= '<div class="col-md-6" style="margin-top: 2%">';
                                $string .= '<b>Pertemuan '.($i+1).'</b>';
                                $string .= '<div class="input-group">';
                                $search = array_search(($i+1), $arrColumn);
                                if($search === false){
                                    $string .= '<input type="text" name="date['.($i+1).'][date]" class="form_datetime form-control" required autocomplete="off" readonly style="background-color:white;">';
                                }else{
                                    $string .= '<input type="text" name="date['.($i+1).'][date]" class="form_datetime form-control" value="'.date('d-M-Y H:i', strtotime($userSchedule[$search]['schedule_date'])).'" required autocomplete="off" readonly style="background-color:white;">';
                                    $string .= '<input type="hidden" name="date['.($i+1).'][id_transaction_academy_schedule]" value="'.$userSchedule[$search]['id_transaction_academy_schedule'].'">';
                                }
                                $string .= '<span class="input-group-btn">';
                                $string .= '<button class="btn default" type="button">';
                                $string .= '<i class="fa fa-calendar"></i>';
                                $string .= '</button>';
                                $string .= '</span>';
                                $string .= '</div>';
                                $string .= '</div>';
                            }

                            $string .= '</div>';
                            $i++;
                        }

                        echo $string;
                    }
                    ?>
                </div>
                <input type="hidden" name="id_user" value="{{$res['id_user']}}">
                <br>
                <br>
                @if($res['status_dp'] == true)
                <div class="form-actions" style="text-align: center">
                    {{ csrf_field() }}
                    <button type="submit" class="btn blue">Submit</button>
                </div>
                @endif
            </form>
        </div>
    </div>

@endsection
