<div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Emergency Contact</span>
                </div>
                <a href="#form_survey" class="btn btn-success" type="button" style="float:right" data-toggle="tab" id="input-survey-loc">
                        Create
                    </a>
                    <a href="#table_survey" class="btn btn-warning" type="button" style="float:right" data-toggle="tab" id="back-survey-loc">
                        List
                    </a>
                    
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table_survey">
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Name</th>
                                    <th class="text-nowrap text-center">Relation</th>
                                    <th class="text-nowrap text-center">Phone</th>
                                    <th class="text-nowrap text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                 @if(!empty($detail['employee_emergency_call']))
                                    @foreach($detail['employee_emergency_call'] as $doc)
                                      <tr>  
                                              <td class="text-nowrap text-center">{{$doc['name_emergency_contact']}}</td>
                                              <td class="text-nowrap text-center">{{$doc['relation_emergency_contact']}}</td>
                                              <td class="text-nowrap text-center">{{$doc['phone_emergency_contact']}}</td>
                                              <td class="text-nowrap text-center"><a class="btn btn-sm red btn-primary" href="{{url('employee/recruitment/contact/delete/'.$doc['id_employee_emergency_contact'])}}"><i class="fa fa-trash-o"></i> Delete</a></td>
                                      </tr>
                                    @endforeach
                                 @else
                                      <tr>
                                          <td colspan="4" style="text-align: center">No Survey Location Yet</td>
                                      </tr>
                                  @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="form_survey">
                        <form class="form-horizontal" role="form" action="{{url('employee/recruitment/contact/create/'.$detail['id_employee'])}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_user" value="{{$detail['id_user']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Name Contact <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama contact dari kerabat atau relasi yang dapat dihubungi" data-container="body"></i></label>
                                    <div class="col-md-5 input-group">
                                        <input class="form-control" type="text" id="name_emergency_contact" name="name_emergency_contact" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Relation Contact <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Hubungan dengan karyawan" data-container="body"></i></label>
                                    <div class="col-md-5 input-group">
                                        <input class="form-control" type="text" id="relation_emergency_contact" name="relation_emergency_contact" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Phone number<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon dari kerabat atau relasi yang dapat dihubungi" data-container="body"></i></label>
                                    <div class="col-md-5 input-group">
                                        <input class="form-control" type="text" id="phone_emergency_contact" name="phone_emergency_contact" required/>
                                         <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                 <i class="fa fa-phone" ></i>
                                                                </button>
                                                            </span>
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