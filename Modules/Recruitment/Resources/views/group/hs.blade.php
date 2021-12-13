<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">List Hair Stylist</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    
                    <div class="tab-pane active" id="hs">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                 
                                        <th scope="col" width="10%"> Nickname </th>
                                        <th scope="col" width="10%"> Full Name </th>
                                        <th scope="col" width="10%"> Email </th>
                                        <th scope="col" width="10%"> Phone </th>
                                        <th scope="col" width="10%"> Gender </th>
                                        <th scope="col" width="10%"> Outlet </th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                        @if(!empty($hs))
                                        @foreach($hs as $dt)
                                            <tr >
                                                <td>{{$dt['nickname']}}</td>
                                                <td>{{$dt['fullname']}}</td>
                                                <td>{{$dt['email']}}</td>
                                                <td>{{$dt['phone_number']}}</td>
                                                <td>{{$dt['gender']}}</td>
                                                <td>{{$dt['outlet_name']}}</td>
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
                </div>
            </div>
        </div>
    </div>
</div>