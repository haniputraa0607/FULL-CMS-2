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
                
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table_rumus_potongan">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                 
                                        <th class="text-nowrap text-center"> Name </th>
                                        <th class="text-nowrap text-center"> Value</th>
                                        <th class="text-nowrap text-center"> Formula</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                        @if(!empty($list_rumus_potongan))
                                        @foreach($list_rumus_potongan as $dt)
                                            <tr style="text-align: center" data-id="{{ $dt['id_hairstylist_group_default_potongans'] }}">
                                               <td style="text-align: center">{{$dt['name']??null}}</td>
                                                <td style="text-align: center">{{"Rp " . number_format($dt['value']??0,2,',','.')}}</td>
                                                <td style="text-align: center">{{$dt['formula']??''}}</td>
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
                </div>
            </div>
        </div>
    </div>
</div>