<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script>

        $('#hslist').on('draw.dt', function() {
            $('input[name="user_hair_stylist_status"]').bootstrapSwitch();
        });

        $('#hslist').on('switchChange.bootstrapSwitch', 'input[name="user_hair_stylist_status"]', function(event, state) {
            var id     = $(this).data('id');
            var token  = "{{ csrf_token() }}";
            if(state == true){
                state = 'Active'
            }else{
                state = 'Inactive'
            }
            $.ajax({
                type : "POST",
                url : "{{ url('recruitment/hair-stylist/update-status') }}",
                data : "_token="+token+"&id_user_hair_stylist="+id+"&user_hair_stylist_status="+state,
                success : function(result) {
                    if (result.status == "success") {
                        document.getElementById('atr-'+id).innerHTML = state;
                        toastr.info("Hair stylist status has been updated.");
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                }
            });
        });
    </script>
@endsection

@extends('layouts.main')

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $title }}</span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div><br>

    <h1 class="page-title" style="margin-top: 0px;">
        {{$sub_title}}
    </h1>
    @include('layouts.notifications')

    <?php
    $date_start = '';
    $date_end = '';

    if(Session::has('filter-hs-list')){
        $search_param = Session::get('filter-hs-list');
        if(isset($search_param['date_start'])){
            $date_start = $search_param['date_start'];
        }

        if(isset($search_param['date_end'])){
            $date_end = $search_param['date_end'];
        }

        if(isset($search_param['rule'])){
            $rule = $search_param['rule'];
        }

        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
        }
    }
    ?>

    <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
        {{ csrf_field() }}
        @include('recruitment::hair_stylist.filter_list')
    </form>

    <br>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">{{ $sub_title }}</span>
            </div>
            <button type="button" class="btn btn-sm green" data-toggle="modal" data-target="#modalUpload" style="float:right; margin-top: 5px;">Update Data</button>
        </div>
        <div class="portlet-body form">
            <div class="table-responsive">
                <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                    <table class="table table-striped table-bordered table-hover" id="hslist">
                        <thead>
                        <tr>
                            <th scope="col" width="10%"> Action </th>
                            <th scope="col" width="10%"> NIK </th>
                            <th scope="col" width="10%"> Join Date </th>
                            <th scope="col" width="10%"> Level </th>
                            <th scope="col" width="10%"> Status </th>
                            <th scope="col" width="10%"> Nickname </th>
                            <th scope="col" width="10%"> Full Name </th>
                            <th scope="col" width="10%"> Email </th>
                            <th scope="col" width="10%"> Phone </th>
                            <th scope="col" width="10%"> Gender </th>
                            <th scope="col" width="10%"> Outlet </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $val)
                                <tr>
                                    <td>
                                        @if(MyHelper::hasAccess([348,349], $grantedFeature))
                                            <a class="btn btn-sm btn-info" target="_blank" href="{{ url('recruitment/hair-stylist/detail', $val['id_user_hair_stylist']) }}"><i class="fa fa-edit"></i></a>
                                        @endif
                                    </td>
                                    <td>{{ $val['user_hair_stylist_code'] }}</td>
                                    <td>{{ date('d M Y H:i', strtotime($val['join_date'])) }}</td>
                                    <td>{{$val['level']}}</td>
                                    <td class="middle-center">
                                        <input type="checkbox" name="user_hair_stylist_status" @if($val['user_hair_stylist_status'] == 'Active') checked @endif data-id="{{ $val['id_user_hair_stylist'] }}" class="make-switch switch-change" data-size="small" data-on-text="Active" data-off-text="Inactive">
                                        <p style="display: none" id="atr-{{$val['id_user_hair_stylist']}}">{{$val['user_hair_stylist_status']}}</p>
                                    </td>
                                    <td>{{$val['nickname']}}</td>
                                    <td>{{$val['fullname']}}</td>
                                    <td>{{$val['email']}}</td>
                                    <td>{{$val['phone_number']}}</td>
                                    <td>{{$val['gender']}}</td>
                                    <td>{{($val['outlet'] ?? false) ? "{$val['outlet']['outlet_code']} - {$val['outlet']['outlet_name']}" : '-'}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
    <br>
    @if ($dataPaginator)
        {{ $dataPaginator->links() }}
    @endif

    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <div class="col-md-5">
                    <h4 class="modal-title" id="newCustomLink">Upload File</h4>
                </div>
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{ url('recruitment/hair-stylist/update-file') }}" method="post" role="form" id="modalCustomLink" enctype="multipart/form-data"> 
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-2">Link <span class="required" aria-required="true">*</span></label>
                        <div class="col-md-10">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="input-group input-large">
                                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                        <span class="fileinput-filename"> </span>
                                    </div>
                                    <span class="input-group-addon btn default btn-file">
                                        <span class="fileinput-new"> Select file </span>
                                        <span class="fileinput-exists"> Change </span>
										<input type="file" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                    </span>
                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>    
                <div class="modal-footer form-actions">
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn blue" id="submit_new_link">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection