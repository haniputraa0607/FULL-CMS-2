<?php 
    $surv = false;
    $prog = false;
    $surveyor = null;
    $attachment_surv = null;
    $location_length = 0.01;
    $location_width = 0.01;
    $location_large = 0.01;
    $survey_date = null;
    $note = null;
    $next = false;
    $status = "Process";
    if($result['progres']=='Survey Location'){
        $surv = true;
    }
    if ($result['project_survey']!=null){
        $status = $result['project_survey']['status'];
        $surveyor = $result['project_survey']['surveyor'];
        $location_length = $result['project_survey']['location_length'];
        $location_width = $result['project_survey']['location_width'];
        $location_large = $result['project_survey']['location_large'];
        $survey_date = $result['project_survey']['survey_date'];
        $note = $result['project_survey']['note'];
        $attachment_surv = $result['project_survey']['attachment'];
        if($result['project_survey']['status']=='Process'){
           $next = true;
        }
        
    }
?>

<script>
        $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
    })
    
    var SweetAlertSubmitSurvey = function() {
            return {
               init: function() {
                    $(".sweetalert-survey-submit").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                      
                        $(this).click(function() {
                            swal({
                                    title: "Submit data?",
                                    text: "Check your data before submit!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, submit it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $('#survey_form').submit();
                                });
                        })
                    })
                }
            }
        }();
        jQuery(document).ready(function() {
            SweetAlertSubmitSurvey.init()
        });
    </script>
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
                    <div id="form_survey">
                        <form class="form-horizontal" id="survey_form" role="form" action="{{url('project/create/survey_location')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_project" value="{{$result['id_project']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Surveyor<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Surveyor" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled  @elseif($result['progres']!='Survey Location') disabled @endif type="text" id="surveyor" name="surveyor" value="{{$surveyor}}" placeholder="Surveyor" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Panjang Lokasi (m)<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Panjang Lokasi (m)" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif type='number' step='0.01'  id="location_length" name="location_length" value="{{$location_length}}" placeholder="Panjang Lokasi (m)" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Lebar Lokasi (m)<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Lebar Lokasi (m)" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif type='number' step='0.01' id="location_width" name="location_width" value="{{$location_width}}" placeholder="Lebar Lokasi (m)" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Luas Lokasi (m)<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Luas Lokasi (m)" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif type='number' step='0.01' id="location_large" value="{{$location_large}}" name="location_large" placeholder="Luas Lokasi (m)" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Tanggal Survey<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Survey" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="survey_date" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif class="datepicker form-control" name="survey_date" value="{{ (!empty($survey_date) ? date('d F Y', strtotime($survey_date)) : '')}}" >
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note</label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif placeholder="Enter note">{{$note}}</textarea>
                                    </div>
                                </div>
                                @if($result['status']=='Process'&&$status=="Process")
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment<br>
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
                                                            <input type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" class="file" id="import_file" name="import_file">
                                                        </span>
                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(@$attachment_surv!=null)
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Link Download file<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <br>
                                        <a target="_blank" target='blank' href="{{ $attachment_surv }}"><i class="fa fa-download" style="font-size:48px"></i></a>
                                    </div>
                                </div>
                                @endif
                                @if ($surv==true&&$result['status']=='Process') 
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <a class="btn blue sweetalert-survey-submit">Submit</a>
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