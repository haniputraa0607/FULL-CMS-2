@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-minicolors/jquery.minicolors.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-color-pickers.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    $('.select2').select2();
    function changeSelect(){
        setTimeout(function(){
            $(".select2").select2({
                placeholder: "Search"
            });
        }, 100);
    }

    function addRule(noRule){
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
            '<div>'+
            '<a class="btn btn-danger btn" onclick="deleteRule('+noRule+')">Delete Category</a>'+
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
            '<div class="col-md-8">'+
            '<textarea class="form-control" placeholder="Enter Question here" name="category['+noRule+'][question][0]" required></textarea>'+
            '</div>'+
            '<div class="col-md-1">'+
            '<a class="btn btn-danger btn" onclick="deleteCondition(`'+noRule.toString()+'0`,`'+noRule.toString()+'`)">&nbsp;<i class="fa fa-trash"></i></a>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '<div class="form-action col-md-12">'+
            '<div class="col-md-3"></div>'+
            '<div class="col-9">'+
            '<a id="btnAddCondition'+noRule+'" href="javascript:;" class="btn btn-info mt-repeater-add" onClick="changeSelect();addCondition('+noRule+', 0)">'+
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

    function deleteRule(no){
		if(no==0){
            alert('This Category cant be deleted');
        }else{
            if(confirm('Are you sure you want to delete this category?')) {
                $('.rule'+no).remove()
            }
        }
	}

    function addCondition(no, noCond){
        noCond = parseInt(noCond) + 1;
		$(
            '<div id="category'+no+noCond+'">'+
            '<div class="form-group">'+
            '<label class="col-md-3 control-label">Question '+
            '<i class="fa fa-question-circle tooltips" data-original-title="Masukan Pertanyaan" data-container="body"></i>'+
            '</label>'+
            '<div class="col-md-8">'+
            '<textarea class="form-control" placeholder="Enter Question here" name="category['+no+'][question]['+noCond+']" required></textarea>'+
            '</div>'+
            '<div class="col-md-1">'+
            '<a class="btn btn-danger btn" onclick="deleteCondition(`'+no+noCond+'`,`'+no+'`)">&nbsp;<i class="fa fa-trash"></i></a>'+
            '</div>'+
            '</div>'+
            '</div>'
		).appendTo($('#div-category'+no)).slideDown("slow")
		$('#btnAddCondition'+no).attr('onclick', 'changeSelect();addCondition('+no+','+noCond+')');
	}

    function deleteCondition(no, indexRule){
        if(no==indexRule+0){
            alert('This Question cant be deleted')
        }else{
            if(confirm('Are you sure you want to delete this question?')) {
                $('#category'+no).remove()
            }
        }
	}

    $(document).ready(function() {
        $(document).ready(function () {
            $('.colorpicker').minicolors({
                format: 'hex',
                theme: 'bootstrap'
            })
        });

        $('.summernote').summernote({
            placeholder: 'Brand Description',
            tabsize: 2,
            toolbar: [
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
            ],
            height: 120
        });
        $(".file").change(function(e) {
            var type      = $(this).data('jenis');
            var widthImg  = 0;
            var heightImg = 0;
            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (type == "logo_brand") {
                        if ($(".file").val().split('.').pop().toLowerCase() != 'png') {
                            toastr.warning("Please check type of your photo.");
                            $("#removeLogo").trigger( "click" );
                        }
                        if (this.width != 200 || this.height != 200) {
                            toastr.warning("Please check dimension of your photo.");
                            $("#removeLogo").trigger( "click" );
                        }
                    }
                    if (type == "image_brand") {
                        if (this.width != 750 || this.height != 375) {
                            toastr.warning("Please check dimension of your photo.");
                            $("#removeImage").trigger( "click" );
                        }
                    }
                };
                image.src = _URL.createObjectURL(file);
            }
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
                <span class="caption-subject font-dark sbold uppercase font-blue">Detail Form Survey</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('businessdev/form-survey/create/update') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group mt-repeater" style="margin-bottom: 0px; !important">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Brand
                                <span class="required" aria-required="true"> *
                                </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukan Kategori Pertanyaan" data-container="body"></i>
                            </label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" value="{{ $brand['name_brand'] }}" name="" placeholder="Enter Category here" required/>
                                <input type="hidden" name="id_brand" value="{{ $brand['id_brand'] }}">
                            </div>
                        </div>
                    </div>
                    <div id="div-rule">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($form_survey as $form)
                        <div class="rule{{ $i }}">
                            <div class="form-group mt-repeater">
                                <div data-repeater-item class="mt-repeater-item">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Category
                                            <i class="fa fa-question-circle tooltips" data-original-title="Masukan Pertanyaan" data-container="body"></i>
                                        </label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" value="{{ $form['category'] }}" name="category[{{ $i }}][cat]" placeholder="Enter Category here" required/>
                                        </div>
                                        <div>
                                            <a class="btn btn-danger btn" onclick="deleteRule({{ $i }})">Delete Category</a>
                                        </div>
                                    </div>
                                    <div class="mt-repeater">
                                        <div class="mt-repeater-cell">
                                            <div id="div-category{{ $i }}">
                                                @foreach ($form['question'] as $q => $question)
                                                <div id="category{{ $i }}{{ $q }}">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Question
                                                            <i class="fa fa-question-circle tooltips" data-original-title="Masukan Pertanyaan" data-container="body"></i>
                                                        </label>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control" placeholder="Enter Question here" name="category[{{ $i }}][question][{{ $q }}]" required>{{ $question }}</textarea>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <a class="btn btn-danger btn" onclick="deleteCondition('{{ $i }}{{ $q }}','{{ $i }}')">&nbsp;<i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="form-action col-md-12">
                                                <div class="col-md-3"></div>
                                                <div class="col-9">
                                                    <a id="btnAddCondition{{  $i }}" href="javascript:;" class="btn btn-info mt-repeater-add" onClick="changeSelect();addCondition({{ $i }}, {{ $q }})">
                                                        <i class="fa fa-plus"></i> Add New Question</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <a href="javascript:;" class="btn btn-success mt-repeater-add" onClick="addRule({{ $i }});changeSelect()">
                                <i class="fa fa-plus"></i> Add New Category</a>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection