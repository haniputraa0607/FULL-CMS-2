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
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .datepicker{
            padding: 6px 12px;
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('.select2').select2();
        function changeSelect(){
            setTimeout(function(){
                $(".select2").select2({
                    placeholder: "Search"
                });
            }, 100);
        }
        $('.datepicker').datepicker({
            'format' : 'dd MM yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });
    
        $(document).ready(function() {
            $('[data-switch=true]').bootstrapSwitch();
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
                <span class="caption-subject font-dark sbold uppercase font-blue">{{ $sub_title }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('req-product/store') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-5">Code Conversion
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode unik data konversi" data-container="body"></i></label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['code_conversion'] }}" readonly required/>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-5">Outlet
                            <i class="fa fa-question-circle tooltips" data-original-title="Outlet yang melakukannya konversi unit" data-container="body"></i></label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['outlet_name'] }}" readonly required/>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-5">User
                            <i class="fa fa-question-circle tooltips" data-original-title="Pengguna yang melakukannya konversi unit" data-container="body"></i></label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['name'] }}" readonly required/>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-5">Product
                            <i class="fa fa-question-circle tooltips" data-original-title="Product yang dikonversi" data-container="body"></i></label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['product_icount_name'] }}" readonly required/>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-5">Conversion
                            <i class="fa fa-question-circle tooltips" data-original-title="Konversi yang dilakukan" data-container="body"></i></label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['unit'] }} to {{ $result['unit_conversion'] }} with ratio {{ $result['ratio'] }}" readonly required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-5">Converted {{ $result['unit'] }}
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah unit yang dikonversikan" data-container="body"></i></label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['qty_conversion'] }}" readonly required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-5">Received {{ $result['unit_conversion'] }}
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah unit yang dikonversikan" data-container="body"></i></label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['qty_unit_converion'] }}" readonly required/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    


@endsection