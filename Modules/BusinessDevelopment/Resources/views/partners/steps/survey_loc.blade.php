<?php 
    $surv = false;
    if(!empty($result['partner_step'])){
        foreach($result['partner_step'] as $i => $step){
            if($step['follow_up']=='Survey Location'){
                $surv = true;
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
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Survey Location</span>
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
                                @if ($surv==false)
                                <a href="#form_survey" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-survey">
                                    Survey Location
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane @if($result['status']=='Candidate' || $surv == true) active @endif" id="form_survey">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih step" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow_up" name="follow_up" value="Survey Location" readonly required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Survey Potential
                                        <i class="fa fa-question-circle tooltips" data-original-title="Survey Potential. OK/NOT OK" data-container="body"></i>
                                    </label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            @if ($surv==true)
                                            <input class="form-control" type="text" id="follow_up" name="survey_potential" @if ($surv==true) readonly value="{{$result['partner_survey'][0]['potential']}}" @endif required/>
                                            @else    
                                            <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" name="survey_potential" data-off-color="default" data-off-text="NOT OK" id="potential">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Payment Note <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan catatan tentang pembayaran" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea style="height: 80px" name="surye_note" id="surye_note" class="form-control" placeholder="Enter survey note here" @if ($surv==true) readonly @endif>@if ($surv==true) {{$result['partner_survey'][0]['note']}} @endif</textarea>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan note" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="noteSurvey" class="form-control" placeholder="Enter note here" @if ($surv==true) readonly @endif >@if ($surv==true) {{ $note }} @endif</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    @if ($surv==true) 
                                    <label for="example-search-input" class="control-label col-md-4">Download Attachment
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file" data-container="body"></i><br></label>
                                        @endif
                                    <div class="col-md-5">
                                        @if ($surv==true) 
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
                                @if ($surv==true)
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">File Form Survey <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file" data-container="body"></i><br></label>
                                    <div class="col-md-5">
                                        <label for="example-search-input" class="control-label col-md-4">
                                            <a href="{{ $result['partner_survey'][0]['attachment'] }}">Download Form Survey</a>
                                        <label>
                                    </div>
                                </div>    
                                @endif
                                @if ($surv==false) 
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="button" class="btn blue" data-toggle="modal" data-target="#formSurvey" id="modalSurvey">Form Survey</button>
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