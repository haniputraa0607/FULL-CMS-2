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
                                        <div class="col-md-4 name">Name </div>
                                        <div class="col-md-8 value">: {{$partner['id_partner']}}</div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row static-info">
                                        <div class="col-md-4 name">Email </div>
                                        <div class="col-md-8 value">: {{$partner['email']}}</div>
                                    </div>
                            </div>
                           </div>
                        </li>
                        <li>
                           <div class="row">
                            <div class="col-md-6">
                                <div class="row static-info">
                                        <div class="col-md-4 name">Phone </div>
                                        <div class="col-md-8 value">: {{$partner['phone']}}</div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row static-info">
                                        <div class="col-md-4 name">Address </div>
                                        <div class="col-md-8 value">: {{$partner['address']}}</div>
                                    </div>
                            </div>
                           </div>
                        </li>
                        <li>
                           <div class="row">
                            <div class="col-md-6">
                                <div class="row static-info">
                                        <div class="col-md-4 name">Start Contract </div>
                                        <div class="col-md-8 value">: {{date("d M Y", strtotime($partner['start_date']))}}</div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row static-info">
                                        <div class="col-md-4 name">End Contract</div>
                                        <div class="col-md-8 value">: {{date("d M Y", strtotime($partner['end_date']))}}</div>
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
                                            @if($partner['status'] == 'Active')
                                                <span class="badge" style="background-color: #26C281; color: #ffffff">{{$partner['status']}}</span>
                                            @elseif($partner['status'] == 'Inactive')
                                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #e1e445;padding: 5px 12px;color: #fff;">{{$partner['status']}}</span>
                                            @else
                                                <span class="badge" style="background-color: #EF1E31; color: #ffffff">{{$partner['status']}}</span>
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
                    <th class="text-nowrap text-center">Date</th>
                    <th class="text-nowrap text-center">Status</th>
                    <th class="text-nowrap text-center">Action</th>
                </tr>
                </thead>
                <tbody style="text-align:center">
                        @php $i = 1;
                        @endphp
                        @foreach($close_temporary as $value)
                            <tr data-id="{{ $value['id_partners_close_temporary'] }}">
                                <td>{{$i}}</td>
                                <td>{{$value['title']}}</td>
                                <td>{{date('d F Y', strtotime($value['close_date']))}}</td>
                                <td>
                                    @if($value['status'] == 'Success')
                                        <span class="badge" style="background-color: #26C281; color: #ffffff">{{$value['status']}}</span>
                                    @elseif($value['status'] == 'Process')
                                        <span class="badge" style="background-color: #e1e445; color: #ffffff">{{$value['status']}}</span>
                                    @else
                                        <span class="badge" style="background-color: #EF1E31; color: #ffffff">{{$value['status']}}</span>
                                    @endif
                                </td>
                                <td>
                                        <a href="{{ $value['detail'] }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"></i> Detail</a>
                                    @if($value['status'] == 'Process')
                                        <a href="{{ $value['reject'] }}" class="btn btn-sm red text-nowrap"><i class="fa fa-trash-o"></i> Reject</a>
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