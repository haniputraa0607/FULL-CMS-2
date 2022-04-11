<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
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

        if(subject_value == 'source'){
            var operator = "conditions["+index+"][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('=', '=');
            operator_value.options[operator_value.options.length] = new Option('like', 'like');        
            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'text';
            }else{
                var operator = "conditions["+index+"][operator]";
                var operator_value = document.getElementsByName(operator)[0];
                for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
                operator_value.options[operator_value.options.length] = new Option('=', '=');        
                operator_value.options[operator_value.options.length] = new Option('>', '>');    
                operator_value.options[operator_value.options.length] = new Option('<', '<');    
                operator_value.options[operator_value.options.length] = new Option('<=', '<=');    
                operator_value.options[operator_value.options.length] = new Option('>=', '>=');    
                operator_value.options[operator_value.options.length] = new Option('!=', '!=');    
                var parameter = "conditions["+index+"][parameter]";
                document.getElementsByName(parameter)[0].type = 'number';
                document.getElementsByName(parameter)[0].value = '';
        }
    }

	$(document).ready(function(){
        @if($filter_date_today ?? false)
            $('input[name=filter_type]').on('change', function() {
                if ($(this).prop('checked')) {
                    if ($(this).val() == 'today') {
                        $('#filter-date-range').addClass('hidden');
                    } else {
                        $('#filter-date-range').removeClass('hidden');
                    }
                }
            }).change();
        @endif

    });
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
            @if($filter_date ?? false)
                @if($filter_date_today ?? false)
                <div class="form-group row">
                    <div class="col-md-9 col-form-label" style="margin-left: 4.5%">
                        <label class="radio-inline">
                            <input type="radio" name="filter_type" @if($is_today ?? false) checked @endif id="filter-date-type" value="today">
                            <span></span> Today
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="filter_type" @if(!($is_today ?? false)) checked @endif id="filter-date-type" value="range_date">
                            <span></span> Range Date
                        </label>
                    </div>
                </div>
                <br>
                @endif
                <div class="row hidden" id="filter-date-range">
                    <div class="col-md-2 text-right pt-3">Date Start:</div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="date" name="start_date" class="form-control" required id="filter_date_start" value="{{date('Y-m-d', strtotime($start_date))}}">
                            <div class="input-group-addon">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-right pt-3">Date End:</div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="date" name="end_date" class="form-control" required id="filter_date_end" value="{{date('Y-m-d', strtotime($end_date))}}">
                            <div class="input-group-addon">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            @endif
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
                                                  <option value="stock_before" @if ($con['subject'] == 'stock_before') selected @endif>Stock Before</option>
                                                  <option value="qty" @if ($con['subject'] == 'qty') selected @endif>Stock Log</option>
                                                  <option value="stock_after" @if ($con['subject'] == 'stock_after') selected @endif>Stock After</option>
                                                  <option value="source" @if ($con['subject'] == 'source') selected @endif>Source</option>
                                              </select>
                                          </div>
                                          <div class="col-md-4">
                                              <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">                
                                                  <option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
                                                  <option value="like" @if ($con['operator'] == 'like') selected @endif>like</option>
                                              </select>
                                          </div>

                                          <div class="col-md-3">
                                              @if($con['subject'] == 'level' || $con['subject'] == 'id_outlet' || $con['subject'] == 'user_franchise_status')
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
                                                  <option value="stock_before">Stock Before</option>
                                                  <option value="qty">Stock Log</option>
                                                  <option value="stock_after">Stock After</option>
                                                  <option value="source">Source</option>
                                              </select>
                                          </div>
                                          <div class="col-md-4">
                                              <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                                  <option value="" selected></option>
                                                  <option value="=" >=</option>
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
                                        <option value="stock_before">Stock Before</option>
                                        <option value="qty">Stock Log</option>
                                        <option value="stock_after">Stock After</option>
                                        <option value="source">Source</option>
                                      </select>
                                  </div>
                                  <div class="col-md-4">
                                      <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                          <option value="" selected></option>
                                          <option value="=">=</option>
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
                      <select name="rule" class="form-control input-sm select2" placeholder="Search Rule" required>
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