<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
<form role="form" class="form-horizontal" action="{{url('product/submitCommission')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
                                        <input type="hidden" name='product_code' id="product_code" value='{{$product_code}}'>
                                                    
					<div class="form-body">
                                                <div class="form-group">
                                                    <label for="example-search-input" class="control-label col-md-4">Percent</label>
                                                    <div class="col-md-5">
                                                        <input type="checkbox" class="make-switch" data-size="small" onchange="myFunction()" data-on-color="success" data-on-text="Percent" name="percent" data-off-color="default" data-off-text="Nominal" {{$commission['percent']??0?'checked':''}} id="percent">
                                                    </div>
                                                </div>
                                               
                                                <div id="id_commission">
                                                     <div class="form-group">
                                                    <label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Percent minimal 1% maksimal 99%" data-container="body"></i></label>
                                                    <div class="col-md-5">
                                                        <input class="form-control" required type="number" id="commission" value="{{$commission['commission']??0}}" @if($commission['percent']??'' == 1) min="1" max="99" @elseif(isset($product[0]['global_price'][0]['product_global_price'])) max='{{$product[0]['global_price'][0]['product_global_price']}}' @endif name="commission" placeholder="Enter Commission"/>
                                                    </div>
                                                </div>
                                                </div>
					</div>
                                        
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Update</button>
					</div>
				</form>

        <script type="text/javascript">
        function myFunction() {
          var id_percent     	=  $("input[name='percent']:checked").val();
          var global_price      =   {{$product[0]['global_price'][0]['product_global_price']??0}}
          if(global_price > 0){
              if(id_percent == 'on'){
                 var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                         <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                        <div class="col-md-6">\
                          <input class="form-control" required type="number" id="commission" name="commission" value"<?= $commission["commission"]??0 ?>"  min="1" max="99" placeholder="Enter Commission Percent"/>\
                        </div></div>';
              }else{
                 var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                         <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                        <div class="col-md-6">\
                          <input class="form-control" required type="number" id="commission" name="commission" max="{{$product[0]['global_price'][0]['product_global_price']??0}}" value"<?= $commission["commission"]??0 ?>" placeholder="Enter Commission Nominal"/>\
                        </div></div>'; 

              }
          }else{
              if(id_percent == 'on'){
                 var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                         <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                        <div class="col-md-6">\
                          <input class="form-control" required type="number" id="commission" name="commission" value"<?= $commission["commission"]??0 ?>"  min="1" max="99" placeholder="Enter Commission Percent"/>\
                        </div></div>';
              }else{
                 var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                         <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                        <div class="col-md-6">\
                          <input class="form-control" required type="number" id="commission" name="commission" value"<?= $commission["commission"]??0 ?>" placeholder="Enter Commission Nominal"/>\
                        </div></div>'; 

              }
          }
          $('#id_commission').html(html);
        }
        </script>