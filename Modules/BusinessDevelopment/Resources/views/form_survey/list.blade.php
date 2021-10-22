<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        #sortable{
            cursor: move;
        }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var table=$('#sample_1').DataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                }
        });

        var SweetAlert = function() {
            return {
                init: function() {
                    $(".sweetalert-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to delete this form survey?",
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
                                        url : "{{url('businessdev/form-survey/delete')}}/"+id,
                                        data : {
                                            '_token' : '{{csrf_token()}}'
                                        },
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Form Suvey has been deleted.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('businessdev/form-survey')}}";
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to delete form suvey.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete form suvey.", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();
        var manual=1;
        $(document).ready(function(){
            SweetAlert.init()
            $('.form').on( 'click', function () {
                $('#data_start').val(table.page.info().start);
            });
            $('#sortable').sortable();
            $('#sortable').on('switchChange.bootstrapSwitch','.brand_status',function(){
                if(!manual){
                    manual=1;
                    return false;
                }
                var switcher=$(this);
                var newState=switcher.bootstrapSwitch('state');
                $.ajax({
                    method:'GET',
                    url:"{{url('brand/switch_status')}}",
                    data:{
                        id_brand:switcher.data('id'),
                        brand_active:newState
                    },
                    success:function(data){
                        if(data.status == 'success'){
                            toastr.info("Success update brand status");
                        }else{
                            manual=0;
                            toastr.warning("Fail update brand status");
                            switcher.bootstrapSwitch('state',!newState);
                        }
                    }
                }).fail(function(data){
                    manual=0;
                    toastr.warning("Fail update brand status");
                    switcher.bootstrapSwitch('state',!newState);
                });
            });
            $('#sortable').on('switchChange.bootstrapSwitch','.brand_visibility',function(){
                if(!manual){
                    manual=1;
                    return false;
                }
                var switcher=$(this);
                var newState=switcher.bootstrapSwitch('state');
                $.ajax({
                    method:'GET',
                    url:"{{url('brand/switch_visibility')}}",
                    data:{
                        id_brand:switcher.data('id'),
                        brand_visibility:newState
                    },
                    success:function(data){
                        if(data.status == 'success'){
                            toastr.info("Success update brand visibility");
                        }else{
                            manual=0;
                            toastr.warning("Fail update brand visibility");
                            switcher.bootstrapSwitch('state',!newState);
                        }
                    }
                }).fail(function(data){
                    manual=0;
                    toastr.warning("Fail update brand visibility");
                    switcher.bootstrapSwitch('state',!newState);
                });
            });
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
    </div><br>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Form Survey List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th width="30px"> No </th>
                        <th> Brand </th>
                        <th width="80px"> Category </th>
                        @if(MyHelper::hasAccess([339,340], $grantedFeature))
                            <th width="130px;"> Action </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="sortable">
                    @if (!empty($form))
                        @foreach($form as $i => $value)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    @foreach ($brand as $b)
                                        @if ($b['id_brand'] == $i)
                                            {{ $b['name_brand'] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    {{ count($value) }}
                                </td>
                                @if(MyHelper::hasAccess([339,340], $grantedFeature))
                                <td class="text-center">
                                    @if(MyHelper::hasAccess([339,340], $grantedFeature))
                                    <a href="{{ url('businessdev/form-survey/detail/'.$i) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-pencil"></i> Edit</a>
                                    @endif
                                    @if(MyHelper::hasAccess([339,340], $grantedFeature))
                                    <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $i }}"><i class="fa fa-trash-o"></i> Delete</a>
                                    @endif
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>



@endsection