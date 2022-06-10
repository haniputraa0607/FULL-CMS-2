@php $out = $outlet[0]; @endphp
<div style="padding:10px 0" class="text-right">
    <a href="#modal_export" data-toggle="modal" class="btn btn-success">Export</a>
    <a href="#modal_stock_adjustment" data-toggle="modal" class="btn btn-primary">Stock Adjustment</a>
</div>
<table class="table datatable">
    <thead>
        <tr>
            <th @if(MyHelper::hasAccess([447], $grantedFeature)) width="300px" @endif>Product Icount</th>
            <th class="text-center">Unit</th>
            <th class="text-center">Stock</th>
            <th class="text-center">Report</th>
            @if(MyHelper::hasAccess([447], $grantedFeature))
            <th class="text-center">Conversion</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($out['product_icount_outlet_stocks'] ?? [] as $outlet_stock)
        <tr data-id="{{ $outlet_stock['id_product_icount'] }}_{{ $outlet_stock['unit'] }}">
            <td>{{ $outlet_stock['product_icount']['name'] }}</td>
            <td class="text-center unit">{{ $outlet_stock['unit'] }}</td>
            <td class="text-center qty">{{ $outlet_stock['stock'] }}</td>
            <td class="text-center"><a href="{{ url()->current() }}/report/{{ $outlet_stock['id_product_icount'] }}/{{ $outlet_stock['unit'] }}" class="btn btn-sm green">Report Stock</a></td>
            @if(MyHelper::hasAccess([447], $grantedFeature))
            <td class="text-center"><a href="javascript:conversion({{ $outlet_stock['id_product_icount'] }},'{{ $outlet_stock['product_icount']['name'] }}','{{ $outlet_stock['id_product_icount'] }}_{{ $outlet_stock['unit'] }}')" data-conv="{{ $outlet_stock['conversion'] }}" data-info="{{ $outlet_stock['info_conversion'] }}" class="btn btn-sm blue link">Convert</a></td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
<div class="modal fade bd-example-modal-sm" id="modal_stock_adjustment" role="dialog" aria-labelledby="stockAdjustmentModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Stock Adjustment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 15px !important">
                <form role="form" action="{{ url('outlet/detail') }}/{{ $outlet[0]['outlet_code'] }}/stock-adjustment" id="form_stock_adjustment_submit" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="row" style="margin-bottom:10px">
                            <label class="col-md-3 text-right" style="padding-top:5px">Title</label>
                            <div class="col-md-8">
                                <input name="title" class="form-control" placeholder="Write stock adjustment title" value="Stock Adjustment">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px">
                            <label class="col-md-3 text-right" style="padding-top:5px">Product Icount</label>
                            <div class="col-md-8">
                                <select class="select_product_icount" name="id_product_icount" data-placeholder="Select product icount" onchange="updateSelectUnit()"></select>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px">
                            <label class="col-md-3 text-right" style="padding-top:5px">Unit</label>
                            <div class="col-md-4">
                                <select class="select2" name="unit" data-placeholder="Select unit" onchange="unitSelected()"></select>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px">
                            <label class="col-md-3 text-right" style="padding-top:5px">Current Stock</label>
                            <div class="col-md-3">
                                <input type="number" class="form-control" name="current_stock" disabled>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px">
                            <label class="col-md-3 text-right" style="padding-top:5px">New Stock</label>
                            <div class="col-md-3">
                                <input type="number" class="form-control" name="new_stock" onchange="adjustStock('new_stock')" required>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px">
                            <label class="col-md-3 text-right" style="padding-top:5px">Stock Adjustment</label>
                            <div class="col-md-3">
                                <input type="number" class="form-control" name="stock_adjustment" onchange="adjustStock('stock_adjustment')" required>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px">
                            <label class="col-md-3 text-right" style="padding-top:5px">Notes</label>
                            <div class="col-md-8">
                                <textarea name="notes" class="form-control" placeholder="Write notes here"></textarea>
                            </div>
                        </div>
                    </div>
                    {{ csrf_field() }}
                </form>
                <div class= "output">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitStockAdjustment()">Submit</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-sm" id="modal_export" role="dialog" aria-labelledby="exportModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Export Product Icount to Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 15px !important">
                <form role="form" action="{{ url('outlet/detail') }}/{{ $outlet[0]['outlet_code'] }}/report-product-log" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="row" style="margin-bottom:10px">
                            <label class="col-md-4 text-right" style="padding-top:5px">From Date</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" id="start_date" class="datepicker form-control" name="start_date" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px">
                            <label class="col-md-4 text-right" style="padding-top:5px">To Date</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" id="start_date" class="datepicker form-control" name="end_date" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                {{ csrf_field() }}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

        </div>
    </div>
</div>