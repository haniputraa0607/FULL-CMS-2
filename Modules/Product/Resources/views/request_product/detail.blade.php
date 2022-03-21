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
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
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

        @if(!is_array($result['request_product_detail']) || count($result['request_product_detail']) <= 0)
        var count_product_service_use = 1;
        @else
        var count_product_service_use = {{count($result['request_product_detail'])}};
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
            '<select class="form-control select2" id="product_use_filter_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][filter]" required placeholder="Select product filter" style="width: 100%" onchange="productFilter('+count_product_service_use+',this.value)">'+
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
            '<select class="form-control select2" id="product_use_unit_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][unit]" required placeholder="Select unit" style="width: 100%" onchange="emptyQty('+count_product_service_use+',this.value)">'+
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
            '<input type="hidden" name="product_icount['+count_product_service_use+'][status]" value="Pending">'+
            '<div class="col-md-1" style="padding: 1px">'+
            '<a class="btn btn-danger btn" onclick="deleteProductServiceUse('+count_product_service_use+')">&nbsp;<i class="fa fa-trash"></i></a>'+
            '</div>'+
            '</div>'+
            '</div>';

            $("#div_product_use").append(html);
            $('.select2').select2({placeholder: "Search"});
            count_product_service_use++;
        }

        var delete_array = [];

        function deleteProductServiceUse(number){
            $('#div_product_use_'+number).empty();
            delete_array.push(number);
        }

        function changeUnit(no,value){
            this_id = '#product_use_unit_'+no;
            $(this_id).empty();
            $('#product_use_unit_'+no).val('');
            $('#product_use_qty_'+no).val('');
            $('#product_use_budget_'+no).empty();
            var html_select = `<option></option>`;
            var unit1 = '';
            var unit2 = '';
            var unit3 = '';
            var budget = '';
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
                        budget += `<option value='<?php echo $row['budget_code']; ?>'><?php echo $row['budget_code']; ?></option>`;

                    }
                <?php 
                }
            ?>
            $(this_id).append(html_select);
            $('#product_use_budget_'+no).append(budget);
            $(".select2").select2({
                placeholder: "Search"
            });
    
        }

        function emptyQty(no,value){
            $('#product_use_qty_'+no).val('');
            $(".select2").select2({
                placeholder: "Search"
            });
        }

        function productFilter(key,value){
            var company = $('#id_outlet option:selected').attr('data-company');
            $('#product_use_code_'+key).empty();
            $('#product_use_unit_'+key).empty();
            $('#product_use_qty_'+key).val('');
            $('#product_use_status_'+key).val('');
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

        $('.save-draft').on('click',function(){
            var product_icounts = [];
            var p = 0;
            for(var i = 0; i < count_product_service_use; i++){
                if($('#product_use_filter_'+i).val() != undefined && $('#product_use_code_'+i).val() != '' && $('#product_use_unit_'+i).val() != '' && $('#product_use_qty_'+i).val() != '' && $('#product_use_budget_'+i).val() != ''){
                    product_icounts[p] = {
                        filter : $('#product_use_filter_'+i).val(),
                        id_product_icount : $('#product_use_code_'+i).val(),
                        unit: $('#product_use_unit_'+i).val(),
                        qty: $('#product_use_qty_'+i).val(),
                        budget_code: $('#product_use_budget_'+i).val(),
                        status: 'Pending'
                    }
                    p++;
                }else{
                    if(delete_array.includes(i)==false){
                        var index_not_completed = p+1;
                        swal("Error!", "Please Complete Data Product "+index_not_completed+".", "error")
                        return false;
                    }
                }
            }
            var data = {
                '_token' : '{{csrf_token()}}',
                'id_request_product' : {{ $result['id_request_product'] }},
                'id_outlet' : {{ $result['id_outlet'] }},
                'id_user_request' : {{ $result['id_user_request'] }},
                'requirement_date' : $('#requirement_date').val(),
                'note_request' : $('#input-request-note').val(),
                'status' : 'Draft',
                'product_icount' : product_icounts
            }
            $.ajax({
                type : "POST",
                url : "{{url('req-product/update')}}",
                data : data,
                success : function(response) {
                    if (response.status == 'success') {
                        swal("Sent!", "Request Product has beed updated as draft", "success")
                        location.href = "{{url('req-product/detail')}}/"+{{ $result['id_request_product'] }};
                    }
                    else if(response.status == "fail"){
                        swal("Error!", "Failed to updated the request product.", "error")
                    }
                    else {
                        swal("Error!", "Something went wrong. Failed to updated the request product.", "error")
                    }
                }
            });
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
            <form class="form-horizontal" role="form" action="{{ url('req-product/update') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <input class="form-control" type="hidden" id="input-code" name="id_request_product" value="{{$result['id_request_product']}}" readonly/>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Code 
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode unik permintaan produk" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" name="code" value="{{$result['code']}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">User Request 
                            <i class="fa fa-question-circle tooltips" data-original-title="User yang membuat permintaan produk" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" value="{{$result['request_product_user_request']['name']}}" readonly/>
                            <input class="form-control" type="hidden" id="input-code" name="id_user_request" value="{{$result['id_user_request']}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Outlet Name <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama outlet yang membuat permintaan produk" data-container="body"></i></label>
                        <div class="col-md-5">
                            <select class="form-control select2 approvedForm" disabled>
                                <option value="" selected disabled>Select Outlet</option>
                                @foreach($outlets as $o => $ol)
                                    <option value="{{$ol['id_outlet']}}" data-company="{{$ol['location_outlet']['company_type']}}" @if($result['id_outlet']==$ol['id_outlet']) selected @endif>{{$ol['outlet_name']}}</option>
                                @endforeach
                            </select>
                            <input class="form-control" type="hidden" id="input-code" name="id_outlet" value="{{$result['id_outlet']}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Request Type <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jenis permintaan barang yang akan digunakan" data-container="body"></i></label>
                        <div class="col-md-5">
                            <select class="form-control select2 approvedForm" required disabled>
                                <option value="" selected disabled>Select Outlet</option>
                                <option value="Sell" @if($result['type']=='Sell') selected @endif>For Sale</option>
                                <option value="Use" @if($result['type']=='Use') selected @endif>To Uses</option>
                            </select>
                            <input class="form-control" type="hidden" id="input-code" name="type" value="{{$result['type']}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Product Catalog <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Katalog Produk yang akan diminta, , setelah request product dibuat, katalog tidak bisa diubah lagi" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" value="{{$result['catalog_name']}}" readonly/>
                            <input class="form-control" type="hidden" id="input-code" name="id_product_catalog" value="{{$result['catalog_name']}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Requirement Date <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal barang akan dibutuhkan" data-container="body"></i></label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" id="requirement_date" class="datepicker form-control" name="requirement_date" value="{{date('d F Y', strtotime($result['requirement_date']))}}" required {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Request By <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="User yang membuat permintaan produk" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" value="{{ $result['request_product_user_request']['name'] }}" readonly/>
                            <input class="form-control" type="hidden" id="input-code" name="id_user_request" value="{{ $result['id_user_request'] }}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Request Notes <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Catatan dari pembuat permintaan produk" data-container="body"></i></label>
                        <div class="col-md-5">
                            <textarea name="note_request" id="input-request-note" class="form-control" placeholder="Enter note here" required {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>{{ $result['note_request'] }}</textarea>
                        </div>
                    </div>
                    @if($result['status'] != 'Draft')
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Approve Notes <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Catatan dari yang menyetujui permintaan produk" data-container="body"></i></label>
                        <div class="col-md-5">
                            <textarea name="note_approve" id="input-note" class="form-control" placeholder="Enter note here" required {{ $result['status'] != 'Pending' ? 'disabled' : '' }} >{{ $result['note_approve'] }}</textarea>
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Status 
                            <i class="fa fa-question-circle tooltips" data-original-title="Status dari permintaan produk yang diajukan" data-container="body"></i></label>
                        <div class="col-md-5">
                            @if($result['status'] == 'Completed By Finance')
                                <span class="badge" style="background-color: #26C281; color: #ffffff; margin-top: 8px">Approved By Finance</span>
                            @elseif($result['status'] == 'Completed By User')
                                <span class="badge" style="background-color: #1d09d4; color: #ffffff; margin-top: 8px">Approved By {{$result['request_product_user_approve']['name']}}</span>
                            @elseif($result['status'] == 'Pending')
                                <span class="badge" style="background-color: #e1e445; color: #ffffff; margin-top: 8px">Pending</span>
                            @elseif($result['status'] == 'Draft')
                                <span class="badge" style="background-color: #c9c9c7; color: #ffffff; margin-top: 8px">Draft</span>
                            @else
                                <span class="badge" style="background-color: #db1912; color: #ffffff; margin-top: 8px">Rejected</span>
                            @endif
                        </div>
                    </div>
                    @if($result['status'] == 'Draft')
                    <input type="hidden" name="status" value="Pending">
                    @endif
                    @if ($result['status']=='Completed By Finance' && MyHelper::hasAccess([415], $grantedFeature))
                    <div class="form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <a class="btn btn-primary" href="{{ url('dev-product/create/'.$result['id_request_product']) }}">Create Product Delivery </a>
                        </div>
                    </div>
                    @endif
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
                                <div @if($result['status']=='Draft')class="col-md-4" @else class="col-md-3" @endif style="padding: 1px">
                                    <b>Product</b>
                                </div>
                                <div @if($result['status']=='Draft') class="col-md-2" @else class="col-md-1" @endif style="padding: 1px">
                                    <b>Unit</b>
                                </div>
                                <div class="col-md-1" style="padding: 1px">
                                    <b>Qty</b>
                                </div>
                                <div class="col-md-2" style="padding: 1px">
                                    <b>Budget Code</b>
                                </div>
                                @if ($result['status']!='Draft')
                                <div class="col-md-2" style="padding: 1px">
                                    <b>Status</b>
                                </div>
                                @endif
                            </div>
                            <div id="div_product_use">
                                @if (!empty($result['request_product_detail']))
                                @foreach($result['request_product_detail'] as $key => $value)
                                <div id="div_product_use_{{$key}}">
                                    <div class="form-group">
                                        <div class="col-md-2" style="padding: 1px">
                                            @if(MyHelper::hasAccess([413], $grantedFeature))
                                            <select class="form-control select2" id="product_use_filter_{{$key}}" name="product_icount[{{$key}}][filter]" required placeholder="Select product filter" style="width: 100%" onchange="productFilter({{$key}},this.value)" {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>
                                                <option selected disabled></option>
                                                <option value="Inventory" @if($value['filter'] == 'Inventory') selected @endif>Inventory</option>
                                                <option value="Non Inventory" @if($value['filter'] == 'Non Inventory') selected @endif>Non Inventory</option>
                                                <option value="Service" @if($value['filter'] == 'Service') selected @endif>Service</option>
                                                <option value="Assets" @if($value['filter'] == 'Assets') selected @endif>Assets</option>
                                            </select>
                                            @else
                                            <input class="form-control" type="text" id="product_use_filter_{{$key}}" value="{{$value['filter']}}" name="product_icount[{{$key}}][filter]" required placeholder="Select product status" style="width: 100%" readonly/>
                                            @endif
                                        </div>
                                        <div @if($result['status']=='Draft')class="col-md-4" @else class="col-md-3" @endif style="padding: 1px">
                                            @if(MyHelper::hasAccess([413], $grantedFeature))
                                            <select class="form-control select2" id="product_use_code_{{$key}}" name="product_icount[{{$key}}][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit({{$key}},this.value)" {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>
                                                <option></option>
                                                @php
                                                    $company_type_outlet = '';
                                                    if($result['request_product_outlet']['location_outlet']['company_type'] == 'PT IMA'){
                                                        $company_type_outlet = 'ima';
                                                    }elseif($result['request_product_outlet']['location_outlet']['company_type'] == 'PT IMS'){
                                                        $company_type_outlet = 'ims';
                                                    }   
                                                @endphp
                                                @foreach($products as $product_use)
                                                    @if ($product_use['company_type'] == $company_type_outlet)
                                                    <option value="{{$product_use['id_product_icount']}}" @if($product_use['id_product_icount'] == $value['id_product_icount']) selected @endif>{{$product_use['code']}} - {{$product_use['name']}}</option>
                                                    @endif
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
                                        <div @if($result['status']=='Draft') class="col-md-2" @else class="col-md-1" @endif style="padding: 1px">
                                            @if(MyHelper::hasAccess([413], $grantedFeature))
                                            <select class="form-control select2" id="product_use_unit_{{$key}}" name="product_icount[{{$key}}][unit]" required placeholder="Select unit" style="width: 100%" onchange="emptyQty({{$key}},this.value)" {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>
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
                                        <div class="col-md-1" style="padding: 1px">
                                            <div class="input-group">
                                                <input type="text" class="form-control price" id="product_use_qty_{{$key}}" name="product_icount[{{$key}}][qty]" required value="{{$value['value']}}" @if(!MyHelper::hasAccess([413], $grantedFeature)) readonly @endif {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="padding: 1px">
                                            @if(MyHelper::hasAccess([415], $grantedFeature))
                                            <select class="form-control select2" id="product_use_budget_{{$key}}" name="product_icount[{{$key}}][budget_code]" required placeholder="Select product status" style="width: 100%" {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>
                                                <option></option>
                                                @if ($value['filter'] == 'Assets')
                                                <option value="Assets" @if($value['budget_code']=='Assets') selected @endif>Assets</option>
                                                @else
                                                <option value="Invoice" @if($value['budget_code']=='Invoice') selected @endif>Invoice</option>
                                                <option value="Beban" @if($value['budget_code']=='Beban') selected @endif>Beban</option>
                                                @endif
                                            </select>
                                            @else
                                            <input class="form-control" type="text" id="product_use_status_{{$key}}" value="{{$value['status']}}" name="product_icount[{{$key}}][status]" required placeholder="Select product status" style="width: 100%" readonly/>
                                            @endif
                                        </div>
                                        @if ($result['status']!='Draft')
                                        <input type="hidden" name="product_icount[{{$key}}][filter]" value="{{ $value['filter'] }}">
                                        <input type="hidden" name="product_icount[{{$key}}][id_product_icount]" value="{{ $value['id_product_icount'] }}">
                                        <input type="hidden" name="product_icount[{{$key}}][unit]" value="{{ $value['unit'] }}">
                                        <input type="hidden" name="product_icount[{{$key}}][qty]" value="{{ $value['value'] }}">
                                        <input type="hidden" name="product_icount[{{$key}}][budget_code]" value="{{ $value['budget_code'] }}">
                                        <div class="col-md-2" style="padding: 1px">
                                            @if(MyHelper::hasAccess([415], $grantedFeature))
                                            <select class="form-control select2" id="product_use_status_{{$key}}" name="product_icount[{{$key}}][status]" required placeholder="Select product status" style="width: 100%" {{ $result['status'] != 'Pending' ? 'disabled' : '' }}>
                                                <option></option>
                                                <option value="Approved" @if($value['status']=='Approved') selected @endif>Approved</option>
                                                <option value="Rejected" @if($value['status']=='Rejected') selected @endif>Rejected</option>
                                            </select>
                                            @else
                                            <input class="form-control" type="text" id="product_use_status_{{$key}}" value="{{$value['status']}}" name="product_icount[{{$key}}][status]" required placeholder="Select product status" style="width: 100%" readonly/>
                                            @endif
                                        </div>
                                        @else
                                        <input type="hidden" name="product_icount[{{$key}}][status]" value="Pending">
                                        @endif
                                        @if ($result['status']=='Draft')
                                        <div class="col-md-1" style="padding: 1px">
                                            <a class="btn btn-danger btn" onclick="deleteProductServiceUse({{$key}})">&nbsp;<i class="fa fa-trash"></i></a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div id="div_product_use_0">
                                    <div class="form-group">
                                        <div class="col-md-2" style="padding: 1px">
                                            <select class="form-control select2" id="product_use_filter_0" name="product_icount[0][filter]" required placeholder="Select product filter" style="width: 100%" onchange="productFilter(0,this.value)" {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>
                                                <option selected disabled></option>
                                                <option value="Inventory" >Inventory</option>
                                                <option value="Non Inventory" >Non Inventory</option>
                                                <option value="Service" >Service</option>
                                                <option value="Assets" >Assets</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4" style="padding: 1px">
                                            @if(MyHelper::hasAccess([413], $grantedFeature))
                                            <select class="form-control select2" id="product_use_code_0" name="product_icount[0][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit(0,this.value)" {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>
                                                <option></option>
                                                @php
                                                    $company_type_outlet = '';
                                                    if($result['request_product_outlet']['location_outlet']['company_type'] == 'PT IMA'){
                                                        $company_type_outlet = 'ima';
                                                    }elseif($result['request_product_outlet']['location_outlet']['company_type'] == 'PT IMS'){
                                                        $company_type_outlet = 'ims';
                                                    }   
                                                @endphp
                                                @foreach($products as $product_use)
                                                    @if ($product_use['company_type'] == $company_type_outlet)
                                                    <option value="{{$product_use['id_product_icount']}}">{{$product_use['code']}} - {{$product_use['name']}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                        <div class="col-md-2" style="padding: 1px">
                                            @if(MyHelper::hasAccess([413], $grantedFeature))
                                            <select class="form-control select2" id="product_use_unit_0" name="product_icount[0][unit]" required placeholder="Select unit" style="width: 100%" onchange="emptyQty(0,this.value)" {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>
                                                <option></option>
                                                <option value="PCS" >PCS</option>
                                            </select>
                                            @endif
                                        </div>
                                        <div class="col-md-1" style="padding: 1px">
                                            <div class="input-group">
                                                <input type="text" class="form-control price" id="product_use_qty_0" name="product_icount[0][qty]" required @if(!MyHelper::hasAccess([413], $grantedFeature)) readonly @endif {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="padding: 1px">
                                            @if(MyHelper::hasAccess([415], $grantedFeature))
                                            <select class="form-control select2" id="product_use_budget_0" name="product_icount[0][budget_code]" required placeholder="Select product status" style="width: 100%" {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>
                                                <option></option>
                                                <option value="Invoice" >Invoice</option>
                                                <option value="Beban" >Beban</option>
                                                <option value="Assets" >Assets</option>
                                            </select>
                                            @endif
                                        </div>
                                        @if ($result['status']!='Draft')
                                        <div class="col-md-2" style="padding: 1px">
                                            @if(MyHelper::hasAccess([415], $grantedFeature))
                                            <select class="form-control select2" id="product_use_status_0" name="product_icount[0][status]" required placeholder="Select product status" style="width: 100%" {{ $result['status'] != 'Draft' ? 'disabled' : '' }}>
                                                <option></option>
                                                <option value="Approved" >Approved</option>
                                                <option value="Rejected" >Rejected</option>
                                            </select>
                                            @else
                                            <input class="form-control" type="text" id="product_use_status_0" name="product_icount[0][status]" required placeholder="Select product status" style="width: 100%" readonly/>
                                            @endif
                                        </div>
                                        @endif
                                        <input class="form-control" type="hidden" name="product_icount[0][status]" value="Pending"/>
                                        <div class="col-md-1" style="padding: 1px">
                                            <a class="btn btn-danger btn" onclick="deleteProductServiceUse(0)">&nbsp;<i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @if ($result['status']=='Draft' && MyHelper::hasAccess([413], $grantedFeature))
                            <div class="form-group">
                                <div class="col-md-4" style="padding: 1px">
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
                            @if($result['status'] == 'Draft')
                            <a id="confirm" class="btn green save-draft">Save As Draft</a>
                            @endif
                            @if($result['status'] == 'Draft' || $result['status'] == 'Pending')
                            <button type="submit" class="btn blue">Submit</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    


@endsection