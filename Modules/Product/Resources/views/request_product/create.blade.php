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
            var company = $('#id_outlet option:selected').attr('data-company');
            var html_select = '';
            <?php
            foreach($products as $row){
            ?>
            if(company=='PT IMA'){
                <?php 
                    if($row['company_type']=='ima'){
                ?>
                html_select += `<option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>`;
                <?php
                    }   
                ?>
            }else if(company=='PT IMS'){
                <?php 
                    if($row['company_type']=='ims'){
                ?>
                html_select += `<option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>`;
                <?php
                    }   
                ?>
            }else{
                html_select += `<option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>`;
            }
            <?php
            }
            ?>

            var html = '<div id="div_product_use_'+count_product_service_use+'">'+
            '<div class="form-group">'+
            '<div class="col-md-2" style="padding: 1px">'+
            '<select class="form-control select2" id="product_use_filter_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][filter]" required placeholder="Select product use" style="width: 100%" onchange="productFilter('+count_product_service_use+',this.value)">'+
            '<option selected disabled></option>'+
            '<option value="Inventory">Inventory</option>'+
            '<option value="Non Inventory">Non Inventory</option>'+
            '<option value="Service">Service</option>'+
            '<option value="Assets">Assets</option>'+
            '</select>'+
            '</div>'+
            '<div class="col-md-4" style="padding: 1px">'+
            '<select class="form-control select2" id="product_use_code_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit('+count_product_service_use+',this.value)">'+
            '<option></option>'+html_select+
            '</select>'+
            '</div>'+
            '<div class="col-md-2" style="padding: 1px">'+
            '<select class="form-control select2" id="product_use_unit_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][unit]" required placeholder="Select unit" style="width: 100%">'+
            '<option></option>'+
            '<option value="PCS">PCS</option>'+
            '</select>'+
            '</div>'+
            '<div class="col-md-1" style="padding: 1px">'+
            '<div class="input-group">'+
            '<input type="text" class="form-control price" id="product_use_qty_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][qty]" required>'+
            '</div>'+
            '</div>'+
            '<div class="col-md-2" style="padding: 1px">'+
            '<select class="form-control select2" id="product_use_budget_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][budget_code]" required placeholder="Select budget code" style="width: 100%">'+
            '<option></option>'+
            '<option>Invoice</option>'+
            '<option>Beban</option>'+
            '<option>Assets</option>'+
            '</select>'+
            '</div>'+
            '<div class="col-md-1" style="padding: 1px">'+
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
            $('#product_use_budget_'+no).val('');
            var html_select = `<option></option>`;
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
                            html_select += `<option value='<?php echo $row['unit1']; ?>'><?php echo $row['unit1']; ?></option>`;
                        }
                        if(unit2!=''){
                            html_select += `<option value='<?php echo $row['unit2']; ?>'><?php echo $row['unit2']; ?></option>`;
                        }
                        if(unit3!=''){
                            html_select += `<option value='<?php echo $row['unit3']; ?>'><?php echo $row['unit3']; ?></option>`;
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

        function selectOutlet(){
            var company = $('#id_outlet option:selected').attr('data-company');
            for (var i = 0; i < count_product_service_use; i++) {
                $('#product_use_filter_'+i).val('');
                $('#product_use_code_'+i).empty();
                $('#product_use_unit_'+i).empty();
                $('#product_use_qty_'+i).val('');
                $('#product_use_budget_'+i).val('');
            }
            var html_select = `<option></option>`;
            var html_unit = '<option></option><option value="PCS">PCS</option>';
            
            <?php
            foreach($products as $row){
            ?>

            if(company=='PT IMA'){
                <?php 
                    if($row['company_type']=='ima'){
                ?>
                html_select += `<option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>`;
                <?php
                    }   
                ?>
            }else if(company=='PT IMS'){
                <?php 
                    if($row['company_type']=='ims'){
                ?>
                html_select += `<option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>`;
                <?php
                    }   
                ?>
            }else{
                html_select += `<option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>`;
            }
            
            <?php
            }
            ?>
            for (var i = 0; i < count_product_service_use; i++) {
                $("#product_use_code_"+i).append(html_select);
                $("#product_use_unit_"+i).append(html_unit);
            }
            $('.select2').select2({placeholder: "Search"});
        }

        function productFilter(key,value){
            var company = $('#id_outlet option:selected').attr('data-company');
            $('#product_use_code_'+key).empty();
            $('#product_use_unit_'+key).empty();
            $('#product_use_qty_'+key).val('');
            $('#product_use_budget_'+key).empty();
            var html_select = `<option></option>`;
            var html_unit = '<option></option><option value="PCS">PCS</option>';
            var budget = `
            <option></option>
            <option>Invoice</option>
            <option>Beban</option>`;
            if(company == 'PT IMA'){
                if(value == 'Inventory'){
                    html_select += `
                    @foreach($products as $row)
                    @if ($row['item_group'] == 'Inventory' && $row['company_type'] == 'ima')
                    <option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>
                    @endif
                    @endforeach`;
                }else if(value == 'Non Inventory'){
                    html_select += `
                    @foreach($products as $row)
                    @if ($row['item_group'] == 'Non Inventory' && $row['company_type'] == 'ima')
                    <option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>
                    @endif
                    @endforeach`;
                }else if(value == 'Service'){
                    html_select += `
                    @foreach($products as $row)
                    @if ($row['item_group'] == 'Service' && $row['company_type'] == 'ima')
                    <option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>
                    @endif
                    @endforeach`;
                }else if(value == 'Assets'){
                    html_select += `
                    @foreach($products as $row)
                    @if ($row['item_group'] == 'Assets' && $row['company_type'] == 'ima')
                    <option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>
                    @endif
                    @endforeach`;
                }   
            }else if(company == 'PT IMS'){
                if(value == 'Inventory'){
                    html_select += `
                    @foreach($products as $row)
                    @if ($row['item_group'] == 'Inventory' && $row['company_type'] == 'ims')
                    <option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>
                    @endif
                    @endforeach`;
                }else if(value == 'Non Inventory'){
                    html_select += `
                    @foreach($products as $row)
                    @if ($row['item_group'] == 'Non Inventory' && $row['company_type'] == 'ims')
                    <option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>
                    @endif
                    @endforeach`;
                }else if(value == 'Service'){
                    html_select += `
                    @foreach($products as $row)
                    @if ($row['item_group'] == 'Service' && $row['company_type'] == 'ims')
                    <option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>
                    @endif
                    @endforeach`;
                }else if(value == 'Assets'){
                    html_select += `
                    @foreach($products as $row)
                    @if ($row['item_group'] == 'Assets' && $row['company_type'] == 'ims')
                    <option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>
                    @endif
                    @endforeach`;
                }  
            }
            else{
                if(value == 'Inventory'){
                    html_select += `
                    @foreach($products as $row)
                    @if ($row['item_group'] == 'Inventory')
                    <option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>
                    @endif
                    @endforeach`;
                }else if(value == 'Non Inventory'){
                    html_select += `
                    @foreach($products as $row)
                    @if ($row['item_group'] == 'Non Inventory')
                    <option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>
                    @endif
                    @endforeach`;
                }else if(value == 'Service'){
                    html_select += `
                    @foreach($products as $row)
                    @if ($row['item_group'] == 'Service')
                    <option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>
                    @endif
                    @endforeach`;
                }else if(value == 'Assets'){
                    html_select += `
                    @foreach($products as $row)
                    @if ($row['item_group'] == 'Assets')
                    <option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>
                    @endif
                    @endforeach`;
                }   
            }
            if(value == 'Assets'){
                budget = `
                <option></option>
                <option>Assets</option>`;
            }   
            $("#product_use_code_"+key).append(html_select);
            $("#product_use_unit_"+key).append(html_unit);
            $("#product_use_budget_"+key).append(budget);
            $('.select2').select2({placeholder: "Search"});

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
            <form class="form-horizontal" role="form" action="{{ url('req-product/store') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Outlet Name <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama outlet yang membuat permintaan produk" data-container="body"></i></label>
                        <div class="col-md-5">
                            <select class="form-control select2 approvedForm" name="id_outlet" id="id_outlet" required onchange="selectOutlet()">
                                <option value="" selected disabled>Select Outlet</option>
                                @foreach($outlets as $o => $ol)
                                    <option value="{{$ol['id_outlet']}}" data-company="{{$ol['location_outlet']['company_type']}}">{{$ol['outlet_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Request Type <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jenis permintaan barang yang akan digunakan" data-container="body"></i></label>
                        <div class="col-md-5">
                            <select class="form-control select2 approvedForm" name="type" required>
                                <option value="" selected disabled>Select Outlet</option>
                                <option value="Sell">For Sale</option>
                                <option value="Use">To Uses</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Requirement Date <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal barang akan dibutuhkan" data-container="body"></i></label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" id="start_date" class="datepicker form-control" name="requirement_date" value="" required>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0px !important">
                        <label for="example-search-input" class="control-label col-md-4">Notes <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Catatan dari pembuat permintaan produk" data-container="body"></i></label>
                        <div class="col-md-5">
                            <textarea name="note_request" id="input-note" class="form-control" placeholder="Enter note here" required></textarea>
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
                                <div class="col-md-2" style="padding: 1px">
                                    <b>Filter</b>
                                </div>
                                <div class="col-md-4" style="padding: 1px">
                                    <b>Product</b>
                                </div>
                                <div class="col-md-2" style="padding: 1px">
                                    <b>Unit</b>
                                </div>
                                <div class="col-md-1" style="padding: 1px">
                                    <b>Qty</b>
                                </div>
                                <div class="col-md-2" style="padding: 1px">
                                    <b>Budget Code</b>
                                </div>
                            </div>
                            <div id="div_product_use">
                                <div id="div_product_use_0">
                                    <div class="form-group">
                                        <div class="col-md-2" style="padding: 1px">
                                            <select class="form-control select2" id="product_use_filter_0" name="product_icount[0][filter]" required placeholder="Select product use" style="width: 100%" onchange="productFilter(0,this.value)">
                                                <option selected disabled></option>
                                                <option value="Inventory">Inventory</option>
                                                <option value="Non Inventory">Non Inventory</option>
                                                <option value="Service">Service</option>
                                                <option value="Assets">Assets</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4" style="padding: 1px">
                                            <select class="form-control select2" id="product_use_code_0" name="product_icount[0][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit(0,this.value)">
                                                <option></option>
                                                @foreach($products as $product_use)
                                                    <option value="{{$product_use['id_product_icount']}}">{{$product_use['code']}} - {{$product_use['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2" style="padding: 1px">
                                            <select class="form-control select2" id="product_use_unit_0" name="product_icount[0][unit]" required placeholder="Select unit" style="width: 100%">
                                                <option></option>
                                                <option value="PCS">PCS</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1" style="padding: 1px">
                                            <div class="input-group">
                                                <input type="text" class="form-control price" id="product_use_qty_0" name="product_icount[0][qty]" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="padding: 1px">
                                            <select class="form-control select2" id="product_use_budget_0" name="product_icount[0][budget_code]" required placeholder="Select budget code" style="width: 100%">
                                                <option></option>
                                                <option>Invoice</option>
                                                <option>Beban</option>
                                                <option>Assets</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1" style="padding: 1px">
                                            <a class="btn btn-danger btn" onclick="deleteProductServiceUse(0)">&nbsp;<i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4" style="padding: 1px">
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