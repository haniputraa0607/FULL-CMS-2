<?php 
    $calcu = false;
    $this_location = [];

    if($result['partner_new_step'])
    {
        $id_this_location = null;
        foreach($result['partner_new_step'] as $key => $new_steps){
            if($new_steps['follow_up'] == 'Calculation' && $new_steps['index'] == $index_step){
                $follow_up = $new_steps['follow_up'];
                $note = $new_steps['note'];
                $file = $new_steps['attachment'];
                $file_span = $new_steps['file'];
                $id_this_location = $new_steps['id_location'];
            }elseif($new_steps['index'] == $index_step){
                $id_this_location = $new_steps['id_location'];
            }

            if($new_steps['follow_up'] == 'Payment' && $new_steps['index'] == $index_step){
                $select = true;
            }
        }
        if($result['partner_locations']){
            foreach($result['partner_locations'] as $key => $loc){
                if($loc['id_location'] == $id_this_location){
                    $this_location = $loc;
                }
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
                    <div class="tab-pane active" id="form_pay">
                        @php $total_payment = 0 @endphp
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th colspan="3">Fees</th>
                                </tr>
                                @if (isset($this_location['renovation_cost']))
                                <tr>
                                    <td>Contractor Price</td>
                                    <td></td>
                                    <td>{{number_format($this_location['renovation_cost'], 0, ',', '.')}}</td>
                                    @php $total_payment += $this_location['renovation_cost'] @endphp
                                </tr>
                                @endif
                                @if (isset($this_location['partnership_fee']))
                                <tr>
                                    <td>Partnership Fee</td>
                                    <td></td>
                                    <td>{{number_format($this_location['partnership_fee'], 0, ',', '.')}}</td>
                                    @php $total_payment += $this_location['partnership_fee'] @endphp
                                </tr>
                                @endif
                                <tr>
                                    <th colspan="3">Rent</th>
                                </tr>
                                @if (isset($this_location['location_large']))
                                <tr>
                                    <td>Location Large</td>
                                    <td></td>
                                    <td>{{number_format($this_location['location_large'], 0, ',', '.')}}</td>
                                </tr>
                                @endif
                                @if (isset($this_location['rental_price']))
                                <tr>
                                    <td>Rental Price</td>
                                    <td></td>
                                    <td>{{number_format($this_location['rental_price'], 0, ',', '.')}}</td>
                                    @php $total_payment += $this_location['rental_price'] @endphp
                                </tr>
                                @endif
                                @if (isset($this_location['service_charge']))
                                <tr>
                                    <td>Service Charge</td>
                                    <td></td>
                                    <td>{{number_format($this_location['service_charge'], 0, ',', '.')}}</td>
                                </tr>
                                @endif
                                @if (isset($this_location['promotion_levy']))
                                <tr>
                                    <td>Promotion Levy</td>
                                    <td></td>
                                    <td>{{number_format($this_location['promotion_levy'], 0, ',', '.')}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th colspan="3">Sale</th>
                                </tr>
                                @if (isset($this_location['income']))
                                <tr>
                                    <td>Income</td>
                                    <td></td>
                                    <td>{{number_format($this_location['income'], 0, ',', '.')}}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/new-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                                <input type="hidden" name="index" value="{{$index_step}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Step yang sedang dilakukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow_up" name="follow_up" value="Calculation" readonly required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Total Payment <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah yang harus dibayarkan partner untuk menenuhi product persiapan outlet" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control numberonly" type="text" data-type="currency" id="total_payment" name="total_payment" placeholder="Enter total payment here" value="@if(isset($this_location['total_payment'])) {{ number_format($this_location['total_payment']) }} @else {{ number_format($total_payment) }} @endif" required {{$calcu ? 'disabled' : ''}}/>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note
                                        <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk step in" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" @if ($calcu==true) readonly @endif >@if ($calcu==true) {{ $note }} @endif</textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="id_location" value="{{$this_location['id_location']??''}}">
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
                                                    <span class="fileinput-filename"> @if (isset($file_span)) {{ $file_span }} @endif</span>
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