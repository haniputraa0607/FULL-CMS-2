@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/global.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script>
        var theory = 0;
        function addTheory() {
            var html =  '<div class="form-group" id="theory_'+theory+'" style="margin-left: 2%;">'+
                        '<div class="col-md-7">'+
                        '<input name="theory['+theory+'][title]" class="form-control" required placeholder="Theory Title">'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input name="theory['+theory+'][minimum_score]" class="form-control" required placeholder="Minimum Score">'+
                        '</div>'+
                        '<div class="col-md-2">'+
                        '<a class="btn btn-danger btn" onclick="deleteTheory('+theory+')">&nbsp;<i class="fa fa-trash"></i></a>'+
                        '</div>'+
                        '</div>';

            $("#div_theory").append(html);
            theory++;
        }

        function deleteTheory(number){
            $('#theory_'+number).remove();
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
                <span class="caption-subject font-blue sbold uppercase">{{$sub_title??""}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" id="form" role="form" action="{{url('theory/create')}}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-2">Category <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih kategori materi" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <select class="form-control select2" name="id_theory_category" required>
                                <option value="" selected disabled>Select Category</option>
                                @foreach($list_category as $category)
                                    @if(empty($category['child']))
                                        <option value="{{$category['id_theory_category']}}">{{$category['theory_category_name']}}</option>
                                    @else
                                        <optgroup label="{{$category['theory_category_name']}}">
                                            @foreach($category['child'] as $child)
                                                <option value="{{$child['id_theory_category']}}">{{$child['theory_category_name']}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <a class="btn btn-primary" onclick="addTheory()">&nbsp;<i class="fa fa-plus-circle"></i> Add Theory </a>
                        </div>
                    </div>
                    <div id="div_theory">
                    </div>
                </div>
                <div class="form-actions" style="text-align: center">
                    {{ csrf_field() }}
                    <button type="submit" class="btn blue">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
