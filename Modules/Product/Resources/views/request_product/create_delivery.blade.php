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
            function changeSelect(){
                setTimeout(function(){
                    $(".select2").select2({
                        placeholder: "Search"
                    });
                }, 100);
            }
        });
    </script>

    <script type="text/javascript">
        
        @if(!is_array($result['request_product_detail'] ?? [] ) || count($result['request_product_detail'] ?? []) <= 0)
        var count_product_service_use = 1;
                @else
        var count_product_service_use = {{count($result['request_product_detail'])}};
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

            var html = '<div id="div_product_use_'+count_product_service_use+'">'+
            '<div class="form-group">'+
            '<div class="col-md-1"></div>'+
            '<div class="col-md-4">'+
            '<select class="form-control select2" id="product_use_code_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit('+count_product_service_use+',this.value)">'+
            '<option></option>'+html_select+
            '</select>'+
            '</div>'+
            '<div class="col-md-2">'+
            '<select class="form-control select2" id="product_use_unit_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][unit]" required placeholder="Select unit" style="width: 100%" onchange="emptyQty('+count_product_service_use+',this.value)">'+
            '<option></option>'+
            '<option value="PCS">PCS</option>'+
            '</select>'+
            '</div>'+
            '<div class="col-md-2">'+
            '<div class="input-group">'+
            '<input type="text" class="form-control price" id="product_use_qty_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][qty]" required>'+
            '</div>'+
            '</div>'+
            '<div class="col-md-1" style="margin-left: 2%">'+
            '<a class="btn btn-danger btn" onclick="deleteProductServiceUse('+count_product_service_use+')">&nbsp;<i class="fa fa-trash"></i></a>'+
            '</div>'+
            '</div>'+
            '</div>';

            $("#div_product_use").append(html);
            $('#div_product_use .select2').select2({placeholder: "Search"});
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
            $("#div_product_use .select2").select2({
                placeholder: "Search"
            });
    
        }

        function emptyQty(no,value){
            $('#product_use_qty_'+no).val('');
            $("#div_product_use .select2").select2({
                placeholder: "Search"
            });
        }

        function requestByOutlet(value){
            let id_outlet = value;
            let type = $('#type').val();
            let status = '<option></option>';

            
            $.ajax({
                type : "POST",
                url : "{{ url('dev-product/request') }}",
                data : {
                    '_token' : '{{csrf_token()}}',
                    'id_outlet' : id_outlet,
                    'type' : type
                },
                success : function(result) {
                    $('#select_request').empty();
                    if(result.length > 0){
                        $.each(result, function(i, index) {
                            status += '<option value="'+index.id_request_product+'">'+index.code+'</option>';
                          });
                    }
                    $('#select_request').append(status);
                },
                error : function(result) {
                    toastr.warning("Something went wrong. Failed to get list request product.");
                }
            });
 
        }

        function requestByType(value){
            let type = value;
            let id_outlet = $('#id_outlet').val();
            let status = '<option></option>';

            $.ajax({
                type : "POST",
                url : "{{ url('dev-product/request') }}",
                data : {
                    '_token' : '{{csrf_token()}}',
                    'id_outlet' : id_outlet,
                    'type' : type
                },
                success : function(result) {
                    $('#select_request').empty();
                    if(result.length > 0){
                        $.each(result, function(i, index) {
                            status += '<option value="'+index.id_request_product+'">'+index.code+'</option>';
                          });
                    }
                    $('#select_request').append(status);
                },
                error : function(result) {
                    toastr.warning("Something went wrong. Failed to get list request product.");
                }
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
            <form class="form-horizontal" role="form" action="{{ url('dev-product/store') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Outlet Name <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama outlet yang membuat permintaan produk" data-container="body"></i></label>
                        <div class="col-md-5">
                            @if(!isset($result['id_request_product']))
                            <select class="form-control select2 approvedForm" name="id_outlet" id="id_outlet" required onchange="requestByOutlet(this.value)">
                                <option value="" selected disabled>Select Outlet</option>
                                @foreach($outlets as $o => $ol)
                                    <option value="{{$ol['id_outlet']}}">{{$ol['outlet_name']}}</option>
                                @endforeach
                            </select>
                            @else
                            <input class="form-control" type="text" value="{{$result['request_product_outlet']['outlet_name']}}" readonly/>
                            <input class="form-control" type="hidden" name="id_outlet" value="{{$result['id_outlet']}}" readonly/>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Request Type <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jenis permintaan barang yang akan digunakan" data-container="body"></i></label>
                        <div class="col-md-5">
                            @if(!isset($result['id_request_product']))
                            <select class="form-control select2 approvedForm" name="type" id="type" required onchange="requestByType(this.value)">
                                <option value="" selected disabled>Select Outlet</option>
                                <option value="Sell">For Sale</option>
                                <option value="Use">To Uses</option>
                            </select>
                            @else
                            <input class="form-control" type="text" name="type" value="{{$result['type']}}" readonly/>
                            @endif
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
                                elseif (!empty($result['id_request_product'])) {
                                    $selected_request[0] = $result['id_request_product'];
                                }
                            @endphp
                            <select class="form-control select2-multiple approvedForm" name="request[]" multiple id="select_request">
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
                        <label for="example-search-input" class="control-label col-md-4">Delivery Charged <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Biaya dibebankan kepada" data-container="body"></i></label>
                        <div class="col-md-5">
                            <select class="form-control select2 approvedForm" name="charged" required>
                                <option value="" selected disabled>Select Outlet</option>
                                <option value="Outlet">Outlet</option>
                                <option value="Central">Central</option>
                            </select>
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
                                <div class="col-md-1"></div>
                                <div class="col-md-4">
                                    <b>Product</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Unit</b>
                                </div>
                                <div class="col-md-2">
                                    <b>Quantity</b>
                                </div>
                            </div>
                            <div id="div_product_use">
                                @if(!empty($result['request_product_detail']))
                                @foreach($result['request_product_detail'] as $key=>$value)
                                <div id="div_product_use_{{$key}}">
                                    <div class="form-group">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4">
                                            @if(!isset($result['id_request_product']))
                                            <select class="form-control select2" id="product_use_code_{{$key}}" name="product_icount[{{$key}}][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit({{$key}},this.value)">
                                                <option></option>
                                                @foreach($products as $product_use)
                                                    <option value="{{$product_use['id_product_icount']}}" @if($product_use['id_product_icount'] == $value['id_product_icount']) selected @endif>{{$product_use['code']}} - {{$product_use['name']}}</option>
                                                @endforeach
                                            </select>
                                            @else
                                            @foreach($products as $product_use)
                                                @if($product_use['id_product_icount'] == $value['id_product_icount']) 
                                                    <input class="form-control" type="text" value="{{$product_use['code']}} - {{$product_use['name']}}" required placeholder="Select product use" style="width: 100%" readonly/>
                                                @endif
                                            @endforeach
                                            <input class="form-control" type="hidden" id="product_use_code_{{$key}}" value="{{$value['id_product_icount']}}" name="product_icount[{{$key}}][id_product_icount]" required placeholder="Select product use" style="width: 100%" readonly/>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            @if(!isset($result['id_request_product']))
                                            <select class="form-control select2" id="product_use_unit_{{$key}}" name="product_icount[{{$key}}][unit]" required placeholder="Select unit" style="width: 100%" onchange="emptyQty({{$key}},this.value)">
                                                <option></option>
                                                @foreach($products as $use)
                                                    @if ($use['id_product_icount'] == $value['id_product_icount'])
                                                        @if($use['unit1']) <option value="{{ $use['unit1'] }}" @if($use['unit1'] == $value['unit']) selected @endif>{{ $use['unit1'] }}</option> @endif
                                                        @if($use['unit2']) <option value="{{ $use['unit2'] }}" @if($use['unit2'] == $value['unit']) selected @endif>{{ $use['unit2'] }}</option> @endif
                                                        @if($use['unit3']) <option value="{{ $use['unit3'] }}" @if($use['unit3'] == $value['unit']) selected @endif>{{ $use['unit3'] }}</option> @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                            @else
                                            <input class="form-control" type="text" id="product_use_unit_{{$key}}" value="{{$value['unit']}}" name="product_icount[{{$key}}][unit]" required placeholder="Select unit" style="width: 100%" readonly/>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <input type="text" class="form-control price" id="product_use_qty_{{$key}}" name="product_icount[{{$key}}][qty]" required value="{{$value['value']}}">
                                            </div>
                                        </div>
                                        <div class="col-md-1" style="margin-left: 2%">
                                            <a class="btn btn-danger btn" onclick="deleteProductServiceUse({{$key}})">&nbsp;<i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div id="div_product_use_0">
                                    <div class="form-group">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4">
                                            <select class="form-control select2" id="product_use_code_0" name="product_icount[0][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit(0,this.value)">
                                                <option></option>
                                                @foreach($products as $product_use)
                                                    <option value="{{$product_use['id_product_icount']}}">{{$product_use['code']}} - {{$product_use['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                        <select class="form-control select2" id="product_use_unit_0" name="product_icount[0][unit]" required placeholder="Select unit" style="width: 100%">
                                            <option></option>
                                            <option value="PCS">PCS</option>
                                        </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <input type="text" class="form-control price" id="product_use_qty_0" name="product_icount[0][qty]" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="margin-left: 2%">
                                            <a class="btn btn-danger btn" onclick="deleteProductServiceUse(0)">&nbsp;<i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="col-md-1"></div>
                                <div class="col-md-4">
                                    <a class="btn btn-primary" onclick="addProductServiceUse()">&nbsp;<i class="fa fa-plus-circle"></i> Add Product </a>
                                </div>
                            </div>
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