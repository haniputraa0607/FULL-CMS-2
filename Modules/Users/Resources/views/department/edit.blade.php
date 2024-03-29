<?php
    $i = count($department['department_child']);
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>

    <script>
        var i = "{{$i}}";
        $(document).ready(function() {
            // library initialization
            $('[data-switch=true]').bootstrapSwitch();
            $('.select2').select2();
        });

        function addChild(num = null) {
            if(num == null){
                var name = "{{$department['department_name']}}";
            }else{
                var name = $('#department_name_'+num).val();
            }

            var html = '<div id="child_'+i+'">' +
                '<div class="form-group">' +
                '<label class="col-md-3 col-form-label">'+name+' <span class="text-danger">*</span></label>' +
                '<div class="col-md-5">' +
                '<input class="form-control" type="text" maxlength="200" id="department_name_'+i+'" name="child['+i+'][department_name]" required placeholder="Enter department name"/>' +
                '</div>' +
                '<div class="col-md-4">' +
                '<a class="btn btn-danger btn" style="margin-left: 2%" onclick="deleteForm('+i+')">&nbsp;<i class="fa fa-trash"></i> </a>' +
                '</div>' +
                '</div>' +
                '</div>';

            $("#child").append(html);
            $('[data-switch=true]').bootstrapSwitch();
            i++;
        }

        function deleteForm(number) {
            $('#child_'+number).empty();
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

    <a href="{{url('user/department')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Update Department</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" id="form_create_table" action="{{url('user/department/update/'.$department['id_department'])}}" method="POST">
                {{ csrf_field() }}
                <div class="form-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Department Name Parent <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" maxlength="200" name="department_name" value="{{$department['department_name']}}" required placeholder="Enter department name here"/>
                        </div>
                        <div class="col-md-4">
                            <a class="btn btn-primary btn" style="margin-bottom: 4%;" onclick="addChild()">&nbsp;<i class="fa fa-plus-circle"></i> Add Child </a>
                        </div>
                    </div>
                    <div id="child">
                        <?php $i=0;?>
                        @foreach($department['department_child'] as $child)
                            <div id="child_{{$i}}">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">{{$department['department_name']}}  <span class="text-danger">*</span></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" maxlength="200" name="child[{{$i}}][department_name]" value="{{$child['department_name']}}" required placeholder="Enter department name here"/>
                                    </div>
                                    <input type="hidden" name="child[{{$i}}][id_department]" value="{{$child['id_department']}}">
                                </div>
                            </div>
                            <?php $i++; ?>
                        @endforeach
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection