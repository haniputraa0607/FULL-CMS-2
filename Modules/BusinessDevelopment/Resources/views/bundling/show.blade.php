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
    $(document).ready(function() {
        $('.select2').select2();
    });
    let currentId = {{count($bundling['bundling_products'] ?? [])}};
    function addProduct() {
        const template = `
            <tr data-id="${currentId}">
                <td>
                    <select class="select2 form-control filter" name="bundling_products[${currentId}][filter]" onchange="productFilter(${currentId}, this.value)">
                        <option value="Inventory">Inventory</option>
                        <option value="Non Inventory">Non Inventory</option>
                        <option value="Service">Service</option>
                        <option value="Assets">Assets</option>
                    </select>
                </td>
                <td>
                    <select class="select2 form-control product" name="bundling_products[${currentId}][id_product_icount]" onchange="updateUnit(${currentId})">
                        @foreach($product_icounts as $product_icount)
                        @if ($product_icount['item_group'] == 'Inventory')
                        <option value="{{$product_icount['id_product_icount']}}" data-full="{{json_encode($product_icount)}}">{{$product_icount['name']}}</option>
                        @endif
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-control select2 unit" name="bundling_products[${currentId}][unit]">
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" name="bundling_products[${currentId}][qty]">
                </td>
                <td>
                    <select class="form-control select2" name="bundling_products[${currentId}][budget_code]">
                        <option>Invoice</option>
                        <option>Beban</option>
                        <option>Assets</option>
                    </select>
                </td>
                <td>
                    <button type="button" onclick="deleteProduct(${currentId})" data-toggle="confirmation" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                </td>
            </tr>
        `;
        $('#products-container tbody').append(template);
        $(`tr[data-id=${currentId}] select`).select2();
        updateUnit(currentId);
        currentId++;
    }

    function updateUnit(id) {
        const select = $(`tr[data-id=${id}] select.product`);
        full = select.find(`option[value="${select.val()}"]`).data('full');
        const options = [];
        if (full) {
            if (full.unit1) {
                options.push(full.unit1);
            }
            if (full.unit2) {
                options.push(full.unit2);
            }
            if (full.unit3) {
                options.push(full.unit3);
            }
        }

        let html = options.map(function (item) {return `<option value="${item}">${item}</option>`}, options).join('');

        $(`tr[data-id=${id}] select.unit`).html(html);
    }

    function deleteProduct(id) {
        $(`#products-container tr[data-id=${id}]`).remove();
    }

    function productFilter(id,value) {
        $(`tr[data-id=${id}] select.product`).empty();
        var val_if = ``;
        if(value == 'Inventory'){
            val_if = `
            @foreach($product_icounts as $product_icount)
            @if ($product_icount['item_group'] == 'Inventory')
            <option value="{{$product_icount['id_product_icount']}}" data-full="{{json_encode($product_icount)}}">{{$product_icount['name']}}</option>
            @endif
            @endforeach`;
        }else if(value == 'Non Inventory'){
            val_if = `
            @foreach($product_icounts as $product_icount)
            @if ($product_icount['item_group'] == 'Non Inventory')
            <option value="{{$product_icount['id_product_icount']}}" data-full="{{json_encode($product_icount)}}">{{$product_icount['name']}}</option>
            @endif
            @endforeach`;
        }else if(value == 'Service'){
            val_if = `
            @foreach($product_icounts as $product_icount)
            @if ($product_icount['item_group'] == 'Service')
            <option value="{{$product_icount['id_product_icount']}}" data-full="{{json_encode($product_icount)}}">{{$product_icount['name']}}</option>
            @endif
            @endforeach`;
        }else if(value == 'Assets'){
            val_if = `
            @foreach($product_icounts as $product_icount)
            @if ($product_icount['item_group'] == 'Assets')
            <option value="{{$product_icount['id_product_icount']}}" data-full="{{json_encode($product_icount)}}">{{$product_icount['name']}}</option>
            @endif
            @endforeach`;
        }
        $(`tr[data-id=${id}] select.product`).append(val_if);
        $(`tr[data-id=${currentId}] select`).select2();
        updateUnit(id);
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
                <span class="caption-subject sbold uppercase font-blue">New Outlet Starter Bundling</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('outlet-starter-bundling/update') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_outlet_starter_bundling" value="{{$bundling['id_outlet_starter_bundling']}}">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Bundling name" class="form-control" name="name" value="{{ old('name', $bundling['name']) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Code <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode Produk Bersifat Unik" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" class="form-control" name="code" value="{{ old('code', $bundling['code']) }}" placeholder="Bundling code" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Status
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode Produk Bersifat Unik" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="checkbox" class="make-switch brand_status" data-size="small" data-on-color="info" data-on-text="Active" data-off-color="default" name="status" data-off-text="Inactive" value="1" @if(old('status', $bundling['status'])) checked @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                       <label for="multiple" class="control-label col-md-3">Description
                           <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
                       </label>
                       <div class="col-md-8">
                           <div class="input-icon right">
                               <textarea name="description" id="text_pro" class="form-control">{{ old('description', $bundling['description']) }}</textarea>
                           </div>
                       </div>
                    </div>
                    <br>
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
                                        <th width="100px">Unit</th>
                                        <th width="100px">Qty</th>
                                        <th width="150px">Budget Code</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bundling['bundling_products'] as $key => $bundling_product)
                                        <tr data-id="{{$key}}">
                                            <td>
                                                <select class="select2 form-control filter" name="bundling_products[{{$key}}][filter]" onchange="productFilter({{$key}}, this.value)">
                                                    <option value="Inventory" @if($bundling_product['filter'] == 'Inventory') selected @endif>Inventory</option>
                                                    <option value="Non Inventory" @if($bundling_product['filter'] == 'Non Inventory') selected @endif>Non Inventory</option>
                                                    <option value="Service" @if($bundling_product['filter'] == 'Service') selected @endif>Service</option>
                                                    <option value="Assets" @if($bundling_product['filter'] == 'Assets') selected @endif>Assets</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="select2 form-control product" name="bundling_products[{{$key}}][id_product_icount]" onchange="updateUnit({{$key}})">
                                                    @foreach($product_icounts as $product_icount)
                                                    @if ($product_icount['item_group'] == $bundling_product['filter'])
                                                    <option value="{{$product_icount['id_product_icount']}}" data-full="{{json_encode($product_icount)}}" @if($product_icount['id_product_icount'] == $bundling_product['id_product_icount']) selected @endif>{{$product_icount['name']}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control select2 unit" name="bundling_products[{{$key}}][unit]">
                                                    <option>{{$bundling_product['unit']}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="bundling_products[{{$key}}][qty]" value="{{$bundling_product['qty']}}">
                                            </td>
                                            <td>
                                                <select class="form-control select2" name="bundling_products[{{$key}}][budget_code]">
                                                    <option {{$bundling_product['budget_code'] == 'Invoice' ? 'selected' : ''}}>Invoice</option>
                                                    <option {{$bundling_product['budget_code'] == 'Beban' ? 'selected' : ''}}>Beban</option>
                                                    <option {{$bundling_product['budget_code'] == 'Assets' ? 'selected' : ''}}>Assets</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" onclick="deleteProduct({{$key}})" data-toggle="confirmation" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                <button class="btn green" type="button" onclick="addProduct()">Add Product</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn blue">Submit</button>
                            <!--<button type="submit" name="next" value="1" class="btn blue">Submit & Manage Photo</button>-->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection