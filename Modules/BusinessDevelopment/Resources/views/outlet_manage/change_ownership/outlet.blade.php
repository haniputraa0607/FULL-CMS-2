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
                    <th class="text-nowrap text-center">Nama Outlet</th>
                    <th class="text-nowrap text-center">Code Outlet</th>
                    <th class="text-nowrap text-center">Address</th>
                </tr>
                </thead>
                <tbody style="text-align:center">
                        @php $i = 1;
                        @endphp
                        @foreach($result['outlet'] as $value)
                            <tr data-id="{{ $value['id_outlet'] }}">
                                <td>{{$i}}</td>
                                <td>{{$value['outlet_name']}}</td>
                                <td>{{$value['outlet_code']}}</td>
                                <td>{{$value['outlet_address']}}</td>
                            </tr>
                         @php $i++;
                        @endphp
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>