<div style="margin-top: -4%">
                    <form class="form-horizontal" role="form" action="{{url('employee/reimbursement/create')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Employee</label>
                                    <div class="col-md-4 input-group">
                                        <input class="form-control" name="id_user" id="id_user" value="{{$data['user_name']??''}}" data-placeholder="Select Employee" disabled="">
                                        <input class="form-control" type="hidden" name="id_employee_cash_advance" id="id_employee_cash_advance" value="{{$data['id_employee_cash_advance']}}" data-placeholder="Select Employee" >
                                               
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Name Product</label>
                                    <div class="col-md-4 input-group">
                                        <input class="form-control" name="id_user" id="key" value="{{$data['name_product']??''}}" data-placeholder="Select Employee" disabled="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Price</label>
                                    <div class="col-md-4 input-group">
                                        <input type="text" name="installment" id='installment' value="{{number_format($data['price']??0,0,',',',')}}" min="1" placeholder="Masukkan jumlah" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Notes Employee</label>
                                    <div class="col-md-6 input-group">
                                        <textarea type="text" class="form-control" name="notes" id="notes" placeholder="Masukkan notes" disabled    >{{$data['notes']??''}}</textarea>
                                    </div>
                                </div>
                                @if($data['status']!='Fat Dept Approved')
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Status</label>
                                    <div class="col-md-4 input-group">
                                        <select W required class="form-control" name="status" id="status" data-placeholder="Select action" disabled>
                                              <option>Pilih Action</option>
                                              <option value="Approved" @if($data['status']=="Approved") selected @endif>Approved</option>
                                              <option value="Success" @if($data['status']=="Success") selected @endif>Approved</option>
                                              <option value="Reject" @if($data['status']=="Reject") selected @endif>Reject</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-md-4 control-label">Notes</label>
                                    <div class="col-md-6 input-group">
                                        <textarea type="text" class="form-control" name="approve_notes" id="approve_notes " placeholder="Masukkan notes" disabled>{{$data['approve_notes']??''}}</textarea>
                                    </div>
                                </div>
                                @else
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Status<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Data ini berguna untuk merubah status dari request perubahan data " data-container="body"></i>
                                    </label>
                                    <div class="col-md-4 input-group">
                                        <select required class="form-control" name="status" id="status" data-placeholder="Select action">
                                            <option value="Approved" >Approved</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Notes<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Data ini berguna untuk memberikan catatan yang diberikan oleh pemvalidasi" data-container="body"></i>
                                    </label>
                                    <div class="col-md-6 input-group">
                                        <textarea type="text" class="form-control" name="approve_notes" id="approve_notes " placeholder="Masukkan notes" ></textarea>
                                    </div>
                                </div>
                                @endif
                                @if($data['status']=='Fat Dept Approved')
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
</div>