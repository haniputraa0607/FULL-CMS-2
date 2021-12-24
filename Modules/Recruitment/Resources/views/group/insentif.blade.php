@yield('filter_insentif')
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">List Insentif</span>
                </div>
                <a href="#form_insentif" class="btn btn-sm blue" type="button" style="float:right" data-toggle="tab" >
                         Create Insentif
                    </a>
                    <a href="#table_insentif" class="btn btn-sm yellow active" type="button" style="float:right" data-toggle="tab" >
                        List Insentif
                    </a>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table_insentif">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                 
                                        <th class="text-nowrap text-center"> Name </th>
                                        <th class="text-nowrap text-center"> Insentif</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                        @if(!empty($insentif['data']))
                                        @foreach($insentif['data'] as $dt)
                                            <tr style="text-align: center" data-id="{{ $dt['id_hairstylist_group_insentif'] }}">
                                                <td>{{$dt['name_insentif']}}</td>
                                                <td>{{"Rp " . number_format($dt['price_insentif'],2,',','.')}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" style="text-align: center">Data Not Available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                             <div class="paginator-right">
                                @if ($insentif['data_paginator'])
                                   {{ $insentif['data_paginator']->links() }}
                               @endif  
                           </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="form_insentif">
                        <form class="form-horizontal" role="form" action="{{url('recruitment/hair-stylist/group/insentif/create')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_hairstylist_group" value="{{$result['id_hairstylist_group']}}">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Name Insentif<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Insentif" data-container="body"></i>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="name_insentif" placeholder="Masukkan nama insentif" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Price Insentif<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Besar Insentif" data-container="body"></i>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="price_insentif" placeholder="Masukkan nama insentif" class="form-control" required />
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