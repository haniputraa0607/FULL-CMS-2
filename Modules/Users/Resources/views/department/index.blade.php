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
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-nestable/jquery.nestable.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .dd-handle:hover{
            background: #fafafa;
            color: #333;
            cursor: context-menu;
        }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>

        $(document).ready(function() {
            var obj = {!! $departments !!};
            var output = '';
            var output_action = '';

            function buildItem(item) {

                var html = "<li class='dd-item' data-id='" + item.id_department + "' data-parent='"+item.id_parent+"'>";
                html += "<div class='dd-handle dd-nodrag'>" + item.department_name + "</div>";
                html += '<input type="hidden" name="position[]" value="'+item.id_department+'">';

                if (item.children) {

                    html += "<ol class='dd-list'>";
                    $.each(item.children, function (index, sub) {
                        html += buildItem(sub);
                    });
                    html += "</ol>";

                }
                html += "</li>";

                return html;
            }

            function buildItemAction(item) {

                var html = "<li style='margin-top:1.2%;margin-bottom:1%;list-style-type:none;'>";
                html += '<div class="row">' +
                    '<a href="{{ url("user/department/edit") }}/'+item.id_department+'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>' +
                    '<a onclick="deleteDepartment(\'' + item.id_department + '\',\'' + item.department_name + '\')" class="btn btn-sm btn-danger sweetalert-delete" style="margin-left:0.5%"><i class="fa fa-trash"></i></a>' +
                    '<div>';

                if (item.children) {

                    $.each(item.children, function (index, sub) {
                        html += buildItemAction(sub);
                    });

                }
                html += "</li>";

                return html;
            }

            $.each(obj, function (index, item) {
                output += buildItem(item);
                output_action += buildItemAction(item);
            });

            $('#departments').html(output);
            $('#departments_action').html(output_action);
	        $('[data-switch=true]').bootstrapSwitch();
        });

        var i = 1;
        function addChild(number) {
            var name = $('#department_name_'+number).val();
            if(name === ''){
                toastr.warning("Please input department name.");
            }else{
                var html = '<div id="div_parent_'+i+'">' +
                    '<div class="form-group">' +
                    '<label class="col-md-3 control-label">'+name+' <span class="text-danger">*</span></label>' +
                    '<div class="col-md-5">' +
                    '<input class="form-control" type="text" maxlength="200" id="department_name_'+i+'" name="data[child]['+i+'][department_name]" required placeholder="Enter department name"/>' +
                    '<input class="form-control" type="hidden" name="data[child]['+i+'][parent]" value="'+number+'"/>' +
                    '</div>' +
                    '<div class="col-md-4">' +
                    '<a class="btn btn-primary btn" onclick="addChild('+i+')">&nbsp;<i class="fa fa-plus-circle"></i> Child </a>' +
                    '<a class="btn btn-danger btn" style="margin-left: 2%" onclick="deleteForm('+i+')">&nbsp;<i class="fa fa-trash"></i></a>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $("#div_parent_"+number).append(html);
                $('[data-switch=true]').bootstrapSwitch();
                i++;
            }
        }

        function deleteForm(number) {
            $('#div_parent_'+number).empty();
        }

        function deleteDepartment(id_department, department_name) {
            swal({
                title: "Are you sure want to delete department \n" + department_name + " ?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete!",
                closeOnConfirm: false
            },
            function () {
                var token  	= "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: "{{ url('user/department/delete') }}/"+id_department,
                    data: "_token=" + token + "&id_department" + id_department,
                    success: function (result) {
                        if (result.status == "success") {
                            swal("Success!", "Deleted department.", "success")
                            location.reload();
                        } else {
                            swal("Error!", "Failed to delete department", "error")
                        }
                    }
                });
            });
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">New Department</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" id="form_create_table" action="{{url('user/department/store')}}" method="POST">
                {{ csrf_field() }}
                <div class="form-body">
                    <div id="div_parent_0">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Department Name Parent <span class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" maxlength="200" id="department_name_0" name="data[0][department_name]" required placeholder="Enter department name"/>
                            </div>
                            <div class="col-md-4">
                                <a class="btn btn-primary" onclick="addChild(0)">&nbsp;<i class="fa fa-plus-circle"></i> Child </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Department List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row">
                <div class="col-md-6">
                    <div class="dd" id="nestable3">
                        <ol class='dd-list dd3-list'>
                            <div id="departments"></div>
                        </ol>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="departments_action"></div>
                </div>
            </div>
        </div>
    </div>

@endsection