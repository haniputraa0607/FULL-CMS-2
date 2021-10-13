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
                                    title: name+"\n\nAre you sure want to delete this partner?",
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
                                        url : "{{url('businessdev/partners/delete')}}/"+id,
                                        data : {
                                            '_token' : '{{csrf_token()}}'
                                        },
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Partner has been deleted.", "success")
                                                SweetAlert.init()
                                                if(pathname=='/businessdev/candidatepartners'){
                                                    location.href = "{{url('businessdev/candidatepartners')}}";
                                                  } else {
                                                    location.href = "{{url('businessdev/partners')}}";
                                                  }
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to delete partner.", "error")
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

        if(Session::has('filter-list-project')){
            $search_param = Session::get('filter-list-project');
            if(isset($search_param['rule'])){
                $rule = $search_param['rule'];
            }

            if(isset($search_param['conditions'])){
                $conditions = $search_param['conditions'];
            }
        }
    ?>

    <form id="form-sorting" action="{{url()->current()}}?filter=1" method="POST">
        @include('project::project.filter')
    </form>
    <br>
  

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">@if($title=='Candidate Partners') List Candidate Partner @else List Partner @endif</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row">
            </div>
            <br>
            <br>
            <div style="white-space: nowrap;">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                        <thead>
                        <tr>
                            <th class="text-nowrap text-center">Start Project</th>
                            <th class="text-nowrap text-center">Name</th>
                            <th class="text-nowrap text-center">Partner</th>
                            <th class="text-nowrap text-center">Lokasi</th>
                            <th class="text-nowrap text-center">Note</th>
                            @if($title=='Process Project')
                            <th class="text-nowrap text-center">Progress</th>
                            @endif
                            @if(MyHelper::hasAccess([339,340,341], $grantedFeature))
                            <th class="text-nowrap text-center">Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $dt)
                                <tr data-id="{{ $dt['id_project'] }}">
                                    <td>{{date('d M Y', strtotime($dt['start_project']))}}</td>
                                    <td>{{$dt['name']}}</td>
                                    <td>{{$dt['name_partner']}}</td>
                                    <td>{{$dt['name_location']}}</td>
                                    <td>{{$dt['note']}}</td>
                                    @if($title=='Process Project')
                                    <td>
                                        <span class="badge" style="background-color: #2460e2; color: #ffffff">{{$dt['progres']}}</span>
                                    </td>
                                    @endif
                                    <td> 
                                        @if($dt['status']=='Process')
                                        <a href="{{ url('project/detail/'.$dt['id_project']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-pencil"></i> Edit</a>
                                        <a class="btn btn-sm red sweetalert-project-reject btn-primary" data-id="{{ $dt['id_partner'] }}" data-name="{{ $dt['name'] }}"><i class="fa fa-trash-o"></i> Delete</a>
                                        @else
                                        <a href="{{ url('project/detail/'.$dt['id_project']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"></i> Detail</a>
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