<?php 
  $step_desain = 1;
  $status = false;
  if(!empty($result['project_desain'])){
    foreach($result['project_desain'] as $i => $step){
      $step_desain++; 
    }
  }
  foreach($result['project_desain'] as $s){
      if($s['status']=='Success'){
          $status = true;
      }
  }
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

        var SweetAlertDesain = function() {
            return {
                init: function() {
                    $(".sweetalert-desain-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        var data = {
                                    '_token' : '{{csrf_token()}}',
                                    'id_projects_desain':id,
                                    'id_project':{{$result['id_project']}}
                                        };
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to delete this desain?",
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
                                        url : "{{url('project/delete/desain')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Desain has been deleted.", "success")
                                               location.href = "{{url('project/detail')}}/"+{{$result['id_project']}}+"#contract";
                                                window.location.reload();
                                            }
                                            else if(response.status == "fail"){
                                              
                                                swal("Error!", "Failed to delete.", "error")
                                            }
                                            else {
                                                console.log(data)
                                                console.log(response)
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
        var SweetAlertNextDesain = function() {
            return {
                init: function() {
                    $(".sweetalert-desain-next").each(function() {
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
                                    text: "Kamu akan diarahkan ke step Contract!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, Next Step!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('project/next/desain')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Success!", "Next Step", "success")
                                                SweetAlert.init()
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
         function number(id){
            $(id).inputmask("remove");
            $(id).inputmask({
                mask: "0999 9999 999999",
                removeMaskOnSubmit: true,
                placeholder:"",
                prefix: "",
                digits: 0,
                // groupSeparator: '.',
                rightAlign: false,
                greedy: false,
                autoGroup: true,
                digitsOptional: false,
            });
        }
        jQuery(document).ready(function() {
            
            number("#cp_designer");
            SweetAlertDesain.init()
            SweetAlertNextDesain.init()
        });
    </script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Desain Location</span>
                </div>
                @if($result['status']=='Process'&&$result['progres']=="Desain Location")
                @if($status!=true)
                     <a href="#form_desain" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="input-follow-up">
                         Desain {{ $step_desain }}
                    </a>
                @endif
                    <a href="#table_desain" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="back-follow-up">
                        Back
                    </a>
                @if($step_desain>1&&$status==true)
                    <a class="btn btn-sm green sweetalert-desain-next btn-primary" type="button" style="float:right" data-toggle="tab" id="next-follow-up">
                        Next Step
                    </a>
                @endif
                @endif
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    
                    <div class="tab-pane active" id="table_desain">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Name Designer</th>
                                    <th class="text-nowrap text-center">CP Designer</th>
                                    <th class="text-nowrap text-center">Step</th>
                                    <th class="text-nowrap text-center">Note</th>
                                    <th class="text-nowrap text-center">Status</th>
                                    <th class="text-nowrap text-center">Attachment</th>
                                    @if($result['progres']=='Desain Location')
                                    <th class="text-nowrap text-center">Action</th>
                                    @endif
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($result['project_desain']))
                                        @foreach($result['project_desain'] as $step)
                                                <tr data-id="{{ $step['id_projects_desain'] }}">
                                                <td> {{$step['nama_designer']}}</td>
                                                <td> {{$step['cp_designer']}}</td>
                                                <td>Desain {{$step['desain']}}</td>
                                                <td>{{$step['note']}}</td>
                                                <td> @if($step['status'] == 'Success')
                                        <span class="badge" style="background-color: #26C281; color: #ffffff">{{$step['status']}}</span>
                                        @elseif($step['status'] == 'Revisi')
                                        <span class="badge" style="background-color: #101ee7; color: #ffffff">{{$step['status']}}</span>
                                        @else
                                        <span class="badge" style="background-color: #EF1E31; color: #ffffff">{{$step['status']}}</span>
                                        @endif
                                                </td>
                                                <td>
                                                    @if(isset($step['attachment']))
                                                    <a target="_blank" href="{{ env('STORAGE_URL_API').$step['attachment'] }}">Link Download</a>
                                                    @else
                                                    No Attachment
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($result['progres']=='Desain Location')
                                                    <a class="btn btn-sm red sweetalert-desain-delete btn-primary" data-id="{{ $step['id_projects_desain'] }}" data-name="Desain {{$step['desain']}}"><i class="fa fa-trash-o"></i> Delete</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" style="text-align: center">No Follow Up Desain Yet</td>
                                        </tr>
                                    @endif
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="form_desain">
                        <form class="form-horizontal" role="form" action="{{url('project/create/desain')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_project" value="{{$result['id_project']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Desain 1<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih step" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="desain" name="desain" value="Desain {{ $step_desain }}" disabled required/>
                                        <input class="form-control" type="hidden" id="desain" name="desain" value="{{ $step_desain }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Designer Name<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama Designer" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="nama_designer" name="nama_designer" placeholder="Enter Nama Designer"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">CP Designer<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Kontak Designer" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="cp_designer" name="cp_designer" placeholder="Enter Kontak Designer"/>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note </label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" ></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Status<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Status Design" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select name="status" class="form-control input-sm select2" placeholder="Status">
                                        <option value="" >Select Status</option>
                                        <option value="Revisi">Revisi</option>
                                        <option value="Success">Success</option>
                                        <option value="Reject">Reject</option>
                                    </select>
                                    </div>
                                </div>
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
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
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