@yield('filter_commission')
<script>
    var noRule = 0;

    var static = false;
    
    function addRule(){
        var id_percent =  $("input[name='percent']:checked").val();
        var id_product     	=  $('#id_product').find(':selected').data('id');

        var percent = ``;
        if(id_percent == 'on'){
            percent = `max="100" min="1"`;
        }else{
            if(id_product != 0){
                percent = `max="${id_product}" min="1"`
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
                    
                </tbody>
            `;
            $('#dynamic-rule').append(table);
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
        var id_product     	=  $('#id_product').find(':selected').data('id');

        if(val == 'Dynamic'){
            $('#id_commission').hide();
            $('#dynamic_commission').show();
            $('#commission_percent').prop('required',false);
            $('#commission_percent').prop('disabled',true);
            static = false;
            
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
                    if(id_product != 0){
                        $(`tr[data-id=${i}] input.value`).attr({"max":id_product,"min":1})
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
            if(id_product != 0){
                if(id_percent == 'on'){
                    var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                    <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                    <div class="col-md-4">\
                    <input class="form-control" required type="number" id="commission_percent" name="commission_percent" min="1" max="100" placeholder="Enter Commission"/>\
                    </div></div>';
                }else{
                    var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                    <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                    <div class="col-md-4">\
                    <input class="form-control" required type="number" id="commission_percent" name="commission_percent" min="0" max="'+id_product+'" placeholder="Enter Commission"/>\
                    </div></div>'; 
                                
                }
            }else{
                if(id_percent == 'on'){
                    var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                    <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                    <div class="col-md-4">\
                    <input class="form-control" required type="number" id="commission_percent" name="commission_percent" min="1" max="100" placeholder="Enter Commission"/>\
                    </div></div>';
                }else{
                    var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                    <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                    <div class="col-md-4">\
                    <input class="form-control" required type="number" id="commission_percent" name="commission_percent" placeholder="Enter Commission"/>\
                    </div></div>'; 
                                
                }
            }
            for (let i = 0; i < noRule; i++) {
                    $(`tr[data-id=${i}] input.qty`).prop('required',false);
                    $(`tr[data-id=${i}] input.qty`).prop('disabled',true);
                    $(`tr[data-id=${i}] input.value`).prop('required',false);
                    $(`tr[data-id=${i}] input.value`).prop('disabled',true);
            }
            if(static==false){
                $('#id_commission').html(html);
                static = true;
            }
        }
    }

    function myFunction() {
        var id_percent     	=  $("input[name='percent']:checked").val();
        var id_product     	=  $('#id_product').find(':selected').data('id');
        
        var type = $('select[name=type] option:selected').val()
        if(type == 'Dynamic'){
            if(id_percent == 'on'){
                for (let i = 0; i < noRule; i++) {
                    $(`tr[data-id=${i}] input.value`).attr({"max":100,"min":1})
                }
            }else{
                if(id_product != 0){
                    for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] input.value`).attr({"max":id_product,"min":1})
                    }
                }else{
                    for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] input.value`).removeAttr("max");
                        $(`tr[data-id=${i}] input.value`).removeAttr("min");
                    }
                }  
            }
        }else{
            if(id_product != 0){
                if(id_percent == 'on'){
                    $('#commission_percent').attr({"max":100,"min":1});
                }else{
                    $('#commission_percent').attr({"max":id_product,"min":1});
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
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">List Commission</span>
                </div>
                     <a href="#form_commission" class="btn btn-sm blue " type="button"  style="float:right" data-toggle="tab" id="input-follow-up">
                         Create
                    </a>
                    <a href="#table_commission" class="btn btn-sm yellow active" type="button" style="float:right" data-toggle="tab" id="back-follow-up">
                        List
                    </a>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    
                    <div class="tab-pane active" id="table_commission">
                        <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                    <thead>
                                    <tr>
                                        <th class="text-nowrap text-center">Name Product</th>
                                        <th class="text-nowrap text-center">Percent</th>
                                        <th class="text-nowrap text-center">Commission</th>
                                        <th class="text-nowrap text-center">Action</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                            @if(!empty($commission['data']))
                                            @foreach($commission['data'] as $dt)
                                            <tr style="text-align: center" data-id="{{ $dt['id_hairstylist_group_commission'] }}">
                                                    <td>{{$dt['product_name']}}</td>
                                                    <td><input disabled  type="checkbox" class="make-switch brand_visibility" data-size="small" data-on-color="info" data-on-text="Percent" data-off-color="default" data-off-text="Nominal" value="1" {{$dt['percent']?'checked':''}}></td>
                                                    <td>
                                                        @if ($dt['dynamic']==1)
                                                            Dynamic
                                                        @else
                                                            @if($dt['percent']==0)
                                                                {{"Rp " . number_format($dt['commission_percent'],2,',','.')}} 
                                                            @else 
                                                                {{$dt['commission_percent']}} %  
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ url('/recruitment/hair-stylist/group/commission/detail/'.$dt['id_enkripsi']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"></i> Detail</a></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" style="text-align: center">Data Not Available</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="paginator-right">
                                @if ($commission['data_paginator'])
                                   {{ $commission['data_paginator']->links() }}
                               @endif  
                           </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="form_commission">
                        <form class="form-horizontal" role="form" action="{{url('recruitment/hair-stylist/group/commission/create')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_hairstylist_group" value="{{$result['id_hairstylist_group']}}">
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Product<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih produk yang akan diatur komisinya" data-container="body"></i>
                                    </label>
                                    <div class="col-md-6">
                                             <select required name="id_product" id="id_product"  onchange="myFunction()" class="select2" >
                                            <option value="" selected disabled></option></option>
                                            @if(isset($product))
                                                @foreach($product as $row)
                                                        <option value="{{$row['id_product']}}" data-id="{{$row['price']}}">{{$row['product_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Percent<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nilai komisi dalam bentuk nominal atau persentase" data-container="body"></i>
                                    </label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <input type="checkbox" class="make-switch" data-size="small" onchange="myFunction()" data-on-color="success" data-on-text="Percent" name="percent" data-off-color="default" data-off-text="Nominal" id="percent">
                                           </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Type<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tipe komisi statis atau dinamis" data-container="body"></i>
                                    </label>
                                    <div class="col-md-2">
                                        <select required name="type" id="type" class="select2" onchange="changeType(this.value)" >
                                            <option value="" selected disabled></option>
                                            <option value="Static" >Static</option>
                                            <option value="Dynamic" >Dynamic</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="id_commission">
                                </div>
                                <div id="dynamic_commission" hidden>
                                    <div class="form-group">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-5">
                                            <div>
                                                <button class="btn green" type="button" onclick="addRule()">Add Rule</button>
                                            </div>
                                            <table id="dynamic-rule" class="table text-center">
                                            </table>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>