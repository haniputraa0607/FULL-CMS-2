<?php 
    $pay = false;
    $pays = false;
    if($result['status']!='Process'){
        $pays = true;
    }
    if(!empty($result['steps'])){
        foreach($result['steps'] as $i => $step){
            if($step['follow_up']=='Payment'){
                $pay = true;
                $follow_up = $step['follow_up'];
                $note = $step['note'];
                $file = $step['attachment'];
            }
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
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane @if($partner['status']=='Reject') active @endif">
                        <div class="portlet box red">
                            <div class="portlet-title">
                                <div class="caption">
                                   <i class="fa fa-gear"></i>Change Location Rejected</div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane @if($result['status']=='Process' || $pay == true) active @endif"" id="form_pay">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/outlet/change_location/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_partner" value="{{$partner['id_partner']}}">
                                <input type="hidden" name="id_outlet_change_location" value="{{$id_outlet_change_location}}">
                                <input type="hidden" name="to_id_location" value="{{$result['to_id_location']??''}}">
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
                                        <input class="form-control" type="text" id="no_spk" name="no_spk" placeholder="Enter total box here" value="@if (old('no_spk')) {{ old('no_spk') }} @else @if (!empty($this_location['no_spk'])) {{ $this_location['no_spk'] }} @endif @endif" required {{$pay ? 'disabled' : ''}}/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">SPK Date <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Surat Perintah Kerja  disetujui oleh kedua pihak" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="date_spk" class="datepicker form-control" name="date_spk" value="{{ (!empty($this_location['date_spk']) ? date('d F Y', strtotime($this_location['date_spk'])) : date('d F Y'))}}" required {{$pay ? 'disabled' : ''}}>
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
                                            <input type="text" id="due_date" class="datepicker form-control" name="due_date" value="{{ (!empty($this_location['due_date']) ? date('d F Y', strtotime($this_location['due_date'])) : date('d F Y'))}}" required {{$pay ? 'disabled' : ''}}>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk step in" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" @if ($pay==true) readonly @endif >@if ($pay==true) {{ $note }} @endif</textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="to_id_location" value="{{$result['to_id_location']??''}}">
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
                                @if ($pays==false) 
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                            <a class="btn red sweetalert-reject" data-id="{{ $result['id_outlet_change_location'] }}">Reject</a>
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