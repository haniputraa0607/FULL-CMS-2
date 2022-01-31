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
        $('#theory_category').dataTable({
            "pageLength": 50,
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false
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
                <span class="caption-subject font-dark sbold uppercase font-blue">List Category Theory</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="theory_category">
                <thead>
                    <tr>
                        <th width="10"> No </th>
                        <th > Name </th>
                        <th class="noExport"> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($category))
                        @foreach($category as $key => $res)
                            <tr style="background-color: #fbfbfb;font-weight:bold">
                                <td style="background-color:  #fbfbfb !important"> {{ ++$key }}. </td>
                                <td > {{ $res['theory_category_name'] }} </td>
                                <td style="width: 80px;">
                                    <a href="{{url('theory/category/detail', $res['id_theory_category'])}}" class="btn btn-sm blue"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                            @foreach($res['child'] as $row => $child)
                                <tr style="background-color: white !important">
                                    <td style="background-color:  white !important"> {{ $key }}.{{ ++$row }} </td>
                                    <td > {{ $child['theory_category_name'] }} </td>
                                    <td style="width: 80px;"></td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection