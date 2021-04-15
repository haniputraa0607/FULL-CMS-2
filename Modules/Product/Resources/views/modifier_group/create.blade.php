@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $(".default-visibility").bootstrapSwitch();
        });
        function changeAssign(val) {
            if($('#select_product').val()){
                $('#select_product').val(null).trigger('change');
            }

            if($('#select_product_variant').val()){
                $('#select_product_variant').val(null).trigger('change');
            }

            if(val == 'Product'){
                $('#select_product').prop('disabled', false);
                $('#select_product_variant').prop('disabled', true);
                $('#select_product').prop('required', true);
                $('#select_product_variant').prop('required', false);
            }else if(val == 'Product Variant'){
                $('#select_product').prop('disabled', true);
                $('#select_product_variant').prop('disabled', false);
                $('#select_product').prop('required', true);
                $('#select_product_variant').prop('required', false);
            }
        }

        var i=0;
        function addModifier() {
            var html = '';
            html += '<div class="form-group" id="mod_'+i+'">';
            html += '<label class="col-md-1 control-label"></label>';
            html += '<div class="col-md-4">';
            html += '<input type="text" placeholder="Name (detail product)" class="form-control" name="data_modifier['+i+'][name]" required>';
            html += '</div>';
            html += '<div class="col-md-4">';
            html += '<input type="text" placeholder="Name (detail transaction)" class="form-control" name="data_modifier['+i+'][name_detail_trx]" required>';
            html += '</div>';
            html += '<div class="col-md-2">';
            html += '<input type="checkbox" class="make-switch default-visibility" data-size="small" data-on-color="info" data-on-text="Visible" data-off-color="default" data-off-text="Hidden" name="data_modifier['+i+'][visibility]" checked>';
            html += '</div>';
            html += '<div class="col-md-1">';
            html += '<a class="btn btn-danger btn-sm" onclick="deleteModifier('+i+')"><i class="fa fa-trash"></i></a>';
            html += '</div>';
            html += '</div>';

            $("#list_modifier").append(html);
            $(".default-visibility").bootstrapSwitch();
            i++;
        }

        function deleteModifier(id) {
            $("#mod_"+id).remove();
        }

        function submit() {
            var msg = '';
            var check = 0;

            if($("input[name='text']").val() === ""){
                msg += '-Topping group name can not be empty.<br>';
            }

            if($("#modifier_assign_type").val() === ""){
                msg += '-Please select assign.<br>';
            }

            if($("#modifier_assign_type").val() === "Product Variant"){
                if($("#select_product_variant").val() === ""){
                    msg += '-Please select product variant.<br>';
                }
            }else if($("#select_product").val() === null){
                msg += '-Please select product.<br>';
            }

            for(var j=0;j<i;j++){
                var operator = "data_modifier["+j+"][name]";
                if(document.getElementsByName(operator)[0]){
                    check++;
                    if(document.getElementsByName(operator)[0].value === ""){
                        msg += '-Topping name can not be empty<br>';
                        break;
                    }
                }
            }

            if(check <= 0){
                msg += '-Please add Topping one or more.<br>';
            }

            if(msg === ""){
                $( "#form_product_modifier_group" ).submit();
            }else{
                toastr.warning(msg);
            }
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
                <span class="caption-subject font-dark sbold uppercase font-blue">New Product Variant NON PRICE (NO SKU)</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" id="form_product_modifier_group" role="form" action="{{ url('product/modifier-group') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Modifier Group Name
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama product variant NON PRICE (NO SKU)" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Product Variant NON PRICE (NO SKU) Name" class="form-control" name="text" value="{{ old('text') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Assign To
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih modifier ini akan di tetapkan kemana saja. Pilih produk jika mau di tetapkan ke produk dan pilih product variant jika mau di tetapkan ke product variant" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select  class="form-control select2" name="modifier_assign_type" id="modifier_assign_type" data-placeholder="select assing to" required onchange="changeAssign(this.value)">
                                    <option></option>
                                    <option value="Product" @if(old('modifier_assign_type')=='Product') selected @endif>Product</option>
                                    <option value="Product Variant" @if(old('modifier_assign_type')=='Product Variant') selected @endif>Product Variant</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="div_list_product">
                        <label for="multiple" class="control-label col-md-3">Product
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih product untuk menetapkan modifier" data-container="body"></i>
                        </label>
                        <div class="col-md-6">
                            <select  class="form-control select2" name="id_product[]" multiple id="select_product" disabled>
                                @foreach($products as $p)
                                    <option value="{{$p['id_product']}}">{{$p['product_code']}} - {{$p['product_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="div_list_product_variant">
                        <label for="multiple" class="control-label col-md-3">Variant
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih product variant untuk menetapkan modifier" data-container="body"></i>
                        </label>
                        <div class="col-md-5">
                            <select  class="form-control select2" name="id_product_variant" id="select_product_variant" disabled>
                                <option></option>
                                @foreach($product_variant as $pv)
                                    <option value="{{$pv['id_product_variant']}}">{{$pv['product_variant_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="div_list_product_variant">
                        <label for="multiple" class="control-label col-md-3">Add Modifier
                        </label>
                        <div class="col-md-5">
                            <a class="btn green" onclick="addModifier()">Add Modifier Group <i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                    <div id="list_modifier">
                    </div>
                </div>
                {{ csrf_field() }}
            </form>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button onclick="submit()" class="btn green"><i class="fa fa-check"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection