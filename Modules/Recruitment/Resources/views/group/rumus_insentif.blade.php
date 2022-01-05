<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Rumus Insentif = {{$rumus_insentif}}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Rumus Insentif</span>
                </div>
                <a href="#form_rumus_insentif" class="btn btn-sm blue" type="button" style="float:right" data-toggle="tab" >
                         Create Rumus Insentif
                    </a>
                    <a href="#table_rumus_insentif" class="btn btn-sm yellow active" type="button" style="float:right" data-toggle="tab" >
                        List Rumus Insentif
                    </a>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table_rumus_insentif">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                 
                                        <th class="text-nowrap text-center"> Name </th>
                                        <th class="text-nowrap text-center"> Insentif</th>
                                        <th class="text-nowrap text-center"> Action</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                        @if(!empty($list_rumus_insentif))
                                        @foreach($list_rumus_insentif as $dt)
                                            <tr style="text-align: center" data-id="{{ $dt['id_hairstylist_group_insentif'] }}">
                                                <td>{{$dt['name_insentif']}}</td>
                                                <td>{{"Rp " . number_format($dt['price_insentif'],2,',','.')}}</td>
                                                <td><a class="btn btn-sm red btn-primary" href="{{url('recruitment/hair-stylist/group/insentif/delete-rumus-insentif/'.$dt['id_enkripsi'])}}"><i class="fa fa-trash-o"></i> Delete</a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" style="text-align: center">Data Not Available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="form_rumus_insentif">
                        <form class="form-horizontal" role="form" action="{{url('recruitment/hair-stylist/group/insentif/create-rumus-insentif')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_hairstylist_group" value="{{$result['id_hairstylist_group']}}">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Insentif<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Product" data-container="body"></i>
                                    </label>
                                    <div class="col-md-6">
                                             <select required name="id_hairstylist_group_insentif" id="id_hairstylist_group_insentif" class="select2" >
                                            <option value=""></option>
                                            @if(isset($list_insentif))
                                                @foreach($list_insentif as $row)
                                                        <option value="{{$row['id_hairstylist_group_insentif']}}">{{$row['name_insentif']}} - {{"Rp " . number_format($row['price_insentif'],2,',','.')}}</option>
                                                @endforeach
                                            @endif
                                        </select>
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
</div>