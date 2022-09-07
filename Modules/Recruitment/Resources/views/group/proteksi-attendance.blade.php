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
                    <span class="caption-subject font-dark sbold uppercase font-yellow">List Proteksi Attendance</span>
                    <br>
                    <br>
                    <span class="caption-subject font-dark">Empty value to use the default value.</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table_insentif">
                        <div class="table-responsive">
                          <form role="form" action="{{url('recruitment/hair-stylist/group/proteksi-attendance/create')}}" method="post" enctype="multipart/form-data">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                        <th class="text-nowrap text-center"> Month </th>
                                        <th class="text-nowrap text-center"> Value</th>
                                        <th class="text-nowrap text-center"> Amount</th>
                                        <th class="text-nowrap text-center"> Amount Proteksi</th>
                                        <th class="text-nowrap text-center"> Amount per Day</th>
                                       
                                </tr>
                                </thead>
                                <tbody>
                                        @if(!empty($proteksi_attendance))
                                        @foreach($proteksi_attendance as $key => $dt)
                                            <tr style="text-align: center" >
                                                <td style="text-align: center">{{$dt['name_month']??null}}</td>
                                                <td style="text-align: center">
                                                    <input type="hidden" name="month[]" value="{{$dt['month']}}"/>
                                                    <input type="hidden" name="id_hairstylist_group[]" value="{{$id}}"/>
                                                    <input type="hidden" name="id_hairstylist_group_default_proteksi_attendance[]" value="{{$dt['id_hairstylist_group_default_proteksi_attendance']}}"/>
                                                    <input type="text" name="value[]" id='value' value="@if($dt['default']==1 && $dt['value'] != null){{number_format($dt['value']??null,0,',',',')}}@endif" data-type="currency" placeholder="{{number_format($dt['default_value']??0,0,',',',')}}" class="form-control" /></input></td>
                                                
                                                <td style="text-align: center">
                                                    <input type="text" name="amount[]" id='amount' value="@if($dt['amount_default']==1 && $dt['amount'] != null){{number_format($dt['amount']??null,0,',',',')}}@endif" data-type="currency" placeholder="{{number_format($dt['default_amount']??0,0,',',',')}}" class="form-control" /></input></td>
                                                <td style="text-align: center">
                                                    <input type="text" name="amount_proteksi[]" id='amount_proteksi' value="@if($dt['amount_proteksi_default']==1 && $dt['amount_proteksi'] != null){{number_format($dt['amount_proteksi']??null,0,',',',')}}@endif" data-type="currency" placeholder="{{number_format($dt['default_amount_proteksi']??0,0,',',',')}}" class="form-control" /></input></td>
                                                
                                                <td style="text-align: center">
                                                    <input type="text" name="amount_day[]" id='amount_day' value="@if($dt['amount_day_default']==1 && $dt['amount_day'] != null){{number_format($dt['amount_day']??null,0,',',',')}}@endif" data-type="currency" placeholder="{{number_format($dt['default_amount_day']??0,0,',',',')}}" class="form-control" /></input></td>
                                                
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