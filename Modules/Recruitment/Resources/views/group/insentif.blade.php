
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">List Insentif</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table_insentif">
                        <div class="table-responsive">
                          <form role="form" action="{{url('recruitment/hair-stylist/group/insentif/create')}}" method="post" enctype="multipart/form-data">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                 
                                        <th class="text-nowrap text-center"> Name </th>
                                        <th class="text-nowrap text-center"> Insentif</th>
                                        <th class="text-nowrap text-center"> Formula</th>
                                        <th class="text-nowrap text-center"> Action</th>
                                       
                                </tr>
                                </thead>
                                <tbody>
                                        @if(!empty($insentif))
                                        @foreach($insentif as $dt)
                                            <tr style="text-align: center" >
                                                <td style="text-align: center">{{$dt['name']??null}}</td>
                                                <td style="text-align: center">
                                                    <input type="hidden" name="id_hairstylist_group[]" value="{{$id}}"/>
                                                    <input type="hidden" name="id_hairstylist_group_default_insentifs[]" value="{{$dt['id_hairstylist_group_default_insentifs']}}"/>
                                                    <input type="text" name="value[]" value="{{number_format($dt['value']??0,0,',',',')}}" id='value' data-type="currency" placeholder="Masukkan nama insentif" class="form-control" required /></td>
                                                <td style="text-align: center">
                                                    <textarea name="formula[]" id="formula" class="form-control" placeholder="Enter rumus insentif">{{$dt['formula']??''}}</textarea>
                                                </td>
                                                <td style="text-align: center">
                                                    <a class="btn btn-sm red btn-primary" href="{{url('recruitment/hair-stylist/group/insentif/delete/'.$dt['id_enkripsi'])}}">Default</a>
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