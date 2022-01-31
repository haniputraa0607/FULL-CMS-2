<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .datepicker{
            padding: 6px 12px;
           }
        .zoom-in {
			cursor: zoom-in;
            border: 1px solid;
		}
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        $('.datepicker').datepicker({
            'format' : 'dd MM yyyy',
            'todayHighlight' : true,
            'autoclose' : true
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
                <span> <a href='{{ $url_title }}'>{{ $title }}</a></span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span><a href='{{ $url_sub_title }}'>{{ $sub_title }}</a></span>
                 @if (!empty($detail_sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @endif
             @if (!empty($detail_sub_title))
            <li>
                <span>{{ $detail_sub_title }}</span>
            </li>
            @endif
        </ul>
    </div>
<br>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">{{$sub_title}}</span>
            </div>
        </div>
        <div class="tabbable-line tabbable-full-width">
            
        <div class="tab-content">
            <div class="tab-pane active" id="overview">
               <div class="portlet-body form">
                        <div style="white-space: nowrap;">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                    <thead>
                                    <tr>
                                        <th class="text-nowrap text-center">No</th>
                                        <th class="text-nowrap text-center">Name</th>
                                        <th class="text-nowrap text-center">Code</th>
                                        <th class="text-nowrap text-center">Kota</th>
                                        <th class="text-nowrap text-center">Type</th>
                                        <th class="text-nowrap text-center">Status</th>
                                        <th class="text-nowrap text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody style="text-align:center">
                                            @php $i = 1;
                                            @endphp
                                            @foreach($result as $value)
                                                <tr data-id="{{ $value['id_outlet_manage'] }}">
                                                    <td>{{$i}}</td>
                                                    <td>{{$value['outlet_name']}}</td>
                                                    <td>{{$value['outlet_code']}}</td>
                                                    <td>{{$value['city_name']}}</td>
                                                    <td>{{$value['type']}}</td>
                                                    <td>
                                                        <span class="sale-num sbold badge badge-pill" style="font-size: 16px!important;height: 30px!important;background-color: @if($value['status']=="Reject")red @elseif($value['status']=="Process") blue @elseif($value['status']=="Waiting") #ffd700 @else #00FF00  @endif;padding: 5px 12px;color: #fff;">{{$value['status']}}</span>

                                                    </td>
                                                    <td>
                                                        @if($value['type']=="Cut Off")
                                                            <a href="{{url('businessdev/partners/outlet/cutoff/detail/'.$value['id_enkripsi'])}}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"> </i> Detail</a>
                                                        @elseif($value['type']=="Change Ownership") 
                                                         <a href="{{url('businessdev/partners/outlet/change/detail/'.$value['id_enkripsi'])}}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"> </i> Detail</a>
                                                        @elseif($value['type']=='Close Temporary') 
                                                         <a href="{{url('businessdev/partners/outlet/close/detail/'.$value['id_enkripsi'])}}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"> </i> Detail</a>
                                                        @elseif($value['type']=='Active Temporary') 
                                                         <a href="{{url('businessdev/partners/outlet/close/detail/'.$value['id_enkripsi'])}}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"> </i> Detail</a>
                                                        @elseif($value['type']=='Change Location') 
                                                         <a href="{{url('businessdev/partners/outlet/change_location/detail/'.$value['id_enkripsi'])}}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"> </i> Detail</a>
                                                        @endif   
                                                    </td>
                                                </tr> 
                                             @php $i++;
                                            @endphp
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    
@endsection