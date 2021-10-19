<form class="form-horizontal" id="form-product-service" role="form" action="{{ url('product-service/product-use/update') }}" method="post">
    <div class="form-body">
        <div class="form-group">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <a class="btn btn-primary" onclick="addProductServiceUse()">&nbsp;<i class="fa fa-plus-circle"></i> Add Product </a>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <b>Product</b>
            </div>
            <div class="col-md-2">
                <b>Quantity Use</b>
            </div>
        </div>
        <div id="div_product_use">
            @if(empty($product_service_use))
                <div id="div_product_use_0">
                    <div class="form-group">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <select class="form-control select2" id="product_use_code_0" name="product_use_data[0][id_product]" required placeholder="Select product use" style="width: 100%">
                                <option></option>
                                @foreach($list_product_service_use as $product_use)
                                    <option value="{{$product_use['id_product']}}">{{$product_use['product_code']}} - {{$product_use['product_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <input type="text" class="form-control price" id="product_use_qty_0" name="product_use_data[0][quantity_use]" required>
                                <span class="input-group-addon">ml</span>
                            </div>
                        </div>
                        <div class="col-md-2" style="margin-left: -2%">
                            <a class="btn btn-danger btn" onclick="deleteProductServiceUse(0)">&nbsp;<i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            @else
                @foreach($product_service_use as $key=>$value)
                    <div id="div_product_use_{{$key}}">
                        <div class="form-group">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <select class="form-control select2" id="product_use_code_{{$key}}" name="product_use_data[{{$key}}][id_product]" required placeholder="Select product use" style="width: 100%">
                                    <option></option>
                                    @foreach($list_product_service_use as $product_use)
                                        <option value="{{$product_use['id_product']}}" @if($product_use['id_product'] == $value['id_product'])) selected @endif>{{$product_use['product_code']}} - {{$product_use['product_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" class="form-control price" id="product_use_qty_{{$key}}" name="product_use_data[{{$key}}][quantity_use]" required value="{{$value['quantity_use']}}">
                                    <span class="input-group-addon">ml</span>
                                </div>
                            </div>
                            <div class="col-md-2" style="margin-left: -2%">
                                <a class="btn btn-danger btn" onclick="deleteProductServiceUse({{$key}})">&nbsp;<i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="form-actions">
        {{ csrf_field() }}
        <div class="row" style="text-align: center;margin-top: 5%">
            <input type="hidden" name="id_product_service" value="{{ $product[0]['id_product'] }}">
            <input type="hidden" name="product_code" value="{{ $product[0]['product_code'] }}">
            <a onclick="productServiceUseSubmit()" class="btn green">Submit</a>
        </div>
    </div>
</form>