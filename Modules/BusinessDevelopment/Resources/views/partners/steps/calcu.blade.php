<?php 
    $calcu = false;
    if(!empty($result['partner_step'])){
        foreach($result['partner_step'] as $i => $step){
            if($step['follow_up']=='Payment'){
                $calcu = true;
                $follow_up = $step['follow_up'];
                $note = $step['note'];
                $file = $step['attachment'];
            }
        }
    }
?>

<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Calculation</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane @if($result['status']=='Rejected') active @endif">
                        <div class="portlet box red">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gear"></i>Warning</div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <p>Candidate Partner Rejected </p>
                                @if ($calcu==false)
                                <a href="#form_pay" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-pay">
                                    Calculation
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane @if($result['status']=='Candidate' || $calcu == true) active @endif" id="form_pay">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Step yang sedang dilakukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow_up" name="follow_up" value="Calculation" readonly required/>
                                    </div>
                                </div>
                                <div class="portlet light" style="margin-bottom: 0; padding-bottom: 0">
                                    <div class="portlet-body form">
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <b>Product</b>
                                            </div>
                                            <div class="col-md-2">
                                                <b>Unit</b>
                                            </div>
                                            <div class="col-md-2">
                                                <b>Quantity</b>
                                            </div>
                                            <div class="col-md-2">
                                                <b>Cost</b>
                                            </div>
                                        </div>
                                        <div id="div_product_use">
                                            @php $total_cost = 0; @endphp
                                            @foreach($starter_products as $key=>$value)
                                            <div id="div_product_use_{{$key}}">
                                                <div class="form-group">
                                                    <input class="form-control" name="product_starter[{{$key}}][budget_code]" type="hidden" value="{{ $value['budget_code'] }}" required readonly/>
                                                    <div class="col-md-4">
                                                        <select class="form-control select2" id="product_use_code_{{$key}}" name="product_starter[{{$key}}][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit({{$key}},this.value)">
                                                            <option></option>
                                                            @foreach($products as $product_use)
                                                                <option value="{{$product_use['id_product_icount']}}" @if($product_use['id_product_icount'] == $value['id_product_icount']) selected @endif>{{$product_use['code']}} - {{$product_use['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                        {{--  @else
                                                        @foreach($products as $product_use)
                                                            @if($product_use['id_product_icount'] == $value['id_product_icount']) 
                                                                <input class="form-control" type="text" value="{{$product_use['code']}} - {{$product_use['name']}}" required placeholder="Select product use" style="width: 100%" readonly/>
                                                            @endif
                                                        @endforeach
                                                        <input class="form-control" type="hidden" id="product_use_code_{{$key}}" value="{{$value['id_product_icount']}}" name="product_icount[{{$key}}][id_product_icount]" required placeholder="Select product use" style="width: 100%" readonly/>
                                                        @endif  --}}
                                                    </div>
                                                    <div class="col-md-2">
                                                        {{--  @if(MyHelper::hasAccess([413], $grantedFeature))  --}}
                                                        <select class="form-control select2" id="product_use_unit_{{$key}}" name="product_starter[{{$key}}][unit]" required placeholder="Select unit" style="width: 100%">
                                                            <option></option>
                                                            @foreach($products as $use)
                                                                @if ($use['id_product_icount'] == $value['id_product_icount'])
                                                                    @if($use['unit1']) <option value="{{ $use['unit1'] }}" @if($use['unit1'] == $value['unit']) selected @endif>{{ $use['unit1'] }}</option> @endif
                                                                    @if($use['unit2']) <option value="{{ $use['unit2'] }}" @if($use['unit2'] == $value['unit']) selected @endif>{{ $use['unit2'] }}</option> @endif
                                                                    @if($use['unit3']) <option value="{{ $use['unit3'] }}" @if($use['unit3'] == $value['unit']) selected @endif>{{ $use['unit3'] }}</option> @endif
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        {{--  @else
                                                        <input class="form-control" type="text" id="product_use_unit_{{$key}}" value="{{$value['unit']}}" name="product_icount[{{$key}}][unit]" required placeholder="Select unit" style="width: 100%" readonly/>
                                                        @endif  --}}
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control price" id="product_use_qty_{{$key}}" name="product_starter[{{$key}}][qty]" required value="{{$value['qty']}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control price" id="product_use_cost_{{$key}}" required value="{{number_format($value['cost'])}}">
                                                        </div>
                                                    </div>
                                                    @php $total_cost = $total_cost + $value['cost']; @endphp
                                                    {{--  <div class="col-md-2">
                                                        @if(MyHelper::hasAccess([415], $grantedFeature))
                                                        <select class="form-control select2" id="product_use_status_{{$key}}" name="product_icount[{{$key}}][status]" required placeholder="Select product status" style="width: 100%">
                                                            <option></option>
                                                            <option value="Pending" @if($value['status']=='Pending') selected @endif>Pending</option>
                                                            <option value="Approved" @if($value['status']=='Approved') selected @endif>Approved</option>
                                                            <option value="Rejected" @if($value['status']=='Rejected') selected @endif>Rejected</option>
                                                        </select>
                                                        @else
                                                        <input class="form-control" type="text" id="product_use_status_{{$key}}" value="{{$value['status']}}" name="product_icount[{{$key}}][status]" required placeholder="Select product status" style="width: 100%" readonly/>
                                                        @endif
                                                    </div>  --}}
                                                    {{--  <div class="col-md-1" style="margin-left: 2%">
                                                        <a class="btn btn-danger btn" onclick="deleteProductServiceUse({{$key}})">&nbsp;<i class="fa fa-trash"></i></a>
                                                    </div>  --}}
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                        {{--  @if ($result['status']=='Pending' && MyHelper::hasAccess([413], $grantedFeature))  --}}
                                        {{--  <div class="form-group">
                                            <div class="col-md-4">
                                                <a class="btn btn-primary" onclick="addProductServiceUse()">&nbsp;<i class="fa fa-plus-circle"></i> Add Product </a>
                                            </div>
                                        </div>  --}}
                                        {{--  @endif  --}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Total Payment <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah yang harus dibayarkan partner untuk menenuhi product persiapan outlet" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="total_payment" name="total_payment" placeholder="Enter total payment here" value="{{ number_format($total_cost) }}" required/>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk step in" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" @if ($calcu==true) readonly @endif >@if ($calcu==true) {{ $note }} @endif</textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="id_location" value="{{$result['partner_locations'][0]['id_location']??''}}">
                                <div class="form-group">
                                    @if ($calcu==false) 
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Unggah file jika ada lampiran yang diperlukan" data-container="body"></i><br>
                                        <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                                        @else
                                    <label for="example-search-input" class="control-label col-md-4">Download Attachment 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file yang dilampirkan pada step ini" data-container="body"></i><br></label>
                                        @endif
                                    <div class="col-md-5">
                                        @if ($calcu==false) 
                                        <div class="fileinput fileinput-new text-left" data-provides="fileinput">
                                            <div class="input-group input-large">
                                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                    <span class="fileinput-filename"> </span>
                                                </div>
                                                <span class="input-group-addon btn default btn-file">
                                                            <span class="fileinput-new"> Select file </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" class="file" name="import_file">
                                                        </span>
                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                        @else
                                        <label for="example-search-input" class="control-label col-md-4">
                                            @if(isset($file))
                                            <a href="{{ $file }}">Link Download Attachment</a>
                                            @else
                                            No Attachment
                                            @endif
                                        <label>
                                        @endif
                                    </div>
                                </div>
                                @if ($calcu==false) 
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                            <a class="btn red sweetalert-reject" data-id="{{ $result['id_partner'] }}" data-name="{{ $result['name'] }}">Reject</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>