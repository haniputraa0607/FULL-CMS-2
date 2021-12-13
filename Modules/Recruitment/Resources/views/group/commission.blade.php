<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">List Commission</span>
                </div>
                     <a href="#form_desain" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="input-follow-up">
                         Create
                    </a>
                    <a href="#table_desain" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="back-follow-up">
                        List
                    </a>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    
                    <div class="tab-pane active" id="table_desain">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Name Product</th>
                                    <th class="text-nowrap text-center">Product Code</th>
                                    <th class="text-nowrap text-center">Commission</th>
                                    <th class="text-nowrap text-center">Action</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                        @if(!empty($commission))
                                        @foreach($commission as $dt)
                                            <tr data-id="{{ $dt['id_hairstylist_group_commission'] }}">
                                                <td>{{$dt['product_name']}}</td>
                                                <td>{{$dt['product_code']}}</td>
                                                <td>{{"Rp " . number_format($dt['commission_percent'],2,',','.')}}</td>
                                                <td><a href="{{ url('/recruitment/hair-stylist/group/commission/detail/'.$dt['id_enkripsi']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"></i> Detail</a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" style="text-align: center">Data Not Available</td>
                                        </tr>
                                    @endif
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="form_desain">
                        <form class="form-horizontal" role="form" action="{{url('recruitment/hair-stylist/group/commission/create')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_hairstylist_group" value="{{$result['id_hairstylist_group']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Product<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Product" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select required name="id_product" id="id_product" class="form-control input-sm select2" >
                                            <option value="">Select Product</option>
                                            @if(isset($product))
                                                @foreach($product as $row)
                                                        <option value="{{$row['id_product']}}">{{$row['product_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" required type="number" id="commission_percent" name="commission_percent" placeholder="Enter Commission"/>
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