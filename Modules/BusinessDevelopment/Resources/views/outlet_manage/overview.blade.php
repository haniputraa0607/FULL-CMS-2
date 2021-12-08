<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@php
    $datenow = date("Y-m-d H:i:s");
@endphp
<div class="portlet-body form">
    <div style="white-space: nowrap;">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                <thead>
                <tr>
                    <th class="text-nowrap text-center">No</th>
                    <th class="text-nowrap text-center">Name</th>
                    <th class="text-nowrap text-center">Code</th>
                    <th class="text-nowrap text-center">Kota</th>
                    <th class="text-nowrap text-center">Status</th>
                    <th class="text-nowrap text-center">Action</th>
                </tr>
                </thead>
                <tbody style="text-align:center">
                        @php $i = 1;
                        @endphp
                        @foreach($outlet as $value)
                            <tr data-id="{{ $value['id_outlet'] }}">
                                <td>{{$i}}</td>
                                <td>{{$value['outlet_name']}}</td>
                                <td>{{$value['outlet_code']}}</td>
                                <td>{{$value['city_name']}}</td>
                                <td>
                                    <span class="sale-num sbold badge badge-pill" style="font-size: 16px!important;height: 30px!important;background-color: @if($value['status_warna']==2)red @elseif($value['status_warna']==1) blue @else #00FF00  @endif;padding: 5px 12px;color: #fff;">{{$value['status_outlet']}}</span>
                                    
                                </td>
                                <td>
                                        @if(isset($value['name_button']))
                                        <a href="{{$value['url_detail']}}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"></i>{{$value['name_button']}}</a>
                                        @endif
                                        @if(isset($value['name_button_close']))
                                        <a href="{{$value['url_detail_close']}}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"></i>{{$value['name_button_close']}}</a>
                                        @endif
                                        @if(empty($value['name_button'])&&empty($value['name_button_close']))
                                        <span class="sale-num sbold badge badge-pill" style="font-size: 16px!important;height: 30px!important;background-color: #808080;padding: 5px 12px;color: #fff;"> No Action</span>
                                        @endif
                                        
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