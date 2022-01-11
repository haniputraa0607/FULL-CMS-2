
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">List Potongan</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table_potongan">
                        <div class="table-responsive">
                          <form role="form" action="{{url('recruitment/hair-stylist/group/potongan/create')}}" method="post" enctype="multipart/form-data">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                 
                                        <th class="text-nowrap text-center"> Name </th>
                                        <th class="text-nowrap text-center"> Potongan</th>
                                        <th class="text-nowrap text-center"> Formula</th>
                                        <th class="text-nowrap text-center"> Action</th>
                                       
                                </tr>
                                </thead>
                                <tbody>
                                        @if(!empty($potongan))
                                        @foreach($potongan as $dt)
                                            <tr style="text-align: center" >
                                                <td style="text-align: center">{{$dt['name']??null}}</td>
                                                <td style="text-align: center">
                                                    <input type="hidden" name="id_hairstylist_group[]" value="{{$id}}"/>
                                                    <input type="hidden" name="id_hairstylist_group_default_potongans[]" value="{{$dt['id_hairstylist_group_default_potongans']}}"/>
                                                    <input type="text" name="value[]" value="{{number_format($dt['value']??0,0,',',',')}}" id='value' data-type="currency" placeholder="Masukkan nama potongan" class="form-control" required /></td>
                                                <td style="text-align: center">
                                                    <textarea name="formula[]" id="formula" class="form-control" placeholder="Enter rumus potongan">{{$dt['formula']??''}}</textarea>
                                                </td>
                                                <td style="text-align: center">
                                                    <a class="btn btn-sm red btn-primary" href="{{url('recruitment/hair-stylist/group/potongan/delete/'.$dt['id_enkripsi'])}}">Default</a>
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