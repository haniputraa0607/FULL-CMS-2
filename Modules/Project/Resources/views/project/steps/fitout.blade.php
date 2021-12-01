<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

        var SweetAlertFitout = function() {
            return {
                init: function() {
                    $(".sweetalert-fitout-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        var data = {
                                    '_token' : '{{csrf_token()}}',
                                    'id_projects_fit_out':id
                                        };
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to delete this fitout?",
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
                                        url : "{{url('project/delete/fitout')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Fit Out has been deleted.", "success")
                                              location.href = "{{url('project/detail')}}/"+{{$result['id_project']}}+"#fitout";
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
                                    text: "Kamu akan diarahkan ke step Handover!",
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
                                                 location.href = "{{url('project/detail')}}/"+{{$result['id_project']}}+"#handover";
                                                window.location.reload();;
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
            SweetAlertNextFitout.init()
            SweetAlertFitout.init()
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
                        Next Step
                    </a>
                @endif
                @endif
            </div>
            <div class="portlet-body form">
                @if($result['progres']!='Fit Out' )
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#table_fitout" data-toggle="tab">Overview </a>
                </li>
                    <li>
                        <a href="#invoice_bap" data-toggle="tab">Invoice BAP </a>
                    </li>
            </ul>
             @endif
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
                                                    <a target="_blank" href="{{ env('STORAGE_URL_API').$step['attachment'] }}">Link Download</a>
                                                    @else
                                                    No Attachment
                                                    @endif
                                                </td>
                                                 @if($result['progres']=='Fit Out')
                                                <td>
                                                   
                                                    <a class="btn btn-sm red sweetalert-fitout-delete btn-primary" data-id="{{ $step['id_projects_fit_out'] }}" data-name="Desain {{$step['title']}}"><i class="fa fa-trash-o"></i> Delete</a>
                                                    
                                                </td>
                                                @endif
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
                                    <label for="example-search-input" class="control-label col-md-4">Note </label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here"></textarea>
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
                    <div class="tab-pane" id="invoice_bap">
                        <form class="form-horizontal" id="conract_form" role="form"  method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">ID Sales Invoice</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="{{$result['invoice_bap']['id_sales_invoice']??''}}"required/>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Amount</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="Rp {{number_format($result['invoice_bap']['amount']??0,2,',','.')}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">DPP</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="Rp {{number_format($result['invoice_bap']['dpp']??0,2,',','.')}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">DPP Tax</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="Rp {{number_format($result['invoice_bap']['dpp_tax']??0,2,',','.')}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tax</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="{{$result['invoice_bap']['tax']??0}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tax Value</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="Rp {{number_format($result['invoice_bap']['tax_value']??0,2,',','.')}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Netto</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="Rp {{number_format($result['invoice_bap']['netto']??0,2,',','.')}}"/>
                                    </div>
                                </div>
                            <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tax Date</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input disabled type="text" id="grand_opening" class="form_datetime form-control" name="grand_opening" value="{{ (!empty( $result['invoice_bap']['tax_date']) ? date('d M Y H:i', strtotime( $result['invoice_bap']['tax_date'])) : '')}}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                  @if(!empty($result['invoice_bap']['value_detail']))
                                        @foreach(json_decode($result['invoice_bap']['value_detail'],true) as $st)
                                             <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Sales Invoice Detail ID</label>
                                                <div class="col-md-5">
                                                    <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="{{$st['SalesInvoiceDetailID']??0}}"/>
                                                </div>
                                            </div> 
                                             <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">ID Item</label>
                                                <div class="col-md-5">
                                                    <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="{{$st['ItemID']??0}}"/>
                                                </div>
                                            </div> 
                                             <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Quantity</label>
                                                <div class="col-md-5">
                                                    <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="{{$st['Qty']??0}}"/>
                                                </div>
                                            </div> 
                                        @endforeach
                                    @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>