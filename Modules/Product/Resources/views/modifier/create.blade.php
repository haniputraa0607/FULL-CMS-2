@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // event listener
            $('#type_dropdown').on('change',function(){
                if($(this).val() == '0'){
                    $('#type_textbox').removeAttr('disabled');
                    $('#type_textbox').removeClass('hidden');
                }else{
                    $('#type_textbox').attr('disabled','disabled');
                    $('#type_textbox').addClass('hidden');
                }
            });
            $('#modifier_type').on('change',function(){
                if($(this).val() == 'Specific'){
                    $('#specific-form select,#specific-form input').removeAttr('disabled');
                    $('#specific-form').removeClass('hidden');
                    $('#product_checkbox').change();
                    $('#category_checkbox').change();
                    $('#brand_checkbox').change();
                }else{
                    $('#specific-form select,#specific-form input').attr('disabled','disabled');
                    $('#specific-form').addClass('hidden');
                }
            });
            $('#specific-form').on('change','#product_checkbox',function(){
                if($('#product_checkbox:checked').length){
                    $('#product_value').removeAttr('disabled');
                }else{
                    $('#product_value').attr('disabled','disabled');
                }
            })
            $('#specific-form').on('change','#category_checkbox',function(){
                if($('#category_checkbox:checked').length){
                    $('#category_value').removeAttr('disabled');
                }else{
                    $('#category_value').attr('disabled','disabled');
                }
            })
            $('#specific-form').on('change','#brand_checkbox',function(){
                if($('#brand_checkbox:checked').length){
                    $('#brand_value').removeAttr('disabled');
                }else{
                    $('#brand_value').attr('disabled','disabled');
                }
            })
            // trigger change
            $('#type_dropdown').change();
            $('#modifier_type').change();
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
                <span class="caption-subject font-dark sbold uppercase font-blue">New Product Modifier</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('product/modifier') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Code
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode Product Modifier" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Product modifier code" class="form-control" name="code" value="{{ old('code') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama product modifier yang akan ditampilkan di aplikasi" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Product Modifier Name" class="form-control" name="text" value="{{ old('text') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Type
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jenis modifier, pilih Other Type jika ingin memasukkan tipe lain yang belum ada" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select class="form-control select2" name="type_dropdown" id="type_dropdown" data-placeholder="select type" required>
                                    <option value="0">Other Type</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Input type here" class="form-control" name="type_textbox" id="type_textbox" value="{{ old('type_textbox') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Scope
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih modifier ini akan tersedia dimana saja. Pilih global jika ingin tampil di semua produk" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select  class="form-control select2" name="modifier_type" id="modifier_type" data-placeholder="select scope" required>
                                    <option value="Global">Global</option>
                                    <option value="Specific">Specific</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="specific-form">
                        <div class="col-md-offset-3 col-md-2">
                            <div class="input-icon right">
                                <input type="checkbox" id="product_checkbox"/> <label for="product_checkbox"> Product</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-icon right form-group">
                                <select  class="form-control select2" multiple id="product_value" name="id_product[]" data-placeholder="select product" required>
                                    <option></option>
                                    @foreach($subject['products'] as $var)
                                    <option value="{{$var['id']}}">{{$var['text']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-offset-3 col-md-2">
                            <div class="input-icon right">
                                <input type="checkbox" id="category_checkbox"/> <label for="category_checkbox"> Category</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-icon right form-group">
                                <select  class="form-control select2" multiple id="category_value" name="id_product_category[]" data-placeholder="select product category" required>
                                    <option></option>
                                    @foreach($subject['product_categories'] as $var)
                                    <option value="{{$var['id']}}">{{$var['text']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-offset-3 col-md-2">
                            <div class="input-icon right">
                                <input type="checkbox" id="brand_checkbox"/> <label for="brand_checkbox"> Brand</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-icon right form-group">
                                <select  class="form-control select2" multiple id="brand_value" name="id_brand[]" data-placeholder="select brand" required>
                                    <option></option>
                                    @foreach($subject['brands'] as $var)
                                    <option value="{{$var['id']}}">{{$var['text']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection