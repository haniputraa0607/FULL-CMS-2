
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

      
        var SweetAlertNextFitout = function() {
            return {
                init: function() {
                    $(".sweetalert-fitout-next").each(function() {
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
                                        url : "{{url('project/next/fitout')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Success!", "Next Step", "success")
                                                SweetAlert.init()
                                                 location.href = "{{url('project/detail')}}/"+{{$result['id_project']}};
                                                window.location.reload();;
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
            SweetAlertNextFitout.init()
        });
    </script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Fit Out</span>
                </div>
                @if($result['status']=='Process'&&$result['progres']=="Fit Out")
                    <a href="#form_fitout" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="input-follow-up">
                         Progres
                    </a>
                    <a href="#table_fitout" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="back-follow-up">
                        Back
                    </a>
                @if($result['project_fitout'])
                    <a class="btn btn-sm green sweetalert-fitout-next btn-primary" type="button" style="float:right" data-toggle="tab" id="next-follow-up">
                        Project Clear
                    </a>
                @endif
                @endif
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    
                    <div class="tab-pane active" id="table_fitout">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Created At</th>
                                    <th class="text-nowrap text-center">Title</th>
                                    <th class="text-nowrap text-center">progres</th>
                                    <th class="text-nowrap text-center">Note</th>
                                    <th class="text-nowrap text-center">Attachment</th>
                                    @if($result['progres']=='Fit Out')
                                    <th class="text-nowrap text-center">Action</th>
                                    @endif
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($result['project_fitout']))
                                        @foreach($result['project_fitout'] as $step)
                                                <tr data-id="{{ $step['id_projects_fit_out'] }}">
                                                <td>{{date('d F Y H:i', strtotime($step['created_at']))}}</td>
                                                <td>{{$step['title']}}</td>
                                                <td>{{$step['progres']}}</td>
                                                <td>{{$step['note']}}</td>
                                                <td>
                                                    @if(isset($step['attachment']))
                                                    <a target="_blank" href="{{ $step['attachment'] }}">Link Download</a>
                                                    @else
                                                    No Attachment
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($result['progres']=='Fit Out')
                                                    <a class="btn btn-sm red sweetalert-desain-delete btn-primary" data-id="{{ $step['id_projects_fit_out'] }}" data-name="Desain {{$step['title']}}"><i class="fa fa-trash-o"></i> Delete</a>
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
                    <div class="tab-pane" id="form_fitout">
                        <form class="form-horizontal" role="form" action="{{url('project/create/fitout')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_project" value="{{$result['id_project']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Title<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan Title" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="title" name="title" required/>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Progres<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan Progres" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="number" id="progres" min="1" max="100" name="progres" required/>
                                        
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
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan file" data-container="body"></i><br>
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