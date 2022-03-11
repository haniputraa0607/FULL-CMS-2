@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
<script type="text/javascript">

    let currentId = 1;
    function addProductCatalog() {
        const template = `
            <tr data-id="${currentId}">
                <td>
                    <select class="select2 form-control filter" name="product_catalog_detail[${currentId}][filter]" required onchange="productFilter(${currentId}, this.value)">
                        <option selected disabled></option>
                        <option value="Inventory">Inventory</option>
                        <option value="Non Inventory">Non Inventory</option>
                        <option value="Service">Service</option>
                        <option value="Assets">Assets</option>
                    </select>
                </td>
                <td>
                    <select class="select2 form-control product" name="product_catalog_detail[${currentId}][id_product_icount]" required>
                        <option selected disabled></option>
                        @foreach($products as $product_icount)
                        <option value="{{$product_icount['id_product_icount']}}" data-full="{{json_encode($product_icount)}}">{{$product_icount['name']}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-control select2 budget" name="product_catalog_detail[${currentId}][budget_code]" required>
                        <option selected disabled></option>
                        <option>Invoice</option>
                        <option>Beban</option>
                    </select>
                </td>
                <td>
                    <button type="button" onclick="deleteProductCatalog(${currentId})" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                </td>
            </tr>
        `;
        $('#products-container tbody').append(template);
        $(`tr[data-id=${currentId}] select`).select2({
            placeholder: "Select"
        });
        currentId++;
    }

    function deleteProductCatalog(id) {
        $(`#products-container tr[data-id=${id}]`).remove();
    }

    function selectCompany(val){
        for (var i = 0; i < currentId; i++) {
            $(`tr[data-id=${i}] select.filter`).val('');
            $(`tr[data-id=${i}] select.product`).empty();
            $(`tr[data-id=${i}] select.budget`).val('');
        }
        var html_select = `<option></option>`;
        
        <?php
            foreach($products as $row){
            ?>

            if(val=='ima'){
                <?php 
                    if($row['company_type']=='ima'){
                ?>
                html_select += `<option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>`;
                <?php
                    }   
                ?>
            }else if(val=='ims'){
                <?php 
                    if($row['company_type']=='ims'){
                ?>
                html_select += `<option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>`;
                <?php
                    }   
                ?>
            }
            
            <?php
            }
        ?>

        for (var i = 0; i < currentId; i++) {
            $(`tr[data-id=${i}] select.product`).append(html_select);
            $(`tr[data-id=${i}] select`).select2({
                placeholder: "Select"
            });
        }
    }

    function productFilter(id,value) {
        var company = $('#company_type option:selected').val();
        $(`tr[data-id=${id}] select.product`).empty();
        $(`tr[data-id=${id}] select.budget`).empty();
        var html_select = `<option></option>`;
        var budget = `
            <option></option>
            <option>Invoice</option>
            <option>Beban</option>`;

        if(company == 'ima'){
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
        }else if(company == 'ims'){
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
            
        $(`tr[data-id=${id}] select.product`).append(html_select);
        $(`tr[data-id=${id}] select.budget`).append(budget);
        $(`tr[data-id=${currentId}] select`).select2();
    }


    $(document).ready(function() {
        $(".select2").select2({
            placeholder: "Select"
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
                <span class="caption-subject sbold uppercase font-blue">New Product Catalog</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama Katalog Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Product Catalog Name" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Company Type <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jenis company untuk katalog produk" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select class="form-control select2 budget" id="company_type" name="company_type" required onchange="selectCompany(this.value)">
                                    <option value="" selected disabled></option>
                                    <option value="ima">PT IMA</option>
                                    <option value="ims">PT IMS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Status
                            <i class="fa fa-question-circle tooltips" data-original-title="Status katalog produk aktif atau tidak" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="checkbox" class="make-switch brand_status" data-size="small" data-on-color="info" data-on-text="Active" data-off-color="default" name="status" data-off-text="Inactive" value="1" @if(old('status')) checked @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                       <label for="multiple" class="control-label col-md-3">Description
                           <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Katalog Produk" data-container="body"></i>
                       </label>
                       <div class="col-md-8">
                           <div class="input-icon right">
                               <textarea name="description" id="text_pro" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
                           </div>
                       </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <center><b>Product Detail</b></center>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <table id="products-container" class="table">
                                <thead>
                                    <tr>
                                        <th width="160px">Filter</th>
                                        <th>Product</th>
                                        <th width="150px">Budget Code</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-id="0">
                                        <td>
                                            <select class="select2 form-control filter" name="product_catalog_detail[0][filter]" required onchange="productFilter(0, this.value)">
                                                <option value="" selected disabled></option>
                                                <option value="Inventory">Inventory</option>
                                                <option value="Non Inventory">Non Inventory</option>
                                                <option value="Service">Service</option>
                                                <option value="Assets">Assets</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="select2 form-control product" name="product_catalog_detail[0][id_product_icount]" required>
                                                <option value="" selected disabled></option>
                                                @foreach($products as $product_icount)
                                                <option value="{{$product_icount['id_product_icount']}}" data-full="{{json_encode($product_icount)}}">{{$product_icount['name']}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control select2 budget" name="product_catalog_detail[0][budget_code]" required>
                                                <option value="" selected disabled></option>
                                                <option value="Invouce">Invoice</option>
                                                <option value="Beban">Beban</option>
                                                <option value="Assets">Assets</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" onclick="deleteProductCatalog(0)" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12" style="padding-left: 22px !important">
                            <a class="btn btn-primary" onclick="addProductCatalog()">&nbsp;<i class="fa fa-plus-circle"></i> Add Product </a>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="text-center">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection