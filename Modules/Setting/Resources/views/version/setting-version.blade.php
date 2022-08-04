@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        function addTextReplace(id ,param){
            if (id == 'mobile') {
                var textvalue = $('#display_text_mobile').val();
                var textvaluebaru = textvalue+" "+param;
                $('#display_text_mobile').val(textvaluebaru);
            } else if (id == 'outlet') {
                var textvalue = $('#display_text_outlet').val();
                var textvaluebaru = textvalue+" "+param;
                $('#display_text_outlet').val(textvaluebaru);
            } else if (id == 'mitra') {
                var textvalue = $('#display_text_mitra').val();
                var textvaluebaru = textvalue+" "+param;
                $('#display_text_mitra').val(textvaluebaru);
            } else if (id == 'web') {
                var textvalue = $('#display_text_web').val();
                var textvaluebaru = textvalue+" "+param;
                $('#display_text_web').val(textvaluebaru);
            } else if (id == 'employee') {
                var textvalue = $('#display_text_employee').val();
                var textvaluebaru = textvalue+" "+param;
                $('#display_text_employee').val(textvaluebaru);
            }
        }
    </script>
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
                <span class="caption-subject font-blue bold uppercase">Version Control Setting</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-body">
                <div class="portlet-body">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_Android" data-toggle="tab" aria-expanded="true"> Android Setting </a>
                    </li>
                    <li class="">
                        <a href="#tab_IOS" data-toggle="tab" aria-expanded="false"> IOS Setting </a>
                    </li>
                    <li class="">
                        <a href="#tab_WebApps" data-toggle="tab" aria-expanded="false"> Web Apps Setting </a>
                    </li>
                    {{-- <li class="">
                        <a href="#tab_OutletApps" data-toggle="tab" aria-expanded="false"> Outlet Apps Setting </a>
                    </li> --}}
                    <li class="">
                        <a href="#tab_MitraApps" data-toggle="tab" aria-expanded="false"> Mitra Apps Android Setting </a>
                    </li>
                    <li class="">
                        <a href="#tab_MitraAppsIOS" data-toggle="tab" aria-expanded="false"> Mitra Apps IOS Setting </a>
                    </li>
                    <li class="">
                        <a href="#tab_EmployeeAndroids" data-toggle="tab" aria-expanded="false"> Employee Apps Android Setting </a>
                    </li>
                    <li class="">
                        <a href="#tab_EmployeeIOS" data-toggle="tab" aria-expanded="false"> Employee Apps IOS Setting </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> Display Setting
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="#tab_display_androidios" tabindex="-1" data-toggle="tab"> Android & IOS </a>
                            </li>
                            <li>
                                <a href="#tab_display_webapps" tabindex="-1" data-toggle="tab"> Web Apps </a>
                            </li>
                            {{-- <li>
                                <a href="#tab_display_outletapps" tabindex="-1" data-toggle="tab"> Outlet Apps </a>
                            </li> --}}
                            <li>
                                <a href="#tab_display_mitraapps" tabindex="-1" data-toggle="tab"> Mitra Apps </a>
                            </li>
                            <li>
                                <a href="#tab_display_employeeapps" tabindex="-1" data-toggle="tab"> Employee Apps </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tab_Android">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div id="addAndroid">
                                    <div class="mt-repeater" id="Android0">
                                        <div class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="col-md-12">
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('Android0')">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="Android[0][app_version]" required placeholder="Android Version">
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi aplikasi Android terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <select name="Android[0][rules]" class="form-control" placeholder="Rules For Different Verion" required>
                                                                <option disabled selected value="">Rules For Different Version</option>
                                                                <option value="1">Allowed</option>
                                                                <option value="0">Not Allowed</option>
                                                            </select>
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi Android yang digunakan berbeda dengan versi aplikasi Android terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-success mt-repeater-add" onclick="addVersion('Android')">
                                <i class="fa fa-plus"></i> Add New Version</a>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Playstore Link
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Link di playstore untuk download aplikasi Android terbaru" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" value="@if(isset($version['version_playstore'])){{ $version['version_playstore'] }}@endif" class="form-control" name="Android[version_playstore]" placeholder="Playstore Link">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Jumlah Versi Disupport
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum versi aplikasi yang disupport" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" value="@if(isset($version['version_max_android'])){{ $version['version_max_android'] }}@endif" class="form-control" name="Android[version_max_android]" placeholder="Input Jumlah">
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_IOS">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div id="addIOS">
                                    <div class="mt-repeater" id="IOS0">
                                        <div class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="col-md-12">
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('IOS0')">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="IOS[0][app_version]" required placeholder="IOS Version">
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi aplikasi IOS terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <select name="IOS[0][rules]" class="form-control" placeholder="Rules For Different Verion" required>
                                                                <option disabled selected value="">Rules For Different Verion</option>
                                                                <option value="1">Allowed</option>
                                                                <option value="0">Not Allowed</option>
                                                            </select>
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi IOS yang digunakan berbeda dengan versi aplikasi IOS terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-success mt-repeater-add" onclick="addVersion('IOS')">
                                <i class="fa fa-plus"></i> Add New Version</a>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Appstore Link
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Link di appstore untuk download aplikasi IOS terbaru" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="IOS[version_appstore]" value="@if(isset($version['version_appstore'])){{ $version['version_appstore'] }}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Jumlah Versi Disupport
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum versi aplikasi yang disupport" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" value="@if(isset($version['version_max_ios'])){{ $version['version_max_ios'] }}@endif" class="form-control" name="IOS[version_max_ios]" placeholder="Input Jumlah">
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_WebApps">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div id="addWebApp">
                                    <div class="mt-repeater" id="WebApp0">
                                        <div class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="col-md-12">
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('WebApp0')">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="WebApp[0][app_version]" required placeholder="Web Apps Version">
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi Web Apps terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <select name="WebApp[0][rules]" class="form-control" placeholder="Rules For Different Verion" required="">
                                                                <option disabled selected value="">Rules For Different Verion</option>
                                                                <option value="1">Allowed</option>
                                                                <option value="0">Not Allowed</option>
                                                            </select>
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi Web Apps yang digunakan berbeda dengan versi aplikasi Web Apps terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-success mt-repeater-add" onclick="addVersion('WebApp')">
                                <i class="fa fa-plus"></i> Add New Version</a>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Web Apps Link
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Link untuk download aplikasi Web Apps terbaru" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="WebApp[version_webstore]" value="@if(isset($version['version_webstore'])){{ $version['version_webstore'] }}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Jumlah Versi Disupport
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum versi aplikasi yang disupport" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" value="@if(isset($version['version_max_webapp'])){{ $version['version_max_webapp'] }}@endif" class="form-control" name="WebApp[version_max_webapp]" placeholder="Input Jumlah">
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_OutletApps">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div id="addOutletApp">
                                    <div class="mt-repeater" id="OutletApp0">
                                        <div class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="col-md-12">
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('OutletApp0')">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="OutletApp[0][app_version]" required placeholder="Outlet Apps Version">
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi Outlet Apps terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <select name="OutletApp[0][rules]" class="form-control" placeholder="Rules For Different Verion" required="">
                                                                <option disabled selected value="">Rules For Different Verion</option>
                                                                <option value="1">Allowed</option>
                                                                <option value="0">Not Allowed</option>
                                                            </select>
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi Outlet Apps yang digunakan berbeda dengan versi aplikasi Outlet Apps terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-success mt-repeater-add" onclick="addVersion('OutletApp')">
                                <i class="fa fa-plus"></i> Add New Version</a>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Outlet Apps Link
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Link untuk download aplikasi Outlet Apps terbaru" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="OutletApp[version_outletstore]" value="@if(isset($version['version_outletstore'])){{ $version['version_outletstore'] }}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Jumlah Versi Disupport
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum versi aplikasi yang disupport" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" value="@if(isset($version['version_max_outletapp'])){{ $version['version_max_outletapp'] }}@endif" class="form-control" name="OutletApp[version_max_outletapp]" placeholder="Input Jumlah">
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_MitraApps">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div id="addMitraApp">
                                    <div class="mt-repeater" id="MitraApp0">
                                        <div class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="col-md-12">
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('MitraApp0')">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="MitraApp[0][app_version]" required placeholder="Mitra Apps Version">
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi Mitra Apps terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <select name="MitraApp[0][rules]" class="form-control" placeholder="Rules For Different Verion" required="">
                                                                <option disabled selected value="">Rules For Different Verion</option>
                                                                <option value="1">Allowed</option>
                                                                <option value="0">Not Allowed</option>
                                                            </select>
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi Mitra Apps yang digunakan berbeda dengan versi aplikasi Mitra Apps terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-success mt-repeater-add" onclick="addVersion('MitraApp')">
                                <i class="fa fa-plus"></i> Add New Version</a>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Mitra Apps Playstore Link
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Link untuk download aplikasi Mitra Apps terbaru" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="MitraApp[version_mitrastore]" value="@if(isset($version['version_mitrastore'])){{ $version['version_mitrastore'] }}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Jumlah Versi Disupport
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum versi aplikasi yang disupport" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" value="@if(isset($version['version_max_mitraapp'])){{ $version['version_max_mitraapp'] }}@endif" class="form-control" name="MitraApp[version_max_mitraapp]" placeholder="Input Jumlah">
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_MitraAppsIOS">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div id="addMitraAppIOS">
                                    <div class="mt-repeater" id="MitraAppIOS0">
                                        <div class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="col-md-12">
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('MitraAppIOS0')">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="MitraAppIOS[0][app_version]" required placeholder="Mitra Apps IOS Version">
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi Mitra IOS Apps terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <select name="MitraAppIOS[0][rules]" class="form-control" placeholder="Rules For Different Verion" required="">
                                                                <option disabled selected value="">Rules For Different Verion</option>
                                                                <option value="1">Allowed</option>
                                                                <option value="0">Not Allowed</option>
                                                            </select>
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi Mitra Apps IOS yang digunakan berbeda dengan versi aplikasi Mitra Apps IOS terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-success mt-repeater-add" onclick="addVersion('MitraAppIOS')">
                                <i class="fa fa-plus"></i> Add New Version</a>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Mitra Apps Appstore Link
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Link untuk download aplikasi Mitra Apps IOS terbaru" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="MitraAppIOS[version_mitra_appstore]" value="@if(isset($version['version_mitra_appstore'])){{ $version['version_mitra_appstore'] }}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Jumlah Versi Disupport
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum versi aplikasi yang disupport" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" value="@if(isset($version['version_max_mitraapp_ios'])){{ $version['version_max_mitraapp_ios'] }}@endif" class="form-control" name="MitraAppIOS[version_max_mitraapp_ios]" placeholder="Input Jumlah">
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_EmployeeAndroids">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div id="addEmployeeAndroid">
                                    <div class="mt-repeater" id="EmployeeAndroid0">
                                        <div class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="col-md-12">
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('EmployeeAndroid0')">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="EmployeeAndroid[0][app_version]" required placeholder="Employee Apps Version">
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi Employee Apps terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <select name="EmployeeAndroid[0][rules]" class="form-control" placeholder="Rules For Different Verion" required="">
                                                                <option disabled selected value="">Rules For Different Verion</option>
                                                                <option value="1">Allowed</option>
                                                                <option value="0">Not Allowed</option>
                                                            </select>
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi Employee Apps yang digunakan berbeda dengan versi aplikasi Employee Apps terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-success mt-repeater-add" onclick="addVersion('EmployeeAndroid')">
                                <i class="fa fa-plus"></i> Add New Version</a>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Employee Apps Playstore Link
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Link untuk download aplikasi Employee Apps terbaru" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="EmployeeAndroid[version_employeestore]" value="@if(isset($version['version_employeestore'])){{ $version['version_employeestore'] }}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Jumlah Versi Disupport
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum versi aplikasi yang disupport" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" value="@if(isset($version['version_max_employeeapp'])){{ $version['version_max_employeeapp'] }}@endif" class="form-control" name="EmployeeAndroid[version_max_employeeapp]" placeholder="Input Jumlah">
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_EmployeeIOS">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div id="addEmployeeIOS">
                                    <div class="mt-repeater" id="EmployeeIOS0">
                                        <div class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="col-md-12">
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('EmployeeIOS0')">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="EmployeeIOS[0][app_version]" required placeholder="Employee Apps IOS Version">
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi Employee IOS Apps terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <select name="EmployeeIOS[0][rules]" class="form-control" placeholder="Rules For Different Verion" required="">
                                                                <option disabled selected value="">Rules For Different Verion</option>
                                                                <option value="1">Allowed</option>
                                                                <option value="0">Not Allowed</option>
                                                            </select>
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi Employee Apps IOS yang digunakan berbeda dengan versi aplikasi Employee Apps IOS terbaru" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-success mt-repeater-add" onclick="addVersion('EmployeeIOS')">
                                <i class="fa fa-plus"></i> Add New Version</a>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Employee Apps Appstore Link
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Link untuk download aplikasi Employee Apps IOS terbaru" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="EmployeeIOS[version_employee_appstore]" value="@if(isset($version['version_employee_appstore'])){{ $version['version_employee_appstore'] }}@endif">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-4 control-label">
                                        Jumlah Versi Disupport
                                        <!-- <span class="required" aria-required="true"> * </span>   -->
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimum versi aplikasi yang disupport" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" value="@if(isset($version['version_max_employeeapp_ios'])){{ $version['version_max_employeeapp_ios'] }}@endif" class="form-control" name="EmployeeIOS[version_max_employeeapp_ios]" placeholder="Input Jumlah">
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_display_androidios">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                Image
                                                <span class="required" aria-required="true"> * </span>
                                                <!--<br>-->
                                                <!-- <span class="required" aria-required="true"> (500*500) </span>  -->
                                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran persegi ditampilkan pada aplikasi" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                                    @if(isset($version['version_image_mobile']))
                                                    <img src="{{ env('STORAGE_URL_API')}}{{$version['version_image_mobile']}}" alt="">
                                                    @else
                                                    <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                    @endif
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="file" id="field_image_square" class="file" accept="image/*" data-jenis="square" name="Display[version_image_mobile]">

                                                        </span>

                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Kalimat yang akan ditampilkan pada aplikasi ketika versi aplikasi yang digunakan berbeda dengan versi terbaru" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="Display[version_text_alert_mobile]" required id="display_text_mobile">@if(isset($version['version_text_alert_mobile'])){{ $version['version_text_alert_mobile'] }}@endif</textarea>
                                                <br>
                                                You can use this variables to display version app :
                                                <br><br>
                                                <div class="row">
                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                        <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '%version_app%' with the latest version for the device used" onClick="addTextReplace('mobile', '%version_app%');">version app</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Button Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Teks pada button yang akan langsung menuju ke playstore / appstore" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="Display[version_text_button_mobile]" value="@if(isset($version['version_text_button_mobile'])){{ $version['version_text_button_mobile'] }}@endif" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_display_webapps">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                Image
                                                <span class="required" aria-required="true"> * </span>
                                                <!--<br>-->
                                                <!-- <span class="required" aria-required="true"> (500*500) </span>  -->
                                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran persegi ditampilkan pada aplikasi" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                                    @if(isset($version['version_image_web']))
                                                    <img src="{{ env('STORAGE_URL_API')}}{{$version['version_image_web']}}" alt="">
                                                    @else
                                                    <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                    @endif
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="file" id="field_image_square" class="file" accept="image/*" data-jenis="square" name="Display[version_image_web]">

                                                        </span>

                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Kalimat yang akan ditampilkan pada aplikasi ketika versi aplikasi yang digunakan berbeda dengan versi terbaru" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="Display[version_text_alert_web]" required id="display_text_web">@if(isset($version['version_text_alert_web'])){{ $version['version_text_alert_web'] }}@endif</textarea>
                                                <br>
                                                You can use this variables to display version app :
                                                <br><br>
                                                <div class="row">
                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                        <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '%version_app%' with the latest version for the device used" onClick="addTextReplace('web', '%version_app%');">version app</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Button Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Teks pada button yang akan langsung menuju ke playstore / appstore" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="Display[version_text_button_web]" value="@if(isset($version['version_text_button_web'])){{ $version['version_text_button_web'] }}@endif" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_display_outletapps">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                Image
                                                <span class="required" aria-required="true"> * </span>
                                                <!--<br>-->
                                                <!-- <span class="required" aria-required="true"> (500*500) </span>  -->
                                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran persegi ditampilkan pada aplikasi" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                                    @if(isset($version['version_image_outlet']))
                                                    <img src="{{ env('STORAGE_URL_API')}}{{$version['version_image_outlet']}}" alt="">
                                                    @else
                                                    <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                    @endif
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="file" id="field_image_square" class="file" accept="image/*" data-jenis="square" name="Display[version_image_outlet]">

                                                        </span>

                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Kalimat yang akan ditampilkan pada aplikasi ketika versi aplikasi yang digunakan berbeda dengan versi terbaru" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="Display[version_text_alert_outlet]" required id="display_text_outlet">@if(isset($version['version_text_alert_outlet'])){{ $version['version_text_alert_outlet'] }}@endif</textarea>
                                                <br>
                                                You can use this variables to display version app :
                                                <br><br>
                                                <div class="row">
                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                        <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '%version_app%' with the latest version for the device used" onClick="addTextReplace('outlet', '%version_app%');">version app</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Button Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Teks pada button yang akan langsung menuju ke playstore / appstore" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="Display[version_text_button_outlet]" value="@if(isset($version['version_text_button_outlet'])){{ $version['version_text_button_outlet'] }}@endif" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_display_mitraapps">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                Image
                                                <span class="required" aria-required="true"> * </span>
                                                <!--<br>-->
                                                <!-- <span class="required" aria-required="true"> (500*500) </span>  -->
                                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran persegi ditampilkan pada aplikasi" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                                    @if(isset($version['version_image_mitra']))
                                                    <img src="{{ env('STORAGE_URL_API')}}{{$version['version_image_mitra']}}" alt="">
                                                    @else
                                                    <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                    @endif
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="file" id="field_image_square" class="file" accept="image/*" data-jenis="square" name="Display[version_image_mitra]">

                                                        </span>

                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Kalimat yang akan ditampilkan pada aplikasi ketika versi aplikasi yang digunakan berbeda dengan versi terbaru" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="Display[version_text_alert_mitra]" required id="display_text_mitra">@if(isset($version['version_text_alert_mitra'])){{ $version['version_text_alert_mitra'] }}@endif</textarea>
                                                <br>
                                                You can use this variables to display version app :
                                                <br><br>
                                                <div class="row">
                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                        <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '%version_app%' with the latest version for the device used" onClick="addTextReplace('mitra', '%version_app%');">version app</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Button Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Teks pada button yang akan langsung menuju ke playstore / appstore" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="Display[version_text_button_mitra]" value="@if(isset($version['version_text_button_mitra'])){{ $version['version_text_button_mitra'] }}@endif" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_display_employeeapps">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                Image
                                                <span class="required" aria-required="true"> * </span>
                                                <!--<br>-->
                                                <!-- <span class="required" aria-required="true"> (500*500) </span>  -->
                                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran persegi ditampilkan pada aplikasi" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                                    @if(isset($version['version_image_employee']))
                                                    <img src="{{ env('STORAGE_URL_API')}}{{$version['version_image_employee']}}" alt="">
                                                    @else
                                                    <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                    @endif
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="file" id="field_image_square" class="file" accept="image/*" data-jenis="square" name="Display[version_image_employee]">

                                                        </span>

                                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Kalimat yang akan ditampilkan pada aplikasi ketika versi aplikasi yang digunakan berbeda dengan versi terbaru" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="Display[version_text_alert_employee]" required id="display_text_employee">@if(isset($version['version_text_alert_employee'])){{ $version['version_text_alert_employee'] }}@endif</textarea>
                                                <br>
                                                You can use this variables to display version app :
                                                <br><br>
                                                <div class="row">
                                                    <div class="col-md-3" style="margin-bottom:5px;">
                                                        <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '%version_app%' with the latest version for the device used" onClick="addTextReplace('employee', '%version_app%');">version app</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-4 control-label">
                                                    Button Text
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Teks pada button yang akan langsung menuju ke playstore / appstore" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="Display[version_text_button_employee]" value="@if(isset($version['version_text_button_employee'])){{ $version['version_text_button_employee'] }}@endif" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var noAndroid = 1;
                var noIOS = 1;
                var noOutletApp = 1;
                var noMitraApp = 1;
                var noMitraAppIOS = 1;
                var noEmployeeAndroid = 1;
                var noEmployeeIOS = 1;
                var noWebApp = 1;

                window.onload = function(event) {
                    var android = JSON.parse('{!! json_encode($version["Android"]) !!}');
                    var ios = JSON.parse('{!! json_encode($version["IOS"]) !!}');
                    var outlet = JSON.parse('{!! json_encode($version["OutletApp"]) !!}');
                    var mitra = JSON.parse('{!! json_encode($version["MitraApp"]) !!}');
                    var mitraIos = JSON.parse('{!! json_encode($version["MitraAppIOS"]) !!}');
                    var employee = JSON.parse('{!! json_encode($version["EmployeeAndroid"]) !!}');
                    var employeeIos = JSON.parse('{!! json_encode($version["EmployeeIOS"]) !!}');
                    var web = JSON.parse('{!! json_encode($version["WebApp"]) !!}');
                    if (android.length != 0) {
                        android.forEach(function(entry) {
                            $('#Android0').remove()
                            appendData('Android', 'Android', noAndroid, 'version_android', entry.app_version, entry.rules);
                            noAndroid++;
                        });
                    } if (ios.length != 0) {
                        ios.forEach(function(entry) {
                            $('#IOS0').remove()
                            appendData('IOS', 'IOS', noIOS, 'version_ios', entry.app_version, entry.rules);
                            noIOS++;
                        });
                    } if (outlet.length != 0) {
                        outlet.forEach(function(entry) {
                            $('#OutletApp0').remove()
                            appendData('OutletApp', 'Outlet Apps', noOutletApp, 'version_outletapp', entry.app_version, entry.rules);
                            noOutletApp++;
                        });
                    } if (mitra.length != 0) {
                        mitra.forEach(function(entry) {
                            $('#MitraApp0').remove()
                            appendData('MitraApp', 'Mitra Apps', noMitraApp, 'version_mitraapp', entry.app_version, entry.rules);
                            noMitraApp++;
                        });
                    } if (mitraIos.length != 0) {
                        mitraIos.forEach(function(entry) {
                            $('#MitraAppIOS0').remove()
                            appendData('MitraAppIOS', 'Mitra Apps IOS', noMitraAppIOS, 'version_mitraapp_ios', entry.app_version, entry.rules);
                            noMitraAppIOS++;
                        });
                    } if (employee.length != 0) {
                        employee.forEach(function(entry) {
                            $('#EmployeeAndroid0').remove()
                            appendData('EmployeeAndroid', 'Employee Apps', noEmployeeAndroid, 'version_employeeapp', entry.app_version, entry.rules);
                            noEmployeeAndroid++;
                        });
                    } if (employeeIos.length != 0) {
                        employeeIos.forEach(function(entry) {
                            $('#EmployeeIOS0').remove()
                            appendData('EmployeeIOS', 'Employee Apps IOS', noEmployeeIOS, 'version_employeeapp_ios', entry.app_version, entry.rules);
                            noEmployeeIOS++;
                        });
                    } if (web.length != 0) {
                        web.forEach(function(entry) {
                            $('#WebApp0').remove()
                            appendData('WebApp', 'Web Apps', noWebApp, 'version_webapp', entry.app_version, entry.rules);
                            noWebApp++;
                        });
                    }
                };

                function appendData(id, device, number, name, version, rules) {
                    var allow = ''
                    var not_allow = ''
                    if (rules == 1) {
                        var allow = 'selected'
                    } else if (rules == 0) {
                        var not_allow = 'selected'
                    }
                    $("#add"+id).append(
                        '<div class="mt-repeater" id="'+id+number+'">'+
                            '<div class="mt-repeater-item mt-overflow">'+
                                '<div class="mt-repeater-cell">'+
                                    '<div class="col-md-12">'+
                                        '<div class="col-md-1">'+
                                            '<a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition(`'+id+number+'`)">'+
                                                '<i class="fa fa-close"></i>'+
                                            '</a>'+
                                        '</div>'+
                                        '<div class="col-md-5">'+
                                            '<div class="input-group">'+
                                                '<input type="text" class="form-control" name="'+id+'['+number+'][app_version]" value="'+version+'" required placeholder="'+device+' Version">'+
                                                '<span class="input-group-addon">'+
                                                    '<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi aplikasi '+device+' terbaru" data-container="body"></i>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-6">'+
                                            '<div class="input-group">'+
                                                '<select name="'+id+'['+number+'][rules]" class="form-control" placeholder="Rules For Different Verion" required>'+
                                                    '<option disabled selected value="">Rules For Different Version</option>'+
                                                    '<option '+allow+' value="1">Allowed</option>'+
                                                    '<option '+not_allow+' value="0">Not Allowed</option>'+
                                                '</select>'+
                                                '<span class="input-group-addon">'+
                                                    '<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi '+device+' yang digunakan berbeda dengan versi aplikasi '+device+' terbaru" data-container="body"></i>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );
                    $('.tooltips').tooltip()
                }


                function dataAppend(item) {
                    if (item.app_type == "Android") {
                        appendDiv('Android', 'Android', noAndroid, 'version_android')
                        noAndroid++;
                    } if (item.app_type == "IOS") {
                        appendDiv('IOS', 'IOS', noIOS, 'version_ios')
                        noIOS++;
                    } if (item.app_type == "OutletApp") {
                        appendDiv('OutletApp', 'Outlet Apps', noOutletApp, 'version_outletapp')
                        noOutletApp++;
                    } if (item.app_type == "MitraApp") {
                        appendDiv('MitraApp', 'Mitra Apps', noMitraApp, 'version_mitraapp')
                        noMitraApp++;
                    } if (item.app_type == "MitraAppIOS") {
                        appendDiv('MitraAppIOS', 'Mitra Apps IOS', noMitraAppIOS, 'version_mitraapp_ios')
                        noMitraAppIOS++;
                    } if (item.app_type == "EmployeeAndroid") {
                        appendDiv('EmployeeAndroid', 'Employee Apps', noEmployeeAndroid, 'version_employeeapp')
                        noEmployeeAndroid++;
                    } if (item.app_type == "EmployeeIOS") {
                        appendDiv('EmployeeIOS', 'Employee Apps IOS', noEmployeeIOS, 'version_employeeapp_ios')
                        noEmployeeIOS++;
                    } if (item.app_type == "WebApp") {
                        appendDiv('WebApp', 'Web Apps', noWebApp, 'version_webapp')
                        noWebApp++;
                    }
                }

                function addVersion(id){
                    if (id == "Android") {
                        appendDiv('Android', 'Android', noAndroid, 'version_android')
                        noAndroid++;
                    } if (id == "IOS") {
                        appendDiv('IOS', 'IOS', noIOS, 'version_ios')
                        noIOS++;
                    } if (id == "OutletApp") {
                        appendDiv('OutletApp', 'Outlet Apps', noOutletApp, 'version_outletapp')
                        noOutletApp++;
                    } if (id == "MitraApp") {
                        appendDiv('MitraApp', 'Mitra Apps', noMitraApp, 'version_mitraapp')
                        noMitraApp++;
                    } if (id == "MitraAppIOS") {
                        appendDiv('MitraAppIOS', 'Mitra Apps IOS', noMitraAppIOS, 'version_mitraapp_ios')
                        noMitraAppIOS++;
                    } if (id == "EmployeeAndroid") {
                        appendDiv('EmployeeAndroid', 'Employee Apps', noEmployeeAndroid, 'version_employeeapp')
                        noEmployeeAndroid++;
                    } if (id == "EmployeeIOS") {
                        appendDiv('EmployeeIOS', 'Employee Apps IOS', noEmployeeIOS, 'version_employeeapp_ios')
                        noEmployeeIOS++;
                    } if (id == "WebApp") {
                        appendDiv('WebApp', 'Web Apps', noWebApp, 'version_webapp')
                        noWebApp++;
                    }
                }

                function appendDiv(id, device, number, name) {
                    $("#add"+id).append(
                        '<div class="mt-repeater" id="'+id+number+'">'+
                            '<div class="mt-repeater-item mt-overflow">'+
                                '<div class="mt-repeater-cell">'+
                                    '<div class="col-md-12">'+
                                        '<div class="col-md-1">'+
                                            '<a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition(`'+id+number+'`)">'+
                                                '<i class="fa fa-close"></i>'+
                                            '</a>'+
                                        '</div>'+
                                        '<div class="col-md-5">'+
                                            '<div class="input-group">'+
                                                '<input type="text" class="form-control" name="'+id+'['+number+'][app_version]" value="@if(isset($version['+name+'])){{ $version['+name+'] }}@endif" required placeholder="'+device+' Version">'+
                                                '<span class="input-group-addon">'+
                                                    '<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Versi aplikasi '+device+' terbaru" data-container="body"></i>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-6">'+
                                            '<div class="input-group">'+
                                                '<select name="'+id+'['+number+'][rules]" class="form-control" placeholder="Rules For Different Verion" required>'+
                                                    '<option disabled selected value="">Rules For Different Version</option>'+
                                                    '<option value="1">Allowed</option>'+
                                                    '<option value="0">Not Allowed</option>'+
                                                '</select>'+
                                                '<span class="input-group-addon">'+
                                                    '<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Aturan jika versi aplikasi '+device+' yang digunakan berbeda dengan versi aplikasi '+device+' terbaru" data-container="body"></i>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );
                    $('.tooltips').tooltip()
                }
                function deleteCondition(response) {
                    $('#'+response).remove()
                }
            </script>
            </div>
        </div>
    </div>
@endsection