<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>

<form role="form" class="form-horizontal" action="{{url('product/submitCommission')}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name='product_code' id="product_code" value='{{$product_code}}'>
    <div class="form-body">
        <div class="form-group">
            <label for="example-search-input" class="control-label col-md-5">Percent</label>
            <div class="col-md-5">
                <input type="checkbox" class="make-switch" data-size="small" onchange="myFunction()" data-on-color="success" data-on-text="Percent" name="percent" data-off-color="default" data-off-text="Nominal" {{$commission['percent']??0?'checked':''}} id="percent">
            </div>
        </div>
        <div class="form-group">
            <label for="example-search-input" class="control-label col-md-5">Type</label>
            <div class="col-md-3">
                <select required name="type" id="type" class="select2" onchange="changeType(this.value)">
                    <option value="" selected disabled></option>
                    <option value="Static" @if (isset($commission['dynamic'])) @if($commission['dynamic']==0) selected @endif @endif>Static</option>
                    <option value="Dynamic" @if (isset($commission['dynamic'])) @if($commission['dynamic']==1) selected @endif @endif>Dynamic</option>
                </select>
            </div>
        </div>
       
        <div id="id_commission" @if (isset($commission['dynamic'])) @if($commission['dynamic']==1) hidden @endif @endif>
             <div class="form-group">
                <label for="example-search-input" class="control-label col-md-5">Commission</label>
                <div class="col-md-3">
                    <input class="form-control" @if (isset($commission['dynamic'])) @if($commission['dynamic']==0) required @else disabled @endif @endif type="number" id="commission_percent" value="{{$commission['commission']??0}}" @if($commission['percent']??'' == 1) min="1" max="100" @elseif(isset($product[0]['global_price'][0]['product_global_price'])) max='{{$product[0]['global_price'][0]['product_global_price']}}' @endif name="commission" placeholder="Enter Commission"/>
                </div>
            </div>
        </div>
        <div id="dynamic_commission" @if (isset($commission['dynamic'])) @if($commission['dynamic']==0) hidden @endif @else hidden @endif>
            <div class="form-group">
                <div class="col-md-4"></div>
                <div class="col-md-5">
                        @if (isset($commission['dynamic_rule_list']) && !empty($commission['dynamic_rule_list']))
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Range</th>
                                        <th class="text-center">Commision</th>  
                                        <th class="text-center">Delete</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commission['dynamic_rule_list'] ?? [] as $key => $dynamic)
                                        <tr>
                                            <td class="text-center">{{ $dynamic['qty'] }}</td>
                                            <td class="text-center">{{ $dynamic['value'] }}</td>
                                            <td class="text-center">
                                                @if (isset($dynamic['id_product_commission_default_dynamic']))
                                                    <a class="btn btn-sm red btn-primary" href="{{url()->current().'/delete-commission/'.$dynamic['id_product_commission_default_dynamic']}}"><i class="fa fa-trash-o"></i> Delete</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    <div>
                        <button class="btn green" type="button" onclick="addRule()">Add Rule</button>
                    </div>
                    <table id="dynamic-rule" class="table text-center">
                    </table>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
                        
    <div class="form-actions" style="text-align:center;">
        {{ csrf_field() }}
        <button type="submit" class="btn blue" id="checkBtn">Update</button>
    </div>
</form>
        
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    var global_price = {{$product[0]['global_price'][0]['product_global_price']??0}};
    var noRule = 0;
    var static = false;

    function addRule(){
        var id_percent =  $("input[name='percent']:checked").val();

        var percent = ``;
        if(id_percent == 'on'){
            percent = `max="100" min="1"`;
        }else{
            if(global_price > 0){
                percent = `max="${global_price}" min="1"`
            }
        }
        
        if(noRule==0){
            var table = `
                <thead>
                    <tr>
                        <th class="text-center col-md-2">Range</th>
                        <th class="text-center col-md-2">Commision</th>
                        <th class="text-center col-md-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($commission['dynamic_rule']) && !empty($commission['dynamic_rule']))
                        @foreach($commission['dynamic_rule'] ?? [] as $key => $dynamic)
                            <tr data-id="{{$key}}">
                                <td>
                                    <input type="number" class="form-control qty" name="dynamic_rule[{{$key}}][qty]" value="{{$dynamic['qty']}}" min="1" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control value" name="dynamic_rule[{{$key}}][value]" value="{{$dynamic['value']}}" @if ($commission['percent']==1) min="1" max="100" @else @if ($product[0]['global_price'][0]['product_global_price']>0) min="1" max="{{ $product[0]['global_price'][0]['product_global_price'] }}" @endif @endif required>
                                </td>
                                <td>
                                    <button type="button" onclick="deleteRule({{$key}})" data-toggle="confirmation" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            `;
            $('#dynamic-rule').append(table);
            noRule = {{ count($commission['dynamic_rule']??[]) }}

        }

        const template = `
            <tr data-id="${noRule}">
                <td>
                    <input type="number" class="form-control qty" name="dynamic_rule[${noRule}][qty]" min="1" required>
                </td>
                <td>
                    <input type="number" class="form-control value" name="dynamic_rule[${noRule}][value]" ${percent} required>
                </td>
                <td>
                    <button type="button" onclick="deleteRule(${noRule})" data-toggle="confirmation" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                </td>
            </tr>
        `;
        $('#dynamic-rule tbody').append(template);
        $(`tr[data-id=${noRule}] select`).select2();
        noRule++;
    }

    function deleteRule(id) {
        $(`#dynamic-rule tr[data-id=${id}]`).remove();
    }

    function changeType(val){
        var id_percent =  $("input[name='percent']:checked").val();

        if(val == 'Dynamic'){
            $('#id_commission').hide();
            $('#dynamic_commission').show();
            $('#commission_percent').prop('required',false);
            $('#commission_percent').prop('disabled',true);

            if(id_percent == 'on'){
                for (let i = 0; i < noRule; i++) {
                    $(`tr[data-id=${i}] input.qty`).prop('required',true);
                    $(`tr[data-id=${i}] input.qty`).prop('disabled',false);
                    $(`tr[data-id=${i}] input.value`).prop('required',true);
                    $(`tr[data-id=${i}] input.value`).prop('disabled',false);
                    $(`tr[data-id=${i}] input.value`).attr({"max":100,"min":1})
                }
            }else{
                for (let i = 0; i < noRule; i++) {
                    $(`tr[data-id=${i}] input.qty`).prop('required',true);
                    $(`tr[data-id=${i}] input.qty`).prop('disabled',false);
                    $(`tr[data-id=${i}] input.value`).prop('required',true);
                    $(`tr[data-id=${i}] input.value`).prop('disabled',false);
                    if(global_price > 0){
                        $(`tr[data-id=${i}] input.value`).attr({"max":global_price,"min":1})
                    }else{
                        $(`tr[data-id=${i}] input.value`).removeAttr("max");
                        $(`tr[data-id=${i}] input.value`).removeAttr("min");
                    }
                }
            }

        }else{
            $('#id_commission').show();
            $('#dynamic_commission').hide();
            $('#commission_percent').prop('required',true);
            $('#commission_percent').prop('disabled',false);
            if(global_price > 0){
                if(id_percent == 'on'){
                    var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-5">Commission</label>\
                        <div class="col-md-3">\
                        <input class="form-control" required type="number" id="commission_percent" name="commission" value"<?= $commission["commission"]??0 ?>"  min="1" max="100" placeholder="Enter Commission"/>\
                        </div></div>';
                }else{
                    var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-5">Commission</label>\
                        <div class="col-md-3">\
                        <input class="form-control" required type="number" id="commission_percent" name="commission" max="{{$product[0]['global_price'][0]['product_global_price']??0}}" value"<?= $commission["commission"]??0 ?>" placeholder="Enter Commission"/>\
                        </div></div>'; 
                }
            }else{
                if(id_percent == 'on'){
                   var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-5">Commission</label>\
                        <div class="col-md-3">\
                        <input class="form-control" required type="number" id="commission_percent" name="commission" value"<?= $commission["commission"]??0 ?>"  min="1" max="100" placeholder="Enter Commission"/>\
                        </div></div>';
                }else{
                   var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-5">Commission</label>\
                        <div class="col-md-3">\
                        <input class="form-control" required type="number" id="commission_percent" name="commission" value"<?= $commission["commission"]??0 ?>" placeholder="Enter Commission"/>\
                        </div></div>'; 
                }
            }
            for (let i = 0; i < noRule; i++) {
                    $(`tr[data-id=${i}] input.qty`).prop('required',false);
                    $(`tr[data-id=${i}] input.qty`).prop('disabled',true);
                    $(`tr[data-id=${i}] input.value`).prop('required',false);
                    $(`tr[data-id=${i}] input.value`).prop('disabled',true);
            }
            $('#id_commission').html(html);
        }
    }

    function myFunction() {
        var id_percent = $("input[name='percent']:checked").val();
        var type = $('select[name=type] option:selected').val();

        if(type == 'Dynamic'){
            if(id_percent == 'on'){
                for (let i = 0; i < noRule; i++) {
                    $(`tr[data-id=${i}] input.value`).attr({"max":100,"min":1})
                }
            }else{
                if(global_price > 0){
                    for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] input.value`).attr({"max":global_price,"min":1})
                    }
                }else{
                    for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] input.value`).removeAttr("max");
                        $(`tr[data-id=${i}] input.value`).removeAttr("min");
                    }
                }  
            }
        }else{
            if(global_price > 0){
                if(id_percent == 'on'){
                    $('#commission_percent').attr({"max":100,"min":1});
                }else{
                    $('#commission_percent').attr({"max":global_price,"min":1});
                }
            }else{
                if(id_percent == 'on'){
                    $('#commission_percent').attr({"max":100,"min":1});
                }else{
                    $('#commission_percent').removeAttr("max");
                    $('#commission_percent').removeAttr("min");
                }
            }
        }
    }
</script>
        
