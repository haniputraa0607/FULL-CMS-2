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
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to delete this request hair stylist?",
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
                                        url : "{{url('recruitment/hair-stylist/request/delete')}}/"+id,
                                        data : {
                                            '_token' : '{{csrf_token()}}'
                                        },
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Request Hair Stylist has been deleted.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('recruitment/hair-stylist/request')}}";
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to delete request hair stylist.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete partner.", "error")
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

        if(Session::has('filter-list-req-hair-stylist')){
            $search_param = Session::get('filter-list-req-hair-stylist');
            if(isset($search_param['rule'])){
                $rule = $search_param['rule'];
            }

            if(isset($search_param['conditions'])){
                $conditions = $search_param['conditions'];
            }
        }
    ?>

    <form id="form-sorting" action="{{url()->current()}}?filter=1" method="POST">
        @include('recruitment::request.filter')
    </form>
    <br>
  

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">List Request Hair Stylist</span></span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row">
                <form id="form-sorting" action="{{url()->current()}}?sorting=1" method="POST">
                    {{ csrf_field() }}
                    <div class="col-md-3">
                        <select name="order" class="form-control select2" style="width: 100%">
                            <option value="created_at" @if(isset($order) && $order == 'created_at') selected @endif>Date</option>
                            <option value="outlet_name" @if(isset($order) && $order == 'outlet_name') selected @endif>Outlet Name</option>
                            <option value="number_of_request" @if(isset($order) && $order == 'number_of_request') selected @endif>Number Of Request</option>
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
                            <th class="text-nowrap text-center">Outlet Name</th>
                            <th class="text-nowrap text-center">Number of Request</th>
                            <th class="text-nowrap text-center">Progress</th>
                            <th class="text-nowrap text-center">Status</th>
                            @if(MyHelper::hasAccess([379,380,381,382], $grantedFeature))
                            <th class="text-nowrap text-center">Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $dt)
                                <tr data-id="{{ $dt['id_request_hair_stylist'] }}">
                                    <td>{{date('d F Y H:i', strtotime($dt['created_at']))}}</td>
                                    <td>{{$dt['outlet_request']['outlet_name']}}</td>
                                    <td class="text-center">{{$dt['number_of_request']}}</td>
                                    <td class="text-center">{{$dt['count']}} / {{$dt['number_of_request']}}</td>
                                    <td>
                                        @if($dt['status'] == 'Approve')
                                        <span class="badge" style="background-color: #26C281; color: #ffffff">{{$dt['status']}}</span>
                                        @elseif($dt['status'] == 'Request')
                                        <span class="badge" style="background-color: #e1e445; color: #ffffff">{{$dt['status']}}</span>
                                        @elseif($dt['status'] == 'Done Approved')
                                        <span class="badge" style="background-color: #11407e; color: #ffffff">{{$dt['status']}}</span>
                                        @else
                                        <span class="badge" style="background-color: #EF1E31; color: #ffffff">{{$dt['status']}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(MyHelper::hasAccess([380,381], $grantedFeature))
                                        <a href="{{ url('recruitment/hair-stylist/request/detail/'.$dt['id_request_hair_stylist']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-pencil"></i> Edit</a>
                                        @endif
                                        @if(MyHelper::hasAccess([382], $grantedFeature))
                                        <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $dt['id_request_hair_stylist'] }}" data-name="{{ $dt['applicant_request']['name'] }}"><i class="fa fa-trash-o"></i> Delete</a>
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