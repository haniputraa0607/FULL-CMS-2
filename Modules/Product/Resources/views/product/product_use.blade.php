<form class="form-horizontal" id="form-product-service" role="form" action="{{ url('product/product-use/update') }}" method="post">
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
              <b>Unit</b>
          </div>
          <div class="col-md-2">
              <b>Quantity</b>
          </div>
      </div>
      <div id="div_product_use">
          @if(empty($product_icount_use))
              <div id="div_product_use_0">
                  <div class="form-group">
                      <div class="col-md-1"></div>
                      <div class="col-md-5">
                          <select class="form-control select2" id="product_use_code_0" name="product_icount[0][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit(0,this.value)">
                              <option></option>
                              @foreach($product_uses as $product_use)
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
                      <div class="col-md-1">
                          <div class="input-group">
                              <input type="text" class="form-control price" id="product_use_qty_0" name="product_icount[0][qty]" required>
                          </div>
                      </div>
                      <div class="col-md-2" style="margin-left: 2%">
                          <a class="btn btn-danger btn" onclick="deleteProductServiceUse(0)">&nbsp;<i class="fa fa-trash"></i></a>
                      </div>
                  </div>
              </div>
          @else
              @foreach($product_icount_use as $key=>$value)
                  <div id="div_product_use_{{$key}}">
                      <div class="form-group">
                          <div class="col-md-1"></div>
                          <div class="col-md-5">
                              <select class="form-control select2" id="product_use_code_{{$key}}" name="product_icount[{{$key}}][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit({{$key}},this.value)">
                                  <option></option>
                                  @foreach($product_uses as $product_use)
                                      <option value="{{$product_use['id_product_icount']}}" @if($product_use['id_product_icount'] == $value['id_product_icount']) selected @endif>{{$product_use['code']}} - {{$product_use['name']}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-md-2">
                            <select class="form-control select2" id="product_use_unit_{{$key}}" name="product_icount[{{$key}}][unit]" required placeholder="Select unit" style="width: 100%">
                                <option></option>
                                @foreach($product_uses as $use)
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
                                  <input type="text" class="form-control price" id="product_use_qty_{{$key}}" name="product_icount[{{$key}}][qty]" required value="{{$value['qty']}}">
                              </div>
                          </div>
                          <div class="col-md-2" style="margin-left: 2%">
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
          <input type="hidden" name="id_product" value="{{ $product[0]['id_product'] }}">
          <input type="hidden" name="product_code" value="{{ $product[0]['product_code'] }}">
          <a onclick="productServiceUseSubmit()" class="btn green">Submit</a>
      </div>
  </div>
</form>