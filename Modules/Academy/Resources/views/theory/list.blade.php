<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/table-datatables-responsive.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('#theory').dataTable({
            "pageLength": 50,
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false
        });
        var SweetAlert = function() {
            return {
                init: function() {
                    $(".delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        var data = {
                            '_token' : '{{csrf_token()}}',
                            'id_theory':id
                        };
                        $(this).click(function() {
                            swal({
                                    title: "Are you sure delete this theory?",
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
                                        url : "{{url('theory/delete')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal({
                                                    title: 'Success!',
                                                    text: 'Theory has been deleted.',
                                                    type: "success",
                                                    timer: 2000,
                                                    showCancelButton: false,
                                                    showConfirmButton: false
                                                });
                                                SweetAlert.init()
                                                window.location.reload();
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to delete.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete .", "error")
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
            SweetAlert.init();

        });

        $("#category").change(function() {
            var id = $(this).val();
            var url = '{{ url("theory") }}/'+id;
            window.location = url;
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
                <span class="caption-subject font-dark sbold uppercase font-blue">List Theory</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <select id="category" class="form-control select2-multiple" name="id_category" data-placeholder="Select Category">
                        <option value="all">All Category</option>
                        @if (!empty($list_category))
                            @foreach($list_category as $cat)
                                <optgroup label="{{$cat['theory_category_name']}}">
                                    <option value="all-{{ $cat['id_theory_category'] }}" @if($id_category == 'all-'.$cat['id_theory_category']) selected @endif>All Category {{ $cat['theory_category_name'] }}</option>
                                    @foreach($cat['child'] as $child)
                                        <option value="{{ $child['id_theory_category'] }}" @if($id_category == $child['id_theory_category']) selected @endif>{{ $child['theory_category_name'] }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <br>
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="theory">
                <thead>
                    <tr>
                        <th width="10"> No </th>
                        <th > Name </th>
                        <th > Minimum Score </th>
                        <th > Category Parent </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($list))
                        @foreach($list as $key => $res)
                            <tr>
                                <td> {{ ++$key }} </td>
                                <td > {{ $res['theory_title'] }} </td>
                                <td > {{ $res['minimum_score'] }} </td>
                                <td > <b>{{$res['parent_name']}}</b> </td>
                                <td style="width: 80px;">
                                    <a href="{{url('theory/detail', $res['id_theory'])}}" class="btn btn-sm blue"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-sm delete btn-danger" data-id="{{$res['id_theory']}}" type="button" data-toggle="tab"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection