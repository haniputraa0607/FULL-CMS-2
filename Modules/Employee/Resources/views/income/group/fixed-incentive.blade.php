<script>
    function addFormula(param,key){
		var textvalue = $('#formula'+key).val();
		var textvaluebaru = textvalue+" "+param;
		$('#formula'+key).val(textvaluebaru);
        }
</script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        @foreach($fixed_incentive as $fixed)
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">{{$fixed['name_fixed_incentive']}}</span>
                    <br>
                    <br>
                    <span class="caption-subject font-dark">Empty value to use the default value.</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table_insentif">
                       
                           @if($fixed['type'] == "Multiple")
                            <div class="table-responsive">
                            <form role="form" action="{{url('employee/income/role/fixed-incentive/create')}}" method="post" enctype="multipart/form-data">
                         <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                 
                                        <th class="text-nowrap text-center"> Range </th>
                                        <th class="text-nowrap text-center"> Value</th>
                                       
                                </tr>
                                </thead>
                                <tbody>
                                    
                                        @if(!empty($fixed['detail']))
                                        @foreach($fixed['detail'] as $key => $dt)
                                            <tr style="text-align: center" >
                                                <td style="text-align: center">{{$dt['ranges']??null}}</td>
                                                <td style="text-align: center">
                                                    <input type="hidden" name="id_role[]" value="{{$id}}"  @if($dt['id_employee_role_default_fixed_incentive_detail']==null) disabled @endif/>
                                                    <input type="hidden" name="id_employee_role_default_fixed_incentive_detail[]" value="{{$dt['id_employee_role_default_fixed_incentive_detail']}}"  @if($dt['id_employee_role_default_fixed_incentive_detail']==null) disabled @endif/>
                                                    <input type="text" @if($dt['id_employee_role_default_fixed_incentive_detail']==null) disabled @endif name="value[]" id='value' value="@if($dt['default']==1 && $dt['value'] != null){{number_format($dt['value']??null,0,',',',')}}@endif" data-type="currency" placeholder="{{number_format($dt['default_value']??0,0,',',',')}}" class="form-control" /></input></td>
                                                
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" style="text-align: center">Data Not Available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                           <div class="paginator-right"  style="float:right">
                                               {{ csrf_field() }}
                                               <button type="submit" class="btn blue">Save</button>
                                           </div>
                                          </form>
                           
                        </div>
                           @else
                            <form class="form-horizontal" role="form" action="{{url('employee/income/role/fixed-incentive/create')}}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_employee_role_default_fixed_incentive_detail[]" value="{{$fixed['detail'][0]['id_employee_role_default_fixed_incentive_detail']??''}}">
                                <input type="hidden" name="id_role[]" value="{{$id}}"/>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Value<span class="required" aria-required="true">*</span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Besar tunjangan" data-container="body"></i>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" name="value[]" id='value' value="@if($fixed['detail'][0]['default']==1 && $fixed['detail'][0]['value'] != null){{number_format($fixed['detail'][0]['value']??null,0,',',',')}}@endif" data-type="currency" placeholder="{{number_format($fixed['detail'][0]['default_value']??0,0,',',',')}}" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="paginator-right"  style="float:right">
                                                <button type="submit" class="btn blue">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                           @endif
                    </div>
                    
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>