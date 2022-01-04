<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Rumus Potongan = {{$rumus_potongan}}</span>
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
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Rumus Potongan</span>
                </div>
                <a href="#form_rumus_potongan" class="btn btn-sm blue" type="button" style="float:right" data-toggle="tab" >
                         Create Rumus Potongan
                    </a>
                    <a href="#table_rumus_potongan" class="btn btn-sm yellow active" type="button" style="float:right" data-toggle="tab" >
                        List Rumus Potongan
                    </a>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table_rumus_potongan">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                 
                                        <th class="text-nowrap text-center"> Name </th>
                                        <th class="text-nowrap text-center"> Potongan</th>
                                        <th class="text-nowrap text-center"> Action</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                        @if(!empty($list_rumus_potongan))
                                        @foreach($list_rumus_potongan as $dt)
                                            <tr style="text-align: center" data-id="{{ $dt['id_hairstylist_group_potongan'] }}">
                                                <td>{{$dt['name_potongan']}}</td>
                                                <td>{{"Rp " . number_format($dt['price_potongan'],2,',','.')}}</td>
                                                <td><a class="btn btn-sm red btn-primary" href="{{url('recruitment/hair-stylist/group/potongan/delete-rumus-potongan/'.$dt['id_enkripsi'])}}"><i class="fa fa-trash-o"></i> Delete</a></td>
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
                    <div class="tab-pane" id="form_rumus_potongan">
                        <form class="form-horizontal" role="form" action="{{url('recruitment/hair-stylist/group/potongan/create-rumus-potongan')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_hairstylist_group" value="{{$result['id_hairstylist_group']}}">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Potongan<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Product" data-container="body"></i>
                                    </label>
                                    <div class="col-md-6">
                                             <select required name="id_hairstylist_group_potongan" id="id_hairstylist_group_potongan" class="select2" >
                                            <option value=""></option>
                                            @if(isset($list_potongan))
                                                @foreach($list_potongan as $row)
                                                        <option value="{{$row['id_hairstylist_group_potongan']}}">{{$row['name_potongan']}} -  {{"Rp " . number_format($row['price_potongan'],2,',','.')}}</option>
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