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

    <script type="text/javascript">

        @if(!is_array($conditions) || count($conditions) <= 0)
        var count_product_service_use = 1;
                @else
        var count_product_service_use = {{count($conditions)}};
        @endif
        
        function addProductServiceUse() {
            var html_select = '';
            <?php
            foreach($products as $row){
            ?>
                html_select += "<option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>";
            <?php
            }
            ?>

            var status = ';'
            @if(MyHelper::hasAccess([419], $grantedFeature))
                status = '<select class="form-control select2" id="product_use_status_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][status]" required placeholder="Select product status" style="width: 100%">'+
                '<option></option>'+
                '<option value="Pending">Pending</option>'+
                '<option value="Approved">Approved</option>'+
                '<option value="Rejected">Rejected</option>'+
                '</select>';
            @else
                status = '<input class="form-control" type="text" id="product_use_status_'+count_product_service_use+'" value="Pending" name="product_icount['+count_product_service_use+'][status]" required placeholder="Select product status" style="width: 100%" readonly/>';
            @endif

            var html = '<div id="div_product_use_'+count_product_service_use+'">'+
            '<div class="form-group">'+
            '<div class="col-md-4">'+
            '<select class="form-control select2" id="product_use_code_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit('+count_product_service_use+',this.value)">'+
            '<option></option>'+html_select+
            '</select>'+
            '</div>'+
            '<div class="col-md-2">'+
            '<select class="form-control select2" id="product_use_unit_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][unit]" required placeholder="Select unit" style="width: 100%">'+
            '<option></option>'+
            '<option value="PCS">PCS</option>'+
            '</select>'+
            '</div>'+
            '<div class="col-md-2">'+
            '<div class="input-group">'+
            '<input type="text" class="form-control price" id="product_use_qty_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][qty]" required>'+
            '</div>'+
            '</div>'+
            '<div class="col-md-2">'+
            status+
            '</div>'+
            '<div class="col-md-1" style="margin-left: 2%">'+
            '<a class="btn btn-danger btn" onclick="deleteProductServiceUse('+count_product_service_use+')">&nbsp;<i class="fa fa-trash"></i></a>'+
            '</div>'+
            '</div>'+
            '</div>';

            $("#div_product_use").append(html);
            $('.select2').select2({placeholder: "Search"});
            count_product_service_use++;
        }

        function deleteProductServiceUse(number){
            $('#div_product_use_'+number).empty();
        }

        function changeUnit(no,value){
            this_id = '#product_use_unit_'+no;
            $(this_id).empty();
            $('#product_use_unit_'+no).val('');
            $('#product_use_qty_'+no).val('');
            var html_select = '<option></option>';
            var unit1 = '';
            var unit2 = '';
            var unit3 = '';
            <?php 
                foreach($products as $row){ ?>
                    if(value=={{ $row['id_product_icount'] }}){
                        unit1 = '{{ $row['unit1'] }}'
                        unit2 = '{{ $row['unit2'] }}'
                        unit3 = '{{ $row['unit3'] }}'
                        if(unit1!=''){
                            html_select += "<option value='<?php echo $row['unit1']; ?>'><?php echo $row['unit1']; ?></option>";
                        }
                        if(unit2!=''){
                            html_select += "<option value='<?php echo $row['unit2']; ?>'><?php echo $row['unit2']; ?></option>";
                        }
                        if(unit3!=''){
                            html_select += "<option value='<?php echo $row['unit3']; ?>'><?php echo $row['unit3']; ?></option>";
                        }
                    }
                <?php 
                }
            ?>
            $(this_id).append(html_select);
            $(".select2").select2({
                placeholder: "Search"
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
                <span class="caption-subject font-dark sbold uppercase font-blue">{{ $sub_title }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('dev-product/update') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <input class="form-control" type="hidden" id="input-code" name="id_delivery_product" value="{{$result['id_delivery_product']}}" readonly/>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Code 
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode unik permintaan produk" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" name="code" value="{{$result['code']}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">User Delivery 
                            <i class="fa fa-question-circle tooltips" data-original-title="User yang membuat pengeriman produk" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" value="{{$result['delivery_product_user_delivery']['name']}}" readonly/>
                            <input class="form-control" type="hidden" id="input-code" name="id_user_delivery" value="{{$result['id_user_delivery']}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Outlet Name <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama outlet yang membuat permintaan produk" data-container="body"></i></label>
                        <div class="col-md-5">
                            {{--  <select class="form-control select2 approvedForm" name="id_outlet" required>
                                <option value="" selected disabled>Select Outlet</option>
                                @foreach($outlets as $o => $ol)
                                    <option value="{{$ol['id_outlet']}}" @if($result['id_outlet']==$ol['id_outlet']) selected @endif>{{$ol['outlet_name']}}</option>
                                @endforeach
                            </select>  --}}
                            <input class="form-control" type="text" value="{{$result['delivery_product_outlet']['outlet_name']}}" readonly/>
                            <input class="form-control" type="hidden" id="input-id_outlet" name="id_outlet" value="{{$result['id_outlet']}}" readonly/>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Request Type <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jenis permintaan barang yang akan digunakan" data-container="body"></i></label>
                        <div class="col-md-5">
                            {{--  <select class="form-control select2 approvedForm" name="type" required>
                                <option value="" selected disabled>Select Outlet</option>
                                <option value="Sell" @if($result['type']=='Sell') selected @endif>For Sale</option>
                                <option value="Use" @if($result['type']=='Use') selected @endif>To Uses</option>
                            </select>  --}}
                            @php
                                if($result['type']=='Sell'){
                                    $type = 'For Sale';
                                }elseif($result['type']=='Use'){
                                    $type = 'To Uses';
                                }
                            @endphp
                            <input class="form-control" type="text" id="input-type" value="{{$type}}" readonly/>
                            <input class="form-control" type="hidden" id="input-type" name="type" value="{{$result['type']}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Delivery Charged <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Biaya dibebankan kepada" data-container="body"></i></label>
                        <div class="col-md-5">
                            <select class="form-control select2 approvedForm" name="charged" required>
                                <option value="" selected disabled>Select Outlet</option>
                                <option value="Outlet" @if($result['charged']=='Outlet') selected @endif>Outlet</option>
                                <option value="Central" @if($result['charged']=='Central') selected @endif>Central</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Reference Request 
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih permintaan yang direspon" data-container="body"></i></label>
                        <div class="col-md-5">
                            @php
                                $selected_request = [];
                                if (old('request')) {
                                    $selected_request = old('request');
                                }
                                elseif (!empty($result['request'])) {
                                    $selected_request = array_column($result['request'], 'id_request_product');
                                }
                            @endphp
                            <select class="form-control select2-multiple approvedForm" name="request[]" multiple >
                                <option value=""></option>
                                @if (!empty($requests))
                                    @foreach($requests as $request)
                                        <option value="{{ $request['id_request_product'] }}" 
                                            @if ($selected_request) 
                                                @if(in_array($request['id_request_product'], $selected_request)) selected 
                                                @endif 
                                            @endif
                                        >{{ $request['code'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Delivery Date <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal barang akan dikirim" data-container="body"></i></label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" id="start_date" class="datepicker form-control" name="delivery_date" @if(isset($result['delivery_date'])) value="{{date('d F Y', strtotime($result['delivery_date']))}}" @endif required>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Status 
                            <i class="fa fa-question-circle tooltips" data-original-title="Status dari permintaan produk yang diajukan" data-container="body"></i></label>
                        <div class="col-md-5">
                            @if($result['status'] == 'Completed')
                                <span class="badge" style="background-color: #26C281; color: #ffffff; margin-top: 8px">{{$result['status']}}</span>
                            @elseif($result['status'] == 'On Progress')
                                <span class="badge" style="background-color: #e1e445; color: #ffffff; margin-top: 8px">{{$result['status']}}</span>
                            @elseif($result['status'] == 'Cancelled')
                                <span class="badge" style="background-color: #db1912; color: #ffffff; margin-top: 8px">{{$result['status']}}</span>
                            @else
                                <span class="badge" style="background-color: #1512db; color: #ffffff; margin-top: 8px">{{$result['status']}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="portlet light" style="margin-bottom: 0; padding-bottom: 0">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject sbold uppercase font-black">Product Request</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <b>Product</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Unit</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Quantity</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Status</b>
                                </div>
                            </div>
                            <div id="div_product_use">
                                @foreach($result['delivery_product_detail'] as $key=>$value)
                                <div id="div_product_use_{{$key}}">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            {{--  @if(MyHelper::hasAccess([419], $grantedFeature))
                                            <select class="form-control select2" id="product_use_code_{{$key}}" name="product_icount[{{$key}}][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit({{$key}},this.value)">
                                                <option></option>
                                                @foreach($products as $product_use)
                                                    <option value="{{$product_use['id_product_icount']}}" @if($product_use['id_product_icount'] == $value['id_product_icount']) selected @endif>{{$product_use['code']}} - {{$product_use['name']}}</option>
                                                @endforeach
                                            </select>
                                            @else  --}}
                                            @foreach($products as $product_use)
                                                @if($product_use['id_product_icount'] == $value['id_product_icount']) 
                                                    <input class="form-control" type="text" value="{{$product_use['code']}} - {{$product_use['name']}}" required placeholder="Select product use" style="width: 100%" readonly/>
                                                @endif
                                            @endforeach
                                            <input class="form-control" type="hidden" id="product_use_code_{{$key}}" value="{{$value['id_product_icount']}}" name="product_icount[{{$key}}][id_product_icount]" required placeholder="Select product use" style="width: 100%" readonly/>
                                            {{--  @endif  --}}
                                        </div>
                                        <div class="col-md-2">
                                            {{--  @if(MyHelper::hasAccess([419], $grantedFeature))
                                            <select class="form-control select2" id="product_use_unit_{{$key}}" name="product_icount[{{$key}}][unit]" required placeholder="Select unit" style="width: 100%">
                                                <option></option>
                                                @foreach($products as $use)
                                                    @if ($use['id_product_icount'] == $value['id_product_icount'])
                                                        @if($use['unit1']) <option value="{{ $use['unit1'] }}" @if($use['unit1'] == $value['unit']) selected @endif>{{ $use['unit1'] }}</option> @endif
                                                        @if($use['unit2']) <option value="{{ $use['unit2'] }}" @if($use['unit2'] == $value['unit']) selected @endif>{{ $use['unit2'] }}</option> @endif
                                                        @if($use['unit3']) <option value="{{ $use['unit3'] }}" @if($use['unit3'] == $value['unit']) selected @endif>{{ $use['unit3'] }}</option> @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                            @else  --}}
                                            <input class="form-control" type="text" id="product_use_unit_{{$key}}" value="{{$value['unit']}}" name="product_icount[{{$key}}][unit]" required placeholder="Select unit" style="width: 100%" readonly/>
                                            {{--  @endif  --}}
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <input type="text" class="form-control price" id="product_use_qty_{{$key}}" name="product_icount[{{$key}}][qty]" required value="{{$value['value']}}" @if(!MyHelper::hasAccess([419], $grantedFeature)) readonly @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            @if(MyHelper::hasAccess([415], $grantedFeature))
                                            <select class="form-control select2" id="product_use_status_{{$key}}" name="product_icount[{{$key}}][status]" required placeholder="Select product status" style="width: 100%">
                                                <option></option>
                                                <option value="Pending" @if($value['status']=='Pending') selected @endif>Pending</option>
                                                <option value="Approved" @if($value['status']=='Approved') selected @endif>Approved</option>
                                                <option value="Rejected" @if($value['status']=='Rejected') selected @endif>Rejected</option>
                                            </select>
                                            @else
                                            <input class="form-control" type="text" id="product_use_status_{{$key}}" value="{{$value['status']}}" name="product_icount[{{$key}}][status]" required placeholder="Select product status" style="width: 100%" readonly/>
                                            @endif
                                        </div>
                                        <div class="col-md-1" style="margin-left: 2%">
                                            <a class="btn btn-danger btn" onclick="deleteProductServiceUse({{$key}})">&nbsp;<i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            @if ($result['status']=='Pending' && MyHelper::hasAccess([413], $grantedFeature))
                            <div class="form-group">
                                <div class="col-md-4">
                                    <a class="btn btn-primary" onclick="addProductServiceUse()">&nbsp;<i class="fa fa-plus-circle"></i> Add Product </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    


@endsection