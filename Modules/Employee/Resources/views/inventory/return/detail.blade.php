<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    
    
 ?>
 @extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .datepicker{
            padding: 6px 12px;
           }
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    

@endsection

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

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-blue">{{ $sub_title }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{url('employee/asset-inventory/return/approve')}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <input class="form-control" type="hidden" id="id_asset_inventory_log" name="id_asset_inventory_log" value="{{$result['id_asset_inventory_log']}}" readonly/>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Code 
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode unik asset & inventory" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" name="code" value="{{$result['code']}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Type 
                            <i class="fa fa-question-circle tooltips" data-original-title="Type pengajuan atau type pengembalian" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" name="code" value="{{$result['type_asset_inventory']}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Category 
                            <i class="fa fa-question-circle tooltips" data-original-title="Categoru asset & inventory" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" name="code" value="{{$result['name_category_asset_inventory']}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Name Asset & Inventory 
                            <i class="fa fa-question-circle tooltips" data-original-title="Categoru asset & inventory" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" name="code" value="{{$result['name_asset_inventory']}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Quantity
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah asset & inventory yang dipinjam" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" name="code" value="{{$result['qty_logs']}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Approve By
                            <i class="fa fa-question-circle tooltips" data-original-title="User yang menerima pengajuan peminjaman asset & inventory" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" name="code" value="{{$result['name']??''}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Date Return
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal penerimaan pengajuan peminjaman asset & inventory" data-container="body"></i></label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="input-code" name="code" value="{{$result['date_return']??''}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Attachment Employee
                            <i class="fa fa-question-circle tooltips" data-original-title="file pengajuan asset & inventory" data-container="body"></i></label>
                        <div class="col-md-5">
                           
                    @if(empty($result['attachment']))
                                    <p style="margin-top: 2%">No file</p>
                            @else
                                    <a style="margin-top: 2%" class="btn blue btn-xs" href="{{env('STORAGE_URL_API').$result['attachment']}} "><i class="fa fa-download"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Status <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Status pengajuan asset & inventory" data-container="body"></i></label>
                        <div class="col-md-5">
                            <select class="form-control" type="text" id="input-status_asset_inventory" name="status_asset_inventory" required >
                             <option value="" >Select Status</option>
                             <option value="Approved" @if($result['status_asset_inventory']=="Approved") selected @endif>Approved</option>
                             <option value="Rejected" @if($result['status_asset_inventory']=="Rejected") selected @endif >Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Notes 
                            <i class="fa fa-question-circle tooltips" data-original-title="Status pengajuan asset & inventory" data-container="body"></i></label>
                        <div class="col-md-5">
                            <textarea  class="form-control" name="notes" placeholder="Notes" >{{$result['notes']??''}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Attachment Approve 
                           <i class="fa fa-question-circle tooltips" data-original-title="file pengajuan asset & inventory yang di upload oleh admin" data-container="body"></i></label>
                        <div class="col-md-5">
                            @if($result['status_asset_inventory']=="Pending") 
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="input-group input-large">
                                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                        <span class="fileinput-filename"> </span>
                                                </div>
                                                <span class="input-group-addon btn default btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" accept="image/png,image/jpg,image/jpeg,image/bmp" name="attachment" class="file" > </span>
                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        </div>
                                </div>
                    @else
                    @if(empty($result['attachment_logs']))
                                    <p style="margin-top: 2%">No file</p>
                            @else
                                    <a style="margin-top: 2%" class="btn blue btn-xs" href="{{env('STORAGE_URL_API').$result['attachment_logs']}} "><i class="fa fa-download"></i></a>
                            @endif
                     @endif
                        </div>
                    </div>
                    
                </div>
                    
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                         @if($result['status_asset_inventory']=="Pending") 
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                         @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
    


@endsection