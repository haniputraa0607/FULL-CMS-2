<?php
use App\Lib\MyHelper;
    $grantedFeature = session('granted_features');
$configs = session('configs');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />

	<style type="text/css">
    .show{
        display:block !important;
    }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script>
        function addSubject(id, count_subject, parent, child) {
            var subID = id+'_'+(count_subject);
            var html = '';
            html += '<div class="form-group" id="'+subID+'">';
            html += '<div class="col-md-8">';
            html += '<input class="form-control" type="text" required name="data['+parent+']['+child+'][]" placeholder="Subject Name" value="">';
            html += '</div>';
            html += '<div class="col-md-2">';
            html += '<a class="btn btn-danger btn" onclick="deleteSubject(\''+subID+'\')">&nbsp;<i class="fa fa-trash"></i></a>';
            html += '</div>';
            html += '</div>';

            $( "#"+id).append(html);
            $("#count_"+id).val(count_subject);
        }
        
        function deleteSubject(id) {
            $("#"+id).remove();
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
                <span class="caption-subject sbold uppercase font-blue">Setting Subject</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="tabbable-line">
                <ul class="nav nav-tabs">
                    <?php $i=0;?>
                    @foreach($result as $key=>$data)
                        <li @if($i == 0) class="active" @endif>
                            <a data-toggle="tab" href="#{{$key}}">{{ucfirst(str_replace('_', ' ', $key))}}</a>
                        </li>
                        <?php $i++;?>
                    @endforeach
                </ul>
            </div>
            <br>
            <div class="tab-content">
                <?php $j=0;?>
                @foreach($result as $key=>$data)
                    <div id="{{$key}}" class="tab-pane @if($j == 0) active @endif">
                        <form class="form-horizontal" id="form-outlet-box" role="form" action="{{ url('enquiries/setting/subject') }}" method="post">
                            <div class="form-body">
                                @foreach($data as $keyChild=>$dataChild)
                                    <?php
                                    $countSubject = count($dataChild['subject']);
                                    $idParent = $key.'_'.$keyChild;
                                    ?>
                                    <div style="margin-left: 5%" id="{{$key.'_'.$keyChild}}">
                                        <p><b>{{ucfirst(str_replace('_', ' ', $keyChild))}}</b> <a style="font-size: 18px;text-decoration:none" onclick="addSubject('{{$idParent}}', {{$countSubject}}, '{{$key}}', '{{$keyChild}}')">&nbsp;<i class="fa fa-plus-circle"></i></a></p>

                                        @foreach($dataChild['subject'] as $inc=>$subject)
                                            <div class="form-group" id="{{$key.'_'.$keyChild.'_'.$inc}}">
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" required placeholder="Subject Name" name="data[{{$key}}][{{$keyChild}}][]" value="{{$subject}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <a class="btn btn-danger btn" onclick="deleteSubject('{{$idParent.'_'.$inc}}')">&nbsp;<i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                        @endforeach
                                        <input type="hidden" id="count_{{$idParent}}" value="{{$countSubject}}">
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="page" value="{{$key}}">
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row" style="text-align: center;margin-top: 5%">
                                    <button type="submit" class="btn green">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php $j++;?>
                @endforeach
            </div>
        </div>
    </div>
@endsection