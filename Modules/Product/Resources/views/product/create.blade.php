@extends('layouts.main')

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
    {{-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

        $('#select_tag').change(function(){
			var value = $(this).val();
            console.log(value)
            if(value !== null){
                value.forEach(function(tag_selected,i){
                    if(tag_selected == '+'){
                        $('.bootstrap-select').removeClass('open')
                        $('#m_modal_5').modal('show');
                        value.splice (i, 1);
                    }
                })
                $('#select_tag').val(value)
                $('#select_tag').selectpicker('refresh')
            }
		})

		$('#new_tag').click(function(){
			var tag_name = $('#tag_name').val();
			var token  = "{{ csrf_token() }}";
            var tag_selected = $('#select_tag').val()
            console.log(tag_selected)
			$.ajax({
                type : "POST",
                url : "{{ url('product/tag/create') }}",
                data : "_token="+token+"&tag_name="+tag_name+"&ajax=1",
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("New tag has been created.");
                        $('#option_new_tag').after(
							'<option value="'+result.result.id_tag+'">'+result.result.tag_name+'</option>'
						);
                        if(tag_selected !== null){
                            tag_selected.splice (0, 0, result.result.id_tag);
                            $('#select_tag').val(tag_selected)
                        }else{
                            $('#select_tag').val(result.result.id_tag)
                        }
						$('#select_tag').selectpicker('refresh');
                    }
                    else if(result.status == "fail"){
                        toastr.error(result.messages[0]);
                    }else{
                        toastr.warning('Failed to create tag.');
                    }
                    $('#m_modal_5').modal('hide');
                }
            });
		})
	$('#close_modal').click(function(){
        var value = $('#select_tag').val();
        value.splice (0, 0);
        $('#select_tag').val(value)
        $('#select_tag').selectpicker('refresh')
	})
    $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Product Description',
            tabsize: 2,
            height: 120,
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
            callbacks: {
                onImageUpload: function(files){
                    sendFile(files[0], $(this).attr('id'));
                },
                onMediaDelete: function(target){
                    var name = target[0].src;
                    token = "<?php echo csrf_token(); ?>";
                    $.ajax({
                        type: 'post',
                        data: 'filename='+name+'&_token='+token,
                        url: "{{url('summernote/picture/delete/product')}}",
                        success: function(data){
                            // console.log(data);
                        }
                    });
                }
            }
        });
    });


    function sendFile(file, id){
        token = "<?php echo csrf_token(); ?>";
        var data = new FormData();
        data.append('image', file);
        data.append('_token', token);
        // document.getElementById('loadingDiv').style.display = "inline";
        $.ajax({
            url : "{{url('summernote/picture/upload/product')}}",
            data: data,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(url) {
                if (url['status'] == "success") {
                    $('#'+id).summernote('editor.saveRange');
                    $('#'+id).summernote('editor.restoreRange');
                    $('#'+id).summernote('editor.focus');
                    $('#'+id).summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                }
                // document.getElementById('loadingDiv').style.display = "none";
            },
            error: function(data){
                // document.getElementById('loadingDiv').style.display = "none";
            }
        })
    }

    $(".file").change(function(e) {
        var widthImg  = 300;
        var heightImg = 300;

        var _URL = window.URL || window.webkitURL;
        var image, file;

        if ((file = this.files[0])) {
            image = new Image();

            image.onload = function() {
                if (this.width == widthImg && this.height == heightImg) {
                    // image.src = _URL.createObjectURL(file);
                }
                else {
                    toastr.warning("Please check dimension of your photo.");
                    $(this).val("");
                    // $('#remove_square').click()
                    // image.src = _URL.createObjectURL();

                    $('#fieldphoto').val("");
                    $('#imageproduct').children('img').attr('src', 'https://www.placehold.it/300x300/EFEFEF/AAAAAA&amp;text=no+image');
                    console.log($(this).val())
                }
            };

            image.src = _URL.createObjectURL(file);
        }

    });
    $(".filePhotoDetail").change(function(e) {
        var widthImg  = 720;
        var heightImg = 360;

        var _URL = window.URL || window.webkitURL;
        var image, file;

        if ((file = this.files[0])) {
            image = new Image();

            image.onload = function() {
                if (this.width == widthImg && this.height == heightImg) {
                    // image.src = _URL.createObjectURL(file);
                //    $('#formimage').submit()
                }
                else {
                    toastr.warning("Please check dimension of your photo.");
                    $('#imageproductDetail').children('img').attr('src', 'https://www.placehold.it/720x360/EFEFEF/AAAAAA&amp;text=no+image');
                    $('#filePhotoDetail').val("");

                }
            };

            image.src = _URL.createObjectURL(file);
        }

    });
    $('.price').each(function() {
        var input = $(this).val();
        var input = input.replace(/[\D\s\._\-]+/g, "");
        input = input ? parseInt( input, 10 ) : 0;

        $(this).val( function() {
            return ( input === 0 ) ? "" : input.toLocaleString( "id" );
        });
    });

    $( ".price" ).on( "keyup", numberFormat);
    function numberFormat(event){
        var selection = window.getSelection().toString();
        if ( selection !== '' ) {
            return;
        }

        if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
            return;
        }
        var $this = $( this );
        var input = $this.val();
        var input = input.replace(/[\D\s\._\-]+/g, "");
        input = input ? parseInt( input, 10 ) : 0;

        $this.val( function() {
            return ( input === 0 ) ? "" : input.toLocaleString( "id" );
        });
    }

    $( ".price" ).on( "blur", checkFormat);
    function checkFormat(event){
        var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
        if(!$.isNumeric(data)){
            $( this ).val("");
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
                <span class="caption-subject sbold uppercase font-blue">New Product</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
{{--                     <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Category <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih Kategori Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <select id="multiple" class="form-control select2-multiple" name="id_product_category" data-placeholder="select category" required>
                                <optgroup label="Category List">
                                    <option value="0">Uncategorize</option>
                                    @if (!empty($parent))
                                        @foreach($parent as $suw)
                                            <option value="{{ $suw['id_product_category'] }}">{{ $suw['product_category_name'] }}</option>
                                            @if (!empty($suw['child']))
                                                @foreach ($suw['child'] as $child)
                                                    <option value="{{ $child['id_product_category'] }}" data-ampas="{{ $child['product_category_name'] }}">&nbsp;&nbsp;&nbsp;{{ $child['product_category_name'] }}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                </optgroup>
                            </select>
                            </div>
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" placeholder="Product name" class="form-control" name="product_name" value="{{ old('product_name') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Code <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode Produk Bersifat Unik" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" class="form-control" name="product_code" value="{{ old('product_code') }}" placeholder="Product code" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Type <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jenis dari produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <select class="select2 form-control" name="product_type" data-placeholder="Select type" required>
                                <option></option>
                                <option value="product" @if(old('product_type') == 'product') selected="selected" @endif>Product</option>
                                <option value="service" @if(old('product_type') == 'service') selected="selected" @endif>Service</option>
                                <option value="academy" @if(old('product_type') == 'academy') selected="selected" @endif>Academy</option>
                            </select>
                        </div>
                    </div>
{{--                     <div class="form-group">
                        <label class="col-md-3 control-label">Global Price <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Global Price Product" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" class="form-control price" name="product_global_price" value="{{old('product_global_price')}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Visible
                            <i class="fa fa-question-circle tooltips" data-original-title="Setting apakah produk akan ditampilkan di aplikasi" data-container="body"></i>
                        </label>
                        <div class="input-icon right">
                            <div class="col-md-2">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio1" name="product_visibility" class="md-radiobtn req-type" value="Visible" required>
                                        <label for="radio1">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Visible</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio2" name="product_visibility" class="md-radiobtn req-type" value="Hidden" required>
                                        <label for="radio2">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Hidden </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Brand
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan brand untuk produk ini" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select class="select2 form-control" multiple="multiple" name="product_brands[]" required>
                                <option value="*">All Brand</option>
                                @foreach($brands as $brand)
                                <option value="{{$brand['id_brand']}}" @if(in_array($brand['id_brand'],old('product_brands',[]))) selected="selected" @endif>{{$brand['name_brand']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Photo <span class="required" aria-required="true">* <br>(300*300) </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                <img src="https://www.placehold.it/300x300/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="imageproduct" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" class="file" id="fieldphoto" accept="image/*" name="photo" required>
                                    </span>

                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Photo Detail<span class="required" aria-required="true">* <br>(720*360) </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar Produk Detail" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                <img src="@if(isset($syu['product_photo_detail'])){{$syu['product_photo_detail']}}@endif" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="imageproductDetail" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" class="filePhotoDetail" id="fieldphotodetail" accept="image/*" name="product_photo_detail">
                                    </span>

                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!--<div class="form-group">-->
                    <!--    <label class="col-md-3 control-label">Video-->
                    <!--        <br>-->
                    <!--        <span class="required" aria-required="true"> (from youtube) </span> -->
                    <!--        <i class="fa fa-question-circle tooltips" data-original-title="Video Tentang Produk" data-container="body"></i>-->
                    <!--    </label>-->
                    <!--    <div class="col-md-8">-->
                    <!--        <div class="input-icon right">-->
                    <!--            <input type="url" placeholder="Example: https://www.youtube.com/watch?v=u9_2wWSOQ" class="form-control" name="product_video" value="{{ old('product_video') }}">-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <!--<div class="form-group">-->
                    <!--    <label class="col-md-3 control-label">Weight-->
                    <!--        <br>-->
                    <!--        <span class="required" aria-required="true"> (gram) </span> -->
                    <!--        <i class="fa fa-question-circle tooltips" data-original-title="Berat Produk" data-container="body"></i>-->
                    <!--    </label>-->
                    <!--    <div class="col-md-8">-->
                    <!--        <div class="input-icon right">-->
                    <!--            <input type="number" placeholder="Product weight" class="form-control" name="product_weight" value="{{ old('product_weight') }}">-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->

{{--                     <div class="form-group">
                       <label for="multiple" class="control-label col-md-3">Description
                           <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
                       </label>
                       <div class="col-md-8">
                           <div class="input-icon right">
                               <textarea name="product_description" id="text_pro" class="form-control">{{ old('product_description') }}</textarea>
                           </div>
                       </div>
                    </div> --}}

                    <!--<div class="form-group">-->
                    <!--    <label for="multiple" class="control-label col-md-3">Tag-->
                    <!--        {{-- <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i> --}}-->
                    <!--    </label>-->
                    <!--    <div class="col-md-8">-->
                    <!--        <select name="id_tag[]" class="bs-select form-control" id="select_tag" multiple data-live-search="true" title="Select Tag">-->
                    <!--            <option id="option_new_tag" value="+" data-content="<span class='btn btn-info'><i class='fa fa-plus' style='color:#fff'></i> Add New Category</span>">-->
                    <!--                New Tag-->
                    <!--            </option>-->
                    <!--            @if (!empty($tags))-->
                    <!--                @foreach($tags as $tag)-->
                    <!--                    <option value="{{ $tag['id_tag'] }}">{{ $tag['tag_name'] }}</option>-->
                    <!--                @endforeach-->
                    <!--            @endif-->
                    <!--        </select>-->
                    <!--    </div>-->
                    <!--</div>-->

                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-8">
                            <input type="hidden" name="next" value="1">
                            <button type="submit" class="btn blue">Submit</button>
                            <!--<button type="submit" name="next" value="1" class="btn blue">Submit & Manage Photo</button>-->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--begin::Modal-->
	<div class="modal fade" id="m_modal_5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						New Tag
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="recipient-name" class="form-control-label">
								Tag Name:
							</label>
							<input type="text" class="form-control" id="tag_name">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-secondary" data-dismiss="modal" id="close_modal">
						Cancel
					</button>
					<button type="button" class="btn btn-primary" id="new_tag">
						Save
					</button>
				</div>
			</div>
		</div>
	</div>
<!--end::Modal-->
@endsection