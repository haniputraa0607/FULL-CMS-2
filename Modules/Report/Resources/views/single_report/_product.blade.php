<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption ">
            <span class="caption-subject sbold uppercase font-blue">Product</span>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-body">

            <div class="bg-grey-steel clearfix" style="padding-top: 15px; padding-bottom: 15px;">
                <div class="col-md-6">
                    <select class="form-control select2" id="product_outlet" name="id_outlet">
                        <option value="0">All Outlets</option>
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet['id_outlet'] }}">{{ $outlet['outlet_code'] ." - ". $outlet['outlet_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        	{{-- Chart --}}
            <div style="margin-top: 30px">
                <div class="tabbable tabbable-tabdrop">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_product_1" data-toggle="tab">Product</a>
                        </li>
                        <li>
                            <a href="#tab_product_2" data-toggle="tab">Gender</a>
                        </li>
                        <li>
                            <a href="#tab_product_3" data-toggle="tab">Age</a>
                        </li>
                        <li>
                            <a href="#tab_product_4" data-toggle="tab">Device</a>
                        </li>
                        <li>
                            <a href="#tab_product_5" data-toggle="tab">Provider</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_product_1">
                            <div id="product_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_product_2">
                            <div id="product_gender_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_product_3">
                            <div id="product_age_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_product_4">
                            <div id="product_device_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_product_5">
                            <div id="product_provider_chart" style="height:300px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px">
                <b>Date Range: {{ $date_range }}</b>
            </div>

            {{-- Card --}}
            <div class="row cards" style="margin-top: 30px">
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0">{{ $report['products']['product_total_nominal'] }}</span> </div>
                                <div class="desc"> 
                                Total Nominal (IDR)
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0">{{ $report['products']['product_total_qty'] }}</span> </div>
                                <div class="desc"> 
                                Total Quantity
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0">{{ $report['products']['product_total_male'] }}</span> </div>
                                <div class="desc"> 
                                Total Male Customer
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0">{{ $report['products']['product_total_female'] }}</span> </div>
                                <div class="desc"> 
                                Total Female Customer
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-wrapper" style="margin-top: 30px">
                <table class="table table-striped table-bordered table-hover table-checkable order-column">
                    <thead>
                        <tr>
                            <th> No </th>
                            <th> Date </th>
                            <th> Product </th>
                            <th> Total Recurring </th>
                            <th> Total (Qty) </th>
                            <th> Total Nominal (IDR) </th>
                            <th> Male Customer </th>
                            <th> Female Customer </th>
                            <th> Android </th>
                            <th> iOS </th>
                            <th> Telkomsel </th>
                            <th> XL </th>
                            <th> Indosat </th>
                            <th> Tri </th>
                            <th> Axis </th>
                            <th> Smart </th>
                            <th> Teens </th>
                            <th> Young Adult </th>
                            <th> Adult </th>
                            <th> Old </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report['products']['data'] as $key => $product)
                        <tr class="odd gradeX">
                            <td>{{ $key+1 }}</td>
                            <td>{{ $product['date'] }}</td>
                            <td>{{ $product['product']['product_name'] }}</td>
                            <td>{{ $product['total_rec'] }}</td>
                            <td>{{ $product['total_qty'] }}</td>
                            <td>{{ $product['total_nominal'] }}</td>
                            <td>{{ $product['cust_male'] }}</td>
                            <td>{{ $product['cust_female'] }}</td>
                            <td>{{ $product['cust_android'] }}</td>
                            <td>{{ $product['cust_ios'] }}</td>
                            <td>{{ $product['cust_telkomsel'] }}</td>
                            <td>{{ $product['cust_xl'] }}</td>
                            <td>{{ $product['cust_indosat'] }}</td>
                            <td>{{ $product['cust_tri'] }}</td>
                            <td>{{ $product['cust_axis'] }}</td>
                            <td>{{ $product['cust_smart'] }}</td>
                            <td>{{ $product['cust_teens'] }}</td>
                            <td>{{ $product['cust_young_adult'] }}</td>
                            <td>{{ $product['cust_adult'] }}</td>
                            <td>{{ $product['cust_old'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>