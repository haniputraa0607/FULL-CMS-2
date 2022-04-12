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

        if(Session::has('filter-list-report-stock')){
            $search_param = Session::get('filter-list-report-stock');
            if(isset($search_param['rule'])){
                $rule = $search_param['rule'];
            }

            if(isset($search_param['conditions'])){
                $conditions = $search_param['conditions'];
            }
            
            if(isset($search_param['start_date'])){
                $start_date = $search_param['start_date'];
            }

            if(isset($search_param['end_date'])){
                $end_date = $search_param['end_date'];
            }
        }
    ?>

    <a href="{{url('outlet/detail')}}/{{ $outlet_code }}#product_icount" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
    <form id="form-sorting" action="{{url()->current()}}?filter=1" method="POST">
        @include('outlet::filter_stock')
    </form>
    <br>
  
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Report Stock</span>
            </div>
        </div>
        <div class="portlet-body form">
            <br>
            <br>
            <div style="white-space: nowrap;">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                        <thead>
                        <tr>
                            <th class="text-nowrap text-center">Date</th>
                            <th class="text-nowrap text-center">Source</th>
                            <th class="text-nowrap text-center">In</th>
                            <th class="text-nowrap text-center">Out</th>
                            <th class="text-nowrap text-center">Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data))
                                <tr>
                                    <th class="text-nowrap text-center"></th>
                                    <th class="text-nowrap text-left" colspan="3">Initial Stock</th>
                                    <th class="text-nowrap text-center">{{ $data[0]['stock_before'] }}</th>
                                </tr>
                                @php
                                    $date_before = '';
                                @endphp
                                @foreach($data as $key => $dt)
                                    <tr data-id="{{ $dt['id_product_icount_outlet_stock_log'] }}">
                                        <td class="text-nowrap text-center">{{ date('d F Y', strtotime($dt['created_at'])) == $date_before ? '' : date('d F Y', strtotime($dt['created_at'])) }}</td>
                                        {{--  <td>{{$dt['source']}}</td>  --}}
                                        <td class="text-nowrap text-left">
                                            @if(isset($dt['id_reference']))
                                                {{$dt['source']}} <a href="{{ $dt['link'] }}">{{ $dt['id_reference'] }}</a>
                                            @else
                                                {{$dt['source']}}
                                            @endif
                                        </td>
                                        <td class="text-nowrap text-center">{{ $dt['qty'] < 0 ? '' : $dt['qty'] }}</td>
                                        <td class="text-nowrap text-center">{{ $dt['qty'] > 0 ? '' : $dt['qty']*-1 }}</td>
                                        <td class="text-nowrap text-center">{{$dt['stock_after']}}</td>
                                    </tr>
                                    @php
                                        $date_before = date('d F Y', strtotime($dt['created_at']));
                                    @endphp
                                @endforeach
                                <tr>
                                    <th class="text-nowrap text-center"></th>
                                    <th class="text-nowrap text-left" colspan="3">End Stock</th>
                                    <th class="text-nowrap text-center">{{ $dt['stock_after'] }}</th>
                                </tr>
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