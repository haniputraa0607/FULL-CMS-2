<?php 
  $step = 1;
  if(!empty($result['partner_step'])){
    foreach($result['partner_step'] as $i => $step){
      $step = $i + 2; 
    }
  }
?>

<div style="white-space: nowrap;">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-yellow">Survey Location</span>
            </div>
        </div>
        <div class="portlet-body form">
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
                        <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukan note" data-container="body"></i></label>
                        <div class="col-md-5">
                            <textarea name="note" id="note" class="form-control" placeholder="Enter note here" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Import Attachment <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukan note" data-container="body"></i><br>
                            <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                        <div class="col-md-5">
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
                        </div>
                    </div>
                    <div class="form-actions">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-offset-4 col-md-8">
                                <button type="submit" class="btn blue">Submit</button>
                                <a class="btn red">Reject</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>