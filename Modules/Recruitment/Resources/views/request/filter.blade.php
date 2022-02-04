<script>
    function changeSelect(){
        setTimeout(function(){
            $(".select2").select2({
                placeholder: "Search"
            });
        }, 100);
    }
    
    function changeSubject(val){
        var subject = val;
        var temp1 = subject.replace("conditions[", "");
        var index = temp1.replace("][subject]", "");
        var subject_value = document.getElementsByName(val)[0].value;
  
        if(subject_value == 'status'){
            var operator = "conditions["+index+"][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('Request', 'Request');
            operator_value.options[operator_value.options.length] = new Option('Approve', 'Approve');
            operator_value.options[operator_value.options.length] = new Option('Rejected', 'Rejected');
            operator_value.options[operator_value.options.length] = new Option('Done Approved', 'Done Approved');
            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
            document.getElementsByName(parameter)[0].value = '';
        }else if(subject_value == 'number_of_request'){
            var operator = "conditions["+index+"][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('=', '=');    
            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'number';
            document.getElementsByName(parameter)[0].value = '';
        }else{
            var operator = "conditions["+index+"][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('=', '=');
            operator_value.options[operator_value.options.length] = new Option('like', 'like');        
            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'text';
            document.getElementsByName(parameter)[0].value = '';
        }
    }
</script>

<div class="portlet light bordered">
  <div class="portlet-title">
      <div class="caption font-blue ">
          <i class="icon-settings font-blue "></i>
          <span class="caption-subject bold uppercase">Filter</span>
      </div>
  </div>
  <div class="portlet-body form">
      <div class="form-body">
          <div class="form-group mt-repeater">
              <div data-repeater-list="conditions">
                  @if (!empty($conditions))
                      @foreach ($conditions as $key => $con)
                          @if(isset($con['subject']))
                              <div data-repeater-item class="mt-repeater-item mt-overflow">
                                  <div class="mt-repeater-cell">
                                      <div class="col-md-12">
                                          <div class="col-md-1">
                                              <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                  <i class="fa fa-close"></i>
                                              </a>
                                          </div>
                                          <div class="col-md-4">
                                              <select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
                                                  <option value="outlet_name" @if ($con['subject'] == 'outlet_name') selected @endif>Outlet Name</option>
                                                  <option value="number_of_request" @if ($con['subject'] == 'number_of_request') selected @endif>Number of Request</option>
                                                  <option value="status" @if ($con['subject'] == 'status') selected @endif>Status</option>
                                              </select>
                                          </div>
                                          <div class="col-md-4">
                                              <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">                
                                              @if($con['subject'] == 'status')
                                                <option value="Request" @if ($con['operator'] == 'Request') selected @endif>Request</option>
                                                <option value="Approve" @if ($con['operator'] == 'Approve') selected @endif>Approve</option>
                                                <option value="Rejected" @if ($con['operator'] == 'Rejected') selected @endif>Rejected</option>
                                                <option value="Done Approved" @if ($con['operator'] == 'Done Approved') selected @endif>Done Approved</option>
                                              @else
                                                  <option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
                                                  <option value="like" @if ($con['operator'] == 'like') selected @endif>like</option>
                                              @endif
                                              </select>
                                          </div>

                                          <div class="col-md-3">
                                              @if($con['subject'] == 'status')
                                                  <input type="hidden" placeholder="Keyword" class="form-control" name="parameter" @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                              @else
                                                  <input type="text" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                              @endif
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          @else
                              <div data-repeater-item class="mt-repeater-item mt-overflow">
                                  <div class="mt-repeater-cell">
                                      <div class="col-md-12">
                                          <div class="col-md-1">
                                              <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                  <i class="fa fa-close"></i>
                                              </a>
                                          </div>
                                          <div class="col-md-4">
                                              <select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
                                                  <option value="" selected disabled>Search Subject</option>
                                                  <option value="outlet_name">Outlet Name</option>
                                                  <option value="number_of_request">Number of Request</option>
                                                  <option value="status">Status</option>
                                              </select>
                                          </div>
                                          <div class="col-md-4">
                                              <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                                  <option value="=" selected>=</option>
                                                  <option value="like">Like</option>
                                              </select>
                                          </div>
                                          <div class="col-md-3">
                                              <input type="text" placeholder="Keyword" class="form-control" name="parameter" />
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          @endif
                      @endforeach
                  @else
                      <div data-repeater-item class="mt-repeater-item mt-overflow">
                          <div class="mt-repeater-cell">
                              <div class="col-md-12">
                                  <div class="col-md-1">
                                      <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                          <i class="fa fa-close"></i>
                                      </a>
                                  </div>
                                  <div class="col-md-4">
                                      <select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
                                          <option value="" selected disabled>Search Subject</option>
                                          <option value="outlet_name">Outlet Name</option>
                                          <option value="number_of_request">Number of Request</option>
                                          <option value="status">Status</option>
                                      </select>
                                  </div>
                                  <div class="col-md-4">
                                      <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                          <option value="=" selected>=</option>
                                          <option value="like">Like</option>
                                      </select>
                                  </div>
                                  <div class="col-md-3">
                                      <input type="text" placeholder="Keyword" class="form-control" name="parameter" />
                                  </div>
                              </div>
                          </div>
                      </div>
                  @endif
              </div>
              <div class="form-action col-md-12">
                  <div class="col-md-12">
                      <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add" onClick="changeSelect();">
                          <i class="fa fa-plus"></i> Add New Condition</a>
                  </div>
              </div>

              <div class="form-action col-md-12" style="margin-top:15px">
                  <div class="col-md-5">
                      <select name="rule" class="form-control input-sm " placeholder="Search Rule" required>
                          <option value="and" @if (isset($rule) && $rule == 'and') selected @endif>Valid when all conditions are met</option>
                          <option value="or" @if (isset($rule) && $rule == 'or') selected @endif>Valid when minimum one condition is met</option>
                      </select>
                  </div>
                  <div class="col-md-4">
                      {{ csrf_field() }}
                      <button type="submit" class="btn yellow"><i class="fa fa-search"></i> Search</button>
                      <a class="btn green" href="{{url()->current()}}">Reset</a>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@if(isset($rule) && $rule==true)
<div class="alert alert-block alert-info fade in">
<button type="button" class="close" data-dismiss="alert"></button>
<h4 class="alert-heading">Displaying search result :</h4>
<p>{{$data_total}}</p><br>
<a class="btn btn-sm btn-warning" href="{{url()->current()}}">Reset</a>
<br>
</div>
@endif