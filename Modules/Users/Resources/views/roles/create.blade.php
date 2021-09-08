@extends('layouts.main-closed')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>

    <script>
        function checkAll(var1,var2){
            for(x=1;x<=var2;x++){
                var value = document.getElementById('module_'+var1).checked;
                if(value == true){
                    document.getElementById(var1+'_'+x).checked = true;
                } else {
                    document.getElementById(var1+'_'+x).checked = false;
                }
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
                <span class="caption-subject sbold uppercase font-blue">New Role</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form action="{{url('role/store')}}" role="form" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Role Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Role Name" data-container="body"></i>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <input type="text" placeholder="Role name" class="form-control" name="role_name" value="{{ old('role_name') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Department <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Department" data-container="body"></i>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-department" name="id_department" data-placeholder="Select department" required>
                                    <option></option>
                                    @foreach($departments as $department)
                                        <option value="{{$department['id_department']}}" @if(old('id_department') == $department['id_department']) selected @endif>{{$department['department_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Job Level <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Job Level" data-container="body"></i>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-job-level" name="id_job_level" data-placeholder="Select job level" required>
                                    <option></option>
                                    @foreach($job_levels as $jobLevel)
                                        <option value="{{$jobLevel['id_job_level']}}" @if(old('id_job_level') == $jobLevel['id_job_level']) selected @endif>{{$jobLevel['job_level_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div style="text-align: center"><h3>Feature</h3></div>
                    <hr>
                    <?php
                    $arrmodule = [];
                    foreach($feature_all as $all){
                        array_push($arrmodule, $all['feature_module']);
                    }
                    $arrmodule = array_unique($arrmodule);
                    ?>
                    @foreach($arrmodule as $key => $module)
                        <div class="form-group">
                            <label class="col-md-3 control-label"  style="margin-top: 10px;">{{$module}}</label>
                            <div class="md-checkbox-inline col-md-9" style="text-align:left">
                                <?php $x = 1; $y=0?>
                                @foreach($feature_all as $key2 => $feature)
                                    @if($feature['feature_module'] == $module)
                                        <?php
                                        $stat = false;
                                        ?>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}_{{$x}}" name="module[]" value="{{$feature['id_feature']}}" class="md-check checkbox{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}" onChange="checkSingle('{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}','{{$x}}')" @if($stat==true) checked @endif>
                                            <label for="{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}_{{$x}}">
                                                <span></span>
                                                <span class="check" style="margin-top: 10px;"></span>
                                                <span class="box" style="margin-top: 10px;"></span> {{$feature['feature_type']}}
                                            </label>
                                        </div>
                                        <?php $x++;?>
                                    @endif
                                @endforeach
                                <div class="md-checkbox">
                                    <input type="checkbox" class="md-check" onChange="checkAll('{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}','{{$x-1}}')" id="module_{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}" @if($y==$x-1) checked @endif>
                                    <label for="module_{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}">
                                        <span></span>
                                        <span class="check" style="margin-top: 10px;" onChange="checkAll('{{str_replace('&','_',str_replace(' ','-', strtolower($module)))}}','{{$x-1}}')"></span>
                                        <span class="box" style="margin-top: 10px;"></span> All {{$module}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="form-group">
                        <label class="col-md-3 control-label">Your Password</label>
                        <div class="col-md-4">
                            <input type="password" class="form-control" width="30%" maxlength="6" name="password_permission" placeholder="Enter Your current PIN" required style="width: 91.3%;">
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-4 col-md-5">
                                <button class="btn btn-lg blue btn-block"> Change Permission <i class="fa fa-check-circle "></i> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection