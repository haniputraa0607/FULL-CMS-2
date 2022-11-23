<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
         var SweetAlert = function() {
            return {
                init: function() {
                    $(".save").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let id    = $(this).data('id');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want change to status "+status.toLowerCase()+" ?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, save it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    window.location.href = "{{url('hair-stylist/payroll/delete')}}/"+id;
                                });
                        })
                    })
                }
            }
        }();

        $(document).ready(function() {
             SweetAlert.init()
            $('.date_picker').datepicker({
            'format' : 'yyyy-mm',
            'todayHighlight' : true,
            'autoclose' : true,
            startView: "months", 
            minViewMode: "months"
        });
            $('#chkall').on('ifChanged', function(event) {
                if(this.checked) {
                    $("#outlets > option").prop("selected", "selected");
                    $("#outlets").trigger("change");
                }else{
                    $("#outlets > option").removeAttr("selected");
                    $("#outlets").trigger("change");
                }
            });
        });

    </script>
@endsection

@extends('layouts.main')

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

    <h1 class="page-title" style="margin-top: 0px;">
        {{$sub_title}}
    </h1>
    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-blue ">
                <i class="icon-settings font-blue "></i>
                <span class="caption-subject bold uppercase">Filter</span>
            </div>
        </div>
        <div class="portlet-body">
            <form class="form-horizontal" role="form" action="{{url('hair-stylist/payroll/export')}}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Date Start :</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="date_picker form-control" name="start_date" required value="{{date('Y-m')}}">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>

                        <label class="col-md-2 control-label">Date End :</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="date_picker form-control" name="end_date" required value="{{date('Y-m')}}">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Outlet <span class="required" aria-required="true"> * </span>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <select  class="form-control select2" multiple name="id_outlet[]" id="outlets" data-placeholder="Select Outlet" required>
                                    @foreach($outlets as $outlet)
                                        <option value="{{$outlet['id_outlet']}}">{{$outlet['outlet_code']}} - {{$outlet['outlet_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="icheck-list">
                                <label><input type="checkbox" class="icheck" id="chkall"> All Outlet</label>
                            </div>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="row" style="text-align: center">
                    <button type="submit" class="btn blue">Export</button>
                </div>
            </form>
        </div>
    </div>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-blue ">
                <i class="icon-settings font-blue "></i>
                <span class="caption-subject bold uppercase">Data</span>
            </div>
        </div>
        <div class="portlet-body">
            <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
            <table class="table table-striped table-bordered table-hover" id="hslist">
                <thead>
                <tr>
                    <th scope="col" width="10%" style="text-align: center"> Outlet </th>
                    <th scope="col" width="10%" style="text-align: center"> Start Date </th>
                    <th scope="col" width="10%" style="text-align: center"> End Date </th>
                    <th scope="col" width="10%" style="text-align: center"> Status </th>
                    <th scope="col" width="10%" style="text-align: center"> Action </th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($data))
                    @foreach($data as $val)
                        <tr style="text-align: center">
                            <td>
                            @foreach(json_decode($val['name_outlet']) as $va)
                            {{$va}}
                            <br>
                            @endforeach
                            </td>
                            <td>{{ date('M Y', strtotime($val['start_date'])) }}</td>
                            <td>{{ date('M Y', strtotime($val['end_date'])) }}</td>
                            <td>{{ $val['status_export'] }}</td>
                            <td>
                                @if($val['status_export'] == "Ready")
                                    <a class="btn btn-sm btn-success" download target="_blank" href="{{env('STORAGE_URL_API').$val['url_export']}}"><i class="fa fa-download"></i></a>
                                    <a class="btn red save" data-id="{{ $val['id_export_payroll_queue'] }}" data-status="Rejected" data-form="approve"><i class="fa fa-trash-o"></i></a>
                                @else
                                    <a class="btn btn-sm btn-info"  href="{{url('hair-stylist/payroll/filter')}}"><i class="fa fa-refresh"></i></a>
                                    <a class="btn red save" data-id="{{ $val['id_export_payroll_queue'] }}" data-status="Rejected" data-form="approve"><i class="fa fa-trash-o"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="5" style="text-align: center">Data Not Available</td></tr>
                @endif
                </tbody>
            </table>
        </div>
        <br>
        @if ($dataPaginator)
            {{ $dataPaginator->links() }}
        @endif
        </div>
    </div>
@endsection