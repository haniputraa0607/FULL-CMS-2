<?php 
    $calcu = false;
    if(!empty($result['step'])){
        foreach($result['step'] as $i => $step){
            if($step['follow_up']=='Calculation'){
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
                                <a href="#form_calcu" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-calcu">
                                    Calculation
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane @if($result['status']=='Process' || $calcu == true) active @endif" id="form_calcu">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/outlet/close/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_outlet_close_temporary" value="{{$result['id_outlet_close_temporary']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih step" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow_up" name="follow_up" value="Calculation" readonly required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan note" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" @if ($calcu==true) readonly @endif >@if ($calcu==true) {{ $note }} @endif</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    @if ($calcu==false) 
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan file" data-container="body"></i><br>
                                        <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                                        @else
                                    <label for="example-search-input" class="control-label col-md-4">Download Attachment 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file" data-container="body"></i><br></label>
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
                                            <a href="{{ env('STORAGE_URL_API').$file }}">Link Download Attachment</a>
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
                                            <a class="btn red sweetalert-reject" data-id="{{ $result['id_outlet_close_temporary'] }}">Reject</a>
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