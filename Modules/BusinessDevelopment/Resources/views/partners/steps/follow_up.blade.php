<?php 
  $step_follow_up = 1;
  if(!empty($result['partner_step'])){
    foreach($result['partner_step'] as $i => $step){
      $step_follow_up = $i + 2; 
    }
  }
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
        var SweetAlertNextSteps = function() {
            return {
                init: function() {
                    $(".sweetalert-next-steps").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        var data = {
                            '_token' : '{{csrf_token()}}',
                            'id_partner':id
                                        };
                        $(this).click(function() {
                            swal({
                                    title: "Approved?",
                                    text: "You will be directed to the next step!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, Next Step!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('businessdev/partners/approved-follow-up')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Success!", "Next Step", "success")
                                                SweetAlert.init()
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
            SweetAlertNextSteps.init();
        
        });
    </script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Follow Up Data</span>
                </div>
                @if($result['status']=='Candidate'&&$result['status_steps']=='On Follow Up' || empty($result['status_steps']))
                    <a href="#form" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="input-follow-up">
                        Follow Up
                    </a>
                    <a href="#table" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="back-follow-up">
                        Back
                    </a>
                    @if($step_follow_up>1)
                    <a class="btn btn-sm green sweetalert-next-steps btn-primary" data-id="{{$result['id_partner']}}" type="button" style="float:right" data-toggle="tab" id="next-follow-up">
                        Approved
                    </a>
                    @endif
                @endif
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
                                <a href="#form" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-follow-up">
                                    Follow Up
                                </a>
                                <a href="#table" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="back-follow-up">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active" id="table">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Created At</th>
                                    <th class="text-nowrap text-center">Step</th>
                                    <th class="text-nowrap text-center">Note</th>
                                    <th class="text-nowrap text-center">Attachment</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($result['partner_step']))
                                        @foreach($result['partner_step'] as $i => $step)
                                            @if ($step['follow_up']=='Follow Up')
                                                @php $i++; @endphp
                                                <tr data-id="{{ $step['id_steps_log'] }}">
                                                    <td>{{date('d F Y H:i', strtotime($step['created_at']))}}</td>
                                                    <td>{{$step['follow_up']}} {{$i}} </td>
                                                    <td>{{$step['note']}}</td>
                                                    <td>
                                                        @if(isset($step['attachment']))
                                                        <a href="{{ $step['attachment'] }}">Link Download Attachment</a>
                                                        @else
                                                        No Attachment
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" style="text-align: center">No Follow Up Yet</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="form">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Step yang sedang dilakukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow_up" name="follow_up" value="@if($step_follow_up<2)Follow Up {{ $step_follow_up }} @else Follow Up @endif" readonly required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk step ini" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" required>{{ old('note') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment
                                        <i class="fa fa-question-circle tooltips" data-original-title="Unggah file jika ada lampiran yang diperlukan" data-container="body"></i><br>
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
                                            @if($result['status']=='Candidate') <a class="btn red sweetalert-reject" data-id="{{ $result['id_partner'] }}" data-name="{{ $result['name'] }}">Reject</a> @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>