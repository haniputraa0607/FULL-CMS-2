@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
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
    <script type="text/javascript">
    $('.select2').select2();
    function changeSelect(){
        setTimeout(function(){
            $(".select2").select2({
                placeholder: "Search"
            });
        }, 100);
    }
    @if(!is_array($conditions) || count($conditions) <= 0)
	var noRule = 1;
			@else
	var noRule = {{count($conditions)}};
	@endif

    function addRule(){
		$("#div-rule").append(
			'<div class="rule'+noRule+'">'+
            '<div class="form-group mt-repeater">'+
            '<div data-repeater-item class="mt-repeater-item">'+
            '<div class="form-group">'+
            '<label class="col-md-2 control-label">Category '+
            '<i class="fa fa-question-circle tooltips" data-original-title="Masukan Kategori Pertanyaan" data-container="body"></i>'+
            '</label>'+
            '<div class="col-md-8">'+
            '<input class="form-control" type="text" value="" name="category['+noRule+'][cat]" placeholder="Enter Category here" required/>'+
            '</div>'+
            '</div>'+
            '<div class="mt-repeater">'+
            '<div class="mt-repeater-cell">'+
            '<div id="div-category'+noRule+'">'+
            '<div id="category'+noRule+'0">'+
            '<div class="form-group">'+
            '<label class="col-md-3 control-label">Question '+
            '<i class="fa fa-question-circle tooltips" data-original-title="Masukan Pertanyaan" data-container="body"></i>'+
            '</label>'+
            '<div class="col-md-9">'+
            '<textarea class="form-control" placeholder="Enter Question here" name="category['+noRule+'][question][0]" required></textarea>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '<div class="form-action col-md-12">'+
            '<div class="col-md-3"></div>'+
            '<div class="col-9">'+
            '<a id="btnAddCondition'+noRule+'" href="javascript:;" class="btn btn-info mt-repeater-add" onClick="changeSelect();addCondition('+noRule+', 1)">'+
            '<i class="fa fa-plus"></i> Add New Question</a>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>'
		);
		noRule++;
	}    

    function addCondition(no, noCond){
		$(
            '<div id="category'+no+noCond+'">'+
            '<div class="form-group">'+
            '<label class="col-md-3 control-label">Question '+
            '<i class="fa fa-question-circle tooltips" data-original-title="Masukan Pertanyaan" data-container="body"></i>'+
            '</label>'+
            '<div class="col-md-9">'+
            '<textarea class="form-control" placeholder="Enter Question here" name="category['+no+'][question]['+noCond+']" required></textarea>'+
            '</div>'+
            '</div>'+
            '</div>'
		).appendTo($('#div-category'+no)).slideDown("slow")
		noCond = parseInt(noCond) + 1
		$('#btnAddCondition'+no).attr('onclick', 'changeSelect();addCondition('+no+','+noCond+')');
	}

    $(document).ready(function() {
        $(document).ready(function () {
            $('.colorpicker').minicolors({
                format: 'hex',
                theme: 'bootstrap'
            })
        });
    });
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
                <span class="caption-subject font-dark sbold uppercase font-blue">New Form Survey</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form id="form-sorting" class="form-horizontal" role="form" action="{{ url('businessdev/form-survey/create') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group mt-repeater" style="margin-bottom: 0px; !important">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Brand
                                <span class="required" aria-required="true"> *
                                </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukan Kategori Pertanyaan" data-container="body"></i>
                            </label>
                            <div class="col-md-8">
                                <select name="id_brand" class="form-control input-sm select2" placeholder="Select Brand" style="width:100%" required>
                                    <option value="" selected disabled></option>
                                    @foreach($brand as $b)
                                        <option value="{{$b['id_brand']}}">{{$b['name_brand']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="div-rule">
                        <div class="rule0">
                            <div class="form-group mt-repeater">
                                <div data-repeater-item class="mt-repeater-item">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Category
                                            <i class="fa fa-question-circle tooltips" data-original-title="Masukan Pertanyaan" data-container="body"></i>
                                        </label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" value="" name="category[0][cat]" placeholder="Enter Category here" required/>
                                        </div>
                                    </div>
                                    <div class="mt-repeater">
                                        <div class="mt-repeater-cell">
                                            <div id="div-category0">
                                                <div id="category00">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Question
                                                            <i class="fa fa-question-circle tooltips" data-original-title="Masukan Pertanyaan" data-container="body"></i>
                                                        </label>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control" placeholder="Enter Question here" name="category[0][question][0]" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-action col-md-12">
                                                <div class="col-md-3"></div>
                                                <div class="col-9">
                                                    <a id="btnAddCondition0" href="javascript:;" class="btn btn-info mt-repeater-add" onClick="changeSelect();addCondition(0, 1)">
                                                        <i class="fa fa-plus"></i> Add New Question</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <a href="javascript:;" class="btn btn-success mt-repeater-add" onClick="addRule();changeSelect()">
                                <i class="fa fa-plus"></i> Add New Category</a>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection