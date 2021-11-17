<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@php
    $datenow = date("Y-m-d H:i:s");
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="portlet profile-info portlet light bordered">
            <div class="portlet sale-summary">
                <div class="portlet-body">
                    <ul class="list-unstyled">
                        <li>
                           <div class="row">
                            <div class="col-md-6">
                                 <div class="row static-info">
                                        <div class="col-md-4 name">Name Outlet</div>
                                        <div class="col-md-8 value">: {{$outlet['outlet_name']}}</div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row static-info">
                                        <div class="col-md-4 name">Outlet Email </div>
                                        <div class="col-md-8 value">: {{$outlet['outlet_email']}}</div>
                                    </div>
                            </div>
                           </div>
                        </li>
                        <li>
                           <div class="row">
                            <div class="col-md-6">
                                <div class="row static-info">
                                        <div class="col-md-4 name">Phone </div>
                                        <div class="col-md-8 value">: {{$outlet['outlet_phone']}}</div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row static-info">
                                        <div class="col-md-4 name">Outlet Address </div>
                                        <div class="col-md-8 value">: {{$outlet['outlet_address']}}</div>
                                    </div>
                            </div>
                           </div>
                        </li>
                        <li>
                           <div class="row">
                            <div class="col-md-6">
                                <div class="row static-info">
                                        <div class="col-md-4 name">Status </div>
                                        <div class="col-md-8 value">: 
                                            @if($outlet['outlet_status'] == 'Active')
                                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">{{$outlet['outlet_status']}}</span>
                                            @elseif($outlet['outlet_status'] == 'Inactive')
                                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #e1e445;padding: 5px 12px;color: #fff;">{{$outlet['outlet_status']}}</span>
                                            @else
                                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #EF1E31;padding: 5px 12px;color: #fff;">{{$outlet['outlet_status']}}</span>
                                            @endif
                                        </div>
                                    </div>
                            </div>
                           </div>
                        </li>
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    
</div>
<div class="portlet-body form">
    <div style="white-space: nowrap;">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                <thead>
                <tr>
                    <th class="text-nowrap text-center">No</th>
                    <th class="text-nowrap text-center">Title</th>
                    <th class="text-nowrap text-center">Note</th>
                    <th class="text-nowrap text-center">Jenis</th>
                    <th class="text-nowrap text-center">Status</th>
                    <th class="text-nowrap text-center">Date Close</th>
                    <th class="text-nowrap text-center">Created At</th>
                    <th class="text-nowrap text-center">Action</th>
                </tr>
                </thead>
                <tbody style="text-align:center">
                        @php $i = 1;
                        @endphp
                        @foreach($result as $value)
                           <tr data-id="{{ $value['id_outlet_close_temporary'] }}">
                                <td>{{$i}}</td>
                                <td>{{$value['title']}}</td>
                                <td>{{$value['note']}}</td>
                                <td>
                                     @if($value['jenis']=='Close')
                                     <span class="sale-num sbold badge badge-pill" style="font-size: 16px!important;height: 30px!important;background-color: red;padding: 5px 12px;color: #fff;">Close</span>
                                        @else
                                        <span class="sale-num sbold badge badge-pill" style="font-size: 16px!important;height: 30px!important;background-color: greenyellow;padding: 5px 12px;color: #fff;">Aktivasi</span>
                                    @endif
                                </td>
                                <td>
                                     @if($value['status']=='Process'||$value['status']=='Waiting')
                                     <span class="sale-num sbold badge badge-pill" style="font-size: 16px!important;height: 30px!important;background-color: lightblue;padding: 5px 12px;color: #fff;">{{$value['status']}}</span>
                                        @elseif($value['status']=='Process')
                                        <span class="sale-num sbold badge badge-pill" style="font-size: 16px!important;height: 30px!important;background-color: greenyellow;padding: 5px 12px;color: #fff;">{{$value['status']}}</span>
                                        @else
                                        <span class="sale-num sbold badge badge-pill" style="font-size: 16px!important;height: 30px!important;background-color: red;padding: 5px 12px;color: #fff;">{{$value['status']}}</span>
                                    @endif
                                </td>
                                <td>{{date('d F Y', strtotime($value['date']))}}</td>
                                <td>{{date('d F Y', strtotime($value['created_at']))}}</td>
                                
                                <td>
                                    <a class="btn btn-sm sweetalert-document-info btn-primary" href="{{$value['url_detail']}}"><i class="fa fa-search"></i> Detail</a>
                                </td>
                            </tr>
                         @php $i++;
                        @endphp
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>