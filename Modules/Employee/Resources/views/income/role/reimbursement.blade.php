<script>
    function addFormulas(param,key){
                var textvalue = $('#value_text'+key).val();
		var textvaluebaru = textvalue+" "+param;
		$('#value_text'+key).val(textvaluebaru);
        }
</script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">List Salary Cuts</span>
                    <br>
                    <br>
                    <span class="caption-subject font-dark">Empty value to use the default value.</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table_potongan">
                        <div class="table-responsive">
                          <form role="form" action="{{url('employee/income/role/reimbursement/create')}}" method="post" enctype="multipart/form-data">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                 
                                        <th class="text-nowrap text-center"> Name </th>
                                        <th class="text-nowrap text-center"> Max Approve Date </th>
                                        <th class="text-nowrap text-center"> Type</th>
                                        <th class="text-nowrap text-center"> Formula</th>
                                       
                                </tr>
                                </thead>
                                <tbody>
                                        @if(!empty($reimbursement))
                                        @foreach($reimbursement as $key => $dt)
                                            <tr style="text-align: center" >
                                                <td style="text-align: center">{{$dt['name']??null}}</td>
                                                <td style="text-align: center">{{$dt['max_approve_date']??null}}</td>
                                                <td style="text-align: center">{{$dt['type']??null}}</td>
                                                <td style="text-align: center">
                                                    <input type="hidden" name="id_role[]" value="{{$id}}"/>
                                                     <input type="hidden" name="id_employee_reimbursement_product_icount[]" value="{{$dt['id_employee_reimbursement_product_icount']}}"/>
                                                    <textarea name="value_text[]" id="value_text{{$key}}" class="form-control" placeholder="{{$dt['value_text']??''}}">@if($dt['default']==1 && $dt['value_text'] != null){{$dt['value_text']??''}}@endif</textarea>
                                                     <div class="row">
                                                            @foreach($textreplaces as $row)
                                                                    <div class="col-md-4" style="margin-top: 5px;">
                                                                            <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="{{ $row['message'] }}" onClick="addFormulas('{{ $row['keyword']}}',{{$key}});">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                                    </div>
                                                            @endforeach
                                                    </div>
                                                </td>
                                                
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
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>