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
                                    title: name+"\n\nAre you sure want delete data ?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, delete it!",
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
        var Download = function() {
            return {
                init: function() {
                    $(".download").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let url         = $(this).data('url');
                        $(this).click(function() {
                            swal({
                                    title: "Download Excel?",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, download it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    var link = document.createElement("a");
                                    link.href = url;
                                    document.body.appendChild(link);
                                    link.click();
                                    document.body.removeChild(link);
                                    delete link;
                                });
                        })
                    })
                }
            }
        }();
        $(document).ready(function() {
             SweetAlert.init()
             Download.init()
            $('.date_picker').datepicker({
            'format' : 'yyyy-mm-dd',
            'todayHighlight' : true,
            'autoclose' : true,
//            startView: "months", 
//            minViewMode: "months"
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
    <script>
    function myFunction(id) {
        id = 'myDIV'+id;
      var x = document.getElementById(id);
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }
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
            <form class="form-horizontal" role="form" action="{{url('hair-stylist/generate/commission')}}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Date Start :</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="date_picker form-control" name="start_date" required value="{{date('Y-m-d')}}">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Date End :</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="date_picker form-control" name="end_date" required value="{{date('Y-m-d')}}">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="row" style="text-align: center">
                    <button type="submit" class="btn blue" @if($ready) disabled @endif>Generate</button>
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
                    <th scope="col" width="10%" style="text-align: center"> Start Date </th>
                    <th scope="col" width="10%" style="text-align: center"> End Date </th>
                    <th scope="col" width="10%" style="text-align: center"> Status </th>
                    <th scope="col" width="10%" style="text-align: center"> Created </th>
                    <th scope="col" width="10%" style="text-align: center"> Action </th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($data))
                    @foreach($data as $val)
                        <tr style="text-align: center">
                            <td>{{ date('d M Y', strtotime($val['start_date'])) }}</td>
                            <td>{{ date('d M Y', strtotime($val['end_date'])) }}</td>
                            <td>{{ $val['status'] }}</td>
                            <td>{{ date('d M Y', strtotime($val['created_at'])) }}</td>
                            <td>
                                @if($val['status'] == "Running")
                                    <a class="btn btn-sm btn-info"  href="{{url('hair-stylist/generate/commission')}}"><i class="fa fa-refresh"></i></a>
                                   @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="4" style="text-align: center">Data Not Available</td></tr>
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