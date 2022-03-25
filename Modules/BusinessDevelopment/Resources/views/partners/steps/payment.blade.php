<?php 
    $pay = false;
    if(!empty($result['partner_step'])){
        foreach($result['partner_step'] as $i => $step){
            if($step['follow_up']=='Payment'){
                $pay = true;
                $follow_up = $step['follow_up'];
                $note = $step['note'];
                $file = $step['attachment'];
            }
        }
    }
    $trans = false;
    if($result['status']=='Active'){
        if(date('Y-m-d') <= date('Y-m-d', strtotime($result['partner_locations'][0]['trans_date']))){
            $trans = true;
        }
    }
?>

<div style="white-space: nowrap;">
    <div class="tab-pane" id="step-follow-up">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Payment</span>
                </div>
                @if($result['status']=='Rejected')
                <a href="#reject_pay" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="pay-reject">
                    Back
                </a>
                @endif
            </div>
            <div class="portlet-body form">
                @if($result['status']=='Active')
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#form_pay" data-toggle="tab">Overview </a>
                    </li>
                    <li>
                        <a href="#init_branch" data-toggle="tab">Initiation Branch</a>
                    </li>
                </ul>
                @endif
                <div class="tab-content">
                    <div class="tab-pane @if($result['status']=='Rejected') active @endif" id="reject_pay">
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
                                @if($result['status_steps']=='Confirmation Letter' || $result['status_steps']=='Payment')
                                <a href="#form_pay" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-pay">
                                    Payment
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane @if($result['status']=='Candidate' || $pay == true) active @endif" id="form_pay">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Step yang sedang dilakukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow_up" name="follow_up" value="Payment" readonly required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">No SPK <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nomor Surat Perintah Kerja calon lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="no_spk" name="no_spk" placeholder="Enter total box here" value="@if (old('no_spk')) {{ old('no_spk') }} @else @if (!empty($result['partner_locations'][0]['no_spk'])) {{ $result['partner_locations'][0]['no_spk'] }} @endif @endif" required readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">SPK Date <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Surat Perintah Kerja  disetujui oleh kedua pihak" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="date_spk" class="datepicker form-control" name="date_spk" value="{{ (!empty($result['partner_locations'][0]['date_spk']) ? date('d F Y', strtotime($result['partner_locations'][0]['date_spk'])) : '')}}" required {{$pay ? 'disabled' : ''}}>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Due Date <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal jatuh tempo atau tanggal terakhir pembayaran partnershi fee" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="due_date" class="datepicker form-control" name="due_date" value="{{ (!empty($result['partner_locations'][0]['due_date']) ? date('d F Y', strtotime($result['partner_locations'][0]['due_date'])) : '')}}" required {{$pay ? 'disabled' : ''}}>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note
                                        <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk step in" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" @if ($pay==true) readonly @endif >@if ($pay==true) {{ $note }} @endif</textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="id_location" value="{{$result['partner_locations'][0]['id_location']??''}}">
                                <div class="form-group">
                                    @if ($pay==false) 
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Unggah file jika ada lampiran yang diperlukan" data-container="body"></i><br>
                                        <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                                        @else
                                    <label for="example-search-input" class="control-label col-md-4">Download Attachment 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file yang dilampirkan pada step ini" data-container="body"></i><br></label>
                                        @endif
                                    <div class="col-md-5">
                                        @if ($pay==false) 
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
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            @if ($pay==false) 
                                            <button type="submit" class="btn blue">Submit</button>
                                            @endif
                                            @if($result['status']=='Candidate')<a class="btn red sweetalert-reject" data-id="{{ $result['id_partner'] }}" data-name="{{ $result['name'] }}">Reject</a>@endif
                                            @if($result['status']=='Active')
                                            @if ($trans)
                                            <a class="btn red sweetalert-reject" data-id="{{ $result['id_partner'] }}" data-name="{{ $result['name'] }}">Reject</a>    
                                            <a class="btn red sweetalert-reject-icount" data-id="{{ $result['id_partner'] }}" data-name="{{ $result['name'] }}">Reject With Icount</a>    
                                            @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane" id="init_branch">
                    @if($result['status']=='Active')
                        @if ($result['partner_locations'][0]['location_init'])
                        <form class="form-horizontal" id="conract_form" role="form"  method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">ID Sales Order</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['id_sales_order']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">ID Sales Order Detail</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['id_sales_order_detail']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">ID Company</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['id_company']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">No Voucher</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['no_voucher']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Amount</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['amount']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tax</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['tax']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tax Value</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['tax_value']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Netto</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['netto']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">ID Item</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['id_item']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Quantity</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['qty']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Unit</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['unit']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Ratio</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['ratio']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Unit Ratio</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['unit_ratio']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Price</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['price']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Item Name</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['detail_name']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Discount</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['disc']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Discount Value</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['disc_value']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Discount Rp</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['disc_rp']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Outstanding</label>
                                    <div class="col-md-5">
                                        <input class="form-control" readonly type="text" value="{{$result['partner_locations'][0]['location_init']['outstanding']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Descriptiom</label>
                                    <div class="col-md-5">
                                        <textarea class="form-control" readonly>{{$result['partner_locations'][0]['location_init']['description']??''}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endif
                    @endif
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>