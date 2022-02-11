<form class="form-horizontal" role="form" action="{{ url('product-academy/theory/save') }}" method="post">
  <div class="form-body">
      <div class="form-group">
          <div class="col-md-1"></div>
          <div class="col-md-4">
              <a class="btn btn-primary" onclick="addTheory()">&nbsp;<i class="fa fa-plus-circle"></i> Add Theory </a>
          </div>
      </div>
      <br>
      <div class="form-group">
          <div class="col-md-1"></div>
          <div class="col-md-8">
              <b>Title</b>
          </div>
      </div>
      <div id="div_theory">
          @if(empty($product_academy_theory))
              <div class="form-group" id="div_theory_0">
                  <div class="col-md-1"></div>
                  <div class="col-md-8">
                      <select class="form-control select2" style=" width: 100%" name="theory[0]" required>
                          <option value="" selected disabled>Select Theory</option>
                          @foreach($list_theory_category as $theory)
                              <option value="{{$theory['id_theory_category']}}">{{$theory['theory_category_name']}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-md-2">
                      <a class="btn btn-danger btn" onclick="deleteTheory({{$key}})">&nbsp;<i class="fa fa-trash"></i></a>
                  </div>
              </div>
          @else
              @foreach($product_academy_theory as $key=>$value)
                  <div class="form-group" id="div_theory_{{$key}}">
                      <div class="col-md-1"></div>
                      <div class="col-md-8">
                          <select class="form-control select2" style=" width: 100%" name="theory[{{$key}}]" required>
                              <option value="" selected disabled>Select Theory</option>
                              @foreach($list_theory_category as $theory)
                                  <option value="{{$theory['id_theory_category']}}" @if($value['id_theory_category'] == $theory['id_theory_category']) selected @endif>{{$theory['theory_category_name']}}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="col-md-2">
                          <a class="btn btn-danger btn" onclick="deleteTheory({{$key}})">&nbsp;<i class="fa fa-trash"></i></a>
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
          <button type="submit" class="btn green">Submit</button>
      </div>
  </div>
</form>