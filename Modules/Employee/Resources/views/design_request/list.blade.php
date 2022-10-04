<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

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
        var table;

        var SweetAlert = function() {
            return {
                init: function() {
                    $(".sweetalert-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        let status    = $(this).data('status');
                        $(this).click(function() {
                            if(status == 'Pending' || status == 'Approve'){
                                swal({
                                        title: name+"\n\nAre you sure want to reject this design request?",
                                        text: "Your will not be able to recover this data!",
                                        type: "warning",
                                        showCancelButton: true,
                                        confirmButtonClass: "btn-danger",
                                        confirmButtonText: "Yes, reject it!",
                                        closeOnConfirm: false
                                    },
                                    function(){
                                        $.ajax({
                                            type : "POST",
                                            url : "{{url('employee/design-request/reject')}}/"+id,
                                            data : {
                                                '_token' : '{{csrf_token()}}'
                                            },
                                            success : function(response) {
                                                if (response.status == 'success') {
                                                    swal("Rejected!", "Design request has been rejectd.", "success")
                                                    SweetAlert.init()
                                                    location.href = "{{url('employee/design-request')}}";
                                                }
                                                else if(response.status == "fail"){
                                                    swal("Error!", "Failed to reject design request.", "error")
                                                }
                                                else {
                                                    swal("Error!", "Something went wrong. Failed to reject partner.", "error")
                                                }
                                            }
                                        });
                                    }
                                );
                            }
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
    </div>
    <br>
    @include('layouts.notifications')

    <?php
        $date_start = '';
        $date_end = '';

        if(Session::has('filter-list-design-request')){
            $search_param = Session::get('filter-list-design-request');
            if(isset($search_param['rule'])){
                $rule = $search_param['rule'];
            }

            if(isset($search_param['conditions'])){
                $conditions = $search_param['conditions'];
            }
        }
    ?>

    <form id="form-sorting" action="{{url()->current()}}?filter=1" method="POST">
        @include('employee::design_request.filter')
    </form>
    <br>
  

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">List Design Request</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row">
                <form id="form-sorting" action="{{url()->current()}}?sorting=1" method="POST">
                    {{ csrf_field() }}
                    <div class="col-md-3">
                        <select name="order" class="form-control select2" style="width: 100%">
                            <option value="created_at" @if(isset($order) && $order == 'created_at') selected @endif>Date</option>
                            <option value="request_name" @if(isset($order) && $order == 'request_name') selected @endif>Name Request</option>
                            <option value="title" @if(isset($order) && $order == 'title') selected @endif>Title</option>
                        </select>
                    </div>
                    <div class="col-md-3 pl-0 pr-0">
                        <select name="order_type" class="form-control select2" style="width: 100%">
                            <option value="desc" @if(isset($order_type) && $order_type == 'desc') selected @endif>Descending</option>
                            <option value="asc" @if(isset($order_type) && $order_type == 'asc') selected @endif>Ascending</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn yellow">Show</button>
                    </div>
                </form>
            </div>
            <br>
            <br>
            <div style="white-space: nowrap;">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                        <thead>
                        <tr>
                            <th class="text-nowrap text-center">Created At</th>
                            <th class="text-nowrap text-center">Request Name</th>
                            <th class="text-nowrap text-center">Title</th>
                            <th class="text-nowrap text-center">Required Date</th>
                            <th class="text-nowrap text-center">Status</th>
                            @if(MyHelper::hasAccess([550,551], $grantedFeature))
                            <th class="text-nowrap text-center">Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $dt)
                                <tr data-id="{{ $dt['id_design_request'] }}">
                                    <td>{{date('d F Y H:i', strtotime($dt['created_at']))}}</td>
                                    <td>{{$dt['request']['name']}}</td>
                                    <td>{{$dt['title']}}</td>
                                    <td>{{date('d F Y', strtotime($dt['required_date']))}}</td>
                                    <td>
                                        @if($dt['status'] == 'Approved')
                                        <span class="badge" style="background-color: #26C281; color: #ffffff">{{$dt['status']}}</span>
                                        @elseif($dt['status'] == 'Pending')
                                        <span class="badge" style="background-color: #e1e445; color: #ffffff">{{$dt['status']}}</span>
                                        @elseif($dt['status'] == 'Finished')
                                        <span class="badge" style="background-color: #11407e; color: #ffffff">{{$dt['status']}}</span>
                                        @elseif($dt['status'] == 'Done Finished')
                                        <span class="badge" style="background-color: #03326f; color: #ffffff">{{$dt['status']}}</span>
                                        @elseif($dt['status'] == 'Provided')
                                        <span class="badge" style="background-color: #03bde2; color: #ffffff">{{$dt['status']}}</span>
                                        @else
                                        <span class="badge" style="background-color: #EF1E31; color: #ffffff">{{$dt['status']}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(MyHelper::hasAccess([539,540], $grantedFeature))
                                        <a href="{{ url('employee/design-request/detail/'.$dt['id_design_request']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-pencil"></i> Edit</a>
                                        @endif
                                        @if(MyHelper::hasAccess([541], $grantedFeature))
                                        <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $dt['id_design_request'] }}" data-name="{{ $dt['request']['name'] }}" data-status="{{ $dt['status'] }}" @if($dt['status'] == 'Rejected' || $dt['status'] == 'Provided' || $dt['status'] == 'Finished') disabled @endif><i class="fa fa-trash-o"></i> Reject</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" style="text-align: center">Data Not Available</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </form>
    <br>
    @if ($data_paginator)
        {{ $data_paginator->links() }}
    @endif  
@endsection