<?php 
    $contract = false;
    $prog = false;
    $first_party = null;
    $second_party = null;
    $nominal = 0;
    $note = null;
    $attachment = null;
    $next_contract = false;
    if($result['progres']=='Contract'){
        $contract = true;
    }
    if ($result['project_contract']!=null){
        $id_projects_contract = $result['project_contract']['id_projects_contract'];
        $first_party = $result['project_contract']['first_party'];
        $second_party = $result['project_contract']['second_party'];
        $nominal = $result['project_contract']['nominal'];
        $note = $result['project_contract']['note'];
        $attachment = $result['project_contract']['attachment'];
        $created_at = $result['project_contract']['updated_at'];
        if($result['project_contract']['status']=='Process'){
           $next_contract = true;
        }
        
    }
?>
<script>
    var SweetAlertDeleteContract = function() {
            return {
                init: function() {
                    $(".sweetalert-contract-delete").each(function() {
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
                                    title: "Delete data?",
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
                                        url : "{{url('project/delete/contract')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Data has been deleted.", "success")
                                               location.href = "{{url('project/detail')}}/"+{{$result['id_project']}}+"#contract";
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
        var SweetAlertNextContract = function() {
            return {
                init: function() {
                    $(".sweetalert-contract-next").each(function() {
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
                                    title: "Next Step?",
                                    text: "Kamu akan diarahkan ke step Fit Out!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, Next Step!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('project/next/contract')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Success!", "Next Step.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('project/detail')}}/"+{{$result['id_project']}}+"#fitout";
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
        jQuery(document).ready(function() {
            SweetAlertNextContract.init()
            SweetAlertDeleteContract.init()
        });
    </script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Contract</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div id="form_survey">
                       <form class="form-horizontal" role="form" action="{{url('project/create/contract')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_project" value="{{$result['id_project']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Pihak 1<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pihak 1" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled @endif type="text" id="first_party" name="first_party" value="{{$first_party}} " required/>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Pihak 2<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pihak 2" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if($result['status']!='Process' ) disabled @endif id="second_party" name="second_party" value="{{$second_party}} " required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Nominal<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nominal" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control prices" type="text" @if($result['status']!='Process' ) disabled @endif id="nominal" name="nominal" value="{{$nominal}}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note</label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" @if($result['status']!='Process' ) disabled @endif class="form-control" placeholder="Enter note here">{{$note}}</textarea>
                                    </div>
                                </div>
                                @if($result['status']=='Process')
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
                                    <label for="example-search-input" class="control-label col-md-4">Link Download file<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <br>
                                        <a target="_blank" target='blank' href="{{ $attachment }}"><i class="fa fa-download" style="font-size:48px"></i></a>
                                    </div>
                                </div>
                                @endif
                                @if ($contract==true&&$result['status']=='Process') 
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                           @if($next_contract==true)
                                            <a class="btn red sweetalert-contract-delete">Delete</a>
                                            <a class="btn green sweetalert-contract-next">Next Step</a>
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