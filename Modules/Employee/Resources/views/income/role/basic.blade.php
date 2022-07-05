<script>
    function addFormula(param,key){
		var textvalue = $('#formula'+key).val();
		var textvaluebaru = textvalue+" "+param;
		$('#formula'+key).val(textvaluebaru);
        }
</script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Basic Salary</span>
                    <br>
                    <br>
                    <span class="caption-subject font-dark">Empty value to use the default value.</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table_insentif">
                       <form role="form" class="form-horizontal" action="{{url('employee/income/role/basic-salary/create')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
                                               <input type="hidden" name="id_role" value="{{$id}}" />
                                                <div id="id_commission">
                                                     <div class="form-group">
                                                    <label for="example-search-input" class="control-label col-md-4">Default Basic Salary<span class="required" aria-required="true">*</span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Besaran gaji pokok" data-container="body"></i></label>
                                                    <div class="col-md-6">
                                                        <input class="form-control" required type="text" id="value" data-type="currency" value="{{number_format($basic_salary['value_role']??0,0,',',',')}}" name="value" placeholder="{{number_format($basic_salary['value']??0,0,',',',')}}"/>
                                                    </div>
                                                </div>
                                                </div>
					</div>
                                        
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Update</button>
					</div>
				</form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>