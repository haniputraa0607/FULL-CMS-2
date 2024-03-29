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
                                        url : "{{ url('recruitment/hair-stylist/candidate/delete') }}"+'/'+id,
                                        data : "_token="+token+"&id_user_hair_stylist="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                swal("Deleted!", "Candidate has been deleted.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('recruitment/hair-stylist/candidate')}}";
                                            }
                                            else if(result.status == "fail"){
                                                swal("Error!", result.messages[0], "error")
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

    if(Session::has('filter-hs-list-candidate')){
        $search_param = Session::get('filter-hs-list-candidate');
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
        @include('recruitment::hair_stylist.filter_list')
    </form>

    <br>
    <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col" width="10%"> Action </th>
                <th scope="col" width="10%"> Status </th>
                <th scope="col" width="10%"> Register Date </th>
                <th scope="col" width="10%"> Full Name </th>
                <th scope="col" width="10%"> Email </th>
                <th scope="col" width="10%"> Phone </th>
                <th scope="col" width="10%"> Gender </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($data))
                @foreach($data as $val)
                    <tr>
                        <td>
                            @if(MyHelper::hasAccess([348,349], $grantedFeature))
                                <a class="btn btn-sm btn-info" href="{{ url('recruitment/hair-stylist/candidate/detail', $val['id_user_hair_stylist']) }}"><i class="fa fa-edit"></i></a>
                            @endif
                            @if(MyHelper::hasAccess([350], $grantedFeature))
                                <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $val['id_user_hair_stylist'] }}" data-name="{{ $val['fullname'] }}"><i class="fa fa-trash-o"></i></a>
                            @endif
                        </td>
                        <td>
                            @if($val['user_hair_stylist_status'] == 'Candidate')
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #9b9e9c;padding: 5px 12px;color: #fff;">Candidate</span>
                            @elseif($val['user_hair_stylist_status'] == 'Rejected')
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Rejected</span>
                            @else
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #faf21e;padding: 5px 12px;color: #fff;">{{$val['user_hair_stylist_status'] }}</span>
                            @endif
                        </td>
                        <td>{{ date('d M Y H:i', strtotime($val['created_at'])) }}</td>
                        <td>{{$val['fullname']}}</td>
                        <td>{{$val['email']}}</td>
                        <td>{{$val['phone_number']}}</td>
                        <td>{{$val['gender']}}</td>
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