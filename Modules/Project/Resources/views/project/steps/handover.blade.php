<?php 
    $handover = false;
    $prog = false;
    $title = null;
    $note = null;
    $attachment = null;
    $next_handover = false;
    if($result['progres']=='Handover'){
        $handover = true;
    }
    if ($result['project_handover']!=null){
        $id_id_projects_handover = $result['project_handover']['id_projects_handover'];
        $title = $result['project_handover']['title'];
        $note = $result['project_handover']['note'];
        $attachment = $result['project_handover']['attachment'];
        $created_at = $result['project_handover']['updated_at'];
        if($result['project_handover']['status']=='Process'){
           $next_handover = true;
        }
    }
?>
<script>
     var SweetAlertDeleteHandover = function() {
            return {
                init: function() {
                    $(".sweetalert-handover-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        var data = {
                                    '_token' : '{{csrf_token()}}',
                                    'id_project':{{$result['id_project']}}
                                        };
                        $(this).click(function() {
                            swal({
                                    title: "Delete data handover?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, delete it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('project/delete/handover')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Data has been deleted.", "success")
                                               location.href = "{{url('project/detail')}}/"+{{$result['id_project']}}+"#handover";
                                                window.location.reload();
                                            }
                                            else if(response.status == "fail"){
                                              
                                                swal("Error!", "Failed to delete.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete .", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();
        var SweetAlertNextHandover = function() {
            return {
                init: function() {
                    $(".sweetalert-handover-next").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        var data = {
                            '_token' : '{{csrf_token()}}',
                            'id_project':{{$result['id_project']}}
                                        };
                        $(this).click(function() {
                            swal({
                                    title: "Project Success?",
                                    text: "Project Success!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, Next Step!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('project/next/handover')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Success!", "Next Step.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('project/detail')}}/"+{{$result['id_project']}};
                                                window.location.reload();

                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete .", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();
        jQuery(document).ready(function() {
            SweetAlertNextHandover.init()
            SweetAlertDeleteHandover.init()
        });
    </script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Handover</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div id="form_survey">
                       <form class="form-horizontal" role="form" action="{{url('project/create/handover')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_project" value="{{$result['id_project']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Title<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="title" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled @endif type="text" id="title" name="title" value="{{$title}} " required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note</label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" @if($result['status']!='Process' ) disabled @endif class="form-control" placeholder="Enter note here" >{{$note}}</textarea>
                                    </div>
                                </div>
                                @if($result['status']=='Process')
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment <br>
                                        <span aria-required="true"> (PDF max 2 mb) </span></label>
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
                                @endif
                                @if(@$attachment!=null)
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Link Download file<span  aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <br>
                                        <a target="_blank" target='blank' href="{{ $attachment }}"><i class="fa fa-download" style="font-size:48px"></i></a>
                                    </div>
                                </div>
                                @endif
                                @if ($handover==true&&$result['status']=='Process') 
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                            @if($next_handover==true)
                                            <a class="btn red sweetalert-handover-delete">Delete</a>
                                            <a class="btn green sweetalert-handover-next">Project Success</a>
                                            @endif
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