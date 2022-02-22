<form class="form-horizontal" id="form-product-service" role="form" action="{{ url('product-service/product-use/update') }}" method="post">
    
    <div class="form-body">
        <div class="form-group">
            <center><b>Product Use IMA</b></center>
        </div>
        <div class="form-group">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <a class="btn btn-primary" onclick="addProductServiceUse('ima')">&nbsp;<i class="fa fa-plus-circle"></i> Add Product </a>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <b>Product</b>
            </div>
            <div class="col-md-2">
                <b>Unit</b>
            </div>
            <div class="col-md-2">
                <b>Quantity</b>
            </div>
        </div>
        <div id="div_product_use_ima">
            @if(empty($product_icount_use_ima))
                <div id="div_product_use_ima_0">
                    <div class="form-group">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <select class="form-control select2" id="product_use_code_ima_0" name="product_icount_ima[0][id_product_icount]" placeholder="Select product use" style="width: 100%" onchange="changeUnit(0,this.value,'ima')">
                                <option></option>
                                @foreach($product_uses_ima as $product_use)
                                    <option value="{{$product_use['id_product_icount']}}">{{$product_use['code']}} - {{$product_use['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select2" id="product_use_unit_ima_0" name="product_icount_ima[0][unit]" placeholder="Select unit" style="width: 100%">
                                <option></option>
                                <option value="PCS">PCS</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <div class="input-group">
                                <input type="text" class="form-control price" id="product_use_qty_ima_0" name="product_icount_ima[0][qty]">
                            </div>
                        </div>
                        <div class="col-md-2" style="margin-left: 2%">
                            <a class="btn btn-danger btn" onclick="deleteProductServiceUse(0,'ima')">&nbsp;<i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            @else
                @foreach($product_icount_use_ima as $key=>$value)
                    <div id="div_product_use_ima_{{$key}}">
                        <div class="form-group">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <select class="form-control select2" id="product_use_code_ima_{{$key}}" name="product_icount_ima[{{$key}}][id_product_icount]" placeholder="Select product use" style="width: 100%" onchange="changeUnit({{$key}},this.value,'ima')">
                                    <option></option>
                                    @foreach($product_uses_ima as $product_use)
                                        <option value="{{$product_use['id_product_icount']}}" @if($product_use['id_product_icount'] == $value['id_product_icount']) selected @endif>{{$product_use['code']}} - {{$product_use['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control select2" id="product_use_unit_ima_{{$key}}" name="product_icount_ima[{{$key}}][unit]" placeholder="Select unit" style="width: 100%">
                                    <option></option>
                                    @foreach($product_uses_ima as $use)
                                        @if ($use['id_product_icount'] == $value['id_product_icount'])
                                            @if($use['unit1']) <option value="{{ $use['unit1'] }}" @if($use['unit1'] == $value['unit']) selected @endif>{{ $use['unit1'] }}</option> @endif
                                            @if($use['unit2']) <option value="{{ $use['unit2'] }}" @if($use['unit2'] == $value['unit']) selected @endif>{{ $use['unit2'] }}</option> @endif
                                            @if($use['unit3']) <option value="{{ $use['unit3'] }}" @if($use['unit3'] == $value['unit']) selected @endif>{{ $use['unit3'] }}</option> @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                <div class="input-group">
                                    <input type="text" class="form-control price" id="product_use_qty_ima_{{$key}}" name="product_icount_ima[{{$key}}][qty]" value="{{$value['qty']}}">
                                </div>
                            </div>
                            <div class="col-md-2" style="margin-left: 2%">
                                <a class="btn btn-danger btn" onclick="deleteProductServiceUse({{$key}},'ima')">&nbsp;<i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <br><br>
    <div class="form-body">
        <div class="form-group">
            <center><b>Product Use IMS</b></center>
        </div>
        <div class="form-group">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <a class="btn btn-primary" onclick="addProductServiceUse('ims')">&nbsp;<i class="fa fa-plus-circle"></i> Add Product </a>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <b>Product</b>
            </div>
            <div class="col-md-2">
                <b>Unit</b>
            </div>
            <div class="col-md-2">
                <b>Quantity</b>
            </div>
        </div>
        <div id="div_product_use_ims">
            @if(empty($product_icount_use_ims))
                <div id="div_product_use_ims_0">
                    <div class="form-group">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <select class="form-control select2" id="product_use_code_ims_0" name="product_icount_ims[0][id_product_icount]" placeholder="Select product use" style="width: 100%" onchange="changeUnit(0,this.value,'ims')">
                                <option></option>
                                @foreach($product_uses_ims as $product_use)
                                    <option value="{{$product_use['id_product_icount']}}">{{$product_use['code']}} - {{$product_use['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select2" id="product_use_unit_ims_0" name="product_icount_ims[0][unit]" placeholder="Select unit" style="width: 100%">
                                <option></option>
                                <option value="PCS">PCS</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <div class="input-group">
                                <input type="text" class="form-control price" id="product_use_qty_ims_0" name="product_icount_ims[0][qty]">
                            </div>
                        </div>
                        <div class="col-md-2" style="margin-left: 2%">
                            <a class="btn btn-danger btn" onclick="deleteProductServiceUse(0,'ims')">&nbsp;<i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            @else
                @foreach($product_icount_use_ims as $key=>$value)
                    <div id="div_product_use_ims_{{$key}}">
                        <div class="form-group">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <select class="form-control select2" id="product_use_code_ims_{{$key}}" name="product_icount_ims[{{$key}}][id_product_icount]" placeholder="Select product use" style="width: 100%" onchange="changeUnit({{$key}},this.value,'ims')">
                                    <option></option>
                                    @foreach($product_uses_ims as $product_use)
                                        <option value="{{$product_use['id_product_icount']}}" @if($product_use['id_product_icount'] == $value['id_product_icount']) selected @endif>{{$product_use['code']}} - {{$product_use['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control select2" id="product_use_unit_ims_{{$key}}" name="product_icount_ims[{{$key}}][unit]" placeholder="Select unit" style="width: 100%">
                                    <option></option>
                                    @foreach($product_uses_ims as $use)
                                        @if ($use['id_product_icount'] == $value['id_product_icount'])
                                            @if($use['unit1']) <option value="{{ $use['unit1'] }}" @if($use['unit1'] == $value['unit']) selected @endif>{{ $use['unit1'] }}</option> @endif
                                            @if($use['unit2']) <option value="{{ $use['unit2'] }}" @if($use['unit2'] == $value['unit']) selected @endif>{{ $use['unit2'] }}</option> @endif
                                            @if($use['unit3']) <option value="{{ $use['unit3'] }}" @if($use['unit3'] == $value['unit']) selected @endif>{{ $use['unit3'] }}</option> @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                <div class="input-group">
                                    <input type="text" class="form-control price" id="product_use_qty_ims_{{$key}}" name="product_icount_ims[{{$key}}][qty]" value="{{$value['qty']}}">
                                </div>
                            </div>
                            <div class="col-md-2" style="margin-left: 2%">
                                <a class="btn btn-danger btn" onclick="deleteProductServiceUse({{$key}},'ims')">&nbsp;<i class="fa fa-trash"></i></a>
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
            <input type="hidden" name="id_product" value="{{ $product[0]['id_product'] }}">
            <input type="hidden" name="product_code" value="{{ $product[0]['product_code'] }}">
            <a onclick="productServiceUseSubmit()" class="btn green">Submit</a>
        </div>
    </div>
</form>