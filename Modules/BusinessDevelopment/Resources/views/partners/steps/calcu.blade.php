<?php 
    $calcu = false;
    if(!empty($result['partner_step'])){
        foreach($result['partner_step'] as $i => $step){
            if($step['follow_up']=='Calculation'){
                $follow_up = $step['follow_up'];
                $note = $step['note'];
                $file = $step['attachment'];
                $file_span = $step['file'];
            }
            if($step['follow_up']=='Payment'){
                $calcu = true;
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
                @if($result['status']=='Rejected')
                <a href="#reject_calcu" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="calcu-reject">
                    Back
                </a>
                @endif
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane @if($result['status']=='Rejected') active @endif" id="reject_calcu">
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
                                @if($result['status_steps']=='Select Location')
                                <a href="#form_calcu" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-calcu">
                                    Calculation
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane @if($result['status']=='Candidate' || $calcu == true) active @endif" id="form_calcu">
                        @php $total_payment = 0 @endphp
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th colspan="3">Fees</th>
                                </tr>
                                <tr>
                                    <td>Contractor Price</td>
                                    <td></td>
                                    <td>{{number_format($result['first_location']['renovation_cost']??0, 0, ',', '.')}}</td>
                                    @php $total_payment += $result['first_location']['renovation_cost']??0 @endphp
                                </tr>
                                <tr>
                                    <td>Partnership Fee</td>
                                    <td></td>
                                    <td>{{number_format($result['first_location']['partnership_fee']??0, 0, ',', '.')}}</td>
                                    @php $total_payment += $result['first_location']['partnership_fee']??0 @endphp
                                </tr>
                                <tr>
                                    <th colspan="3">Rent</th>
                                </tr>
                                <tr>
                                    <td>Location Large</td>
                                    <td></td>
                                    <td>{{number_format($result['first_location']['location_large']??0, 0, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td>Rental Price</td>
                                    <td></td>
                                    <td>{{number_format($result['first_location']['rental_price']??0, 0, ',', '.')}}</td>
                                    @php $total_payment += $result['first_location']['rental_price']??0 @endphp
                                </tr>
                                <tr>
                                    <td>Service Charge</td>
                                    <td></td>
                                    <td>{{number_format($result['first_location']['service_charge']??0, 0, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td>Promotion Levy</td>
                                    <td></td>
                                    <td>{{number_format($result['first_location']['promotion_levy']??0, 0, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <th colspan="3">Sale</th>
                                </tr>
                                <tr>
                                    <td>Income</td>
                                    <td></td>
                                    <td>{{number_format($result['first_location']['income']??0, 0, ',', '.')}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_partner" value="{{$result['id_partner']??null}}">
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
                                            <input class="form-control numberonly" type="text" data-type="currency" id="total_payment" name="total_payment" placeholder="Enter total payment here" value="{{ number_format($result['first_location']['total_payment'] ?: $total_payment) }}" required {{$calcu ? 'disabled' : ''}}/>
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
                                            @if($result['status']=='Candidate')<a class="btn red sweetalert-reject" data-id="{{ $result['id_partner'] }}" data-name="{{ $result['name'] }}">Reject</a>@endif
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